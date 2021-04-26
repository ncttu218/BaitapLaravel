<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Commands\Ranking\StaffWeeklyCountCommand;
use Request;

/**
 * 全拠点をランキングするコマンド
 *
 * @author ahmad
 */
class StaffWeeklyRankCommand extends Command {

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ranking:staff-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'スタッフブログのログから毎週のランキングを計算するコマンド';

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle()
    {
        $hanshaCodes = config('original.hansha_code');
        // Honda Cars 東京中央
        $exclusionCodes = ['1011801'];
        
        foreach ($hanshaCodes as $hanshaCode => $name) {
            // 除き
            if (in_array($hanshaCode, $exclusionCodes)) {
                continue;
            }
        
            $this->comment("{$name} → 開始");
            $this->dispatch( new StaffWeeklyCountCommand( $hanshaCode ) );
            $this->comment("{$name} → 終了");
            $this->comment("");
        }
    }

}
