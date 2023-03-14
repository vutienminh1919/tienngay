<?php

namespace Modules\VFCPayment\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Repositories\Interfaces\MultiQrRepositoryInterface as MultiQrRepository;

class QRCodeController extends BaseController
{
    /**
    * Modules\MongodbCore\Repositories\MultiQrRepository
    */
    private $qrRepo;


   /**
     * @OA\Info(
     *     version="1.0",
     *     title="API VFCPayment"
     * )
     */
    public function __construct(
        MultiQrRepository $qrRepository
    ) {
        $this->qrRepo = $qrRepository;
    }

    /**
     * @OA\Post(
     *     path="/vfcpayment/multiQr",
     *     tags={"vfcpayment"},
     *     operationId="multiQr",
     *     summary="insert multi qr to database",
     *     description="insert multiple link qr to data base",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="requestId",type="string"),
     *                   @OA\Property(property="iosDevice",type="string"),
     *                   @OA\Property(property="androidDevice",type="string"),
     *                   @OA\Property(property="otherDevice",type="string"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function multiQr(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('vfcpayment')->info('vfcpayment multiQr requested: ' . print_r($requestData, true));
        $requestId = !empty($requestData["requestId"]) ? $requestData["requestId"] : "";
        $iosDevice = !empty($requestData["iosDevice"]) ? $requestData["iosDevice"] : "";
        $androidDevice = !empty($requestData["androidDevice"]) ? $requestData["androidDevice"] : "";
        $otherDevice = !empty($requestData["otherDevice"]) ? $requestData["otherDevice"] : "";

        $validator = Validator::make($requestData, [
            'requestId' => 'required|string|max:50',
            'iosDevice' => 'required|string',
            'androidDevice' => 'required|string',
        ]);
        if ($validator->fails()) {
            Log::channel('vfcpayment')->info('validate error: ' . print_r($validator->errors(), true));
            $response = [
                'requestId' => $requestId,
                'iosDevice' => $iosDevice,
                'androidDevice' => $androidDevice,
                'otherDevice' => $otherDevice,
                'data' => '',
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first()
            ];
            Log::channel('vfcpayment')->info('vfcpayment multiQr response: ' . print_r($response, true));
            return response()->json($response);
        }
        //search info
        $create = $this->qrRepo->create([
            'request_id' => $requestId,
            'ios' => $iosDevice,
            'android' => $androidDevice,
            'other' => $otherDevice
        ]);

        if (!$create) {
            $response = [
                'requestId' => $requestId,
                'iosDevice' => $iosDevice,
                'androidDevice' => $androidDevice,
                'otherDevice' => $otherDevice,
                'data' => '',
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('VFCPayment::messages.not_found')
            ];
            Log::channel('vfcpayment')->info('vfcpayment multiQr response: ' . print_r($response, true));
            return response()->json($response);
        }
        $response = [
            'requestId' => $requestId,
            'iosDevice' => $iosDevice,
            'androidDevice' => $androidDevice,
            'otherDevice' => $otherDevice,
            'data' => $create,
            'status' => Response::HTTP_OK,
            'message' => __('VFCPayment::messages.get_data_success')
        ];
        Log::channel('vfcpayment')->info('vfcpayment multiQr response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/vfcpayment/multiQrLink",
     *     tags={"vfcpayment"},
     *     operationId="multiQr",
     *     summary="insert multi qr to database",
     *     description="insert multiple link qr to data base",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="requestId",type="string"),
     *                   @OA\Property(property="id",type="string"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function multiQrLink(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        Log::channel('vfcpayment')->info('vfcpayment multiQrLink requested: ' . print_r($requestData, true));
        $requestId = !empty($requestData["requestId"]) ? $requestData["requestId"] : "";
        $id = !empty($requestData["id"]) ? $requestData["id"] : "";

        $validator = Validator::make($requestData, [
            'requestId' => 'required|string|max:50',
            'id' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::channel('vfcpayment')->info('validate error: ' . print_r($validator->errors(), true));
            $response = [
                'requestId' => $requestId,
                'id' => $id,
                'data' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first()
            ];
            Log::channel('vfcpayment')->info('vfcpayment multiQrLink response: ' . print_r($response, true));
            return response()->json($response);
        }
        //search info
        $fetch = $this->qrRepo->find($id);

        if (!$fetch) {
            $response = [
                'requestId' => $requestId,
                'id' => $id,
                'data' => [],
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('VFCPayment::messages.not_found')
            ];
            Log::channel('vfcpayment')->info('vfcpayment multiQrLink response: ' . print_r($response, true));
            return response()->json($response);
        }
        $response = [
            'requestId' => $requestId,
            'id' => $id,
            'status' => Response::HTTP_OK,
            'data' => [
                'iosDevice' => $fetch['ios'],
                'androidDevice' => $fetch['android'],
                'otherDevice' => $fetch['other'],
            ],
            'message' => __('VFCPayment::messages.get_data_success')
        ];
        Log::channel('vfcpayment')->info('vfcpayment multiQrLink response: ' . print_r($response, true));
        return response()->json($response);
    }
}
