<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\MysqlCore\Repositories\Interfaces\ReportLogTransactionRepositoryInterface as ReportLogTransactionRepository;

class ReportLogTransactionController extends BaseController
{

    /**
    * Modules\MysqlCore\Repositories\ReportLogTransactionRepository
    */
    private $reportRepo;

    private $user;
    private $roles;

    public function __construct(
        ReportLogTransactionRepository $reportRepo
    ) {
        $this->reportRepo = $reportRepo;
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        Log::channel('cpanel')->info("ReportLogTransactionController index");
        $this->user = session('user');
        $this->roles = !empty($this->user['roles']['reportLogTransaction']) ? $this->user['roles']['reportLogTransaction'] : [];
        if (empty($this->user['email'])) {
            echo __('ViewCpanel::message.unauthorized');
            exit;
        }
        if (isset($this->roles['index']) && !$this->roles['index']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $currentTime = new DateTime();
        $data =  $this->reportRepo->getListByMonth($currentTime->format("Y-m"));

        return view('viewcpanel::reportLogTransaction.index', [
            'currentTime' => $currentTime->format("Y-m"),
            'results' => $data,
            'filterUrl' => route('ViewCpanel::Report.logTran.search'),
        ]);
    }

    /**
     * Search report log transaction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search (Request $request) {
        Log::channel('cpanel')->info("ReportLogTransactionController search");
        $this->user = session('user');
        $this->roles = !empty($this->user['roles']['reportLogTransaction']) ? $this->user['roles']['reportLogTransaction'] : [];
        if (empty($this->user['email'])) {
            return response()->json([
                'data' => [],
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => __('ViewCpanel::message.unauthorized')
            ]);
        }
        if (isset($this->roles['search']) && !$this->roles['search']) {
            return response()->json([
                'data' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ]);
        }
        $dataPost = $request->all();
        $url = config('routes.logTran.search');

        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }
}
