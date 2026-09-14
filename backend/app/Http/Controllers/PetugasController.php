<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function indexPeminjaman(Request $request)
    {
        $search = $request->input('search');

        $peminjamans = Peminjaman::with(['user', 'detailPinjams.alat'])
            ->where('status', 'diajukan')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    public function setujuiPeminjaman($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPinjams.alat')->findOrFail($id);

            if ($peminjaman->status !== 'diajukan') {
                throw new \Exception('Peminjaman ini sudah diproses.');
            }

            foreach ($peminjaman->detailPinjams as $detail) {
                $alat = $detail->alat;
                if ($alat->stok < $detail->jumlah) {
                    throw new \Exception("Stok alat {$alat->nama_alat} tidak mencukupi.");
                }
                $alat->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'dipinjam']);
            DB::commit();
            return redirect()->back()->with('success', 'Peminjaman disetujui dan stok alat dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function prosesPengembalian(Request $request, $peminjamanId)
    {
        $request->validate([
            'kondisi_kembali' => 'required|string',
            'denda' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPinjams.alat')->findOrFail($peminjamanId);

            if ($peminjaman->status !== 'dipinjam') {
                throw new \Exception('Hanya peminjaman berstatus dipinjam yang dapat dikembalikan.');
            }

            if ($peminjaman->pengembalian()->exists()) {
                throw new \Exception('Peminjaman ini sudah memiliki data pengembalian.');
            }
            
            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali' => now(),
                'kondisi_kembali' => $request->kondisi_kembali,
                'denda' => $request->denda ?? 0,
                'petugas_id' => auth()->id(),
            ]);

            $peminjaman->update(['status' => 'selesai']);

            foreach ($peminjaman->detailPinjams as $detail) {
                $detail->alat->increment('stok', $detail->jumlah);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Pengembalian berhasil dicatat dan stok dipulihkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    // Menolak Peminjaman (Menghapus pengajuan agar siswa bisa mengajukan ulang)
    public function tolakPeminjaman($id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);

            // Pastikan statusnya memang masih diajukan
            if ($peminjaman->status == 'diajukan') {
                $peminjaman->delete();
                return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil ditolak.');
            }

            return redirect()->back()->with('error', 'Status peminjaman sudah berubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexPengembalian(Request $request)
    {
        $search = $request->input('search');

        $peminjamans = Peminjaman::with([
            'user',
            'detailPinjams.alat',
            'pengembalian'
        ])
        ->where('status', 'dipinjam')
        ->when($search, function ($query, $search) {
            return $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->get();

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    public function indexLaporan(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $dariTanggal = $request->input('dari_tanggal');
        $sampaiTanggal = $request->input('sampai_tanggal');

        $peminjamans = Peminjaman::with(['user', 'pengembalian', 'detailPinjams.alat'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($dariTanggal, function ($query, $dariTanggal) {
                return $query->whereDate('tgl_pinjam', '>=', $dariTanggal);
            })
            ->when($sampaiTanggal, function ($query, $sampaiTanggal) {
                return $query->whereDate('tgl_pinjam', '<=', $sampaiTanggal);
            })
            ->latest()
            ->get();

        $ringkasan = [
            'total' => $peminjamans->count(),
            'diajukan' => $peminjamans->where('status', 'diajukan')->count(),
            'dipinjam' => $peminjamans->where('status', 'dipinjam')->count(),
            'selesai' => $peminjamans->where('status', 'selesai')->count(),
            'denda' => $peminjamans->sum(fn ($peminjaman) => $peminjaman->pengembalian?->denda ?? 0),
        ];

        return view('petugas.laporan.index', compact('peminjamans', 'ringkasan', 'search', 'status', 'dariTanggal', 'sampaiTanggal'));
    }
}