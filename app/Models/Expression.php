<?php

namespace App\Models;

// import
use App\Models\User;
use App\Models\SpeakerCategory;
use Illuminate\Database\Eloquent\Model;

class Expression extends Model
{
    // 登録を許可するカラム
    protected $fillable = [
        'user_id',
        'speaker_category_id',
        'phrase',
        'meaning',
        'memo',
        'speaker_name',
        'heard_at',
        'place',
        'is_favorite',
    ];

    // カラムの変換
    protected $casts = [
        'heard_at' => 'date',
        'is_favorite' => 'boolean',
    ];

    // この表現を登録したユーザー
    public function user()
    {
        // 「expressions.user_id → users.id」で自動連結
        return $this->belongsTo(User::class);
    }


    // この表現が属する話者カテゴリ
    public function speakerCategory()
    {
        // expressions.speaker_category_id → speaker_categories.id」で自動連結
        return $this->belongsTo(SpeakerCategory::class);
    }
}
