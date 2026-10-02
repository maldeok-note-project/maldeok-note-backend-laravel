<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpeakerCategoryRequest;
use App\Http\Requests\UpdateSpeakerCategoryRequest;
use App\Services\SpeakerCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


// 話者カテゴリController
class SpeakerCategoryController extends Controller
{
    // Servicesクラスのインスタンスを保持
    private SpeakerCategoryService $service;


    // クラス作成時に自動で呼ばれる
    public function __construct(SpeakerCategoryService $service)
    {
        // Laravelが自動でServiceを差し込む
        $this->service = $service;
    }


    // 新規作成
    public function store(StoreSpeakerCategoryRequest $request): JsonResponse
    {
        // バリデーション確認
        $validated = $request->validated();

        // JWT認証で取得した「ログイン中のユーザー」
        $user = $request->attributes->get('auth_user');

        try{
            // Service経由でカテゴリ作成
            $category = $this->service->create(
                $user,
                $validated['name']
            );
        // 重複時はDomainException
        }catch(\DomainException $e){
            return response()->json([
                'message' => $e->getMessage(),
            ], 409);
        }

        // 成功レスポンス
        return response()->json([
            'message' => 'カテゴリを作成しました。',
            'data' => $category,
        ], 201);
    }


    // カテゴリ一覧
    public function index(Request $request): JsonResponse
    {
        // JWT認証で取得した「ログイン中のユーザー」
        $user = $request->attributes->get('auth_user');

        // Service経由でカテゴリ取得
        $categories = $this->service->list($user);

        // 成功レスポンス
        return response()->json([
            'message' => 'カテゴリ一覧を取得しました。',
            'data' => $categories,
        ], 200);
    }


    // カテゴリ編集
    public function update(UpdateSpeakerCategoryRequest $request, int $id): JsonResponse
    {
        // バリデーション確認
        $validated = $request->validated();

        // JWT認証取得ログインユーザー
        $user = $request->attributes->get('auth_user');

        // Service経由でカテゴリ編集
        try{
            $category = $this->service->update(
                $user,
                $id,
                $validated['name']
            );
        // 重複時エラー
        } catch(\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 409);
        }

        // 成功レスポンス
        return response()->json([
            'message' => 'カテゴリを更新しました。',
        ], 200);
    }


    // カテゴリ削除
    public function destroy(Request $request, int $id): JsonResponse
    {
        // JWT認証取得ログインユーザー
        $user = $request->attributes->get('auth_user');

        // Serviceに受け渡す
        try{
            $this->service->delete($user, $id);
        } catch (\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 409);
        }

        // 成功レスポンス
        return response()->json([
            'message' => 'カテゴリを削除しました。',
        ], 200);
    } 
    
}
