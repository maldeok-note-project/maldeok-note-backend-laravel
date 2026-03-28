<?php

namespace App\Http\Controllers;

// import
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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


        // 条件
        $request->validate([
            'name' => 'nullable|string|max:255',
            'nullable|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::find($userId);

        // IDが違う場合
        if (!$user) {
            return response()->json([
                'message' => 'user not found'
            ], 404);
        }

        // 変更内容があれば更新
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        // 保存
        $user->save();

        return response()->json([
            'message' => 'profile update ok',
            'data' => $user
        ]);
    }
}
