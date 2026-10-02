<?php

// import
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
        Schema::create('expressions', function (Blueprint $table) {
            $table->id();

            // どのユーザーの表現か
            $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

            // どのカテゴリに属するか(削除制限つき)
            $table->foreignId('speaker_category_id')
            ->constrained()
            ->restrictOnDelete();

            // 表現本体
            $table->string('phrase');
            $table->string('meaning');
            $table->string('memo')->nullable();

            // 誰が言ったか
            $table->string('speaker_name');

            // いつ・どこで聞いたか
            $table->date('heard_at');
            $table->string('place')->nullable();

            // お気に入りフラグ
            $table->boolean('is_favorite')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expressions');
    }
};
