<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
// use Modules\Hcns\Http\Middleware\Authorization;

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

Route::prefix('/hcns')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module HCNS");
    });

    Route::post('/saveRecord', 'HcnsController@saveRecord');
    Route::post('/valid', 'HcnsController@valid');
    Route::post('/updateRecord/{id}', 'HcnsController@updateRecord');
    Route::get('/getAllRecord', 'HcnsController@getAllRecord');
    Route::post('/getAllHcns', 'HcnsController@getAllHcns');
});

