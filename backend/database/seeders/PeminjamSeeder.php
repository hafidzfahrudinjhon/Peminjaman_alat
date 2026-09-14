<?php

namespace Database\Seeders;

use App\Models\Peminjam;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PeminjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peminjam = [
            [
                'user_id' => 3, 
                'tgl_pinjam' => '2026-06-04',   
                'tgl_kembali_plan' => '2026-06-10',
                'status' => 'dikembalikan'
            ],
            [
                'user_id' => 4, 
                'tgl_pinjam' => '2026-06-05',   
                'tgl_kembali_plan' => '2026-06-15',
                'status' => 'dikembalikan'
            ],
            [
                'user_id' => 5, 
                'tgl_pinjam' => '2026-06-10',   
                'tgl_kembali_plan' => '2026-06-20',
                'status' => 'telat'
            ],
            [
                'user_id' => 3, 
                'tgl_pinjam' => '2026-06-15',   
                'tgl_kembali_plan' => '2026-06-25',
                'status' => 'dipinjam'
            ],
            [
                'user_id' => 4, 
                'tgl_pinjam' => '2026-06-20',   
                'tgl_kembali_plan' => '2026-06-30',
                'status' => 'diajukan'
            ]
        ];

        foreach ($peminjam as $item) {
            Peminjam::create($item);
        }
    }
}
