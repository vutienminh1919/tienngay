<?php

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

use Modules\ViewCpanel\Http\Middleware\PaymentHolidays;
use Modules\ViewCpanel\Http\Middleware\TokenIsValid;
use Modules\ViewCpanel\Http\Middleware\VerifyCsrfToken;

Route::middleware([
    TokenIsValid::class, 
    PaymentHolidays::class,
    VerifyCsrfToken::class
])->prefix('/payment-holiday')->group(function() {
    Route::get('/index','PaymentHolidayController@index')->name('viewcpanel::PaymentHolidays.index');
    Route::get('/detail/{id}','PaymentHolidayController@detail')->name('viewcpanel::PaymentHolidays.detail');
    Route::get('/edit/{id}','PaymentHolidayController@edit')->name('viewcpanel::PaymentHolidays.edit');
    Route::post('/store','PaymentHolidayController@store')->name('viewcpanel::PaymentHolidays.store');
    Route::post('/update','PaymentHolidayController@update')->name('viewcpanel::PaymentHolidays.update');
    Route::post('/updateStatus','PaymentHolidayController@updateStatus')->name('viewcpanel::PaymentHolidays.updateStatus');
    Route::post('/delete','PaymentHolidayController@delete')->name('viewcpanel::PaymentHolidays.delete');
});
