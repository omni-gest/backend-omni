<?php

use App\Http\Controllers\AgendamentoController;
use Illuminate\Http\Request;
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

Route::controller(AgendamentoController::class)->group(function () {
    Route::post('/{empresa}', 'create');
    // Route::get('{telefone}', 'get');
    Route::get('/profissionais/{empresa}/{tipos_servico}', 'getProfissionaisByTipoServico');
    Route::get('/horarios/{empresa}/{id_funcionario}/{data}', 'getHorariosByFunc');
    Route::get('/empresa/{empresa}', 'getEmpresa');
    Route::get('/meusagendamentos/{empresa}/{telefone}', 'getAgendasByCliente');
});