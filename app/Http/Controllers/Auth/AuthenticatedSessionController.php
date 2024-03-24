<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewDeviceLoginNotification;
use App\Models\UserLocation;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle user authentication registered event.
     */
    public function handleAuthenticated()
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user !== null) {
            $userId = $user->id;
        }

        // Retrieve the user's IP address and user agent
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        // Retrieve the user's current location
        $userLocation = UserLocation::where('user_id', $userId)->first();

        // If user's location doesn't exist or IP or user agent doesn't match, update the record and send notification
        if (!$userLocation || $userLocation->ip_address !== $ipAddress || $userLocation->user_agent !== $userAgent) {
            if (!$userLocation) {
                $userLocation = new UserLocation();
                $userLocation->user_id = $user->id;
            }

            // Get location data using IP address from API
            $locationData = $this->getLocationData($ipAddress);

            // Extract city name from location data
            $city = $locationData['city'] ?? null;

            // If city data is not available or API request fails,
            // like in my case it can be one of the following reasons:
            // private range, reserved range, invalid query
            // we then generate a fake city name
            if (!$city) {
                $city = fake()->city;
            }

            // Update user's location
            $userLocation->ip_address = $ipAddress;
            $userLocation->user_agent = $userAgent;
            $userLocation->login_at = now();
            $userLocation->location = $city;
            $userLocation->save();
            
            // Send email notification for new users or existing users with different IP or User Agent
            Mail::to($user->email)->send(new NewDeviceLoginNotification($user));
        }
    }

    /**
     * Get location data using IP address from API.
     */
    private function getLocationData($ipAddress)
    {
        $response = Http::get('http://ip-api.com/json/' . $ipAddress . '?fields=49168');

        if ($response->successful()) {
            return $response->json();
        }

        return [];
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
