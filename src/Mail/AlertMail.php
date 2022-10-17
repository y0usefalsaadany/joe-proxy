<?php

namespace Yousefpackage\JoeProxy\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from your website')
        ->from(env('MAIL_FROM_ADDRESS'),env('ALERT') ?? 'Your Website Security')
        ->subject($this->data['subject'])
        ->view('joeProxy::alertMail');
    }
}
