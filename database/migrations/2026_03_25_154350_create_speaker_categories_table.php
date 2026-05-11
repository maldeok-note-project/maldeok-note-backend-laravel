<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('speaker_categories', function (Blueprint $table) {
            $table->id();

            // どのユーザーのカテゴリか
            $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

            // カテゴリ名(例: 友達、推し、先生 など)
            $table->string('name');

            $table->timestamps();

            // 同じユーザーが同じカテゴリ名を重複して作れないようにする
            $table->unique(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speaker_categories');
    }
};
