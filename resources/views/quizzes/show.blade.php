<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} - EduQuest</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f7f7ff; color: #202044; }
        header { background: white; padding: 18px 5%; border-bottom: 1px solid #ecebf5; }
        .logo { color: #6558e8; text-decoration: none; font-size: 24px; font-weight: 800; }
        main { width: min(800px, 92%); margin: 30px auto; }
        .card { background: white; border: 1px solid #ecebf5; border-radius: 15px; padding: 22px; margin-bottom: 18px; }
        .muted { color: #70718c; line-height: 1.6; }
        .tag { background: #efedff; color: #5144cc; padding: 5px 9px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .timer { position: sticky; top: 0; z-index: 1; background: #202044; color: white; padding: 14px 18px; border-radius: 12px; margin: 18px 0; font-weight: bold; }
        .option { display: flex; gap: 10px; align-items: flex-start; border: 1px solid #e5e7eb; border-radius: 9px; padding: 12px; margin: 10px 0; cursor: pointer; }
        .option:hover { background: #f8f7ff; }
        .option input { margin-top: 4px; }
        .button { display: inline-block; padding: 12px 17px; border: 0; border-radius: 9px; background: #6558e8; color: white; font-weight: bold; text-decoration: none; cursor: pointer; }
        .alert { background: #fff4d8; color: #855500; padding: 12px; border-radius: 9px; }
        .actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    </style>
</head>
<body>
<header>
    <a href="{{ route('home') }}" class="logo">EduQuest.</a>
</header>

<main>
    @if (session('error'))
        <div class="alert">{{ session('error') }}</div>
    @endif

    <div class="card">
        <span class="tag">{{ $quiz->subject->name }} · Kelas {{ $quiz->grade }}</span>
        <h1>{{ $quiz->title }}</h1>
        <p class="muted">{{ $quiz->summary }}</p>
        <p class="muted">
            {{ $quiz->questions->count() }} soal · Durasi {{ $quiz->duration_minutes }} menit
        </p>
    </div>

    <div class="timer">
        Sisa waktu: <span id="timer">--:--</span>
    </div>

    <form id="quiz-form" method="POST" action="{{ route('quizzes.submit', $quiz->slug) }}">
        @csrf

        @foreach ($quiz->questions as $question)
            <section class="card">
                <h3>
                    Soal {{ $loop->iteration }}
                    <span class="muted">({{ $question->points }} poin)</span>
                </h3>

                <p>{{ $question->question_text }}</p>

                @foreach (['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d'] as $letter => $field)
                    <label class="option">
                        <input
                            type="radio"
                            name="answers[{{ $question->id }}]"
                            value="{{ $letter }}"
                        >
                        <span><strong>{{ $letter }}.</strong> {{ $question->$field }}</span>
                    </label>
                @endforeach
            </section>
        @endforeach

        <div class="card">
            <p class="muted">
                Periksa jawaban sebelum mengirim. Saat waktu habis, kuis akan dikirim otomatis.
            </p>

            <div class="actions">
                <button class="button" id="submit-button" type="submit">
                    Selesaikan Kuis
                </button>

                <a class="muted" href="{{ route('quizzes.index') }}"
                   onclick="return confirm('Keluar sekarang? Kuis belum akan dinilai sampai dikirim.')">
                    Kembali ke daftar kuis
                </a>
            </div>
        </div>
    </form>
</main>

<script>
    let remaining = {{ (int) $remainingSeconds }};
    const timer = document.getElementById('timer');
    const form = document.getElementById('quiz-form');
    let submitted = false;

    function updateTimer() {
        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;

        timer.textContent =
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');

        if (remaining <= 0) {
            if (!submitted) {
                submitted = true;
                timer.textContent = 'Waktu habis';
                form.submit();
            }
            return;
        }

        remaining--;
    }

    form.addEventListener('submit', function () {
        submitted = true;
        document.getElementById('submit-button').disabled = true;
    });

    updateTimer();
    const timerInterval = setInterval(function () {
        if (submitted) {
            clearInterval(timerInterval);
            return;
        }
        updateTimer();
    }, 1000);
</script>
</body>
</html>
