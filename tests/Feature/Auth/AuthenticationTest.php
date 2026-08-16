<?php

namespace Tests\Feature\Auth;

use App\Mail\NewDeviceLoginNotification;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        Http::fake([
            'https://ipwho.is/*' => Http::response(['success' => true, 'city' => 'Cape Town'], 200),
        ]);
        Mail::fake();

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertDatabaseHas('user_locations', [
            'user_id' => $user->id,
            'location' => 'Cape Town',
        ]);
        Mail::assertSent(NewDeviceLoginNotification::class, 1);
    }

    public function test_login_tracking_falls_back_deterministically_when_geolocation_fails(): void
    {
        Http::fake([
            'https://ipwho.is/*' => Http::response([], 503),
        ]);
        Mail::fake();

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertDatabaseHas('user_locations', [
            'user_id' => $user->id,
            'location' => 'Unknown',
        ]);
        Mail::assertSent(NewDeviceLoginNotification::class, 1);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        Mail::fake();
        Http::fake();

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        Mail::assertNothingSent();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
