<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MaterialController;

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

Route::controller(MaterialController::class)->group(function () {
    Route::post('', 'create');
    Route::get('{id_material}', 'get');
    Route::get('', 'get');
    Route::put('{id_material}', 'update');
    Route::delete('{id_material}', 'delete');
});