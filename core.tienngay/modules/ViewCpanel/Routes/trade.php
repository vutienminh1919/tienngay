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

use Modules\ViewCpanel\Http\Middleware\TokenIsValid;
use Modules\ViewCpanel\Http\Middleware\VerifyCsrfToken;
use Modules\ViewCpanel\Http\Middleware\TradeMKT;

Route::middleware([
  TokenIsValid::class,
  VerifyCsrfToken::class,
  TradeMKT::class
])->prefix('trade')->group(function () {
    Route::get('/createItem', 'TradeItemController@createItem')->name('viewcpanel::trade.createItem');
    Route::post('/insertItem', 'TradeItemController@insertItem')->name('viewcpanel::trade.insertItem');
    Route::post('/uploadImg', 'TradeItemController@uploadImg')->name('viewcpanel::trade.uploadImg');
    Route::post('/getTypeByName', 'TradeItemController@getTypeByName')->name('viewcpanel::trade.getTypeByName');
    Route::get('/listItem', 'TradeItemController@listItem')->name('viewcpanel::trade.listItem');
    Route::post('/blockItem', 'TradeItemController@blockItem')->name('viewcpanel::trade.blockItem');
    Route::get('/detailItem/{id}', 'TradeItemController@detailItem')->name('viewcpanel::trade.detailItem');
    Route::get('/editItem/{id}', 'TradeItemController@editItem')->name('viewcpanel::trade.editItem');
    Route::post('/updateItem/{id}', 'TradeItemController@updateItem')->name('viewcpanel::trade.updateItem');
    Route::prefix('warehouse')->group(function () {
        //pgd
        Route::get('/pgd_create', 'DeliveryBillController@pgdCreate')->name('viewcpanel::warehouse.pgdCreate');
        Route::post('/pgd_save', 'DeliveryBillController@pgdSave')->name('viewcpanel::warehouse.pgdSave');
        Route::get('/pgd_detail/{id}', 'DeliveryBillController@pgdDetail')->name('viewcpanel::warehouse.pgdDetail');
        Route::get('/pgd_index', 'DeliveryBillController@pgdIndex')->name('viewcpanel::warehouse.pgdIndex');
        Route::post('/getItemByStoreId','DeliveryBillController@getItemStorageByStoreId')->name('viewcpanel::warehouse.getItemByStoreId');
        Route::post('/uploadLisence','DeliveryBillController@uploadLisence')->name('viewcpanel::warehouse.uploadLisence');
        Route::post('/updateLisence/{id}','DeliveryBillController@updateLisence')->name('viewcpanel::warehouse.updateLisence');
        Route::post('/getAreaByDomain','DeliveryBillController@getAreaByDomain')->name('viewcpanel::warehouse.getAreaByDomain');
        Route::post('/getStoreByArea','DeliveryBillController@getStoreByArea')->name('viewcpanel::warehouse.getStoreByArea');
        //asm, rsm, gdkd, mkt
        Route::get('/detail/{id}', 'DeliveryBillController@detail')->name('viewcpanel::warehouse.detail');
    });
    Route::prefix('transfer')->group(function() {
        Route::get('/create', 'TransferController@create')->name('viewcpanel::transfer.create');
        Route::post('/save', 'TransferController@save')->name('viewcpanel::transfer.save');
        Route::get('/edit/{id}','TransferController@edit')->name('viewcpanel::transfer.edit');
        Route::post('/update/{id}','TransferController@update')->name('viewcpanel::transfer.update');
        Route::get('/detail/{id}','TransferController@detail')->name('viewcpanel::transfer.detail');
        Route::post('/cancel','TransferController@cancel')->name('viewcpanel::transfer.cancel');
        Route::post('/delete','TransferController@delete')->name('viewcpanel::transfer.delete');
        Route::get('/detail_pgd/{id}','TransferController@detailPgd')->name('viewcpanel::transfer.detail_pgd');
        Route::post('/confirm_export','TransferController@confirmExport')->name('viewcpanel::transfer.confirmExport');
        Route::post('/confirm_import','TransferController@confirmImport')->name('viewcpanel::transfer.confirmImport');
        Route::post('/confirm_create','TransferController@confirmCreate')->name('viewcpanel::transfer.confirmCreate');
    });

    Route::prefix('/inventory')->group(function () {
        Route::get('/', 'TradeInventoryController@index')->name('viewcpanel::trade.inventory.index');
        Route::post('/reportInsert', 'TradeInventoryController@reportInsert')->name('viewcpanel::trade.inventory.reportInsert');
        Route::get('/reportCreate', 'TradeInventoryController@reportCreate')->name('viewcpanel::trade.inventory.reportCreate');
        Route::get('/reportList', 'TradeInventoryController@reportList')->name('viewcpanel::trade.inventory.reportList');
        Route::get('/reportDetail/{id}', 'TradeInventoryController@reportDetail')->name('viewcpanel::trade.inventory.reportDetail');
        Route::get('/adjustmentCreate/{id}', 'TradeInventoryController@adjustmentCreate')->name('viewcpanel::trade.inventory.adjustmentCreate');
        Route::post('/adjustmentInsert', 'TradeInventoryController@adjustmentInsert')->name('viewcpanel::trade.inventory.adjustmentInsert');
        Route::post('/uploadImg', 'TradeInventoryController@uploadImg')->name('viewcpanel::trade.inventory.uploadImg');
        Route::post('/getItembyStoreId', 'TradeInventoryController@getItembyStoreId')->name('viewcpanel::trade.inventory.getItembyStoreId');
        Route::get('/adjustmentList', 'TradeInventoryController@adjustmentList')->name('viewcpanel::trade.inventory.adjustmentList');
        Route::get('/adjustmentDetail/{id}', 'TradeInventoryController@adjustmentDetail')->name('viewcpanel::trade.inventory.adjustmentDetail');
        Route::post('/updateAdjustmentDone', 'TradeInventoryController@updateAdjustmentDone')->name('viewcpanel::trade.inventory.updateAdjustmentDone');
        Route::post('/updateAdjustmentCancel', 'TradeInventoryController@updateAdjustmentCancel')->name('viewcpanel::trade.inventory.updateAdjustmentCancel');
        Route::post('/getAreaByDomain', 'TradeInventoryController@getAreaByDomain')->name('viewcpanel::trade.inventory.getAreaByDomain');
        Route::post('/getStoreByCodeArea', 'TradeInventoryController@getStoreByCodeArea')->name('viewcpanel::trade.inventory.getStoreByCodeArea');
        Route::get('/storageDetail/{id}', 'TradeInventoryController@storageDetail')->name('viewcpanel::trade.inventory.storageDetail');
        Route::post('/insertExplanation', 'TradeInventoryController@insertExplanation')->name('viewcpanel::trade.inventory.insertExplanation');
        Route::post('/getItemByItemId', 'TradeInventoryController@getItemByItemId')->name('viewcpanel::trade.inventory.getItemByItemId');

    });

    Route::post('/getItemsByStoreId', 'TradeItemController@getItemsByStoreId')->name('viewcpanel::trade.getItemsByStoreId');
    Route::prefix('/trade-order')->group(function() {
        Route::get('/index', 'TradeOrderController@index')->name('viewcpanel::trade.tradeOrder.index');
        Route::get('/', 'TradeOrderController@requestOrderView')->name('viewcpanel::trade.tradeOrder.requestOrderView');
        Route::get('/trade-items', 'TradeOrderController@tradeItems')->name('viewcpanel::trade.tradeOrder.tradeItems');
        Route::post('/upload-plan', 'TradeOrderController@uploadPlan')->name('viewcpanel::trade.tradeOrder.uploadPlan');
        Route::post('/order', 'TradeOrderController@requestOrder')->name('viewcpanel::trade.tradeOrder.requestOrder');
        Route::post('/sentFirstApprove', 'TradeOrderController@sentFirstApprove')->name('viewcpanel::trade.tradeOrder.sentFirstApprove');
        Route::post('/updateStatus/{id}', 'TradeOrderController@updateStatus')->name('viewcpanel::trade.tradeOrder.updateStatus');
        Route::get('/detail/{id}', 'TradeOrderController@detailOrderView')->name('viewcpanel::trade.tradeOrder.detailOrderView');
        Route::get('/edit/{id}', 'TradeOrderController@editOrderView')->name('viewcpanel::trade.tradeOrder.editOrderView');
        Route::post('/update/{id}', 'TradeOrderController@updateOrder')->name('viewcpanel::trade.tradeOrder.updateOrder');
        Route::post('/delete/{id}', 'TradeOrderController@deleteOrder')->name('viewcpanel::trade.tradeOrder.deleteOrder');
        Route::post('/confirmed-allotment/{id}', 'TradeOrderController@confirmedAllotment')->name('viewcpanel::trade.tradeOrder.confirmedAllotment');
    });
    Route::prefix('/budget-estimates')->group(function() {
        Route::get('/index', 'TradeBudgetEstimatesController@index')->name('viewcpanel::trade.budgetEstimates.index');
        Route::get('/detail/{id}', 'TradeBudgetEstimatesController@detail')->name('viewcpanel::trade.budgetEstimates.detail');
        Route::post('/{id}', 'TradeBudgetEstimatesController@updateBudgetEstimateStatus')->name('viewcpanel::trade.budgetEstimates.updateBudgetEstimateStatus');
        Route::post('/customer-goal/{id}', 'TradeBudgetEstimatesController@updateCustomerGoal')->name('viewcpanel::trade.budgetEstimates.updateCustomerGoal');
        Route::post('/comment/{id}', 'TradeBudgetEstimatesController@addComment')->name('viewcpanel::trade.budgetEstimates.addComment');
        Route::post('/update-progress/{id}', 'TradeBudgetEstimatesController@updateProgress')->name('viewcpanel::trade.budgetEstimates.updateProgress');
        Route::post('/delete/{id}', 'TradeBudgetEstimatesController@deleteBE')->name('viewcpanel::trade.budgetEstimates.deleteOrder');
    });
    Route::prefix('/publication')->group(function() {
        Route::get('/create_publications', 'QlpublicationsController@create_publications')->name('viewcpanel::trade.publication.create1');
        Route::post('/find_one_trade', 'QlpublicationsController@find_one_trade')->name('viewcpanel::trade.publication.find_one_trade');
        Route::post('/create', 'QlpublicationsController@create')->name('viewcpanel::trade.publication.create');
        Route::get('/list_publications', 'QlpublicationsController@show_list')->name('viewcpanel::trade.publication.list');
        Route::post('/detailPublication', 'QlpublicationsController@detailPublication')->name('viewcpanel::trade.publication.detailPublication');
        Route::post('/notePublics', 'QlpublicationsController@notePublics')->name('viewcpanel::trade.publication.notePublics');
        Route::get('/detail_publics/{id}', 'QlpublicationsController@detailPuclication')->name('viewcpanel::trade.publication.detail_publication');
        Route::post('/find_publication', 'QlpublicationsController@findPubl')->name('viewcpanel::trade.publication.findPubl');
        Route::post('/notePuclication', 'QlpublicationsController@notePuclication')->name('viewcpanel::trade.publication.notePuclication');
        Route::post('/allLogAcception/{id}', 'QlpublicationsController@allLogAcception')->name('viewcpanel::trade.publication.allLogAcception');
        //show chi tiết chứng từ
        Route::post('/dtailLogAcception', 'QlpublicationsController@dtailLogAcception')->name('viewcpanel::trade.publication.dtailLogAcception');
        //show ảnh chứng từ
        Route::post('/dtailLogAcception1', 'QlpublicationsController@dtailLogAcception1')->name('viewcpanel::trade.publication.dtailLogAcception1');
        Route::post('/acceptionPublic', 'QlpublicationsController@acceptionPublic')->name('viewcpanel::trade.publication.acceptionPublic');
        Route::get('/update_publics/{id}', 'QlpublicationsController@detailPuclication1')->name('viewcpanel::trade.publication.update_publication');
        Route::post('/update', 'QlpublicationsController@update_publics')->name('viewcpanel::trade.publication.update');
        Route::post('/create_public_status_order', 'QlpublicationsController@create_status_order')->name('viewcpanel::trade.publication.create_public_status_order');
        Route::post('/update_status_block', 'QlpublicationsController@update_status_block')->name('viewcpanel::trade.publication.update_status_block');
        Route::post('/update_status_order', 'QlpublicationsController@update_status_order')->name('viewcpanel::trade.publication.update_status_order');
        Route::get('/findOneKeyId/{id}/{key_id}', 'QlpublicationsController@findOneKeyId')->name('viewcpanel::trade.publication.findOneKeyId');
        Route::post('/allotment_publication/{id}/{key_id}', 'QlpublicationsController@allotment_publication')->name('viewcpanel::trade.publication.allotment_publication');
        Route::post('/importExcel', 'QlpublicationsController@importFile')->name('viewcpanel::trade.publication.importExcel');
        Route::post('/uploadFile', 'QlpublicationsController@uploadFile')->name('viewcpanel::trade.publication.uploadFile');
    });
});
