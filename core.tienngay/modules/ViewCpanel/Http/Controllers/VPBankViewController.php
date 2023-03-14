<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\VPBank\Service\VPBankApi;
use Modules\MysqlCore\Repositories\Interfaces\VPBankTransactionRepositoryInterface as VPBTranRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;

class VPBankViewController extends BaseController
{

    /**
    * Modules\MysqlCore\Repositories\VPBankTransactionRepository
    */
    private $vpbTranRepository;

    /**
    * Modules\MongodbCore\Repositories\StoreRepository
    */
    private $storeRepository;

    public function __construct(
        VPBankApi $VPBankApi, 
        VPBTranRepository $vpbTranRepository, 
        StoreRepository $storeRepository
    ) {
        // $this->middleware('tokenIsValid');
        $this->vpbTranRepository = $vpbTranRepository;
        $this->storeRepo = $storeRepository;
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function transaction()
    {
        $currentTime = new DateTime();
        $transactions = $this->vpbTranRepository->getListByMonth($currentTime->format("Y-m-d"));
        return view('viewcpanel::vpbank.transaction', [
            'currentTime' => $currentTime->format("Y-m"),
            'transactions' => $transactions,
            'getListByMonthUrl' => route('ViewCpanel::VPBank.transaction.getListByMonth'),
            'searchTransactionsUrl' => route('ViewCpanel::VPBank.transaction.searchTransaction'),
            'downloadReport' => route('ViewCpanel::VPBank.downloadReport'),
            'storeCodesUrl' => route('ViewCpanel::VPBank.storeCodes'),
        ]);
    }

    /**
     * Get Transaction list by range time
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listTransactionByMonth (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.vpbank.transaction.getListByMonth');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * Search MoMo Transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchTransactions (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.vpbank.transaction.searchTransactions');

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * Show detail of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function show($id)
    {
        $transaction = $this->vpbTranRepository->find($id);
        if (!$transaction) {
            abort(404);
        }
        $van = data_get($transaction, 'virtualAccountNumber');
        $store = $this->storeRepo->findByVpbStoreCode(substr($van, 0, 8));
        return view('viewcpanel::vpbank.detail', ['transaction' => $transaction, 'store' => $store]);
    }

    public function downloadReport(Request $request) {
        $data = $request->all();

        if (isset($data["tcv_report_date"])) {
            $filename = str_replace("-","",$data["tcv_report_date"]) . ".VPB.THUHO.TCV.csv";
        }
        if (isset($data["tcv_report_month"])) {
            $filename = str_replace("-","",$data["tcv_report_month"]) . ".VPB.BAOCAOPHI.TCV.csv";
        }
        if (isset($data["tcvdb_report_date"])) {
            $filename = str_replace("-","",$data["tcvdb_report_date"]) . ".VPB.THUHO.TCVDB.csv";
        }
        if (isset($data["tcvdb_report_month"])) {
            $filename = str_replace("-","",$data["tcvdb_report_month"]) . ".VPB.BAOCAOPHI.TCVDB.csv";
        }
        $path = env("VPB_DOWNLOAD_REPORT").'/'.$filename;
        return response()->redirectTo($path);
    }

   /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function storeCodes()
    {
        $stores = $this->storeRepo->getAll();
        return view('viewcpanel::vpbank.storeCodes', [
            'stores' => $stores,
        ]);
    } 
}
