<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // マイグレーション実行時の処理 (テーブルにカラムを追加)
    public function up(): void
    {
        Schema::table('expressions', function (Blueprint $table) {
            // deleted_at カラム (TIMESTAMP NULL) を追加
            $table->softDeletes();
        });
    }

    
    // ロールバック時の処理 (カラムを削除して元に戻す)
    public function down(): void
    {
        Schema::table('expressions', function (Blueprint $table) {
            //deleted_at カラムを削除
            $table->softDeletes();
        });
    }
};
