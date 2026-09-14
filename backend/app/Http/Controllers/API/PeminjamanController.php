<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Peminjaman\StorePeminjamanRequest;
use App\Http\Resources\PeminjamanResource;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\DetailPinjam;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Exception;

class PeminjamanController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();

        $query = Peminjaman::with([
            'user',
            'detailPinjam.alat',
            'pengembalian'
        ]);

        if ($user->role === 'peminjam') {
            $query->where('user_id', $user->id);
        }

        $peminjaman = $query->latest()->get();

        return response()->json([
            'message' => 'Daftar peminjaman berhasil diambil.',
            'data' => PeminjamanResource::collection($peminjaman)
        ]);
    }

    public function store(StorePeminjamanRequest $request): JsonResponse
    {
        try {
            $peminjaman = DB::transaction(function () use ($request) {

                $user = auth()->user();

                $peminjaman = Peminjaman::create([
                    'user_id' => $user->id,
                    'tgl_pinjam' => now()->toDateString(),
                    'tgl_kembali_plan' => $request->tgl_kembali_plan,
                    'status' => 'diajukan',
                ]);

                foreach ($request->items as $item) {

                    $alat = Alat::lockForUpdate()
                        ->findOrFail($item['alat_id']);

                    if ($alat->stok < $item['jumlah']) {
                        throw new Exception(
                            "Stok alat '{$alat->nama_alat}' tidak mencukupi. Sisa stok: {$alat->stok}"
                        );
                    }

                    DetailPinjam::create([
                        'peminjaman_id' => $peminjaman->id,
                        'alat_id' => $item['alat_id'],
                        'jumlah' => $item['jumlah'],
                    ]);
                }

                return $peminjaman->load([
                    'user',
                    'detailPinjam.alat'
                ]);
            });

            return response()->json([
                'message' => 'Peminjaman berhasil diajukan. Menunggu persetujuan petugas.',
                'data' => new PeminjamanResource($peminjaman)
            ], 201);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Peminjaman $peminjaman): JsonResponse
    {
        $peminjaman->load([
            'user',
            'detailPinjam.alat',
            'pengembalian'
        ]);

        return response()->json([
            'message' => 'Detail peminjaman berhasil diambil.',
            'data' => new PeminjamanResource($peminjaman)
        ]);
    }

    public function destroy(Peminjaman $peminjaman): JsonResponse
    {
        $user = auth()->user();

        if (
            $user->role === 'peminjam' &&
            $peminjaman->user_id !== $user->id
        ) {
            return response()->json([
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $peminjaman->delete();

        return response()->json([
            'message' => 'Peminjaman berhasil dihapus.'
        ]);
    }

    public function riwayat(): JsonResponse
    {
        $riwayat = Peminjaman::with([
            'detailPinjam.alat',
            'pengembalian'
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

        return response()->json([
            'message' => 'Riwayat peminjaman Anda.',
            'data' => PeminjamanResource::collection($riwayat)
        ]);
    }
}