<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServicoController;

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

Route::controller(ServicoController::class)->group(function () {
    Route::post('', 'create');
    Route::get('30days', 'getLast30Days');
    Route::get('30DaysPerFunc', 'getLast30DaysPerFunc');
    Route::get('30DaysPerTipoServico', 'getLast30DaysPerTipoServico');
    Route::get('dashboard', 'getDashboardDados');
    Route::get('topSevenServiceTypes', 'getTopSevenServiceTypes');
    Route::get('topThreeEmployees', 'getTopThreeEmployeesByTotalTypeService');
    Route::get('{id_servico}', 'get');
    Route::get('', 'get');
    Route::put('{id_servico}', 'update');
    Route::patch('{id_servico}', 'finalizar');
    Route::delete('{id_servico}', 'delete');
});