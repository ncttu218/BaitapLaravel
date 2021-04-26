<?php

namespace App\Http\Controllers\Api\Common\Repositories;

use App\Http\Controllers\tCommon;
use App\Models\Staffbbs;
use App\Models\StaffbbsDraft;
use App\Models\TrueDesign;
use App\Models\DraftDesign;
use App\Original\Codes\Aichi\ImageFrameCodes;
use App\Original\Codes\Aichi\BackgroundDesignCodes;

/**
 * 背景デザインのコントローラー
 * 
 * @author ahmad
 */
trait DesignRepository
{
    use tCommon;

    /**
     * インデックス
     */
    public function getIndex() {
        // 出力フォーマットのチェック
        if ($this->showType !== 'json') {
            return "エラー： 表示できません。";
        }

        // JSONデータ
        // 初期値
        $jsonData = [
            'layout' => null,
            'pattern' => null,
            'main_photo' => null
        ];
        // 初期値
        for ($i = 1; $i <= 4; $i++) {
            $jsonData['shop_photo' . $i] = null;
            $jsonData['shop_comment' . $i] = null;
            $jsonData['staff_photo' . $i] = null;
            $jsonData['staff_name' . $i] = null;
            $jsonData['staff_position' . $i] = null;
        }
        // 現在タイムスタンプ
        $now = time();

        // 背景デザイン
        $designObj = TrueDesign::createNewInstance( $this->hanshaCode )
            ->where('shop', $this->shopCode)
            ->first();
        if ($designObj) {
            $jsonData['layout'] = $designObj->layout;
            $jsonData['pattern'] = $designObj->pattern;
            $jsonData['main_photo'] = $designObj->main_photo . "?{$now}";
            if (!preg_match('/^http|\/\//', $jsonData['main_photo'])) {
                $jsonData['main_photo'] = asset_auto($jsonData['main_photo']);
            }
        }

        // スタッフ紹介
        $draftStaffObj = StaffbbsDraft::createNewInstance( $this->hanshaCode )
            ->where('shop', $this->shopCode)
            ->orderBy('grade')
            ->get();
        foreach ($draftStaffObj as $itemObj) {
            $i = $itemObj->grade;
            $jsonData['shop_photo' . $i] = $itemObj->photo2 . "?{$now}";
            $jsonData['shop_comment' . $i] = $itemObj->comment;
            $jsonData['staff_photo' . $i] = $itemObj->photo . "?{$now}";
            $jsonData['staff_name' . $i] = $itemObj->name;
            $jsonData['staff_position' . $i] = $itemObj->department;
            if (!preg_match('/^http|\/\//', $jsonData['shop_photo' . $i])) {
                $jsonData['shop_photo' . $i] = asset_auto($jsonData['shop_photo' . $i]);
            }
            if (!preg_match('/^http|\/\//', $jsonData['staff_photo' . $i])) {
                $jsonData['staff_photo' . $i] = asset_auto($jsonData['staff_photo' . $i]);
            }
        }
        
        /*
         * JSONでデータを出力する
         * json_encodeで値をJSON形式に変換して出力する
         * JSON_PRETTY_PRINT JSON出力データを見やすくする
         * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
         * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
         */
        return response()->json( $jsonData, 200, [
            'Content-Type' => 'application/json'
        ], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }
    
}
