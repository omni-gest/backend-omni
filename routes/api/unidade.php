<?php

use App\Http\Controllers\API\UnidadeController;
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

Route::controller(UnidadeController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_unidade_und}', 'get');
    Route::get('', 'get');
    Route::put('{id_unidade_und}', 'update');
    Route::delete('{id_unidade_und}', 'delete');
});