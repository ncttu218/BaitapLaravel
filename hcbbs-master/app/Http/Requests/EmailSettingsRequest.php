<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Rules\EmailForwardEmailRule;
use App\Models\EmailSettings;
use App\Models\Base;
use Request;
use DB;

/**
 * 投稿アドレスの登録・編集用のフォームリクエスト
 *
 * @author ahmad
 *
 */
class EmailSettingsRequest extends SearchRequest {
    
    /**
     * ユーザーのメールアドレスの一致確認
     */
    const CHECK_USER_EMAIL_UNIQUE = 0;
    
    /**
     * 転送メールアドレスの一致確認
     */
    const CHECK_FORWARD_EMAIL_UNIQUE = 1;

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
        $request = (object)Request::all();
        
        // 転送メールを別の店舗に登録されるかのルール
        Validator::extend('unique_infobbs_forward_email', function ($attribute, $value)
        use($request) {
            return $this->checkInfobbsEmailUnique($request, self::CHECK_FORWARD_EMAIL_UNIQUE);
        });
        
        // 転送メールを別の店舗に登録されるかのルール
        Validator::extend('unique_staff_forward_email', function ($attribute, $value)
        use($request) {
            return $this->checkStaffEmailUnique($request, self::CHECK_FORWARD_EMAIL_UNIQUE);
        });
        
        // 転送メールを別の店舗に登録されるかのルール
        Validator::extend('unique_shop_code', function ($attribute, $value)
        use($request) {
            return $this->checkInfobbsEmailUnique($request, self::CHECK_USER_EMAIL_UNIQUE);
        });
        
        // 転送メールを別の店舗に登録されるかのルール
        Validator::extend('unique_staff_code', function ($attribute, $value)
        use($request) {
            return $this->checkStaffEmailUnique($request, self::CHECK_USER_EMAIL_UNIQUE);
        });
        
        // 店舗コードが登録されるかの確認
        Validator::extend('registered_shop_code', function ($attribute, $value)
        use($request) {
            if (($request->system_name == 'infobbs' && empty($request->hansha_code))
                    || ($request->system_name == 'forwarded_infobbs' && empty($request->forward_email))
                    || empty($request->shop_code)) {
                return true;
            }
            
            $hanshaCode = null;
            if ($request->system_name == 'forwarded_infobbs') {
                if (preg_match('/^([0-9]{7})\.infobbs.+$/', $request->forward_email, $match)) {
                    $hanshaCode = $match[1];
                }
            } else {
                $hanshaCode = $request->hansha_code;
            }
            
            // テーブルが存在しない場合
            try {
                $item = Base::select(['id'])
                        ->where('hansha_code', $hanshaCode)
                        ->where('base_code', $request->shop_code)
                        ->where('base_published_flg', 1)
                        ->first();
            } catch (\Exception $ex) {
                return false;
            }
            return $item !== null;
        });
        
        // スタッフコードが登録されるかの確認
        Validator::extend('registered_staff_code', function ($attribute, $value)
        use($request) {
            if (($request->system_name == 'staff' && empty($request->hansha_code))
                    || ($request->system_name == 'forwarded_staff' && empty($request->forward_email))
                    || empty($request->shop_code)) {
                return true;
            }
        
            $hanshaCode = null;
            if ($request->system_name == 'forwarded_staff') {
                if (preg_match('/^([0-9]{7})\.staff.+$/', $request->forward_email, $match)) {
                    $hanshaCode = $match[1];
                }
            } else {
                $hanshaCode = $request->hansha_code;
            }
        
            // テーブルが存在しない場合
            try {
                $item = DB::table('tb_' . $hanshaCode . '_staff')
                        ->select(['id'])
                        ->where('shop', $request->shop_code)
                        ->where('number', $request->staff_code)
                        ->where('disp', 'ON')
                        ->first();
            } catch (\Exception $ex) {
                return false;
            }
            return $item !== null;
        });
        
        // 無効な店舗ブログの転送メールアドレスのルール
        Validator::extend('valid_infobbs_forward_email', function ($attribute, $value) {
            return preg_match('/^[0-9]{7}\.infobbs@/', $value);
        });
        
        // 無効なスタッフブログの転送メールアドレスのルール
        Validator::extend('valid_staff_forward_email', function ($attribute, $value) {
            return preg_match('/^[0-9]{7}\.staff@/', $value);
        });
        
        $rules = [
            'email' => 'required|email', // メールアドレス
            'shop_code' => 'required|max:2', // 拠点コード
            'system_name' => 'required' // システム名
        ];
        
        if ($request->system_name == 'infobbs') {
            $rules['shop_code'] .= '|unique_shop_code';
        }
        
        if ($request->system_name == 'staff') {
            $rules['staff_code'] .= 'unique_staff_code';
        }
        
        // 直接のメールの場合、販社コードが必須
        if ($request->system_name == 'infobbs' || $request->system_name == 'staff') {
            $rules['hansha_code'] = 'required'; // 販社コード
        }
        
        // スタッフブログの場合、スタッフコードのフォーマットが有効
        if ($request->system_name == 'staff' || $request->system_name == 'forwarded_staff') {
            $rules['staff_code'] = 'required|max:10|regex:/^data[0-9]{6}$/'; // スタッフコード
        }
        
        // 店舗ブログの場合、店舗コードを登録されている？
        if ($request->system_name == 'infobbs' || $request->system_name == 'forwarded_infobbs') {
            $rules['shop_code'] .= '|registered_shop_code';
        }
        
        // スタッフブログの場合、スタッフコードを登録されている？
        if ($request->system_name == 'staff' || $request->system_name == 'forwarded_staff') {
            $rules['staff_code'] .= '|registered_staff_code';
        }
        
        // 転送メールの店舗ブログの場合、メールのチェック
        if ($request->system_name == 'forwarded_infobbs') {
            $rules['forward_email'] = 'required|email|valid_infobbs_forward_email'; // 転送メール
            // 上書きの防止
            $rules['email'] .= '|unique_infobbs_forward_email';
        }
        
        // 転送メールのスタッフブログの場合、メールのチェック
        if ($request->system_name == 'forwarded_staff') {
            $rules['forward_email'] = 'required|email|valid_staff_forward_email'; // 転送メール
            // 上書きの防止
            $rules['email'] .= '|unique_staff_forward_email';
        }
        
        return $rules;
    }
    
    public function messages() {
        return [
            'unique_infobbs_forward_email' => 'メールアドレスが別の店舗に登録されています。',
            'valid_infobbs_forward_email' => '店舗ブログの転送メールアドレスのフォーマットが無効です。',
            'unique_staff_forward_email' => 'メールアドレスが別のスタッフに登録されています。',
            'valid_staff_forward_email' => 'スタッフブログの転送メールアドレスのフォーマットが無効です。',
            'unique_shop_code' => 'メールアドレスが別の店舗に登録されています。',
            'unique_staff_code' => 'メールアドレスが別のスタッフに登録されています。',
            'registered_shop_code' => '店舗コードを登録されていません。',
            'registered_staff_code' => 'スタッフコードを登録されていません。',
            'staff_code.regex' => 'スタッフコードのフォーマットが無効です。',
        ];
    }
    
    public function checkInfobbsEmailUnique($request, $validationType) {
        // スキップ
        if ($validationType == self::CHECK_FORWARD_EMAIL_UNIQUE &&
                empty($request->forward_email)) {
            return true;
        }

        $item = EmailSettings::select(['id'])
                ->where('email', $request->email)
                ->where('id', '<>', $request->id);
        
        if ($validationType == self::CHECK_FORWARD_EMAIL_UNIQUE) {
            $item = $item->where('forward_email', $request->forward_email)
                    ->where('system_name', 'forwarded_infobbs');
        } else {
            $item = $item->where('hansha_code', $request->hansha_code)
                    ->where('system_name', 'infobbs');
        }
        
        $item = $item->first();
        
        return $item === null;
    }
    
    public function checkStaffEmailUnique($request, $validationType) {
        // スキップ
        if ($validationType == self::CHECK_FORWARD_EMAIL_UNIQUE &&
                empty($request->forward_email)) {
            return true;
        }

        $item = EmailSettings::select(['id'])
                ->where('email', $request->email)
                ->where('id', '<>', $request->id);
        
        if ($validationType == self::CHECK_FORWARD_EMAIL_UNIQUE) {
            $item = $item->where('forward_email', $request->forward_email)
                ->where('system_name', 'forwarded_staff');
        } else {
            $item = $item->where('hansha_code', $request->hansha_code)
                    ->where('system_name', 'staff');
        }
        
        $item = $item->where('shop_code', $request->shop_code)
                ->first();
        
        return $item === null;
    }
}
