<?php

namespace Modules\PaymentGateway\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Modules\MongodbCore\Entities\BankTransaction;
use Modules\MysqlCore\Entities\Reconciliation;

class CheckMomoTransactionInBank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:checkMomoTransactionInBank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recheck Momo transaction reconciliation';

    protected $reconciliationModel;
    protected $bankTransactionModel;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Reconciliation $reconciliation, BankTransaction $bankTransaction)
    {
        parent::__construct();
        $this->reconciliationModel = $reconciliation;
        $this->bankTransactionModel = $bankTransaction;
    }

    /**
     * Execute the console command.
     *
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        Log::channel('cronjob')->info('CheckMomoTransactionInBank job starting');
       $reconciliations = DB::table($this->reconciliationModel->getTableName())
                ->whereNull($this->reconciliationModel::DELETED_AT)
                ->where($this->reconciliationModel::STATUS, '=', $this->reconciliationModel::STATUS_PENDING)
                ->get();

        foreach ($reconciliations as $key => $reconciliation) {
            $reconciliation = (array)$reconciliation;
            Log::channel('cronjob')->info('CheckMomoTransactionInBank reconciliationId' .  $reconciliation["id"]);
            $bankTransaction = $this->bankTransactionModel::where(
                $this->bankTransactionModel::TYPE, '=', $this->bankTransactionModel::TYPE_MOMO_RECONCILIATION
            )->where(
                $this->bankTransactionModel::CONTENT, 'like', '%' . $reconciliation["code"] . '%'
            )->first();
            Log::channel('cronjob')->info('bankTransaction search' .  print_r($bankTransaction, true));
            if ($bankTransaction) {
                if ($bankTransaction["money"] < $reconciliation["pay_amount"]) {
                    $status = $this->reconciliationModel::STATUS_UNDERPAYMENT;
                } else if ($bankTransaction["money"] > $reconciliation["pay_amount"]) {
                    $status = $this->reconciliationModel::STATUS_OVERPAYMENT;
                } else {
                    $status = $this->reconciliationModel::STATUS_SUCCESS;
                }
                $date = date("Y-m-d H:s:i", $bankTransaction["date"]);
                $updateData = [
                    $this->reconciliationModel::STATUS => $status,
                    $this->reconciliationModel::PAID_AMOUNT => $bankTransaction["money"],
                    $this->reconciliationModel::PAID_DATE => $date,
                    $this->reconciliationModel::UPDATED_BY => "System",
                ];
                $reconciliation = DB::table($this->reconciliationModel->getTableName())
                ->where('id', '=', $reconciliation["id"])
                ->update($updateData);
                Log::channel('cronjob')->info('Update reconciliation info'. print_r($updateData, true));
                Log::channel('cronjob')->info('Update reconciliation status'. $reconciliation["id"] . ' success');
            } else {
                Log::channel('cronjob')->info('Update reconciliation status'. $reconciliation["id"] . ' failed');
            }
            
        }

    }
}