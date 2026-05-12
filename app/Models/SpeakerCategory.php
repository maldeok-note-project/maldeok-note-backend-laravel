<?php

namespace App\Models;

// import
use App\Models\User;
use App\Models\Expression;
use Illuminate\Database\Eloquent\Model;

class SpeakerCategory extends Model
{
    // カテゴリを作成したユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // カテゴリに属する表現一覧
    public function expressions()
    {
        return $this->hasMany(Expression::class);
    }
}
