<?php

namespace App\Http\Controllers\V2\_1006078\Admin;

use App\Http\Controllers\Admin\Common\Repositories\Hobbs\BlogConfirmationListRepository;
use App\Http\Controllers\V2\Common\Admin\Controllers\HobbsCoreController;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IHobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\HobbsRepository;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class HobbsController extends HobbsCoreController implements IHobbsRepository
{
    use HobbsRepository;
    use BlogConfirmationListRepository;
    
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