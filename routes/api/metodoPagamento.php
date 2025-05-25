<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MetodoPagamentoController;

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

Route::controller(MetodoPagamentoController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_metodo_pagamento}', 'get');
    Route::get('', 'get');
    Route::put('{id_metodo_pagamento}', 'update');
    Route::delete('{id_metodo_pagamento}', 'delete');
});