<?php

namespace Modules\AppKhachHang\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\AppKhachHang\Http\Controllers\AuthController;

class AppKhachHang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appkh:ekyc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quét ekyc app khách hàng';

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
        $ekyc = App::make(AuthController::class);
        $ekyc->callAction('checkEkyc', []);
        Log::channel('cronjob')->info('Run ekycAppkh job success');
    }
}
