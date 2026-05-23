<?php

namespace App\Services;

use App\Models\Expression;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use LengthException;

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


    // 表現一覧
    public function getAll(User $user): LengthAwarePaginator
    {
        // 自分の表示だけ
        return $user->expressions()
        ->with('speakerCategory') // カテゴリも取得
        ->latest() // 新しい順
        ->paginate(20); // １ページ２０件
    }
}