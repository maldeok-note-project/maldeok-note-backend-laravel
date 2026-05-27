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


    // エラーメッセージに使う日本語の項目名
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

    // エラーメッセージ
    public function messages(): array
    {
        return [
            'phrase.required' => '表現は必須です。',
            'phrase.string'   => '表現は文字列で入力してください。',
            'phrase.max'      => '表現は255文字以内で入力してください。',

            'meaning.required' => '意味は必須です。',
            'meaning.string'   => '意味は文字列で入力してください。',
            'meaning.max'      => '意味は255文字以内で入力してください。',

            'speaker_category_id.required' => 'カテゴリは必須です。',
            'speaker_category_id.integer'  => 'カテゴリIDは数値で指定してください。',

            'speaker_name.required' => '名前は必須です。',
            'speaker_name.string'   => '名前は文字列で入力してください。',
            'speaker_name.max'      => '名前は100文字以内で入力してください。',

            'heard_at.required' => '日付は必須です。',
            'heard_at.date'     => '日付は正しい日付形式で入力してください。',

            'memo.string' => 'メモは文字列で入力してください。',
            'memo.max'    => 'メモは1000文字以内で入力してください。',

            'place.string' => '場所は文字列で入力してください。',
            'place.max'    => '場所は255文字以内で入力してください。',
        ];
    }
}
