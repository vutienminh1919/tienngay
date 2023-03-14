<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Modules\MysqlCore\Repositories\Interfaces\MoMoAppRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\MysqlCore\Entities\MoMoApp;

class MoMoViewController extends BaseController
{

    private $momoAppRepository;

    public function __construct(MoMoAppRepositoryInterface $momoAppRepository) {
       $this->momoAppRepository = $momoAppRepository;
       $this->middleware('tokenIsValid');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $currentTime = new DateTime();
        $transactions = $this->momoAppRepository->getListByMonth($currentTime->format("Y-m-d"));
        return view('viewcpanel::momoApp.index', [
            'currentTime' => $currentTime->format("Y-m"),
            'transactions' => $transactions,
            'getListByMonthUrl' => route('ViewCpanel::Momo.listTransactionByMonth'),
            'searchTransactionsUrl' => route('ViewCpanel::Momo.searchTransaction'),
            'createReconciliationUrl' => route('ViewCpanel::Momo.reconciliation.create'),
            'indexReconciliationUrl' => route('ViewCpanel::Momo.reconciliation.index'),
            'autoConfirmUrl' => route('ViewCpanel::Momo.autoConfirm'),
        ]);
    }

    /**
     * Show detail of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function show($id)
    {
        $transaction = $this->momoAppRepository->find($id);
        if ($transaction["payment_option"] == MoMoApp::PAYMENT_OPTION_INVESTOR) {
            return view('viewcpanel::momoApp.investor-detail', ['transaction' => $transaction]);
        } else {
            return view('viewcpanel::momoApp.detail', ['transaction' => $transaction]);
        }
        
    }

    /**
     * Get Transaction list by range time
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listTransactionByMonth (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.paymentgateway.momo.listTransactionByMonth');
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
        $url = config('routes.paymentgateway.momo.searchTransactions');

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * confirm transactions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autoConfirm (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.paymentgateway.momo.autoConfirm');

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

}
