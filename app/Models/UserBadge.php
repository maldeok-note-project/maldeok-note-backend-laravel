<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBadge extends Model
{
    protected $fillable = [
        'user_id',
        'badge_id',
        'unlocked_at',
    ];


    // 日時カラム指定
    protected $casts = [
        'unlocked_at' => 'datetime',
    ];

    // どのユーザーが取得したか
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // 取得バッジ
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }
}
