<?php

namespace App\Lib\Util;

use Input;

/**
 * ファイルアップロードのユーティリティー
 *
 * @author yhatsutori
 *
 */
class UploadFileUtil{

    /**
     * コンストラクタ
     */
    private function __construct(){
        // 担当者画面でアップロード可能な拡張子を指定
        $this->extensions = [ 'jpg', 'jpeg', 'png' ];
    }

    /**
     * 保存先のファイルのパスを取得する
     * @param savePath 保存先のディレクトリパス
     * @return 保存先のファイルパス
     */
    public static function save( $savePath ) {
        // ファイルのアップロードされている項目の処理を実行
        if( isset( $_FILES["csv_file"] ) == True && !empty( $_FILES["csv_file"]["size"] ) == True ){
            // ファイルがアップロードできたかを確認
            if( is_uploaded_file( $_FILES["csv_file"]["tmp_name"] ) == true ){
                // 拡張子を取得
                $extension = self::getExtension( $_FILES["csv_file"]["name"] );
                
                if ( $extension == "" || !preg_match( "/csv/i", $extension ) ) {
                    $errMsg .= "この拡張子({$extension})のファイルはアップロードできません。";
                    throw new Exception( $errMsg );
                }

                // ファイル名を取得
                $fileName = date("Y-m-d-H-i") . '_' . $_FILES["csv_file"]["name"];

                // ファイルを保存
                $saveFile = $savePath . '/' . $fileName;
                
                // ディレクトリが存在しなければ、ディレクトリを作成
                if( file_exists( $savePath ) != True ){
                    mkdir( $savePath );
                    chmod( $savePath, 0777 );
                }

                // ファイルの移動
                if( move_uploaded_file( $_FILES["csv_file"]["tmp_name"], $saveFile ) == true ){
                    // 書き込み権限を変更
                    chmod( $saveFile, 0644 );

                }else{
                    $errMsg .= "アップロードに失敗しました。";
                    throw new Exception( $errMsg );
                }
            }
        }

        return $saveFile;

        /*
        // 過去につかっていた処理
        // アップロードされているcsvファイル名を取得
        $file     = Input::file( 'csv_file' );

        $fileName = date("YmdHis").'_'.$file->getClientOriginalName();
        setlocale(LC_ALL, 'ja_JP.UTF-8');

        $file = file_get_contents( $file );
        $target = mb_convert_encoding( $file, 'UTF-8', 'sjis-win' );
        $target = str_replace( '\r\n', '\n', $target );
        //$target = UploadFileUtil::convertEOL($target);
        
        $savePathAndFileName = $savePath . '/' . $fileName;

        $fh = fopen( $savePathAndFileName, 'a+' );
        fwrite( $fh, $target );
        rewind( $fh );

        return $savePathAndFileName;
        */
    }

    /**
     * 拡張子を取得
     * @param  [type] $filename ファイル名
     * @return [type]           拡張子
     */
    public static function getExtension( $filename ) {
        //
        $pos = strrpos( $filename, '.', -1 );

        // 拡張子を取得
        $extension = substr( $filename, $pos, strlen( $filename ) );

        return $extension;
    }
    
    /**
     * [convertEOL description]
     * @param  [type] $string [description]
     * @param  string $to     [description]
     * @return [type]         [description]
     */
    public static function convertEOL( $string, $to='\n' ) {
        return preg_replace( "/\r\n|\r|\n/", $to, $string );
    }

    /**
     * アップロードされた画像ファイル名を取得（拡張子を含む）
     * @param  string $name inputのname属性
     * @return string|null  アップロードされたファイル名
     */
    public static function getImageName($name)
    {
        if (! \Request::hasFile($name)) {
            return null;
        }

        return \Request::file($name)->getClientOriginalName();
    }

    /**
     * アップロードされたファイル名の拡張子を取得
     * @param  string $file_name ファイル名
     * @return string|Exception  拡張子
     */
    public static function getImageExtension($file_name)
    {
        $extension = \File::extension($file_name);

        if (empty($extension)) {
            throw new \Exception("拡張子を判別できませんでした。\n選択したファイルの拡張子を確認してください。");
        }

        return \File::extension($file_name);
    }

    /**
     * 画像ファイルを保存するパスを取得
     * @param  string $name inputのname属性
     * @param  string $path 保存するディレクトリ
     * @return string       保存するパス
     */
    public static function getImagePath($name, $path)
    {
        $file_name = self::getImageName($name);

        return $path.'/'.$file_name;
    }

    /**
     * アップロードされた画像ファイルを移動させる処理
     * @param  string $name   inputのname属性
     * @param  string $path   保存するパス
     * @param  string $rename ファイル名の変更
     */
    public static function moveImage($name, $path, $rename='')
    {
        if (! \Request::hasFile($name)) {
            return false;
        }

        $file_name = self::getImageName($name);
        if (is_null($file_name)) {
            return false;
        }

        if (! empty($rename)) {
            \Request::file($name)->move($path, public_path($path).'/'.$rename);
        } else {
            \Request::file($name)->move($path, public_path($path).'/'.$file_name);
        }
    }

}
