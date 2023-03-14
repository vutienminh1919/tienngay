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

Route::prefix('payment-holiday')->group(function () {
    Route::get('/', function () {
        echo "Wellcome to PaymentHoliday module";
    });
    Route::post('/create', 'PaymentHolidayController@store');
    Route::post('/edit', 'PaymentHolidayController@edit');
    Route::post('/status', 'PaymentHolidayController@updateStatus');
    Route::post('/delete', 'PaymentHolidayController@delete');
});
