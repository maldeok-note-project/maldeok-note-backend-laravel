<?php

// import
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// 会員登録
Route::post('/register', [AuthController::class, 'register']);

// ログイン
Route::post('/login', [AuthController::class, 'login']);