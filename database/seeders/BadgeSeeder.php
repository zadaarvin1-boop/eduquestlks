<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Langkah Pertama',
                'slug' => 'langkah-pertama',
                'description' => 'Selesaikan kuis pertamamu.',
                'icon' => 'award',
            ],
            [
                'name' => 'Penjelajah Ilmu',
                'slug' => 'penjelajah-ilmu',
                'description' => 'Selesaikan 5 materi pembelajaran.',
                'icon' => 'book-open',
            ],
            [
                'name' => 'Pakar Kuis',
                'slug' => 'pakar-kuis',
                'description' => 'Selesaikan 10 kuis.',
                'icon' => 'trophy',
            ],
            [
                'name' => 'Nilai Sempurna',
                'slug' => 'nilai-sempurna',
                'description' => 'Dapatkan nilai penuh dalam sebuah kuis.',
                'icon' => 'star',
            ],
            [
                'name' => 'Kolektor Lencana',
                'slug' => 'kolektor-lencana',
                'description' => 'Kumpulkan 4 lencana lainnya.',
                'icon' => 'crown',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['slug' => $badge['slug']],
                $badge
            );
        }
    }
}
