<?php

namespace Modules\VPBank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\MysqlCore\Repositories\Interfaces\MistakenVpbankTransactionRepositoryInterface as MistakenTransactionRepository;
use Carbon\Carbon;

class MistakenVpbankController extends BaseController
{
    /**
    * Modules\MysqlCore\Repositories\MistakenVpbankTransactionRepository
    */
    private $mistakenTranRepo;


    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API VPBank"
     * )
     */
    public function __construct(
        MistakenTransactionRepository $mistakenTranRepo
    ) {
        $this->mistakenTranRepo = $mistakenTranRepo;
    }

    /**
     * @OA\Post(
     *     path="/vpbank/mistakentransaction/getListByMonth",
     *     tags={"vpbank"},
     *     operationId="getListByMonth",
     *     summary="get list data",
     *     description="get transaction list from mistaken_vpbank_transactions table by range time",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="time",type="string"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function listTransactionByMonth(Request $request) {
        $time = $request->input('time'); // Tien ngay transaction id
        $data =  $this->mistakenTranRepo->getListByMonth($time);
        Log::channel('vpbank')->info('search transaction by month: ' . $time);
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('VPBank::messages.get_data_success')
        ]);
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/vpbank/mistakentransaction/searchTransactions",
     *     tags={"vpbank"},
     *     operationId="search",
     *     summary="search transaction",
     *     description="get transaction list from mistaken_vpbank_transactions table by special condition",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="status",type="number"),
     *                   @OA\Property(property="transactionId",type="string"),
     *                   @OA\Property(property="start_date",type="string"),
     *                   @OA\Property(property="end_date",type="string"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function searchTransactions(Request $request) {
        $conditions = $request->all();
        Log::channel('vpbank')->info('search searchTransactions: ' . print_r($conditions, true));
        $data =  $this->mistakenTranRepo->searchByConditions($conditions);
        Log::channel('vpbank')->info('search searchTransactions result: ' . print_r($data, true));
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('VPBank::messages.get_data_success')
        ]);
        return response()->json($response);
    }

    public function getAllTransactions(Request $request)
    {
        $conditions = $request->all();
        if (!empty($conditions['place'])) {
            $conditions['place'] = json_decode($conditions['place']);
        } else {
            $conditions['place'] = "";
        }
        $data =  $this->mistakenTranRepo->searchMistakenOnDatePayAndStoreID($conditions);
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('VPBank::messages.get_data_success')
        ]);
        return response()->json($response);

    }

}
