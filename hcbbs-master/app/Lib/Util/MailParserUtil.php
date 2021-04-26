<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Util;

use Phemail\MessageParser;

/**
 * Description of MailParserUtil
 *
 * @author ahmad
 */
class MailParserUtil {
    
    /**
     * 添付ファイルがないメッセージ
     */
    const MESSAGE_ATTACHMENT_TYPE_NONE = 0;
    
    /**
     * 連携する画像、添付ファイルがあるメッセージ 
     */
    const MESSAGE_ATTACHMENT_TYPE_RELATED = 1;
    
    /**
     * 代替する画像、添付ファイルがあるメッセージ 
     */
    const MESSAGE_ATTACHMENT_TYPE_ALTERNATE = 2;
    
    /**
     * メールID
     * 
     * @var string
     */
    public $messageTempDirname;
    
    /**
     * 店舗名
     * 
     * @var string
     */
    public $baseName;
    
    /**
     * メッセージの月
     * 
     * @var string
     */
    public $month;
    
    /**
     * 一般的なメールフォーマット
     * 
     * @var int
     */
    const MAIL_DEVICE_GENERAL = 0;
    
    /**
     * iPadで送信されるメールのフォーマット
     * 
     * @var int
     */
    const MAIL_DEVICE_IPAD = 1;
    
    /**
     * Microsoft Outlookで送信されるメールのフォーマット
     * 
     * @var int
     */
    const MAIL_DEVICE_OUTLOOK = 2;
    
    /**
     * メールのフォーマット
     * 
     * @var int
     */
    public $deviceType = self::MAIL_DEVICE_GENERAL;
    
    /**
     * メッセージを表示する
     * 
     * @param string $message
     */
    private function comment($message) {
        echo $message . PHP_EOL;
    }
    
    /**
     * メールファイルのメール情報を取得する
     * 
     * @param string $path メールファイルのパス
     * @return array
     */
    public function parseEmailFile($path) {
        // メールファイルを解析する
        $parser = new MessageParser();
        $message = $parser->parse($path);
        
        // ファイル内容
        $fileContent = file_get_contents($path);
        
        ########################################################################
        # 画像ファイル名に変な文字列が入ったらファイル名を変換する
        ########################################################################
        $pattern = '/((?:file)?name=")(.*?\.[jJpPeEgGiIfFnN]+)(")/';
        if (preg_match($pattern, $fileContent, $match)) {
            // 文字列を検索する
            $names = [];
            $fileContent = preg_replace_callback($pattern, function($match)
                    use (&$names) {
                $name = $match[2];
                $newName = \App\Original\Util\ImageUtil::normalizeFileName($name, false);
                // 一覧に入れる
                $names[$name] = $newName;
                return $match[1] . $newName . $match[3];
            }, $fileContent);
            // 文字列を置換する
            foreach ($names as $find => $replacemnet) {
                $fileContent = str_replace($find, $replacemnet, $fileContent);
                // HTMLの中
                $find = htmlentities($find);
                $find = str_replace('\'', '&#39;', $find);
                $fileContent = str_replace($find, $replacemnet, $fileContent);
            }
            // 再生成
            $arr = preg_split("/\r\n|\n|\r/", $fileContent);
            $parser = new MessageParser();
            $message = $parser->parse($arr);
        }
        ########################################################################
        
        ########################################################################
        # デバイスの対応
        ########################################################################
        // iPadデバイスに対応するマーク
        if ($message->getHeaderValue('content-type') == 'multipart/mixed' &&
                preg_match('/iPad Mail/', $message->getHeaderValue('x-mailer'))) {
            $this->deviceType = self::MAIL_DEVICE_IPAD;
        } else if (preg_match('/[Oo]utlook/', $message->getHeaderValue('x-mailer'))) {
            $this->deviceType = self::MAIL_DEVICE_OUTLOOK;
            // 余計なタグを削除
            $string = preg_replace('/<\/?xml>/', '', $fileContent);
            $string = preg_replace('/<[a-z]+?\:[a-z]+?\s[\w\W]+?>[\w\W]+?<\/[a-z]+?\:[a-z]+?>/', '', $string);
            $string = preg_replace('/<!--\[if.+?\]>[\w\W]+?<!\[endif\]-->/', '', $string);
            $string = preg_replace('/<style>[\w\W]*?<!--/', '<style>', $string);
            $string = preg_replace('/-->[\w\W]*?<\/style>/', '</style>', $string);
            // 構成を再作成
            $arr = preg_split("/\r\n|\n|\r/", $string);
            $parser = new MessageParser();
            $message = $parser->parse($arr);
        }
        ########################################################################

        // 件名を記事のタイトルに
        $mailSubject = $this->decodeHeaderText($message->getHeaderValue('subject'));

        // 送信者
        $fromObj = imap_rfc822_parse_headers('From: ' . $message->getHeaderValue('from'));
        $fromObj = $fromObj->from[0];
        // メールアドレス
        $mailAddr = "{$fromObj->mailbox}@{$fromObj->host}";
        // 名前
        $senderName = $this->decodeHeaderText($fromObj->personal ?? '');
            
        // 転送メールのチェック
        // 宛先
        $toObj = imap_rfc822_parse_headers('To: ' . $message->getHeaderValue('to'));
        $toObj = $toObj->to[0];
        // 名前
        $recipientName = $this->decodeHeaderText($toObj->personal ?? '');
        // メールアドレス
        $recipientAddr = "{$toObj->mailbox}@{$toObj->host}";
        
        // メールの日時
        $mailTime = date('YmdHis', strtotime($message->getHeaderValue('date')));
        
        return compact([
            'message',
            'mailSubject',
            'mailAddr',
            'senderName',
            'fromObj',
            'toObj',
            'recipientName',
            'recipientAddr',
            'mailTime'
        ]);
    }
    
    /**
     * ヘッダーのテキストを置換する
     * 
     * @param string $string ヘッダーのテキスト
     */
    private function decodeHeaderText($string) {
        $string = preg_replace_callback('/=\?(.+?)\?B\?(.*?)\?=/', function ($match) {
            return mb_convert_encoding(base64_decode($match[2]), 'UTF-8', $match[1]);
        }, $string);
        return $string;
    }
    
    /**
     * メールの内容を解析する
     * 
     * @param object $message メッセージのオブジェクト
     * @param Closure $onMultipartFoundCallback 添付ファイルがあるコールバック
     * @return string
     */
    public function parseMailContent($message, $onMultipartFoundCallback = null) {
        // 本文
        $body = '';
        $images = [];
        $this->parseMailBody($message, $body, $images);
        // 画像
        if ($this->deviceType !== self::MAIL_DEVICE_IPAD) {
            $_body = null;
            $this->parseMailImages($message, $images, $_body);
        }
        
        $images = $this->retrieveAttachmentFiles($images);
        // コールバック
        if ($onMultipartFoundCallback !== null) {
            return $onMultipartFoundCallback($body, $images);
        }
    }
    
    /**
     * 本文パーシング処理
     * 
     * @param object $message
     * @param string $body
     */
    private function parseMailBody($message, &$body, &$images) {
        $contentType = $message->getHeaderValue('content-type');
        if ($this->deviceType === self::MAIL_DEVICE_OUTLOOK) {
            $doParsing = $contentType === 'text/html';
        } else {
            $doParsing = $contentType === 'text/html' || $contentType === 'text/plain';
        }
        
        if ($doParsing) {
            $contents = trim($message->getContents());
            if (!empty($contents)) {
                // 暗号化
                $contentTransferEnc = $message->getHeaderValue('content-transfer-encoding');
                // HTMLに対応
                if ($contentType === 'text/html') {
                    $contents = quoted_printable_decode($contents);
                }
                // BASE64の暗号化
                $charset = $message->getHeaderAttribute('content-type', 'charset');
                if ($contentTransferEnc === 'base64') {
                    $contents = base64_decode($contents);
                } else if ($this->deviceType === self::MAIL_DEVICE_OUTLOOK) {
                    // Microsoft Outlookでの文字変換
                    $contents = preg_replace_callback('/\e.+?\e\(B/', function ($match)
                            use ($charset) {
                        return mb_convert_encoding($match[0], 'UTF-8', $charset);
                    }, $contents);
                } else if (!empty ($charset)) {
                    // charsetがあるメールに対応
                    $contents = mb_convert_encoding($contents, 'UTF-8', $charset);
                }
                
                if ($this->deviceType !== self::MAIL_DEVICE_IPAD) {
                    $body = $contents;
                } else {
                    $body .= $contents;
                }
            }
        } else if ($this->deviceType === self::MAIL_DEVICE_IPAD &&
                preg_match('/^image\\//', $contentType)) {
            $this->parseMailImages($message, $images, $body);
        }
        
        $parts = $message->getParts();
        foreach ($parts as $i => $messagePart) {
            $this->parseMailBody($messagePart, $body, $images);
        }
    }
    
    /**
     * 画像パーシング処理
     * 
     * @param object $message メールデータ
     * @param array $images 画像
     */
    private function parseMailImages($message, &$images, &$body) {
        $contentType = $message->getHeaderValue('content-type');
        if (preg_match('/^image\\//', $contentType)) {
            $images[] = $message;
        }
        if ($body !== null) {
            $attachmentId = count($images) - 1;
            $body .= '<img src="cid:' . $attachmentId . '" style="width: 100%;">';
        }
        $parts = $message->getParts();
        foreach ($parts as $i => $messagePart) {
            $this->parseMailImages($messagePart, $images, $body);
        }
    }
    
    /*public function parseMailContent($message, $onMultipartFoundCallback = null) {
        $parts = $message->getParts();
        $contentType = $message->getHeaderValue('content-type');
        $mailContent = '';
        
        if (count($parts) > 0) {
            // 添付ファイルがあるかを確認する
            $mainPartIndex = -1;
            // 添付タイプ
            $attachmentType = self::MESSAGE_ATTACHMENT_TYPE_NONE;
            
            foreach ($parts as $i => $messagePart) {
                $contentType = $messagePart->getHeaderValue('content-type');
                
                // 内容タイプのチェック
                if (preg_match('/^multipart\/related$/', $contentType)) {
                    // 配列のIDを返す
                    $mainPartIndex = $i;
                    // 添付タイプ
                    $attachmentType = self::MESSAGE_ATTACHMENT_TYPE_RELATED;
                    break;
                } else if (preg_match('/^multipart\/alternative$/', $contentType)) {
                    // 配列のIDを返す
                    $mainPartIndex = $i;
                    // 添付タイプ
                    $attachmentType = self::MESSAGE_ATTACHMENT_TYPE_ALTERNATE;
                    break;
                }
            }
            
            // 添付ファイルがある場合
            if ($mainPartIndex > -1) {
                $mainPart = $parts[$mainPartIndex];
                
                // 代替する添付の場合
                if ($attachmentType === self::MESSAGE_ATTACHMENT_TYPE_ALTERNATE) {
                    $parts = array_slice($parts, $mainPartIndex + 1);
                    if (count($parts) == 0) {
                        $parts = $message->getAttachments();
                    }
                } else {
                    $parts = [];
                }
                
                // 解析する
                $mailContent = $this->getMailContentByContentType(
                    $mainPart,
                    $parts,
                    $attachmentType,
                    $onMultipartFoundCallback
                );
            } else {
                // 添付ファイルがない場合
                $mailContent = $this->getMailContentByContentType($message, $parts);
            }
        } else {
            $mailContent = $this->getMailContentByContentType($message);
        }
        
        return $mailContent;
    }*/
    
    /**
     * 内容タイプによってメール内容を解析する
     * 
     * @param object $message メッセージのオブジェクト
     * @param array $parts メッセージ内容の配列
     * @param int $attachmentType 添付ファイルのタイプ
     * @param Closure $onMultipartFoundCallback 添付ファイルがあるコールバック
     * @return array
     */
    private function getMailContentByContentType(
        $message,
        $parts = [],
        $attachmentType = self::MESSAGE_ATTACHMENT_TYPE_NONE,
        $onMultipartFoundCallback = null
    ) {
        $contentType = $message->getHeaderValue('content-type');
        $files = [];
        
        if ($attachmentType == self::MESSAGE_ATTACHMENT_TYPE_RELATED ||
                $attachmentType == self::MESSAGE_ATTACHMENT_TYPE_ALTERNATE) {
            // 添付ファイルがあるメッセージ内容の配列
            $messageParts = $message->getParts();
            
            // メール内容
            $text = '';
            
            // 添付ファイル
            if ($attachmentType == self::MESSAGE_ATTACHMENT_TYPE_RELATED) {
                $attachments = array_splice($messageParts, 1);
                
                $content = $messageParts[0]->getContents();
                // 暗号化
                $contentTransferEnc = $messageParts[0]->getHeaderValue('content-transfer-encoding');
                // BASE64の暗号化
                if ($contentTransferEnc === 'base64') {
                    $content = base64_decode($content);
                }

                // 変換する
                $text .= quoted_printable_decode($content);
            } else if ($attachmentType == self::MESSAGE_ATTACHMENT_TYPE_ALTERNATE) {
                $attachments = $parts;
                foreach ($messageParts as $messagePart) {
                    // 平分をスキップ
                    $contentType = $messagePart->getHeaderValue('content-type');
                    if ($contentType == 'text/plain') {
                        continue;
                    }
                    
                    $content = $messagePart->getContents();
                    
                    // 暗号化
                    $contentTransferEnc = $messagePart->getHeaderValue('content-transfer-encoding');
                    // BASE64の暗号化
                    if ($contentTransferEnc === 'base64') {
                        $content = base64_decode($content);
                    }

                    // 変換する
                    $text .= quoted_printable_decode($content);
                }
            } else {
                return;
            }
            
            // コールバック
            if ($onMultipartFoundCallback !== null) {
                $files = $this->retrieveAttachmentFiles($attachments);
                // 置換されたメール内容を戻す
                $text = $onMultipartFoundCallback($text, $files);
            }
        } else if ($attachmentType == self::MESSAGE_ATTACHMENT_TYPE_NONE) {
            switch ($contentType) {
                // 内容がHTML
                case 'text/html':
                    $text = quoted_printable_decode($message->getContents());
                    break;

                // 内容が平分
                case 'text/plain':
                    if (count($parts) > 0) {
                        $text = nl2br(base64_decode($message->getContents()));
                    } else {
                        $text = $message->getContents();
                    }
                    break;

                // その他の内容
                default:
                    $text = $message->getContents();
                    break;
            }
        }
        
        return $text;
    }

    /**
     * メールに添付されたファイルを取得する
     * @param array $attachments 添付ファイル
     */
    private function retrieveAttachmentFiles($attachments) {
        $files = [];
        $count = count($attachments);
        $this->comment("{$count}件画像の保存中");

        foreach ($attachments as $i => $attachment) {
            // 画像ファイル名
            $attachmentName = $attachment->getHeaderAttribute('content-type', 'name');
            $attachmentName = $this->decodeHeaderText($attachmentName);
            $attachmentName = urlencode_unicode($attachmentName);
                
            if ($this->deviceType !== self::MAIL_DEVICE_IPAD) {
                // 添付ファイルのIDの判定
                // Thunderbirdからのメール
                $attachmentId = $attachment->getHeaderValue('x-attachment-id');
                if ($attachmentId === null) {
                    // Web上からのメール
                    $attachmentId = $attachment->getHeaderValue('content-id');
                    $attachmentId = preg_replace('/<(.+?)>/', '$1', $attachmentId);
                }
            } else {
                // 添付ファイルのIDの判定
                $attachmentId = $i;
                // 画像ファイル名
                $attachmentName = $i . '.' . pathinfo($attachmentName)['extension'];
            }
            // MIMEタイプ
            $mimeType = $attachment->getHeaderValue('content-type');

            // 画像以外のファイルをスキップ
            if (!preg_match('/^image\//', $mimeType)) {
                continue;
            }

            // ファイルの内容
            $content = base64_decode($attachment->getContents());
            // フォルダーが存在しない場合、作成する
            if (!file_exists($this->messageTempDirname)) {
                mkdir($this->messageTempDirname, 0777, true);
            }
            
            // ファイル名のチェック
            $attachmentName = \App\Original\Util\ImageUtil::normalizeFileName($attachmentName);

            // 画像のファイルパス
            $imageFilePath = "{$this->messageTempDirname}/{$attachmentName}";
            // 画像ファイルを書き込む
            file_put_contents($imageFilePath, $content);
            @chmod($imageFilePath, 0777);

            // 画像ファイルのパスを配列
            $imageFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $imageFilePath);
            $files[$attachmentId] = str_replace('/', DIRECTORY_SEPARATOR, $imageFilePath);
        }
        return $files;
    }
}
