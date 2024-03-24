@component('mail::message')
    # New Device Login Notification

    Hello {{ $user->first_name }} {{ $user->last_name }},

    We noticed a login from a new device/browser on your account.

    If this was you, you can ignore this email. Otherwise, please take the necessary steps to secure your account.

    Thanks,
    {{ config('app.name') }}
@endcomponent
