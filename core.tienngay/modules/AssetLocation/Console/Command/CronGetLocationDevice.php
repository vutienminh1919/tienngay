<?php


namespace Modules\AssetLocation\Console\Command;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\AssetLocation\Http\Service\DeviceService;
use Modules\AssetLocation\Http\Service\Telegram;

class CronGetLocationDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:device';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron location device';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DeviceService $deviceService,
                                Request $request)
    {
        $this->deviceService = $deviceService;
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
            $this->deviceService->check_status_device_active();
        } catch (\Exception $exception) {
            $error = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
                'Client: ' . env('APP_ENV') . "\n" .
                'Cron: ' . '"<b>' . 'CronGetLocationDevice' . '</b>"' . "\n" .
                'Phát sinh lỗi: ' . '"<b>' . json_encode($error) . '</b>"' . "\n" .
                'IP: ' . '"<b>' . $this->request->ip() . '</b>"';
            Telegram::send($message_new);
        }
        return;
    }
}
