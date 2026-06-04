<?php

namespace App\Services;

use App\Models\Expression;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;


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
    public function getAll(User $user, ?string $search = null): LengthAwarePaginator
    {
        // クエリ作成
        $query = $user->expressions()
        ->with('speakerCategory') //カテゴリ取得
        ->latest(); // 新しい順

        // searchがあれば絞り込み
        if($search !== null){
            $query->where(function ($q) use ($search){
                $q->where('prase', 'like', "%{$search}%")
                ->orWhere('meaning', 'like', "%{$search}%");
            });
        }

        // 1ページの件数
        return $query->paginate(20);
    }


    // 表現詳細
    public function show(User $user, int $id): Expression
    {
        // 自分の表現だけ
        return $user->expressions()
        ->with('speakerCategory') // カテゴリも取得
        ->findOrFail($id); // 見つからなければエラー
    }


    // 表現編集
    public function update(User $user, int $id, array $data): Expression
    {
        // 所有権確認
        $expression = $user->expressions()->findOrFail($id);

        // 変更部分があれば、カテゴリ所有権確認
        if(isset($data['speaker_category_id'])){
            // 自分のカテゴリのみ更新可
            $exists = $user->speakerCategories()
            ->where('id', $data['speaker_category_id'])
            ->exists();

            // 自分以外はエラー
            if(!$exists){
                throw new \DomainException('指定されたカテゴリは使用できません。');
            }
        }

        // 更新
        $expression->update($data);
        return $expression->load('speakerCategory');
    }


    // 表現削除
    public function delete(User $user, int $id): Expression
    {
        // ユーザー所有の、未削除の表現を取得
        $expression = $user->expressions()->findOrFail($id);

        // 論理削除を実行
        $expression->delete();

        // 削除した表現を返す
        return $expression;
    }


    // お気に入り
    public function toggleFavorite(User $user, int $id): Expression
    {
        // 自分の表現だけ取得(無ければ404)
        $expression = $user->expressions()->findOrFail($id);

        // is_favorite を反転して保存(お気に入り前)
        $expression->update([
            'is_favorite' => !$expression->is_favorite,
        ]);

        // カテゴリ含めレスポンス
        return $expression->load('speakerCategory');
    }
}