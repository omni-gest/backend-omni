<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ClienteController;

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

Route::controller(ClienteController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_cliente}', 'get');
    Route::get('', 'get');
    Route::put('{id_cliente}', 'update');
    Route::delete('{id_cliente}', 'delete');
});