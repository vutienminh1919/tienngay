<?php


namespace App\Http\Controllers;


use App\Models\Contract;
use App\Models\DraftNl;
use App\Models\Investor;
use App\Models\Pay;
use App\Models\Transaction;
use App\Repository\ContractRepositoryInterface;
use App\Repository\DraftNlRepository;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\KpiRepositoryInterface;
use App\Repository\PayRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\LogNlService;
use App\Service\NganLuongPayOut;
use App\Service\RoleService;
use App\Service\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        ContractRepositoryInterface $contract,
        TransactionRepositoryInterface $transaction,
        TransactionService $transactionService,
        PayRepositoryInterface $pay,
        DraftNlRepository $draftNl,
        NganLuongPayOut $nganLuongPayOut,
        LogNlService $logNlService,
        RoleService $roleService,
        KpiRepositoryInterface $kpiRepository
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->contract_model = $contract;
        $this->transaction_model = $transaction;
        $this->transactionService = $transactionService;
        $this->pay_model = $pay;
        $this->draft_model = $draftNl;
        $this->nganLuongPayOut = $nganLuongPayOut;
        $this->logNlService = $logNlService;
        $this->roleService = $roleService;
        $this->kpi_model = $kpiRepository;
    }

    public function create_transaction_investor_contract(Request $request)
    {
        $this->transactionService->create_transaction_investor($request);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function history_transaction_investor(Request $request)
    {
        $condition = $request->only('id', 'start', 'end', 'option');
        $transactions = $this->transaction_model->history_transaction_investor($condition, $request->limit, $request->offset);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $transactions);
    }

    public function money_payment(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'order_code', 'investor_code', 'type_contract');
        $transactions = $this->transaction_model->money_payment($condition);
        foreach ($transactions as $transaction) {
            $transaction->pay = $transaction->pay;
            $transaction->investor = $transaction->contract->investor;
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $transactions);
    }

    public function count_all_time(Request $request)
    {
        $condition = $request->only('type_contract');
        $data = $this->transaction_model->sum_tra_lai($condition);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function count_month(Request $request)
    {
        $condition = $request->only('type_contract');
        $data = $this->transaction_model->sum_tra_lai($condition, date('Y-m-01 00:00:00'));
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function import_transaction_pay_ndt_uy_quyen(Request $request)
    {
        $contract = $this->contract_model->findCode($request->code_contract);
        if (!$contract) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                "message" => "Không tìm thấy hợp đồng",
                'data' => $request->key
            ]);
        }

        $validate = $this->transactionService->validate_transaction_pay_ndt_uy_quyen($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                "message" => $validate->errors()->first(),
                'data' => $request->key
            ]);
        } else {
            $this->transactionService->create_transaction_pay_ndt_uy_quyen($request);
            return response()->json([
                'status' => Controller::HTTP_OK,
                "message" => 'success',
            ]);
        }
    }

    public function overview_transaction_proceeds(Request $request)
    {
        $condition = $request->only('type_contract');
        $overView = $this->transactionService->overView($condition);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $overView);
    }

    public function money_payment_all(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'code_contract', 'investor_code', 'type_contract');
        $transactions = $this->transaction_model->money_payment_all($condition);
        foreach ($transactions as $transaction) {
            $transaction->contract = $transaction->contract()->with('investor')->first();
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $transaction);
    }

    public function get_transaction_nl_warning()
    {
        $transaction = $this->transaction_model->findMany([
            Transaction::COLUMN_TYPE => Transaction::DAU_TU,
            Transaction::COLUMN_STATUS => Transaction::STATUS_WARNING,
            Transaction::COLUMN_PAYMENT_SOURCE => Transaction::PAYMENT_SOURCE_NGAN_LUONG,
        ]);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $transaction);
    }

    public function get_bill_nl_warning()
    {
        $bills = $this->draft_model->findMany([DraftNl::COLUMN_STATUS => DraftNl::NEW]);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $bills);
    }

    public function money_management_v2(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'order_code', 'full_name', 'type_contract', 'excel');
        $transactions = $this->transaction_model->get_proceeds_v2($condition);
        $data_roles = [];
        $roles = $this->roleService->get_user_role();
        foreach ($roles as $role) {
            array_push($data_roles, $role->slug);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $transactions,
            'role' => $data_roles,
            'message' => "Success"
        ], Controller::HTTP_OK);
    }

    public function chart_invest(Request $request)
    {
        $data = [];
        $month = date('n');
        for ($i = 1; $i <= $month; $i++) {
            $data['month'][$i] = 'Tháng ' . $i;
            $total_money = $this->transaction_model->total_money_invest_by_month($i);
            $data['invest'][$i] = (int)$total_money->investment_amount;
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function dashboard_ndt(Request $request)
    {
        $from_date = !empty($request['from_date']) ? $request['from_date'] . ' 00:00:00' : date('Y-m-d 00:00:00', time());
        $to_date = !empty($request['to_date']) ? $request['to_date'] . ' 23:59:59' : date('Y-m-d 23:59:59', time());
        $current_month = date('m', strtotime($to_date));
        $current_year = date('Y', strtotime($to_date));
        $dashboard_data = array();
        if (strtotime($from_date) > strtotime($to_date)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => 'Thời gian tìm kiếm không hợp lệ!'
            ], Controller::HTTP_OK);
        }
        $condition = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];
        $condition_kpi = [
            'month' => $current_month,
            'year' => $current_year
        ];
        $total_money_invest = $this->transaction_model->total_investment_by_time($condition);
        $total_investor_new_active = $this->investor_model->total_investor_activate_new_dash($condition);
        $total_investor_activated_invested = $this->investor_model->total_investor_activated_invested($condition);
        $total_investor_activated_not_invested_yet = $this->investor_model->total_investor_activated_not_invested_yet($condition);
        $kpi_by_time = $this->kpi_model->findExistsKpi($condition_kpi);
        $kpi_target_month = $kpi_by_time['invest_target'] ?? 0;
        //percentage
        $percentage_investor_activated_invested = $total_investor_new_active != 0 ? round(($total_investor_activated_invested / $total_investor_new_active) * 100, 2) : 0;
        $percentage_investor_activated_not_invested_yet = $total_investor_new_active != 0 ? round(($total_investor_activated_not_invested_yet / $total_investor_new_active) * 100, 2) : 0;
        $percentate_kpis_month_completed = $kpi_target_month != 0 ? round(($total_money_invest / $kpi_target_month) * 100, 2) : 0;
        $dashboard_data = [
            'total_money_invest' => $total_money_invest,
            'total_investor_new_active' => $total_investor_new_active,
            'total_investor_activated_invested' => $total_investor_activated_invested,
            'percentage_invested' => $percentage_investor_activated_invested,
            'total_investor_activated_not_invested_yet' => $total_investor_activated_not_invested_yet,
            'percentage_not_invested_yet' => $percentage_investor_activated_not_invested_yet,
            'kpi_target_month' => $kpi_target_month,
            'percentage_kpi_completed' => $percentate_kpis_month_completed
        ];
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $dashboard_data);
    }

    public function chart_invest_by_day_on_month(Request $request)
    {
        $data = [];
        $date = date('d');
        if ($date < 5) {
            $first_date = Carbon::now()->subDays(5)->format('Y-m-d');
        } else {
            $first_date = Carbon::now()->firstOfMonth()->format('Y-m-d');
        }
        $now = Carbon::now()->format('Y-m-d');
        $datediff = floor((strtotime($now) - strtotime($first_date)) / (60 * 60 * 24));
        for ($i = 0; $i <= $datediff; $i++) {
            $date = Carbon::now()->subDays($datediff - $i)->format('Y-m-d');
            $data['date'][$i] = date('d/m', strtotime($date));
            $total_money = $this->transaction_model->total_money_invest_by_day_on_month($date);
            $data['invest'][$i] = (int)$total_money->investment_amount;
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function chart_payment_by_day_on_month(Request $request)
    {
        $data = [];
        $date = date('d');
        if ($date < 5) {
            $first_date = Carbon::now()->subDays(5)->format('Y-m-d');
        } else {
            $first_date = Carbon::now()->firstOfMonth()->format('Y-m-d');
        }
        $now = Carbon::now()->format('Y-m-d');
        $datediff = floor((strtotime($now) - strtotime($first_date)) / (60 * 60 * 24));
        for ($i = 0; $i <= $datediff; $i++) {
            $date = Carbon::now()->subDays($datediff - $i)->format('Y-m-d');
            $data['date'][$i] = date('d/m', strtotime($date));
            $total_money = $this->transaction_model->total_money_payment_by_day_on_month($date);

            $data['tien_goc'][$i] = (int)$total_money->tien_goc;
            $data['tien_lai'][$i] = (int)$total_money->tien_lai;
            $data['tong_goc_lai'][$i] = (int)$total_money->tong_goc_lai;
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function chart_payment(Request $request)
    {
        $data = [];
        $month = date('n');
        for ($i = 1; $i <= $month; $i++) {
            $data['month'][$i] = 'Tháng ' . $i;
            $total_money = $this->transaction_model->total_money_payment_by_month($i);
            $data['tien_goc'][$i] = (int)$total_money->tien_goc;
            $data['tien_lai'][$i] = (int)$total_money->tien_lai;
            $data['tong_goc_lai'][$i] = (int)$total_money->tong_goc_lai;
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $data);
    }

    public function payment_nl(Request $request)
    {
        if (empty($request->phone_number) && empty($request->amount_money)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Không hợp lệ"
            ], Controller::HTTP_OK);
        }
        $investor = Investor::where('phone_number', $request->phone_number)->first();
        if (!$investor) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Số điện thoại không hợp lệ"
            ], Controller::HTTP_OK);
        }

        $contracts = Contract::where('investor_id', $investor['id'])
            ->where('status', 'success')
            ->get();
        if (empty($contracts)) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => "Không có hd để thanh toán"
            ], Controller::HTTP_OK);
        }

        $ref_code = 'TN_' . date('Ymd') . '_' . uniqid();
        $data = [
            'account_type' => 3,
            'card_fullname' => $request->name_bank_account,
            'card_number' => $request->interest_receiving_account,
            'bank_code' => $request->bank_name,
            'ref_code' => $ref_code,
            'total_amount' => $request->amount_money,
            'card_month' => '',
            'card_year' => '',
            'branch_name' => '',
            'reason' => 'VFC hoan tien trai nghiem APP NDT - ' . $request->name_bank_account
        ];

        $result = $this->nganLuongPayOut->web_SetCashoutRequest($data);
        foreach ($contracts as $contract) {
            $this->contract_model->update($contract['id'], [Contract::COLUMN_STATUS_CONTRACT => Contract::EXPIRE, Contract::COLUMN_STATUS => Contract::PENDING]);
            $pays = $this->pay_model->findMany([Pay::COLUMN_CONTRACT_ID => $contract['id']]);
            foreach ($pays as $pay) {
                $this->pay_model->update($pay['id'], [Pay::COLUMN_STATUS => Pay::HUY]);
            }
        }
        $this->logNlService->create_payout($data, $result, 'payment', $ref_code);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $result);
    }

    public function money_payment_v2(Request $request)
    {
        $condition = $request->only('fdate', 'tdate', 'order_code', 'investor_code', 'type_contract', 'code_contract', 'full_name', 'excel');
        $transactions = $this->transaction_model->money_payment_v2($condition);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS, $transactions);
    }
}
