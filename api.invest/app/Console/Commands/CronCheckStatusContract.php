<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronCheckStatusContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contract:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check status contract (expire or effect)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
