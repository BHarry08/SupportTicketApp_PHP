<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Route::get('/', "TicketController@index");
Route::get('/list', "TicketController@index");
Route::get('/list-tickets', "TicketController@ListUserTickets");
Route::get('/create-ticket', "TicketController@create");
Route::post('/create-ticket', "TicketController@store");
Route::get('/view/{id}', "TicketController@show");
Route::get('/add-reply/{id}', "TicketController@edit");
Route::post('/add-reply/{id}', "TicketController@update");
Route::get('/logout', function () {
    Auth::logout();
    return redirect("/login");
});

Route::prefix('agent')->group(function () {
    Route::get('/login', "Agent\AuthController@login");
    Route::post('/login', "Agent\AuthController@processLogin");
    Route::post('/login', "Agent\AuthController@processLogin");
    Route::get('/', "Agent\TicketController@index");
    Route::get('/list', "Agent\TicketController@index");
    Route::get('/list-tickets', "Agent\TicketController@list");
    Route::get('/view/{id}', "Agent\TicketController@show");
    Route::get('/add-reply/{id}', "Agent\TicketController@edit");
    Route::post('/add-reply/{id}', "Agent\TicketController@update");
    Route::get('/logout', function () {
        Auth::guard('agents')->logout();
        return redirect("/agent/login");
    });

});

Route::prefix('admin')->group(function () {
    Route::get('/login', "Admin\AuthController@login");
    Route::post('/login', "Admin\AuthController@processLogin");
    Route::get('/list-agents', "Admin\AdminController@listAgents");
    Route::get('/admin-list-agents', "Admin\AdminController@listAgentsData");
    Route::get('/list-agent-tickets/{id}', "Admin\AdminController@ListAgentTickets");
    Route::get('/list-agent-tickets-data/{id}', "Admin\AdminController@agentTicketData");
    Route::get('/view/{id}', "Admin\AdminController@show");
    Route::get('/logout', function () {
        Auth::guard('admins')->logout();
        return redirect("/admin/login");
    });

});

Auth::routes();
