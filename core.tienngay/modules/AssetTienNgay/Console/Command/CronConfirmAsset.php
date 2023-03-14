<?php


namespace Modules\AssetTienNgay\Console\Command;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\AssetLocation\Http\Service\Telegram;
use Modules\AssetTienNgay\Http\Service\SuppliesService;
use Modules\AssetTienNgay\Model\SuppliesAsset;

class CronConfirmAsset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'confirm:asset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron confirm asset';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SuppliesService $suppliesService)
    {
        $this->suppliesService = $suppliesService;
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
            $start = Carbon::now()->subDays(7)->format('Y-m-d 00:00:00');
            $end = Carbon::now()->subDays(7)->format('Y-m-d 23:59:59');
            $assets = SuppliesAsset::where('status', 4)
                ->whereNotNull('status_receive')
                ->whereBetween('date_receive', [strtotime($start), strtotime($end)])
                ->get();
            foreach ($assets as $asset) {
                $this->suppliesService->cron_office_confirm($asset['_id']);
                echo $asset['_id'] . "\n";
            }
        } catch (\Exception $exception) {
            $error = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
                'Client: ' . env('APP_ENV') . "\n" .
                'Cron: ' . '"<b>' . 'CronConfirmAsset' . '</b>"' . "\n" .
                'Phát sinh lỗi: ' . '"<b>' . $error . '</b>"' . "\n" .
                'IP: ' . '"<b>' . $this->request->ip() . '</b>"';
            Telegram::send($message_new);
        }
        return;
    }
}
