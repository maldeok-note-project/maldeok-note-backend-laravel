<?php

namespace App\Http\Controllers;

// import
use App\Services\SpeakerCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// 継承
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
    public function store(Request $request): JsonResponse
    {
        // バリデーションチェック
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ], [
            'name.required' => '入力は必須です。',
            'name.string' => 'カテゴリ名は文字列で入力してください。',
            'name.max' => 'カテゴリ名は50文字以内で入力してください',
        ]);

        // Serviceカテゴリ作成
        try{
            // JWT認証で取得した「ログイン中のユーザー」
            $category = $this->service->create(
                $request->user(),
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

}
