<?php

namespace Modules\Marketing\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Marketing\Http\Controllers\TradeInventoryController;

class ForControlReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade:forControl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Đối soát báo cáo tồn kho hàng tháng';

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
        $blacklist = App::make(TradeInventoryController::class);
        $blacklist->callAction('forControlStorageReport', []);
        Log::channel('cronjob')->info('Run forControlStorageReport job success');
    }
}
