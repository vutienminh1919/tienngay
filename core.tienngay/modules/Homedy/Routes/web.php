<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('homedy')->middleware('homedy.auth')->group(function() {
    Route::get('list_province', 'HomedyController@list_province');
    Route::get('list_district', 'HomedyController@list_district');
    Route::post('send_lead', 'HomedyController@send_lead_post');
    Route::get('get_lead', 'HomedyController@get_lead');
    Route::post('find_lead', 'HomedyController@find_lead');
});
