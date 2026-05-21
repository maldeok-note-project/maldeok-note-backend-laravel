<?php

namespace App\Services;

use App\Models\Expression;
use App\Models\User;


// Controllerから呼び出されて、DB操作・業務ルールの処理
class ExpressionService
{
    // 表現作成
    public function create(User $user, array $data): Expression
    {
        // 自分のID以外なら、findOrFailが自動で404を投げる
        $user->speakerCategories()->findOrFail($data['speaker_category_id']);

        // User経由で作成
        return $user->expressions()->create($data);
    }
}