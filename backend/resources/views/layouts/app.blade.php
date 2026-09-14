<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <!-- Memuat Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white flex flex-col">
            @if(auth()->user()->role == 'admin')
                <div class="p-5 text-xl font-bold tracking-wider border-b border-gray-800">
                PANEL ADMIN
            </div>
            <div class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-800 text-white font-medium">Dashboard</a>
                <a href="{{ route('admin.alat.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">Kelola Alat</a>
                <a href="{{ route('admin.user.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">Kelola User</a>
                <a href="{{ route('admin.kategori.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">Kelola Kategori</a>
                <a href="{{ route('admin.peminjaman.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-800 text-gray-400 hover:text-white transition">Kelola Peminjaman</a>
                <a href="{{ route('admin.pengembalian.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.pengembalian*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition">Kelola Pengembalian</a>
            </div>
            <div class="p-4 border-t border-gray-800 text-sm text-gray-400">
                Logged in as: <span class="text-white font-semibold">{{ auth()->user()->name }}</span>
            </div>
            @endif

            @if(auth()->user()->role == 'petugas')
             <div class="p-5 text-xl font-bold tracking-wider border-b border-gray-800">
                PANEL PETUGAS
            </div>
            <div class="flex-1 p-4 space-y-2">
                <a href="{{ route('petugas.peminjaman.index') }}"
                class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('petugas.peminjaman*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                Persetujuan Peminjaman</a>

                <a href="{{ route('petugas.pengembalian.index') }}"
                class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('petugas.pengembalian*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                Pemantauan Pengembalian</a>

                <a href="{{ route('petugas.laporan.index') }}"
                class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('petugas.laporan*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                Cetak Laporan</a>
            </div>
            @endif

            @if(auth()->user()->role == 'peminjam')
            <div class="p-5 text-xl font-bold tracking-wider border-b border-gray-800">
                PANEL PEMINJAM
            </div>
            <div class="flex-1 p-4 space-y-2">
                <a href="{{ route('peminjam.katalog') }}"
                class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('peminjam.katalog') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                Katalog Alat</a>

                <a href="{{ route('peminjam.kembali') }}"
                class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('peminjam.kembali') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                Pengembalian Barang</a>

                <a href="{{ route('peminjam.riwayat') }}"
                class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('peminjam.riwayat') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                Riwayat Peminjaman</a>

                <a href="#"
                class="block px-4 py-2 rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                Profil</a>
            </div>
            <div class="p-4 border-t border-gray-800 text-sm text-gray-400">
                Logged in as: <span class="text-white font-semibold">{{ auth()->user()->name }}</span>
            </div>
            @endif
            
        </div>

        <!-- Main Content Container -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Navbar Atas -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
                <div class="text-lg font-semibold text-gray-800">
                    @yield('header-title', 'Dashboard')
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Logout
                    </button>
                </form>
            </header>

            <!-- Konten Utama Halaman -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>
    </div>


</body>
</html>