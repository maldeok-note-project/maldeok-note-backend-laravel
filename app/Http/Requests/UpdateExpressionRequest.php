<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

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


    // エラーメッセージに使う日本語の項目名
    #[Override]
    public function attributes(): array
    {
        return [
            'phrase' => '表現',
            'meaning' => '意味',
            'memo' => 'メモ',
            'speaker_category_id' => '話者カテゴリ',
            'speaker_name' => '話者の名前',
            'heard_at' => '聞いた日付',
            'place' => '場所',
        ];
    }
}
