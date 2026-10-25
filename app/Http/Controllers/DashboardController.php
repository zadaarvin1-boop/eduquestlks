<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\MaterialCompletion;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $materialsCompleted = MaterialCompletion::query()
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();

        $materialsLearned = $materialsCompleted;

        $quizzesCompleted = QuizAttempt::query()
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->distinct()
            ->count('quiz_id');

        $recentAttempts = QuizAttempt::query()
            ->with('quiz')
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at')
            ->limit(5)
            ->get();

        // Ambil semua lencana beserta waktu perolehannya oleh pengguna.
        $badges = Badge::query()
            ->with([
                'users' => function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                },
            ])
            ->get();

        $earnedBadgeIds = $badges
            ->filter(fn($badge) => $badge->users->isNotEmpty())
            ->pluck('id')
            ->all();

        return view('dashboard', compact(
            'user',
            'materialsCompleted',
            'materialsLearned',
            'quizzesCompleted',
            'recentAttempts',
            'badges',
            'earnedBadgeIds'
        ));
    }
}
