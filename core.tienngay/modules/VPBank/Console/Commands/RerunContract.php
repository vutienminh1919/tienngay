<?php

namespace Modules\VPBank\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Modules\MysqlCore\Entities\VPBankTransaction;
use Modules\MongodbCore\Entities\Transaction;
use App;
use Modules\VPBank\Service\ApiTienNgay;

class RerunContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpbank:rerunContract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "run contract";

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
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $startTime = date('Y-m-d H:i:s', strtotime('now') - 86400); //current time - 24h
        Log::channel('cronjob')->info('RerunContract job start');
        $transactions = DB::table('vpbank_transactions')
                ->select(VPBankTransaction::ID, VPBankTransaction::CONTRACT_ID) // id phiếu thu, bank_code
                ->whereNotNull(VPBankTransaction::CONTRACT_ID) // giao dịch đã tạo phiếu thu
                ->where(VPBankTransaction::CREATED_AT, '>', $startTime)
                ->get();
        if ($transactions->count() < 1) {
            Log::channel('cronjob')->info('transactions is empty');
            Log::channel('cronjob')->info('RerunContract job success');
            return;
        }
        //get only Contract IDs value
        $ids = $transactions->pluck(VPBankTransaction::CONTRACT_ID);
        foreach ($ids as $key => $value) {
            Log::channel('cronjob')->info('Rerun contract: ' . $value . ' start: ');
            $result = ApiTienNgay::refreshContractInfo($value);
            Log::channel('cronjob')->info('Rerun contract: ' . $value . ' result: ' . print_r($result, true));
        }
        Log::channel('cronjob')->info('RerunContract job success');
    }
}