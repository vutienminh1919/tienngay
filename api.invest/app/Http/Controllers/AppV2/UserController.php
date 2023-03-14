<?php


namespace App\Http\Controllers\AppV2;


use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use App\Repository\ActionRepositoryInterface;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\NotificationRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\InvestorService;
use App\Service\RateService;
use App\Service\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        RoleRepositoryInterface $role,
        UserService $userService,
        ActionRepositoryInterface $action,
        InvestorService $investorService,
        RateService $rateService,
        NotificationRepositoryInterface $notificationRepository,
        ContractRepositoryInterface $contractRepository
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->role_model = $role;
        $this->userService = $userService;
        $this->action_model = $action;
        $this->investorService = $investorService;
        $this->rateService = $rateService;
        $this->notificationRepository = $notificationRepository;
        $this->contractRepository = $contractRepository;

    }

    public function app_register(Request $request)
    {
        $validate = $this->userService->validate_app_register($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ], Controller::HTTP_OK);
        }

        $check = $this->userService->check_referral_code($request);
        if (count($check) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $check[0]
            ], Controller::HTTP_OK);
        }

        $result = $this->userService->app_register($request);
        if (isset($result['otp']->sendError) && $result['otp']->sendError == false) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_OK,
                Controller::MESSAGE => 'Mã xác thực sẽ được cung cấp thông qua cuộc gọi',
            ]);
        } else {
            $message = "Gửi OTP thất bại";
            if (!empty($result['message'])) {
                $message = $result['message'];
            } elseif (isset($result['otp']->sendErrorMsg)) {
                $message = $result['otp']->sendErrorMsg;
            }
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $message
            ]);
        }
    }

    public function block_account(Request $request)
    {
        $message = $this->userService->validate_block_account($request);
        if (count($message) > 0) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $message[0]
            ]);
        }
        $result = $this->userService->block_account($request);
        if (isset($result['otp']->sendError) && $result['otp']->sendError == false) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_OK,
                Controller::MESSAGE => 'Mã xác thực sẽ được cung cấp thông qua cuộc gọi',
                Controller::DATA => [
                    'checksum' => $result['checksum']
                ]
            ]);
        } else {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => isset($result['otp']->sendErrorMsg) ? $result['otp']->sendErrorMsg : 'Gửi OTP thất bại',
            ]);
        }
    }

    public function confirm_block_account(Request $request)
    {
        $message = $this->userService->validate_confirm_block_account($request);
        if (count($message) > 0) {
            return response()->json([
                Controller::STATUS => Controller::HTTP_BAD_REQUEST,
                Controller::MESSAGE => $message[0]
            ]);
        }
        $this->userService->confirm_block_account($request);
        return response()->json([
            Controller::STATUS => Controller::HTTP_OK,
            Controller::MESSAGE => Controller::SUCCESS
        ]);
    }

    public function get_notification_user(Request $request)
    {
        $user = $this->user_model->find($request->id);
//        if ($request->option == 1) {
//            $data = $this->notificationRepository->get_notification_promotion($request, $user);
//        } else {
        $data = $this->notificationRepository->get_notification_user($request, $user);
//        }
        foreach ($data as $noti) {
            $noti->title = !empty($noti->title) ? $noti->title : title_notification($noti->action);
            if (!empty($noti->code_contract)) {
                $contract = $this->contractRepository->find_contract($noti->code_contract);
                if (!empty($contract)) {
                    $noti->action_id = $contract->id;
                }
            }
        }
        return response()->json([
            Controller::STATUS => Controller::HTTP_OK,
            Controller::MESSAGE => Controller::SUCCESS,
            Controller::DATA => $data
        ]);
    }

    public function get_all_active()
    {
        $users = $this->user_model->get_all_active();
        return response()->json([
            Controller::STATUS => Controller::HTTP_OK,
            Controller::MESSAGE => Controller::SUCCESS,
            Controller::DATA => $users
        ]);
    }

    public function update_referral(Request $request)
    {
        $user = $this->user_model->update($request->id, [User::TYPE_REFERRAL => $request->type]);
        return response()->json([
            Controller::STATUS => Controller::HTTP_OK,
            Controller::MESSAGE => Controller::SUCCESS,
            Controller::DATA => $user
        ]);
    }
}
