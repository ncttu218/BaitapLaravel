<?php

namespace App\Http\Controllers\Infobbs;

use App\Http\Controllers\Controller;
use App\Original\Util\SessionUtil;
use Request;
use DB;
use Image;

/**
 * 画面アップロード機能（本文中）コントローラー
 *
 * @author M.ueki
 *
 */
class ImageTmpController extends Controller {
    /**
     * コンストラクタ
     */
    public function __construct() {
    }

    /**
     * 画面表示
     * @return string
     */
    public function getIndex(){
        return view('infobbs.image_tmp')
            ->with('upload','off')
            ->with('msg','')
            ->with('urlAction',action_auto('Infobbs\ImageTmpController' . '@postUpload'));
    }

    /**
     * 画像ファイル取得
     * @return string
     */
    public function postUpload(){
        $req = Request::all();

        $upload = 'on';
        $msg = '';

        if(isset($req['file'])){
            $fileName = $this->makeImage2($req['width']);

            if($fileName[0] == -1){
                // ファイルタイプ不可
                $msg = "このファイルタイプ($fileName[1])のアップロードには対応していません。";
                $upload = 'off';
            }
        }

        return view('infobbs.image_tmp')
            ->with('upload',$upload)
            ->with('msg',$msg)
            ->with('fileName',$fileName[0])
            ->with('width',$req['width'])
            ->with('urlAction',action_auto('Infobbs\ImageTmpController' . '@postUpload'));
    }

    /**
     * 画像ファイル生成(Laravel Imageプラグイン)
     * @param  integer $width     画像横幅
     * @return array   [エラー,ファイル名]
     */
    protected function makeImage($width)
    {
        // ユーザ情報
        $loginAccountObj = SessionUtil::getUser();

        $file = Request::file('file');
        // ファイル名取得
        $fileOrg = $file->getClientOriginalName();
        // 拡張子なし
        if(strpos($fileOrg,'.') == 0){
            // 拡張子なし
            return [-1,' '];
        }
        // 拡張子取得
        $ext = substr($fileOrg, strrpos($fileOrg, '.') + 1);
        // ファイル情報取得
        $fileInfo = getimagesize($file);
        if(!$fileInfo){
            // 画像ファイル以外
            return [-1,$ext];
        }
        if($fileInfo[2] != IMAGETYPE_JPEG AND
           $fileInfo[2] != IMAGETYPE_GIF AND
           $fileInfo[2] != IMAGETYPE_PNG
               ){
            // 画像タイプ不可
            return [-1,$ext];
        }

        // ファイル名生成
        $tableNo = $loginAccountObj->gethanshaCode();
        $path = Config('original.dataImage') . $tableNo;
        $msStr = explode(".", (microtime(true)))[1];//ミリ秒
        $inFileName = $tableNo . '_' . date("Ymd_His") . '_' . $msStr .'.' .$ext;
        $outFileName = $tableNo . '_' . date("Ymd_His") . '_' . $msStr . '_free' .'.' .$ext;

        // ファイル取り込み
        $file->move($path,$inFileName);

        // 画像リサイズ
        $inFile = $path . '/' . $inFileName;
        $outFile = $path . '/' . $outFileName;

        $size = GetImageSize($inFile);      //　元画像サイズ取得
        // 高さ計算
        $rate = $width / $size[0];
        $height = round($size[1] * $rate);

        // 画像リサイズ
        Image::make($inFile)
            ->resize($width, $height)
            ->save($outFile);

        // 一時ファイル削除
        unlink($inFile);

        return [$outFile];
    }
    
    /**
     * 画像ファイル生成(PHP版)
     * @param  integer $width     画像横幅
     * @return array   [エラー,ファイル名]
     */
    protected function makeImage2($width)
    {
        // ユーザ情報
        $loginAccountObj = SessionUtil::getUser();

        $file = Request::file('file');
        // ファイル名取得
        $fileOrg = $file->getClientOriginalName();
        // 拡張子なし
        if(strpos($fileOrg,'.') == 0){
            // 拡張子なし
            return [-1,' '];
        }
        // 拡張子取得
        $ext = substr($fileOrg, strrpos($fileOrg, '.') + 1);
        // ファイル情報取得
        $fileInfo = getimagesize($file);
        if(!$fileInfo){
            // 画像ファイル以外
            return [-1,$ext];
        }
        if($fileInfo[2] != IMAGETYPE_JPEG AND
           $fileInfo[2] != IMAGETYPE_GIF AND
           $fileInfo[2] != IMAGETYPE_PNG
               ){
            // 画像タイプ不可
            return [-1,$ext];
        }

        // ファイル名生成
        $tableNo = $loginAccountObj->gethanshaCode();
        $path = Config('original.dataImage') . $tableNo;
        $msStr = explode(".", (microtime(true)))[1];//ミリ秒
        $inFileName = $tableNo . '_' . date("Ymd_His") . '_' . $msStr .'.' .$ext;
        $outFileName = $tableNo . '_' . date("Ymd_His") . '_' . $msStr . '_free' .'.' .$ext;

        // ファイル取り込み
        $file->move($path,$inFileName);

        // 画像リサイズ
        $inFile = $path . '/' . $inFileName;
        $outFile = $path . '/' . $outFileName;

        $size = GetImageSize($inFile);      //　元画像サイズ取得
        // 高さ計算
        $rate = $width / $size[0];
        $height = round($size[1] * $rate);

        $out = ImageCreateTrueColor($width, $height);

        //　元画像ファイル読み込み
        switch ($fileInfo[2]){
            case IMAGETYPE_JPEG:
                $in = ImageCreateFromJPEG($inFile); 

                break;
            case IMAGETYPE_GIF:
                $in = ImageCreateFromGIF($inFile);
                
                break;
            case IMAGETYPE_PNG:
                imagealphablending($out, false);
                imagesavealpha($out, true);
                $in = ImageCreateFromPNG($inFile);

                break;
        }

        //　サイズ変更・コピー
        ImageCopyResampled($out, $in, 0, 0, 0, 0, $width, $height, $size[0], $size[1]); 

        //　画像保存
        switch ($fileInfo[2]){
            case IMAGETYPE_JPEG:
                ImageJPEG($out, $outFile);
                
                break;
            case IMAGETYPE_GIF:
                $bgcolor = imagecolorallocatealpha($in,0,0,0,127);
                imagefill($out, 0, 0, $bgcolor);
                imagecolortransparent($out,$bgcolor);
                ImageGIF($out, $outFile);
                
                break;
            case IMAGETYPE_PNG:
                ImagePNG($out, $outFile);
                
                break;
        }

        ImageDestroy($in);
        ImageDestroy($out);
        // tmpファイル削除
        unlink($path . '/' . $inFileName);

        return [$outFile];
    }

}