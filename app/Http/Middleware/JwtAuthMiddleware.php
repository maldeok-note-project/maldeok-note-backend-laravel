<?php

namespace App\Http\Middleware;

use App\Models\RevokedToken;
use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class JwtAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ヘッダーからトークン取得
        $token = $request->bearerToken();
        // トークンが無ければ
        if (!$token) {
            return response()->json([
                'message' => 'token not found'
            ], 401);
        }

        // ログアウト済みトークンか確認
        // revoked_tokens に保存されているトークンは使用不可
        if (RevokedToken::where('token', $token)->exists()) {
            return response()->json([
                'message' => 'token has been revoked'
            ], 401);
        }

        try {
            // トークンの中身を確認
            $decodedToken = JWT::decode($token, new Key(env('TOKEN_SECRET'), 'HS256'));
            // トークン内の sub からユーザーIDを取得
            $userId = $decodedToken->sub;
        
        // トークンが不正、または有効期限切れの場合
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'invalid token'
            ], 401);
        }

        // subからuserを探す
        $user = User::find($userId);
        // 見つからない場合
        if (!$user) {
            return response()->json([
                'message' => 'user not found'
            ], 404);
        }

        // 後続のControllerやRequestでログイン中ユーザー/IDを使えるようにする
        $request->attributes->set('auth_user', $user);
        $request->attributes->set('auth_user_id', $userId);
        // 次の処理
        return $next($request);
    }
}
