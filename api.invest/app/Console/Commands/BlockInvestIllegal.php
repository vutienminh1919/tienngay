<?php

namespace App\Console\Commands;

use App\Models\Interest;
use App\Models\Investment;
use Illuminate\Console\Command;

class BlockInvestIllegal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:block_illegal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Block investment illegal';

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
        $investments = Investment::where(Investment::COLUMN_STATUS, Investment::STATUS_ACTIVE)
            ->whereNull(Investment::COLUMN_INVESTOR_CONFIRM)
            ->get();

        foreach ($investments as $investment) {
            $interest = Interest::where(Interest::COLUMN_TYPE_INTEREST, $investment['type_interest'])
                ->where(Interest::COLUMN_PERIOD, ($investment['number_day_loan'] / 30))
                ->where(Interest::COLUMN_STATUS, Interest::STATUS_ACTIVE)
                ->first();
            if (!$interest) {
                echo $investment['id'] . "\n";
                Investment::where(Investment::COLUMN_ID, $investment['id'])
                    ->update([Investment::COLUMN_STATUS => Investment::STATUS_BLOCK]);
            }
        }
        return 0;
    }
}
