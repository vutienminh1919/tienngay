<?php

namespace Modules\Macom\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\MongodbCore\Entities\Macom;
use Modules\MongodbCore\Repositories\Interfaces\MacomRepositoryInterface as macomRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as roleRepository;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface as userCpanelRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as storeRepository;
use Modules\MongodbCore\Repositories\Interfaces\AreaRepositoryInterface as areaRepository;
use Modules\MongodbCore\Repositories\Interfaces\HistoryMacomRepositoryInterface as historyMacomRepository;

class MacomController extends BaseController
{

    private $macomRepository;
    private $roleRepository;
    private $userCpanelRepository;
    private $storeRepository;
    private $areaRepository;
    private $historyMacomRepository;

    public function __construct(
        MacomRepository $macomRepository,
        RoleRepository $roleRepository,
        UserCpanelRepository $userCpanelRepository,
        StoreRepository $storeRepository,
        AreaRepository $areaRepository,
        HistoryMacomRepository $historyMacomRepository
        )
    {
        $this->macomRepository = $macomRepository;
        $this->roleRepository = $roleRepository;
        $this->storeRepository = $storeRepository;
        $this->userCpanelRepository = $userCpanelRepository;
        $this->areaRepository = $areaRepository;
        $this->historyMacomRepository = $historyMacomRepository;
    }

    /**
    * save
    * 
    * @param Illuminate\Http\Request;
    * @return json
    */
    public function save(Request $request) {
        $dataRequest = $request->all();
        log::channel('macom')->info('data save' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            "campaign_name" => "required",
            "code_area"     => "required",
            'store'         => 'required',
            'url'           => 'required',
        ], [
            "campaign_name"         => "Tên chiến dịch đang để trống",
            "code_area.required"    => "Chưa có khu vực nào được chọn",
            "store.required"        => "Chưa có phòng giao dịch được chọn",
            "url.required"          => "Chưa upload chứng từ",
        ]);
        Log::channel('macom')->info("validator ". $validator->fails());
        if($validator->fails()) {
            Log::channel('macom')->info('save validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
            ]);
        }
        if (count($dataRequest['store']) > 0) {
            $divison_social = (float)($dataRequest['social_media']/count($dataRequest['store']));
            $divison_pr = (float)($dataRequest['pr_tv']/count($dataRequest['store']));
            $divison_kol = (float)($dataRequest['kol_koc']/count($dataRequest['store']));
            $divison_ooh = (float)($dataRequest['ooh']/count($dataRequest['store']));
            $divison_other = (float)($dataRequest['other']/count($dataRequest['store']));
        }
        if (!empty($dataRequest['store'])) {
            foreach ($dataRequest['store'] as $i) {
                $store_name = $this->storeRepository->getStoreName($i);
                $store[] = [
                    'id' => $i,
                    'store' => $store_name,
                    'code_area' => $dataRequest['code_area'],
                    'social_media' => $divison_social,
                    'pr_tv' => $divison_pr,
                    'kol_koc' => $divison_kol,
                    'ooh' => $divison_ooh,
                    'other' => $divison_other,
                ];
            }
        }
        $code_area_name = $this->areaRepository->getCodeAreaName($dataRequest['code_area']);
        $domain = $this->areaRepository->getDomainByCodeArea($dataRequest['code_area']);
        $input = [
            'campaign_name' => $dataRequest['campaign_name'] ?? "",
            'code_area' => $dataRequest['code_area'] ?? "",
            'social_media' => (float)$dataRequest['social_media'] ?? "",
            'pr_tv' => (float)$dataRequest['pr_tv'] ?? "",
            'kol_koc' => (float)$dataRequest['kol_koc'] ?? "",
            'ooh' => (float)$dataRequest['ooh'] ?? "",
            'other' =>(float)$dataRequest['other'] ?? "",
            'stores' => $store ?? "",
            'url' => $dataRequest['url'] ?? "",
            'area_name' => $code_area_name['title'] ?? "",
            'domain' => $domain['domain']['code'] ?? "",
            'domain_name' => $domain['domain']['name'] ?? "",
            'created_by' => $dataRequest['created_by'] ?? "",
            'updated_by' => $dataRequest['created_by'] ?? "",
            'hits' => (int)$dataRequest['hits'] ?? "",
        ];
        log::channel('macom')->info('data save'. print_r($input, true));
        $create = $this->macomRepository->create($input);
        if ($create) {
            $input['macom_id'] = $create['_id'];
            $history = $this->historyMacomRepository->create($input);
            Log::channel('macom')->info('create history macom' . print_r($create, true));
            if (!$create || !$history) {
                return response()->json([
                    BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                    BaseController::MESSAGE => BaseController::FAIL,
                    BaseController::DATA => BaseController::NO_DATA,
                ]);
            }
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $create,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => BaseController::NO_DATA,
        ]);
    }

    /**
    * getStoreByCodeArea
    * 
    * @param Illuminate\Http\Request;
    * @return json
    */
    public function getStoreByCodeArea(Request $request) {
        $dataRequest = $request->all();
        $store = $this->storeRepository->getStoreByCodeArea($dataRequest['code_area']);
        if ($store) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $store,
            ]);
        }
    }

    /**
    * update
    * 
    * @param Illuminate\Http\Request;
    * @param string $id;
    * @return json
    */
    public function update(Request $request, $id) {
        $dataRequest = $request->all();
        log::channel('macom')->info('data update' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            "campaign_name" => "required",
            "code_area"     => "required",
            'store'         => 'required',
            'url'           => 'required',
        ], [
            "campaign_name"         => "Tên chiến dịch đang để trống",
            "code_area.required"    => "Chưa có khu vực nào được chọn",
            "store.required"        => "Chưa có phòng giao dịch được chọn",
            "url.required"          => "Chưa upload chứng từ",
        ]);
        Log::channel('macom')->info("validator ". $validator->fails());
        if($validator->fails()) {
            Log::channel('macom')->info('update validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
            ]);
        }
        if (count($dataRequest['store']) > 0) {
            $divison_social = (float)($dataRequest['social_media']/count($dataRequest['store']));
            $divison_pr = (float)($dataRequest['pr_tv']/count($dataRequest['store']));
            $divison_kol = (float)($dataRequest['kol_koc']/count($dataRequest['store']));
            $divison_ooh = (float)($dataRequest['ooh']/count($dataRequest['store']));
            $divison_other = (float)($dataRequest['other']/count($dataRequest['store']));
        }
        if (!empty($dataRequest['store'])) {
            foreach ($dataRequest['store'] as $i) {
                $store_name = $this->storeRepository->getStoreName($i);
                $store[] = [
                    'id' => $i,
                    'store' => $store_name,
                    'code_area' => $dataRequest['code_area'],
                    'social_media' => $divison_social,
                    'pr_tv' => $divison_pr,
                    'kol_koc' => $divison_kol,
                    'ooh' => $divison_ooh,
                    'other' => $divison_other,
                ];
            }
        }
        $detail_history = $this->historyMacomRepository->findById($id);
        $code_area_name = $this->areaRepository->getCodeAreaName($dataRequest['code_area']);
        $domain = $this->areaRepository->getDomainByCodeArea($dataRequest['code_area']);
        $inputUpdate = [
            'campaign_name' => $dataRequest['campaign_name'] ?? "",
            'code_area' => $dataRequest['code_area'] ?? "",
            'social_media' => (float)$dataRequest['social_media'] ?? "",
            'pr_tv' => (float)$dataRequest['pr_tv'] ?? "",
            'kol_koc' => (float)$dataRequest['kol_koc'] ?? "",
            'ooh' => (float)$dataRequest['ooh'] ?? "",
            'other' =>(float)$dataRequest['other'] ?? "",
            'stores' => $store ?? "",
            'url' => $dataRequest['url'] ?? "",
            'area_name' => $code_area_name['title'] ?? "",
            'domain' => $domain['domain']['code'] ?? "",
            'domain_name' => $domain['domain']['name'] ?? "",
            'updated_by' => $dataRequest['updated_by'] ?? "",
            'hits' => (int)$dataRequest['hits'] ?? "",
        ];
        log::channel('macom')->info('data update'. print_r($inputUpdate, true));
        $update = $this->macomRepository->update($inputUpdate, $id);
        if ($update) {
            $history = $this->historyMacomRepository->update($inputUpdate, $id);
            Log::channel('macom')->info('update history macom' . print_r($history, true));
            if (!$update || !$history) {
                return response()->json([
                    BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                    BaseController::MESSAGE => BaseController::FAIL,
                    BaseController::DATA => BaseController::NO_DATA,
                ]);
            }
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $update,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => BaseController::NO_DATA,
        ]);
    }

    /**
    * getAreaByDomain
    * 
    * @param Illuminate\Http\Request;
    * @return json
    */
    public function getAreaByDomain(Request $request) {
        $dataRequest = $request->all();
        $area = $this->areaRepository->getAreaByDomain($dataRequest['domain']);
        if ($area) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $area,
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
            BaseController::MESSAGE => BaseController::FAIL,
            BaseController::DATA => BaseController::NO_DATA,
        ]);
    }


}