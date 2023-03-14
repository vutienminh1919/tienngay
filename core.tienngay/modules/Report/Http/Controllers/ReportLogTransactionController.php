<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\MysqlCore\Repositories\Interfaces\ReportLogTransactionRepositoryInterface as ReportLogTransactionRepository;
use Carbon\Carbon;

class ReportLogTransactionController extends BaseController
{
    /**
    * Modules\MysqlCore\Repositories\ReportLogTransactionRepository
    */
    private $reportRepo;


    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Report"
     * )
     */
    public function __construct(
        ReportLogTransactionRepository $reportRepo
    ) {
        $this->reportRepo = $reportRepo;
    }

    /**
     * Get list report by month
     * 
     */
    public function listLogByMonth(Request $request) {
        $time = $request->input('time');
        Log::channel('report')->info('ReportLogTransaction listLogByMonth: ' . $time);
        $data =  $this->reportRepo->getListByMonth($time);
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('Report::messages.get_data_success')
        ]);
        return response()->json($response);
    }

    /**
     * search item by conditions
     */
    public function search(Request $request) {
        $conditions = $request->all();
        unset($conditions['_token']);
        if(count(array_filter($conditions)) == 0) {
            return response()->json([
                'data' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Report::messages.please_input_data_search')
            ]);
        }
        $data =  $this->reportRepo->searchByConditions($conditions);
        Log::channel('report')->info('ReportLogTransaction search conditions: ' . print_r($conditions, true));
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('Report::messages.get_data_success')
        ]);
        return response()->json($response);
    }

}
