<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\MysqlCore\Repositories\Interfaces\ReconciliationRepositoryInterface;
use Modules\MysqlCore\Repositories\Interfaces\MoMoAppRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\Log;

class TransactionReconciliationViewController extends BaseController
{

    private $reconciliationRepository;
    private $momoAppRepository;

    public function __construct(
        ReconciliationRepositoryInterface $reconciliationRepository,
        MoMoAppRepositoryInterface $momoAppRepository
    ) {
       $this->reconciliationRepository = $reconciliationRepository;
       $this->momoAppRepository = $momoAppRepository;
       $this->middleware('tokenIsValid');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   $currentTime = new DateTime();
        $reconciliations = $this->reconciliationRepository->getListByMonth($currentTime->format("Y-m-d"));
        return view('viewcpanel::transactionsReconciliation.index', [
            'reconciliations' => $reconciliations,
            'currentTime' => $currentTime->format("Y-m"),
            'getListByMonthUrl' => route('ViewCpanel::Momo.reconciliation.getListByMonth')
        ]);
    }

    /**
     * Show detail of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function show($id)
    {
        $reconciliation = $this->reconciliationRepository->find($id);
        $transactions = $this->momoAppRepository->getTransactionsByReconciliationId($id);
        $result = [
            'details' => $reconciliation,
            'transactions' => $transactions,
        ];

        return view('viewcpanel::transactionsReconciliation.details', 
            [
                'result' => $result,
                'deleteUrl' => route('ViewCpanel::Momo.reconciliation.details.cancel'),
                'sendEmail' => route('ViewCpanel::Momo.reconciliation.details.sendEmail'),
                'reconciliationId' => $id
            ]
        );
    }

    /**
     * Get transaction reconciliations list by range time
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getListByMonth (Request $request) {
        $dataPost = $request->all();
        $url = config('routes.paymentgateway.reconciliation.getListByMonth');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * Send transaction reconciliation email to momo
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request)
    {
        $dataPost = $request->all();
        $url = config('routes.paymentgateway.reconciliation.sendEmail');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * Delete transaction reconciliation
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $dataPost = $request->all();
        $url = config('routes.paymentgateway.reconciliation.delete');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * create transaction reconciliation
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createReconciliation (Request $request) {
        $dataPost = $request->all();
        $user = session('user');
        $dataPost["created_by"] = $user["email"];
        $url = config('routes.paymentgateway.reconciliation.create');

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        $response = $result->json();
        if ($response["status"] == Response::HTTP_OK) {
            $response["url"] = route('ViewCpanel::Momo.reconciliation.details', ['id' => $response["reconciliationId"]]);
        }
        Log::info('Result Api: ' . $url . ' ' . print_r($response, true));
        return response()->json($response);
    }

}
