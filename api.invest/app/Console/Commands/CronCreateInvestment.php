<?php


namespace App\Console\Commands;


use App\Models\Contract;
use App\Service\ContractService;
use App\Service\InvestmentService;
use Illuminate\Console\Command;

class CronCreateInvestment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:investment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron create investment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InvestmentService $investmentService)
    {
        parent::__construct();
        $this->investmentService = $investmentService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arr_money = [1000000, 3000000, 5000000, 10000000, 15000000, 20000000, 25000000, 30000000, 50000000, 100000000, 150000000, 200000000];
        $arr_month = [1, 3, 6, 9, 12, 18, 24];
        foreach ($arr_money as $money) {
            if ($money <= 5000000) {
                foreach ($arr_month as $month) {
                    for ($i = 0; $i < 5; $i++) {
                        if ($month == 1) {
                            $investment2 = $this->investmentService->auto_create($month, $money, Contract::LAI_HANG_THANG_GOC_CUOI_KY);
                            echo $investment2['id'] . "\n";
                        } else {
                            if ($month < 3 || $month > 6)
                                continue;
                            $investment1 = $this->investmentService->auto_create($month, $money, Contract::DU_NO_GIAM_DAN);
                            echo $investment1['id'] . "\n";

                            $investment3 = $this->investmentService->auto_create($month, $money, Contract::GOC_LAI_CUOI_KY);
                            echo $investment3['id'] . "\n";
                        }
                    }
                }
            } else {
                foreach ($arr_month as $month) {
                    for ($i = 0; $i < 5; $i++) {
                        if ($month == 1) {
                            $investment2 = $this->investmentService->auto_create($month, $money, Contract::LAI_HANG_THANG_GOC_CUOI_KY);
                            echo $investment2['id'] . "\n";
                        } else {
                            $investment1 = $this->investmentService->auto_create($month, $money, Contract::DU_NO_GIAM_DAN);
                            echo $investment1['id'] . "\n";

                            $investment3 = $this->investmentService->auto_create($month, $money, Contract::GOC_LAI_CUOI_KY);
                            echo $investment3['id'] . "\n";
                        }
                    }
                }
            }
        }
        return 0;
    }
}
