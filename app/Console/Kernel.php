<?php

namespace App\Console;

use App\Jobs\SendScheduledNotificationJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       // $title = "yee";
        //$content = "yee haw";
        // $schedule->command('inspire')->hourly();
        $schedule->command('send:scheduledmessage')->everyMinute();

        $schedule->call([new \App\Http\Controllers\MessageController, 'deleteOldNotifs'])->daily();
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
