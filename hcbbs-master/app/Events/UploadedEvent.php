<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Lib\Csv\CsvImportResult;
use App\Models\UserAccount;
use App\Events\Event;

/**
 * csvをアップロードした時のイベント
 * App\Events\Handlers\UploadedHandler.phpと連動する
 */
class UploadedEvent extends Event
{
    use SerializesModels;

    public $user;
    public $result;
    public $csvType;

    /**
     * Create a new event instance.
     * UploadedHandlerが本体
     * @return void
     */
    public function __construct( UserAccount $user, CsvImportResult $result, $csvType )
    {
        $this->user = $user;
        $this->result = $result;
        $this->csvType = $csvType;
    }


}
