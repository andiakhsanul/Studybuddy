<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Tugas;
use App\Models\Pengingat;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $now = now();
        $deadlineTimePrioritasTinggi = $now->copy()->addMinutes(30);
        $deadlineTimePrioritasRendah = $now->copy()->addMinutes(15);

        // Notifikasi untuk tugas dengan skala prioritas tinggi
        $schedule->call(function () use ($deadlineTimePrioritasTinggi) {
            // Ambil tugas dengan skala prioritas tinggi dan tenggat waktu mendekati 30 menit
            $tugas = Tugas::where('skala_prioritas', 1)
                ->where('TENGGAT_WAKTU', '>=', now())
                ->where('TENGGAT_WAKTU', '<=', $deadlineTimePrioritasTinggi)
                ->get();

            // Buat pengingat untuk tugas-tugas ini
            foreach ($tugas as $tugasItem) {
                $pengingat = new Pengingat();
                $pengingat->users_id = $tugasItem->users_id;
                $pengingat->TANGGAL_PENGINGAT = $tugasItem->TENGGAT_WAKTU;
                $pengingat->KETERANGAN = 'Pengingat tugas: ' . $tugasItem->DESK_TUGAS;
                $pengingat->JUDUL_PENGINGAT = 'Tugas';
                $pengingat->save();
            }
        })->everyFiveMinutes();

        // Notifikasi untuk tugas dengan skala prioritas rendah
        $schedule->call(function () use ($deadlineTimePrioritasRendah) {
            // Ambil tugas dengan skala prioritas rendah dan tenggat waktu mendekati 15 menit
            $tugas = Tugas::where('skala_prioritas', 0)
                ->where('TENGGAT_WAKTU', '>=', now())
                ->where('TENGGAT_WAKTU', '<=', $deadlineTimePrioritasRendah)
                ->get();

            // Buat pengingat untuk tugas-tugas ini
            foreach ($tugas as $tugasItem) {
                $pengingat = new Pengingat();
                $pengingat->users_id = $tugasItem->users_id;
                $pengingat->TANGGAL_PENGINGAT = $tugasItem->TENGGAT_WAKTU;
                $pengingat->KETERANGAN = 'Pengingat tugas: ' . $tugasItem->DESK_TUGAS;
                $pengingat->JUDUL_PENGINGAT = 'Tugas';
                $pengingat->save();
            }
        })->everyFiveMinutes();
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
