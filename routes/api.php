<?php

use Illuminate\Support\Facades\Route;
use Twentyonetf\AjaxTableCard\Http\Controllers\CacheController;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::get('/cache/{slug}', CacheController::class.'@show');
Route::post('/cache', CacheController::class.'@store');