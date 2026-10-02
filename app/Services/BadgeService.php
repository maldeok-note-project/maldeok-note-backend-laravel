<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use \Illuminate\Database\Eloquent\Collection;

class BadgeService{

    // 全バッジ一覧を取得
    public function getAll(): Collection
    {
        return Badge::orderBy('condition')->get();
    }


    // 獲得したバッジ一覧
    public function getMyBadges(User $user)
    {
        return $user->userBadges()
            ->with('badge')
            ->orderBy('unlocked_at')
            ->get()
            ->map(fn($userBadge) => [
                'id' => $userBadge->badge->id,
                'name' => $userBadge->badge->name,
                'description' => $userBadge->badge->description,
                'condition' => $userBadge->badge->condition,
                'unlocked_at' => $userBadge->unlocked_at,
            ]);
    }


    // 解放されたバッジを付与
    public function checkAndUnlock(User $user): array
    {
        // 現在の登録数を取得
        $count = $user->expressions()->count();

        // 解放済みバッジID取得
        $unlockedId = $user->badges()->pluck('badges.id')->toArray();

        // 条件を満たしてるが、未開放のバッジ取得
        $newBadges = Badge::where('condition', '<=', $count)
            ->whereNotIn('id', $unlockedId)
            ->get();

        // 対象が無ければリターン
        if($newBadges->isEmpty()){
            return [];
        }

        // user_badges に INSERT（解放日時も記録）
        $now = now();
        foreach($newBadges as $badge){
            $user->badges()->attach($badge->id, [
                'unlocked_at' => $now,
            ]);
        }
        return $newBadges->toArray();
    }
}