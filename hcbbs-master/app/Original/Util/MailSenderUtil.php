<?php

namespace App\Original\Util;

/**
 * メール送信のライブラリー
 *
 * @author ahmad
 */
class MailSenderUtil
{
    /**
     * AWSサービスでメール送信をする
     * MailSendAddress  宛先のメールアドレス（カンマで区切る）
     * mail_format      本文
     * MailSubject      件名
     * MailName         送信者名
     * @param array $cfg APIのパラメーター
     * @return string 送信ステータス
     */
    public static function awsSendMail( $cfg ) {
        // 内容の文字変換
        $cfg['mail_format'] = mb_convert_encoding(
            $cfg['mail_format'],
            'Shift-JIS', 'UTF-8'
        );
        // 件名の文字変換
        $cfg['MailSubject'] = mb_convert_encoding(
            $cfg['MailSubject'],
            'Shift-JIS', 'UTF-8'
        );
        // 名前の文字変換
        $cfg['MailName'] = mb_convert_encoding(
            $cfg['MailName'],
            'Shift-JIS', 'UTF-8'
        );
        
        // メールデータ
        $mailData = $cfg;
        $mailData = http_build_query($mailData, "", "&");

        // ヘッダー
        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Content-Length: " . strlen($mailData)
        );

        // コンテクスト
        $context = array(
            "http" => array(
                "method" => "POST",
                "header" => implode("\r\n", $header),
                "MailSendAddress" => $cfg['MailSendAddress'],
                "content" => $mailData
            )
        );

        // AWSサービスでメール送信
        $url = 'https://secure.hondanet.co.jp/common-php/aws_sender.php';
        $result = file_get_contents($url, false, stream_context_create($context));
        
        return $result;
    }
    
}
