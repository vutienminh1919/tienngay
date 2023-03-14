<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm23RepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;
use Validator;

class ReportForm23Controller extends BaseController
{

    /**
    * Modules\MongodbCore\Repositories\ReportForm3Repository
    */
    private $reportForm3Repo;

    /**
    * Modules\MongodbCore\Repositories\StoreRepository
    */
    private $storeRepo;

    public function __construct(
        ReportForm23RepositoryInterface $reportForm23Repository,
        StoreRepository $storeRepository
    ) {
       $this->reportForm23Repo = $reportForm23Repository;
       $this->storeRepo = $storeRepository;
       // $this->middleware('tokenIsValid');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function reportForm23()
    {   $currentTime = new DateTime('1 month ago');
        //$results = $this->reportForm23Repo->getListByMonth($currentTime->format("Y-m-d"));
        $results = [
            'total' => 0,
            'data' => []
        ];
        $stores = $this->storeRepo->getAll();
        return view('viewcpanel::reportForm23.index', [
            'results' => $results,
            'currentTime' => $currentTime->format("Y-m"),
            'stores' => $stores,
            'filterUrl' => route('ViewCpanel::ReportForm23.search')
        ]);
    }

    public function search(Request $request) {
        $dataPost = $request->all();
        $url = config('routes.reportForm23.search');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $results = Http::asForm()->post($url, $dataPost);
        return response()->json($results->json());
    }

}
