<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm2RepositoryInterface;

class ReportForm2Controller extends BaseController
{
    /**
    * Modules\MongodbCore\Repositories\ReportForm2Repository
    */
    private $reportForm2Repo;

   /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Report"
     * )
     */
    public function __construct(
        ReportForm2RepositoryInterface $reportForm2Repository
    ) {
       $this->reportForm2Repo = $reportForm2Repository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function search(Request $request)
    {
        $data = $request->all();
        Log::channel('report')->info('Report search requested: ' . print_r($data, true));
        if (empty($data)) {
            return response()->json([
                'data' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Report::messages.not_found')
            ]);
        }
        $validator = Validator::make($data, [
            'contract_code'   => 'string|max:50',
            'contract_disbursement'   => 'string|max:50',
            'store_id'   => 'string|max:50',
            'range_time' => 'date_format:Y-m'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            Log::channel('report')->info('Report search response: ' . print_r($response, true));
            return response()->json($response);
        }
        $results = $this->reportForm2Repo->search($data);
        if (empty($results)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Report::messages.not_found'),
                'data' => $results
            ];
            Log::channel('report')->info('Report search response: ' . print_r($response, true));
            return response()->json($response);
        }
        
        $response = [
            'status' => Response::HTTP_OK,
            'message' => __('Report::messages.success'),
            'data' => $results
        ];
        //Log::channel('report')->info('Report search response: ' . print_r($response, true));
        return response()->json($response);
        
    }
}
