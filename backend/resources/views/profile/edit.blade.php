@extends('layouts.app')

@section('title', 'Profil Saya')
@section('header-title', 'Profil Saya')

@section('content')
<div class="max-w-3xl space-y-6">
    @if(session('success'))
        <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-4 pb-5 border-b border-gray-200">
            @if($user->foto_profil)
                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto profil {{ $user->name }}"
                    class="w-20 h-20 rounded-full object-cover border border-gray-200">
            @else
                <div class="w-20 h-20 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-2xl font-bold">
                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 capitalize">{{ $user->role }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required maxlength="255"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="255"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp', $user->no_hp) }}" maxlength="15"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="foto_profil" class="block text-sm font-medium text-gray-700 mb-1">Foto profil</label>
                <input id="foto_profil" name="foto_profil" type="file" accept=".jpg,.jpeg,.png"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
                <p class="mt-1 text-xs text-gray-500">Format JPG atau PNG, maksimal 2 MB.</p>
            </div>

            <div class="md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" maxlength="255"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $user->alamat) }}</textarea>
            </div>
        </div>

        <div class="pt-5 border-t border-gray-200 space-y-4">
            <div>
                <h3 class="font-semibold text-gray-800">Ubah password</h3>
                <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengganti password.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password saat ini</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password baru</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi password baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                Simpan perubahan
            </button>
        </div>
    </form>
</div>
@endsection
