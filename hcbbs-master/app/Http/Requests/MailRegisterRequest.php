<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SearchRequest;
use App\Models\EmailSettings;
use App\Original\Util\SessionUtil;
use Request;

/**
 * メールアドレス登録用のフォームリクエスト
 *
 * @author ahmad
 *
 */
class MailRegisterRequest extends SearchRequest {

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
        
        // 転送メールを別の店舗に登録されるかのルール
        Validator::extend('unique_email', function ($attribute, $value)
        use($request) {
            $hanshaCode = SessionUtil::getUser()
                    ->getHanshaCode();
            
            // スキップ
            if (empty($hanshaCode) || empty($request->shop)) {
                return true;
            }
            
            // 転送メール
            $forwardEmail = $hanshaCode . '.' . $request->system_name .'@hondanet.co.jp';
            
            $item = EmailSettings::select(['id'])
                    ->where('email', $value)
                    ->where('forward_email', $forwardEmail)
                    ->where('shop_code', $request->shop);
            
            // システム名の絞込
            if ($request->system_name == 'staff') {
                $item = $item->whereRaw("(system_name = 'staff' OR system_name = 'forwarded_staff')");
            } else if ($request->system_name == 'infobbs') {
                $item = $item->whereRaw("(system_name = 'infobbs' OR system_name = 'forwarded_infobbs')");
            }
            
            $item = $item->first();
            
            return $item === null;
        });
        
        $rules = [
            'email' => 'required|email|unique_email', // メールアドレス
            'shop' => 'required|max:2', // 拠点コード
            'system_name' => 'required' // システム名
        ];
        
        return $rules;
    }

    /**
     * エラーメッセージ
     * @return array
     */
    public function messages()
    {
        // エントリーフォームの入力値確認
        $messages = [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスが無効です。',
            'email.unique' => 'メールアドレスが登録されました。',
            'shop.required' => '拠点コードを入力してください。',
            'system_name.required' => 'システム名を入力してください。',
            'unique_email' => 'メールアドレスが別の店舗またはスタッフに登録されています。',
        ];
        
        return $messages;
    }
}
