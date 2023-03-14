<?php

namespace App\Console\Commands;

use App\Models\Investor;
use App\Repository\InvestorRepositoryInterface;
use Illuminate\Console\Command;

class CronClearAssignCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear assign call no process';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InvestorRepositoryInterface $investorRepository)
    {
        parent::__construct();
        $this->investorRepository = $investorRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $investors = $this->investorRepository->get_investor_no_process();
        foreach ($investors as $investor) {
            $this->investorRepository->update($investor->id, [Investor::COLUMN_ASSIGN_CALL => null]);
        }
    }
}
