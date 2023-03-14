<?php

namespace Modules\PaymentHoliday\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Modules\MongodbCore\Repositories\Interfaces\PaymentHolidayRepositoryInterface as PaymentHolidayRepository;
use Modules\MongodbCore\Entities\PaymentHoliday;

class PaymentHolidayController extends BaseController
{
    /**
     * Modules\MongodbCore\Repositories\PaymentHolidayRepository
     * */
    private $paymentHolidayRepo;

    /**
     * Modules\MongodbCore\Repositories\HeyuStoreRepository
     * */
    private $heyuStoreRepo;

    const MESSAGES = [
        'name.required'         => 'Tên sự kiện không được để trống',
        'description.required'  => 'Mô tả không được để trống',
        'start_date.required'   => 'Ngày bắt đầu không được để trống',
        'start_date.date_format'=> 'Không đúng định dạng ngày (Y-m-d)',
        'end_date.required'     => 'Ngày được phép thanh toán muộn nhất không được để trống',
        'end_date.date_format'  => 'Không đúng định dạng ngày (Y-m-d)',
        'end_date.gte'          => 'Ngày được phép thanh toán muộn nhất phải sau ngày ngày bắt đầu',
        'created_by.required'   => 'Không lấy được thông tin người đăng nhập',
        'id.required'           => 'Không xác định được đối tượng',
        'status.required'       => 'Không xác định được trạng thái',
        'status.in'             => 'Trạng thái không nằm trong danh mục cho phép',
    ];

    public function __construct(
        PaymentHolidayRepository $paymentHolidayRepo
    ) {
        $this->paymentHolidayRepo = $paymentHolidayRepo;
    }

    /**
     * Store new payment holidays data into collection
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function store(Request $request) {
        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentHoliday::messages.errors'),
                'data' => $data
            ];
            return response()->json($response);
        }

        $validator = Validator::make($data, [
            'name'                  => 'required',
            'description'           => 'required',
            'start_date'            => 'required|date_format:Y-m-d',
            'end_date'              => 'required|date_format:Y-m-d|gte:start_date',
            'created_by'            => 'required',
        ], self::MESSAGES);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first()
            ];
            return response()->json($response);
        }

        $storeData = [
            PaymentHoliday::NAME            => $data['name'],
            PaymentHoliday::DESCRIPTION     => $data['description'],
            PaymentHoliday::START_DATE      => strtotime($data['start_date'] . ' 00:00:00'),
            PaymentHoliday::END_DATE        => strtotime($data['end_date'] . ' 23:59:59'),
            PaymentHoliday::CREATED_BY      => $data['created_by'],
        ];
        
        if ($storage = $this->paymentHolidayRepo->store($storeData)) {
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $storage,
                'message' => __('PaymentHoliday::messages.success')
            ];
            return response()->json($response);
        }
        
        $response = [
            'status' => Response::HTTP_BAD_REQUEST,
            'data' => $data,
            'message' => __('PaymentHoliday::messages.errors')
        ];
        return response()->json($response);
    }

    /**
     * Edit existed payment holidays data 
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function edit(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('paymentholiday')->info('PaymentHoliday edit: ');
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentHoliday::messages.errors'),
                'data' => $data
            ];
            return response()->json($response);
        }
        Log::channel('paymentholiday')->info('PaymentHoliday edit data: ' . print_r($data, true));
        $validator = Validator::make($data, [
            'id'                    => 'required',
            'name'                  => 'required',
            'description'           => 'required',
            'start_date'            => 'required|date_format:Y-m-d',
            'end_date'              => 'required|date_format:Y-m-d|gte:start_date',
            'created_by'            => 'required',
            'status'                => 'integer|in:'.implode(PaymentHoliday::$statusAll, ','),
        ], self::MESSAGES);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first()
            ];
            return response()->json($response);
        }

        $storeData = [
            PaymentHoliday::NAME            => $data['name'],
            PaymentHoliday::DESCRIPTION     => $data['description'],
            PaymentHoliday::START_DATE      => strtotime($data['start_date'] . ' 00:00:00'),
            PaymentHoliday::END_DATE        => strtotime($data['end_date'] . ' 23:59:59'),
            PaymentHoliday::UPDATED_BY      => $data['created_by'],
        ];
        if (isset($data['status'])) {
            $storeData[PaymentHoliday::STATUS] = $data['status'];
        }
        Log::channel('paymentholiday')->info('PaymentHoliday edit storeData data: ' . print_r($storeData, true));
        if ($storage = $this->paymentHolidayRepo->update($data['id'], $storeData)) {
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $storage,
                'message' => __('PaymentHoliday::messages.success')
            ];
            Log::channel('paymentholiday')->info('PaymentHoliday edit response data: ' . print_r($response, true));
            return response()->json($response);
        }
        $response = [
            'status' => Response::HTTP_BAD_REQUEST,
            'data' => $data,
            'message' => __('PaymentHoliday::messages.errors')
        ];
        Log::channel('paymentholiday')->info('PaymentHoliday edit response2 data: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * update existed payment holidays status 
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function updateStatus(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('paymentholiday')->info('PaymentHoliday updateStatus: ');
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentHoliday::messages.errors'),
                'data' => $data
            ];
            return response()->json($response);
        }
        Log::channel('paymentholiday')->info('PaymentHoliday updateStatus data: ' . print_r($data, true));
        $validator = Validator::make($data, [
            'id'                    => 'required',
            'status'                => 'required|integer|in:'.implode(PaymentHoliday::$statusAll, ','),
            'created_by'            => 'required',
        ], self::MESSAGES);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first()
            ];
            return response()->json($response);
        }

        $storeData = [
            PaymentHoliday::STATUS          => (int)$data['status'],
            PaymentHoliday::UPDATED_BY      => $data['created_by']
        ];
        Log::channel('paymentholiday')->info('PaymentHoliday storeData data: ' . print_r($storeData, true));
        if ($storage = $this->paymentHolidayRepo->update($data['id'], $storeData)) {
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $storage,
                'message' => __('PaymentHoliday::messages.success')
            ];
            Log::channel('paymentholiday')->info('PaymentHoliday response data: ' . print_r($response, true));
            return response()->json($response);
        }
        
        $response = [
            'status' => Response::HTTP_BAD_REQUEST,
            'data' => $data,
            'message' => __('PaymentHoliday::messages.errors')
        ];
        Log::channel('paymentholiday')->info('PaymentHoliday response data: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * update existed payment holidays status 
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function delete(Request $request) {
        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentHoliday::messages.errors'),
                'data' => $data
            ];
            return response()->json($response);
        }

        $validator = Validator::make($data, [
            'id'                    => 'required',
        ], self::MESSAGES);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first()
            ];
            return response()->json($response);
        }

        $storeData = [
            PaymentHoliday::UPDATED_BY      => $data['created_by']
        ];
        if ($storage = $this->paymentHolidayRepo->delete($data['id'], $storeData)) {
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $storage,
                'message' => __('PaymentHoliday::messages.success')
            ];
            return response()->json($response);
        }
        
        $response = [
            'status' => Response::HTTP_BAD_REQUEST,
            'data' => $data,
            'message' => __('PaymentHoliday::messages.errors')
        ];
        return response()->json($response);
    }
    
}
