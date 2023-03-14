<?php

namespace Modules\Tenancy\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Tenancy\Http\Controllers\PaymentPeriodController;

class Tenancy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:sendmailqh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tìm kiếm hợp đồng quá hạn hằng ngày';

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
        $quaHan = App::make(PaymentPeriodController::class);
        $quaHan->callAction('send_mail_qua_han', []);
        Log::channel('cronjob')->info('Run tenancy job success');
    }
}

