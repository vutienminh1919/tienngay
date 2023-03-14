<?php

namespace Modules\PaymentGateway\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Modules\MysqlCore\Entities\Reconciliation;
use Modules\MysqlCore\Entities\MoMoApp;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CURLFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SendTransactionReconciliationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reconciliation:sendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send transactions reconciliation email to momo';

    protected $reconciliationModel;
    protected $momoAppModel;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Reconciliation $reconciliation, MoMoApp $momoApp)
    {
        parent::__construct();
        $this->reconciliationModel = $reconciliation;
        $this->momoAppModel = $momoApp;
    }

    /**
     * Execute the console command.
     *
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        Log::channel('cronjob')->info('Run SendTransactionReconciliationEmail job');
        $reconciliations = DB::table($this->reconciliationModel->getTableName())
                ->whereNull($this->reconciliationModel::DELETED_AT)
                ->where($this->reconciliationModel::STATUS, '=', $this->reconciliationModel::STATUS_SENDEMAIL)
                ->get();

        foreach ($reconciliations as $key => $reconciliation) {
            $reconciliation = (array)$reconciliation;
            Log::channel('cronjob')->info('sending reconciliation email: '. $reconciliation["id"]);
            $select = DB::raw(
                "*, (CASE 
                    WHEN status = '". $this->momoAppModel::TRANSACTION_PENDING . "' THEN 'Chưa thanh toán'
                    WHEN status = '". $this->momoAppModel::TRANSACTION_SUCCESS . "' THEN 'Đã thanh toán'
                    ELSE 'Không xác định'
                END) AS status_text"
            );
            $transactions = $this->momoAppModel::select($select)
            ->where(
                $this->momoAppModel::TRANSACTION_RECONCILIATION_ID, $reconciliation["id"]
            )
            ->get();

            $attachPath = $this->getAttachFileUrl($reconciliation, $transactions);
            if (!$attachPath) {
                Log::channel('cronjob')->info('Upload file failed '. $attachPath);
                return false;
            }
            $result = $this->sendEmail($attachPath, $transactions->count(), $reconciliation);
            if ($result["status"] == Response::HTTP_OK) {
                $reconciliation = DB::table($this->reconciliationModel->getTableName())
                ->where('id', '=', $reconciliation["id"])
                ->update([
                    $this->reconciliationModel::STATUS => $this->reconciliationModel::STATUS_PENDING,
                ]);
                Log::channel('cronjob')->info('Update reconciliation status'. $reconciliation["id"] . ' success');
            } else {
                Log::channel('cronjob')->info('Update reconciliation status'. $reconciliation["id"] . ' failed');
            }
            
        }

        Log::channel('cronjob')->info('Run CheckTransactionStatus job success');
    }

    protected function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('API_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('API_URL_PROD') . '/' . $path;
        } else {
            return env('API_URL_LOCAL') . '/' . $path;
        }
    }

    protected function getAttachFileUrl($reconciliationInfo, $transactions) {
        Log::channel('cronjob')->info('reconciliationInfo: '. print_r($reconciliationInfo, true));
        Log::channel('cronjob')->info('transactions: '. print_r($transactions, true));
        $excelHead = ' <tr style="text-align: center">
                                <th style="text-align: center;">STT</th>
                                <th style="text-align: center;">Mã GD</th>
                                <th style="text-align: center">Số Tiền GD</th>
                                <th style="text-align: center">Khách Hàng</th>
                                <th style="text-align: center">Mã HĐ</th>
                                <th style="text-align: center">Thời Gian GD</th>
                                <th style="text-align: center">Phí GD</th>
                                <th style="text-align: center">TT Thanh Toán</th>
                            </tr>';
        $excelContent = '';
        $count = 1;
        foreach ($transactions->toArray() as $key => $value) {
            $excelContent .= '<tr>
                                <td style="text-align: left;" data-attr="transaction_no">' . $count . '</td>
                                <td data-attr="transactionId">' . $value['transactionId'] . '</td>
                                <td data-attr="paid_amount">' . $value['paid_amount'] . '</td>
                                <td data-attr="name">' . $value['name'] . '</td>
                                <td data-attr="contract_code_disbursement">' . $value['contract_code_disbursement'] . '</td>
                                <td data-attr="paid_date">' . $value['paid_date'] . '</td>
                                <td data-attr="transaction_fee">' . $value['transaction_fee'] . '</td>
                                <td data-attr="status">' . $value['status_text'] . '</td>
                            </tr>';
                            $count++;
        }
        $htmlstr = '<table id="data-table" class="table table-striped">
                        <thead>
                           ' . $excelHead . '
                        </thead>
                        <tbody align="center" id="listingTable">
                            ' . $excelContent . '
                        </tbody>
                    </table>';
        
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($htmlstr);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $file_name = $reconciliationInfo['code'].'_'.time().'.xls';
        $path = storage_path('app/public/' . $file_name);
        $writer->save($path);
        chown($path, "apache");
        chmod($path, 0777);
        $cfile = new CURLFile($path, 'xls', $file_name);
        $serviceUpload = env("URL_SERVICE_UPLOAD");
        Log::channel('cronjob')->info('Service Upload URL: '. print_r($serviceUpload, true));
        Log::channel('cronjob')->info('File Path1: '. print_r($path, true));
        Log::channel('cronjob')->info('cfile: '. print_r($cfile, true));
        $post = array('avatar' => $cfile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $serviceUpload);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result1 = json_decode($result, true);
        Log::channel('cronjob')->info('File Excel URL: '. print_r($result1, true));
        if(isset($result1['path'])) {
            unlink($path); //delete file
            return $result1['path'];
        }
        return false;
    }

    protected function sendEmail($attachPath, $transactionsCount, $reconciliation) {
        $dataPost = [
            "code" => $reconciliation['code'],
            "payAmount" => $reconciliation['pay_amount'],
            "transactionsNumber" => $transactionsCount,
            "attachPath" => $attachPath,
            "momoEmail" => env("MOMO_EMAIL")
        ];

        $url = $this->getApiUrl('transaction/sendEmailMomo');

        Log::channel('cronjob')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::channel('cronjob')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return $result;
    }
}