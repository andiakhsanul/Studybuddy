<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskOverdueMail;
use App\Models\Tugas;

class SendTaskOverdueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Dapatkan tugas yang waktunya mendekati 5 menit dari waktu sekarang
        $nearDueTasks = Tugas::where('TENGGAT_WAKTU', '<=', now()->addMinutes(5)) // Hanya tugas yang mendekati dalam 5 menit
            ->where('STATUS', false) // Pastikan tugas belum selesai
            ->get();

        // Kirim email untuk setiap tugas yang mendekati waktu sekarang
        foreach ($nearDueTasks as $task) {
            Mail::to($task->users->EMAIL)->send(new TaskOverdueMail($task));
        }
    }
}
