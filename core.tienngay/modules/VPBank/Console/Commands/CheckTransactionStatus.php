<?php

namespace Modules\VPBank\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Modules\MysqlCore\Entities\VPBankTransaction;

class CheckTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpbank:recheckTranStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recheck contract_status of transaction';

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
        Log::channel('cronjob')->info('Run VPBank CheckTransactionStatus job');
        $transactions = DB::table('vpbank_transactions')
                ->select(VPBankTransaction::TN_TRANSACTIONID . ' as contract_transaction_id') // id phiếu thu
                ->where(VPBankTransaction::STATUS, '=', VPBankTransaction::STATUS_PENDING) // phiếu thu xử lý
                ->where(VPBankTransaction::TRAN_STATUS, '=', VPBankTransaction::TRAN_STATUS_ACTIVE) // đã thanh toán
                ->whereNotNull(VPBankTransaction::TN_TRANSACTIONID)
                ->get();
        if ($transactions->count() < 1) {
            Log::channel('cronjob')->info('transaction is empty');
            Log::channel('cronjob')->info('Run VPBank CheckTransactionStatus job success');
            return;
        }
        $url = $this->getApiUrl('transaction/check_transactions_status');
        $dataPost = [
            'transactionIds' => $transactions->toArray(),
        ];
        Log::channel('cronjob')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::channel('cronjob')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if(!empty($result) && $result['status'] == Response::HTTP_OK) {
            foreach ($result['data'] as $key => $value) {
                if ($value['status'] == 1) {
                    DB::table('vpbank_transactions')
                    ->where(VPBankTransaction::TN_TRANSACTIONID, $value['transactionId'])
                    ->update([VPBankTransaction::STATUS => VPBankTransaction::STATUS_SUCCESS]); // approved
                }
            }
        }
        Log::channel('cronjob')->info('Run VPBank CheckTransactionStatus job success');
    }

    protected function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('API_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('API_URL_PROD') . '/' . $path;
        } else {
            return env('API_URL_LOCAL') . '/' . $path;
        }
    }
}