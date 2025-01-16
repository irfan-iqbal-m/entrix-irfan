<?php

namespace App\Jobs;

use App\Mail\GoodMorningMail;
use App\Mail\TaskAssignedMail;
use App\Mail\TaskOverdueMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

class SendTaskNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public $tries = 3;

    public $timeout = 150;

    // public $retryUntil = 3600; 
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */

    public function handle()
    {

        // // Notify user when a data is assigned
        // Notification::send($this->user, new TaskAssignedNotification($this->data));

        // // Check if the data is overdue
        // if ($this->data->due_date < now()) {
        //     Notification::send($this->user, new TaskOverdueNotification($this->data));
        // }
        if ($this->data['due_date'] < now()) {
            Mail::to($this->data['to'])->send(new TaskOverdueMail($this->data));
        }


        Mail::to($this->data['to'])->send(new TaskAssignedMail($this->data));
    }


    /**
     * The job failed.
     */
    public function failed(Exception $exception)
    {
        Log::error('MAil failed for user: ' . $this->data['to']);
        Log::error('Error: ' . $exception->getMessage());
    }

    /**
     * Retry the job if the email fails.
     */
    public function retryUntil()
    {
        return now()->addMinutes(30);
    }
}
