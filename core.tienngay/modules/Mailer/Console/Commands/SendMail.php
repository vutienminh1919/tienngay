<?php

namespace Modules\Mailer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use App;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailer:sendMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "send mail action";

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
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $mailController = App::make(\Modules\Mailer\Http\Controllers\MailController::class);
        $mailController->callAction('sendWaitingMails', ['cronjob-mailer']);
    }

}