<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VendaController;

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

Route::controller(VendaController::class)->group(function () {
    Route::post('', 'create');
    Route::get('topMateriaisVendidos', 'getTotalMateriaisPorVenda');
    Route::get('topValorMateriaisVendidos', 'getValorMateriaisPorVenda');
    Route::get('topFuncionariosPorVenda', 'getTopTresFuncionariosPorVenda');
    Route::get('topVendasPorCentroCusto', 'getVendasPorCentroCusto');
    Route::get('topVendasPorCliente', 'getVendasPorCliente');
    Route::get('totalVendasPorOrigemCliente', 'getTotalVendasPorOrigemCliente');
    Route::get('totalVendas', 'getTotalVendas');
    Route::get('', 'get');
    Route::get('{id_venda}', 'get');
    Route::get('{id_venda}/materiais', 'getMateriais');
    Route::put('{id_venda}', 'update');
    Route::patch('{id_venda}/finalizar', 'finalizar');
    Route::patch('{id_venda}/cancelar', 'cancelar');
});
