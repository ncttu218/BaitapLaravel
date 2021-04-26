<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;
use Session;

/**
 * お知らせの登録・編集用のフォームリクエスト
 *
 * @author yhatsutori
 *
 */
class ShowroomInfoRequest extends FormRequest {

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
        $request = Request::all();
        // 入力された値をセッションで保持
        Session::put( 'srInfo.input', $request );

        $rules = [
            'comment' => 'required',
        ];
        
        return $rules;
    }

    public function messages()
    {
        // エントリーフォームの入力値確認
        $messages = [
            'comment.required' => 'コメントを入力してください。',
        ];
        
        return $messages;
    }
}
