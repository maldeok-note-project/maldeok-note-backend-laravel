<?php

namespace App\Http\Requests;

// import
use Illuminate\Foundation\Http\FormRequest;

// 継承
class UpdateProfileRequest extends FormRequest
{
    // このリクエストを許可する
    public function authorize(): bool
    {
        return true;
    }

    // 入力チェックのルール
    public function rules(): array
    {
        // ログイン中ユーザーのIDを取得
        $userId = $this->attributes->get('auth_user_id');

        // 条件（送られてこなくてもOK）
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6',
        ];
    }
}
