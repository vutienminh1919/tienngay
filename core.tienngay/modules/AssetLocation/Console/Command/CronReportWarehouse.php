<?php


namespace Modules\AssetLocation\Console\Command;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Modules\AssetLocation\Http\Service\DeviceService;
use Modules\AssetLocation\Http\Service\Telegram;
use Modules\AssetLocation\Http\Service\WarehouseService;

class CronReportWarehouse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:warehouse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron report warehouse';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DeviceService $deviceService,
                                Request $request,
                                WarehouseService $warehouseService)
    {
        $this->deviceService = $deviceService;
        $this->request = $request;
        $this->warehouseService = $warehouseService;
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
            $this->warehouseService->report_warehouse();
        } catch (\Exception $exception) {
            $error = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
                'Client: ' . env('APP_ENV') . "\n" .
                'Cron: ' . '"<b>' . 'CronGetLocationDevice' . '</b>"' . "\n" .
                'Phát sinh lỗi: ' . '"<b>' . $error . '</b>"' . "\n" .
                'IP: ' . '"<b>' . $this->request->ip() . '</b>"';
            Telegram::send($message_new);
        }
        return;
    }
}
