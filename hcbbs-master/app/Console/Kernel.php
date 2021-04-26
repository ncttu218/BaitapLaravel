<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\BaseWeeklyRankCommand;
use App\Console\Commands\BaseWeeklyRankTokyoChuoCommand;
use App\Console\Commands\StaffWeeklyRankCommand;
use App\Console\Commands\DataEraseCommand;
use App\Console\Commands\MailBlogRegisterPhpCommand;
use App\Console\Commands\MailBlogRegisterPerlAdvancedCommand;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BaseWeeklyRankCommand::class,
        BaseWeeklyRankTokyoChuoCommand::class,
        StaffWeeklyRankCommand::class,
        DataEraseCommand::class,
        MailBlogRegisterPhpCommand::class,
        MailBlogRegisterPerlAdvancedCommand::class,
        //'App\Console\Commands\Inspire',
        //'App\Console\Commands\UserRegister',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->command('inspire')
                ->hourly();
    }

}
