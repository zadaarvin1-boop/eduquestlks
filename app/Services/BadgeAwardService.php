<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\MaterialCompletion;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BadgeAwardService
{
    public function check(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user = User::query()
                ->whereKey($user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $completedQuizzes = QuizAttempt::query()
                ->where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->distinct('quiz_id')
                ->count('quiz_id');

            $completedMaterials = MaterialCompletion::query()
                ->where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->count();

            $hasPerfectScore = QuizAttempt::query()
                ->where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->whereColumn('score', 'total_points')
                ->where('total_points', '>', 0)
                ->exists();

            $earned = [];

            if ($completedQuizzes >= 1) {
                $earned[] = 'langkah-pertama';
            }

            if ($completedMaterials >= 5) {
                $earned[] = 'penjelajah-ilmu';
            }

            if ($completedQuizzes >= 10) {
                $earned[] = 'pakar-kuis';
            }

            if ($hasPerfectScore) {
                $earned[] = 'nilai-sempurna';
            }

            foreach ($earned as $slug) {
                $badge = Badge::where('slug', $slug)->first();

                if ($badge) {
                    DB::table('user_badges')->insertOrIgnore([
                        'user_id' => $user->id,
                        'badge_id' => $badge->id,
                        'earned_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $otherBadgeCount = DB::table('user_badges')
                ->join('badges', 'badges.id', '=', 'user_badges.badge_id')
                ->where('user_badges.user_id', $user->id)
                ->whereIn('badges.slug', [
                    'langkah-pertama',
                    'penjelajah-ilmu',
                    'pakar-kuis',
                    'nilai-sempurna',
                ])
                ->count();

            if ($otherBadgeCount >= 4) {
                $badge = Badge::where('slug', 'kolektor-lencana')->first();

                if ($badge) {
                    DB::table('user_badges')->insertOrIgnore([
                        'user_id' => $user->id,
                        'badge_id' => $badge->id,
                        'earned_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}
