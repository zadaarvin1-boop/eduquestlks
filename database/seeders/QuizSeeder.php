<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            'matematika' => Subject::where('slug', 'matematika')->firstOrFail(),
            'ipa' => Subject::where('slug', 'ipa')->firstOrFail(),
            'bahasa-inggris' => Subject::where('slug', 'bahasa-inggris')->firstOrFail(),
        ];

        $definitions = [
            [
                'subject_id' => $subjects['matematika']->id,
                'title' => 'Kuis Persamaan Linear Dua Variabel',
                'slug' => 'kuis-persamaan-linear-dua-variabel',
                'summary' => 'Latihan persamaan linear dua variabel dan SPLDV.',
                'grade' => '10',
                'duration_minutes' => 10,
                'questions' => [
                    ['Jika 2x + y = 10 dan x = 3, nilai y adalah ...', '2', '3', '4', '5', 'C', '2(3) + y = 10, jadi y = 4.'],
                    ['Manakah persamaan linear dua variabel?', 'x + y = 8', 'x² + y = 8', 'x³ = 8', 'xy = 8', 'A', 'Persamaan linear memiliki pangkat variabel tertinggi satu.'],
                    ['Jika x + y = 12 dan x = 7, nilai y adalah ...', '3', '4', '5', '6', 'C', 'y = 12 - 7 = 5.'],
                    ['Pada 3x + 2y = 15, angka 3 disebut ...', 'Variabel', 'Koefisien x', 'Konstanta', 'Eksponen', 'B', 'Angka yang mengalikan x disebut koefisien x.'],
                    ['Jika x + y = 9 dan x - y = 3, nilai x adalah ...', '3', '4', '5', '6', 'D', 'Jumlahkan kedua persamaan: 2x = 12, jadi x = 6.'],
                ],
            ],
            [
                'subject_id' => $subjects['ipa']->id,
                'title' => 'Kuis Sistem Pernapasan Manusia',
                'slug' => 'kuis-sistem-pernapasan-manusia',
                'summary' => 'Pelajari organ pernapasan dan proses pertukaran gas.',
                'grade' => '8',
                'duration_minutes' => 10,
                'questions' => [
                    ['Tempat utama pertukaran oksigen dan karbon dioksida adalah ...', 'Trakea', 'Alveolus', 'Laring', 'Faring', 'B', 'Pertukaran gas berlangsung di alveolus dan kapiler darah.'],
                    ['Gas yang dibutuhkan tubuh untuk respirasi adalah ...', 'Nitrogen', 'Karbon monoksida', 'Oksigen', 'Helium', 'C', 'Oksigen digunakan dalam respirasi sel.'],
                    ['Saluran yang menghubungkan laring dengan bronkus adalah ...', 'Trakea', 'Esofagus', 'Alveolus', 'Diafragma', 'A', 'Trakea bercabang menjadi dua bronkus.'],
                    ['Saat menarik napas, diafragma ...', 'Melengkung ke atas', 'Berhenti bergerak', 'Menutup trakea', 'Berkontraksi dan bergerak ke bawah', 'D', 'Kontraksi diafragma memperbesar rongga dada.'],
                    ['Salah satu gas sisa yang dikeluarkan saat mengembuskan napas adalah ...', 'Oksigen murni', 'Karbon dioksida', 'Hidrogen', 'Ozon', 'B', 'Karbon dioksida merupakan hasil sisa respirasi sel.'],
                ],
            ],
            [
                'subject_id' => $subjects['bahasa-inggris']->id,
                'title' => 'Kuis Simple Present Tense',
                'slug' => 'kuis-simple-present-tense',
                'summary' => 'Latihan simple present tense untuk kebiasaan dan fakta umum.',
                'grade' => '10',
                'duration_minutes' => 10,
                'questions' => [
                    ['Choose the correct sentence.', 'She go to school every day.', 'She goes to school every day.', 'She going to school every day.', 'She gone to school every day.', 'B', 'With she, he, or it, the verb generally takes -s or -es.'],
                    ['Which sentence expresses a daily habit?', 'I am sleeping now.', 'I slept yesterday.', 'I study every evening.', 'I will study tomorrow.', 'C', 'Every evening describes a routine.'],
                    ['Complete: They ___ football on Sundays.', 'plays', 'playing', 'played', 'play', 'D', 'Use the base verb with they.'],
                    ['Choose the correct negative sentence.', 'He do not like tea.', 'He does not like tea.', 'He does not likes tea.', 'He not like tea.', 'B', 'Use does not + base verb with he, she, or it.'],
                    ['Which phrase commonly indicates a routine?', 'Yesterday', 'Tomorrow', 'Every day', 'Right now', 'C', 'Every day indicates a repeated activity.'],
                ],
            ],
        ];

        foreach ($definitions as $definition) {
            $questions = $definition['questions'];
            unset($definition['questions']);

            $quiz = Quiz::updateOrCreate(
                ['slug' => $definition['slug']],
                [
                    'subject_id' => $definition['subject_id'],
                    'title' => $definition['title'],
                    'slug' => $definition['slug'],
                    'summary' => $definition['summary'],
                    'grade' => $definition['grade'],
                    'duration_minutes' => $definition['duration_minutes'],
                    'created_by' => null,
                    'is_published' => true,
                ]
            );

            foreach ($questions as $item) {
                Question::updateOrCreate(
                    [
                        'quiz_id' => $quiz->id,
                        'question_text' => $item[0],
                    ],
                    [
                        'option_a' => $item[1],
                        'option_b' => $item[2],
                        'option_c' => $item[3],
                        'option_d' => $item[4],
                        'correct_answer' => $item[5],
                        'explanation' => $item[6],
                        'points' => 1,
                    ]
                );
            }
        }

        $this->command?->info('QuizSeeder selesai: 3 kuis dan 15 soal tersedia.');
    }
}
