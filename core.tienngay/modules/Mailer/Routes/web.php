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

Route::prefix('mailer')->group(function() {
	Route::get('/', function() {
		echo "Wellcome to Mailer module";
	});

	Route::post('/sendEmailApi','MailController@sendEmailApi');
	Route::post('/toolSendEmail','MailController@toolSendEmail');
	Route::post('/getCodeEmail','MailController@getCodeEmail');
	Route::post('/saveTemplate','MailController@saveTemplate');
	Route::post('/getSubject','MailController@getSubject');
	Route::post('/updateTemplate/{id}','MailController@updateTemplate');
	Route::post('/getMessage','MailController@getMessage');
	Route::post('/getUserMkt','MailController@getUserMkt');
	Route::post('/getSlug','MailController@getSlug');
	Route::post('/sendEmailCheckPass','MailController@sendEmailCheckPass');
	Route::post('/mailTenancy','MailController@sendMailTenancy');
	Route::post('/sendMailTrade','MailController@sendMailTrade');
});
