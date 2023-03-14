<?php

namespace App\Console\Commands;

use App\Models\ConfigCall;
use App\Models\Investor;
use App\Repository\ConfigCallRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoInvestorCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investor:call';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto assign investor for call';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InvestorRepositoryInterface $investor,
                                ConfigCallRepositoryInterface $configCallRepository)
    {
        parent::__construct();
        $this->investor_model = $investor;
        $this->configCallRepository = $configCallRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $leads = $this->investor_model->get_investor_null_assign();
        $cskh_online = $this->configCallRepository->findOne([ConfigCall::COLUMN_DATE => date('Y-m-d')]);
        if ($cskh_online) {
            $users = explode(',', $cskh_online->telesales);
            $last_lead = $this->investor_model->findLastLead();
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
                    $this->investor_model->update($leads[$i]->id, [Investor::COLUMN_ASSIGN_CALL => $users[$j], Investor::COLUMN_TIME_ASSIGN_CALL => Carbon::now()]);
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
