<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class BadgeService{

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