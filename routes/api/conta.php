<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ContaController;

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

Route::controller(ContaController::class)->group(function () {
    Route::post('{tipo_movimentacao}', 'create');
    Route::get('{id_movimentacao}', 'get');
    Route::get('', 'get');
    Route::put('{id_movimentacao}', 'update');
    Route::delete('{id_movimentacao}', 'delete');
});