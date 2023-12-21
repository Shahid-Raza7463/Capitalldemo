<?php

namespace App\Jobs;

use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title;
    public $mail_content;
    public $emailid;
    public $attachmentPath;
    public $name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $mail_content, $emailid, $attachmentPath, $name)
    {
        $this->title = $title;
        $this->mail_content = $mail_content;
        $this->emailid = $emailid;
        $this->attachmentPath = $attachmentPath;
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send the email using the Mailable class
        Mail::to($this->emailid)
            ->send(new NotificationMail($this->title, $this->mail_content, $this->attachmentPath, $this->name));
    }
}
