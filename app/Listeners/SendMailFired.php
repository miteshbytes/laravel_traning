<?php

namespace App\Listeners;

use App\User;
use App\Events\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\SendLoginDetails;

class SendMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        //dd($email = $event->user->email);
        $email = $event->user->email;
        Mail::to($email)->send(new SendLoginDetails($event->user));
    }
}
