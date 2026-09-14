@extends('layouts.app')

@section('title', 'Katalog Alat - Panel Peminjam')
@section('header-title', 'Katalog Alat')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('peminjam.peminjaman.ajukan') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali Rencana</label>
                    <input type="date" name="tgl_kembali_plan" class="w-full md:max-w-xs border border-gray-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="w-full md:max-w-xl">
                    <form action="{{ route('peminjam.katalog') }}" method="GET" class="flex">
                        <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="🔎 Cari alat..." class="flex-1 border border-gray-300 rounded-l-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-r-xl font-medium">
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @forelse($alats as $alat)
                    <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-md transition">
                        <div class="bg-gray-100 p-3 flex items-center justify-between">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">READY</span>
                            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                                <input type="checkbox" name="alat_id[]" value="{{ $alat->id }}" class="h-4 w-4 text-blue-600 rounded border-gray-300">
                                <span>Pilih</span>
                            </label>
                        </div>

                        <div class="p-4">
                            <div class="w-full h-40 rounded-xl overflow-hidden bg-gray-100 mb-4">
                                @if($alat->gambar)
                                    <img src="{{ asset('images/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                        Gambar tidak tersedia
                                    </div>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $alat->nama_alat }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $alat->kategori->nama_kategori ?? '-' }}</p>

                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-gray-600">Stok:</span>
                                <span class="font-bold text-blue-600">{{ $alat->stok }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="number" name="jumlah[]" value="1" min="1" max="{{ $alat->stok }}" class="w-20 border border-gray-300 rounded-lg px-2 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="button" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">
                                    Pinjam
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-10 text-center text-gray-500">
                        Tidak ada alat yang tersedia saat ini.
                    </div>
                @endforelse
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                    Ajukan Peminjaman
                </button>
            </div>
        </div>
    </form>
</div>
@endsection