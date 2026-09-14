@extends('layouts.app')

@section('title', 'Pengembalian Barang - Panel Peminjam')
@section('header-title', 'Pengembalian Barang')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Daftar Barang yang Sedang Dipinjam</h3>
                <p class="text-sm text-gray-500 mt-1">Pilih peminjaman yang akan dikembalikan.</p>
            </div>
            <a href="{{ route('peminjam.katalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Kembali ke Katalog
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        @forelse($peminjamans as $peminjaman)
            <div class="border border-gray-200 rounded-lg mb-4 overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                    <div>
                        <p class="font-semibold text-gray-800">Peminjaman #{{ $peminjaman->id }}</p>
                        <p class="text-sm text-gray-500">Tanggal pinjam: {{ $peminjaman->tgl_pinjam->format('d-m-Y') }} | Rencana kembali: {{ $peminjaman->tgl_kembali_plan->format('d-m-Y') }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        {{ ucfirst($peminjaman->status) }}
                    </span>
                </div>

                <div class="p-4">
                    <ul class="space-y-2 mb-4">
                        @foreach($peminjaman->detailPinjams as $detail)
                            <li class="flex justify-between items-center text-sm text-gray-700">
                                <span>{{ $detail->alat->nama_alat ?? '-' }}</span>
                                <span class="font-medium">{{ $detail->jumlah }} unit</span>
                            </li>
                        @endforeach
                    </ul>

                    <form action="{{ route('peminjam.peminjaman.kembali', $peminjaman->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Barang Saat Dikembalikan</label>
                            <input type="text" name="kondisi_kembali" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Baik, ada sedikit lecet" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Denda (opsional)</label>
                            <input type="number" name="denda" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0">
                        </div>

                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Konfirmasi Pengembalian
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-gray-500">
                Tidak ada barang yang sedang dipinjam saat ini.
            </div>
        @endforelse
    </div>
</div>
@endsection
