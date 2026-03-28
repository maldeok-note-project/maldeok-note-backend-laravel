<?php

namespace App\Http\Middleware;

// import
use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

class JwtAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
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

        // トークンの中身を確認
        try {
            $decoded = JWT::decode($token, new Key(env('TOKEN_SECRET'), 'HS256'));
            $userId = $decoded->sub;
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

        $request->attributes->set('auth_user', $user);
        $request->attributes->set('auth_user_id', $userId);

        return $next($request);
    }
}
