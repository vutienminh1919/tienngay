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

use Modules\ViewCpanel\Http\Middleware\Ksnb_Tbp_valid;
use Modules\ViewCpanel\Http\Middleware\KsnbReport;
use Modules\ViewCpanel\Http\Middleware\KsnbValid;
use Modules\ViewCpanel\Http\Middleware\TokenIsValid;
use Modules\ViewCpanel\Http\Middleware\hcnsUser;
use Modules\ViewCpanel\Http\Middleware\VerifyCsrfToken;
use Modules\ViewCpanel\Http\Middleware\HeyuValid;
use Modules\ViewCpanel\Http\Middleware\ReportLogTransaction;

Route::prefix('cpanel')->group(function() {
    Route::get('/open-app', function () {
        return view('viewcpanel::page.openApp', []);
    });
    // MoMo group route
    Route::prefix('momo')->group(function() {
        Route::get('/transactions', 'MoMoViewController@index');
        Route::get('/transaction/{id}', 'MoMoViewController@show');

        Route::post('/listTransactionByMonth', 'MoMoViewController@listTransactionByMonth')->name('ViewCpanel::Momo.listTransactionByMonth');
        Route::post('/searchTransactions', 'MoMoViewController@searchTransactions')->name('ViewCpanel::Momo.searchTransaction');
        Route::post('/autoConfirm', 'MoMoViewController@autoConfirm')->name('ViewCpanel::Momo.autoConfirm');

    });

    Route::prefix('momo/reconciliation')->group(function() {
        Route::post('/create', 'TransactionReconciliationViewController@createReconciliation')->name('ViewCpanel::Momo.reconciliation.create');
        Route::get('/details/{id}', 'TransactionReconciliationViewController@show')->name('ViewCpanel::Momo.reconciliation.details');
        Route::post('/details/sendEmail', 'TransactionReconciliationViewController@sendEmail')->name('ViewCpanel::Momo.reconciliation.details.sendEmail');
        Route::post('/details/cancel', 'TransactionReconciliationViewController@delete')->name('ViewCpanel::Momo.reconciliation.details.cancel');
        Route::get('/index', 'TransactionReconciliationViewController@index')->name('ViewCpanel::Momo.reconciliation.index');
        Route::post('/getListByMonth', 'TransactionReconciliationViewController@getListByMonth')->name('ViewCpanel::Momo.reconciliation.getListByMonth');
    });
    // VPBank group route
    Route::prefix('vpbank')->group(function() {
         Route::prefix('mistakentransaction')->group(function() {
            Route::get('/index', 'MistakenVpbankController@transaction')->name('ViewCpanel::VPBank.mistakentransaction.transactions');
            Route::post('/transactions/getListByMonth', 'MistakenVpbankController@listTransactionByMonth')->name('ViewCpanel::VPBank.mistakentransaction.getListByMonth');
            Route::post('/transactions/searchTransactions', 'MistakenVpbankController@searchTransactions')->name('ViewCpanel::VPBank.mistakentransaction.searchTransaction');
        });
        Route::get('/tran-detail/{id}', 'VPBankViewController@show');
        Route::get('/transactions', 'VPBankViewController@transaction')->name('ViewCpanel::VPBank.transactions');
        Route::post('/transactions/getListByMonth', 'VPBankViewController@listTransactionByMonth')->name('ViewCpanel::VPBank.transaction.getListByMonth');
        Route::post('/transactions/searchTransactions', 'VPBankViewController@searchTransactions')->name('ViewCpanel::VPBank.transaction.searchTransaction');
        Route::get('/download-report', 'VPBankViewController@downloadReport')->name('ViewCpanel::VPBank.downloadReport');
        Route::get('/storeCodes', 'VPBankViewController@storeCodes')->name('ViewCpanel::VPBank.storeCodes');
    });

    // Report group route
    Route::prefix('report')->group(function() {
    // Route::middleware([TokenIsValid::class, VerifyCsrfToken::class])->prefix('report')->group(function() {
        Route::get('/form3', 'ReportViewController@reportForm3');
        Route::post('/form3/search', 'ReportViewController@search')->name('ViewCpanel::ReportForm3.search');
        Route::post('/form3/importExcel', 'ReportViewController@importExcel')->name('viewcpanel::ReportForm3.importExcel');
        Route::get('/bieu-mau', 'ReportViewController@downloadBieuMau')->name('viewcpanel::ReportForm3.downloadBieuMau');

        Route::get('/form2', 'ReportForm2ViewController@reportForm2');
        Route::post('/form2/search', 'ReportForm2ViewController@search')->name('ViewCpanel::ReportForm2.search');

        Route::get('/logTran', 'ReportLogTransactionController@index')->middleware(ReportLogTransaction::class);
        Route::post('/logTran/search', 'ReportLogTransactionController@search')->middleware(ReportLogTransaction::class)->name('ViewCpanel::Report.logTran.search');

        Route::get('/form23', 'ReportForm23Controller@reportForm23');
        Route::post('/form23/search', 'ReportForm23Controller@search')->name('ViewCpanel::ReportForm23.search');
    });

    // Export Excel group route
    Route::prefix('exportExcel')->group(function() {
        Route::get('/exportAllLead', 'ExportExcelController@exportAllLead');
        Route::get('/exportGic_plt', 'ExportExcelController@exportGic_plt');
        Route::get('/exportGic', 'ExportExcelController@exportGic');
        Route::get('/exportGicEasy', 'ExportExcelController@exportGicEasy');
        Route::get('/exportMicTnds', 'ExportExcelController@exportMicTnds');
        Route::get('/exportMic', 'ExportExcelController@exportMic');
        Route::get('/exportContractTnds', 'ExportExcelController@exportContractTnds');
        Route::get('/exportVbiUtv', 'ExportExcelController@exportVbiUtv');
        Route::get('/exportVbiSxh', 'ExportExcelController@exportVbiSxh');
        Route::get('/exportVbiSxhBn', 'ExportExcelController@exportVbiSxhBn');
        Route::get('/exportVbiUtvBn', 'ExportExcelController@exportVbiUtvBn');
        Route::get('/exportVbiTnds', 'ExportExcelController@exportVbiTnds');
    });

    //Reports Ksnb
    Route::middleware(TokenIsValid::class)->prefix('reportsKsnb')->group(function() {
        // Route::get('/listReports', 'KsnbViewController@listReports')->name('ViewCpanel::ReportsKsnb.listReports');
        Route::get('/createReport', 'KsnbViewController@createReport')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::ReportsKsnb.createReport');
        Route::post('/saveReport', 'KsnbViewController@saveReport')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::ReportsKsnb.saveReport');
        Route::get('/editReport/{id}', 'KsnbViewController@editReport')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::ReportsKsnb.editReport');
        Route::post('/updateReport/{id}', 'KsnbViewController@updateReport')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::ReportsKsnb.updateReport');
        Route::get('/detailReport/{id}', 'KsnbViewController@detailReport')->middleware(TokenIsValid::class, Ksnb_Tbp_valid::class)->name('ViewCpanel::ReportKsnb.detailReport');
        Route::get('/filter', 'KsnbViewController@filter')->name('ViewCpanel::ReportKsnb.filterReport');
        Route::post('/updateProcess/{id}', 'KsnbViewController@updateProcess')->middleware(TokenIsValid::class,KsnbReport::class)->name('ViewCpanel::ReportKsnb.updateProcess');

        Route::post('/uploadImage','KsnbViewController@uploadImage')->name('ViewCpanel::ReportKsnb.uploadImage');
        Route::post('/getCodeByType','KsnbViewController@getCodeByType')->name('ViewCpanel::ReportKsnb.getCodeByType');
        Route::post('/getPunishmentByCode','KsnbViewController@getPunishmentByCode')->name('ViewCpanel::ReportKsnb.getPunishmentByCode');
        Route::post('/getDisciplineByCode','KsnbViewController@getDisciplineByCode')->name('ViewCpanel::ReportKsnb.getDisciplineByCode');
        Route::post('/getDescription','KsnbViewController@getDescription')->name('ViewCpanel::ReportKsnb.getDescription');
        Route::post('/getNameByEmail','KsnbViewController@getNameByEmail')->name('ViewCpanel::ReportKsnb.getNameByEmail');
        Route::post('/allMailRoll','KsnbViewController@allMailRoll')->name('ViewCpanel::ReportKsnb.allMailRoll');
        Route::post('/getAllRoom','KsnbViewController@getAllRoom')->name('ViewCpanel::ReportKsnb.getAllRoom');

//
        Route::get('/list_users_ksnb','KsnbViewController@list_users_ksnb')->middleware(TokenIsValid::class)->name('ViewCpanel::ReportsKsnb.listReports');
//
        Route::post('/updateNotConfrim/{id}','KsnbViewController@updateNotConfrim')->middleware(TokenIsValid::class,KsnbReport::class)->name('ViewCpanel::ReportKsnb.updateNotConfrim');
        Route::post('/updateReConfrim/{id}','KsnbViewController@updateReConfrim')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::ReportKsnb.updateReConfrim');
        Route::get('/feedbackReport/{id}','KsnbViewController@feedback')->middleware(TokenIsValid::class)->name('ViewCpanel::ReportsKsnb.feedbackReport');
        Route::post('/sendfeedback/{id}', 'KsnbViewController@sendfeedback')->middleware(TokenIsValid::class)->name('ViewCpanel::ReportsKsnb.sendfeedback');
        Route::post('/getEmployeesByStoreId', 'KsnbViewController@getEmployeesByStoreId')->name('ViewCpanel::ReportKsnb.getEmployeesByStoreId');
        Route::post('/getEmailCHTByStoreId', 'KsnbViewController@getEmailCHTByStoreId')->name('ViewCpanel::ReportKsnb.getEmailCHTByStoreId');

        Route::post('/updateinfer/{id}', 'KsnbViewController@updateInfer')->middleware(TokenIsValid::class,KsnbReport::class)->name('ViewCpanel::ReportsKsnb.infer');
        Route::post('/updateWaitConfrim/{id}', 'KsnbViewController@updateWaitConfrim')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::ReportsKsnb.WaitConfrim');

        Route::post('/getErrorCodeInfo', 'KsnbViewController@getErrorCodeInfo')->name('ViewCpanel::ReportsKsnb.getErrorCodeInfo');

        Route::post('/cancelRpNv/{id}', 'KsnbViewController@cancelRpNv')->name('ViewCpanel::ReportsKsnb.cancelRpNv');
        Route::post('/cancelRpTbp/{id}', 'KsnbViewController@cancelRpTbp')->name('ViewCpanel::ReportsKsnb.cancelRpTbp');

        Route::post('/ksnbFeedbackReport/{id}', 'KsnbViewController@ksnbFeedback')->middleware(TokenIsValid::class)->name('ViewCpanel::ReportsKsnb.ksnbFeedback');

        Route::post('/waitInfer/{id}', 'KsnbViewController@waitInfer')->middleware(TokenIsValid::class)->name('ViewCpanel::ReportsKsnb.waitInfer');

        Route::post('/endTimeReport', 'KsnbViewController@endTimeReport')->name('ViewCpanel::ReportsKsnb.endTimeReport');

        Route::post('/sendCeo/{id}','KsnbViewController@sendCeo')->name('ViewCpanel::ReportsKsnb.sendCeo');
        Route::post('/ceoNotConfirm/{id}','KsnbViewController@ceoNotConfirm')->name('ViewCpanel::ReportsKsnb.ceoNotConfirm');
        Route::post('/ceoConfirm/{id}','KsnbViewController@ceoConfirm')->name('ViewCpanel::ReportsKsnb.Confirm');


        //Route phiếu ghi nhận start
        Route::post('/getQuoteDocument', 'KsnbViewController@getQuoteDocument')->name('ViewCpanel::ReportKsnb.getQuoteDocument');
        Route::get('/download', 'KsnbViewController@download')->name('ViewCpanel::ReportKsnb.download');
        Route::get('/getAllNote', 'NoteKsnbViewController@listAllNote')->name('ViewCpanel::NoteKsnb.listAllNote');
        Route::post('/saveNote', 'NoteKsnbViewController@saveNote')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::NoteKsnb.saveNote');
        Route::get('/createNote', 'NoteKsnbViewController@createNote')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::NoteKsnb.createNote');
        Route::get('/detailNote/{id}', 'NoteKsnbViewController@detailNote')->middleware(TokenIsValid::class, Ksnb_Tbp_valid::class)->name('ViewCpanel::NoteKsnb.detailNote');
        Route::post('/updateNote/{id}', 'NoteKsnbViewController@updateNote')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::NoteKsnb.updateNote');
        Route::get('/editNote/{id}', 'NoteKsnbViewController@editNote')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::NoteKsnb.editNote');
        Route::post('/getUserActive','NoteKsnbViewController@getUserActive')->name('ViewCpanel::NoteKsnb.getUserActive');
        Route::post('/waitConfirmNote/{id}','NoteKsnbViewController@waitConfirmNote')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::NoteKsnb.waitConfirmNote');
        Route::post('/notConfirmNote/{id}','NoteKsnbViewController@notConfirmNote')->middleware(TokenIsValid::class,KsnbReport::class)->name('ViewCpanel::NoteKsnb.notConfirmNote');
        Route::post('/reConfirmNote/{id}','NoteKsnbViewController@reConfirmNote')->middleware(TokenIsValid::class,KsnbValid::class)->name('ViewCpanel::NoteKsnb.reConfirmNote');
        Route::post('/confirmNote/{id}','NoteKsnbViewController@confirmNote')->middleware(TokenIsValid::class,KsnbReport::class)->name('ViewCpanel::NoteKsnb.confirmNote');
        Route::post('/userFeedback/{id}','NoteKsnbViewController@userFeedback')->name('ViewCpanel::NoteKsnb.userFeedback');
        Route::post('/ksnbFeedback/{id}','NoteKsnbViewController@ksnbFeedback')->name('ViewCpanel::NoteKsnb.ksnbFeedback');
        Route::post('/waitInferNote/{id}','NoteKsnbViewController@waitInferNote')->name('ViewCpanel::NoteKsnb.waitInferNote');
        Route::post('/inferNote/{id}','NoteKsnbViewController@inferNote')->middleware(TokenIsValid::class,KsnbReport::class)->name('ViewCpanel::NoteKsnb.inferNote');
        Route::get('/feedback/{id}','NoteKsnbViewController@feedback')->name('ViewCpanel::NoteKsnb.feedback');
    });


    Route::prefix('/ksnb_erors')->group(function (){
       Route::get('/list','KsnbCodeErrorsController@list')->middleware(TokenIsValid::class,KsnbValid::class)->name('viewcpanel::ksnbErrors.list');
       Route::get('/create','KsnbCodeErrorsController@create')->middleware(TokenIsValid::class,KsnbValid::class)->name('viewcpanel::ksnbErrors.create');
       Route::post('/save','KsnbCodeErrorsController@save')->middleware(TokenIsValid::class,KsnbValid::class)->name('viewcpanel::ksnbErrors.save');
       Route::get('/edit/{id}','KsnbCodeErrorsController@edit')->middleware(TokenIsValid::class,KsnbValid::class)->name('viewcpanel::ksnbErrors.edit');
       Route::post('/update/{id}','KsnbCodeErrorsController@update')->middleware(TokenIsValid::class,KsnbValid::class)->name('viewcpanel::ksnbErrors.update');
       Route::get('/detail/{id}','KsnbCodeErrorsController@detail')->middleware(TokenIsValid::class,KsnbValid::class)->name('viewcpanel::ksnbErrors.detail');
       Route::post('/status','KsnbCodeErrorsController@status')->middleware(TokenIsValid::class,KsnbValid::class)->name('viewcpanel::ksnbErrors.updateStatus');
    });

    Route::middleware([VerifyCsrfToken::class])->prefix('/pti')->group(function (){
        Route::prefix('/bhtn')->group(function (){
            Route::get('/','PTIViewController@bhtnIndex')->middleware(TokenIsValid::class);
            Route::get('/ban-ngoai','PTIViewController@bnIndex')->middleware(TokenIsValid::class);
            Route::get('/doi-soat','PTIViewController@doiSoatIndex')->middleware(TokenIsValid::class);
            Route::post('/search', 'PTIViewController@search')->middleware(TokenIsValid::class)->name('ViewCpanel::pti.bhtn.search');
            Route::get('/exportGCN', 'PTIViewController@exportGCN')->middleware(TokenIsValid::class)->name('ViewCpanel::pti.bhtn.exportGCN');
            Route::get('/order-bn','PTIViewController@bhtnBN')->name('ViewCpanel::pti.bhtn.orderBn');
            Route::post('/create-order-bn','PTIViewController@orderBhtnBN')->name('ViewCpanel::pti.bhtn.orderBhtnBN');
            Route::post('/check-payment','PTIViewController@bhtnCheckPayment')->name('ViewCpanel::pti.bhtn.checkPayment');
            Route::get('/pgd-bn','PTIViewController@pgdBN')->middleware(TokenIsValid::class)->name('ViewCpanel::pti.bhtn.pgdBN');
            Route::post('/pgd-create-order-bn','PTIViewController@pgdOrderBhtnBN')->middleware(TokenIsValid::class)->name('ViewCpanel::pti.bhtn.pgdOrderBhtnBN');
        });
    });

    Route::middleware([VerifyCsrfToken::class, TokenIsValid::class, hcnsUser::class])->prefix('/hcns')->group(function (){
        Route::get('/', function () {
            echo("Wellcome to module HCNS");
        });
        Route::get('/listRecord','HcnsController@listAllRecord')->name('viewcpanel::hcns.listRecord');
        Route::get('/createRecord','HcnsController@createRecord')->name('viewcpanel::hcns.createRecord');
        Route::get('/detailRecord/{id}', 'HcnsController@detailRecord')->name('viewcpanel::hcns.detailRecord');
        Route::get('/editRecord/{id}', 'HcnsController@editRecord')->name('viewcpanel::hcns.editRecord');
        Route::post('/saveRecord', 'HcnsController@saveRecord')->name('viewcpanel::hcns.saveRecord');
        Route::post('/updateRecord/{id}', 'HcnsController@updateRecord')->name('viewcpanel::hcns.updateRecord');
        Route::post('/uploadImage','HcnsController@uploadImage')->name('viewcpanel::hcns.uploadImage');
        Route::post('/importExcel', 'HcnsController@importExcelHcns')->name('viewcpanel::hcns.importExcel');
        Route::get('/exportExcel', 'HcnsController@exportExcel')->name('viewcpanel::hcns.exportExcel');
        Route::get('/download', 'HcnsController@downloadFile')->name('viewcpanel::hcns.download');
    });

    Route::prefix('/blacklist')->group(function() {
        Route::get('/', 'BlackListController@getPropertyBlacklist')->name('viewcpanel::blacklist.list');
        Route::post('/search', 'BlackListController@searchBlacklist')->name('viewcpanel::blacklist.search');
        Route::get('/detailProperty/{id}', 'BlackListController@detailProperty')->name('viewcpanel::blackList.detailProperty');
        Route::get('/detailHcns/{id}', 'BlackListController@detailHcns')->name('viewcpanel::blackList.detailHcns');
        Route::get('/detailExemtion/{id}', 'BlackListController@detailExemtion')->name('viewcpanel::blackList.detailExemtion');
    });

    Route::middleware([TokenIsValid::class])->prefix('/toolSendEmail')->group(function() {
        Route::get('/', function () {
            echo("Wellcome to module Mailer");
        });
        Route::get('/sendEmail', 'MailController@sendMail')->name('viewcpanel::toolSendEmail.sendEmail');
        Route::post('/saveTemplate', 'MailController@saveTemplate')->name('viewcpanel::toolSendEmail.saveTemplate');
        Route::post('/import', 'MailController@importListEmail')->name('viewcpanel::toolSendEmail.import');
        Route::post('/getCodeEmail', 'MailController@getCodeEmail')->name('viewcpanel::toolSendEmail.getCodeEmail');
        Route::post('/getSubject', 'MailController@getSubject')->name('viewcpanel::toolSendEmail.getSubject');
        Route::get('/download', 'MailController@downloadFile')->name('viewcpanel::toolSendEmail.downloadFile');
        Route::get('/createTemplate', 'MailController@createTemplate')->name('viewcpanel::toolSendEmail.createTemplate');
        Route::get('/editTemplate/{id}', 'MailController@editTemplate')->name('viewcpanel::toolSendEmail.editTemplate');
        Route::post('/updateTemplate{id}', 'MailController@updateTemplate')->name('viewcpanel::toolSendEmail.updateTemplate');
        Route::get('/indexTempale', 'MailController@indexTempale')->name('viewcpanel::toolSendEmail.indexTempale');
        Route::post('/getMessage', 'MailController@getMessage')->name('viewcpanel::toolSendEmail.getMessage');
        Route::post('/getSlug', 'MailController@getSlug')->name('viewcpanel::toolSendEmail.getSlug');
    });

      Route::middleware([TokenIsValid::class, VerifyCsrfToken::class, HeyuValid::class])->prefix('/heyu')->group(function() {
          Route::get('/', 'HeyuStoreController@index')->name('viewcpanel::heyu.index');
          Route::post('/insert', 'HeyuStoreController@insert')->name('viewcpanel::heyu.insert');
          Route::get('/create', 'HeyuStoreController@create')->name('viewcpanel::heyu.create');
          Route::post('/getStatusHeyu', 'HeyuStoreController@getStatusHeyu')->name('viewcpanel::heyu.getStatusHeyu');
          Route::get('/searchDriver', 'HeyuStoreController@searchDriver')->name('viewcpanel::heyu.searchDriver');
          Route::get('/searchUniformHeyu', 'HeyuStoreController@searchUniformHeyu')->name('viewcpanel::heyu.searchUniformHeyu');
          Route::post('/inventoryHeyu', 'HeyuStoreController@inventoryHeyu')->name('viewcpanel::heyu.inventoryHeyu');
          Route::post('/detailById', 'HeyuStoreController@detailById')->name('viewcpanel::heyu.detailById');
          Route::get('/update', 'HeyuStoreController@update')->name('viewcpanel::heyu.update'); //nhập kho
          Route::post('/updateUniformTienngay', 'HeyuStoreController@updateUniformTienngay')->name('viewcpanel::heyu.updateUniformTienngay'); // nhập kho
          Route::get('/edit/{id}', 'HeyuStoreController@edit')->name('viewcpanel::heyu.edit'); // sửa kho
          Route::post('/editUniformTienngay', 'HeyuStoreController@editUniformTienngay')->name('viewcpanel::heyu.editUniformTienngay'); // sửa kho

          Route::get('/history/{id}', 'HeyuStoreController@history')->name('viewcpanel::heyu.history');

          Route::prefix('/handover')->group(function() {
            Route::get('/create-bill', 'HeyuHandoverController@createBill');
            Route::post('/store-bill', 'HeyuHandoverController@storeBill')->name('viewcpanel::heyu.handover.storeBill');
            Route::get('/{id}', 'HeyuHandoverController@detailBill')->name('viewcpanel::heyu.handover.detailBill');
            Route::post('/approve', 'HeyuHandoverController@approve')->name('viewcpanel::heyu.handover.approve');
            Route::post('/cancel', 'HeyuHandoverController@cancel')->name('viewcpanel::heyu.handover.cancel');
            Route::get('/', 'HeyuHandoverController@index')->name('viewcpanel::heyu.handover.index');
          });
          Route::post('/driverInfo', 'HeyuHandoverController@driverInfo')->name('viewcpanel::heyu.driverInfo');
          Route::post('/uploadImage','HeyuHandoverController@uploadImage')->name('viewcpanel::heyu.uploadImage');
      });

      //Macom
      Route::middleware([TokenIsValid::class, VerifyCsrfToken::class])->prefix('/macom')->group(function() {
        Route::get('/index','MacomController@index')->name('viewcpanel::macom.cost.index');
        Route::get('/create','MacomController@create')->name('viewcpanel::macom.cost.create');
        Route::post('/save','MacomController@save')->name('viewcpanel::macom.cost.save');
        Route::post('/uploadLicense','MacomController@uploadLicense')->name('viewcpanel::macom.cost.uploadLicense');
        Route::get('/history','MacomController@history')->name('viewcpanel::macom.cost.history');
        Route::get('/edit/{id}','MacomController@edit')->name('viewcpanel::macom.cost.edit');
        Route::post('/update/{id}','MacomController@update')->name('viewcpanel::macom.cost.update');
        Route::get('/detail/{id}','MacomController@detail')->name('viewcpanel::macom.cost.detail');
        Route::post('/getStoreByCodeArea','MacomController@getStoreByCodeArea')->name('viewcpanel::macom.cost.getStoreByCodeArea');
        Route::post('/getAreaByDomain','MacomController@getAreaByDomain')->name('viewcpanel::macom.cost.getAreaByDomain');
      });
});
