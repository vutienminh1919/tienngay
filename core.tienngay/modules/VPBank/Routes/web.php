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

Route::prefix('vpbank')->group(function() {

    Route::get('/', function () {
        echo("Wellcome to module VPBank");
    });
    Route::post('/createVirtualAccount', 'VPBankController@createVirtualAccount');
    Route::post('/updateVirtualAccount', 'VPBankController@updateVirtualAccount');
    Route::post('/getBankList', 'VPBankController@getBankList');
    Route::post('/getBranchList', 'VPBankController@getBranchList');
    Route::post('/getBeneficiaryInfo', 'VPBankController@getBeneficiaryInfo');
    Route::post('/getVan', 'VPBankController@getVitualAccountNumber');
    Route::prefix('transaction')->group(function() {
    	Route::post('/notification', 'VPBankController@notification');
        Route::post('/getListByMonth', 'VPBankController@listTransactionByMonth');
        Route::post('/searchTransactions', 'VPBankController@searchTransactions');
        Route::post('/notifiAPIHandle', 'VPBankController@notifiAPIHandle');
    });
    Route::prefix('mistakentransaction')->group(function() {
        Route::post('/getListByMonth', 'MistakenVpbankController@listTransactionByMonth');
        Route::post('/searchTransactions', 'MistakenVpbankController@searchTransactions');
        Route::post('/getAllTransactions', 'MistakenVpbankController@getAllTransactions');
    });

    if (env('APP_ENV') != 'product') {
        Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
        Route::get('/document', function() {
            $openapi = \OpenApi\Generator::scan([__DIR__.'/../Http']);
            header('Content-Type: application/x-yaml');
            return $openapi->toYaml();
        });
    }

    Route::get('/logs/vpbank/{date}', function (Request $request, $date) {
        $pass = $request->input("pw");
        if ($pass !== env("PASS_LOG")) {
            return;
        }
        $path = storage_path('vpbank/vpbank-'. $date . '.log');
        if (!file_exists($path)) {
            return;
        }
        return response()->download($path, 'vpbank-'. $date . '.log');
    });

});
