<?php


namespace Modules\AssetLocation\Console\Command;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Modules\AssetLocation\Http\Service\ContractService;
use Modules\AssetLocation\Http\Service\Telegram;

class CronAlarmCheckInAddressCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:checkin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron alarm checkin address customer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContractService $contractService,
                                Request $request)
    {
        $this->contractService = $contractService;
        $this->request = $request;
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
            $this->contractService->send_alarm_contract_by_product_asset_location();
        } catch (\Exception $exception) {
            $error = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
                'Client: ' . env('APP_ENV') . "\n" .
                'Cron: ' . '"<b>' . 'CronAlarmCheckInAddressCustomer' . '</b>"' . "\n" .
                'Phát sinh lỗi: ' . '"<b>' . json_encode($error) . '</b>"' . "\n" .
                'IP: ' . '"<b>' . $this->request->ip() . '</b>"';
            Telegram::send($message_new);
        }
        return;
    }
}
