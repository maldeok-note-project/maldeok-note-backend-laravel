<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpressionRequest;
use App\Http\Requests\UpdateExpressionRequest;
use App\Services\ExpressionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ExpressionController extends Controller
{
    // インスタンス保持
    private ExpressionService $service;

    // クラス作成時、自動呼出し
    public function __construct(ExpressionService $service)
    {
        // Laravelが自動でServiceを挿入
        $this->service = $service;
    }

    
    // 表現一覧
    public function index(Request $request)
    {
        // JWT認証/ログイン中ユーザー
        $user = $request->attributes->get('auth_user');
        $search = $request->query('search');

        // Service経由で一覧取得
        $expressions = $this->service->getAll($user, $search);

        // 成功レスポンス
        return response()->json($expressions);
    }


    // 表現作成
    public function store(StoreExpressionRequest $request): JsonResponse
    {
        // バリデーションデータ取得
        $validated = $request->validated();

        // JWT認証/ログイン中ユーザー
        $user = $request->attributes->get('auth_user');

        // Service経由で表現作成
        try{
            $expression = $this->service->create($user, $validated);
        } catch (\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }

        // 成功レスポンス
        return response()->json([
            'message' => '表現を登録しました。',
            'data' => $expression,
        ], 201);
    }


    // 表現詳細
    public function show(Request $request, int $id): JsonResponse
    {
        //JWT認証/ログイン中ユーザー
        $user = $request->attributes->get('auth_user');

        // Service経由で表現詳細取得
        // 自分以外エラー
        $expression = $this->service->show($user, $id);

        // 成功レスポンス
        return response()->json($expression);
    }


    // 表現編集
    public function update(UpdateExpressionRequest $request, int $id): JsonResponse
    {
        // バリデーションデータ取得
        $validated = $request->validated();

        // JWT認証/ログイン中ユーザー
        $user = $request->attributes->get('auth_user');

        // Service経由で表現更新
        try {
            $expression = $this->service->update($user, $id, $validated);
        } catch (\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }

        // 成功レスポンス
        return response()->json([
            'message' => '表現を更新しました。',
            'data' => $expression,
        ], 200);
    }


    // 表現削除
    public function destroy(Request $request, int $id): JsonResponse
    {
        // JWT認証/ログイン中ユーザー
        $user = $request->attributes->get('auth_user');

        // Service層で削除処理を実行
        $deletedExpression = $this->service->delete($user, $id);

        // 成功レスポンス
        return response()->json([
            'message' => '表現を削除しました。',
            'data' => $deletedExpression,
        ], 200);
    }


    // お気に入り
    public function toggleFavorite(Request $request, int $id): JsonResponse
    {
        // JWT認証/ログイン中ユーザー
        $user = $request->attributes->get('auth_user');

        // Server経由でトグル処理
        $expression = $this->service->toggleFavorite($user, $id);

        // 成功レスポンス
        return response()->json([
            'message' => 'お気に入りを更新しました。',
            'data' => $expression,
        ], 200);
    }
}
