<?php


namespace App\Service;


use App\Models\Investor;
use App\Models\Notification;
use App\Repository\ContractRepository;
use App\Repository\ContractRepositoryInterface;
use App\Repository\InvestorRepository;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LeadBackLogRepositoryInterface;
use App\Repository\LeadBackLogRepository;
use App\Repository\NotificationRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class InvestorService extends BaseService
{
    protected $investorRepository;
    protected $contractRepository;
    protected $leadBackLogRepository;
    protected $roleService;
    protected $notificationRepository;
    protected $userRepository;
    protected $notificationService;

    /**
     * @var LeadBackLogRepository
     */


    public function __construct(InvestorRepositoryInterface $investorRepository,
                                LogInvestorService $logInvestorService,
                                ContractRepositoryInterface $contractRepository,
                                LeadBackLogRepository $leadBackLogRepository,
                                RoleService $roleService,
                                NotificationRepositoryInterface $notificationRepository,
                                NotificationService $notificationService,
                                UserRepositoryInterface $userRepository
    )
    {
        $this->investorRepository = $investorRepository;
        $this->logInvestorService = $logInvestorService;
        $this->contractRepository = $contractRepository;
        $this->leadBackLogRepository = $leadBackLogRepository;
        $this->roleService = $roleService;
        $this->notificationRepository = $notificationRepository;
        $this->userRepository = $userRepository;
        $this->notificationService = $notificationService;
    }

    public function create_investor_uy_quyen($request, $id)
    {
        $data = [
            Investor::COLUMN_CODE => $request->phone,
            Investor::COLUMN_PHONE_NUMBER => $request->phone,
            Investor::COLUMN_NAME => $request->full_name,
            Investor::COLUMN_IDENTITY => $request->cmt,
            Investor::COLUMN_STATUS => Investor::STATUS_ACTIVE,
            Investor::COLUMN_USER_ID => $id,
            Investor::COLUMN_ACTIVE_AT => date('Y-m-d H:i:s'),
            Investor::COLUMN_EMAIL => $request->email,
            Investor::COLUMN_CREATED_BY => current_user()->email
        ];
        $this->investorRepository->create($data);
    }

    public function call_update_investor($request)
    {
        $update = [
            Investor::COLUMN_EMAIL => $request->email,
            Investor::COLUMN_IDENTITY => $request->identity,
            Investor::COLUMN_NAME => $request->name,
            Investor::COLUMN_AVATAR => $request->avatar,
            Investor::COLUMN_FRONT_CARD => $request->front_facing_card,
            Investor::COLUMN_CARD_BACK => $request->card_back,
            Investor::COLUMN_BIRTHDAY => $request->birthday,
            Investor::COLUMN_CITY => $request->city,
            Investor::COLUMN_STATUS_CALL => $request->status,
            Investor::COLUMN_ADDRESS => $request->address,
            Investor::COLUMN_JOB => $request->job,
        ];
        $data = $this->investorRepository->update($request->id, $update);
        return $data;
    }


    public function validate_call_update($request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'email.required' => 'Email không để trống',
            'email.email' => 'Email không hợp lệ',
            'name.required' => 'Tên nhà đầu tư không để trống',
        ]);
        return $validate;
    }

    public function target_account_receiving_interest($request)
    {
        $message = [];
        if ($request->type == Investor::TYPE_PAYMENT_BANK) {
            $data = [
                Investor::COLUMN_TYPE_INTEREST_RECEIVING_ACCOUNT => $request->type,
                Investor::COLUMN_INTEREST_RECEIVING_ACCOUNT => $request->bank_account,
                Investor::COLUMN_BANK_NAME => $request->bank_name,
                Investor::COLUMN_NAME_BANK_ACCOUNT => $request->name_account,
                Investor::COLUMN_TYPE_CARD => $request->type_card,
            ];
        } else {
            $data = [
                Investor::COLUMN_TYPE_INTEREST_RECEIVING_ACCOUNT => $request->type,
            ];
        }
        $new = $this->investorRepository->update($request->id, $data);
        $this->logInvestorService->app_create_log($data, $new);
        return $new;
    }

    public function update_payment_interest()
    {
        $data = $this->investorRepository->get_list_null_type_interest_receving();
        foreach ($data as $datum) {
            $result = $this->investorRepository->update($datum['id'],
                [Investor::COLUMN_TYPE_INTEREST_RECEIVING_ACCOUNT => Investor::TYPE_PAYMENT_VIMO]
            );
            $this->logInvestorService->create_log($datum, $result);
        }
    }

    public function check_account_receiving_interest($request)
    {
        $message = [];
        $investor = $this->investorRepository->find($request->id);
        if (empty($request->type)) {
            $message[] = 'Loại thanh toán không để trống';
        }

        if ($request->type == Investor::TYPE_PAYMENT_BANK) {
            if (!empty($investor['type_interest_receiving_account']) && $investor['type_interest_receiving_account'] != Investor::TYPE_PAYMENT_BANK) {
                $current_time = strtotime(Carbon::now());
                $time_check = strtotime(date('Y-m-d 15:00:00'));
                if ($current_time <= $time_check) {
                    $message[] = 'Hệ thống đang trong quá trình thanh toán nhà đầu tư, bạn vui lòng cập nhật sau 15h. Xin cảm ơn';
                    return $message;
                }
            }

            if (!empty($investor['type_interest_receiving_account']) && $investor['type_interest_receiving_account'] == Investor::TYPE_PAYMENT_BANK) {
                $message[] = 'Bạn đã cập nhật thông tin nhận lãi rồi nên không thể cập nhật lại. Vui lòng liên hệ CSKH để hỗ trợ';
                return $message;
            }

            if (empty($request->bank_name)) {
                $message[] = 'Tên ngân hàng không để trống';
            }
            if (empty($request->type_card)) {
                $message[] = 'Loại tài khoản không để trống';
            }
            if (empty($request->bank_account)) {
                $message[] = 'Tài khoản ngân hàng không để trống';
            }
            if (empty($request->name_account)) {
                $message[] = 'Tên tài khoản ngân hàng không để trống';
            }

            if ($request->type_card == Investor::THE_ATM) {
                if (!in_array(strlen($request->bank_account), [16, 19])) {
                    $message[] = 'Số thẻ phải 16 số hoặc 19 số';
                }
            }
        } else {
            if (!isset($investor->token_id_vimo)) {
                $message[] = 'Bạn chưa có liên kết tài khoản vimo';
            }

            if (!empty($investor['type_interest_receiving_account']) && $investor['type_interest_receiving_account'] != Investor::TYPE_PAYMENT_VIMO) {
                $message[] = 'Bạn đã chọn hình thức nhận lãi rồi nên không thể chọn lại. Xin cảm ơn';
            }
        }
        return $message;
    }

    public function getReportProductivityService($request)
    {
        if (isset($request['start_date']) && isset($request['end_date'])) {
            $from_date = $request['start_date'];
            $to_date = $request['end_date'];
            $end_current_day = date('Y-m-d', strtotime($to_date)) . ' 00:00:00';
        } else {
            $from_date = date('Y-m-d') . ' 00:00:00';
            $to_date = date('Y-m-d') . ' 23:59:59';
            $end_current_day = date('Y-m-d', strtotime($to_date)) . ' 00:00:00';
        }
        if (isset($request['find_call_assign'])) {
            $telesales = $request['find_call_assign'];
        }
        $yesterday = strtotime('-1 day', strtotime($to_date));
        $date_yesterday = date('Y-m-d', $yesterday);
        $data_report = array();
        $array_id_telesales = [];
        $user_tls = $this->roleService->get_user_by_role('telesales');
        foreach ($user_tls as $tl) {
            array_push($array_id_telesales, $tl['id']);
        }
//        $array_id_telesales = $this->investorRepository->getIdTelesales();
        if (!empty($telesales)) {
            $array_id_telesales = array($telesales);
        } else {
            if (($request['is_tbp_tls']) == true) {
                $array_id_telesales = $array_id_telesales;
            } else {
                $array_id_telesales = array(current_user()->id);
            }
        }
        if (!empty($array_id_telesales)) {
            foreach ($array_id_telesales as $i => $id_tls) {
                $email_telesales = $this->investorRepository->getEmailTelesales($id_tls);
                $lead_new_in_day = $this->investorRepository->getLeadNewInDay($from_date, $to_date, $id_tls);
                $backlog_old_not_yet = $this->investorRepository->getLeadBackLogRealTime($from_date, $end_current_day, $id_tls);
                $lead_backlog_saved = $this->leadBackLogRepository->getLeadBackLogSaved($id_tls, $date_yesterday);
                $lead_processing_in_day = $this->investorRepository->getLeadInDayProcessed($from_date, $to_date, $id_tls);
                $lead_new_activated_in_day = $this->investorRepository->getLeadNewActiveInday($from_date, $to_date, $id_tls);
                $lead_new_activated_old = $this->investorRepository->getLeadNewActiveOld($end_current_day, $id_tls);
                $total_amount_invest = $this->contractRepository->getSumNdtByTelesales($id_tls, $from_date, $to_date);
                $data_report[$i]['id_tls'] = $id_tls;
                $data_report[$i]['email_tls'] = $email_telesales;
                $data_report[$i]['lead_new_in_day'] = $lead_new_in_day;
                $data_report[$i]['backlog_old_not_yet'] = $backlog_old_not_yet;
                $data_report[$i]['lead_backlog_saved'] = $lead_backlog_saved;
                $data_report[$i]['lead_processed_in_day'] = $lead_processing_in_day;
                $data_report[$i]['lead_new_activated_in_day'] = $lead_new_activated_in_day;
                $data_report[$i]['lead_new_activated_old'] = $lead_new_activated_old;
                $data_report[$i]['sum_amount_investment'] = $total_amount_invest;
            }
        }
        return $data_report;
    }

    public function push_notification_close_vimo()
    {
        $investors = $this->investorRepository->findMany([Investor::COLUMN_STATUS => Investor::STATUS_ACTIVE]);
        foreach ($investors as $key => $investor) {
            $user = $this->userRepository->find($investor['user_id']);
            $this->notificationService->push_notification_close_vimo($user);
        }
        return;

    }
}
