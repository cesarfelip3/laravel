<?php

namespace App\Console;

use App\Console\Commands\ProjectSetup;
use App\Console\Commands\Scaffolding;
use App\Console\Commands\ScaffoldingRollback;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        ProjectSetup::class,
        Scaffolding::class,
        ScaffoldingRollback::class,
    ];

    protected function schedule(Schedule $schedule)
    {

    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
