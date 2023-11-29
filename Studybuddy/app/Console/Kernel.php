<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Tugas;
use App\Models\Pengingat;
use App\Jobs\SendTaskOverdueEmail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->job(new SendTaskOverdueEmail)->everyTenMinutes(); // Sesuaikan dengan kebutuhan jadwal
}

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
