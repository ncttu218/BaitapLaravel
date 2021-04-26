<?php

namespace App\Handlers\Events;

use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * アップロードイベント処理のハンドラー
 *
 * @author yhatsutori
 */
class UploadedHandler
{
    use DispatchesCommands;

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * UploadedEventが発火されたタイミングで動作
     * 各csvアップロード情報を登録
     * 本社管理のアップロード画面の下のほうにある情報のこと
     *
     * @param  UploadedEvent  $event
     * @return void
     */
    public function handle( UploadedEvent $event ){
    }
}
