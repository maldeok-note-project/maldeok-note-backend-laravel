<?php

namespace App\Http\Controllers;

// import
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;


// 継承
class UserProfileController extends Controller
{
    // ユーザー情報更新
    public function update(UpdateProfileRequest $request)
    {        
        // ログイン中のユーザー取得
        $user = $request->attributes->get('auth_user');

        // 入力済みの内容取得
        $validatedData = $request->validated();

        // 変更内容があれば更新
        if (array_key_exists('name', $validatedData)) {
            $user->name = $validatedData['name'];
        }

        if (array_key_exists('email', $validatedData)) {
            $user->email = $validatedData['email'];
        }

        if (array_key_exists('password', $validatedData)) {
            $user->password = $validatedData['password'];
        }
        // 保存
        $user->save();

        return response()->json([
            'message' => 'profile update successful',
            'data' => $user,
        ]);
    }


    // アカウント削除
    public function destroy(Request $request)
    {
        // ログイン中のユーザー取得
        $user = $request->attributes->get('auth_user');
        // 削除
        $user->delete();
        // 成功
        return response()->json([
            'message' => 'user deletion successful'
        ], 200);
    }
}
