<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();
            $table->string('icon')->default('award');
        });

        // Pertahankan data lama jika tabel sudah berisi baris.
        DB::table('badges')
            ->orderBy('id')
            ->get()
            ->each(function ($badge) {
                DB::table('badges')
                    ->where('id', $badge->id)
                    ->update([
                        'name' => 'Lencana ' . $badge->id,
                        'slug' => 'lencana-' . $badge->id,
                        'description' => 'Lencana pencapaian EduQuest.',
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'name',
                'slug',
                'description',
                'icon',
            ]);
        });
    }
};
