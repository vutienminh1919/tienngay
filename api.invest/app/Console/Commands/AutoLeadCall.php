<?php

namespace App\Console\Commands;

use App\Models\ConfigCall;
use App\Models\LeadInvestor;
use App\Repository\ConfigCallRepositoryInterface;
use App\Repository\LeadInvestorRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoLeadCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lead:call';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto assign lead for call';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LeadInvestorRepositoryInterface $leadInvestorRepository,
                                ConfigCallRepositoryInterface $configCallRepository)
    {
        parent::__construct();
        $this->leadInvestor_model = $leadInvestorRepository;
        $this->configCallRepository = $configCallRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $leads = $this->leadInvestor_model->get_lead_null_assign();
        $cskh_online = $this->configCallRepository->findOne([ConfigCall::COLUMN_DATE => date('Y-m-d')]);
        if ($cskh_online) {
            $users = explode(',', $cskh_online->telesales);
            $last_lead = $this->leadInvestor_model->findLastLead();
            if ($last_lead) {
                $user_last_lead = $last_lead->assign_call;
                $vi_tri_auto = array_search($user_last_lead, $users);
                if (isset($vi_tri_auto)) {
                    if ($vi_tri_auto == (count($users) - 1)) {
                        $start = 0;
                    } else {
                        $start = $vi_tri_auto + 1;
                    }
                } else {
                    $start = 0;
                }
            } else {
                $start = 0;
            }

            if (count($leads) > 0) {
                $count = 0;
                for ($i = 0, $j = $start; $i < count($leads), $j < count($users); $i++, $j++) {
                    $this->leadInvestor_model->update($leads[$i]->id, [LeadInvestor::COLUMN_ASSIGN_CALL => $users[$j], LeadInvestor::COLUMN_TIME_ASSIGN_CALL => Carbon::now()]);
                    if (count($users) - 1 == $j) {
                        $j = -1;
                    }
                    $count++;
                    if ($count == count($leads)) {
                        break;
                    }
                }
            }
        }
    }
}
