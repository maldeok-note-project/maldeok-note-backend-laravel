<?php

// import
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SpeakerCategoryController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| 認証が不要なAPI
|--------------------------------------------------------------------------
*/
// 会員登録
Route::post('/register', [AuthController::class, 'register']);

// ログイン
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| 認証が必要なAPI
|--------------------------------------------------------------------------
*/
Route::middleware('jwt.auth')->group(function () {
    // ユーザー情報更新
    Route::patch('/me', [UserProfileController::class, 'update']);
    
    // アカウント削除
    Route::delete('/me', [UserProfileController::class, 'destroy']);
    
    // ログアウト
    Route::post('/logout', [AuthController::class, 'logout']);


    /*
    |--------------------------------------------------------------------------
    | 話者カテゴリ API
    |--------------------------------------------------------------------------
    */
    // カテゴリ作成
    Route::post('/speaker-categories', [SpeakerCategoryController::class, 'store']);

    // カテゴリ一覧
    Route::get('/speaker-categories', [SpeakerCategoryController::class, 'index']);

    // カテゴリ編集
    Route::patch('/speaker-categories/{id}', [SpeakerCategoryController::class, 'update'])
});
