<?php

use App\Http\Controllers\API\EmpresaMenuController;
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

Route::controller(EmpresaMenuController::class)->group(function () {
    Route::post('', 'create');
    Route::get('', 'getMenuEmpresa');
    Route::get('/{id_empresa}', 'getMenuByIdEmpresa');
});