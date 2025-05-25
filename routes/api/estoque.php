<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EstoqueController;

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

Route::controller(EstoqueController::class)->group(function () {
    Route::get('{id_estoque}', 'get');
    Route::get('', 'get');
    Route::put('{id_estoque}', 'update');
    Route::post('', 'create');
    Route::delete('{id_estoque}', 'delete');
});