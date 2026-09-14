<?php

namespace Database\Seeders;

use App\Models\Alat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alat = [
            [
                'kategori_id' => 1,
                'nama_alat' => 'Router Mikrotik RB941-2nD',
                'stok' => 15,
                'status_kondisi' => 'Baik',
                'deskripsi' => 'Router nirkabel rumahan yang cocok untuk praktik jaringan dasar.',
                'gambar' => 'mikrotik_rb941-2nd.jpg'
            ],
            [
                'kategori_id' => 2,
                'nama_alat' => 'Kamera DSLR Canon EOS 3000D',
                'stok' => 10,
                'status_kondisi' => 'Baik',
                'deskripsi' => 'Kamera DSLR entry-level yang cocok untuk pemula dalam fotografi dan videografi.',
                'gambar' => 'canon_eos_3000d.jpg'
            ],
            [
                'kategori_id' => 3,
                'nama_alat' => 'Laptop Dell Inspiron 15',
                'stok' => 8,
                'status_kondisi' => 'Baik',
                'deskripsi' => 'Laptop serbaguna untuk pemrosesan data, pemrograman, dan tugas sehari-hari.',
                'gambar' => 'dell_inspiron_15.jpg'
            ],
            [
                'kategori_id' => 4,
                'nama_alat' => 'Multimeter Digital Fluke 117',
                'stok' => 12,
                'status_kondisi' => 'Baik',
                'deskripsi' => 'Alat ukur listrik yang akurat untuk mengukur tegangan, arus, dan resistansi.',
                'gambar' => 'fluke_117.jpg'
            ],
            [
                'kategori_id' => 5,
                'nama_alat' => 'Hard Disk Eksternal Seagate 2TB',
                'stok' => 20,
                'status_kondisi' => 'Baik',
                'deskripsi' => 'Media penyimpanan eksternal dengan kapasitas besar untuk backup data.',
                'gambar' => 'seagate_2tb.jpg'
            ]
        ];

        foreach ($alat as $item) {
            Alat::create($item);
        }
    }
}
