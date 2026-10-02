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
        Schema::table('speaker_categories', function (Blueprint $table) {
            // speaker_categoriesテーブルにdeleted_atカラムを追加する
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('speaker_categories', function (Blueprint $table) {
            // deleted_atカラムを削除する
            $table->dropSoftDeletes();
        });
    }
};
