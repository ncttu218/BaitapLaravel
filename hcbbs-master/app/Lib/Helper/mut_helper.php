<?php

/**
 * 六三の共通関数
 */

################################
## 六三の共通関数
################################

/**
 * オリジナルisset
 * @param  value $checkVal 値が存在するかを調べる値
 * @param  string $setValue 値が存在しない時の値
 * @return 成功：$checkValue 失敗：setValue
 */
function orgIsset( $checkValue, $setValue="" ){
    if( isset( $checkValue ) ){
        if( !empty( $checkValue ) ){
            return $checkValue;
        }
    }
    return $setValue;
}

/**
 *  値を代入したいオブジェクトに、配列又は、オブジェクトの値を格納する
 * @param  object or array $paramVar オブジェクトのメンバ変数に代入するオブジェクト又は配列
 * @param  object &$setObject 値を代入するオブジェクト
 */
function orgSetObjectParams( $paramVar, &$setObject=NULL ){
    // paramVar は配列か、オブジェクトで渡す。

    // セッションの値が空でない時に動作
    if( !empty( $paramVar ) == true && !is_null( $setObject ) == true ){
        // セッションの値を取得
        foreach( $paramVar as $key => $value ){
            // 代入先の変数があるか
            if( isset( $setObject->$key ) == true ){
                // 代入する値が配列ではないか
                if( !is_array( $value ) == true ){
                    $setObject->$key = orgIsset( $value, $setObject->$key );
                }
            }
        }
    }
}

/**
 * 全角をスペースを半角スペースにする
 * @param  string $value
 * @param  string $typeFlg 未使用
 * @return 半角スペースにした値
 */
function orgTrim( $value, $typeFlg="" ){
    $value = str_replace( '　', ' ', $value );
    $value = trim( $value );

    return $value;
}

/**
 * 指定された数のパディングを行う
 * @param  [type]  $value   [description]
 * @param  integer $padding [description]
 * @return [type]           [description]
 */
function orgPadding( $value, $padding=8 ){
    $param = '%0' . $padding . 'd';
    $value = sprintf( $param, $value );
    return $value;
}

/**
 * 色をつけた文字の出力(デバッグ)
 * @return [type] [description]
 */
function d(){
    echo '<pre style="background:#fff;color:#333;border:1px solid #ccc;margin:2px;padding:4px;font-family:monospace;font-size:12px">';
    foreach ( func_get_args() as $v ){
        var_dump( $v );
    }
    echo '</pre>';
}

if (!function_exists('mb_str_split')) {
    /**
     * 日本語対応の文字列分割関数
     * @param  [type]  $str       分割元文字列
     * @param  integer $split_len 文字数
     * @return [type]             分割した文字を格納した配列
     */
    function mb_str_split($str, $split_len = 1) {

        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');

        if ($split_len <= 0) {
            $split_len = 1;
        }

        $strlen = mb_strlen($str, 'UTF-8');
        $ret    = array();

        for ($i = 0; $i < $strlen; $i += $split_len) {
            $ret[] = mb_substr($str, $i, $split_len);
        }
        return $ret;
    }
}

################################
## 六三の共通関数(メール)
################################

/**
 * メール送信用関数
 * @param  string $to         メールの宛先
 * @param  string $subject    メールのタイトル
 * @param  string $body       メールの本文
 * @param  string $from_email 送信用のメールアドレス
 * @param  string $from_name  送信者名
 * @return 成功： 失敗：false
 */
function mutSendMail( $to, $subject, $body, $from_email, $from_name ){
    // chenge encode
    $changeEncode = "ISO-2022-JP";

    mb_language('ja');
    $internal_encoding = mb_internal_encoding();
    mb_internal_encoding( $internal_encoding );

    // ヘッダに追加する文字列を格納
    $headers  = "MIME-Version: 1.0 \n" ;
    $headers .= "From: " .
        "". mb_encode_mimeheader( mb_convert_encoding( $from_name, $internal_encoding, "AUTO" ), $changeEncode )
        . "" . "<" . $from_email . "> \n";

    $headers .= "Reply-To: " .
        "". mb_encode_mimeheader( mb_convert_encoding( $from_name, $internal_encoding, "AUTO" ), $changeEncode )
        . "" . "<" . $from_email . "> \n";

    $headers .= "Content-Type: text/plain;charset={$changeEncode} \n";

    /* Convert body to same encoding as stated
    in Content-Type header above */

    $body = mb_convert_encoding( $body, $changeEncode, "AUTO" );

    /* Mail, optional paramiters. */
    // 追加パラメータ
    $sendmail_params  = "-f$from_email";

    // moto
    //$subject = mb_encode_mimeheader( mb_convert_encoding( $subject, $internal_encoding, "AUTO" ), "ISO-2022-JP" );

    $orgEncoding = mb_internal_encoding();  // 元のエンコーディングを保存
    mb_internal_encoding( $changeEncode );// 変換したい文字列のエンコーディングをセット
    $subject = mb_encode_mimeheader( mb_convert_encoding( $subject, $changeEncode, "AUTO" ), $changeEncode, "B", "\r\n" );
    mb_internal_encoding( $orgEncoding );// エンコーディングを戻す

    $result = mail($to, $subject, $body, $headers, $sendmail_params);

    return $result;
}

/**
 * 自動的にHTTPかHTTPSかのアセットURL
 * @author ahmad
 * @param string $path パス
 * @return string
 */
function asset_auto($path){
    return preg_replace('/^https?:/', '', asset($path));
}

/**
 * 自動的にHTTPかHTTPSかのURL
 * @author ahmad
 * @param string $path パス
 * @return string
 */
function url_auto($path){
    return preg_replace('/^https?:/', '', url($path));
}

/**
 * 自動的にHTTPかHTTPSかのアクションURL
 * @author ahmad
 * @param string $controller コントローラー
 * @param string $params パラメーター
 * @return string
 */
function action_auto($controller, $params = []){
    $url = preg_replace('/^https?:/', '', action($controller, $params));
    return preg_replace('/(v2\/.+?\/[0-9]+?\/.+?)\-common/', '$1', $url);
}
