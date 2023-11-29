<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Tugas;

class TaskOverdueMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    public function __construct(Tugas $task)
    {
        $this->task = $task;
    }

    public function build()
    {
        $subject = 'Task Overdue Mail';
        $content = "Dear {$this->task->users->NAMA},\n\n"
                 . "Your task \"{$this->task->DESK_TUGAS}\" is overdue. Please take necessary actions.\n\n"
                 . "Regards,\nYour Application";

        return $this->subject($subject)->text($content);
    }
}
