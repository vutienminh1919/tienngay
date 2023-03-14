<?php

namespace Modules\PTI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Modules\MongodbCore\Entities\PtiBHTN;
use Jenssegers\Mongodb\Eloquent\DB;
use App;
use Modules\MongodbCore\Entities\Transaction;

class RunOrderBhtn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pti:runOrderBhtn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "order bhtn";

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
        Log::channel('cronjob')->info('Run PTI RunOrderBhtn job');
        $orders = PtiBHTN::select(PtiBHTN::ID, PtiBHTN::BANK_TRANSID) // id 
                ->where(PtiBHTN::STATUS, '=', PtiBHTN::STATUS_PAYMENTSUCCESS) // order đã được thanh toán
                ->where(PtiBHTN::TYPE, '=', PtiBHTN::TYPE_BN) // order bán ngoài
                ->get();
        if ($orders->count() < 1) {
            Log::channel('cronjob')->info('order pti is empty');
            Log::channel('cronjob')->info('Run PTI RunOrderBhtn job success');
            return;
        }
        //get only IDs value
        $ids = $orders->pluck(PtiBHTN::ID);
        $update = PtiBHTN::whereIn(PtiBHTN::ID, $ids)
                ->update([PtiBHTN::STATUS => PtiBHTN::STATUS_CALLORDER]);
        foreach ($orders as $key => $value) {
            $value = json_decode(json_encode($value), true);
            // process order
            $ptiController = App::make(\Modules\PTI\Http\Controllers\PTIBaoHiemTaiNan::class);
            Log::channel('cronjob')->info('Run PTI RunOrderBhtn run process order ' . $value[PtiBHTN::ID]);
            $ptiController->callAction('callOrderBN', [$value[PtiBHTN::ID], 'cronjob']);
        }
        Log::channel('cronjob')->info('Run PTI RunOrderBhtn job success');
    }
}