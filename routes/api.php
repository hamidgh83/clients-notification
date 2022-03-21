<?php

use App\Http\Controllers\AgentsControler;
use App\Http\Controllers\ClientsControler;
use App\Http\Controllers\NotificationsController;
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
    Route::post('/clients', 'create')->name('client.create');
    Route::get('/clients/{client}', 'get')->name('client.view');
    Route::patch('/clients/{client}', 'update')->name('client.update');
    Route::delete('/clients/{client}', 'delete')->name('client.delete');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/agents/clients/{client}', 'get')->name('agent.client.view');
        Route::get('/agents/clients', 'getAll')->name('agent.clients.index');
    });
});

Route::controller(AgentsControler::class)->group(function () {
    Route::post('/agents', 'create')->name('agent.create');
});

