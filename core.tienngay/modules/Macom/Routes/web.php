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

Route::prefix('/macom')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module MACOM");
    });
    Route::post('/save','MacomController@save');
    Route::post('/get_domain_MB','MacomController@get_domain_MB');
    Route::post('/getStoreByCodeArea', 'MacomController@getStoreByCodeArea');
    Route::post('/update/{id}', 'MacomController@update');
    Route::post('/getAreaByDomain', 'MacomController@getAreaByDomain');
});

