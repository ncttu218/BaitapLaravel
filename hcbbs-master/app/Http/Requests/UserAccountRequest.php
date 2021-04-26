<?php

namespace App\Http\Requests;

use App\Http\Requests\SearchRequest;

/**
 * アカウントの登録・編集用のフォームリクエスト
 *
 * @author yhatsutori
 *
 */
class UserAccountRequest extends SearchRequest {

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
            //'user_id' => 'required|unique:tb_user_account'
            'user_login_id' => 'required',
            'user_password' => 'required',
            'user_name' => 'required',
            'account_level' => 'required',
            'hansha_code' => 'required'
        ];
        
        return $rules;
    }
    
}
