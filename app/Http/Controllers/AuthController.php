<?php

namespace App\Http\Controllers;

// import
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


// 継承
class AuthController extends Controller{

    // 新規会員
    public function register(Request $request)
    {
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


    // ログイン
    public function login(Request $request)
    {
        // 入力チェック
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // メールアドレスでアカウントを探す
        $user = User::where('email', $request->email)->first();

        // 送られてきたパスワードとDBを照会
        if (!$user || !Hash::check($request->password, $user->password)) {
            // ログイン失敗
            return response()->json([
                'message' => 'login fail'
            ], 401);
        }

        // ログイン成功
        return response()->json([
            'message' => 'login ok'
        ]);
    }
}