<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PessoaController;

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

Route::controller(PessoaController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_pessoa_pes}', 'get');
    Route::get('', 'get');
    Route::put('{id_pessoa_pes}', 'update');
    Route::delete('{id_pessoa_pes}', 'delete');
});