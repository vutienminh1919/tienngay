<?php

namespace Modules\BlackList\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\BlackList\Http\Controllers\BlackListController;

class BlackList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blacklist:cronjobBlacklist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật blacklist hằng ngày';

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
        $blacklist = App::make(BlackListController::class);
        $blacklist->callAction('insertBlacklist', []);
        Log::channel('cronjob')->info('Run BlacklistInsert job success');
    }
}
