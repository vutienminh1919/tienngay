<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Repository\ContractRepositoryInterface;
use App\Repository\DeviceRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\NotificationRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\NotificationService;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class NotificationController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        RoleRepositoryInterface $role,
        DeviceRepositoryInterface $device,
        NotificationRepositoryInterface $notification,
        NotificationService $notificationService,
        ContractRepositoryInterface $contract
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->role_model = $role;
        $this->device_model = $device;
        $this->notification_model = $notification;
        $this->notificationService = $notificationService;
        $this->contract_model = $contract;
    }

    public function get_notification_user(Request $request)
    {
        $notis = $this->notification_model->get_notification_user_app($request->id, $request->limit, $request->offset);
        foreach ($notis as $noti) {
            if (isset($noti->code_contract)) {
                $contract = $this->contract_model->findCode($noti->code_contract);
                if (isset($contract)) {
                    $noti->action_id = $contract->id;
                }
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $notis
        ]);
    }

    public function count_unread_noti_user(Request $request)
    {
        $total = $this->notification_model->count_unread($request->id);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $total
        ]);
    }

    public function update_read(Request $request)
    {
        $this->notification_model->update($request->id, [Notification::COLUMN_STATUS => Notification::READ]);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
        ]);
    }

    public function create_notification_app(Request $request)
    {
        $this->notificationService->create_notification($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
        ]);
    }

    public function get_paginate_notification_user(Request $request)
    {
        $noti = $this->notification_model->get_paginate_notification_user($request->id);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $noti
        ]);
    }

    public function read_all(Request $request)
    {
        $notis = $this->notification_model->find_foreignKey($request->id, 'user', 'user_id');
        foreach ($notis as $noti) {
            $this->notification_model->update($noti['id'], [Notification::COLUMN_STATUS => Notification::READ]);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
        ]);
    }

    public function popup()
    {
        $data = $this->notification_model->popup();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    public function read_all_app(Request $request)
    {
        if (!empty($request->user_id)) {
            Notification::where(Notification::COLUMN_USER_ID, $request->user_id)
                ->update([Notification::COLUMN_STATUS => Notification::READ]);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
        ]);
    }


}
