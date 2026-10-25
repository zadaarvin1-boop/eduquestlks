<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = $request->user();

        // Jika belum login, arahkan ke halaman login
        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil semua lencana yang tersedia
        $badges = Badge::query()
            ->orderBy('id')
            ->get();

        // Ambil lencana yang sudah diperoleh pengguna
        $earnedBadges = $user->badges()
            ->get()
            ->keyBy('id');

        // Ambil ID lencana yang sudah diperoleh
        $earnedBadgeIds = $earnedBadges->keys()->all();

        // Hitung jumlah lencana dan progres
        $totalBadges = $badges->count();
        $totalEarned = $earnedBadges->count();

        $progress = $totalBadges > 0
            ? (int) round(($totalEarned / $totalBadges) * 100)
            : 0;

        // Tampilkan halaman pencapaian
        return view('achievements.index', compact(
            'user',
            'badges',
            'earnedBadges',
            'earnedBadgeIds',
            'totalBadges',
            'totalEarned',
            'progress'
        ));
    }
}
