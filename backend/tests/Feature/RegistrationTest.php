<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_registration_creates_and_signs_in_a_borrower(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Rina Peminjam',
            'email' => 'rina@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'no_hp' => '081234567890',
            'alamat' => 'Bandung',
            'role' => 'admin',
        ]);

        $user = User::where('email', 'rina@example.com')->firstOrFail();

        $response->assertRedirect(route('peminjam.katalog'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame('peminjam', $user->role);
        $this->assertTrue(password_verify('password123', $user->password));
    }

    public function test_api_registration_creates_a_borrower_and_returns_a_token(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Budi Peminjam',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.email', 'budi@example.com')
            ->assertJsonPath('data.role', 'peminjam')
            ->assertJsonPath('token_type', 'Bearer')
            ->assertJsonStructure(['access_token']);

        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'role' => 'peminjam',
        ]);
    }

    public function test_registration_rejects_duplicate_email_and_unconfirmed_password(): void
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'password' => 'password123',
        ]);

        $this->postJson('/api/register', [
            'name' => 'Another User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
