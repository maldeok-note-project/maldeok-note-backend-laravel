<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpressionRequest extends FormRequest
{
    // 権限チェック
    public function authorize(): bool
    {
        return true;
    }


    // バリデーションルール定義
    public function rules(): array
    {
        return [
            // 表現
            'phrase' => 'sometimes|required|string|max:255',
            // 意味
            'meaning' => 'sometimes|required|string|max:255',
            // メモ
            'memo' => 'sometimes|required|string|max:1000',
            // カテゴリID
            'speaker_category_id' => 'sometimes|required|integer',
            // 話者の名前
            'speaker_name' => 'sometimes|required|max:100',
            // 日付
            'heard_at' => 'sometimes|required|date',
            // 場所
            'place' => 'sometimes|nullable|string|max:255',
        ];
    }
}
