<?php

use App\Http\Controllers\API\CargoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(CargoController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_cargo}', 'get');
    Route::get('', 'get');
    Route::put('{id_cargo}', 'update');
    Route::delete('{id_cargo}', 'delete');
});