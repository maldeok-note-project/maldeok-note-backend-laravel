<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // 表を作る処理
    public function up(): void
    {
        Schema::create('revoked_tokens', function (Blueprint $table) {
            $table->id(); // 通し番号(主キー)

            // ログアウト済みJWT。毎回検索されるので、重複禁止(unique)で索引もつける
            $table->string('token', 512)->unique();

            // JWTの有効期限(AuthControllerが 'Y-m-d H:i:s' の形式で保存している)
            $table->dateTime('expires_at');

            // created_at / updated_at(モデルが標準設定なので必要)
            $table->timestamps();
        });
    }

    // 表を消す処理(migrate:rollback用)
    public function down(): void
    {
        Schema::dropIfExists('revoked_tokens');
    }
};