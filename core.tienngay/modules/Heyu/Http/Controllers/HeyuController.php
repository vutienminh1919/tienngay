<?php

namespace Modules\Heyu\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Modules\Heyu\Service\HeyuApi;

class HeyuController extends BaseController
{

    /**
    * Modules\Heyu\Service\HeyuApi
    */
    protected $heyuApi;

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API "Heyu"
     * )
     */
    public function __construct(
        HeyuApi $heyuApi
    ) {
        $this->heyuApi = $heyuApi;
    }

    /**
    * Tìm thông tin tài xế theo mã Thành viên
    * @param $request Illuminate\Http\Request
    * @return $response json
    */
    public function findUserByCode(Request $request)
    {
        Log::channel('heyu')->info('Heyu findUserByCode request: ' . $request->getContent());
        $data = json_decode($request->getContent(), true);
        $validator = Validator::make($data, [
            'code'   => 'required|string'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Heyu::messages.not_found'),
                'data' => []
            ];
            Log::channel('heyu')->info('Heyu findUserByCode response: ' . print_r($response, true));
            return response()->json($response);
        }
        $mainData = [
            'code' => $data['code']
        ];
        $result = $this->heyuApi->findUserByCode($mainData);
        if (isset($result['code']) && $result['code'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Heyu::messages.success'),
                'data' => $result['data']
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => isset($result['message']) ? $result['message'] : __('Heyu::messages.something_errors'),
                'data' => []
            ];
        }
        Log::channel('heyu')->info('Heyu findUserByCode response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * Nạp tiền Heyu theo mã Thành viên
    * @param $request Illuminate\Http\Request
    * @return $response json
    */
    public function charge(Request $request)
    {
        Log::channel('heyu')->info('Heyu charge request: ' . $request->getContent());
        $data = json_decode($request->getContent(), true);
        $validator = Validator::make($data, [
            'code'   => 'required|string',
            'amount'   => 'required|numeric',
            'orderId'   => 'required|string'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            Log::channel('heyu')->info('Heyu charge response: ' . print_r($response, true));
            return response()->json($response);
        }
        $mainData = [
            'code' => $data['code'],
            'amount' => $data['amount'],
            'orderId' => $data['orderId']
        ];
        $result = $this->heyuApi->charge($mainData);
        if (isset($result['code']) && $result['code'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Heyu::messages.success'),
                'data' => $result['data']
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => isset($result['message']) ? $result['message'] : __('Heyu::messages.something_errors'),
                'data' => []
            ];
        }
        Log::channel('heyu')->info('Heyu charge response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * Tìm thông đồng phục tài xế theo mã Thành viên
    * @param $request Illuminate\Http\Request
    * @return $response json
    */
    public function getTransactions(Request $request)
    {
        Log::channel('heyu')->info('Heyu getTransactions request: ' . $request->getContent());
        $data = json_decode($request->getContent(), true);
        $validator = Validator::make($data, [
            'page'   => 'required|numeric',
            'limit'   => 'required|numeric',
            'sort'   => 'required|in:1,-1'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            Log::channel('heyu')->info('Heyu getTransactions response: ' . print_r($response, true));
            return response()->json($response);
        }
        $mainData = [
            'page' => $data['page'],
            'limit' => $data['limit'],
            'sort' => $data['sort']
        ];
        $result = $this->heyuApi->getTransactions($mainData);
        if (isset($result['code']) && $result['code'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Heyu::messages.success'),
                'data' => $result['data']
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => isset($result['message']) ? $result['message'] : __('Heyu::messages.something_errors'),
                'data' => []
            ];
        }
        Log::channel('heyu')->info('Heyu getTransactions response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * Tìm thông đồng phục tài xế theo mã Thành viên
    * @param $request Illuminate\Http\Request
    * @return $response json
    */
    public function getStatus(Request $request)
    {
        Log::channel('heyu')->info('Heyu getStatus request: ' . $request->getContent());
        $data = json_decode($request->getContent(), true);
        $validator = Validator::make($data, [
            'code'   => 'required|string'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Heyu::messages.not_found'),
                'data' => []
            ];
            Log::channel('heyu')->info('Heyu getStatus response: ' . print_r($response, true));
            return response()->json($response);
        }
        $mainData = [
            'code' => $data['code']
        ];
        $result = $this->heyuApi->getStatus($mainData);
        Log::channel('heyu')->info('Heyu getStatus response1: ' . print_r($result, true));
        if (isset($result['code']) && $result['code'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'handoverStatus' => isset($result['data']['handoverStatus']) ? $result['data']['handoverStatus'] : 0,
                'message' => isset($result['message']) ? $result['message'] : __('Heyu::messages.success'),
                'data' => $result['data']
            ];
        } elseif (isset($result['code']) && $result['code'] == Response::HTTP_MULTIPLE_CHOICES) {
            $response = [
                'status' => Response::HTTP_MULTIPLE_CHOICES,
                'message' => $result['message'],
                'data' => []
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => isset($result['message']) ? $result['message'] : __('Heyu::messages.something_errors'),
                'data' => []
            ];
        }
        Log::channel('heyu')->info('Heyu getStatus response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * Xác nhận giao đồng phục cho tài xế
    * @param $request Illuminate\Http\Request
    * @return $response json
    */
    public function handover(Request $request)
    {
        Log::channel('heyu')->info('Heyu handover request: ' . $request->getContent());
        $data = json_decode($request->getContent(), true);
        $validator = Validator::make($data, [
            'code'   => 'required|string',
            'storeId'   => 'required|string',
            'coatSize'   => 'string',
            'shirtSize'   => 'string'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            Log::channel('heyu')->info('Heyu handover response: ' . print_r($response, true));
            return response()->json($response);
        }
        $mainData = [
            'code' => $data['code'],
            'storeId' => $data['storeId'],
            'coatSize' => data_get($data, 'coatSize', ''),
            'shirtSize' => data_get($data, 'shirtSize', ''),
        ];
        $result = $this->heyuApi->handover($mainData);
        if (isset($result['code']) && $result['code'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Heyu::messages.success'),
                'data' => $result['data']
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => isset($result['message']) ? $result['message'] : __('Heyu::messages.something_errors'),
                'data' => []
            ];
        }
        Log::channel('heyu')->info('Heyu handover response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * Tra cứu thông tin đồng phục hiện tại các PGD
    * @param $request Illuminate\Http\Request
    * @return $response json
    */
    public function inventory(Request $request)
    {
        Log::channel('heyu')->info('Heyu inventory request: ' . $request->getContent());
        $data = json_decode($request->getContent(), true);
        $validator = Validator::make($data, [
            'storeIds'   => 'required|array'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            Log::channel('heyu')->info('Heyu inventory response: ' . print_r($response, true));
            return response()->json($response);
        }
        $mainData = [
            'storeIds' => $data['storeIds'],
        ];
        $result = $this->heyuApi->inventory($mainData);
        if (isset($result['code']) && $result['code'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Heyu::messages.success'),
                'data' => $result['data']
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => isset($result['message']) ? $result['message'] : __('Heyu::messages.something_errors'),
                'data' => []
            ];
        }
        Log::channel('heyu')->info('Heyu inventory response: ' . print_r($response, true));
        return response()->json($response);
    }

}
