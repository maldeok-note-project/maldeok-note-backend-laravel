<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class BadgeController extends Controller
{
    public function __construct(
        private BadgeService $badgeService
    ){}


    // 全バッジ一覧
    public function index(): JsonResponse
    {
        $badges = $this->badgeService->getAll();
        return response()->json($badges);
    }


    // 取得バッジ一覧
    public function my(Request $request): JsonResponse
    {
        // // JWT認証/ログイン中ユーザー
        $user = $request->attributes->get('auth_user');

        // ユーザーが持っているバッジを確認
        $userBadges = $this->badgeService->getMyBadges($user);

        // 成功レスポンス
        return response()->json($userBadges);
    }
}