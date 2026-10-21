<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $math = Subject::updateOrCreate(
            ['slug' => 'matematika'],
            [
                'name' => 'Matematika',
                'description' => 'Materi matematika untuk siswa.',
            ]
        );

        $science = Subject::updateOrCreate(
            ['slug' => 'ipa'],
            [
                'name' => 'Ilmu Pengetahuan Alam',
                'description' => 'Materi ilmu pengetahuan alam.',
            ]
        );

        $english = Subject::updateOrCreate(
            ['slug' => 'bahasa-inggris'],
            [
                'name' => 'Bahasa Inggris',
                'description' => 'Materi bahasa Inggris untuk siswa.',
            ]
        );

        Material::updateOrCreate(
            ['slug' => 'persamaan-linear-dua-variabel'],
            [
                'subject_id' => $math->id,
                'created_by' => null,
                'grade' => '10',
                'title' => 'Persamaan Linear Dua Variabel',
                'summary' => 'Pengenalan persamaan linear dua variabel dan cara memahami bentuk persamaannya.',
                'content' => "Persamaan linear dua variabel adalah persamaan yang memuat dua variabel dengan pangkat tertinggi satu.\n\nContoh:\n2x + y = 10\n\nUntuk mempelajarinya, kenali terlebih dahulu variabel, koefisien, dan konstanta yang ada di dalam persamaan.",
                'is_published' => true,
            ]
        );

        Material::updateOrCreate(
            ['slug' => 'sistem-pernapasan-manusia'],
            [
                'subject_id' => $science->id,
                'created_by' => null,
                'grade' => '8',
                'title' => 'Sistem Pernapasan Manusia',
                'summary' => 'Mengenal organ utama sistem pernapasan dan fungsi dasarnya.',
                'content' => "Sistem pernapasan membantu tubuh mengambil oksigen dan mengeluarkan karbon dioksida.\n\nOrgan utamanya meliputi hidung, faring, laring, trakea, bronkus, dan paru-paru.\n\nUdara masuk melalui saluran pernapasan sampai ke bagian paru-paru tempat pertukaran gas berlangsung.",
                'is_published' => true,
            ]
        );

        Material::updateOrCreate(
            ['slug' => 'simple-present-tense'],
            [
                'subject_id' => $english->id,
                'created_by' => null,
                'grade' => '10',
                'title' => 'Simple Present Tense',
                'summary' => 'Memahami penggunaan Simple Present Tense untuk kebiasaan dan fakta umum.',
                'content' => "Simple Present Tense digunakan untuk menyatakan kebiasaan, rutinitas, dan fakta umum.\n\nContoh:\nI study every day.\nShe reads a book.\n\nUntuk subjek he, she, atau it, kata kerja umumnya mendapat akhiran -s atau -es pada kalimat positif.",
                'is_published' => true,
            ]
        );
    }
}
