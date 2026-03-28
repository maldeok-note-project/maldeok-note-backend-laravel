<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    // ユーザー情報更新
    public function update(Request $request)
    {
        $token = $request->bearerToken();

        return response()->json([
            'token' => $token
        ]);
    }
}
