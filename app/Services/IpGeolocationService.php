<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class IpGeolocationService
{
    public function cityFor(?string $ipAddress): ?string
    {
        if (!$ipAddress) {
            return null;
        }

        $baseUrl = rtrim((string) config('services.ip_geolocation.base_url', 'https://ipwho.is'), '/');

        try {
            $response = Http::acceptJson()
                ->timeout(3)
                ->retry(2, 100, throw: false)
                ->get($baseUrl . '/' . urlencode($ipAddress));
        } catch (Throwable) {
            return null;
        }

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        if (($data['success'] ?? true) === false) {
            return null;
        }

        $city = $data['city'] ?? null;

        return is_string($city) && trim($city) !== '' ? trim($city) : null;
    }
}
