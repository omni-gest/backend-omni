<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServicoTipoController;

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

Route::controller(ServicoTipoController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_servico_tipo}', 'get');
    Route::get('', 'get');
    Route::put('{id_servico_tipo}', 'update');
    Route::delete('{id_servico_tipo}', 'delete');
});