<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Infobbs;

use App\Http\Controllers\Admin\Common\Controllers\Parents\InfobbsCoreController;
use App\Original\Util\SessionUtil;
use DB;

/**
 * Description of AdminConfirmation
 *
 * @author ohishi
 */
trait TAdminConfirmation {
    
    /**
     * 本社認証なしの時の更新
     * 
     * @param string $key 記事番号
     * @param array $val フォームのデータ
     */
    private function adminConfirmationOffBulkUpdate($key, $val) {
        // 日時
        $dateTime = date("Y-m-d H:i:s");
        
        // テーブル更新
        $column = array();
        
        // 掲載
        if(isset($val['published'])) {
            $column['published'] = $val['published'] ?? 'OFF';
        }
        
        // 公開申請
        if (isset($val['editflag'])) {
            $column['editflag'] = $val['editflag'] ?? null;
        }
        
        // カテゴリ
        // 本社申請機能のときのみカテゴリーセット
        $category = '';
        $column['category'] = ''; // チェックがない場合全部消す
        if(isset($val['category'])){
            foreach ($val['category'] as $catVal){
                if($category){
                    $category .= ',';
                }
                $category .= $catVal;
            }
        }
        $column['category'] = $category;

        // 更新時間
        // $column = $this->setColumn('updated_at', $dateTime, $column);
        
        DB::table(SessionUtil::getTableName())->where('number', $key)
                ->update($column);
    }
    
    /**
     * 本社認証ありの時の更新
     * 
     * @param object $row
     * @param string $key 現在データベースにあるデータ
     * @param array $val フォームのデータ
     */
    private function adminConfirmationOnBulkUpdate($key, $val, $row) {
        // 日時
        $dateTime = date("Y-m-d H:i:s");
        // テーブル更新
        $column = array();
        
        // 掲載
        $published_changed = false;
        if(isset($val['published'])){
            $column['published'] = $val['published'];
            // 掲載モード更新ステータス
            $published_changed = $val['published'] != $row->published;
        } else if ($this->published_mode == '1' && empty($row->published)) {
            $published_changed = true;
            $column['published'] = 'OFF';
        }
        
        // 公開申請
        $editflag_changed = false;
        if(isset($val['editflag'])){
            $column['editflag'] = $val['editflag'];
            // 編集フラグ更新ステータス
            $editflag_changed = $val['editflag'] != $row->editflag;
        } else if (!empty($row->editflag)) {
            $editflag_changed = true;
            $column['editflag'] = null;
        }
        
        // お店から
        $msg1_changed = false;
        if(isset($val['msg1'])){
            $column['msg1'] = $val['msg1'];
            // メッセージ更新ステータス
            $msg1_changed = $val['msg1'] != $row->msg1;
        } else if (!empty($row->msg1)) {
            $msg1_changed = true;
            $column['msg1'] = null;
        }

        // カテゴリ
        // 本社申請機能のときのみカテゴリーセット
        $category = '';
        $column['category'] = '';// チェックがない場合全部消す
        $category_changed = false;
        if(isset($val['category'])){
            foreach ($val['category'] as $catVal){
                if($category){
                    $category .= ',';
                }
                $category .= $catVal;
            }
            $column['category'] = $category;
            // レコード更新ステータス
            $category_changed = $category != $row->category;
        } else if (!empty($row->category)) {
            $category_changed = true;
            $column['category'] = null;
        }

        // 更新時間
        // $column = $this->setColumn('updated_at', $dateTime, $column);

        if ($published_changed || $editflag_changed || $category_changed || $msg1_changed) {
            DB::table(SessionUtil::getTableName())->where('number', $key)
                ->update($column);
        }

        // 掲載モード・編集フラグが変わる場合
        if ($editflag_changed &&
            $column['editflag'] == 'release')
        {
            // 公開申請日送信時を更新
            DB::table(SessionUtil::getTableName())->where('number', $key)
                ->update(['release_requested_at' => $dateTime]);
            // 公開申請が変わる時の通知がON
            if (in_array(InfobbsCoreController::NOTIFICATION_POST_EDIT_FLAG_CHANGED, $this->notificationTypes)) {
                // メール送信
                $this->sendUploadMail( (array)$row, 'infobbs',  InfobbsCoreController::NOTIFICATION_POST_EDIT_FLAG_CHANGED);
            }
        }
    }
}
