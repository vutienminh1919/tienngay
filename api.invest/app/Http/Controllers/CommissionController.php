<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Repository\UserRepository;
use App\Service\CommissionService;
use App\Service\UserService;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    protected $commissionService;
    protected $userService;
    protected $userRepository;

    public function __construct(CommissionService $commissionService,
                                UserService $userService,
                                UserRepository $userRepository)
    {
        $this->commissionService = $commissionService;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function create(Request $request)
    {
        $this->commissionService->create($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS
        ]);
    }

    public function commission_investor(Request $request)
    {
        $user = $this->userService->find($request->id);
        if (!$user) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu"
            ], Controller::HTTP_OK);
        }

        $data = $this->userService->commission_investor($user, $request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $data
        ]);
    }

    public function get_all_commission(Request $request)
    {
        $data = $this->userService->get_all_commission($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $data
        ]);
    }

    public function detail_commission_investor(Request $request)
    {
        $user = $this->userService->find($request->id);
        if (!$user) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu"
            ], Controller::HTTP_OK);
        }

        $data = $this->userService->detail_commission_investor($user, $request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $data
        ]);
    }

    public function excel_all_commission(Request $request)
    {
        $data = $this->userService->excel_all_commission($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $data
        ]);
    }

    public function import_commission(Request $request)
    {
        $message = $this->userService->validate_import_commission($request);
        if (count($message) > 0) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                "message" => $message[0],
                'key' => $request->key
            ]);
        } else {
            $this->userService->import_commission($request);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'success'
            ]);
        }
    }

    public function commission_cvkd(Request $request)
    {
        $user = $this->userRepository->findOne([User::PHONE => $request->phone, User::STATUS => User::STATUS_ACTIVE]);
        if (!$user) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu"
            ], Controller::HTTP_OK);
        }

        $data = $this->userService->commission_investor($user, $request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $data
        ]);
    }

    public function commission_group_cvkd(Request $request)
    {
        $data = $this->userService->commission_group_cvkd($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $data
        ]);
    }
}
