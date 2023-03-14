<?php

namespace App\Http\Controllers;

use App\Models\ConfigCall;
use App\Models\LeadInvestor;
use App\Models\LogCall;
use App\Models\LogChangeLead;
use App\Repository\ConfigCallRepositoryInterface;
use App\Repository\LeadInvestorRepositoryInterface;
use App\Repository\LogCallRepositoryInterface;
use App\Repository\LogChangeLeadRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\LeadInvestorService;
use App\Service\LogCallService;
use App\Service\LogInvestorService;
use App\Service\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeadInvestorController extends Controller
{
    public function __construct(LeadInvestorRepositoryInterface $leadInvestor,
                                LeadInvestorService $leadInvestorService,
                                LogInvestorService $logInvestorService,
                                LogCallService $logCallService,
                                LogCallRepositoryInterface $logCall,
                                UserRepositoryInterface $userRepository,
                                ConfigCallRepositoryInterface $configCallRepository,
                                RoleService $roleService,
                                LogChangeLeadRepositoryInterface $log_change_lead)
    {
        $this->leadInvestor_model = $leadInvestor;
        $this->leadInvestor_service = $leadInvestorService;
        $this->logInvestorService = $logInvestorService;
        $this->logCallService = $logCallService;
        $this->logCall_model = $logCall;
        $this->user_model = $userRepository;
        $this->configCallRepository = $configCallRepository;
        $this->roleService = $roleService;
        $this->log_change_lead_model = $log_change_lead;
    }

    public function importLeadInvestor(Request $request)
    {
        $validate = $this->leadInvestor_service->validateImportInvestor($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => $validate->errors()->first(),
                'key' => $request->key
            ]);
        }
        if (isset($request->phone)) {
            if (substr($request->phone, 0, 1) !== '0') {
                $phone_number = '0' . $request->phone;
            } else {
                if (substr($request->phone, 0, 1 == 'o') || substr($request->phone, 0, 1 == 'O')) {
                    $phone_number = '0' . substr($request->phone, 1, strlen($request->phone) - 1);
                } else {
                    $phone_number = $request->phone;
                }
            }
        }
        $lead = $this->leadInvestor_model->findOne([LeadInvestor::COLUMN_PHONE => $phone_number]);
        if ($lead) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Số điện thoại đã tồn tại',
                'key' => $request->key
            ]);
        }
        $request->phone_number = $phone_number;
        $this->leadInvestor_service->import_create($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'success',
        ]);
    }

    public function get_list_lead_investor(Request $request)
    {
        $filter = $request->only('name_investor', 'phone', 'status', 'status_call', 'source', 'find_call_assign', 'priority', 'note_delete');
        $role = $this->roleService->get_user_role();
        foreach ($role as $item) {
            if ($item->slug == 'telesales') {
                if ($item->pivot->position == 1) {
                    $filter['assign_call'] = current_user()->id;
                }
            }
        }
        $leads = $this->leadInvestor_model->get_list_lead_investor($filter);
        foreach ($leads as $lead) {
            $lead->call = $lead->call;
            if (isset($lead->assign_call)) {
                $cskh = $this->user_model->find($lead->assign_call);
                $lead->user_call = $cskh->email;
                $lead->id_user_call = $cskh->id;
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'success',
            'data' => $leads
        ]);
    }

    public function call_detail(Request $request)
    {
        $lead = $this->leadInvestor_model->find($request->id);
        $lead->call = $lead->call;
        return response()->json([
            'status' => Controller::HTTP_OK,
            "data" => $lead,
        ]);
    }


    public function call_update_investor(Request $request)
    {
        if (isset($request->email)) {
            $lead_email = $this->leadInvestor_model->findOne(['email' => $request->email]);
            if ($lead_email) {
                if ($request->id != $lead_email->id) {
                    return response()->json([
                        'status' => Controller::HTTP_BAD_REQUEST,
                        "message" => "Email đã tồn tại",
                    ]);
                }
            }
        }
        if (isset($request->identity)) {
            if (strlen($request->identity) < 9 || strlen($request->identity) > 12) {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    "message" => "CMT từ 9 đến 12 số",
                ]);
            }
            $lead_cmt = $this->leadInvestor_model->findOne(['identity' => $request->identity]);
            if ($lead_cmt) {
                if ($request->id != $lead_cmt->id) {
                    return response()->json([
                        'status' => Controller::HTTP_BAD_REQUEST,
                        "message" => "CMT đã tồn tại",
                    ]);
                }
            }
        }
        if (isset($request->status) && $request->status == 13) {
            if (!isset($request->note)) {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    "message" => "Vui lòng chọn lý do hủy",
                ]);
            }
        }
        $data = $this->leadInvestor_service->call_update_investor($request);
        $this->logInvestorService->create_log($request->all(), $data);
        $this->logCallService->add_log_call_lead($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            "message" => "Cập nhật thành công",
        ]);
    }

    public function history_call_lead(Request $request)
    {
        $lead = $this->leadInvestor_model->find($request->id);
        $lead->call = $lead->call;
        if (isset($lead->call)) {
            $lead->log = $this->logCall_model->findManySortColumn([LogCall::COLUMN_CALL_ID => $lead->call->id], LogCall::COLUMN_CREATED_AT, 'DESC');
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            "message" => "thành công",
            'data' => $lead
        ]);
    }

    public function excel_call_lead(Request $request)
    {

        $filter = $request->only('fdate', 'tdate');
        $list = $this->leadInvestor_model->getAllListNew($filter);
        foreach ($list as $value) {
            $value->call = $value->call;
            if (!empty($value->assign_call)) {
                $value->user_call = $this->user_model->find($value->assign_call);
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $list
        ]);
    }

    public function assign_call_old(Request $request)
    {
        $leads = $this->leadInvestor_model->get_all_lead();
        foreach ($leads as $lead) {
            $this->leadInvestor_model->update($lead->id, [LeadInvestor::COLUMN_ASSIGN_CALL => $request->id]);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            "message" => "thành công",
        ]);
    }

    public function test_auto()
    {
        $leads = $this->leadInvestor_model->get_lead_null_assign();
        $cskh_online = $this->configCallRepository->findOne([ConfigCall::COLUMN_DATE => date('Y-m-d')]);
        if ($cskh_online) {
            $users = explode(',', $cskh_online->telesales);
            $last_lead = $this->leadInvestor_model->findLastLead();
            if ($last_lead) {
                $user_last_lead = $last_lead->assign_call;
                $vi_tri_auto = array_search($user_last_lead, $users);
                if (isset($vi_tri_auto)) {
                    if ($vi_tri_auto == (count($users) - 1)) {
                        $start = 0;
                    } else {
                        $start = $vi_tri_auto + 1;
                    }
                } else {
                    $start = 0;
                }
            } else {
                $start = 0;
            }
            if (count($leads) > 0) {
                $count = 0;
                for ($i = 0, $j = $start; $i < count($leads), $j < count($users); $i++, $j++) {
                    $this->leadInvestor_model->update($leads[$i]->id, [LeadInvestor::COLUMN_ASSIGN_CALL => $users[$j]]);
                    if (count($users) - 1 == $j) {
                        $j = -1;
                    }
                    $count++;
                    if ($count == count($leads)) {
                        break;
                    }
                }
            }
        }
    }

    public function change_call(Request $request)
    {
        if (empty($request->user_call_id)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                "message" => "User đã được gán",
            ]);
        }
        $lead = $this->leadInvestor_model->find($request->id_lead);
        if ($lead->assign_call == $request->user_call_id) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                "message" => "User đã được gán",
            ]);
        }
        $lead_new = $this->leadInvestor_model->update($lead->id, [LeadInvestor::COLUMN_ASSIGN_CALL => $request->user_call_id]);
        $this->log_change_lead_model->create(
            [
                LogChangeLead::COLUMN_TYPE => 'lead',
                LogChangeLead::COLUMN_REQUEST => json_encode($lead),
                LogChangeLead::COLUMN_RESPONSE => json_encode($lead_new),
                LogChangeLead::COLUMN_INVESTOR_ID => $request->id_lead,
                LogChangeLead::COLUMN_CREATED_BY => current_user()->email
            ]
        );
        return response()->json([
            'status' => Controller::HTTP_OK,
            "message" => "Thành công",
        ]);
    }

    public function insertLeadInvest(Request $request)
    {
        $validate = $this->leadInvestor_service->validateInsertLeadInvest($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_UNAUTHORIZED,
                'message' => $validate->errors()->first(),
            ]);
        }
        $insertLead = $this->leadInvestor_service->insert_lead_invest($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "thành công",
        ]);
    }

    public function missed_call_investor(Request $request)
    {

        Log::info('missed_call_investor request  : ' . print_r($request->all(), true));
        $result = $this->leadInvestor_service->missed_call($request);
        Log::info('missed_call_investor result: ' . print_r($result, true));
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "thành công",
            'data' => $result
        ]);
    }

    public function total_excel_call_lead(Request $request)
    {

        $filter = $request->only('fdate', 'tdate');
        $list = $this->leadInvestor_model->total_excel_call_lead($filter);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $list
        ]);
    }

    public function excel_call_lead_v2(Request $request)
    {
        $filter = $request->only('fdate', 'tdate');
        $list = $this->leadInvestor_model->excel_call_lead_v2($filter);
//        foreach ($list as $value) {
//            if (!empty($value->assign_call)) {
//                $value->user_call = $this->user_model->find($value->assign_call);
//            }
//        }
        $data_roles = [];
        $roles = $this->roleService->get_user_role();
        if ($roles) {
            foreach ($roles as $role) {
                array_push($data_roles, $role->slug);
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $list,
            'role' => $data_roles,
        ]);
    }

    public function vbeeImport()
    {
        $result = $this->leadInvestor_service->import_vbee();
        if (!empty($result) && $result == 1) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => "import thành công",
                'data' => $result
            ]);
        } else {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "import thất bại",
                'data' => $result
            ]);
        }
    }

    public function webhookVbeeNdt(Request $request)
    {
        $result = $this->leadInvestor_service->webhook_vbee_ndt($request);
        if (!empty($result) && $result == 1) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => "thành công",
                'data' => $result
            ]);
        }else{
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "thất bại",
                'data' => $result
            ]);
        }
    }



}
