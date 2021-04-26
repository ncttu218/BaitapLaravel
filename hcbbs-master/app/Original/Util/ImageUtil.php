<?php

namespace App\Original\Util;

use Exception;
use Request;
/*use Imagick;
use ImagickPixel;*/

/**
 * 画像処理のライブラリー
 */
class ImageUtil
{
    /**
     * 画像の幅の制限
     * 
     * @var int
     */
    const MAX_IMAGE_WIDTH = 800;
    
    /**
     * 幅800pxの画像サーバー
     */
    const IMAGE_UPLOADING_URL_800 = 'http://image.hondanet.co.jp/cgi/upload_img.php';
    
    /**
     * 幅1500pxの画像サーバー
     */
    const IMAGE_UPLOADING_URL_1500 = 'http://image.hondanet.co.jp/cgi/upload_img1500.php';
    
    /**
     * 
     * @param string $inFile 画像のソース
     * @param string $outFile 保存先
     */
    public static function resizeAndFixOrientation($inFile, $outFile, $maxWidth = self::MAX_IMAGE_WIDTH)
    {
        $imageInfo = getimagesize($inFile);
        $imageType = $imageInfo[2];
        
        // Orientation
        $orientation = null;
        if ($imageType == IMAGETYPE_JPEG) {
            // EXIF情報がエラー時、スキップ
            try {
                $exif = exif_read_data($inFile);
            } catch (\Exception $ex) {
            }
            // EXIF情報にオリエンテーション値がある場合
            if (isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
            }
        }
        
        // Get new dimensions
        list($width_orig, $height_orig) = $imageInfo;
        $height = (int) (($maxWidth / $width_orig) * $height_orig);
        // リサンプリング
        if ($width_orig > $maxWidth) {
            $image_p = imagecreatetruecolor($maxWidth, $height);
        } else {
            $image_p = imagecreatetruecolor($width_orig, $height_orig);
        }
        
        //　元画像ファイル読み込み
        switch ($imageType){
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($inFile); 

                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($inFile);
                
                break;
            case IMAGETYPE_PNG:
                imagealphablending($image_p, false);
                imagesavealpha($image_p, true);
                $image = imagecreatefrompng($inFile);

                break;
        }
        
        // リサイズ
        if ($width_orig > $maxWidth) {
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $maxWidth, $height,
                    $width_orig, $height_orig);
        } else {
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_orig, $height_orig,
                    $width_orig, $height_orig);
        }
        
        // Fix Orientation
        if ($orientation !== null) {
            switch($orientation) {
                case 3:
                case 4:
                    $image_p = imagerotate($image_p, 180, 0);
                    break;
                case 6:
                case 5:
                    $image_p = imagerotate($image_p, -90, 0);
                    break;
                case 8:
                case 7:
                    $image_p = imagerotate($image_p, 90, 0);
                    break;
            }
        }
        
        //　画像保存
        switch ($imageType){
            case IMAGETYPE_JPEG:
                imagejpeg($image_p, $outFile);
                
                break;
            case IMAGETYPE_GIF:
                $bgcolor = imagecolorallocatealpha($image, 0, 0, 0, 127);
                imagefill($image_p, 0, 0, $bgcolor);
                imagecolortransparent($image_p, $bgcolor);
                imagegif($image_p, $outFile);
                
                break;
            case IMAGETYPE_PNG:
                imagepng($image_p, $outFile);
                
                break;
        }
        
        imagedestroy($image_p);
        imagedestroy($image);
    }
    
    /**
     * 
     * 参考：https://qiita.com/RichardImaokaJP/items/385beb77eb39243e50a6
     * 
     * @param string $dest 画像ファイル名
     */
    /*public static function normalizeOrientation( $src, $dest )
    {
        $src = realpath($src);
        if (!file_exists($src)) {
            throw new Exception('画像ファイルは存在しません：' . $src);
        }
        
        $image = new Imagick($src);
        $profiles = $image->getImageProfiles('icc', true);
        $exif = $image->getImageProperties('exif:*');
        $orientation = $exif['exif:Orientation'] ?? 0;
        
        if ($orientation < 3 || $orientation > 8) {
            return;
        }
        $image->stripImage();
        
        switch ( $orientation ) {
            case 3:
            case 4: // 反転
                $image->rotateimage(new ImagickPixel('#FFFFFF'), 180);
                break;
            case 6:
            case 5: // 反転
                $image->rotateimage(new ImagickPixel('#FFFFFF'), 90);
                break;
            case 8:
            case 7: // 反転
                $image->rotateimage(new ImagickPixel('#FFFFFF'), 270);
                break;
        }
        
        // 画像データをファイルに書き込む
        if(!empty($profiles)) {
            $image->profileImage('icc', $profiles['icc']);
        }
        
        $image->writeImage( $dest );
        $image->clear();
    }*/
    
    /**
     * 
     * @param string $base64
     * @param string $src
     * @param string $dest
     */
    /*private static function base64ToImage( $base64, $dest )
    {
        $imageBlob = base64_decode($base64);

        $image = new Imagick();
        $image->readImageBlob($imageBlob);
        
        $image->writeImage( $dest );
        $image->clear();
    }*/


    /**
     * 文字列からbase64を使う画像を検索して、保存する関数
     * 
     * @param string $string
     * @param string $dirname
     * @return void
     */
    public static function base64ToImageFromString( $string, $dirname, $tableNo, $tableType='infobbs', $isSimulation = false )
    {
        $matches = [];
        $pattern = '/data:(image\/.+?);base64,([a-zA-Z0-9\+\/\=]+)/';
        $images = [];
        $replacer = function ( $match ) use ( $dirname, &$index, &$images, $isSimulation, $tableNo, $tableType ) {
            // ファイル名を生成
            $mimeType = $match[1];
            $extension = 'jpg';
            switch ($mimeType) {
                case 'image/png':
                    $extension = 'png';
                    break;
                case 'image/gif':
                    $extension = 'gif';
                    break;
            }
            $filename = 'base64_' . $index . '.' . $extension;
            $dest = $dirname . DIRECTORY_SEPARATOR . $filename;
            $index++;
            
            // 画像データをファイルに保存
            if (!$isSimulation) {
                $base64str = $match[2];
                // self::base64ToImage($base64str, $dest);
                file_put_contents($dest, base64_decode($base64str));
            }
            $path = self::adjustImage($dest, 0, $tableNo, $tableType, false, $isSimulation);
            @unlink($dest);
            
            $url = asset_auto($path);
            $images[] = $url;
            return $url . '"';
        };
        $index = 0;
        $string = preg_replace_callback($pattern, $replacer, $string);
        if ($isSimulation) {
            return [
                'content' => $string,
                'images' => $images,
            ];
        }
        return $string;
    }
    
    /**
     * 画像ファイル取得
     * @param  integer $fileNo    ファイルリクエストNo
     * @param  string $no         ファイル名No
     * @return string 出力ファイル名
     */
    public static function makeImage( $fileNo, $no, $tableNo, $tableType = 'infobbs', $oldName = '', $maxWidth = self::MAX_IMAGE_WIDTH )
    {
        // ファイル取り込み
        $file = Request::file($fileNo);
        
        return self::adjustImage( $file, $no, $tableNo, $tableType, true, false, $oldName, $maxWidth );
    }
    
    /**
     * ローカルにある画像を調整する
     * @param string $src 画像ファイルパス
     * @param string $publicDir 公開フォルダー名
     * @param string $tableNo 販社コード
     * @param string $tableType システム名
     * @return boolean|string 生成した画像ファイル名
     */
    public static function copyAndAdjustLocalImage($src, $publicDir, $tableNo, $tableType = 'infobbs') {
        // ディレクトリパス
        $dirName = config('original.dataImage') . $tableNo;
        $path = $dirName;
        if ($publicDir !== null) {
            $path = base_path() . '/' . $publicDir . '/' . $dirName;
        }
        
        $fileInfo = getimagesize($src);
        if($fileInfo[2] != IMAGETYPE_JPEG AND
            $fileInfo[2] != IMAGETYPE_GIF AND
            $fileInfo[2] != IMAGETYPE_PNG
        ){
            // 画像タイプ不可
            return false;
        }
        
        $ext = substr($src, strrpos($src, '.') + 1); // 拡張子
        $msStr = explode(".", (microtime(true)))[1];//ミリ秒
        // 保存する画像ファイル名
        $filename = $tableNo . '_' . $tableType . '_' . date("Ymd_His") . '_' . 
            $msStr . '.' . $ext;
        $dst = $path . '/' . $filename;
        
        // フォルダチェック、なければフォルダ作成
        if(!file_exists($path)){
            mkdir($path, 0777);
        }
        
        // 画像をリサイズして、自動的に回転
        self::resizeAndFixOrientation($src, $dst);
        
        return $dirName . '/' . $filename;
    }


    /**
     * 画像を調整
     * 
     * @param string $file
     * @param int $no
     * @param int $tableNo
     * @param bool $isStream
     * @param bool $isSimulation
     * @param string $oldName
     * @return object
     */
    private static function adjustImage( $file, $no, $tableNo, $tableType='infobbs', $isStream = true, $isSimulation = false, $oldName = '', $maxWidth = self::MAX_IMAGE_WIDTH )
    {
        // ディレクトリパス
        $path = Config('original.dataImage') . $tableNo;
        
        // ファイル情報取得
        if ($isStream) {
            $fileOrg = $file->getClientOriginalName();

            
            if(strpos($fileOrg, '.') == 0){
                // ファイルのパスを取得する
                $info = pathinfo($fileOrg);
                
                if (!in_array(strtolower($info['extension']), ['jpg', 'jpeg', 'gif', 'png'])) {
                    // 拡張子なし
                    return 'err/' . $fileOrg . '.' . ' ';
                }
            }

            // ファイルのパスを取得する
            $info = pathinfo($fileOrg);

            // PDFファイルの場合
            if( strtolower($info['extension']) === 'pdf' ){
                // PDFファイルのサムネ画像を生成
                $outFile = self::makePdfThumbnail( $file, $no, $tableNo, $tableType, $fileOrg, $path );
                return $outFile;
            }
        } else {
            $fileOrg = $file;
        }
        $ext = substr($fileOrg, strrpos($fileOrg, '.') + 1); // 拡張子

        if (!$isSimulation) {
            try {
                $fileInfo = getimagesize($file);
            } catch (\Exception $ex) {
                // ファイルサイズのエラーなど
                return 'err/' . $fileOrg;
            }
            if(!$fileInfo){
                // 画像ファイル以外エラー
                return 'err/' . $fileOrg;
            }
        }
        if(!$isSimulation && 
            $fileInfo[2] != IMAGETYPE_JPEG AND
            $fileInfo[2] != IMAGETYPE_GIF AND
            $fileInfo[2] != IMAGETYPE_PNG
                ){
            // 画像タイプ不可
            return 'err/' . $fileOrg;
        }
        $number = substr("0000" . strval($no),-5);
        $msStr = explode(".", (microtime(true)))[1] ?? 0;//ミリ秒
        // 画像ファイル名を生成
        $inFileName = $tableNo . '_' . $tableType . '_' . date("Ymd_His") . '_' . $msStr . '_' . $number . '_tmp' . '.' . $ext;
        // 保存する画像ファイル名
        if (empty($oldName)) {
            $outFileName = $tableNo . '_' . $tableType . '_' . date("Ymd_His") . '_' . $msStr . '_' .$number . '.' . $ext;
        } else {
            $outFileName = $oldName;
        }

        // フォルダチェック、なければフォルダ作成
        if(!file_exists($path)){
            mkdir($path,0777);
        }

        // ファイル取り込み
        if ($isStream) {
            $file->move($path, $inFileName);
        }
        $inFile = $path . '/' . $inFileName;
        $outFile = $path . '/' . $outFileName;
        
        if ($isSimulation) {
            return $outFile;
        }
        
        // 画像リサイズ
        if ($isStream) {
            // 画像をリサイズして、自動的に回転
            self::resizeAndFixOrientation($inFile, $outFile, $maxWidth);
        } else {
            // 画像をリサイズして、自動的に回転
            self::resizeAndFixOrientation($file, $outFile, $maxWidth);
        }
        
        // テンポラリー画像を削除
        @unlink( $inFile );

        return $outFile;
    }

    /**
     * 画像アップサーバーのリスポンスをチェックする
     * @param string $response リスポンス
     * @return bool
     */
    private static function isInvalidImageServeResponse($response) {
        return !preg_match('/\.(?:[jJ][pP][eE][gG]|'
                        . '[jJ][pP][gG]|'
                        . '[pP][nN][gG]|'
                        . '[gG][iI][fF]|'
                        . '[bB][mM][pP])$/', $response);
    }
    
    /**
     * ファイル名を直す処理
     * 
     * @param string $filename ファイル名
     * @return string
     */
    public static function normalizeFileName($filename, $useTime = true) {
        $pathinfo = pathinfo($filename);
        $filename = $pathinfo['filename'];
        // ファイル名のチェック
        $filename_enc = urlencode($filename);
        $filename_enc = str_replace('%28','_',$filename_enc);
        $filename_enc = str_replace('%29','_',$filename_enc);
        // タイムスタンプ
        $time = '';
        if ($useTime === true) {
            $time = time()  . '_';
        }
        $filename = $time . str_replace('%','',$filename_enc);
        $filename = str_replace('+','20',$filename);
        $filename = str_replace('.','20',$filename);

        $maxLength = 100;
        if (strlen($filename) > $maxLength) {
            $filename = substr($filename, 0, $maxLength);
        }
        return $filename . '.' . $pathinfo['extension'];
    }
    
    /**
     * 画像ファイルをアップして画像のURLを取得する
     * @param string $path 画像ファイルのパス
     * @param string $postInfo 記事情報
     *  ・hanshaCode 販社コード
     *  ・systemName システム名
     * @return string 画像のURL
     */
    public static function uploadImageToExternalServer($postInfo) {
        // 販社コード
        $hanshaCode = $postInfo['hanshaCode'];
        // システム名
        $systemName = $postInfo['systemName'];
        
        // ファイル取り込み
        if (isset($postInfo['path'])) {
            // 画像のパス情報
            $path = $postInfo['path'];
            $fileName = basename($path);
        } else {
            // 画像のパス情報
            $file = Request::file($postInfo['varName']);
            $fileName = $file->getClientOriginalName();
            $tmpPath = config('original.dataImage') . $hanshaCode;
            $file->move($tmpPath, $fileName);
            $path = $tmpPath . '/' . $fileName;
        }
        
        // ファイル名のチェック
        $fileName = self::normalizeFileName($fileName);
        
        $url = '';
        // 日時
        $time = date('YmdHis');
        // ターゲットURL
        $targetUrl = self::IMAGE_UPLOADING_URL_800;
        if (isset($postInfo['maxSize']) && !empty($postInfo['maxSize']) &&
                $postInfo['maxSize'] == 1500) {
            $targetUrl = self::IMAGE_UPLOADING_URL_1500;
        }
        $targetUrl .= "?id={$hanshaCode}/{$systemName}&time={$time}";
        
        // MIMEタイプ
        $mimeType = mime_content_type($path);
        // 添付画像のデータ
        $options = [
            'useCookie' => false,
            'attachments' => [
                ['path' => $path, 'name' => $fileName, 'type' => $mimeType]
            ],
        ];

        // 画像アップサーバーの名前
        $remoteFileName = '';
        // 画像をアップする
        if (($response = http_get_contents($targetUrl, $options)) !== false) {
            @unlink($path);
            if (preg_match('/Request Error:/', $response) ||
                    self::isInvalidImageServeResponse($response)
            ) {
                return 'err/' . $fileName;
            }
            // リスポンスがURL
            $remoteFileName = $response;
        }
        // URLを作成
        $url = "//image.hondanet.co.jp/cgi/{$hanshaCode}/{$systemName}/"
                . "data/image/{$remoteFileName}";

        return $url;
    }

    /**
     * PDFファイルのサムネ画像を生成
     * 
     * @param string $inFile
     * @param string $outFile
     * @param array $fileInfo
     */
    private static function makePdfThumbnail( $file=null, $no, $tableNo, $tableType, $fileOrg="", $path ){
        if( empty( $file ) == True ){
            return 'err/' . $fileOrg . '.' . ' ';
        }
        $ext = substr($fileOrg, strrpos($fileOrg, '.') + 1); // 拡張子

        $number = substr("0000" . strval($no),-5);
        $msStr = explode(".", (microtime(true)))[1] ?? 0;//ミリ秒
        // 保存する画像ファイル名
        $outFileName = $tableNo . '_' . $tableType . '_' . date("Ymd_His") . '_' . $msStr . '_' .$number . '.' . $ext;
        // 画像ファイル名を生成
        $tmpThumb1Name = 'thu_' . $tableNo . '_' . $tableType . '_' . date("Ymd_His") . '_' . $msStr . '_' . $number . '_tmp' . '.jpg';
        // 保存先サムネイル画像
        $thumb1Name = 'thu_' . $tableNo . '_' . $tableType . '_' . date("Ymd_His") . '_' . $msStr . '_' . $number . '.jpg';
        
        // フォルダチェック、なければフォルダ作成
        if(!file_exists($path)){
            mkdir($path,0777);
        }
        if(!file_exists($path . '/thumb/')){
            mkdir($path . '/thumb/',0777);
        }

        // ファイル取り込み
        $file->move($path, $outFileName);

        $outFile = $path . '/' . $outFileName;
        $tmpThumbPath = $path . '/thumb/' . $tmpThumb1Name;
        $thumbPath = $path . '/thumb/' . $thumb1Name;
        
        // PDFファイルからJPEG変換するコマンド
        $cmd = "convert -geometry 240 -flatten {$outFile}[0] {$tmpThumbPath}";
        $result = shell_exec($cmd);

        // 画像をリサイズして、自動的に回転
        self::resizeAndFixOrientation($tmpThumbPath, $thumbPath );
        
        // テンポラリー画像を削除
        @unlink( $tmpThumbPath );

        return $outFile;

    }
    
    /**
     * 画像をリサイズ
     * 
     * @param string $inFile
     * @param string $outFile
     * @param array $fileInfo
     */
    /*private static function resizeImage( $inFile, $outFile, $fileInfo )
    {
        // サイズが大きい場合、画像横幅をリサイズ
        $width = self::MAX_IMAGE_WIDTH;

        // 元画像サイズ取得
        if($fileInfo[0] <= self::MAX_IMAGE_WIDTH){
            // サイズが小さい場合、取り込んだファイル名を出力ファイル名にリネーム
            rename($inFile, $outFile);
            return;
        }

        // 高さ計算
        $rate = $width / $fileInfo[0];
        $height = round($fileInfo[1] * $rate);
        
        // 画像リサイズ php版 start
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
        ImageCopyResampled($out, $in, 0, 0, 0, 0, $width, $height, $fileInfo[0], $fileInfo[1]); 

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
        // 画像リサイズ php版 end

        
/*
 * Imageプラグインだとサーバでエラーになるのでとりあえずコメント
 * /etc/php.ini
 * ;extension=php_fileinfo.dllがコメントになっている?
 * 
        // 画像リサイズ
        Image::make($inFile)
            ->resize($width, $height)
            ->save($outFile);
*/
        // 一時ファイル削除
        /*unlink($inFile);
    }*/
}