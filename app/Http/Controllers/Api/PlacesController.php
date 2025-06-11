<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class PlacesController extends Controller
{
    public function venues(Request $request)
    {
        $city = $request->query('city', 'Tokyo');
        $apiKey = env('FOURSQUARE_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->get("https://api.foursquare.com/v3/places/search", [
            'near' => "{$city},JP",
            'limit' => 5,
        ]);

        return $response->json();
    }
}
