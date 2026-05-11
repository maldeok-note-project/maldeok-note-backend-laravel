<?php

namespace App\Models;

// import
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
}
