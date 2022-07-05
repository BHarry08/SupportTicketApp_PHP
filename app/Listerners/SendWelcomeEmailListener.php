<?php

namespace App\Listerners;

use App\Events\SendWelcomeEmailEvent;
use App\Mail\SendWelcome;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailListener
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
     * @param  SendWelcomeEmailEvent  $event
     * @return void
     */
    public function handle(SendWelcomeEmailEvent $event)
    {
        $email = $event->user->emails;
        Mail::to($email)->send(new SendWelcome($event->user));
    }
}
