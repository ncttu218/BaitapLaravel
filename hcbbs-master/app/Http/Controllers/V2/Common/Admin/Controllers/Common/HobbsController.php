<?php

namespace App\Http\Controllers\V2\Common\Admin\Controllers\Common;

use App\Http\Controllers\V2\Common\Admin\Controllers\HobbsCoreController;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IHobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\HobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Patches\Hobbs\_20200217_getIndex_setStyle2;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class HobbsController extends HobbsCoreController implements IHobbsRepository
{
    use HobbsRepository;
    
    use _20200217_getIndex_setStyle2;
    
    /**
     * 一覧表示
     * @return string
     */
    public function getIndex() {
        return $this->overrideGetIndex();
    }
    
    /**
     * 表示リスト（ページネイション）
     * @return array
     */
    protected function makeList() {
        return $this->overrideMakeList();
    }
}