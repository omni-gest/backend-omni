<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EmpresaController;
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

Route::controller(EmpresaController::class)->group(function () {
    Route::post('', 'create');
    Route::put('/{id_empresa_emp}', 'update');
    Route::get('/usuarios', 'getUsers');
    Route::get('', 'getAll');
});
