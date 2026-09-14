<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Jalankan seed data kategori ke database.
     */
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Jaringan & Konektivitas'],
            ['nama_kategori' => 'Multimedia & Audio Visual'],
            ['nama_kategori' => 'Perangkat Pemrosesan'],
            ['nama_kategori' => 'Perkakas & Elektronik'],
            ['nama_kategori' => 'Suku Cadang & Aksesoris'],
        ];

        foreach ($kategori as $kat) {
            Kategori::create($kat);
        }
    }
}
