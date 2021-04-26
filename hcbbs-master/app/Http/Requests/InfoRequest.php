<?php

namespace App\Http\Requests;

use App\Http\Requests\SearchRequest;

/**
 * お知らせの登録・編集用のフォームリクエスト
 *
 * @author yhatsutori
 *
 */
class InfoRequest extends SearchRequest {

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
            'info_target_date' => 'required',
            'info_title' => 'required|max:100',
            'info_body' => 'required|max:300'
        ];
        
        return $rules;
    }
}
