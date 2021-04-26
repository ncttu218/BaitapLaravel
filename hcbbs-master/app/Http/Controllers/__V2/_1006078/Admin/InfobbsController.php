<?php

namespace App\Http\Controllers\V2\_1006078\Admin;

use App\Http\Controllers\V2\Common\Admin\Controllers\InfobbsCoreController;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IInfobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\InfobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Patches\Infobbs\_20200217_getIndex_setStyle2;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class InfobbsController extends InfobbsCoreController implements IInfobbsRepository
{
    use InfobbsRepository;
    
    use _20200217_getIndex_setStyle2;
    
    /**
     * 一覧表示
     * @return string
     */
    public function getIndex() {
        return $this->overrideGetIndex();
    }
}
