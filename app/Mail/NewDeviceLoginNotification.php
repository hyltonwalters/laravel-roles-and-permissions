<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewDeviceLoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): NewDeviceLoginNotification
    {
        Log::info('New Device Login Notification email is being sent to: ' . $this->user->email);
        return $this->markdown('emails.new-device-login')
            ->subject('New Device Login Notification')
            ->with([
                'user' => $this->user,
            ]);
    }
}

