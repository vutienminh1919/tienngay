<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

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

Route::prefix('report')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module Report");
    });
    Route::prefix('reportForm3')->group(function() {
	    Route::post('/search', 'ReportForm3Controller@search');
	    Route::post('/importDungTinhLai', 'ReportForm3Controller@importDungTinhLai');
	});

    Route::prefix('reportForm2')->group(function() {
        Route::post('/search', 'ReportForm2Controller@search');
    });

    Route::prefix('logTran')->group(function() {
        Route::post('/search', 'ReportLogTransactionController@search');
    });

    Route::prefix('reportForm23')->group(function() {
        Route::post('/search', 'ReportForm23Controller@search');
    });
});
