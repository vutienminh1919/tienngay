<?php

namespace App\Console\Commands;

use App\Models\Investment;
use App\Repository\InvestmentRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class InvestmentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'block:investment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Block investment over 10 day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InvestmentRepositoryInterface $investmentRepository)
    {
        parent::__construct();
        $this->investment_model = $investmentRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $limit = Carbon::now()->subDays(5);
        $investments = $this->investment_model->get_over_10_day($limit);
        if (count($investments) > 0) {
            foreach ($investments as $investment) {
                $this->investment_model->update($investment->id, [Investment::COLUMN_STATUS => Investment::STATUS_BLOCK]);
            }
        }
    }
}
