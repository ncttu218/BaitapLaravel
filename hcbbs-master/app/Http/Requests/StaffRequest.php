<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Original\Util\SessionUtil;
use Request;

/**
 * お知らせの登録・編集用のフォームリクエスト
 *
 * @author yhatsutori
 *
 */
class StaffRequest extends FormRequest {

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
        
        $rules = [
            'name' => 'required',
            'shop' => 'required',
        ];

        // 入力された値をセッションで保持
        $sessionData = SessionUtil::getData('profile');
        foreach ($request as $key => $value) {
            if (!isset($sessionData[$key])) {
                continue;
            }
            $sessionData[$key] = $value;
        }
        SessionUtil::putData( $sessionData, 'profile' );
        
        return $rules;
    }

    public function messages()
    {
        // エントリーフォームの入力値確認
        $messages = [
            'name.required' => '氏名を入力してください。',
            'shop.required' => '店舗を入力してください。',
        ];
        
        return $messages;
    }
}
