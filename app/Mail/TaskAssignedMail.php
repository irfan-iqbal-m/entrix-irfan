<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        
        
        $this->data = $data;
    }

    
    public function build()
    {
        return $this->subject('Task Assigned')
            ->view('emails.task-assined-mail')
        ->with('data', $this->data);
    }
}
