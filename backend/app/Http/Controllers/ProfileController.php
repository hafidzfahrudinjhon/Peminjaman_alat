<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', ['user' => request()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'current_password' => ['required_with:password', 'current_password'],
            'password' => ['nullable', 'string', Password::min(8), 'confirmed'],
        ]);

        unset($data['current_password']);
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $oldPhoto = $user->foto_profil;
        if ($request->hasFile('foto_profil')) {
            $photoPath = $request->file('foto_profil')->store('profiles', 'public');
            if ($photoPath === false) {
                throw new \RuntimeException('Foto profil gagal disimpan.');
            }
            $data['foto_profil'] = $photoPath;
        }

        $user->fill($data)->save();

        if (isset($data['foto_profil']) && $oldPhoto) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
