@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - Panel Peminjam')
@section('header-title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Riwayat Peminjaman Saya</h3>
                <p class="text-sm text-gray-500 mt-1">Daftar pengajuan dan status peminjaman alat.</p>
            </div>
            <a href="{{ route('peminjam.katalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                + Buat Peminjaman
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">#</th>
                        <th class="py-3 px-4 border-b">Tanggal Pinjam</th>
                        <th class="py-3 px-4 border-b">Tanggal Kembali</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">Detail Alat</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($peminjamans as $index => $peminjaman)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 border-b">{{ $peminjaman->tgl_pinjam->format('d-m-Y') }}</td>
                            <td class="py-3 px-4 border-b">{{ $peminjaman->tgl_kembali_plan->format('d-m-Y') }}</td>
                            <td class="py-3 px-4 border-b">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($peminjaman->status === 'diajukan') bg-yellow-100 text-yellow-800
                                    @elseif($peminjaman->status === 'dipinjam') bg-blue-100 text-blue-800
                                    @elseif($peminjaman->status === 'dikembalikan' || $peminjaman->status === 'selesai') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-b">
                                <ul class="list-disc pl-4 space-y-1">
                                    @foreach($peminjaman->detailPinjams as $detail)
                                        <li>
                                            {{ $detail->alat->nama_alat ?? '-' }}
                                            <span class="text-gray-500">({{ $detail->jumlah }} unit)</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500">
                                Belum ada riwayat peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
