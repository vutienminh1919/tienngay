<?php

namespace App\Console\Commands;

use App\Models\Contract;
use Illuminate\Console\Command;

class GenerateDateContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GenerateDateContract';

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
        $contracts = Contract::whereNull(Contract::COLUMN_START_DATE)
            ->limit(2000)
            ->get();
        foreach ($contracts as $contract) {
            $start_date = date('Y-m-d', strtotime($contract['created_at']));
            Contract::where(Contract::COLUMN_ID, $contract['id'])
                ->update([
                    Contract::COLUMN_START_DATE => strtotime($start_date),
                ]);
            $month = $contract['number_day_loan'] / 30;
            $due_date = $this->periodDays($start_date, $month)['date'];
            Contract::where(Contract::COLUMN_ID, $contract['id'])
                ->update([
                    Contract::COLUMN_DUE_DATE => strtotime($due_date)
                ]);
            echo $contract['code_contract'] . "\n";
        }
        return 0;
    }

    /**
     * @param $start_date
     * @param $per
     * @return array
     * @throws \Exception
     */
    private function periodDays($start_date, $per)
    {
        $from = new \DateTime($start_date);
        $day = $from->format('j');
        $from->modify('first day of this month');
        $period = new \DatePeriod($from, new \DateInterval('P1M'), $per);
        $arr_date = [];
        foreach ($period as $date) {
            $lastDay = clone $date;
            $lastDay->modify('last day of this month');
            $date->setDate($date->format('Y'), $date->format('n'), $day);
            if ($date > $lastDay) {
                $date = $lastDay;
            }
            $arr_date[] = $date->format('Y-m-d');
        }
        $datetime1 = new \DateTime($arr_date[$per - 1]);
        $datetime2 = new \DateTime($arr_date[$per]);
        $difference = $datetime1->diff($datetime2);
        return array('date' => ($arr_date[$per]), 'days' => $difference->days);
    }
}
