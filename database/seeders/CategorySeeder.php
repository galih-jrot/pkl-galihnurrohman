<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Keripik & Snack Kentang',
                'slug' => 'keripik-snack-kentang',
                'description' => 'Koleksi keripik dan snack kentang dengan berbagai rasa',
                'image' => 'galih.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Kacang & Biji-bijian',
                'slug' => 'kacang-biji-bijian',
                'description' => 'Berbagai jenis kacang dan biji-bijian yang gurih',
                'image' => 'jarot.png',
                'is_active' => true,
            ],
            [
                'name' => 'Permen & Jelly',
                'slug' => 'permen-jelly',
                'description' => 'Permen dan jelly dengan berbagai rasa untuk semua umur',
                'image' => 'galih.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Camilan Tradisional',
                'slug' => 'camilan-tradisional',
                'description' => 'Camilan tradisional Indonesia yang lezat',
                'image' => 'jarot.png',
                'is_active' => true,
            ],
             [
                'name' => 'minuman khas daerah',
                'slug' => 'minuman-tradisional',
                'description' => 'minuman tradisional Indonesia yang lezat',
                'image' => 'jarot.png',
                'is_active' => true,
            ],
            [
                'name' => 'makanan ringan Tradisional',
                'slug' => 'makanan-ringan-tradisional',
                'description' => 'makanan ringan tradisional Indonesia yang lezat',
                'image' => 'jarot.png',
                'is_active' => true,
            ],
            [
                'name' => 'Roti & Kue',
                'slug' => 'roti-kue',
                'description' => 'Roti dan kue lezat untuk camilan',
                'image' => 'galih.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Minuman Segar',
                'slug' => 'minuman-segar',
                'description' => 'Minuman segar dan menyegarkan',
                'image' => 'jarot.png',
                'is_active' => true,
            ],





        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        $this->command->info('Berhasil membuat ' . count($categories) . ' kategori sample.');
    }
}
