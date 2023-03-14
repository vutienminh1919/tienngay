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

class MasterPaymentProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpbank:masterPaymentProcess';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "create transaction of other payment";

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
        $startTime = date('Y-m-d H:i:s', strtotime('now') - 300); //current time - 5p
        Log::channel('cronjob')->info('Run VPBank MasterPaymentProcess job');
        $transactions = DB::table('vpbank_transactions')
                ->select(VPBankTransaction::ID, VPBankTransaction::TRANSACTION_ID) // id phiếu thu, bank_code
                ->where(VPBankTransaction::STATUS, '=', VPBankTransaction::STATUS_PENDING) // phiếu thu xử lý
                ->where(VPBankTransaction::TRAN_STATUS, '=', VPBankTransaction::TRAN_STATUS_ACTIVE) // đã thanh toán
                ->whereNotNull(VPBankTransaction::MASTER_ACCOUNT_NUMBER) // không rỗng master account number
                ->where(VPBankTransaction::VIRTUAL_ACCOUNT_NUMBER, '=', '') //null van
                ->whereNull(VPBankTransaction::TN_TRANCODE) // giao dịch chưa tạo phiếu thu
                ->where(VPBankTransaction::CREATED_AT, '>', $startTime)
                ->whereNull(VPBankTransaction::DELETED_AT) // not include trashed
                ->where(VPBankTransaction::RUN_PAYMENT, '=', VPBankTransaction::RUN_PAYMENT_PENDING) // not payment yet!
                ->get();
        if ($transactions->count() < 1) {
            Log::channel('cronjob')->info('transactions is empty');
            Log::channel('cronjob')->info('Run VPBank MasterPaymentProcess job success');
            return;
        }
        //get only IDs value
        $ids = $transactions->pluck(VPBankTransaction::ID);
        $update = DB::table('vpbank_transactions')
                ->whereIn(VPBankTransaction::ID, $ids)
                ->update([VPBankTransaction::RUN_PAYMENT => VPBankTransaction::RUN_PAYMENT_SUCCESS]);
        foreach ($transactions as $key => $value) {
            $value = json_decode(json_encode($value), true);
            // process payment
            $vpController = App::make(\Modules\VPBank\Http\Controllers\VPBankController::class);
            Log::channel('cronjob')->info('Run VPBank MasterPaymentProcess run process payment ' . $value[VPBankTransaction::ID]);
            $vpController->callAction('masterPaymentProcess', [$value[VPBankTransaction::ID], 'cronjob']);
        }
        Log::channel('cronjob')->info('Run VPBank MasterPaymentProcess job success');
    }

}