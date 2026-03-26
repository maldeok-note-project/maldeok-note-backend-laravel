<?php

namespace App\Http\Controllers;

// import
use App\Models\User;
use Illuminate\Http\Request;


// 継承
class AuthController extends Controller{

    // 新規会員
    public function register(Request $request){
        // 入力チェック（バリデーション）
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // userテーブルに新規ユーザー登録
        $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                ]);

        // 結果出力
        return response()->json([
            'message' => 'register ok',
            'data' => $user,
        ]);
    }
}