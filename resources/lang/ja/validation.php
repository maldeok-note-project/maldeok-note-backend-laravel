<?php

return [
    // ルールメッセージ
    'required' => ':attributeは必須です。',
    'string' => ':attributeは文字列で入力してください。',
    'integer' => ':attributeは数値で指定してください。',
    'boolean' => ':attributeはtrue/falseで指定してください。',
    'date' => ':attributeは正しい日付形式で入力してください。',
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。'
        ],

    // フィールド名
    'attributes' => [
        'phrase' => '表現',
        'meaning' => '意味',
        'memo' => 'メモ',
        'speaker_category_id' => 'カテゴリID',
        'speaker_name' => '話者の名前',
        'heard_at' => '聞いた日付',
        'place' => '場所',
        'is_favorite' => 'お気に入り',
        'name' => 'カテゴリ名'
    ],
];