<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Hafidz Fahrudin',
                'email' => 'hafidz145@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'no_hp' => '081234567891',
                'alamat' => 'Ciparay, West Java',
            ],
            [
                'name' => 'Dimas Pratama',
                'email' => 'dimas@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
                'no_hp' => '082345678901',
                'alamat' => 't',
            ],
            [
                'name' => 'Handy Setiawan',
                'email' => 'Handy@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'peminjam',
                'no_hp' => '083456789012',
                'alamat' => 'Cibiru, Bandung',
            ],
            [
                'name' => 'Reginal Kencana',
                'email' => 'Reginal@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'peminjam',
                'no_hp' => '084567890123',
                'alamat' => 'Cikopo, Bandung',
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'Rizky@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'peminjam',
                'no_hp' => '085678901234',
                'alamat' => 'Cimahi, Bandung',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
