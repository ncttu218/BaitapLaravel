<?php

namespace App\Original\Util;

use App\Models\Base;
use App\Models\InfobbsComment;
use App\Models\StaffbbsComment;
use App\Models\Role;
use App\Original\Codes\Base\BaseShowFlgCodes;
use App\Original\Codes\DispCodes;
use App\Original\Codes\MaruBatsuCodes;
use DB;

class CodeUtil {

    /**
     * 全てのコメントを数える販社コード
     * 
     * @var array
     */
    private static $countAllCommentHansha = [
        '7151315', // 宮城
        '7251883', // 山形
        '1351901', // 埼玉
        '8812702', // 前橋
        '1388039', // 久喜
    ];

    /**
     * 権限を取得
     * @param  [type] $code    [description]
     * @param  string $default [description]
     * @return [type]          [description]
     */
    public static function getRoleName($code, $default=''){
        // 権限の一覧を取得
        $roleList = (array)Role::options();

        if( isset( $roleList[$code] ) ){
            return $roleList[$code];
        }

        return $default;
    }

    /**
     * ○×を取得
     * @param  [type] $code    [description]
     * @param  string $default [description]
     * @return [type]          [description]
     */
    public static function getMaruBatsuType($code, $default=''){
        $name = ( new MaruBatsuCodes() )->getValue($code);
        if (! empty($code)) {
            return $name;
        }
        
        return $default;
    }
    
    /**
     * 表示か非表示を取得
     * @param  [type] $code    [description]
     * @param  string $default [description]
     * @return [type]          [description]
     */
    public static function getDispType($code, $default=''){
        $name = ( new DispCodes() )->getValue($code);
        if (! empty($code)) {
            return $name;
        }
        
        return $default;
    }

    #######################
    ## Base 拠点一覧画面用
    #######################

    /**
     * 拠点表示フラグのリストを取得
     * @return [type] [description]
     */
    public static function getBaseShowFlgList(){
        // 拠点表示フラグの値があるかを確認
        $baseShowFlgList = ( new BaseShowFlgCodes() )->getOptions();

        return $baseShowFlgList;
    }

    /**
     * 拠点表示フラグの指定された値を取得
     * @return [type] [description]
     */
    public static function getBaseShowFlgName( $num ){
        $baseShowFlgList = self::getBaseShowFlgList();

        if( isset( $baseShowFlgList[$num] ) == True ){
            return $baseShowFlgList[$num];
        }
        return $num;
    }

    #######################
    ## 管理画面 投稿アドレス一覧
    #######################

    /**
     * システム名のリストを取得
     * @return [type] [description]
     */
    public static function getBlogSystemNameList(){
        // システム名の一覧
        $blogSystemNameList = [
            'infobbs' => 'infobbs: 店舗ブログ',
            'staff' => 'staff: スタッフブログ'
        ];

        return $blogSystemNameList;
    }

    /**
     * システム名の指定された値を取得
     * @return [type] [description]
     */
    public static function getBlogSystemName( $code ){
        $blogSystemNameList = self::getBlogSystemNameList();

        if( isset( $blogSystemNameList[$code] ) == True ){
            return $blogSystemNameList[$code];
        }
        return $num;
    }

    #######################
    ## 管理画面スタッフ紹介
    #######################

    /**
     * 書のリストを取得
     * @return [type] [description]
     */
    public static function getDegreeList(){
        // 肩書の一覧
        $degreeList = [
            'staff10' => '店長',
            'staff20' => '工場長',
            'staff29' => '店長代行',
            'staff30' => '営業',
            'staff40' => 'サービスフロント',
            'staff50' => 'サービス',
            'staff60' => 'ストアマネージャー',
            'staff70' => '事務',
        ];

        return $degreeList;
    }

    /**
     * 書の指定された値を取得
     * @return [type] [description]
     */
    public static function getDegreeName( $num ){
        $degreeList = self::getDegreeList();

        if( isset( $degreeList[$num] ) == True ){
            return $degreeList[$num];
        }
        return $num;
    }

    #######################
    ## API
    #######################

    /**
     * ブログの合計件数を表示
     */
    public static function getBlogTotalSum( $hansha_code="0000001", $shop_code="", $category="", array $options = [] ){

        $count = 0;
       
        if( $hansha_code === "" ){
            return "<p>表示エラー</p>";
        }

        
        
        $tableName = 'tb_' . $hansha_code . '_infobbs';

        // 一覧表示
        $query = DB::table( $tableName . ' AS info' );

        // 拠点コード
        if( $shop_code !== "" ){
            $query = $query->where('info.shop', $shop_code );
        }
        // カテゴリー
        if( isset( $category ) && $category !== "" ){
            /// カテゴリーを検索するSQL
            $query = $query->whereRaw( DB::Raw( " ARRAY['{$category}'] <@ regexp_split_to_array( info.category, ',' ) "  ) );

        }
        
        // 店舗除外
        if (isset($options['shopExclusion']) && is_array($options['shopExclusion'])
                && count($options['shopExclusion']) > 0) {
            $query = $query->whereNotIn( 'info.shop', $options['shopExclusion'] );
        }
        
        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();
        
        $count = $query->where('published', 'ON')
                    // 削除日時がNULLのとき
                    ->whereNull('info.deleted_at')
                    ->whereRaw(' ((from_date <= now() AND to_date >= now()) OR '
                        . '(from_date <= now() AND to_date IS NULL) OR '
                        . '(from_date IS NULL AND to_date >= now()) OR '
                        . '(from_date IS NULL AND to_date IS NULL)) ')
                    // 拠点テーブルとのJOIN
                    ->join( $baseTableName . ' AS b', function ($join) use($hansha_code) {
                        $join->on('b.base_code', 'info.shop'); // 拠点コード
                        $join->whereRaw("(b.show_flg = '1' OR b.show_flg IS NULL)"); // 表示機能
                        $join->on('b.hansha_code', DB::raw("'{$hansha_code}'")); // 販社コード
                    })
                    // 削除フラグ
                    ->whereNull('b.deleted_at')
                    // 非公開の拠点は除く
                    ->where( 'b.base_published_flg', '<>', 2 )
                    ->count('*');

        return $count;
    }

    /**
     * ブログコメントの合計数数の
     */
    public static function getBlogCommentCountTotal( $hansha_code="0000001", $blog_data_id=0 ){

        $count = 0;
        // 指定したIDのモデルオブジェクトを取得
        $infobbsCommentMObj = InfobbsComment::createNewInstance( $hansha_code );
        $infobbsCommentMObj = $infobbsCommentMObj->where( 'num', '=', $blog_data_id );
        
        if (!in_array($hansha_code, self::$countAllCommentHansha)) {
            $infobbsCommentMObj = $infobbsCommentMObj->where( 'mark', '!=', '' );
        }

        $count = $infobbsCommentMObj->count( '*' );

        return ( !is_null( $count ) )? $count : 0;
    }

    /**
     * ブログコメントの合計数数の
     */
    public static function getBlogCommentCountList( $hansha_code="0000001", $blog_data_id=0 ){

        $commentList = [];
        // 指定したIDのモデルオブジェクトを取得
        $infobbsCommentMObj = InfobbsComment::createNewInstance( $hansha_code );

        $commentList = $infobbsCommentMObj->where( 'num', '=', $blog_data_id )
                                ->where( 'mark', '!=', '' )
                                ->groupBy( 'mark' )
                                ->select( DB::raw( 'mark, count(*) as comment_count' ) )
                                ->get();

        return $commentList;
    }

    /**
     * スタッフブログコメントの合計数数の合計
     */
    public static function getStaffBlogCommentCountTotal( $hansha_code="0000001", $blog_data_id=0 ){

        $count = 0;
        // 指定したIDのモデルオブジェクトを取得
        $staffbbsCommentMObj = StaffbbsComment::createNewInstance( $hansha_code );

        $count = $staffbbsCommentMObj->where( 'num', '=', $blog_data_id )
                                ->count( '*' );

        return ( !is_null( $count ) )? $count : 0;
    }

    /**
     * スタッフブログコメントの合計数数の一覧
     */
    public static function getStaffBlogCommentCountList( $hansha_code="0000001", $blog_data_id=0 ){

        $commentList = [];
        // 指定したIDのモデルオブジェクトを取得
        $staffbbsCommentMObj = StaffbbsComment::createNewInstance( $hansha_code );

        $commentList = $staffbbsCommentMObj->where( 'num', '=', $blog_data_id )
                                ->groupBy( 'mark' )
                                ->select( DB::raw( 'mark, count(*) as comment_count' ) )
                                ->get();

        return $commentList;
    }
    
    /**
     * 販社がv2を使うマーク
     * 
     * @param string $hanshaCode 販社コード
     * @return bool
     */
    public static function isV2($hanshaCode, $suffix = '') {
        if ($suffix !== '') {
            $suffix = '/' . $suffix;
        }
        $v2Path = app_path('Http/Controllers/V2/_' . $hanshaCode . $suffix);
        $hasV2Config = isset(config('original.v2_adv_para')[$hanshaCode]) ?? false;
        return file_exists($v2Path) || $hasV2Config;
    }
    
    /**
     * 販社がv3を使うマーク
     * 
     * @param string $hanshaCode 販社コード
     * @return bool
     */
    public static function isV3($hanshaCode, $suffix = '', $namespace = '') {
        if ($suffix !== '') {
            $suffix = '/' . $suffix;
        }
        $v2Path = app_path('Http/Controllers' . $namespace . '/_' . $hanshaCode . $suffix);
        return file_exists($v2Path);
    }
    
    /**
     * v2のURLを取得
     * 
     * @param string $action コントローラー名
     * @param string $hanshaCode 販社コード
     * @return string
     */
    public static function getV2Url($action, $hanshaCode = null) {
        $namespace = '';
        $controllerName = '';
        $actionName = '';
        if (preg_match('/(^.+?)\\\(.+?Controller)@(.+?)$/', $action, $match)) {
            $namespace = $match[1];
            $controllerName = $match[2];
            $actionName = $match[3];
        }
        
        $filename = $namespace . '/' . $controllerName . '.php';
        if ($hanshaCode !== null && self::isV3($hanshaCode, $filename)) {
            $action = "$namespace\\_{$hanshaCode}\\$controllerName" . '@' . $actionName;
        } else {
            $action = $namespace . '\\Common\\Controllers\\' .
                    $controllerName . '@' . $actionName;
        }
        
        return action_auto($action);
    }
    
    /**
     * 指定する機能を持っている販社がv2を使うマーク
     * 
     * @param string $hanshaCode 販社コード
     * @param string $controllerName コントローラー名
     * @return bool
     */
    public static function isV2Has($hanshaCode, $controllerName) {
        $v2Path = app_path('Http/Controllers/V2/_' .
                $hanshaCode . '/' . $controllerName . '.php');
        return file_exists($v2Path);
    }

    /**
     * サムネ画像URLを取得する関数
     * 
     * @param string $filePath ファイルのパス
     * @return string $thumbPath サムネイル画像のパス
     */
    public static function getPdfThumbnail( $filePath="" ) {
        // サムネイル画像のパス
        $thumbPath = "";

        // ファイルのURLが空でないとき
        if( !empty( $filePath ) ){
            // ファイルパスのの設定
            $filePath = asset_auto( $filePath );
            // ファイルパスの情報を取得する
            $info = pathinfo( $filePath );
            
            // 拡張子がPDFのとき
            if( strtolower( $info['extension'] ) === "pdf" ){
                
                // サムネイル画像のURLを生成
                $thumbPath = $info['dirname'] . '/thumb/thu_' . $info['filename'] . '.jpg';
            }
        }
        return $thumbPath;
    }
    
 }
