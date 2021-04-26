<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Requests;

use App\Http\Requests\SearchRequest;
use Request;

/**
 * Description of InfobbsRequest
 *
 * @author ohishi
 */
class InfobbsRequest extends SearchRequest {

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
        // リクエスト
        $request = (object)Request::all();
        // 販社コード
        $hanshaCode = Request::segment(3) ?? '';
        // ルール
        $rules = [];
        
        // 福島様のみ
        if ($hanshaCode === '8153883') {
            $rules['to_date'] = 'required|regex:/^\d\d\d\d-\d\d-\d\d$/';
        }

        return $rules;
    }
    
    public function messages() {
        return [
            'to_date.required' => '掲載終了日が未設定です。必ず設定してください',
            'to_date.regex' => '掲載終了日のフォーマットが正しくないです',
        ];
    }

}
