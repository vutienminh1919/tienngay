<?php

namespace App\Http\Controllers;


use App\Models\Call;

use App\Models\Contract;
use App\Models\Investor;
use App\Models\LogCall;
use App\Models\LogChangeLead;
use App\Models\LogInvestor;
use App\Models\User;
use App\Repository\CallRepositoryInterface;
use App\Repository\ConfigCallRepositoryInterface;
use App\Repository\ContractRepository;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LogCallRepositoryInterface;
use App\Repository\LogChangeLeadRepositoryInterface;
use App\Repository\LogInvestorRepositoryInterface;
use App\Repository\PayRepository;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\InvestorService;
use App\Service\LogCallService;
use App\Service\LogInvestorService;
use App\Service\NotificationService;
use App\Service\RoleService;
use App\Service\Vimo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Service\Investor\NewInvestor;

class InvestorController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        NotificationService $notificationService,
        LogInvestorRepositoryInterface $logInvest,
        CallRepositoryInterface $call,
        LogCallRepositoryInterface $logCall,
        LogCallService $logCallService,
        LogInvestorService $logInvestorService,
        InvestorService $investorService,
        RoleRepositoryInterface $role,
        ConfigCallRepositoryInterface $configCallRepository,
        RoleService $roleService,
        LogChangeLeadRepositoryInterface $log_change_lead,
        ContractRepository $contractRepository,
        PayRepository $payRepository
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->logInvest_model = $logInvest;
        $this->notificationService = $notificationService;
        $this->call_model = $call;
        $this->log_call_service = $logCallService;
        $this->log_investor_service = $logInvestorService;
        $this->investor_service = $investorService;
        $this->logCall_model = $logCall;
        $this->role_model = $role;
        $this->configCallRepository = $configCallRepository;
        $this->roleService = $roleService;
        $this->log_change_lead_model = $log_change_lead;
        $this->contractRepository = $contractRepository;
        $this->payRepository = $payRepository;

    }

    public function create_investor(Request $request)
    {
        $data = [
            Investor::COLUMN_CODE => $request->phone,
            Investor::COLUMN_NAME => $request->name,
            Investor::COLUMN_PHONE_NUMBER => $request->phone,
            Investor::COLUMN_STATUS => Investor::STATUS_NEW,
            Investor::COLUMN_EMAIL => $request->email,
            Investor::COLUMN_CREATED_BY => $request->created_by,
            Investor::COLUMN_USER_ID => $request->user_id,
        ];
        $this->investor_model->create($data);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function update_link_vimo(Request $request)
    {
        $data = [
            Investor::COLUMN_PHONE_VIMO => $request->phone,
            Investor::COLUMN_LINKED_ID_VIMO => $request->link_id,
        ];
        $this->investor_model->update($request->id, $data);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function active_link_vimo(Request $request)
    {
        $data = [
            Investor::COLUMN_TOKEN_ID_VIMO => $request->token_vimo,
        ];
        $this->investor_model->update($request->id, $data);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function unlink_vimo(Request $request)
    {
        $data = [
            Investor::COLUMN_TOKEN_ID_VIMO => null,
            Investor::COLUMN_LINKED_ID_VIMO => null,
            Investor::COLUMN_PHONE_VIMO => null
        ];
        $this->investor_model->update($request->id, $data);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function getListNew(Request $request)
    {

        $filter = $request->only('name', 'email', 'phone', 'status', 'status_call', 'find_call_assign', 'start_date', 'end_date', 'note_delete');
        $role = $this->roleService->get_user_role();
        foreach ($role as $item) {
            if ($item->slug == 'telesales') {
                if ($item->pivot->position == 1) {
                    $filter['assign_call'] = current_user()->id;
                }
            }
        }
        $per_page = $request->get('per_page');
        $list = $this->investor_model->getListNewPaginate($filter, $per_page);
        foreach ($list as $value) {
            $value->call = $value->call;
            if ($value->call) {
                $value->log_call = $this->logCall_model->findOneSortColumn([LogCall::COLUMN_CALL_ID => $value->call->id], LogCall::CREATED_AT, 'DESC');
            }
            $value->user = $value->user;
            if (isset($value->assign_call)) {
                $user_call = $this->user_model->find($value->assign_call);
                $value->user_call = $user_call->email;
                $value->id_user_call = $user_call->id;
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $list
        ]);
    }

    public function comfirmNew(Request $request, NewInvestor $newInvestor)
    {
        $data = explode(',', $request->get('investor_list', ''));
        $result = $newInvestor->confirm($data);
        if ($result) {
            $devices = [];
            foreach ($data as $value) {
                $investor = $this->investor_model->find($value);
                $user = $investor->user;
                $this->notificationService->push_notification_active_investor($request, $user);
            }
            $this->logInvest_model->create([
                LogInvestor::COLUMN_REQUEST => json_encode($request->all()),
                LogInvestor::COLUMN_RESPONSE => json_encode($result),
                LogInvestor::COLUMN_CREATED_BY => current_user()->email,
                LogInvestor::COLUMN_URL => $request->url()
            ]);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công'
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Error'
        ]);
    }

    public function blockNew(Request $request, NewInvestor $newInvestor)
    {
        $data = explode(',', $request->get('investor_list', ''));
        $result = $newInvestor->block($data);
        if ($result) {
            $this->logInvest_model->create([
                LogInvestor::COLUMN_REQUEST => json_encode($request->all()),
                LogInvestor::COLUMN_RESPONSE => json_encode($result),
                LogInvestor::COLUMN_CREATED_BY => current_user()->email,
                LogInvestor::COLUMN_URL => $request->url()
            ]);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công'
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Error'
        ]);
    }

    public function upload_accuracy_app(Request $request)
    {
        $user = $this->investor_model->find_identity($request->identity);
        if (!empty($user)) {
            return response()->json([
                'status' => Controller::HTTP_UNAUTHORIZED,
                'message' => 'Chứng minh thư đã tồn tại'
            ]);
        }
        $data = [
            Investor::COLUMN_FRONT_CARD => $request->front_facing_card,
            Investor::COLUMN_CARD_BACK => $request->card_back,
            Investor::COLUMN_AVATAR => $request->avatar,
            Investor::COLUMN_IDENTITY => $request->identity,
        ];
        $this->investor_model->update($request->id, $data);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thanh cong']);
    }

    public function detailNew(Request $request)
    {
        $investor = $this->investor_model->findConfirmNew($request->id);
        if ($investor) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công',
                'data' => $investor
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Error'
        ]);
    }

    public function updateNew(Request $request)
    {
        $investor = $this->investor_model->findConfirmNew($request->id);
        if ($investor) {
            $data = $this->investor_model->update($request->id, [
                'name' => $request->get('name'),
                'email' => $request->get('email')
            ]);
            $this->logInvest_model->create([
                LogInvestor::COLUMN_REQUEST => json_encode($request->all()),
                LogInvestor::COLUMN_RESPONSE => json_encode($data),
                LogInvestor::COLUMN_CREATED_BY => current_user()->email,
                LogInvestor::COLUMN_URL => $request->url()
            ]);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'data' => $data
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'data' => 'Dữ liệu không tồn tại'
        ]);
    }

    /**
     * @OA\Post(path="/investor/list",
     *   tags={"investor"},
     *   summary="Danh sách investor",
     *
     *   @OA\Parameter(in="query", name="page"),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(property="email",type="string"),
     *          @OA\Property(property="phone",type="string"),
     *          @OA\Property(property="status",type="string"),
     *        )
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function list(Request $request)
    {
        $filter = $request->only('email', 'phone', 'name', 'status_call', 'investment_status', 'find_call_assign', 'note_delete');
        $role = $this->roleService->get_user_role();
        foreach ($role as $item) {
            if ($item->slug == 'telesales') {
                if ($item->pivot->position == 1) {
                    $filter['assign_call'] = current_user()->id;
                }
            }
        }
        $list = $this->investor_model->getListPaginate($filter);
        foreach ($list as $value) {
            $value->call = $value->call()->first();
            $value->user = $value->user()->first();
            $value->contract = $value->contracts()->first();
            if (isset($value->assign_call)) {
                $user = $this->user_model->find($value->assign_call);
                $value->user_call = $user->email;
                $value->id_user_call = $user->id;
            }
            $value->so_du_vi = 0;
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $list);
    }

    /**
     * @OA\Post(path="/investor/detail/{id}",
     *   tags={"investor"},
     *   summary="Chi tiết investor",
     *   @OA\Parameter(in="path", name="id"),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function detail(Request $request)
    {
        $investor = $this->investor_model->findInvestor($request->id);
        if ($investor) {
            $investor['constract'] = $investor->contracts()->get();
            $investor->type = $investor->user->type;
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công',
                'data' => $investor
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Error'
        ]);
    }

    public function test(Request $request)
    {
        $investor = $this->investor_model->find($request->id);
        $user = $investor->user;
        $device_token = $investor->user->device->device_token;
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $user
        ]);
    }

    public function list_ndt_uy_quyen(Request $request)
    {
        $filter = $request->only('email', 'phone', 'name');
        $list = $this->investor_model->getListNdtUyQuyenPaginate($filter);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $list);
    }

    public function update_invester_active(Request $request)
    {
        $investor = $this->investor_model->find($request->id);
        $update = [
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ];

        $data = $this->investor_model->update($request->id, $update);
        $user = $this->user_model->findOne(['id' => $investor->user_id]);
        $this->user_model->update($user->id, ['email' => $request->email, 'full_name' => $request->name]);
        $this->log_investor_service->create_log($request->all(), $data);

        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function excel_list(Request $request, Vimo $vimo)
    {
        $list = $this->investor_model->getALlActive();
        foreach ($list as $value) {
            $value->call = $value->call;
            $value->contract = $value->contracts()->count();
            if ($value->contract > 0) {
                $value->total_monney = $value->contracts()->sum(Contract::COLUMN_AMOUNT_MONEY);
            }
            if (!empty($value->assign_call)) {
                $value->user_call = $this->user_model->find($value->assign_call);
            }
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $list);
    }


    public function call_update_investor(Request $request)
    {
        $validate = $this->investor_service->validate_call_update($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                "message" => $validate->errors()->first(),
            ]);
        }
        $investor_email = $this->investor_model->findOne(['email' => $request->email]);
        if ($investor_email) {
            if ($request->id != $investor_email->id) {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    "message" => "Email đã tồn tại",
                ]);
            }
        }
        if (isset($request->identity)) {
            if (strlen($request->identity) < 9 || strlen($request->identity) > 12) {
                return response()->json([
                    'status' => Controller::HTTP_BAD_REQUEST,
                    "message" => "CMT từ 9 đến 12 số",
                ]);
            }
            $investor_cmt = $this->investor_model->findOne(['identity' => $request->identity]);
            if ($investor_cmt) {
                if ($request->id != $investor_cmt->id) {
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
        $data = $this->investor_service->call_update_investor($request);
        $investor = $this->investor_model->find($request->id);
        $this->user_model->update($investor->user_id, ['full_name' => $request->name, 'email' => $request->email]);
        $this->log_investor_service->create_log($request->all(), $data);
        $this->log_call_service->add_log_call($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            "message" => "Cập nhật thành công",
        ]);
    }

    public function call_detail(Request $request)
    {
        $investor = $this->investor_model->find($request->id);
        $investor->call = $investor->call;
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $investor);
    }

    public function excel_call(Request $request, Vimo $vimo)
    {

        $filter = $request->only('fdate', 'tdate');
        $list = $this->investor_model->getAllListNew($filter);
        foreach ($list as $value) {
//            $value->call = $this->call_model->findOne([Call::COLUMN_INVESTOR_ID => $value->id]);
            $value->call = $value->call()->first();
            $value->user = $this->user_model->find($value->user_id);
            if (!empty($value->assign_call)) {
                $value->user_call = $this->user_model->find($value->assign_call);
            }
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $list);
    }

    public function history_call(Request $request)
    {
        $investor = $this->investor_model->find($request->id);
        $investor->call = $investor->call;
        if (isset($investor->call)) {
            $investor->log = $this->logCall_model->findManySortColumn(
                [LogCall::COLUMN_CALL_ID => $investor->call->id],
                LogCall::COLUMN_CREATED_AT,
                'DESC');
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $investor);
    }

    public function assign_call_old(Request $request)
    {
        $investors = $this->investor_model->get_investor_different_active();
        foreach ($investors as $investor) {
            $this->investor_model->update($investor->id, [Investor::COLUMN_ASSIGN_CALL => $request->id]);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            "message" => "thành công",
        ]);
    }

    public function update_payment_interest()
    {
        $this->investor_service->update_payment_interest();
        return response()->json([
            'status' => Controller::HTTP_OK,
            "message" => "thành công",
        ]);
    }

    public function test_investment_status(Request $request)
    {
        $investors = $this->investor_model->get_investor_active();
        foreach ($investors as $investor) {
            $contract = $investor->contracts()->first();
            if (isset($contract)) {
                $this->investor_model->update($investor->id, [Investor::COLUMN_INVESTMENT_STATUS => Investor::DA_DAU_TU]);
            } else {
                $this->investor_model->update($investor->id, [Investor::COLUMN_INVESTMENT_STATUS => Investor::CHUA_DAU_TU]);
            }
        }
        return;
    }

    public function assign_call_investor_active(Request $request)
    {
        $investors = $this->investor_model->assign_call_investor_active();
        foreach ($investors as $investor) {
            if (empty($investor->assgin_call)) {
                $this->investor_model->update($investor->id, [Investor::COLUMN_ASSIGN_CALL => $request->id]);
            }
        }
        return;
    }

    public function test_auto(Request $request)
    {
        $investors = $this->investor_model->get_investor_no_process();
        echo "<pre>";
        print_r($investors);
        echo "</pre>";
    }

    public function change_call(Request $request)
    {
        if (!isset($request->user_call_id)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                "message" => "User không được trống",
            ]);
        }
        $lead = $this->investor_model->find($request->id_lead);
        if ($lead->assign_call == $request->user_call_id) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                "message" => "User đã được gán",
            ]);
        }
        $lead_new = $this->investor_model->update($lead->id, [Investor::COLUMN_ASSIGN_CALL => $request->user_call_id, Investor::COLUMN_TIME_ASSIGN_CALL => Carbon::now()]);
        $this->log_change_lead_model->create(
            [
                LogChangeLead::COLUMN_TYPE => 'investor',
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

    public function get_investor_send_mkt()
    {
        $data = $this->investor_model->get_investor_send_mkt();
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function getCountListNew(Request $request)
    {

        $filter = $request->only('email', 'phone', 'status', 'status_call', 'find_call_assign', 'start_date', 'end_date');
        $role = $this->roleService->get_user_role();
        foreach ($role as $item) {
            if ($item->slug == 'telesales') {
                if ($item->pivot->position == 1) {
                    $filter['assign_call'] = current_user()->id;
                }
            }
        }
        $count = $this->investor_model->getCountListNewPaginate($filter);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $count);
    }

    public function test_excel(Request $request)
    {
        $filter = $request->only('fdate', 'tdate');
        $list = $this->investor_model->excel_getAllListNew($filter);
        foreach ($list as $value) {
//            $value->call = $this->call_model->find_one(Call::COLUMN_INVESTOR_ID, $value->id);
            $value->user = $this->user_model->find($value->user_id);
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

    public function get_call(Request $request)
    {
        $data = $this->call_model->findOne([Call::COLUMN_INVESTOR_ID => $request->id]);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function getReportProductivityDl(Request $request)
    {
        $filter = $request->only('start_date', 'end_date', 'find_call_assign');
        $role = $this->roleService->get_user_role();
        foreach ($role as $item) {
            if ($item->slug == 'telesales') {
                if ($item->pivot->position == 3) {
                    $filter['is_tbp_tls'] = true;
                } else {
                    $filter['is_tbp_tls'] = false;
                }
            } elseif ($item->slug == 'van-hanh') {
                $filter['is_tbp_tls'] = true;
            } else {
                $filter['is_tbp_tls'] = false;
            }
        }
        if (current_user()->is_admin == 1) {
            $filter['is_tbp_tls'] = true;
        }
        $data = $this->investor_service->getReportProductivityService($filter);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function block_user_assign_call(Request $request)
    {
        $investor = $this->investor_model->findOne([Investor::COLUMN_PHONE_NUMBER => $request->phone]);
        if ($investor) {
            $this->investor_model->update($investor['id'], [Investor::COLUMN_ASSIGN_CALL => 75]);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
        ]);

    }

    public function total_excel_call(Request $request, Vimo $vimo)
    {

        $filter = $request->only('fdate', 'tdate');
        $list = $this->investor_model->total_excel_call($filter);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $list);
    }

    public function excel_call_v2(Request $request, Vimo $vimo)
    {
        $filter = $request->only('fdate', 'tdate');
        $list = $this->investor_model->excel_call_v2($filter);
        $data_roles = [];
        $roles = $this->roleService->get_user_role();
        foreach ($roles as $role) {
            array_push($data_roles, $role->slug);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $list,
            'role' => $data_roles,
        ]);
    }

    public function excel_list_v2(Request $request, Vimo $vimo)
    {
        $list = $this->investor_model->getALlActive_v2();
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $list);
    }

    public function identification(Request $request)
    {
        $data = [];
        if (!empty($request->id)) {
            $arr_id = explode(',', str_replace(array('"', "'"), '', $request->id));
            $investors = $this->investor_model->identification($arr_id);
            foreach ($investors as $key => $investor) {
                $data[$key] = [
                    'id' => $investor['id'] ?? "",
                    'name' => $investor['name'] ?? "",
                    'phone_number' => $investor['phone_number'] ?? "",
                    'created_at' => Carbon::parse($investor['created_at'])->format('d-m-Y H:i:s'),
                    'avatar' => $investor['avatar'] ?? "",
                    'status' => $investor['status']
                ];
            }
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function list_v2(Request $request)
    {
        $filter = $request->only('email', 'phone', 'name', 'status_call', 'investment_status', 'find_call_assign', 'note_delete', 'tab', 'time_care');
        $role = $this->roleService->get_user_role();
        foreach ($role as $item) {
            if ($item->slug == 'telesales') {
                if ($item->pivot->position == 1) {
                    $filter['assign_call'] = current_user()->id;
                }
            }
        }
        $list = $this->investor_model->list_v2($filter);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $list);
    }
}
