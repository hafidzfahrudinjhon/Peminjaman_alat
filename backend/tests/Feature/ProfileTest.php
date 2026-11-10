<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_panel_can_open_the_shared_profile_page(): void
    {
        foreach (['admin', 'petugas', 'peminjam'] as $role) {
            $user = User::create([
                'name' => ucfirst($role),
                'email' => "{$role}@example.com",
                'password' => 'password123',
                'role' => $role,
            ]);

            $this->actingAs($user)
                ->get(route('profile.edit'))
                ->assertOk()
                ->assertSee('Profil Saya');
        }
    }

    public function test_user_can_update_profile_without_changing_their_role_or_password(): void
    {
        $user = User::create([
            'name' => 'Nama Lama',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'petugas',
        ]);
        $originalPassword = $user->password;

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Nama Baru',
                'email' => 'baru@example.com',
                'no_hp' => '081234567890',
                'alamat' => 'Bandung',
                'role' => 'admin',
            ])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHas('success');

        $user->refresh();
        $this->assertSame('Nama Baru', $user->name);
        $this->assertSame('baru@example.com', $user->email);
        $this->assertSame('petugas', $user->role);
        $this->assertSame($originalPassword, $user->password);
    }

    public function test_password_change_requires_the_current_password(): void
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'peminjam',
        ]);

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->put(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'current_password' => 'incorrect-password',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('password123', $user->fresh()->password));
    }
}
