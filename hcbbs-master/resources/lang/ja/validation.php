<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */

    "accepted" => "The :attribute must be accepted.",
    "active_url" => "The :attribute is not a valid URL.",
    "after" => "The :attribute must be a date after :date.",
    "alpha" => "The :attribute may only contain letters.",
    "alpha_dash" => "The :attribute may only contain letters, numbers, and dashes.",
    "alpha_num" => "The :attribute may only contain letters and numbers.",
    "array" => "The :attribute must be an array.",
    "before" => "The :attribute must be a date before :date.",
    "between" => [
        "numeric" => "The :attribute must be between :min and :max.",
        "file" => "The :attribute must be between :min and :max kilobytes.",
        "string" => "The :attribute must be between :min and :max characters.",
        "array" => "The :attribute must have between :min and :max items.",
    ],
    "boolean" => "The :attribute field must be true or false.",
    "confirmed" => "The :attribute confirmation does not match.",
    "date" => "The :attribute is not a valid date.",
    "date_format" => "The :attribute does not match the format :format.",
    "different" => "The :attribute and :other must be different.",
    "digits" => "The :attribute must be :digits digits.",
    "digits_between" => "The :attribute must be between :min and :max digits.",
    "email" => "The :attribute must be a valid email address.",
    "filled" => "The :attribute field is required.",
    "exists" => "The selected :attribute is invalid.",
    "image" => "The :attribute must be an image.",
    "in" => "The selected :attribute is invalid.",
    "integer" => "The :attribute must be an integer.",
    "ip" => "The :attribute must be a valid IP address.",
    "max" => [
        "numeric" => "The :attribute may not be greater than :max.",
        "file" => "The :attribute may not be greater than :max kilobytes.",
        "string" => ":attributeは:max文字以下でご入力ください.",
        "array" => "The :attribute may not have more than :max items.",
    ],
    //"mimes"                => "The :attribute must be a file of type: :values.",
    "mimes" => ":attribute",
    "min" => [
        "numeric" => "The :attribute must be at least :min.",
        "file" => "The :attribute must be at least :min kilobytes.",
        "string" => "The :attribute must be at least :min characters.",
        "array" => "The :attribute must have at least :min items.",
    ],
    "not_in" => "The selected :attribute is invalid.",
    "numeric" => "The :attribute must be a number.",
    "regex" => "The :attribute format is invalid.",
    "required" => ":attributeは必須入力です",
    "required_if" => "The :attribute field is required when :other is :value.",
    "required_with" => "The :attribute field is required when :values is present.",
    "required_with_all" => "The :attribute field is required when :values is present.",
    "required_without" => "The :attribute field is required when :values is not present.",
    "required_without_all" => "The :attribute field is required when none of :values are present.",
    "same" => "The :attribute and :other must match.",
    "size" => [
        "numeric" => "The :attribute must be :size.",
        "file" => "The :attribute must be :size kilobytes.",
        "string" => "The :attribute must be :size characters.",
        "array" => "The :attribute must contain :size items.",
    ],
    "unique" => "The :attribute has already been taken.",
    "url" => "The :attribute format is invalid.",
    "timezone" => "The :attribute must be a valid zone.",
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'base_code' => [
            'change_unique' => '拠点コードはすでに使用されているため使用できません',
        ],
        'user_id' => [
            'change_unique' => '担当者コードはすでに使用されているため使用できません',
            'is_alnum' => '担当者コードは半角英数字で入力してください',
        ],
        'user_login_id' => [
            'change_unique' => 'ログインIDはすでに使用されているため使用できません',
            'is_alnum' => 'ログインIDは半角英数字で入力してください',
        ],
        'user_password' => [
            'is_alnum' => 'パスコードは半角英数字で入力してください',
        ]
    ],
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => [
        'name' => '名前',
        'csv_file' => 'CSVファイルをアップロードしてください。',
        'csv_cols' => 'CSVカラム数',
        'user_id' => '担当者コード',
        'user_login_id' => 'ログインID',
        'password' => 'パスワード',
        'user_password' => 'パスコード',
        'user_name' => '担当者',
        'account_level' => '機能権限',
        'mail_mut' => 'メールアドレス(六三用) ',
        'mail_user' => 'メールアドレス(お客様用) ',
        'hansha_code' => '販社コード',
        'base_code' => '拠点コード',
        'email' => 'メールアドレス',
        'forward_email' => '転送メール',
        'staff_code' => 'スタッフコード',
        'shop_code' => '拠点コード',
        'base_name' => '拠点名',
        'base_short_name' => '拠点略称',
        'work_level' => '新中区分',
        'info_target_date' => '対象日',
        'info_title' => 'タイトル',
        'info_body' => '内容',
        'car_manage_number' => '統合車両管理NO',
        'act_car_manage_number' => '統合車両管理NO',
        'abc_car_manage_number' => '統合車両管理NO',
        'rst_manage_number' => '統合車両管理NO',
        'tmr_manage_number' => '統合車両管理NO',
        'face-image' => '顔写真はjpeg,jpg,pngをアップロードしてください。',
        // トピックス 登録・編集
        'title' => 'タイトル',
        'description' => '本文',
        'view_flg' => '表示フラグ',
        'category' => 'カテゴリー',
        // 販社 登録・編集
        'hansha_name' => '販社名',
        'hansha_cd' => '販社コード',
        'pref' => '都道府県',
        // 車種 登録・編集
        'car_name' => '車種名'
    ],
];
