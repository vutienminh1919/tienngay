<?php


namespace Modules\Tenancy\Console\Command;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Tenancy\Http\Controllers\TenancyController;

class ThanhLyHD extends Command
{
        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:TLHDTenancy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tìm kiếm các hợp đồng đến ngày thanh lý';

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
        $toiHan = App::make(TenancyController::class);
        $toiHan->callAction('get_all_tenancy_hdtl', []);
        Log::channel('cronjob')->info('Run tenancy job success');
    }
}
