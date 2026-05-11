<?php

namespace App\Http\Controllers;

// import
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;
use App\Models\RevokedToken;
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
                    'password' => Hash::make($request->password),
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

        // 現在時間
        $now = time();
        // トークンの有効時間
        $ttl = (int) env('TOKEN_TTL', 60);

        // トークンの中身
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => $now,
            // 有効期限
            'exp' => $now + ($ttl * 60),
        ];

        // トークン作成
         $token = JWT::encode($payload, env('TOKEN_SECRET'), 'HS256');

        // ログイン成功
        return response()->json([
            'message' => 'login ok',
            'token' => $token,
        ]);
    }


    // ログアウト
    public function logout(Request $request)
    {
        // AuthorizationヘッダーからBearer Token取得
        $token = $request->bearerToken();
        // トークンが見つからないとき
        if (!$token) {
            return response()->json([
                'message' => 'token not found'
            ], 401);
        }

        // JWTをdecodeしてpayload取得
        $decoded = JWT::decode($token, new Key(env('TOKEN_SECRET'), 'HS256'));

        // revoked_tokens テーブルに保存
        // → 今後このtokenは使用不可になる
        RevokedToken::create([
            'token' => $token,
            // JWTのexp(有効期限)をDB保存用日時へ変換
            'expires_at' => date('Y-m-d H:i:s', $decoded->exp),
        ]);

        // ログアウト成功表示
        return response()->json([
            'message' => 'logout ok'
        ], 200);
    }
}