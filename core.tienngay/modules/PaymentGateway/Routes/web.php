<?php

use Illuminate\Http\Response;
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

Route::prefix('paymentgateway')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module PaymentGateway");
    });

    Route::get('/document', function() {
        $openapi = \OpenApi\Generator::scan([__DIR__.'/../Http']);
        header('Content-Type: application/x-yaml');
        return $openapi->toYaml();
    });

    // MoMo group route
    Route::prefix('momo')->group(function() {
    	Route::post('/getBillInfo', 'MoMoAppController@getBillInfo');
    	Route::post('/notifyPaymentResult', 'MoMoAppController@notifyPaymentResult');
    	Route::post('/listTransactionByMonth', 'MoMoAppController@listTransactionByMonth')->name('PaymentGateway::Momo.listTransactionByMonth');
    	Route::post('/searchTransactions', 'MoMoAppController@searchTransactions')->name('PaymentGateway::Momo.searchTransaction');
        Route::post('/getContractList', 'MoMoAppController@getContractList');
        Route::post('/checkTransactionStatus', 'MoMoAppController@checkTransactionStatus');
        Route::post('/autoConfirm', 'MoMoAppController@autoConfirm');
    });

    // MoMo group route
    Route::prefix('momo/reconciliation')->group(function() {
        Route::post('/create', 'TransactionReconciliationController@store');
        Route::post('/getListByMonth', 'TransactionReconciliationController@getListByMonth');
        Route::post('/delete', 'TransactionReconciliationController@delete');
        Route::post('/sendEmail', 'TransactionReconciliationController@sendEmail');
    });
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    // MoMo group route
    Route::prefix('momo/appKH')->group(function() {
        Route::post('/initPayment', 'MoMoAppKHController@initPayment')->name('PaymentGateway::Momo.appKH.initPayment');
        Route::get('/callback', 'MoMoAppKHController@callback')->name('PaymentGateway::Momo.appKH.callback');
        Route::post('/notify', 'MoMoAppKHController@notify')->name('PaymentGateway::Momo.appKH.notify');
        Route::post('/transactionInfo', 'MoMoAppKHController@transactionInfo');
    });

    // MoMo group route
    Route::prefix('momo/appNDT')->group(function() {
        Route::post('/initPayment', 'MoMoAppNDTController@initPayment')->name('PaymentGateway::Momo.appKH.initPayment');
        Route::get('/callback', 'MoMoAppNDTController@callback')->name('PaymentGateway::Momo.appKH.callback');
        Route::post('/notify', 'MoMoAppNDTController@notify')->name('PaymentGateway::Momo.appKH.notify');
        Route::post('/transactionInfo', 'MoMoAppNDTController@transactionInfo');
    });

    if (env('APP_ENV') != 'product') {
        Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    }
    //download log
    Route::get('/logs/momo/{date}', function (Request $request, $date) {
        $pass = $request->input("pw");
        if ($pass !== env("PASS_LOG")) {
            return;
        }
        $path = storage_path('momo/momo-'. $date . '.log');
        if (!file_exists($path)) {
            return;
        }
        return response()->download($path);
    });
    Route::get('/logs/cronjob/{date}', function (Request $request, $date) {
        $pass = $request->input("pw");
        if ($pass !== env("PASS_LOG")) {
            return;
        }
        $path = storage_path('cronjob-logs/laravel-'. $date . '.log');
        if (!file_exists($path)) {
            return;
        }
        return response()->download($path, 'cron-'. $date . '.log');
    });
    Route::get('/logs/logs/{date}', function (Request $request, $date) {
        $pass = $request->input("pw");
        if ($pass !== env("PASS_LOG")) {
            return;
        }
        $path = storage_path('logs/laravel-'. $date . '.log');
        if (!file_exists($path)) {
            return;
        }
        return response()->download($path, 'log-'. $date . '.log');
    });
});
