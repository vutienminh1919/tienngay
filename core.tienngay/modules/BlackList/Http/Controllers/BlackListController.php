<?php

namespace Modules\BlackList\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Modules\MongodbCore\Repositories\BlackListRepository;
use Modules\MongodbCore\Repositories\Interfaces\BlackListRepositoryInterface as BlackListRepositoryInterface;
use Modules\MongodbCore\Entities\BlackList;
use Modules\BlackList\Service\BlackListApi;
use Modules\MongodbCore\Repositories\HcnsRepository;
use Modules\MongodbCore\Repositories\Interfaces\HcnsRepositoryInterface as HcnsRepositoryInterface;

class BlackListController extends BaseController
{
    private $blacklistRepository;

    private $hcnsRepository;
    /**
     * @OA\Info(
     *     version="1.0",
     * )
     */
    public function __construct(
        BlackListRepository $blacklistRepository,
        HcnsRepository $hcnsRepository
    )
    {
        $this->blacklistRepository = $blacklistRepository;
        $this->hcnsRepository = $hcnsRepository;
    }

    //cronjob insert into blacklist (1 time/day)
    public function insertBlacklist()
    {
        $exemtion = $this->saveExemtion();
        $hcns = $this->saveHcns();
        $property = $this->saveProperty();
        $response = [
            'status' => BaseController::HTTP_OK,
            'message' => 'ok',
        ];
        return response()->json($response);

    }

    //insert Property
    public function saveProperty()
    {
        $data = BlackListApi::getBlacklistProperty();
        $result = [];
        if ($data['status'] == 200 && !empty($data['data'])) {
            $property = $data['data'];
            //        Log::channel('blacklist')->info('result api' . print_r($property, true));
            foreach ($property as $item) {
                $pro = $this->blacklistRepository->findProperty($item['_id']['$oid']);
                $identify = !empty($item['customer_infor']['identify']) ? $item['customer_infor']['identify'] : "";
                $passport = !empty($item['customer_infor']['passport']) ? $item['customer_infor']['passport'] : "" ;
                if (($identify == "") && ($passport == "")) {
                    $dataInsert = [
                        BlackList::NAME => !empty($item['customer_infor']['name']) ? $item['customer_infor']['name'] : "",
                        BlackList::PHONE => !empty($item['customer_infor']['phone']) ? $item['customer_infor']['phone'] : "",
                        BlackList::IDENTIFY => !empty($item['customer_infor']['identify']) ? $item['customer_infor']['identify'] : "",
                        BlackList::PASSPORT => !empty($item['customer_infor']['passport']) ? $item['customer_infor']['passport'] : "",
                        BlackList::ID_PROPERTY => !empty($item['_id']['$oid']) ? $item['_id']['$oid'] : "",
                        BlackList::ID_HCNS => "",
                        BlackList::ID_EXEMTION => "",
                        BlackList::CREATED_BY => $item['created_by'],
                        BlackList::CREATED_AT => time(),
                    ];
                    $create = $this->blacklistRepository->createProperty($dataInsert);
                }
                if ($identify) {
                    $propertySameIdentify = $this->blacklistRepository->findSameId($identify);
                    if ($propertySameIdentify) {
                        $update = [
                            BlackList::NAME => $propertySameIdentify['name'],
                            BlackList::PHONE => $propertySameIdentify['phone'],
                            BlackList::IDENTIFY => $propertySameIdentify['identify'],
                            BlackList::PASSPORT => $propertySameIdentify['passport'],
                            BlackList::ID_PROPERTY => !empty($item['_id']['$oid']) ? $item['_id']['$oid'] : "",
                            BlackList::ID_HCNS => $propertySameIdentify['id_hcns'],
                            BlackList::ID_EXEMTION => $propertySameIdentify['id_exemtion'],
                            BlackList::CREATED_BY => $propertySameIdentify['created_by'],
                            BlackList::CREATED_AT => $propertySameIdentify['created_at'],
                            BlackList::UPDATED_AT => time(),
                            BlackList::UPDATED_BY => $propertySameIdentify['created_by'],
                        ];
                        $create = $this->blacklistRepository->updatePropertyID($update, $propertySameIdentify['_id']);
                    } else {
                        if (empty($pro)) {
                            $dataInsert = [
                                BlackList::NAME => !empty($item['customer_infor']['name']) ? $item['customer_infor']['name'] : "",
                                BlackList::PHONE => !empty($item['customer_infor']['phone']) ? $item['customer_infor']['phone'] : "",
                                BlackList::IDENTIFY => !empty($item['customer_infor']['identify']) ? $item['customer_infor']['identify'] : "",
                                BlackList::PASSPORT => !empty($item['customer_infor']['passport']) ? $item['customer_infor']['passport'] : "",
                                BlackList::ID_PROPERTY => !empty($item['_id']['$oid']) ? $item['_id']['$oid'] : "",
                                BlackList::ID_HCNS => "",
                                BlackList::ID_EXEMTION => "",
                                BlackList::CREATED_BY => $item['created_by'],
                                BlackList::CREATED_AT => time(),
                            ];
                            $create = $this->blacklistRepository->createProperty($dataInsert);
                        } else {
                            $update = [
                                BlackList::NAME => $pro['name'],
                                BlackList::PHONE => !empty($item['customer_infor']['phone']) ? $item['customer_infor']['phone'] : "",
                                BlackList::IDENTIFY => !empty($item['customer_infor']['identify']) ? $item['customer_infor']['identify'] : "",
                                BlackList::PASSPORT => !empty($item['customer_infor']['passport']) ? $item['customer_infor']['passport'] : "",
                                BlackList::ID_PROPERTY => $pro['id_property'],
                                BlackList::ID_HCNS => "",
                                BlackList::ID_EXEMTION => "",
                                BlackList::CREATED_BY => $pro['created_by'],
                                BlackList::CREATED_AT => $pro['created_at'],
                                BlackList::UPDATED_AT => time(),
                                BlackList::UPDATED_BY => $pro['created_by'],
                            ];
                            $create = $this->blacklistRepository->updateProperty($update, $pro['_id']);
                        }
                    }
                    $result[] = !empty($create) ? $create : "";
                    if ($result) {
                        $response = [
                            BaseController::STATUS => BaseController::HTTP_OK,
                            BaseController::MESSAGE => BaseController::SUCCESS,
                            BaseController::DATA => $result
                        ];
                    } else {
                        $response = [
                            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                            BaseController::MESSAGE => BaseController::ERRORS,
                        ];
                    }
                }
                if ($passport) {
                    $propertySameIdentify = $this->blacklistRepository->findSamePassport($passport);
                    if ($propertySameIdentify) {
                        $update = [
                            BlackList::NAME => $propertySameIdentify['name'],
                            BlackList::PHONE => $propertySameIdentify['phone'],
                            BlackList::IDENTIFY => $propertySameIdentify['identify'],
                            BlackList::PASSPORT => $propertySameIdentify['passport'],
                            BlackList::ID_PROPERTY => !empty($item['_id']['$oid']) ? $item['_id']['$oid'] : "",
                            BlackList::ID_HCNS => $propertySameIdentify['id_hcns'],
                            BlackList::ID_EXEMTION => $propertySameIdentify['id_exemtion'],
                            BlackList::CREATED_BY => $propertySameIdentify['created_by'],
                            BlackList::CREATED_AT => $propertySameIdentify['created_at'],
                            BlackList::UPDATED_AT => time(),
                            BlackList::UPDATED_BY => $propertySameIdentify['created_by'],
                        ];
                        $create = $this->blacklistRepository->updatePropertyID($update, $propertySameIdentify['_id']);
                    } else {
                        if (empty($pro)) {
                            $dataInsert = [
                                BlackList::NAME => !empty($item['customer_infor']['name']) ? $item['customer_infor']['name'] : "",
                                BlackList::PHONE => !empty($item['customer_infor']['phone']) ? $item['customer_infor']['phone'] : "",
                                BlackList::IDENTIFY => !empty($item['customer_infor']['identify']) ? $item['customer_infor']['identify'] : "",
                                BlackList::PASSPORT => !empty($item['customer_infor']['passport']) ? $item['customer_infor']['passport'] : "",
                                BlackList::ID_PROPERTY => !empty($item['_id']['$oid']) ? $item['_id']['$oid'] : "",
                                BlackList::ID_HCNS => "",
                                BlackList::ID_EXEMTION => "",
                                BlackList::CREATED_BY => $item['created_by'],
                                BlackList::CREATED_AT => time(),
                            ];
                            $create = $this->blacklistRepository->createProperty($dataInsert);
                        } else {
                            $update = [
                                BlackList::NAME => $pro['name'],
                                BlackList::PHONE => !empty($item['customer_infor']['phone']) ? $item['customer_infor']['phone'] : "",
                                BlackList::IDENTIFY => !empty($item['customer_infor']['identify']) ? $item['customer_infor']['identify'] : "",
                                BlackList::PASSPORT => !empty($item['customer_infor']['passport']) ? $item['customer_infor']['passport'] : "",
                                BlackList::ID_PROPERTY => $pro['id_property'],
                                BlackList::ID_HCNS => "",
                                BlackList::ID_EXEMTION => "",
                                BlackList::CREATED_BY => $pro['created_by'],
                                BlackList::CREATED_AT => $pro['created_at'],
                                BlackList::UPDATED_AT => time(),
                                BlackList::UPDATED_BY => $pro['created_by'],
                            ];
                            $create = $this->blacklistRepository->updateProperty($update, $pro['_id']);
                        }
                    }
                    $result[] = !empty($create) ? $create : "";
                    if ($result) {
                        $response = [
                            BaseController::STATUS => BaseController::HTTP_OK,
                            BaseController::MESSAGE => BaseController::SUCCESS,
                            BaseController::DATA => $result
                        ];
                    } else {
                        $response = [
                            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                            BaseController::MESSAGE => BaseController::ERRORS,
                        ];
                    }
                }
            }
        } else {
            $response = [
                'status' => BaseController::HTTP_BAD_REQUEST,
                'message' => BaseController::NO_DATA,
            ];
        }
        return response()->json(!empty($response_) ? $response : "");

    }
        //insert hcns
    public function saveHcns()
    {
        $hcns = $this->getAllHcns();
        // Log::channel('BlackList')->info('data hcns' . print_r($hcns, true));
        $result = [];
        if (empty($hcns['data'])) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::NO_DATA,
            ];
        } else {
            foreach ($hcns['data'] as $k => $i) {
                $identify = $i['user_identify'];
                if ($identify) {
                    $propertySameIdentify = $this->blacklistRepository->findSameId($identify);
                    if ($propertySameIdentify) {
                        $update = [
                            BlackList::NAME => $propertySameIdentify['name'],
                            BlackList::PHONE => $propertySameIdentify['phone'],
                            BlackList::IDENTIFY => $propertySameIdentify['identify'],
                            BlackList::PASSPORT => $propertySameIdentify['passport'],
                            BlackList::ID_PROPERTY => $propertySameIdentify['id_property'],
                            BlackList::ID_HCNS => $i['_id'],
                            BlackList::ID_EXEMTION => $propertySameIdentify['id_exemtion'],
                            BlackList::CREATED_BY => $propertySameIdentify['created_by'],
                            BlackList::CREATED_AT => $propertySameIdentify['created_at'],
                            BlackList::UPDATED_AT => time(),
                            BlackList::UPDATED_BY => $propertySameIdentify['created_by'],

                        ];
                        $create = $this->blacklistRepository->updatePropertyID($update, $propertySameIdentify['_id']);
                    } else {
                        $dataInsert = [
                            BlackList::NAME => $i['user_name'],
                            BlackList::PHONE => $i['user_phone'],
                            BlackList::IDENTIFY => $i['user_identify'],
                            BlackList::PASSPORT => $i['user_passport'],
                            BlackList::ID_HCNS => $i['_id'],
                            BlackList::ID_PROPERTY => "",
                            BlackList::ID_EXEMTION => "",
                            BlackList::CREATED_BY => $i['created_by'],
                            BlackList::CREATED_AT => time(),
                        ];
                        // Log::channel('BlackList')->info('data insert' . print_r($dataInsert, true));
                        $create = $this->blacklistRepository->createHcns($dataInsert);
                    }
                    if ($create) {
                        $result[] = $create;
                    }
                }
            }
            $response = [
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $result
            ];
        }
        return response()->json($response);
    }
        // get all hcns from blacklist_hcns
    public function getAllHcns()
    {
        $data = $this->hcnsRepository->getALlHcnsScan();
        foreach ($data as $item) {
            $this->hcnsRepository->updateScan([
                'scan' => 2
            ], $item['_id']);
        }
        if ($data) {
            $response = [
                'status' => BaseController::HTTP_OK,
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => BaseController::HTTP_BAD_REQUEST,
                'data' => [],
            ];
        }
        return $response;
    }
        //get all exemtion from exemtions
    public function getAllExemtion()
    {
        $data = BlackListApi::getBlacklistExemtion();
        if ($data) {
            $response = [
                'status' => BaseController::HTTP_OK,
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => BaseController::HTTP_BAD_REQUEST,
                'data' => [],
            ];
        }
        return $response;

    }
        //insert exemption
    public function saveExemtion()
    {
        $exemtion = $this->getAllExemtion();
        $result = [];
         if (empty($exemtion['data']['data'])) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::NO_DATA,
            ];
         } else {
             foreach ($exemtion['data']['data'] as $k => $i) {
                 $record = $this->blacklistRepository->findExemtion($i['customer_identify']);
                 if ($record) {
                     $id_exemtion = $i['_id']['$oid'];
                     $id_contract = $i['id_contract'];
                     $update = [
                         BlackList::ID_EXEMTION => $id_exemtion,
                         BlackList::ID_CONTRACT_EXEMTION => $id_contract
                     ];
                     $this->blacklistRepository->updateIdExemtion($update, $record['_id']);
                 }
                 $identify = $i['customer_identify'];
                 if ($identify) {
                     $propertySameIdentify = $this->blacklistRepository->findSameId($identify);
                     if ($propertySameIdentify) {
                         $update = [
                             BlackList::NAME => $propertySameIdentify['name'],
                             BlackList::PHONE => $propertySameIdentify['phone'],
                             BlackList::IDENTIFY => $propertySameIdentify['identify'],
                             BlackList::PASSPORT => $propertySameIdentify['passport'],
                             BlackList::ID_PROPERTY => $propertySameIdentify['id_property'],
                             BlackList::ID_HCNS => $propertySameIdentify['id_hcns'],
                             BlackList::ID_EXEMTION => !empty($i['_id']['$oid']) ? (array)$i['_id']['$oid'] : "",
                             BlackList::CREATED_BY => $propertySameIdentify['created_by'],
                             BlackList::CREATED_AT => $propertySameIdentify['created_at'],
                             BlackList::UPDATED_AT => time(),
                             BlackList::UPDATED_BY => $propertySameIdentify['created_by'],
                         ];
                         $create = $this->blacklistRepository->updatePropertyID($update, $propertySameIdentify['_id']);
                     } else {
                         if (empty($record)) {
                             $dataInsert = [
                                 BlackList::NAME => $i['customer_name'],
                                 BlackList::PHONE => $i['customer_phone_number'],
                                 BlackList::IDENTIFY => $i['customer_identify'],
                                 BlackList::PASSPORT => "",
                                 BlackList::ID_HCNS => "",
                                 BlackList::ID_PROPERTY => "",
                                 BlackList::ID_EXEMTION => !empty($i['_id']['$oid']) ? (array)$i['_id']['$oid'] : "",
                                 BlackList::ID_CONTRACT_EXEMTION => (array)$i['id_contract'],
                                 BlackList::CREATED_BY => $i['created_profile_by'],
                                 BlackList::CREATED_AT => time(),
                             ];
                             // Log::channel('BlackList')->info('data insert' . print_r($dataInsert, true));
                             $create = $this->blacklistRepository->createExemtion($dataInsert);
                             if ($create) {
                                 $result[] = $create;
                             }
                         }
                     }
                 } else {
                     $response = [
                         BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                         BaseController::MESSAGE => BaseController::ERRORS,
                     ];
                 }
                 $response = [
                     BaseController::STATUS => BaseController::HTTP_OK,
                     BaseController::MESSAGE => BaseController::SUCCESS,
                     BaseController::DATA => $result
                 ];
             }
         }
        return response()->json($response);

    }

    public function getHcnsNoScan()
    {
        $records = $this->hcnsRepository->getHcnsWithNoScan();
        foreach ($records as $item) {
            $this->hcnsRepository->addScanHcns($item['_id']);
        }
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ];
        return response()->json($response);

    }

    public function removeProperty()
    {
        $property = $this->blacklistRepository->getBlacklistPropertyAndRemove();
        $response = [
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ];
        return response()->json($response);

    }


}
