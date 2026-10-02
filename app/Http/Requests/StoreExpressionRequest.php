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
            'speaker_category_id' => 'required|integer',
            'speaker_name'        => 'required|string|max:100',
            'heard_at'            => 'required|date',
            'memo'                => 'nullable|string|max:1000',
            'place'               => 'nullable|string|max:255',
            'is_favorite'         => 'nullable|boolean',
        ];
    }
}
