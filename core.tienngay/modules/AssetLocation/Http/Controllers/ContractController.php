<?php


namespace Modules\AssetLocation\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\AssetLocation\Http\Repository\ContractRepository;
use Modules\AssetLocation\Http\Service\ContractService;
use Modules\AssetLocation\Http\Service\RoleService;
use Modules\AssetLocation\Http\Service\StoreService;

class ContractController extends BaseController
{
    protected $contractService;
    protected $storeService;
    protected $roleService;
    protected $contractRepository;

    public function __construct(ContractService $contractService,
                                StoreService $storeService,
                                RoleService $roleService,
                                ContractRepository $contractRepository)
    {
        $this->contractService = $contractService;
        $this->storeService = $storeService;
        $this->roleService = $roleService;
        $this->contractRepository = $contractRepository;
    }

    public function asset_by_user_business(Request $request)
    {
        $data = $this->contractService->asset_by_user_business($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function recall_device(Request $request)
    {
        $check = $this->contractService->validate_recall_device($request);
        if (count($check) > 0) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $check[0]);
        } else {
            $this->contractService->recall_device($request);
            return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
        }
    }

    public function asset_by_asm_business(Request $request)
    {
        $data = $this->contractService->asset_by_asm_business($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function get_store_by_asm(Request $request)
    {
        $data = $this->roleService->getStoresName($request->user->_id);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function send_alarm_contract_by_product_asset_location(Request $request)
    {
        $this->contractService->send_alarm_contract_by_product_asset_location();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    public function contract_by_product_asset_location()
    {
        $this->contractService->contract_by_product_asset_location();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    public function update_address_contract(Request $request)
    {
        $check = $this->contractService->validate_update_address_contract($request);
        if (count($check) > 0) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $check[0]);
        } else {
            $this->contractService->update_address_contract($request);
            return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
        }
    }

    public function update_note_contract(Request $request)
    {
        $check = $this->contractService->validate_update_note_contract($request);
        if (count($check) > 0) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $check[0]);
        } else {
            $this->contractService->update_note_contract($request);
            return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
        }
    }

    public function contract_by_collection(Request $request)
    {
        $data = $this->contractService->contract_by_collection($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function get_store_by_collection(Request $request)
    {
        $data = $this->roleService->get_store_by_collection($request->user->email);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function deepDetect(Request $request)
    {
        $link = $request->link;
        $response = Http::withHeaders([
            'Token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwiY2xpZW50IjoidGllbm5nYXkuYXNzZXRzIiwia2V5Ijo0MTEyNTgxOTkwfQ.EC5EhZOxYrgPlfcne1-Yb374TP00A7C1rgieMauBpQI'
        ])->get('https://checker.tienvui.vn/deepDetectUrl?url=' . $link);
        $result = json_decode($response->body());
        if ($result && $result->isSuccess == true) {
            $data = $result->paths[0]->results;
            $data_result = [];
            foreach ($data as $datum) {
                if ($datum->type == 1) {
                    $contract = $this->contractRepository->find($datum->id);
                    if ($contract && !empty($contract['code_contract'])) {
                        $datum->code_contract_disbursement = $contract['code_contract_disbursement'] ?? $contract['code_contract'];
                        $datum->store = $contract['store']['name'];
                        $datum->status = contract_status($contract['status']);
                        $datum->amount_money = number_format($contract['loan_infor']['amount_money']);
                        $datum->customer_name = ($contract['customer_infor']['customer_name']);
                        array_push($data_result, $datum);
                    }
                }
            }
            return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data_result);
        } else {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, self::FAIL);
        }
    }

    public function excel_asset_by_user_business(Request $request)
    {
        $data = $this->contractService->excel_asset_by_user_business($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function recall_device_hand_over(Request $request){

        $check = $this->contractService->validate_recall_device($request);
        if (count($check) > 0) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $check[0]);
        } else {
            $this->contractService->recall_device_hand_over($request);
            return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
        }

    }
}
