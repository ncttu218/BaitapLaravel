<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Commands\Ranking\BaseWeeklyCountCommand;
use Request;

/**
 * 全拠点をランキングするコマンド
 *
 * @author ahmad
 */
class BaseWeeklyRankTokyoChuoCommand extends Command {

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ranking:base-weekly-tokyo-chuo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ログから毎週のランキングを計算するコマンド（東京中央様のみ）';

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle()
    {
        $hanshaCode = '1011801';
        $hanshaCodes = config('original.hansha_code');
        $name = $hanshaCodes[$hanshaCode];
        
        $this->comment("{$name} → 開始");
        $this->dispatch( new BaseWeeklyCountCommand( $hanshaCode ) );
        $this->comment("{$name} → 終了");
        $this->comment("");
    }

}
