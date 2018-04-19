<?php

namespace App\Engine\Mailer;


use Nette\Mail\SendmailMailer;
use Nette\Mail\Message;

class Mailer
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new SendmailMailer();
    }

    public function buildMessage():Message{
        return new Message;
    }

    public function sendEmail(Message $mail){
        $this->mailer->send($mail);
    }

}