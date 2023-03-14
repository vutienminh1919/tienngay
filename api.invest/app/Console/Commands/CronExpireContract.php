<?php

namespace App\Console\Commands;

use App\Service\ContractService;
use Illuminate\Console\Command;

class CronExpireContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron expire contract';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContractService $contractService)
    {
        parent::__construct();
        $this->contractService = $contractService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->contractService->get_contract_to_check_status();
    }
}
