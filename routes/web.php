<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\TeacherMaterialController;
use App\Http\Controllers\TeacherQuizController;
use App\Http\Controllers\TeacherQuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\MaterialCompletionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AchievementController;

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/achievements', [AchievementController::class, 'index'])
        ->name('achievements.index');
});

Route::get('/materi', [MaterialController::class, 'index'])
    ->name('materials.index');

Route::get('/materi/{slug}', [MaterialController::class, 'show'])
    ->name('materials.show');


Route::middleware(['auth', 'role:teacher,admin'])
    ->prefix('guru')
    ->name('teacher.')
    ->group(function () {
        Route::get('/materi', [
            TeacherMaterialController::class,
            'index',
        ])->name('materials.index');

        Route::get('/materi/tambah', [
            TeacherMaterialController::class,
            'create',
        ])->name('materials.create');

        Route::post('/materi', [
            TeacherMaterialController::class,
            'store',
        ])->name('materials.store');

        Route::get('/materi/{material}/edit', [
            TeacherMaterialController::class,
            'edit',
        ])->name('materials.edit');

        Route::put('/materi/{material}', [
            TeacherMaterialController::class,
            'update',
        ])->name('materials.update');

        Route::delete('/materi/{material}', [
            TeacherMaterialController::class,
            'destroy',
        ])->name('materials.destroy');
    });


Route::middleware(['auth', 'role:teacher,admin'])
    ->prefix('guru')
    ->name('teacher.')
    ->group(function () {
        Route::get('/kuis', [TeacherQuizController::class, 'index'])
            ->name('quizzes.index');

        Route::get('/kuis/tambah', [TeacherQuizController::class, 'create'])
            ->name('quizzes.create');

        Route::post('/kuis', [TeacherQuizController::class, 'store'])
            ->name('quizzes.store');

        Route::get('/kuis/{quiz}/edit', [TeacherQuizController::class, 'edit'])
            ->name('quizzes.edit');

        Route::put('/kuis/{quiz}', [TeacherQuizController::class, 'update'])
            ->name('quizzes.update');

        Route::delete('/kuis/{quiz}', [TeacherQuizController::class, 'destroy'])
            ->name('quizzes.destroy');

        Route::prefix('kuis/{quiz}/soal')
            ->name('quizzes.questions.')
            ->group(function () {
                Route::get('/', [TeacherQuestionController::class, 'index'])
                    ->name('index');

                Route::get('/tambah', [TeacherQuestionController::class, 'create'])
                    ->name('create');

                Route::post('/', [TeacherQuestionController::class, 'store'])
                    ->name('store');

                Route::get('/{question}/edit', [TeacherQuestionController::class, 'edit'])
                    ->name('edit');

                Route::put('/{question}', [TeacherQuestionController::class, 'update'])
                    ->name('update');

                Route::delete('/{question}', [TeacherQuestionController::class, 'destroy'])
                    ->name('destroy');
            });
    });


Route::get('/kuis', [QuizController::class, 'index'])
    ->name('quizzes.index');

Route::get('/kuis/{slug}', [QuizController::class, 'show'])
    ->name('quizzes.show');

Route::post('/kuis/{slug}/submit', [QuizController::class, 'submit'])
    ->name('quizzes.submit');

Route::get('/kuis/{slug}/hasil', [QuizController::class, 'result'])
    ->name('quizzes.result');

Route::post(
    '/materi/{material:slug}/selesai',
    [MaterialCompletionController::class, 'store']
)->middleware('auth')->name('materials.complete');
