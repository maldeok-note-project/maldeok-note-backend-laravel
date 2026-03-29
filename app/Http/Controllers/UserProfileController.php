<?php

namespace App\Http\Controllers;

// import
// use App\Models\User;
// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;


// 継承
class UserProfileController extends Controller
{
    // ユーザー情報更新
    public function update(UpdateProfileRequest $request)
    {        
        // 
        $user = $request->attributes->get('auth_user');

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


    // アカウント削除
    public function destroy(Request $request)
    {
        $user = $request->attributes->get('auth_user');

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
