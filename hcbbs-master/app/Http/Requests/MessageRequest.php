<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 1行メッセージの登録・編集用のフォームリクエスト
 *
 * @author yhatsutori
 *
 */
class MessageRequest extends FormRequest {

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
        // リクエストを取得
        $request = $this->request->all();

        $rules = [
            'title' => 'required',
            // 'from_date' => 'required',
            // 'to_date' => 'required',
        ];

        // 掲載期間の入力が正しくないとき
        if( ( isset( $request['from_date'] ) && isset( $request['to_date'] ) ) && ( $request['from_date'] > $request['to_date'] ) ){
            $rules['to_from_date'] = 'required';
        }
        
        return $rules;
    }

    public function messages()
    {
        // エントリーフォームの入力値確認
        $messages = [
            'title.required' => 'タイトルを入力してください。',
            // 'from_date.required' => '掲載期間：開始日を入力してください。',
            // 'to_date.required' => '掲載期間：終了日を入力してください。',
            'to_from_date.required' => '掲載期間：終了日は、開始日と同じかそれより後の日付を入力してください。',
        ];
        
        return $messages;
    }
}
