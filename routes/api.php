<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Modules\Reservations\Controllers\ReservationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'reservations'], function() {
    Route::get('', [ReservationsController::class, 'getReservations']);
    Route::post('sync', [ReservationsController::class, 'syncReservations']);
    Route::get('test', [ReservationsController::class, 'test']);
});
