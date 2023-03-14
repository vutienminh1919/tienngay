<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
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

Route::prefix('/blacklist')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module BlackList");
    });
    Route::post('/saveHcns', 'BlackListController@saveHcns');
    Route::post('/getHcns', 'BlackListController@getHcns');


    Route::post('/property', 'BlackListController@saveProperty');
    //cron job
    Route::post('/cronJobBlacklist', 'BlackListController@insertBlacklist');
    Route::post('/exemtion', 'BlackListController@saveExemtion');
    Route::post('/exemtion/list', 'BlackListController@getAllExemtion');
    Route::post('/exemtion/detail', 'BlackListController@detailExemtion');
    Route::post('/addScanHcns', 'BlackListController@getHcnsNoScan');
    Route::post('/removeProperty', 'BlackListController@removeProperty');

});

