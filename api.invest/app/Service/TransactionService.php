<?php


namespace App\Service;


use App\Models\Contract;
use App\Models\Pay;
use App\Models\Transaction;
use App\Repository\ContractRepository;
use App\Repository\ContractRepositoryInterface;
use App\Repository\PayRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TransactionService extends BaseService
{
    protected $transactionRepository;
    protected $contractRepository;
    protected $payRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository,
                                ContractRepositoryInterface $contractRepository,
                                PayRepositoryInterface $payRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->contractRepository = $contractRepository;
        $this->payRepository = $payRepository;
    }

    public function create_paypal($request, $pay, $result)
    {
        $insertTransaction = [
            Transaction::COLUMN_TYPE => Transaction::TRA_LAI,
            Transaction::COLUMN_TYPE_METHOD => Transaction::FORM_HANDMADE,  //1 tu dong, 2 kt tra tay
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS,//1 thanh cong, 2 that bai
            Transaction::COLUMN_CODE_CONTRACT => $pay->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => round($pay->goc_lai_1ky),
            Transaction::COLUMN_TIEN_GOC => round($pay->tien_goc_1ky_phai_tra),
            Transaction::COLUMN_TIEN_LAI => round($pay->tien_lai_1ky_phai_tra),
            Transaction::COLUMN_INVESTOR_CODE => $pay->investor_code,
            Transaction::COLUMN_TRANSACTION_VIMO => $result['vimo_transaction_id'],
            Transaction::COLUMN_NOTE => $request->note,
            Transaction::COLUMN_CREATED_BY => $request->created_by,
            Transaction::COLUMN_CONTRACT_ID => $pay->contract->id,
            Transaction::COLUMN_TONG_GOC_LAI => round($pay->goc_lai_1ky),
            Transaction::COLUMN_PAY_ID => $request->id,
        ];
        $this->transactionRepository->create($insertTransaction);
    }

    public function create_transaction_investor($request)
    {
        $data = [
            Transaction::COLUMN_CONTRACT_ID => $request->contract_id,
            Transaction::COLUMN_TYPE => Transaction::DAU_TU,
            Transaction::COLUMN_CODE_CONTRACT => $request->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => $request->investment_amount,
            Transaction::COLUMN_INVESTOR_CODE => $request->investor_code,
            Transaction::COLUMN_TRANSACTION_VIMO => $request->transaction_vimo,
            Transaction::COLUMN_INTEREST => $request->interest,
            Transaction::COLUMN_CREATED_BY => $request->created_by,
            Transaction::COLUMN_PAYMENT_SOURCE => $request->source,
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS
        ];
        if (!empty($request->created_at)) {
            $data[Transaction::COLUMN_CREATED_AT] = $request->created_at;
        }
        $this->transactionRepository->create($data);
    }

    public function create_transaction_ndt_uy_quyen($request, $contract, $investor)
    {
        $interest = $request->interest / 12;
        $data = [
            Transaction::COLUMN_CONTRACT_ID => $contract->id,
            Transaction::COLUMN_TYPE => Transaction::DAU_TU,
            Transaction::COLUMN_CODE_CONTRACT => $contract->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => $request->amount_money,
            Transaction::COLUMN_INVESTOR_CODE => $investor->code,
            Transaction::COLUMN_INTEREST => json_encode(['interest' => $interest, 'interest_year' => $request->interest]),
            Transaction::COLUMN_CREATED_BY => current_user()->email,
            Transaction::COLUMN_CREATED_AT => $request->created_at,
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS
        ];
        return $this->transactionRepository->create($data);
    }

    public function create_transaction_pay_ndt_uy_quyen($request)
    {
        $contract = $this->contractRepository->findCode($request->code_contract);
        $data = [
            Transaction::COLUMN_TYPE => Transaction::TRA_LAI,
            Transaction::COLUMN_TYPE_METHOD => Transaction::FORM_HANDMADE,  //1 tu dong, 2 kt tra tay
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS,
            Transaction::COLUMN_CODE_CONTRACT => $request->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => $request->tien_goc + $request->tien_lai,
            Transaction::COLUMN_TIEN_GOC => $request->tien_goc,
            Transaction::COLUMN_TIEN_LAI => $request->tien_lai,
            Transaction::COLUMN_CREATED_BY => "superadmin@tienngay.vn",
            Transaction::COLUMN_CONTRACT_ID => $contract->id,
            Transaction::COLUMN_TONG_GOC_LAI => $request->tien_goc + $request->tien_lai,
            Transaction::COLUMN_INVESTOR_CODE => $contract->investor->code,
            Transaction::COLUMN_CREATED_AT => $request->created_at,

        ];
        return $this->transactionRepository->create($data);
    }

    public function validate_transaction_pay_ndt_uy_quyen($request)
    {
        $validate = Validator::make($request->all(), [
            Transaction::COLUMN_CODE_CONTRACT => 'required',
            Transaction::COLUMN_TIEN_GOC => 'required',
            Transaction::COLUMN_TIEN_LAI => 'required',
            Transaction::COLUMN_CREATED_AT => 'required',
        ]);
        return $validate;
    }

    public function transaction_pay_ndt_uy_quyen($contract, $pay, $date_pay)
    {
        $this->payRepository->update($pay->id, [Pay::COLUMN_STATUS => Pay::DA_THANH_TOAN]);
        $transaction = [
            Transaction::COLUMN_TYPE => Transaction::TRA_LAI,
            Transaction::COLUMN_TYPE_METHOD => Transaction::FORM_HANDMADE,  //1 tu dong, 2 kt tra tay
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS,//1 thanh cong, 2 that bai
            Transaction::COLUMN_CODE_CONTRACT => $pay->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => round($pay->goc_lai_1ky),
            Transaction::COLUMN_TIEN_GOC => round($pay->tien_goc_1ky_phai_tra),
            Transaction::COLUMN_TIEN_LAI => round($pay->tien_lai_1ky_phai_tra),
            Transaction::COLUMN_INVESTOR_CODE => $pay->investor_code,
            Transaction::COLUMN_NOTE => 'Trả lãi NDT ủy quyền',
            Transaction::COLUMN_CREATED_BY => current_user()->email,
            Transaction::COLUMN_CONTRACT_ID => $contract->id,
            Transaction::COLUMN_TONG_GOC_LAI => round($pay->goc_lai_1ky),
            Transaction::COLUMN_PAY_ID => $pay->id,
            Transaction::COLUMN_DATE_PAY => $date_pay,
        ];
        return $this->transactionRepository->create($transaction);
    }

    public function overView($condition)
    {
        $data = [];
        $data['tong_tien_thu_duoc'] = $this->transactionRepository->tong_tien_thu_duoc($condition);
        $data['tong_giao_dich'] = $this->transactionRepository->tong_giao_dich($condition);
        $data['tong_tien_thu_duoc_theo_thang'] = $this->transactionRepository->tong_tien_thu_duoc_theo_thang($condition);
        $data['tong_giao_dich_theo_thang'] = $this->transactionRepository->tong_giao_dich_theo_thang($condition);
        $data['tong_tien_thu_duoc_theo_ngay'] = $this->transactionRepository->tong_tien_thu_duoc_theo_ngay($condition);
        $data['tong_giao_dich_theo_ngay'] = $this->transactionRepository->tong_giao_dich_theo_ngay($condition);
        $data['tong_giao_dich_theo_nam'] = $this->transactionRepository->tong_giao_dich_theo_nam($condition);
        $data['tong_tien_thu_duoc_theo_nam'] = $this->transactionRepository->tong_tien_thu_duoc_theo_nam($condition);
        $month = date('m') - 1;
        if ($month <= 0) {
            $getMonthOld = 12;
            $getYearOld = date('Y') - 1;
        } else {
            $getMonthOld = $month;
            $getYearOld = date('Y');
        }
        $getDateMonth = get_created_at_with_year($getMonthOld, $getYearOld);
        $condition['start'] = $getDateMonth['start'];
        $condition['end'] = $getDateMonth['end'];
        $data['tong_tien_thu_duoc_theo_tung_thang'] = $this->transactionRepository->tong_tien_thu_duoc_theo_tung_thang($condition);
        return $data;
    }

    public function create_paypal_auto($data, $pay, $result)
    {
        $insertTransaction = [
            Transaction::COLUMN_TYPE => Transaction::TRA_LAI,
            Transaction::COLUMN_TYPE_METHOD => Transaction::FORM_AUTO,  //1 tu dong, 2 kt tra tay
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS,//1 thanh cong, 2 that bai
            Transaction::COLUMN_CODE_CONTRACT => $pay->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => round($pay->goc_lai_1ky),
            Transaction::COLUMN_TIEN_GOC => round($pay->tien_goc_1ky_phai_tra),
            Transaction::COLUMN_TIEN_LAI => round($pay->tien_lai_1ky_phai_tra),
            Transaction::COLUMN_INVESTOR_CODE => $pay->investor_code,
            Transaction::COLUMN_TRANSACTION_VIMO => $result['vimo_transaction_id'],
            Transaction::COLUMN_NOTE => $data['description'],
            Transaction::COLUMN_CREATED_BY => 'automatic system',
            Transaction::COLUMN_CONTRACT_ID => $pay->contract->id,
            Transaction::COLUMN_TONG_GOC_LAI => round($pay->goc_lai_1ky),
            Transaction::COLUMN_PAY_ID => $pay->id,
            Transaction::COLUMN_PAYMENT_SOURCE => Transaction::PAYMENT_SOURCE_VIMO
        ];
        $this->transactionRepository->create($insertTransaction);
    }

    public function app_create_transaction_v2($contract, $request)
    {
        $data = [
            Transaction::COLUMN_CONTRACT_ID => $contract->id,
            Transaction::COLUMN_TYPE => Transaction::DAU_TU,
            Transaction::COLUMN_CODE_CONTRACT => $contract->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => $contract->investment_amount,
            Transaction::COLUMN_INVESTOR_CODE => $contract->investor_code,
            Transaction::COLUMN_INTEREST => $contract->interest,
            Transaction::COLUMN_CREATED_BY => $contract->created_by,
            Transaction::COLUMN_PAYMENT_SOURCE => $request->source,
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS
        ];
        if ($request->source == Transaction::PAYMENT_SOURCE_VIMO) {
            $data[Transaction::COLUMN_TRANSACTION_VIMO] = $request->trading_code;
        } else {
            $data[Transaction::COLUMN_TRADING_CODE] = $request->trading_code;
        }
        if (!empty($request->created_at)) {
            $data[Transaction::COLUMN_CREATED_AT] = $request->created_at;
        }
        $this->transactionRepository->create($data);
    }

    public function create_paypal_nl($request, $pay, $result)
    {
        $insertTransaction = [
            Transaction::COLUMN_TYPE => Transaction::TRA_LAI,
            Transaction::COLUMN_TYPE_METHOD => Transaction::FORM_HANDMADE,  //1 tu dong, 2 kt tra tay
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS,//1 thanh cong, 2 that bai
            Transaction::COLUMN_CODE_CONTRACT => $pay->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => round($pay->goc_lai_1ky),
            Transaction::COLUMN_TIEN_GOC => round($pay->tien_goc_1ky_phai_tra),
            Transaction::COLUMN_TIEN_LAI => round($pay->tien_lai_1ky_phai_tra),
            Transaction::COLUMN_INVESTOR_CODE => $pay->investor_code,
            Transaction::COLUMN_TRADING_CODE => $result->transaction_id,
            Transaction::COLUMN_NOTE => !empty($request->note) ? $request->note : 'TienNgay.vn thanh toán nhà đầu tư',
            Transaction::COLUMN_CREATED_BY => current_user()->email,
            Transaction::COLUMN_CONTRACT_ID => $pay->contract->id,
            Transaction::COLUMN_TONG_GOC_LAI => round($pay->goc_lai_1ky),
            Transaction::COLUMN_PAY_ID => $pay->id,
            Transaction::COLUMN_PAYMENT_SOURCE => Transaction::PAYMENT_SOURCE_NGAN_LUONG,
        ];
        $this->transactionRepository->create($insertTransaction);
    }

    public function create_paypal_nl_auto($data, $pay, $result)
    {
        $insertTransaction = [
            Transaction::COLUMN_TYPE => Transaction::TRA_LAI,
            Transaction::COLUMN_TYPE_METHOD => Transaction::FORM_AUTO,  //1 tu dong, 2 kt tra tay
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS,//1 thanh cong, 2 that bai
            Transaction::COLUMN_CODE_CONTRACT => $pay->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => round($pay->goc_lai_1ky),
            Transaction::COLUMN_TIEN_GOC => round($pay->tien_goc_1ky_phai_tra),
            Transaction::COLUMN_TIEN_LAI => round($pay->tien_lai_1ky_phai_tra),
            Transaction::COLUMN_INVESTOR_CODE => $pay->investor_code,
            Transaction::COLUMN_TRADING_CODE => $result->transaction_id,
            Transaction::COLUMN_NOTE => "TienNgay thanh toán NĐT",
            Transaction::COLUMN_CREATED_BY => 'automatic system',
            Transaction::COLUMN_CONTRACT_ID => $pay->contract->id,
            Transaction::COLUMN_TONG_GOC_LAI => round($pay->goc_lai_1ky),
            Transaction::COLUMN_PAY_ID => $pay->id,
            Transaction::COLUMN_PAYMENT_SOURCE => Transaction::PAYMENT_SOURCE_NGAN_LUONG,
        ];
        $this->transactionRepository->create($insertTransaction);
    }

    public function app_create_transaction_nl($contract, $transaction_id)
    {
        $data = [
            Transaction::COLUMN_CONTRACT_ID => $contract->id,
            Transaction::COLUMN_TYPE => Transaction::DAU_TU,
            Transaction::COLUMN_CODE_CONTRACT => $contract->code_contract,
            Transaction::COLUMN_INVESTMENT_AMOUNT => $contract->investment_amount,
            Transaction::COLUMN_INVESTOR_CODE => $contract->investor_code,
            Transaction::COLUMN_INTEREST => $contract->interest,
            Transaction::COLUMN_CREATED_BY => $contract->created_by,
            Transaction::COLUMN_PAYMENT_SOURCE => Transaction::PAYMENT_SOURCE_NGAN_LUONG,
            Transaction::COLUMN_TRADING_CODE => $transaction_id,
            Transaction::COLUMN_STATUS => Transaction::STATUS_SUCCESS
        ];
        $this->transactionRepository->create($data);
    }

    public function sumTransactionWallet($startDay, $endDay, $status)
    {
        $sumTransaction = DB::table('transaction')
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->join('investor', 'contract.investor_id', '=', 'investor.id')
            ->where('contract.type_contract', '=', "APP")
            ->where('transaction.payment_source', '=', "$status")
            ->where('transaction.type', '=', "1")
            ->whereBetween('transaction.created_at', [$startDay, $endDay])
            ->sum('transaction.investment_amount');

        return $sumTransaction;


    }

    public function sumTransactionWallet_UQ($startDay, $endDay, $status)
    {
        $sumTransaction = DB::table('transaction')
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->join('investor', 'contract.investor_id', '=', 'investor.id')
            ->where('transaction.type', '=', "1")
            ->where('contract.type_contract', '=', "$status")
            ->whereBetween('transaction.created_at', [$startDay, $endDay])
            ->sum('transaction.investment_amount');
        return $sumTransaction;
    }

    public function sumPayNdtActual($startDay, $endDay, $status)
    {

        if ($status == "nganluong") {
            $sumTransaction = DB::table('transaction')
                ->join('contract', 'transaction.contract_id', '=', 'contract.id')
                ->where('contract.type_contract', '=', "APP")
                ->where('transaction.payment_source', '=', $status)
                ->where('transaction.type', '=', "2")
                ->whereBetween('transaction.created_at', [$startDay, $endDay])
                ->sum('transaction.investment_amount');
        } elseif ($status == 'vimo') {
            $sumTransaction = DB::table('transaction')
                ->join('contract', 'transaction.contract_id', '=', 'contract.id')
                ->where('contract.type_contract', '=', "APP")
                ->where(function ($query) use ($status) {
                    $query->where('transaction.payment_source', '=', $status)
                        ->orWhere('transaction.payment_source', '=', NULL);
                })
                ->where('transaction.type', '=', "2")
                ->whereBetween('transaction.created_at', [$startDay, $endDay])
                ->sum('transaction.investment_amount');
        }
        return $sumTransaction;
    }

    public function sumPayNdtHopTacActual($startDay, $endDay, $status)
    {
        $sumTransaction = DB::table('transaction')
            ->join('contract', 'transaction.contract_id', '=', 'contract.id')
            ->where('transaction.type', '=', "2")
            ->where('contract.type_contract', '=', "$status")
            ->whereBetween('transaction.created_at', [$startDay, $endDay])
            ->sum('transaction.investment_amount');
        return $sumTransaction;


    }


}
