<?php

namespace Modules\Heyu\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Modules\MongodbCore\Repositories\Interfaces\HeyuHandoverRepositoryInterface as HeyuHandoverRepository;
use Modules\MongodbCore\Repositories\Interfaces\HeyuStoreRepositoryInterface as HeyuStoreRepository;
use Modules\MongodbCore\Entities\HeyuHandover as HModel;
use Modules\Heyu\Service\HeyuApi;

class HeyuHandoverController extends HeyuController
{
    /**
     * Modules\MongodbCore\Repositories\HeyuHandoverRepository
     * */
    private $handoverRepo;

    /**
     * Modules\MongodbCore\Repositories\HeyuStoreRepository
     * */
    private $heyuStoreRepo;

    public function __construct(
        HeyuHandoverRepository $heyuHandoverRepository,
        HeyuStoreRepository $heyuStoreRepository,
        HeyuApi $heyuApi
    ) {
        $this->handoverRepo = $heyuHandoverRepository;
        $this->heyuStoreRepo = $heyuStoreRepository;
        $this->heyuApi = $heyuApi;
    }

    /**
     * Store new handover data into collection
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function storeHandoverBill(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('heyu')->info('storeHandoverBill: ' . print_r($data, true));

        $validator = Validator::make($data, [
            'store_id'              => 'required',
            'store_name'            => 'required',
            'driver_code'           => 'required',
            'driver_name'           => 'required|string',
            'coat'                  => 'required|array',
            'shirt'                 => 'required|array',
            'created_by'            => 'required|string',
            'coat.s'                => 'integer',
            'coat.m'                => 'integer',
            'coat.l'                => 'integer',
            'coat.xl'               => 'integer',
            'coat.xxl'              => 'integer',
            'coat.xxxl'             => 'integer',
            'shirt.s'               => 'integer',
            'shirt.m'               => 'integer',
            'shirt.l'               => 'integer',
            'shirt.xl'              => 'integer',
            'shirt.xxl'             => 'integer',
            'shirt.xxxl'            => 'integer',
            'evidence'              => 'required|array'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first()
            ];
            Log::channel('heyu')->info('Heyu storeHandoverBill response: ' . print_r($response, true));
            return response()->json($response);
        }

        // Kiểm tra tài xế đã nhận đồng phục chưa.
        $mainData = [
            'code' => $data['driver_code']
        ];
        $driverStatus = $this->heyuApi->getStatus($mainData);
        
        if (
            isset($driverStatus['code']) && 
            $driverStatus['code'] == Response::HTTP_OK && 
            !empty($driverStatus['data']['handoverStatus'])
        ) {
            //pass
        } elseif (isset($driverStatus['code']) && $driverStatus['code'] == Response::HTTP_MULTIPLE_CHOICES) {
            $response = [
                'status' => Response::HTTP_MULTIPLE_CHOICES,
                'message' => $driverStatus['message'],
                'data' => []
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => isset($driverStatus['message']) ? $driverStatus['message'] : __('Heyu::messages.something_errors'),
                'data' => []
            ];
            return response()->json($response);
        }

        // Lưu dữ liệu vào DB Tiện Ngay
        $storeData = [
            HModel::STORE_ID      => $data['store_id'],
            HModel::STORE_NAME    => $data['store_name'],
            HModel::DRIVER_CODE   => $data['driver_code'],
            HModel::DRIVER_NAME   => $data['driver_name'],
            HModel::CREATED_BY    => $data['created_by'],
            HModel::COAT              => [
                HModel::SIZE_S        => !empty($data['coat']['s']) ? $data['coat']['s'] : 0,
                HModel::SIZE_M        => !empty($data['coat']['m']) ? $data['coat']['m'] : 0,
                HModel::SIZE_L        => !empty($data['coat']['l']) ? $data['coat']['l'] : 0,
                HModel::SIZE_XL       => !empty($data['coat']['xl']) ? $data['coat']['xl'] : 0,
                HModel::SIZE_XXL      => !empty($data['coat']['xxl']) ? $data['coat']['xxl'] : 0,
                HModel::SIZE_XXXL     => !empty($data['coat']['xxxl']) ? $data['coat']['xxxl'] : 0
            ],
            HModel::SHIRT             => [
                HModel::SIZE_S        => !empty($data['shirt']['s']) ? $data['shirt']['s'] : 0,
                HModel::SIZE_M        => !empty($data['shirt']['m']) ? $data['shirt']['m'] : 0,
                HModel::SIZE_L        => !empty($data['shirt']['l']) ? $data['shirt']['l'] : 0,
                HModel::SIZE_XL       => !empty($data['shirt']['xl']) ? $data['shirt']['xl'] : 0,
                HModel::SIZE_XXL      => !empty($data['shirt']['xxl']) ? $data['shirt']['xxl'] : 0,
                HModel::SIZE_XXXL     => !empty($data['shirt']['xxxl']) ? $data['shirt']['xxxl'] : 0
            ],
            HModel::EVIDENCE          => $data['evidence'],
        ];

        // Kiểm tra kho theo id PGD
        $storage = $this->heyuStoreRepo->detailByStoreId($data['store_id']);
        if (empty($storage)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Heyu::messages.storage_empty')
            ];
            Log::channel('heyu')->info('Heyu storeHandoverBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $storageCoat = $storage['detail']['coat'];
        $storageShirt = $storage['detail']['shirt'];
        $notEnough = false;
        Log::channel('heyu')->info('Heyu storeHandoverBill before update coat: ' . print_r($storageCoat, true));
        Log::channel('heyu')->info('Heyu storeHandoverBill before update shirt: ' . print_r($storageShirt, true));
        foreach ($storeData[HModel::COAT] as $key => $value) {
            if ($storageCoat[$key] - $value < 0) {
                $notEnough = true;
                break;
            } else {
                $storageCoat[$key] = $storageCoat[$key] - $value;
            }
        }

        foreach ($storeData[HModel::SHIRT] as $key => $value) {
            if ($storageShirt[$key] - $value < 0) {
                $notEnough = true;
                break;
            } else {
                $storageShirt[$key] = $storageShirt[$key] - $value;
            }
        }
        Log::channel('heyu')->info('Heyu storeHandoverBill after update coat: ' . print_r($storageCoat, true));
        Log::channel('heyu')->info('Heyu storeHandoverBill after update shirt: ' . print_r($storageShirt, true));
        if ($notEnough) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Heyu::messages.storage_notenought')
            ];
            Log::channel('heyu')->info('Heyu storeHandoverBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $updateStorage = $this->heyuStoreRepo->updateStorage($data['store_id'], ["coat" => $storageCoat, "shirt" => $storageShirt]);
        $result = $this->handoverRepo->store($storeData);
        if (!empty($result['_id'])) {
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $result->toArray(),
                'message' => __('Heyu::messages.success')
            ];
        } else {
            $response = [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('Heyu::messages.something_errors')
            ];
        }
        Log::channel('heyu')->info('Heyu storeHandoverBill response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * Update handover bill's status to approved
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function approveHandoverBill(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('heyu')->info('approveHandoverBill: ' . print_r($data, true));

        $validator = Validator::make($data, [
            'id'                    => 'required',
            'approvedBy'            => 'required'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first()
            ];
            Log::channel('heyu')->info('Heyu approveHandoverBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $handoverBill = $this->handoverRepo->detail($data['id']);
        if (!$handoverBill) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Heyu::messages.not_found')
            ];
            Log::channel('heyu')->info('Heyu approveHandoverBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $coatSize = '';
        $shirtSize = '';
        foreach($handoverBill[HModel::COAT] as $key => $value) {
            if ($value > 0) {
                $coatSize = $key;
                break;
            }
        }
        foreach($handoverBill[HModel::SHIRT] as $key => $value) {
            if ($value > 0) {
                $shirtSize = $key;
                break;
            }
        }
        $updateHeyuStorage = $this->handover([
            'code' => $handoverBill[HModel::DRIVER_CODE],
            'storeId' => $handoverBill[HModel::STORE_ID],
            'coatSize' => $coatSize,
            'shirtSize' => $shirtSize,
        ]);
        if ($updateHeyuStorage['status'] != Response::HTTP_OK) {
            Log::channel('heyu')->info('Heyu approveHandoverBill response: ' . print_r($updateHeyuStorage, true));
            return response()->json($updateHeyuStorage);
        }
        $update = $this->handoverRepo->approve($data['id'], $data['approvedBy']);
        if ($update) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Heyu::messages.success')
            ];
        } else {
            $response = [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('Heyu::messages.something_errors')
            ];
        }
        Log::channel('heyu')->info('Heyu approveHandoverBill response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * Update handover bill's status to cancle
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function cancleHandoverBill(Request $request) {
        $data = json_decode($request->getContent(), true);
        Log::channel('heyu')->info('cancleHandoverBill: ' . print_r($data, true));

        $validator = Validator::make($data, [
            'id'                    => 'required',
            'approvedBy'            => 'required',
            'cancleNote'           => 'required'
        ]);
        if ( $validator->fails() ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $validator->errors()->first()
            ];
            Log::channel('heyu')->info('Heyu cancleHandoverBill response: ' . print_r($response, true));
            return response()->json($response);
        }

        $handoverBill = $this->handoverRepo->detail($data['id']);
        if (!$handoverBill) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Heyu::messages.not_found')
            ];
            Log::channel('heyu')->info('Heyu cancleHandoverBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        // Update lại kho theo id PGD
        $storage = $this->heyuStoreRepo->detailByStoreId($handoverBill[HModel::STORE_ID]);
        if (empty($storage)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('Heyu::messages.not_found')
            ];
            Log::channel('heyu')->info('Heyu cancleHandoverBill response: ' . print_r($response, true));
            return response()->json($response);
        }
        $storageCoat = $storage['detail']['coat'];
        $storageShirt = $storage['detail']['shirt'];
        Log::channel('heyu')->info('Heyu cancleHandoverBill before update coat: ' . print_r($storageCoat, true));
        Log::channel('heyu')->info('Heyu cancleHandoverBill before update shirt: ' . print_r($storageShirt, true));
        foreach ($handoverBill[HModel::COAT] as $key => $value) {
            $storageCoat[$key] = $storageCoat[$key] + $value;
        }

        foreach ($handoverBill[HModel::SHIRT] as $key => $value) {
            $storageShirt[$key] = $storageShirt[$key] + $value;
        }
        Log::channel('heyu')->info('Heyu cancleHandoverBill after update coat: ' . print_r($storageCoat, true));
        Log::channel('heyu')->info('Heyu cancleHandoverBill after update shirt: ' . print_r($storageShirt, true));
        $updateStorage = $this->heyuStoreRepo->updateStorage($handoverBill[HModel::STORE_ID], ["coat" => $storageCoat, "shirt" => $storageShirt]);

        $update = $this->handoverRepo->cancle($data['id'], $data['approvedBy'], $data['cancleNote']);
        if ($update) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Heyu::messages.success')
            ];
        } else {
            $response = [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('Heyu::messages.something_errors')
            ];
        }
        Log::channel('heyu')->info('Heyu cancleHandoverBill response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
    * Xác nhận giao đồng phục cho tài xế
    * @param $request Illuminate\Http\Request
    * @return $response json
    */
    public function handover($data)
    {
        $mainData = [
            'code' => $data['code'],
            'storeId' => $data['storeId'],
            'coatSize' => data_get($data, 'coatSize', ''),
            'shirtSize' => data_get($data, 'shirtSize', ''),
        ];
        Log::channel('heyu')->info('Heyu handover request: ' . print_r($mainData, true));
        $result = $this->heyuApi->handover($mainData);
        Log::channel('heyu')->info('Heyu handover response: ' . print_r($result, true));
        if (isset($result['code']) && $result['code'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Heyu::messages.success')
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => isset($result['message']) ? $result['message'] : __('Heyu::messages.something_errors')
            ];
        }
        return $response;
    }
}
