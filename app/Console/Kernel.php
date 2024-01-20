<?php

namespace App\Console;

use App\Events\NewPingsEvent;
use App\Models\Domain;
use App\Models\Ping;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $domains = Domain::all();

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $flag = "-n";
            } else {
                $flag = "-c";
            }

            //TODO добавить проверку на кол-во пингов, чтобы иногда чистить бд

            foreach ($domains as $domain) {
                $dn = $domain->name;
                $out = trim(exec(escapeshellcmd("ping $flag 3 $dn")));
                $ping = Ping::create([
                   "domain" => $dn,
                    "info"  => $out
                ]);

                broadcast(new NewPingsEvent($ping));
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
