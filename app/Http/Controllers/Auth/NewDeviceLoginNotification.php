<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDeviceLoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function build(): NewDeviceLoginNotification
    {
        return $this->markdown('emails.new-device-login')
            ->subject('New Device Login Notification');
    }
}
