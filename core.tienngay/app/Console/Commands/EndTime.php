<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Entities\KsnbCodeError;
use Modules\MongodbCore\Entities\ReportsKsnb;
use App;
use Modules\ReportsKsnb\Http\Controllers\ReportsKsnbController;

class EndTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportksnb:endtime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cập nhật trạng thái sau 3 ngày  nv vi phạm không phản hồi biên bản';

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
        $endTime = App::make(ReportsKsnbController::class);
        $endTime->callAction('endTime', ['cronjob']);
        Log::channel('cronjob')->info('Run endTime job success');
    }
}
