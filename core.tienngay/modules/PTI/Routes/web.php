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

Route::prefix('pti')->group(function() {
	Route::get('/', function() {
		echo "Wellcome to PTI module";
	});
    Route::post('/createForm', 'PTIController@createForm');
    Route::post('/orderByContract', 'PTIController@orderByContract');
    Route::post('/orderByBN', 'PTIController@orderByBN');
    Route::post('/apiCreateOrder', 'PTIController@apiCreateOrder');
    Route::post('/apiGetPdfFile', 'PTIController@apiGetPdfFile');
    Route::prefix('bhtn')->group(function() { // Bảo Hiểm Tai Nạn Con Người
    	Route::post('/orderByContract', 'PTIBaoHiemTaiNan@orderByContract');
        Route::post('/apiGetPdfFile', 'PTIBaoHiemTaiNan@apiGetPdfFile');
        Route::post('/orderBhtnBN', 'PTIBaoHiemTaiNan@orderBhtnBN');
        Route::post('/callOrderBN', 'PTIBaoHiemTaiNan@callOrderBN');
        Route::post('/bhtnPayment', 'PTIBaoHiemTaiNan@bhtnPayment');
    });
});
