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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // JWT認証/ログイン中ユーザー
        $user = $request->attributes->get('auth_user');

        // Service経由で一覧取得
        $expressions = $this->service->getAll($user);

        // 成功レスポンス
        return response()->json($expressions);
    }

    /**
     * 表現作成
     */
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
