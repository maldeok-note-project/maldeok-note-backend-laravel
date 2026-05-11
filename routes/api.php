<?php

// import
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// 会員登録
Route::post('/register', [AuthController::class, 'register']);

// ログイン
Route::post('/login', [AuthController::class, 'login']);

// 要認証
Route::middleware('jwt.auth')->group(function(){
    // ユーザー情報更新
    Route::patch('/me', [UserProfileController::class, 'update']);
    
    // アカウント削除
    Route::delete('/user', [UserProfileController::class, 'destroy']);
    
    // ログアウト
    Route::post('/logout', [AuthController::class, 'logout']);
});
