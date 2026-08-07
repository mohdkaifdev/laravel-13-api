<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class WelcomeMail extends Mailable
{
    public array $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Welcome to Laravel API')
            ->view('emails.welcome');
    }
}
