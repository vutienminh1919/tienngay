<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\MysqlCore\Repositories\Interfaces\MistakenVpbankTransactionRepositoryInterface as MistakenTransactionRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;

class MistakenVpbankController extends BaseController
{

    /**
    * Modules\MysqlCore\Repositories\MistakenTransactionRepository
    */
    private $vpbTranRepository;

    /**
    * Modules\MongodbCore\Repositories\StoreRepository
    */
    private $storeRepo;

    public function __construct(
        MistakenTransactionRepository $vpbTranRepository,
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
        $transactions = $this->vpbTranRepository->searchByConditions([]);
        $codeArea = $this->storeRepo->getCodeAreaList();
        return view('viewcpanel::mistakentransaction.index', [
            'codeArea' => $codeArea,
            'currentTime' => $currentTime->format("Y-m"),
            'transactions' => $transactions,
            'getListByMonthUrl' => route('ViewCpanel::VPBank.mistakentransaction.getListByMonth'),
            'filterUrl' => route('ViewCpanel::VPBank.mistakentransaction.searchTransaction'),
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
        $url = config('routes.vpbank.mistakentransaction.getListByMonth');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * Search mistaken Vpbank transaction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchTransactions (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.vpbank.mistakentransaction.searchTransactions');

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }
}
