<?php

namespace Modules\PaymentGateway\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Modules\MysqlCore\Entities\MoMoApp;

class CheckTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:recheckStatus';

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
        Log::channel('cronjob')->info('Run CheckTransactionStatus job');
        $transactions = DB::table('epayment_transactions')
                ->select('contract_transaction_id') // id phiếu thu
                ->where('contract_status', '=', MoMoApp::CONTRACT_STATUS_PENDING) // phiếu thu xử lý
                ->where('status', '=', MoMoApp::TRANSACTION_SUCCESS) // đã thanh toán
                ->whereNotNull('contract_transaction_id')
                ->get();
        if ($transactions->count() < 1) {
            Log::channel('cronjob')->info('transaction is empty');
            Log::channel('cronjob')->info('Run CheckTransactionStatus job success');
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
                    DB::table('epayment_transactions')
                    ->where('contract_transaction_id', $value['transactionId'])
                    ->update(['contract_status' => 2]); // approved
                }
            }
        }
        Log::channel('cronjob')->info('Run CheckTransactionStatus job success');
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