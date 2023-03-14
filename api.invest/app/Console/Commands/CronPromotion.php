<?php


namespace App\Console\Commands;


use App\Service\ContractService;
use App\Service\TelegramBot;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class CronPromotion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:promotion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron promotion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContractService $contractService,
                                Request $request,
                                TelegramBot $telegramBot)
    {
        parent::__construct();
        $this->contractService = $contractService;
        $this->request = $request;
        $this->telegrambot = $telegramBot;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->contractService->get_contract_by_promotions();
        } catch (\Exception $exception) {
            $env = env('APP_ENV');
            $uri = $this->request->getRequestUri();
            $message = [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
            ];
            $this->telegrambot->sendError($env, $uri, json_encode($message), '');
        }
    }
}
