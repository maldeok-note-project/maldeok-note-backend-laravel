<?php

namespace App\Http\Controllers;

// import
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;


// 継承
class UserProfileController extends Controller
{
    // ユーザー情報更新
    public function update(Request $request)
    {
        $token = $request->bearerToken();

        // トークン確認
        if (!$token) {
            return response()->json([
                'message' => 'token not found'
            ], 401);
        }

        $decoded = JWT::decode($token, new Key(env('TOKEN_SECRET'), 'HS256'));

        $userId = $decoded->sub;

        $user = User::find($userId);

        return response()->json([
            'data' => $user
        ]);
    }
}
