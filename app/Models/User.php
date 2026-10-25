<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Badge;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'grade',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getLevelAttribute(): int
    {
        $xp = (int) ($this->attributes['xp'] ?? 0);

        return match (true) {
            $xp >= 1000 => 5,
            $xp >= 500 => 4,
            $xp >= 250 => 3,
            $xp >= 100 => 2,
            default => 1,
        };
    }

    public function getLevelTitleAttribute(): string
    {
        return match ($this->level) {
            1 => 'Pemula',
            2 => 'Penjelajah',
            3 => 'Pembelajar',
            4 => 'Cendekia',
            5 => 'Master',
        };
    }

    public function getXpProgressAttribute(): int
    {
        $xp = (int) ($this->attributes['xp'] ?? 0);

        if ($this->level === 5) {
            return 100;
        }

        $levels = [
            1 => [0, 100],
            2 => [100, 250],
            3 => [250, 500],
            4 => [500, 1000],
        ];

        [$start, $next] = $levels[$this->level];

        return (int) round(
            (($xp - $start) / ($next - $start)) * 100
        );
    }

    public function getXpToNextLevelAttribute(): int
    {
        $xp = (int) ($this->attributes['xp'] ?? 0);

        if ($this->level === 5) {
            return 0;
        }

        $thresholds = [
            1 => 100,
            2 => 250,
            3 => 500,
            4 => 1000,
        ];

        return $thresholds[$this->level] - $xp;
    }
    public function materialCompletions()
    {
        return $this->hasMany(\App\Models\MaterialCompletion::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(\App\Models\QuizAttempt::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class)
            ->withPivot('earned_at')
            ->withTimestamps();
    }
}
