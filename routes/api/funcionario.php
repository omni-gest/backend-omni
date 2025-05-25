<?php

use App\Http\Controllers\API\FuncionarioController;
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

Route::controller(FuncionarioController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_funcionario}', 'get');
    Route::get('', 'get');
    Route::put('{id_funcionario}', 'update');
    Route::delete('{id_funcionario}', 'delete');
});