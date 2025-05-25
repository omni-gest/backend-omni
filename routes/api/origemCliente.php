<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrigemClienteController;



Route::controller(OrigemClienteController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_origem_cliente_orc}', 'get');
    Route::get('', 'get');
    Route::put('{id_origem_cliente_orc}', 'update');
    Route::delete('{id_origem_cliente_orc}', 'delete');
});