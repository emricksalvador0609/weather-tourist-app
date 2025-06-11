<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class WeatherController extends Controller
{
    public function forecast(Request $request)
    {
        $city = $request->query('city', 'Tokyo');
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
            'q' => "{$city},JP",
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        return $response->json();
    }
}
