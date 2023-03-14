<?php

namespace App\Console\Commands;

use App\Models\Investor;
use App\Repository\InvestorRepositoryInterface;
use Illuminate\Console\Command;

class InvestmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status investment of investor';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InvestorRepositoryInterface $investorRepository)
    {
        parent::__construct();
        $this->investor_model = $investorRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $investors = $this->investor_model->get_investor_active();
        foreach ($investors as $investor) {
            $contract = $investor->contracts()->first();
            if (isset($contract)) {
                $this->investor_model->update($investor->id, [Investor::COLUMN_INVESTMENT_STATUS => Investor::DA_DAU_TU]);
            } else {
                $this->investor_model->update($investor->id, [Investor::COLUMN_INVESTMENT_STATUS => Investor::CHUA_DAU_TU]);
            }
        }
        return;
    }
}
