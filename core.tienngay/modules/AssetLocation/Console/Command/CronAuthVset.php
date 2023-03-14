<?php


namespace Modules\AssetLocation\Console\Command;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\AssetLocation\Http\Service\AccountVsetService;
use Modules\AssetLocation\Http\Service\Telegram;

class CronAuthVset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vset:auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron auth vset';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AccountVsetService $accountVsetService,
                                Request $request)
    {
        $this->accountVsetService = $accountVsetService;
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
            $this->accountVsetService->auth();
        } catch (\Exception $exception) {
            $error = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
                'Client: ' . env('APP_ENV') . "\n" .
                'Cron: ' . '"<b>' . 'CronAuthVset' . '</b>"' . "\n" .
                'Phát sinh lỗi: ' . '"<b>' . json_encode($error) . '</b>"' . "\n" .
                'IP: ' . '"<b>' . $this->request->ip() . '</b>"';
            Telegram::send($message_new);
        }
        return;
    }
}
