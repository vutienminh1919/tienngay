<?php


namespace App\Service;


use App\Models\Interest;
use App\Models\Investment;
use App\Repository\InterestRepository;
use App\Repository\InvestmentRepositoryInterface;
use http\Env\Request;

class InvestmentService extends BaseService
{
    protected $investmentRepository;
    protected $interestRepository;

    public function __construct(InvestmentRepositoryInterface $investmentRepository,
                                InterestRepository $interestRepository)
    {
        $this->investmentRepository = $investmentRepository;
        $this->interestRepository = $interestRepository;
    }

    public function so_luong_hd_tao_trong_thang()
    {
        $total = $this->investmentRepository->so_luong_hd_tao_trong_thang();
        return $total;
    }

    public function create($request)
    {
        $count = $this->so_luong_hd_tao_trong_thang();
        $date = date('Ymd');
        $time = date('His');
        $code_contract = 'HĐGV/' . $date . '/' . $time . '/0' . ++$count;
//        $code_contract_disbursement = 'HĐGV/' . $date . '/0' . ++$count;
        $data = [
            Investment::COLUMN_CODE_CONTRACT => $code_contract,
            Investment::COLUMN_CODE_CONTRACT_DISBURSEMENT => $code_contract,
            Investment::COLUMN_NUMBER_DAY_LOAN => $request->month * 30,
            Investment::COLUMN_AMOUNT_MONEY => $request->amount_money,
            Investment::COLUMN_TYPE_INTEREST => $request->type_interest,
            Investment::COLUMN_TYPE => Investment::HOP_DONG_GOI_VON,
            Investment::COLUMN_CREATED_BY => current_user()->email,
            Investment::COLUMN_STATUS => Investment::STATUS_ACTIVE
        ];
        $this->investmentRepository->create($data);
    }

    public function create_cpanel($request)
    {
        $interest = $this->interestRepository->findOne([
            Interest::COLUMN_TYPE_INTEREST => $request->type_interest,
            Interest::COLUMN_PERIOD => (int)$request->number_day_loan / 30,
            Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE
        ]);
        if ($interest) {
            $data = [
                Investment::COLUMN_CODE_CONTRACT => $request->code_contract,
                Investment::COLUMN_CODE_CONTRACT_DISBURSEMENT => $request->code_contract_disbursement,
                Investment::COLUMN_NUMBER_DAY_LOAN => $request->number_day_loan,
                Investment::COLUMN_AMOUNT_MONEY => $request->amount_money,
                Investment::COLUMN_TYPE_INTEREST => $request->type_interest,
                Investment::COLUMN_TYPE => Investment::HOP_DONG_DA_GN,
                Investment::COLUMN_CONTRACT_ID => $request->contract_id,
                Investment::COLUMN_CREATED_BY => 'superadmin@tienngay.vn',
                Investment::COLUMN_STATUS => Investment::STATUS_ACTIVE
            ];
            $this->investmentRepository->create($data);
        }
        return;
    }

    public function update_otp($otp_invest, $time_otp_invest, $request)
    {
        $data = [
            Investment::COLUMN_OTP_INVEST => $otp_invest,
            Investment::COLUMN_TIME_OTP_INVEST => $time_otp_invest,
            Investment::COLUMN_INVESTOR_CREATE_OTP => $request->id,
        ];
        $this->investmentRepository->update($request->contract_id, $data);
    }

    public function update_time_invest($time_otp_invest, $request)
    {
        $data = [
            Investment::COLUMN_TIME_OTP_INVEST => $time_otp_invest,
            Investment::COLUMN_INVESTOR_CREATE_OTP => $request->id,
        ];
        $this->investmentRepository->update($request->contract_id, $data);
    }

    public function auto_create($month, $amount_money, $type_interest)
    {
        $interest = $this->interestRepository->findOne([
            Interest::COLUMN_PERIOD => (int)$month,
            Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE,
            Interest::COLUMN_TYPE_INTEREST => $type_interest
        ]);
        if ($interest) {
            $count = $this->so_luong_hd_tao_trong_thang();
            $date = date('Ymd');
            $time = date('His');
            $code_contract = 'HĐGV/' . $date . '/' . $time . '/0' . ++$count;
            $insert = [
                Investment::COLUMN_CODE_CONTRACT => $code_contract,
                Investment::COLUMN_CODE_CONTRACT_DISBURSEMENT => $code_contract,
                Investment::COLUMN_NUMBER_DAY_LOAN => $month * 30,
                Investment::COLUMN_AMOUNT_MONEY => $amount_money,
                Investment::COLUMN_TYPE_INTEREST => $type_interest,
                Investment::COLUMN_TYPE => Investment::HOP_DONG_GOI_VON,
                Investment::COLUMN_CREATED_BY => 'system',
                Investment::COLUMN_STATUS => Investment::STATUS_ACTIVE
            ];
            return $this->investmentRepository->create($insert);
        }
        return null;
    }
}
