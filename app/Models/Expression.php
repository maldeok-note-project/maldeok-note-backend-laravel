<?php

namespace App\Models;

// import
use App\Models\User;
use App\Models\SpeakerCategory;
use Illuminate\Database\Eloquent\Model;

class Expression extends Model
{
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
