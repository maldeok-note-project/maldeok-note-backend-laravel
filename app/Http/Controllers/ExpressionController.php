<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpressionRequest;
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
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
