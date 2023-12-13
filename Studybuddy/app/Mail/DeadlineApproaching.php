<?php

// app/Mail/DeadlineApproaching.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Tugas;

class DeadlineApproaching extends Mailable
{
    use Queueable, SerializesModels;

    public $tugas;

    public function __construct(Tugas $tugas)
    {
        $this->tugas = $tugas;
    }

    public function build()
    {
        return $this->view('emails.deadline-approaching');
    }
}

