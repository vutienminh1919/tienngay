<?php

namespace App\Console\Commands;


use App\Http\Controllers\LeadBackLogController;
use Illuminate\Console\Command;

class CronCalculatorLeadOldProcessed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lead:old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto save total investor backlog in past';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LeadBackLogController $leadBackLogController)
    {
        parent::__construct();
        $this->leadBackLogController = $leadBackLogController;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->leadBackLogController->leadBackLogDaily();
    }
}
