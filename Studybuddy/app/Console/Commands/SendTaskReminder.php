<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Tugas;
use Carbon\Carbon;
use db;

class SendTaskReminder extends Command
{
    protected $signature = 'send:task-reminder';
    protected $description = 'Send task reminders to users with tasks due within 5 minutes.';

    public function handle()
    {
        $tasks = Tugas::where('TENGGAT_WAKTU', '<=', Carbon::now()->addMinutes(5))
            ->where('STATUS', 0)
            ->get();

        foreach ($tasks as $task) {
            $user = $task->users;
            $subject = 'Task Reminder';
            $message = "Hi $user->NAMA, your task '{$task->DESK_TUGAS}' is due within 5 minutes.";


            Mail::raw($message, function ($email) use ($user, $subject) {
                $email->to($user->EMAIL)->subject($subject);
            });

            $this->info("Task reminder sent to $user->NAMA");
        }
    }
}
