<?php


namespace App\Service;


use App\Models\Device;
use App\Models\Investor;
use App\Models\Notification;
use App\Models\User;
use App\Repository\DeviceRepository;
use App\Repository\DeviceRepositoryInterface;
use App\Repository\NotificationRepository;
use App\Repository\NotificationRepositoryInterface;

class NotificationService extends BaseService
{
    protected $notificationRepository;
    protected $deviceRepository;
    protected $firebase;
    protected $logsService;

    public function __construct(NotificationRepositoryInterface $notificationRepository,
                                DeviceRepositoryInterface $deviceRepository,
                                Firebase $firebase,
                                LogsService $logsService)
    {
        $this->notificationRepository = $notificationRepository;
        $this->deviceRepository = $deviceRepository;
        $this->firebase = $firebase;
        $this->logsService = $logsService;
    }

    public function push_notification_paypal_investor($request, $user, $pay)
    {
        $account = '';
        if ($user->investor->type_interest_receiving_account == Investor::TYPE_PAYMENT_VIMO) {
            $account = 'ví liên kết';
        } else {
            $account = 'tài khoản nhận lãi';
        }
        $message = "💵 Qúy khách được thanh toán số tiền " . number_format(round($pay->goc_lai_1ky)) . ' VND' .
            " cho kì " . $pay->ky_tra . " gói đầu tư " . $pay->contract->code_contract_disbursement .
            '. Số tiền sẽ được chuyển về ' . $account . '.Qúy khách vui lòng kiểm tra sau ít phút nhận được thông báo này. Xin cảm ơn! 🎁';
        $data_notification = [
            Notification::COLUMN_ACTION => Notification::LOAI_THANH_TOAN,
            Notification::COLUMN_NOTE => !empty($request->note) ? $request->note : 'TienNgay.vn thanh toán nhà đầu tư',
            Notification::COLUMN_USER_ID => $user->id,
            Notification::COLUMN_STATUS => Notification::UNREAD, //1: new, 2 : read, 3: block,
            Notification::COLUMN_CODE_CONTRACT => $pay->code_contract,
            Notification::COLUMN_MESSAGE => $message,
            Notification::COLUMN_CREATED_BY => current_user()->email,
            Notification::COLUMN_LINK => "/contract/show?code=" . $pay->code_contract
        ];
        $this->notificationRepository->create($data_notification);

        $title = "Thông báo nhận lãi";
        $type = 'pay';
        try {
            $this->push_firebase($user, $message, $title, $type);
        } catch (\Exception $exception) {
            $this->logsService->create($user, $exception, 'NotificationService/push_notification_paypal_investor');
        }
    }

    public function create_notification($request)
    {
        $data = [
            Notification::COLUMN_USER_ID => $request->user_id,
            Notification::COLUMN_CODE_CONTRACT => $request->code_contract,
            Notification::COLUMN_ACTION => $request->action,
            Notification::COLUMN_STATUS => Notification::UNREAD,
            Notification::COLUMN_MESSAGE => $request->message,
            Notification::COLUMN_LINK => $request->link,
            Notification::COLUMN_NOTE => $request->note,
            Notification::COLUMN_CREATED_BY => $request->created_by,
        ];
        $this->notificationRepository->create($data);
    }

    public function push_notification_active_investor($request, $user)
    {
        $message = "🎉🎉 Tài khoản Nhà đầu tư của quý khách đã được xác thực thành công. Xin cảm ơn!";
        $data_notification = [
            Notification::COLUMN_ACTION => Notification::LOAI_XAC_THUC,
            Notification::COLUMN_USER_ID => $user->id,
            Notification::COLUMN_STATUS => Notification::UNREAD, //1: new, 2 : read, 3: block,
            Notification::COLUMN_MESSAGE => $message,
            Notification::COLUMN_NOTE => "Xác thực nhà đầu tư",
            Notification::COLUMN_CREATED_BY => current_user()->email,
        ];
        $this->notificationRepository->create($data_notification);

        $title = "Xác thực nhà đầu tư";
        $type = 'auth';
        try {
            $this->push_firebase($user, $message, $title, $type);
        } catch (\Exception $exception) {
            $this->logsService->create($user, $exception, 'NotificationService/push_notification_active_investor');
        }
    }

    public function push_notification_paypal_investor_auto($noti, $user, $pay)
    {
        if ($user->investor->type_interest_receiving_account == Investor::TYPE_PAYMENT_VIMO) {
            $account = 'ví liên kết';
        } else {
            $account = 'tài khoản nhận lãi';
        }
        $message = "💵 Qúy khách được thanh toán số tiền " . number_format_vn(round($pay->goc_lai_1ky)) . ' VND' .
            " cho kì " . $pay->ky_tra . " gói đầu tư " . $pay->contract->code_contract_disbursement .
            '. Số tiền sẽ được chuyển về ' . $account . '. Qúy khách vui lòng kiểm tra sau ít phút nhận được thông báo này. Xin cảm ơn';
        $data_notification = [
            Notification::COLUMN_ACTION => Notification::LOAI_THANH_TOAN,
            Notification::COLUMN_NOTE => $noti['note'],
            Notification::COLUMN_USER_ID => $user->id,
            Notification::COLUMN_STATUS => Notification::UNREAD, //1: new, 2 : read, 3: block,
            Notification::COLUMN_CODE_CONTRACT => $pay->code_contract,
            Notification::COLUMN_MESSAGE => $message,
            Notification::COLUMN_CREATED_BY => $noti['created_by'],
            Notification::COLUMN_LINK => "/contract/show?code=" . $pay->code_contract
        ];
        $this->notificationRepository->create($data_notification);

        $title = "Thông báo nhận lãi";
        $type = 'pay';
        try {
            $this->push_firebase($user, $message, $title, $type);
        } catch (\Exception $exception) {
            $this->logsService->create($user, $exception, 'NotificationService/push_notification_paypal_investor_auto');
        }
    }

    public function app_push_notification_investment($contract, $investor)
    {
        $code_contract = $contract['code_contract_disbursement'] ?? $contract['code_contract'];
        $message = '🎉🎉 Bạn đã thực hiện đầu tư cho hợp đồng ' . $code_contract . " với số tiền " . number_format_vn($contract->amount_money) . " VND." . " Cảm ơn Quý khách đã tin tưởng và sử dụng dịch vụ của Tienngay.vn!";
        $data_notification = [
            'action' => 'investor',
            'note' => "Đầu tư hợp đồng",
            'user_id' => $investor->user->id,
            'status' => 1, //1: new, 2 : read, 3: block,
            'code_contract' => $code_contract,
            'message' => $message,
            "created_by" => $investor['phone_number'],
            'link' => "/contract/show?code=" . $contract['code_contract']
        ];
        $this->notificationRepository->create($data_notification);

        $user = $investor->user;
        $title = "Thông báo đầu tư";
        $type = 'investor';
        try {
            $this->push_firebase($user, $message, $title, $type);
        } catch (\Exception $exception) {
            $this->logsService->create($user, $exception, 'NotificationService/app_push_notification_investment');
        }
    }

    public function push_notification_paypal_investor_replay($request, $user, $pay)
    {
        $account = '';
        if ($user->investor->type_interest_receiving_account == Investor::TYPE_PAYMENT_VIMO) {
            $account = 'ví liên kết';
        } else {
            $account = 'tài khoản nhận lãi';
        }
        $message = "💵 Qúy khách được thanh toán số tiền " . number_format(round($pay->goc_lai_1ky)) . ' VND' .
            " cho kì " . $pay->ky_tra . " gói đầu tư " . $pay->contract->code_contract_disbursement .
            '. Số tiền sẽ được chuyển về ' . $account . '.Qúy khách vui lòng kiểm tra sau ít phút nhận được thông báo này. Xin cảm ơn!';
        $data_notification = [
            Notification::COLUMN_ACTION => Notification::LOAI_THANH_TOAN,
            Notification::COLUMN_NOTE => !empty($request->note) ? $request->note : 'TienNgay.vn thanh toán nhà đầu tư',
            Notification::COLUMN_USER_ID => $user->id,
            Notification::COLUMN_STATUS => Notification::UNREAD, //1: new, 2 : read, 3: block,
            Notification::COLUMN_CODE_CONTRACT => $pay->code_contract,
            Notification::COLUMN_MESSAGE => $message,
            Notification::COLUMN_CREATED_BY => current_user()->email,
            Notification::COLUMN_LINK => "/contract/show?code=" . $pay->code_contract
        ];
        $this->notificationRepository->create($data_notification);
    }

    public function push_firebase($user, $msg, $title, $type)
    {
        try {
            $device = $this->deviceRepository->findMany([Device::COLUMN_USER_ID => $user->id]);
            if (!empty($device)) {
                $count_unread = $this->notificationRepository->count_unread($user->id);
                $to = [];
                $to = $device->pluck(Device::COLUMN_DEVICE_TOKEN);
                $this->firebase->setTitle($title);
                $this->firebase->setMessage($msg);
                $this->firebase->setBadge((int)$count_unread);
                $message = $this->firebase->getMessage();
                $this->firebase->setType($type);
                $data = $this->firebase->getData();
                $result = $this->firebase->sendMultiple($to, $message, $data);
            }
        } catch (\Exception $exception) {
            $this->logsService->create($user, $exception, 'NotificationService/push_firebase');
        }

    }
}
