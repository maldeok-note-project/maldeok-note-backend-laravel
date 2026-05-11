<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevokedToken extends Model
{
    // 登録・更新を許可するカラム
    protected $fillable = [
        'token',
        'expires_at',
    ];
}
