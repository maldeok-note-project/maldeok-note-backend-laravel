<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreSpeakerCategoryRequest extends FormRequest
{
    // 権限確認
    public function authorize(): bool
    {
        return true;
    }


    // バリデーションルール
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
        ];
    }


    // エラーメッセージ
    #[Override]
    public function messages(): array
    {
        return [
            'name.required' => 'カテゴリ名は必須です。',
            'name.string' => 'カテゴリ名は文字列で入力してください。',
            'name.max' => 'カテゴリ名は50文字以内で入力してください。',
        ];
    }
}
