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

Route::prefix('/appkh')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module Appkh");
    });
    Route::post('/getUserWaitAuth', 'AuthController@getUserWaitAuth');
    Route::post('/ekyc', 'AuthController@ekyc');
    Route::post('/checkEkyc', 'AuthController@checkEkyc');
});

