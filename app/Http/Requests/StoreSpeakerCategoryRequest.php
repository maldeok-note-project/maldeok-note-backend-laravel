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
}
