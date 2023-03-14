<?php


namespace App\Service;

use App\Models\ContractInterest;
use App\Models\Interest;
use App\Models\Investment;
use App\Models\LogInterest;
use App\Repository\ContractInterestRepositoryInterface;
use App\Repository\InterestRepositoryInterface;
use App\Repository\LogInterestRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;

class InterestService extends BaseService
{
    protected $interestRepository;
    protected $contractInterestRepository;
    protected $logInterestRepository;

    public function __construct(InterestRepositoryInterface $interestRepository,
                                ContractInterestRepositoryInterface $contractInterestRepository,
                                LogInterestRepositoryInterface $logInterestRepository)
    {
        $this->interestRepository = $interestRepository;
        $this->contractInterestRepository = $contractInterestRepository;
        $this->logInterestRepository = $logInterestRepository;
    }

    public function get_interest_for_app($request)
    {
        $period = $request->period;
        $type_interest = $request->type_interest;
        $interest_period_type = $this->interestRepository->findOne([Interest::COLUMN_PERIOD => $period, Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE, Interest::COLUMN_TYPE_INTEREST => $type_interest]);
        if ($interest_period_type) {
            $interest_period_detail = $this->contractInterestRepository->findOne([ContractInterest::COLUMN_INTEREST_ID => $interest_period_type->id, ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE]);
            $interest_period_type->contract_interest_id = $interest_period_detail->id;
            return $interest_period_type;
        } else {
            $interest_period_type_null = $this->interestRepository->get_interest_period_type_interest_null($period);
            if ($interest_period_type_null) {
                $interest_period_detail = $this->contractInterestRepository->findOne([ContractInterest::COLUMN_INTEREST_ID => $interest_period_type_null->id, ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE]);
                $interest_period_type_null->contract_interest_id = $interest_period_detail->id;
                return $interest_period_type_null;
            } else {
                $interest_all = $this->interestRepository->findOne([Interest::COLUMN_TYPE => Interest::TYPE_ALL, Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE]);
                return $interest_all;
            }
        }
    }

    public function get_interest_for_investment($contract)
    {
        $period = (int)$contract->number_day_loan / 30;
        $type_interest = $contract->type_interest;
        $interest_period_type = $this->interestRepository->findOne([Interest::COLUMN_PERIOD => $period, Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE, Interest::COLUMN_TYPE_INTEREST => $type_interest]);
        if ($interest_period_type) {
            $interest_period_detail = $this->contractInterestRepository->findOne([ContractInterest::COLUMN_INTEREST_ID => $interest_period_type->id, ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE]);
            $interest_period_type->contract_interest_id = $interest_period_detail->id;
            return $interest_period_type;
        } else {
            $interest_period_type_null = $this->interestRepository->get_interest_period_type_interest_null($period);
            if ($interest_period_type_null) {
                $interest_period_detail = $this->contractInterestRepository->findOne([ContractInterest::COLUMN_INTEREST_ID => $interest_period_type_null->id, ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE]);
                $interest_period_type_null->contract_interest_id = $interest_period_detail->id;
                return $interest_period_type_null;
            } else {
                $interest_all = $this->interestRepository->findOne([Interest::COLUMN_TYPE => Interest::TYPE_ALL, Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE]);
                return $interest_all;
            }
        }
    }

    public function create_period_new($request)
    {
        $message = [];
        $interest = $this->interestRepository->findOne([Interest::COLUMN_TYPE => Interest::TYPE_PERIOD, Interest::COLUMN_TYPE_INTEREST => $request->type_interest, Interest::COLUMN_PERIOD => $request->period]);
        if ($interest) {
            $this->interestRepository->update($request->id, [Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE]);
            $contract_interest = $this->contractInterestRepository->findOne([ContractInterest::COLUMN_INTEREST_ID => $interest->id, ContractInterest::COLUMN_INTEREST => $request->interest]);
            if ($contract_interest) {
                if ($contract_interest->status == ContractInterest::STATUS_ACTIVE) {
                    $message[] = 'Lãi suất đã tồn tại';
                    return $message;
                } else {
                    foreach ($interest->contractInterests as $value) {
                        $this->contractInterestRepository->update($value->id, [ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_BLOCK]);
                    }
                    $this->interestRepository->update($interest->id, [Interest::COLUMN_INTEREST => $request->interest]);
                    $contract_interest_new = $this->contractInterestRepository->update($contract_interest->id, [ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE]);
                }
            } else {
                foreach ($interest->contractInterests as $value) {
                    $this->contractInterestRepository->update($value->id, [ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_BLOCK]);
                }
                $this->interestRepository->update($interest->id, [Interest::COLUMN_INTEREST => $request->interest]);
                $contract_interest_new = $this->contractInterestRepository->create(
                    [
                        ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE,
                        ContractInterest::COLUMN_INTEREST => $request->interest,
                        ContractInterest::COLUMN_INTEREST_ID => $interest->id,
                        ContractInterest::COLUMN_CREATED_BY => current_user()->email
                    ]
                );
            }
        } else {
            $interest_new = $this->interestRepository->create([
                Interest::COLUMN_TYPE => Interest::TYPE_PERIOD,
                Interest::COLUMN_PERIOD => $request->period,
                Interest::COLUMN_INTEREST => $request->interest,
                Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE,
                Interest::COLUMN_TYPE_INTEREST => $request->type_interest,
                Interest::COLUMN_CREATED_BY => current_user()->email
            ]);
            $contract_interest_new = $this->contractInterestRepository->create(
                [
                    ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE,
                    ContractInterest::COLUMN_INTEREST => $request->interest,
                    ContractInterest::COLUMN_INTEREST_ID => $interest_new->id,
                    ContractInterest::COLUMN_CREATED_BY => current_user()->email
                ]
            );
        }
        $log = [
            LogInterest::COLUMN_TYPE => LogInterest::TYPE_CREATE,
            LogInterest::COLUMN_NEW => json_encode($contract_interest_new),
            LogInterest::COLUMN_CREATED_BY => current_user()->email
        ];
        $this->logInterestRepository->create($log);
        return $message;
    }

    public function get_interest_period()
    {
        $interest = [];
        $interest_type_null = $this->interestRepository->get_interest_period_type_interest('');
        $interest[0] = $interest_type_null;
        $interest_type_1 = $this->interestRepository->get_interest_period_type_interest(Interest::DU_NO_GIAM_DAN);
        $interest[1] = $interest_type_1;
        $interest_type_2 = $this->interestRepository->get_interest_period_type_interest(Interest::LAI_HANG_THANG_GOC_CUOI_KY);
        $interest[2] = $interest_type_2;
        $interest_type_4 = $this->interestRepository->get_interest_period_type_interest(Interest::GOC_LAI_CUOI_KY);
        $interest[4] = $interest_type_4;
        return $interest;
    }

    public function update_interest_period($request)
    {
        try {
            $interest = $this->interestRepository->find($request->id);
            if ($interest->status == Interest::STATUS_ACTIVE) {
                Investment::where(Investment::COLUMN_TYPE_INTEREST, $interest['type_interest'])
                    ->where(Investment::COLUMN_NUMBER_DAY_LOAN, ($interest['period'] * 30))
                    ->where(Investment::COLUMN_STATUS, Investment::STATUS_ACTIVE)
                    ->whereNull(Investment::COLUMN_INVESTOR_CONFIRM)
                    ->update([Investment::COLUMN_STATUS => Investment::STATUS_BLOCK]);

                $interest_new = $this->interestRepository->update($request->id, [Interest::COLUMN_STATUS => Interest::STATUS_BLOCK]);
            } else {
                $interest_new = $this->interestRepository->update($request->id, [Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE]);
            }
            $log = [
                LogInterest::COLUMN_TYPE => LogInterest::TYPE_UPDATE,
                LogInterest::COLUMN_OLD => json_encode($interest),
                LogInterest::COLUMN_NEW => json_encode($interest_new),
                LogInterest::COLUMN_CREATED_BY => current_user()->email
            ];
            $this->logInterestRepository->create($log);
        } catch (\Exception $exception) {

        }

    }

    public function edit_add_interest_period($request)
    {
        $interest = $this->interestRepository->find($request->id);
        $interest_new = $this->interestRepository->update($request->id,
            [
                Interest::COLUMN_STATUS => Interest::STATUS_ACTIVE,
                Interest::COLUMN_INTEREST => $request->interest
            ]);
        $contract_interest_all = $this->contractInterestRepository->findMany([ContractInterest::COLUMN_INTEREST_ID => $request->id]);
        foreach ($contract_interest_all as $value) {
            $this->contractInterestRepository->update($value->id, [ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_BLOCK]);
        }
        $contract_interest = $this->contractInterestRepository->findOne([
            ContractInterest::COLUMN_INTEREST => $request->interest,
            ContractInterest::COLUMN_INTEREST_ID => $request->id
        ]);
        if ($contract_interest) {
            $this->contractInterestRepository->update($contract_interest->id, [ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE]);
        } else {
            $this->contractInterestRepository->create(
                [
                    ContractInterest::COLUMN_INTEREST_ID => $request->id,
                    ContractInterest::COLUMN_INTEREST => $request->interest,
                    ContractInterest::COLUMN_STATUS => ContractInterest::STATUS_ACTIVE,
                    ContractInterest::COLUMN_CREATED_BY => current_user()->email
                ]);
        }
        $this->logInterestRepository->create(
            [
                LogInterest::COLUMN_TYPE => LogInterest::TYPE_UPDATE,
                LogInterest::COLUMN_OLD => json_encode($interest),
                LogInterest::COLUMN_NEW => json_encode($interest_new),
                LogInterest::COLUMN_CREATED_BY => current_user()->email
            ]
        );
    }
}
