<?php

namespace App\Services;

// import
use App\Models\SpeakerCategory;
use App\Models\User;
use Ramsey\Collection\Collection;

// ontrollerから呼び出され、DB操作や業務ルールの処理を行う
class SpeakerCategoryService{
    // 新しい話者カテゴリを作成
    public function create(User $user, string $name): SpeakerCategory
    {
        // 重複確認
        $exists = SpeakerCategory::where('user_id', $user->id)
        ->where('name', $name)
        ->exists();

        // 重複があった場合エラー
        if($exists){
            throw new \DomainException('このカテゴリは登録されています。');
        }

        // カテゴリ新規作成
        // User経由で作成することで、user_idが自動でセット
        return $user->speakerCategories()->create([
            'name' => $name,
        ]);
    }


    // カテゴリ一覧取得
    // Collection: ララベル専用配列
    public function list(User $user): Collection
    {
        // ユーザーのカテゴリを新規順で取得
        // User経由で自動的にuser_idに絞り込む
        return $user->speakerCategories()
        // oderBy: 並び替え
        // desc: 降順
        ->orderBy('created_at', 'desc')
        ->get();    
    }
}