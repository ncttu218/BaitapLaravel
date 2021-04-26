<?php

namespace App\Http\Requests;

use App\Http\Requests\SearchRequest;

/**
 * 拠点の登録・編集用のフォームリクエスト
 *
 * @author yhatsutori
 *
 */
class BaseRequest extends SearchRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'hansha_code' => 'required', // 販社コード
            'base_code' => 'required', // 拠点コード
            'base_name' => 'required' // 拠点名
        ];
        
        return $rules;
    }
}
