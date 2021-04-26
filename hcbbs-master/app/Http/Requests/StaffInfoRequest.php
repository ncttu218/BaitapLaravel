<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;
use Session;

class StaffInfoRequest extends FormRequest {

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

        // キャンセルされる時、検証されない
        if (isset($request['cancel'])) {
            return [];
        }

        // 入力された値をセッションで保持
        Session::put( 'staffInfo.input', $request );
        
        $rules = [
            'name' => 'required',
            'shop' => 'required',
            'department' => 'required',
        ];
        
        $hanshaCode = Request::segment(3);
        if ($hanshaCode == '5551803') {
        } else if ($hanshaCode == '1103901') {
            $rules['grade'] = 'required|numeric';
        } else {
            $rules['grade'] = 'required|numeric|digits_between:2,2';
        }

        return $rules;
    }
    
    public function messages()
    {
        return [
            'name.required' => '氏名は必須入力です',
            'shop.required' => '店舗名は必須入力です',
            'grade.required' => '等級は必須入力です',
            'grade.numeric' => '等級は半角数字で入力してください',
            'grade.digits_between' => '等級は半角数字、2桁で入力してください(入力例：05)',
            'department.required' => '所属・役職は必須入力です',
        ];
    }

}
