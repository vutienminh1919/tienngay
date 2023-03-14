<?php

namespace Modules\Marketing\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Marketing\Http\Controllers\TradeOrderController;

class CloseRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade:closeRequest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Đóng các request chưa hoàn tất';

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
        $tradeOrder = App::make(TradeOrderController::class);
        $tradeOrder->callAction('closeRequest', ['cronjob']);
    }
}
