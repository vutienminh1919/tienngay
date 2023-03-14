<?php

//use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\Tenancy\Http\Middleware\Tenancy_ke_toan_valid;
use Modules\Tenancy\Http\Middleware\Tenancy_ptmb_valid;

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

Route::prefix('/tenancy')->group(function () {

    Route::get('/', function () {
        echo("Wellcome to module tenancy");
    });
    Route::middleware('auth_tenancy')->group(function () {
        Route::middleware('check_ke_toan')->group(function () {

           Route::post('/detail_tenancy/{id}', 'TenancyController@detail_tenancy');
           Route::post('/update_status/{id}', 'TenancyController@update_status');
           Route::post('/toi_han', 'PaymentPeriodController@toi_han');
           Route::post('/qua_han', 'PaymentPeriodController@qua_han');
        });
        Route::post('/update_tenancy/{id}', 'TenancyController@update_tenancy');
        Route::post('/findOneAppendix/{id}', 'TenancyController@findOneAppendix');
        Route::post('/insert_new_tenancy/{id}', 'TenancyController@newInsertKyHan');
        Route::post('/Thanh_ly_hop_dong/{id}', 'TenancyController@Thanh_ly_hop_dong');
        Route::post('/find_tenancy/{id}', 'TenancyController@findData');
        Route::post('/findLogs/{id}', 'TenancyController@findLogs');
        Route::post('/uploadScanHd', 'TenancyController@uploadScanHd');
        Route::post('/getAll/{code_contract}', 'TenancyController@getAll');
        Route::post('/create_tenancy', 'TenancyController@create_tenancy');
        Route::post('/history_payment_deposit/{id}', 'TenancyController@history_payment_deposit');
        Route::post('/findImageKyHan', 'PaymentPeriodController@findImageKyHan');

        //update có cả kt lẫn phát triển mặt bằng
        Route::post('/update_tenancy_status_block/{id}', 'TenancyController@update_tenancy_status_block')
        ->middleware(Tenancy_ptmb_valid::class,Tenancy_ke_toan_valid::class);
        //list có cả kt lẫn phát triển mặt bằng
        Route::post('/list', 'TenancyController@get_data_tenancy');
        Route::post('/getAll_tenancy', 'PaymentPeriodController@createData');
        Route::post('/payment_tenancy/{id}', 'PaymentPeriodController@payment_Tenancy');
        Route::post('/thanh_toan_thue/{id}', 'PaymentPeriodController@thanh_toan_thue');
        Route::post('/updateTienCocChuNha/{id}', 'PaymentPeriodController@updateTienCocChuNha');
        Route::post('/note_tenancy', 'PaymentPeriodController@note_tenancy');
        Route::post('/find_one_payment_priod/{id}', 'PaymentPeriodController@find_one_payment_priod');
        Route::post('/updateTienCocChuNha/{id}', 'PaymentPeriodController@updateTienCocChuNha');
        Route::post('/note_tenancy', 'PaymentPeriodController@note_tenancy');
        Route::post('/updateMoney', 'PaymentPeriodController@updateMoney');
        Route::post('/updateMoneyPax', 'PaymentPeriodController@updateMoneyPax');
        Route::post('/update_payment_ky_han/{id}', 'PaymentPeriodController@update_payment_ky_han');
        Route::post('/find_one_payment_priod_ky_han', 'PaymentPeriodController@find_one_payment_priod_ky_han');
        Route::post('/history_payment_deposit_home/{id}', 'TenancyController@history_payment_deposit_home');
        Route::post('/find_one_id_Tenancy/{id}', 'TenancyController@find_one_id_Tenancy');

    });

    Route::post('/createData', 'NotificationPaymentController@createData');
    Route::post('/send_notification', 'NotificationPaymentController@send_notification');
    Route::post('/getDataAll', 'NotificationPaymentController@getDataAll');
    Route::post('/statusNotification/{id}', 'NotificationPaymentController@statusNotification');
    Route::post('/statusNotification/{id}', 'NotificationPaymentController@statusNotification');
    Route::post('/get_all_tenancy', 'NotificationPaymentController@get_all_tenancy');
    Route::post('/contract_active', 'NotificationPaymentController@contract_active');
    Route::post('/send_notification_email', 'NotificationPaymentController@send_notification_email');
    Route::post('/get_all_tenancy_hdtl', 'TenancyController@get_all_tenancy_hdtl');
    Route::post('/thanh_ly_hop_dong_tenancy/{id}', 'TenancyController@thanh_ly_hop_dong_tenancy');

    Route::post('/send_mail_toi_han', 'PaymentPeriodController@send_mail_toi_han');
    Route::post('/send_mail_qua_han', 'PaymentPeriodController@send_mail_qua_han');

    Route::post('/test/{id}', 'TenancyController@test');
    Route::post('/test', 'TenancyController@test1');
    Route::post('/findUserPtmb', 'TenancyController@findUserPtmb');
});
