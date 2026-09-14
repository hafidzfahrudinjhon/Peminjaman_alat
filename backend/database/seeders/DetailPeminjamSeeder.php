<?php

namespace Database\Seeders;

use App\Models\DetailPeminjam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPeminjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = [
            ['peminjaman_id' => 1, 'alat_id' =>1, 'jumlah' => 2],
            ['peminjaman_id' => 2, 'alat_id' =>2, 'jumlah' => 1],
            ['peminjaman_id' => 3, 'alat_id' =>3, 'jumlah' => 3],
            ['peminjaman_id' => 4, 'alat_id' =>4, 'jumlah' => 1],
            ['peminjaman_id' => 5, 'alat_id' =>5, 'jumlah' => 2],
        ];

        foreach ($details as $detail) {
            DetailPeminjam::create($detail);
        }
    }
}
