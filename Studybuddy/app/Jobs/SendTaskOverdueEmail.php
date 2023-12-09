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
        $nearDueTasks = Tugas::where('TENGGAT_WAKTU', '<=', now()->addMinutes(5))
            ->where('STATUS', false)
            ->get();

        foreach ($nearDueTasks as $task) {
            // Check if the task is due within the next 5 minutes
            $dueTime = now()->addMinutes(5);
            if ($task->TENGGAT_WAKTU <= $dueTime) {
                // Send email to the user
                Mail::to($task->users->EMAIL)->send(new TaskOverdueMail($task));
            }
        }
    }
}
