<?php


namespace Modules\CtvTienNgay\Console\Command;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\AssetLocation\Http\Service\Telegram;
use Modules\CtvTienNgay\Http\Controllers\DonVayController;
use Modules\CtvTienNgay\Service\ConfigService;
use Modules\MongodbCore\Entities\Lead;

class CronUpdateStatusLead extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron check update status lead';

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
        try {
            $get_all = Lead::whereNotNull('ctv_code')->get();
            DonVayController::insertDB_lead($get_all);
        } catch (\Exception $exception) {
            $error = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
                'Client: ' . env('APP_ENV') . "\n" .
                'Cron: ' . '"<b>' . 'CronUpdateStatusLead' . '</b>"' . "\n" .
                'Phát sinh lỗi: ' . '"<b>' . json_encode($error) . '</b>"';
            Telegram::send($message_new);
        }
        return;
    }
}
