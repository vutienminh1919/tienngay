<?php

namespace App\Console\Commands;

use App\Models\InfoCommission;
use App\Models\User;
use App\Repository\CommissionRepository;
use App\Repository\ContractRepository;
use App\Repository\InfoCommissionRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class CronCommissionInvestor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investor:commission {--month= }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Commission Investor';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContractRepository $contractRepository,
                                Request $request,
                                UserRepository $userRepository,
                                CommissionRepository $commissionRepository,
                                InfoCommissionRepository $infoCommissionRepository,
                                UserService $userService)
    {
        parent::__construct();
        $this->contractRepository = $contractRepository;
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->commissionRepository = $commissionRepository;
        $this->infoCommissionRepository = $infoCommissionRepository;
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $year_month = $this->option('month') ?? date('Y-m');
        $year = !empty($year_month) ? explode('-', $year_month)[0] : date('Y');
        $month = !empty($year_month) ? explode('-', $year_month)[1] : date('m');
        $date = get_created_at_with_year($month, $year);
        $this->request->fdate = $date['start'];
        $this->request->tdate = $date['end'];

        $timeline = strtotime($year . '-' . $month . '-01');
        $user_commission = $this->userRepository->get_user_refferall();
        if ($timeline <= strtotime('2022-12-01')) {
            foreach ($user_commission as $user_id) {
                $info = $this->userRepository->find($user_id);
                $type_referral = !empty($info->type_referral) ? $info->type_referral : 'app';
                $total_invest = $this->userRepository->total_invest($user_id, $this->request);
                if ($total_invest <= 0) continue;
                $this->commission_v1($total_invest, $type_referral, $user_id, $year_month, $this->request);
                echo 'success' . "\n";
            }
        } else {
            foreach ($user_commission as $user_id) {
                $info = $this->userRepository->find($user_id);
                $type_referral = !empty($info->type_referral) ? $info->type_referral : 'app';
                if ($type_referral == 'cvkd') {
                    $total_invest = $this->userRepository->total_invest($user_id, $this->request);
                    if ($total_invest <= 0) continue;
                    $this->commission_v1($total_invest, $type_referral, $user_id, $year_month, $this->request);
                    echo 'success1' . "\n";
                } else {
                    $contracts = $this->contractRepository->get_all_contract_by_referral_v2($this->request, $user_id);
                    $commission = $this->commissionRepository->findCommission(200000000, $type_referral, $this->request);
                    if (count($contracts) == 0) continue;
                    $this->commission_v2($contracts, $user_id, $year_month, $commission);
                    echo 'success2' . "\n";
                }
            }
        }
        return 0;
    }

    public function commission_v1($total_invest, $type_referral, $user_id, $year_month, $request)
    {
        $commission = $this->commissionRepository->findCommission((int)$total_invest, $type_referral, $request);
        $info_old = $this->infoCommissionRepository->findOne([InfoCommission::USER_ID => $user_id, InfoCommission::TIME => $year_month, InfoCommission::DETAIL_ID => null]);
        if ($info_old) {
            $info = $this->infoCommissionRepository->update($info_old['id'], [
                InfoCommission::COMMISSION => $commission['commission'],
                InfoCommission::TOTAL_MONEY => $total_invest,
                InfoCommission::MONEY_COMMISSION => (int)$total_invest * $commission['commission'] / 100,
            ]);
        } else {
            $info = $this->infoCommissionRepository->create([
                InfoCommission::USER_ID => $user_id,
                InfoCommission::COMMISSION => $commission['commission'],
                InfoCommission::TIME => $year_month,
                InfoCommission::TOTAL_MONEY => $total_invest,
                InfoCommission::MONEY_COMMISSION => (int)$total_invest * $commission['commission'] / 100,
            ]);
        }
        $user_referral = $this->userRepository->findMany([User::REFERRAL_ID => $user_id, User::STATUS => User::STATUS_ACTIVE]);
        foreach ($user_referral as $item) {
            $contracts = $this->contractRepository->get_contract_commission_by_user($item['id'], $request);
            if ($contracts) {
                foreach ($contracts as $contract) {
                    $detail = $this->infoCommissionRepository->findOne([InfoCommission::CONTRACT_ID => $contract->id, InfoCommission::USER_ID => $item['id'], InfoCommission::TIME => $year_month, InfoCommission::DETAIL_ID => $info['id']]);
                    if ($detail) {
                        $this->infoCommissionRepository->update($detail['id'], [
                            InfoCommission::COMMISSION => $commission['commission'],
                            InfoCommission::MONEY_COMMISSION => (int)$contract->amount_money * $commission['commission'] / 100,
                        ]);
                    } else {
                        $this->infoCommissionRepository->create([
                            InfoCommission::USER_ID => $item['id'],
                            InfoCommission::COMMISSION => $commission['commission'],
                            InfoCommission::TIME => $year_month,
                            InfoCommission::TOTAL_MONEY => $contract->amount_money,
                            InfoCommission::MONEY_COMMISSION => (int)$contract->amount_money * $commission['commission'] / 100,
                            InfoCommission::CONTRACT_ID => $contract->id,
                            InfoCommission::DETAIL_ID => $info['id'],
                        ]);
                    }
                }
            }
        }
    }

    public function commission_v2($contracts, $user_id, $year_month, $commission)
    {
        $info_old = $this->infoCommissionRepository->findOne([InfoCommission::USER_ID => $user_id, InfoCommission::TIME => $year_month, InfoCommission::DETAIL_ID => null]);
        if ($info_old) {
            $info = $info_old;
        } else {
            $info = $this->infoCommissionRepository->create([
                InfoCommission::USER_ID => $user_id,
                InfoCommission::TIME => $year_month,
            ]);
        }

        $total_money_number = 0;
        $money_commission_number = 0;
        foreach ($contracts as $contract) {
            $result = $this->userService->commission_contract_v2($contract, $this->request, $year_month, $commission, $user_id);
            if ($result['so_ngay'] == 0) continue;
            $detail = $this->infoCommissionRepository->findOne([InfoCommission::CONTRACT_ID => $contract->id, InfoCommission::USER_ID => $contract->user_id, InfoCommission::TIME => $year_month, InfoCommission::DETAIL_ID => $info['id']]);
            if ($detail) {
                $this->infoCommissionRepository->update($detail['id'], [
                    InfoCommission::COMMISSION => $result['commission'],
                    InfoCommission::MONEY_COMMISSION => $result['money_commission_number'],
                    InfoCommission::TOTAL_MONEY => $result['total_money_number'],
                    InfoCommission::DAY => $result['so_ngay']
                ]);
            } else {
                $this->infoCommissionRepository->create([
                    InfoCommission::USER_ID => $contract->user_id,
                    InfoCommission::TIME => $year_month,
                    InfoCommission::COMMISSION => $result['commission'],
                    InfoCommission::MONEY_COMMISSION => $result['money_commission_number'],
                    InfoCommission::TOTAL_MONEY => $result['total_money_number'],
                    InfoCommission::CONTRACT_ID => $contract->id,
                    InfoCommission::DETAIL_ID => $info['id'],
                    InfoCommission::DAY => $result['so_ngay']
                ]);
            }
            $total_money_number += $result['total_money_number'];
            $money_commission_number += $result['money_commission_number'];
        }

        $this->infoCommissionRepository->update($info['id'], [
            InfoCommission::COMMISSION => $commission['commission'],
            InfoCommission::TOTAL_MONEY => $total_money_number,
            InfoCommission::MONEY_COMMISSION => $money_commission_number,
        ]);
    }
}
