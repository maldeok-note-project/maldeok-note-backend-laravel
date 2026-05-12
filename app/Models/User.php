<?php

namespace App\Models;

// import
use App\Models\Expression;
use App\Models\SpeakerCategories;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // 登録・更新を許可するカラム
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // APIのレスポンスに含めないカラム
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // カラムの型変換
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // ユーザーが登録した表現一覧
    public function expressions()
    {
        // Laravelが自動で「users.id ← expressions.user_id」を繋いでくれる
        return $this->hasMany(Expression::class);
    }


    // ユーザーが作成した話者カテゴリ一覧
    public function speakerCategories()
    {
        // 「users.id ← speaker_categories.user_id」で自動連結
        return $this->hasMany(SpeakerCategories::class);
    }
}
