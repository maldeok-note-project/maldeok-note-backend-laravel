<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevokedToken extends Model
{
    // 保存する項目のみ許可
    protected $fillable = [
        'token',
        'expires_at',
    ];
}
