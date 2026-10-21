<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('material_completions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('material_id')
                ->constrained('materials')
                ->cascadeOnDelete();

            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'material_id']);
        });
    }
};
