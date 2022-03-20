<?php

use App\Http\Controllers\ClientsControler;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(ClientsControler::class)->group(function () {
    Route::get('/clients/{client}', 'get');
    Route::post('/clients', 'create');
    Route::patch('/clients/{client}', 'update');
    Route::delete('/clients/{client}', 'delete');
});
