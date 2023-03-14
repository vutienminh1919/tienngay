<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\VFCPayment\Http\Middleware\Authorization;

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

Route::prefix('vfcpayment')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module VFCPayment");
    });

    Route::post('/getContractList', 'VFCPaymentController@getContractList')->middleware(Authorization::class);
    Route::post('/getPayment', 'VFCPaymentController@getPayment')->middleware(Authorization::class);
    Route::post('/search_van', 'VFCPaymentController@getAllContractsbyVan')->middleware(Authorization::class);
    Route::post('/multiQr', 'QRCodeController@multiQr')->middleware(Authorization::class);
    Route::post('/multiQrLink', 'QRCodeController@multiQrLink')->middleware(Authorization::class);
    Route::post('/getQrCode', 'VFCPaymentController@getQrCode')->middleware(Authorization::class);//phiếu thu tiền mặt
});
