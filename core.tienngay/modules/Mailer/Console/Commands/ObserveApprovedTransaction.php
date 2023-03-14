<?php

namespace Modules\Mailer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use App;
use Modules\MongodbCore\Entities\Transaction;
use Modules\MysqlCore\Entities\Mail;

class ObserveApprovedTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailer:ObserveApprovedTransaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "sent mail to the related people when there is approved transaction";

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
        var_dump("Case1: Những phiếu thu tạo mới.");
        $newTrans = Transaction::whereIn(Transaction::TYPE_PAYMENT, [
            Transaction::TYPE_PAYMENT_TERM,
            Transaction::TYPE_PAYMENT_GH,
            Transaction::TYPE_PAYMENT_CC,
        ])
        ->whereIn(Transaction::PAYMENT_METHOD, [
            (int)Transaction::PAYMENT_METHOD_CASH,
            (int)Transaction::PAYMENT_METHOD_INTERNET_BANKING,
            (string)Transaction::PAYMENT_METHOD_CASH,
            (string)Transaction::PAYMENT_METHOD_INTERNET_BANKING,
            Transaction::PAYMENT_METHOD_NGAN_LUONG,
        ])
        ->where(Transaction::STATUS, '!=', Transaction::STATUS_CANCLED)
        ->where(Transaction::CREATED_AT, '>', time() - (5 * 60)) // lấy giao dịch 5p đổ lại
        ->where(Transaction::STATUS_EMAIL, 'exists', false)
        ->get();

        $this->sentEmail($newTrans);
        var_dump("Case2: Những phiếu thu đang chờ duyệt.");
        $waitingTrans = Transaction::where(Transaction::STATUS_EMAIL, '=', Transaction::STATUS_EMAIL_WAITING)
        ->whereIn(Transaction::PAYMENT_METHOD, [
            (int)Transaction::PAYMENT_METHOD_CASH,
            (int)Transaction::PAYMENT_METHOD_INTERNET_BANKING,
            (string)Transaction::PAYMENT_METHOD_CASH,
            (string)Transaction::PAYMENT_METHOD_INTERNET_BANKING,
            Transaction::PAYMENT_METHOD_NGAN_LUONG,
        ])
        ->whereIn(Transaction::STATUS, [
            Transaction::STATUS_SUCCESS,
            Transaction::STATUS_RETURNED,
            Transaction::STATUS_CANCLED
        ])
        ->whereIn(Transaction::TYPE_PAYMENT, [
            Transaction::TYPE_PAYMENT_TERM,
            Transaction::TYPE_PAYMENT_GH,
            Transaction::TYPE_PAYMENT_CC,
        ])->get();

        $this->sentEmail($waitingTrans);

        var_dump("Case3: Những phiếu thu đã từng gửi email nhưng thay đổi lại trạng thái.");
    }

    /**
     * Sent Email Process 
     * @param array $trans
     */
    public function sentEmail($trans) {
        $mailController = App::make(\Modules\Mailer\Http\Controllers\MailController::class);
        foreach($trans as $tran) {
            if ($tran[Transaction::STATUS] == Transaction::STATUS_SUCCESS) {
                $subject = 'Thông Báo Phiếu Thu Được Duyệt Thành Công';
                $tranStatus = 'đã được duyệt thành công';
            } else if ($tran[Transaction::STATUS] == Transaction::STATUS_CANCLED) {
                $subject = 'Thông Báo Phiếu Thu Bị Hủy';
                $tranStatus = 'bị hủy';
            } else if ($tran[Transaction::STATUS] == Transaction::STATUS_RETURNED) {
                $subject = 'Thông Báo Phiếu Thu Bị Trả Về';
                $tranStatus = 'bị trả về';
            } else {
                if (!isset($tran[Transaction::STATUS_EMAIL])) {
                    // update waiting sent email status
                    $update = Transaction::where(Transaction::CODE, '=', $tran[Transaction::CODE])
                    ->update([Transaction::STATUS_EMAIL => Transaction::STATUS_EMAIL_WAITING]);
                    continue;
                } else {
                    
                }
            }
            $emailTo = explode(',', env('OBSERVE_APPROVED_TRANSACTION_EMAIL'));
            $emailTo[] = $tran[Transaction::CREATED_BY];
            $emailTo = array_unique($emailTo);
            
            foreach($emailTo as $email) {
                $toEmail = $email;
                $message = view('mailer::observeApprovedTransaction', [
                    'toEmail' => $toEmail,
                    'code' => $tran[Transaction::CODE],
                    'status' => $tranStatus,
                    'codeContract' => $tran[Transaction::CODE_CONTRACT_DISBURSEMENT],
                    'name' => $tran[Transaction::CUSTOMER_NAME],
                    'paidAmount' => number_format($tran[Transaction::TOTAL]),
                    'paymentMethod' => Transaction::getTypePaymentName($tran[Transaction::TYPE_PAYMENT], $tran[Transaction::TYPE]),
                    'paidDate' => date('d-m-Y', $tran[Transaction::DATE_PAY]),
                    'createdAt' => date('d-m-Y', $tran[Transaction::CREATED_AT]),
                    'createdBy' => $tran[Transaction::CREATED_BY]
                ]);
                
                // push email to queue
                $mailController->callAction('queueEmail', [$subject, $message, Mail::TYPE_OBSERVE_APPROVED_TRANSACTION, $toEmail]);
            }
            // update send email success status
            $update = Transaction::where(Transaction::CODE, '=', $tran[Transaction::CODE])
            ->update([
                Transaction::STATUS_EMAIL => Transaction::STATUS_EMAIL_SEND
            ]);
        }
    }
}