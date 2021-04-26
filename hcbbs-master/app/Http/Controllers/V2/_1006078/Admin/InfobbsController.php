<?php

namespace App\Http\Controllers\V2\_1006078\Admin;

use App\Http\Controllers\Admin\Common\Repositories\Infobbs\BlogConfirmationListRepository;
use App\Http\Controllers\V2\Common\Admin\Controllers\InfobbsCoreController;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IInfobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\InfobbsRepository;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class InfobbsController extends InfobbsCoreController implements IInfobbsRepository
{
    use InfobbsRepository;
    use BlogConfirmationListRepository;
    
    /**
     * 一覧表示
     * @return string
     */
    public function getIndex() {
        return $this->overrideGetIndex();
    }
}
