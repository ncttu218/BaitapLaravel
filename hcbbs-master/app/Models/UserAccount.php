<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Original\Util\SessionUtil;

/**
 * 担当者モデル
 *
 * @author yhatsutori
 *
 */
class UserAccount extends AbstractModel implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, SoftDeletes;

    // テーブル名
    protected $table = 'tb_account_hansha';

    // 変更可能なカラム
    protected $fillable = [
        'user_login_id',
        'user_password',
        'password',
        'user_name',
        'account_level',
        'bikou',
        'last_logined',
        'remember_token',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'mail_mut',
        'mail_user',
        'hansha_code',
        'shop',
        'category'
    ];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * 担当者選択用のOptionをDBから取得する
     *
     */
    public static function options() {
        // 拠点長は表示しない
        //return UserAccount::whereNotIn( 'account_level', [6] )
        return UserAccount::orderBys( ['id' => 'asc'] )
            ->pluck( 'user_name', 'user_id' );
    }
        
    /**
     * ユーザーIDの重複をチェックする
     * カスタムバリデーション用メソッド
     * @param unknown $value
     * @return boolean
     */
    public function unique( $value ) {
        $count = UserAccount::where( 'user_id', $value )
                            ->whereNull( $this->getTableName().'.'.$this->getDeletedAtColumn() )
                            ->count();

        return $count == 0;
    }

    /**
     * ユーザーログインIDの重複チェックをする
     * カスタムバリデーション用メソッド
     * @param unknown $value
     * @return boolean
     */
    public function unique_login_id( $value ) {
        $count = UserAccount::where( 'user_login_id', $value )
                            ->whereNull( $this->getTableName().'.'.$this->getDeletedAtColumn() )
                            ->count();

        return $count == 0;
    }
    
    /**
     * 半角チェックをする
     * カスタムバリデーション用メソッド
     * @param unknown $value
     * @return boolean
     */
    public function is_alnum( $value ) {
        if (preg_match("/^[a-zA-Z0-9]+$/",$value)) {
            return TRUE;
    	} else {
            return FALSE;
    	}
    }

    ###########################
    ## User List Commands
    ###########################
    
    /**
     * 検索条件を指定するメソッド
     * @param  [type] $query      [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function scopeWhereRequest( $query, $requestObj ){
        // 本社権限は販社コード指定
        $loginAccountObj = SessionUtil::getUser();
        $level = $loginAccountObj->getAccountLevel();
        $hansha_code = $loginAccountObj->getHanshaCode();

        // 販社コード
        $query->whereMatch( 'hansha_code', $requestObj->hansha_code );
        
        if($level >= 2){
            $sql = "hansha_code = " . "'" . $hansha_code . "'";
            $query->whereRaw( DB::raw($sql) );
        }
        
        return $query;
    }

        /**
     * ダミー表示の検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereUserId( $query, $value ){
        if( $value ){
            $sql = "user_login_id = " . "'" . $value . "'";
            $query->whereRaw( DB::raw($sql) );
        }

        return $query;
    }
}