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

            foreach ($domains as $domain) {
                $di = $domain->id;
                $dn = $domain->name;
                $out = trim(exec(escapeshellcmd("ping $flag 1 $dn")));
                $array_out = explode(', ', $out);
                if (str_contains($array_out[2], 'Lost')) {
                    $answer = str_replace('Lost = 1 ', '', $array_out[2]);
                } else {
                    $answer = str_replace('Average = ', '', $array_out[2]);
                }

                $ping = Ping::create([
                    "info"  => $answer,
                    "domain_id" => $di
                ]);

                broadcast(new NewPingsEvent($ping, $di));
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
