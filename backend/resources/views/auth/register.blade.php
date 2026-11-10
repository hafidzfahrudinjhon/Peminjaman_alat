<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem Peminjaman Alat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-8">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Buat Akun Peminjam</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="255" autocomplete="name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="no_hp" class="block text-gray-700 text-sm font-semibold mb-2">Nomor HP (opsional)</label>
                <input id="no_hp" type="tel" name="no_hp" value="{{ old('no_hp') }}" maxlength="15" autocomplete="tel"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="alamat" class="block text-gray-700 text-sm font-semibold mb-2">Alamat (opsional)</label>
                <textarea id="alamat" name="alamat" maxlength="255" rows="2" autocomplete="street-address"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter.</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8" autocomplete="new-password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Daftar
            </button>
        </form>

        <p class="mt-5 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Masuk</a>
        </p>
    </div>
</body>
</html>
