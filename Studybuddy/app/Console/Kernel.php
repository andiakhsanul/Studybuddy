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
    protected function schedule(Schedule $schedule): void
    {
        // Pengecekan dan pembuatan pengingat setiap 5 menit
        $schedule->call(function () {
            $now = now();
            $deadlineTime = now()->addMinutes(10);

            // Ambil tugas yang tenggat waktunya sudah mendekati 10 menit dari sekarang
            $tugas = Tugas::where('TENGGAT_WAKTU', '>=', $now)
                ->where('TENGGAT_WAKTU', '<=', $deadlineTime)
                ->whereDoesntHave('pengingat') // Pastikan tugas belum memiliki pengingat
                ->get();
                dd($tugas);
            // Buat pengingat untuk setiap tugas yang memenuhi syarat
            foreach ($tugas as $tugasItem) {
                $pengingat = new Pengingat();
                $pengingat->mahasiswa_id = $tugasItem->mahasiswa_id;
                $pengingat->jadwalharian_id = $tugasItem->jadwalharian_id;
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
