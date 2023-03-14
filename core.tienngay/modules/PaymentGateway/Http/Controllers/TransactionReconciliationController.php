<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Modules\PaymentGateway\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\MysqlCore\Repositories\Interfaces\ReconciliationRepositoryInterface;
use Modules\MysqlCore\Repositories\Interfaces\MoMoAppRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Artisan;

class TransactionReconciliationController extends BaseController
{

    private $reconciliationRepository;
    private $momoAppRepository;

    public function __construct(
        ReconciliationRepositoryInterface $reconciliationRepository,
        MoMoAppRepositoryInterface $momoAppRepository
    ) {
       $this->reconciliationRepository = $reconciliationRepository;
       $this->momoAppRepository = $momoAppRepository;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Log::channel('momo')->info('transactions reconciliation requested: ' . print_r($data, true));
        if (empty($data["selectedIds"])) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.selected_transaction_is_empty')
            ]);
        }
        $transactions = $this->momoAppRepository->summaryNotReconciliationByIds($data["selectedIds"]);
        Log::channel('momo')->info('summaryNotReconciliationByIds: ' . print_r($transactions, true));
        if ($transactions["totalTransaction"] <= 0) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.reconciliation_has_been_confrimed')
            ]);
        }
        try {
            DB::beginTransaction();

            $transactions["created_by"] = $data["created_by"];
            $reconciliation = $this->reconciliationRepository->store($transactions);
            $updateReconciliationId = $this->momoAppRepository->updateReconciliationId($reconciliation["id"], $data["selectedIds"]);
            DB::commit();
        }
        catch(Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.create_reconciliation_failed')
            ]);
        }
        
        return response()->json([
            'reconciliationId' => $reconciliation["id"],
            'status' => Response::HTTP_OK,
            'message' => __('PaymentGateway::messages.create_reconciliation_successfully')
        ]);
    }

    /**
     * Get Transaction reconciliations list by range time
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/reconciliation/getListByMonth",
     *     tags={"paymentgateway"},
     *     operationId="getListByMonth",
     *     summary="get list data",
     *     description="get transaction reconciliation list from transaction_reconciliations table by range time",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                       'time' => (date) format: YYYY-MM-DD
     *                   )
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
    public function getListByMonth(Request $request) {
        $time = $request->input('time');
        $data =  $this->reconciliationRepository->getListByMonth($time);
        Log::channel('momo')->info('search transaction reconciliations by month: ' . $time);
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('PaymentGateway::messages.get_data_success')
        ]);
        return response()->json($response);
    }

    /**
     * Send transaction reconciliation email to momo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/reconciliation/sendEmail",
     *     tags={"paymentgateway"},
     *     operationId="sendEmail",
     *     summary="send email to momo",
     *     description="Send transaction reconciliation email to momo",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                       'id' => (int) 
     *                   )
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
    public function sendEmail(Request $request) {
        $id = (int)$request->input('id');
        $reconciliation = $this->reconciliationRepository->sendingEmailStatus($id);
        if ($reconciliation) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => __('PaymentGateway::messages.send_email_success')
            ]);
        }
        return response()->json([
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => __('PaymentGateway::messages.send_email_failed')
        ]);
    }

    /**
     * Delete transaction reconciliation by Id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/reconciliation/delete",
     *     tags={"paymentgateway"},
     *     operationId="deleteReconciliation",
     *     summary="Delete transaction reconciliation",
     *     description="Delete transaction reconciliation by Id",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                       'id' => (int) 
     *                   )
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
    public function delete(Request $request) {
        $id = (int)$request->input('id');
        Log::channel('momo')->info('delete transaction reconciliation start: ' . $id);
        try {
            DB::beginTransaction();

            $reconciliation = $this->reconciliationRepository->delete($id);
            $transactions = $this->momoAppRepository->removeReconciliationId($id);
            DB::commit();
            Log::channel('momo')->info('delete transaction reconciliation successfully: ' . $id);
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => __('PaymentGateway::messages.delete_success')
            ]);
        }
        catch(Exception $e) {
            DB::rollBack();
            Log::channel('momo')->info('delete transaction reconciliation failed: ' . $id);
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.delete_failed')
            ]);
        }
    }
}
