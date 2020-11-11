<?php

namespace App\Listeners;

use App\Events\SendMail;
use App\Mail\SendToAdminLoginDetails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailAdminFired
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
        $email = "mitesh123@yopmail.com";
        Mail::to($email)->send(new SendToAdminLoginDetails($event->user));
    }
}
