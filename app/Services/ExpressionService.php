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
        // 自分のカテゴリか確認
        $exists = $user->speakerCategories()
        ->where('id', $data['speaker_category_id'])
        ->exists();

        // 自分以外はエラー
        if(!$exists){
            throw new \DomainException('指定されたカテゴリは使用できません。');
        }

        // User経由で作成
        return $user->expressions()->create($data);
    }
}