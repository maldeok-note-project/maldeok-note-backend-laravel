<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpressionRequest extends FormRequest
{
    /**
     * このリクエストを実行する権限があるか
     * 認証は jwt.auth ミドルウェアで処理しているので true を返す
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'phrase' => 'required|string|max:255',
            'meaning'             => 'required|string|max:255',
            'speaker_category_id' => 'required|integer|exists:speaker_categories,id',
            'speaker_name'        => 'required|string|max:100',
            'heard_at'            => 'required|date',
            'memo'                => 'nullable|string|max:1000',
            'place'               => 'nullable|string|max:255',
            'is_favorite'         => 'nullable|boolean',
        ];
    }

    /**
     * エラーメッセージ（日本語化）
     */
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
            'speaker_category_id.exists'   => '指定されたカテゴリは存在しません。',

            'speaker_name.required' => '名前は必須です。',
            'speaker_name.string'   => '名前は文字列で入力してください。',
            'speaker_name.max'      => '名前は100文字以内で入力してください。',

            'heard_at.required' => '日付は必須です。',
            'heard_at.date'     => '日付は正しい日付形式で入力してください。',

            'memo.string' => 'メモは文字列で入力してください。',
            'memo.max'    => 'メモは1000文字以内で入力してください。',

            'place.string' => '場所は文字列で入力してください。',
            'place.max'    => '場所は255文字以内で入力してください。',

            'is_favorite.boolean' => 'お気に入りはtrue/falseで指定してください。',
        ];
    }
}
