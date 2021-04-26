<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Http\Controllers\tCommon;
use App\Models\Base;
use App\Models\Staffbbs;
use App\Models\StaffbbsDraft;
use App\Models\TrueDesign;
use App\Models\DraftDesign;
use App\Original\Codes\Aichi\EventBlockCodes;
use App\Original\Codes\Aichi\UsedcarBlockCodes;
use App\Original\Codes\Aichi\ImageFrameCodes;
use App\Original\Codes\Aichi\BackgroundDesignCodes;
use App\Original\Util\CodeUtil;
use App\Original\Util\SessionUtil;
use App\Original\Util\ImageUtil;
use Request;

/**
 * 背景デザインとスタッフ紹介の更新
 * 
 * @author ahmad
 */
trait DesignRepository
{
    use tCommon;

    /**
     * 背景デザインを編集する画面
     */
    public function getEdit() {
        // リクエスト
        $reqs = Request::all();
        // 拠点コード
        $shopCode = $reqs['shop'] ?? '';
        // 販社一覧
        $shopList = $this->shopList($this->hanshaCode);
        // 拠点名
        $shopName = $shopList[$shopCode] ?? '';
        // 背景デザイン
        $design = DraftDesign::createNewInstance( $this->hanshaCode )
            ->where('shop', $shopCode)
            ->first();
        if ($design) {
            // 写真URLを調整
            $design->main_photo_url = $design->main_photo;
            if (!preg_match('/^http|\/\//', $design->main_photo)) {
                $design->main_photo_url = asset_auto($design->main_photo);
            }
        }
        // スタッフ紹介
        $staffObj = StaffbbsDraft::createNewInstance( $this->hanshaCode )
            ->where('shop', $shopCode)
            ->get();
        $staff = [];
        foreach ($staffObj as $item) {
            $i = $item->grade;
            // 写真URLの調整
            $item->photo_url = $item->photo;
            if (!preg_match('/^http|\/\//', $item->photo)) {
                $item->photo_url = asset_auto($item->photo);
            }
            $item->photo2_url = $item->photo2;
            if (!preg_match('/^http|\/\//', $item->photo2)) {
                $item->photo2_url = asset_auto($item->photo2);
            }
            $staff[$i] = $item;
        }
        // URL
        $urlConfirmDesign = CodeUtil::getV2Url('Admin\DesignController@postConfirm', $this->hanshaCode);
        // ビュー名
        $viewName = "api.{$this->hanshaCode}.admin.design.form";
        return view($viewName, compact(
            'shopList',
            'shopCode',
            'shopName',
            'design',
            'staff',
            'urlConfirmDesign'
        ));
    }

    /**
     * アップした画像データを取得
     */
    private function readFileData($data) {
        // 背景デザイン
        $name = 'design_main_photo';
        if (Request::file($name) !== null) {
            $fileName = ImageUtil::makeImage($name, 0, $this->hanshaCode, 'staff' );
            $data['design']['main_photo'] = $fileName;
        }
        // スタッフ紹介
        for ($i = 1; $i <= 4; $i++) {
            // ヘッダー写真
            $name = 'staff_header' . $i;
            if (Request::file($name) !== null) {
                $fileName = ImageUtil::makeImage($name, 0, $this->hanshaCode, 'staff' );
                $data['staff'][$i]['photo2'] = $fileName;
            }
            // スタッフ写真
            $name = 'staff_pic' . $i;
            if (Request::file($name) !== null) {
                $fileName = ImageUtil::makeImage($name, 0, $this->hanshaCode, 'staff' );
                $data['staff'][$i]['photo'] = $fileName;
            }
        }
        return $data;
    }

    /**
     * ドラフトを更新する
     */
    private function updateDraft($data) {
        // 店舗コード
        $shopCode = $data['shop'] ?? '';
        // 背景デザイン
        $modelObj = DraftDesign::createNewInstance( $this->hanshaCode )
            ->where('shop', $shopCode)
            ->first();
        if ($modelObj) {
            // 背景
            if (isset($data['design']['main_photo'])) {
                $newData['main_photo'] = $data['design']['main_photo'];
            }
            // レイアウト
            if (isset($data['design']['layout'])) {
                $newData['layout'] = $data['design']['layout'];
            }
            // パターン
            if (isset($data['design']['pattern'])) {
                $newData['pattern'] = $data['design']['pattern'];
            }
            // パスワード
            if (isset($data['design']['edit_pwd'])) {
                $newData['edit_pwd'] = $data['design']['edit_pwd'];
            }
            if (count($newData) > 0) {
                $modelObj->update($newData);
            }
        }
        // スタッフ紹介
        $modelObj = StaffbbsDraft::createNewInstance( $this->hanshaCode )
            ->where('shop', $shopCode)
            ->get();
        if ($modelObj) {
            foreach ($modelObj as $itemObj) {
                $newData = [];
                $i = (int)$itemObj->grade;
                // ヘッダー写真
                if (isset($data['staff'][$i]['photo2'])) {
                    $newData['photo2'] = $data['staff'][$i]['photo2'];
                }
                // プロファイル写真
                if (isset($data['staff'][$i]['photo'])) {
                    $newData['photo'] = $data['staff'][$i]['photo'];
                }
                // 名前
                if (isset($data['staff'][$i]['name'])) {
                    $newData['name'] = $data['staff'][$i]['name'];
                }
                // 肩書
                if (isset($data['staff'][$i]['department'])) {
                    $newData['department'] = $data['staff'][$i]['department'];
                }
                // コメント
                if (isset($data['staff'][$i]['comment'])) {
                    $newData['comment'] = $data['staff'][$i]['comment'];
                }
                if (count($newData) > 0) {
                    // 更新
                    $itemObj->update($newData);
                }
            }
        }
    }

    /**
     * 写真URLを調整する
     * 
     * @param array $data データ
     * @return array
     */
    private function normalizeImageUrl($data) {
        // 背景デザイン
        if (isset($data['design']['main_photo'])) {
            $data['design']['main_photo_url'] = asset_auto($data['design']['main_photo']);
        }
        // スタッフ紹介
        if (isset($data['staff'])) {
            for ($i = 1; $i <= 4; $i++) {
                // ヘッダー写真
                if (isset($data['staff'][$i]['photo2'])) {
                    $data['staff'][$i]['photo2_url'] = asset_auto($data['staff'][$i]['photo2']);
                }
                // スタッフ写真
                if (isset($data['staff'][$i]['photo'])) {
                    $data['staff'][$i]['photo_url'] = asset_auto($data['staff'][$i]['photo']);
                }
            }
        }
        return $data;
    }

    /**
     * 背景デザインを確認する画面
     */
    public function postConfirm() {
        // リクエスト
        $reqs = Request::all();
        // 画像を読み込む
        $reqs = $this->readFileData($reqs);
        // ドラフトを更新
        $this->updateDraft($reqs);
        // 写真URLの調整
        $reqs = $this->normalizeImageUrl($reqs);
        // 拠点コード
        $shopCode = $reqs['shop'] ?? '';
        // 販社一覧
        $shopList = $this->shopList($this->hanshaCode);
        // 拠点名
        $shopName = $shopList[$shopCode] ?? '';
        // 背景デザイン
        $design = $reqs['design'] ?? [];
        // スタッフ紹介
        $staff = $reqs['staff'] ?? [];
        // コード一覧
        $codes = [
            'layout' => (new BackgroundDesignCodes)->getOptions(),
            'pattern' => (new ImageFrameCodes)->getOptions(),
        ];
        // URL
        $urlSaveDesign = CodeUtil::getV2Url('Admin\DesignController@postSave', $this->hanshaCode);
        $urlEditDesign = CodeUtil::getV2Url('Admin\DesignController@getEdit', $this->hanshaCode) . '?shop=' . $shopCode;
        // ビュー名
        $viewName = "api.{$this->hanshaCode}.admin.design.confirm";
        return view($viewName, compact(
            'shopList',
            'shopCode',
            'shopName',
            'design',
            'staff',
            'codes',
            'urlSaveDesign',
            'urlEditDesign'
        ));
    }

    /**
     * 背景デザインを保存する
     */
    public function postSave() {
        // リクエスト
        $reqs = Request::all();
        // 店舗コード
        $shopCode = $reqs['shop'] ?? '';
        // 背景デザイン
        $draftDesignObj = DraftDesign::createNewInstance( $this->hanshaCode )
            ->where('shop', $shopCode)
            ->first();
        if ($draftDesignObj) {
            $trueDesignObj = TrueDesign::createNewInstance( $this->hanshaCode )
                ->where('shop', $shopCode)
                ->first();
            if ($trueDesignObj) {
                $data = [
                    'main_photo' => $draftDesignObj->main_photo,
                    'layout' => $draftDesignObj->layout,
                    'pattern' => $draftDesignObj->pattern,
                    'edit_pwd' => $draftDesignObj->edit_pwd,
                ];
                $trueDesignObj->update($data);
            }
        }
        // スタッフ紹介
        $draftStaffObj = StaffbbsDraft::createNewInstance( $this->hanshaCode )
            ->where('shop', $shopCode)
            ->orderBy('grade')
            ->get();
        foreach ($draftStaffObj as $itemObj) {
            $i = $itemObj->grade;
            $trueStaffObj = Staffbbs::createNewInstance( $this->hanshaCode )
                ->where('shop', $shopCode)
                ->where('grade', $i)
                ->first();
            if (!$trueStaffObj) {
                continue;
            }
            $data = [
                'name' => $itemObj->name,
                'photo' => $itemObj->photo,
                'photo2' => $itemObj->photo2,
                'comment' => $itemObj->comment,
                'grade' => $itemObj->grade,
            ];
            $trueStaffObj->update($data);
        }
        // URL
        $urlEditDesign = CodeUtil::getV2Url('Admin\DesignController@getEdit', $this->hanshaCode) . '?shop=' . $shopCode;
        // ビュー名
        $viewName = "api.{$this->hanshaCode}.admin.design.complete";
        return view($viewName, compact(
            'urlEditDesign'
        ));
    }
}
