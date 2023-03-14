<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm2RepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\Log;
use Validator;

class ReportForm2ViewController extends BaseController
{

    /**
    * Modules\MongodbCore\Repositories\ReportForm2Repository
    */
    private $reportForm2Repo;

    /**
    * Modules\MongodbCore\Repositories\StoreRepository
    */
    private $storeRepo;

    public function __construct(
        ReportForm2RepositoryInterface $reportForm2Repository
    ) {
       $this->reportForm2Repo = $reportForm2Repository;
       $this->middleware('tokenIsValid');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function reportForm2()
    {   $currentTime = new DateTime('1 month ago');
        //$results = $this->reportForm2Repo->getListByMonth($currentTime->format("Y-m-d"));
        $results = [
            'total' => 0,
            'data' => []
        ];
        return view('viewcpanel::reportForm2.index', [
            'results' => $results,
            'currentTime' => $currentTime->format("Y-m"),
            'filterUrl' => route('ViewCpanel::ReportForm2.search'),
        ]);
    }

    public function search(Request $request) {
        $dataPost = $request->all();
        $url = config('routes.reportForm2.search');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $results = Http::asForm()->post($url, $dataPost);
        return response()->json($results->json());
    }

}
