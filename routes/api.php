<?php

use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Api\PlacesController;

Route::get('/weather', [WeatherController::class, 'forecast']);
Route::get('/places', [PlacesController::class, 'venues']);
