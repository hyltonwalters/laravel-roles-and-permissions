<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewDeviceLoginNotification;
use App\Models\UserLocation;
use App\Services\IpGeolocationService;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function __construct(private readonly IpGeolocationService $geolocation)
    {
    }

    /**
     * Handle the authenticated event by recording a new device/location and notifying the user.
     */
    public function handleAuthenticated(): void
    {
        $user = Auth::user();

        if ($user === null) {
            return;
        }

        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        $userLocation = UserLocation::where('user_id', $user->id)->first();

        $deviceChanged = !$userLocation
            || $userLocation->ip_address !== $ipAddress
            || $userLocation->user_agent !== $userAgent;

        if (!$deviceChanged) {
            return;
        }

        $userLocation ??= new UserLocation(['user_id' => $user->id]);

        $userLocation->ip_address = $ipAddress;
        $userLocation->user_agent = $userAgent;
        $userLocation->login_at = now();
        $userLocation->location = $this->geolocation->cityFor($ipAddress) ?? 'Unknown';
        $userLocation->save();

        Mail::to($user->email)->send(new NewDeviceLoginNotification($user));
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        event(new Authenticated('web', auth()->user()));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
