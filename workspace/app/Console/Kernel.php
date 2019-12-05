<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath = './bat/timpo.txt';
        $schedule->exec('sh ./bat/timpo.sh')->everyMinute()->appendOutputTo($filePath);
        $schedule->command('mail:notice -I 0.5h')->everyThirtyMinutes()->appendOutputTo($filePath);
        $schedule->command('mail:notice -I 1h')->hourly()->appendOutputTo($filePath);
        $schedule->command('mail:notice -I 2h')->cron('0 */2 * * *')->appendOutputTo($filePath);
        $schedule->command('mail:notice -I 3h')->cron('0 */3 * * *')->appendOutputTo($filePath);
        $schedule->command('mail:notice -I 4h')->cron('0 */4 * * *')->appendOutputTo($filePath);
        $schedule->command('mail:notice -I 5h')->cron('0 */5 * * *')->appendOutputTo($filePath);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
