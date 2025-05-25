<?php

use App\Http\Controllers\API\CentroCustoController;
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

Route::controller(CentroCustoController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_centro_custo}', 'get');
    Route::get('', 'get');
    Route::put('{id_centro_custo}', 'update');
    Route::delete('{id_centro_custo}', 'delete');
});