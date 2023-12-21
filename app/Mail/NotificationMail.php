<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $mail_content;
    public $emailid;
    public $attachmentPath;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $mail_content, $attachmentPath, $name)
    {
        $this->title = $title;
        $this->mail_content = $mail_content;
        $this->attachmentPath = $attachmentPath;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notificationmail')
            ->with([
                'title' => $this->title,
                'mail_content' => $this->mail_content,
            ]);
    }
}
