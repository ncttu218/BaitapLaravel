<?php

/**
 * プログラム内共通の関数
 */

/**
 * cURLデータを取得する。
 * @param string $url URL
 * @param array $options オプション
 */
function http_get_contents($url, $options = []) {
    // クッキー
    if (!isset($options['useCookie'])) {
        $options['useCookie'] = true;
    }
    // タイムアウト
    $timeout = 500;
    if (isset($options['timeout'])) {
        $timeout = (int)$options['timeout'];
    }
    // 添付ファイル情報
    $attachments = [];
    if (isset($options['attachments'])) {
        $filePath = $options['attachments'][0]['path'];
        $fileName = $options['attachments'][0]['name'];
        $fileType = $options['attachments'][0]['type'];
        // ファイルの情報をCURLデータに変換
        if (function_exists('curl_file_create')) {
            $curlFile = curl_file_create($filePath, $fileType, $fileName);
            $attachments = array('file' => $curlFile);
        }
    }
    
    $ch = curl_init();
    // オプション
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_URL, $url);
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    }
    if (isset($_SERVER['HTTP_REFERER'])) {
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // プロキシサーバー
    if (isset($options['proxy'])) {
        curl_setopt($ch, CURLOPT_PROXY, $options['proxy']['host']);
        curl_setopt($ch, CURLOPT_PROXYPORT, $options['proxy']['port']);
    }

    // クッキーヘッダー
    if ($options['useCookie'] === true) {
        curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
        $cookie_header = "Cookie:";
        $headers = [];
        foreach($_COOKIE as $key => $value) {
            $cookie_header .= " {$key}={$value};";
        }
        $headers[] = $cookie_header;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    // 添付ファイル情報を登録
    if (count($attachments) > 0) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $attachments);
    }

    // 実行
    $retval = curl_exec($ch);

    if (curl_errno($ch)) {
            return 'Request Error: ' . curl_error($ch);
    }

    curl_close($ch);

    if (FALSE === $retval) {
        return FALSE;
    } else {
        return $retval;
    }
}

/**
 * テキストをHTML改行があるかをチェックする
 * @param string $content 内容
 * @return boolean
 */
function has_no_nl($content) {
    if (preg_match('/<html.*?>/', $content)) {
        return false;
    }
    return !preg_match('/<(?:br|p)\s*?\/?>/', $content);
}

/**
 * ユニコードのテキストを基準化
 * @param string $str テキスト
 * @return string
 */
function urlencode_unicode($str) {
    // ファイル名を基準化
    $str = urlencode($str);
    $str = str_replace('%28', '_', $str);
    $str = str_replace('%29', '_', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('+', '20', $str);
    return $str;
}
    
/**
 * フォルダーと中身を削除する
 * @param string $target パス
 */
function rmdir_recursively($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK );

        foreach( $files as $file ){
            rmdir_recursively( $file );      
        }

        @rmdir( $target );
    } elseif(is_file($target)) {
        @unlink( $target );  
    }
}

if (!function_exists('http_arg_url')) {
    /**
     * 配列パラメーターパラメーターからURLを作成
     * @param array $data URLパラメーターのデータ
     * @param array|string $blacklist URLパラメーターのブラックリスト
     * @return string
     */
    function http_arg_url(array $data, $blacklist = array()) {
        if (!is_array($blacklist)) {
            $blacklist = [$blacklist];
        }
        if (!empty($blacklist)) {
            $data = array_diff_key($data, array_flip($blacklist));
        }
        return http_build_query($data);
    }
}

?>