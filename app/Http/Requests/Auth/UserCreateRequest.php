<?php

namespace App\Http\Requests\Auth;

use App\Services\IpGeolocationService;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
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
     * Prepare validated user data and initial location metadata.
     */
    public function createUser(): array
    {
        $userData = $this->validated();
        $userData['password'] = bcrypt($userData['password']);

        $ipAddress = $this->ip();
        $userAgent = $this->userAgent();
        $city = app(IpGeolocationService::class)->cityFor($ipAddress) ?? 'Unknown';

        $userLocationData = [
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'location' => $city,
            'login_at' => now(),
        ];

        $roles = $this->input('roles');

        return compact('userData', 'userLocationData', 'roles');
    }
}
