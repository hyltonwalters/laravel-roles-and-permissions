<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'roles' => ['required', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Create the user location before creating the user.
     *
     * @return array
     */
    public function createUser(): array
    {
        $userData = $this->validated();
        $userData['password'] = bcrypt($userData['password']);

        // Retrieve the user's IP address and user agent
        $ipAddress = $this->ip();
        $userAgent = $this->userAgent();

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

        // Create the user location
        $userLocationData = [
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'location' => $city,
            'login_at' => now(),
        ];

        // Get roles from the request data
        $roles = $this->input('roles');

        // Return both user data and user location data, and role ID
        return compact('userData', 'userLocationData', 'roles');
    }

    /**
     * Get location data using IP address from API.
     *
     * @param string $ipAddress
     * @return array
     */
    private function getLocationData(string $ipAddress): array
    {
        $response = Http::get('http://ip-api.com/json/' . $ipAddress . '?fields=49168');

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }
}
