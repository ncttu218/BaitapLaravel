<?php

namespace App\Original\Observer;

use App\Original\Observer\ModelsObserver;

/**
 * トピックス用モデルオブザーバー
 * ・主に定型項目の処理
 *
 * @author yhatsutori
 *
 */
class TopicsModelObserver extends ModelsObserver {

    use tModelObserver;

    /**
     * 登録前処理
     *
     * @param unknown $model
     */
    public function creating($model) {
        $this->injectValueCaseCreating($model);
    }

    /**
     * 更新前処理
     *
     * @param unknown $model
     */
    public function updating($model) {
        $this->injectValueCaseUpdating($model);
    }

    /**
     * セーブ前処理
     *
     * @param unknown $model
     */
    public function saving($model) {
        $this->injectValueCaseSaving($model);
    }
}
