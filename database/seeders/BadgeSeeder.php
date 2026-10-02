<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name'        => '입덕',
                'description' => '表現を1個登録した',
                'condition'   => 1,
            ],
            [
                'name'        => '찐팬 予備軍',
                'description' => '表現を10個登録した',
                'condition'   => 10,
            ],
            [
                'name'        => '현장러',
                'description' => '表現を30個登録した',
                'condition'   => 30,
            ],
            [
                'name'        => '고인물',
                'description' => '表現を50個登録した',
                'condition'   => 50,
            ],
            [
                'name'        => '진짜 말덕',
                'description' => '表現を100個登録した',
                'condition'   => 100,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
