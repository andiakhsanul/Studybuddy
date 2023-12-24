<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Tugas;
use App\Jobs\SendTaskOverdueEmail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        // Logika untuk mengirim email
        $usersWithNearDeadline = \App\Models\Tugas::where('TENGGAT_WAKTU', '<=', now()->addMinutes(5))
            ->where('TENGGAT_WAKTU', '>', now())
            ->where('STATUS', 0)
            ->get();

        foreach ($usersWithNearDeadline as $tugas) {
            $user = $tugas->users;
            \Illuminate\Support\Facades\Mail::to($user->EMAIL)->send(new \App\Mail\DeadlineApproaching($tugas));
        }
    })->everyMinute();
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
