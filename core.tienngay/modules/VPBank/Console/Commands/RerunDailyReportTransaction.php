<?php

namespace Modules\VPBank\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Modules\MysqlCore\Entities\VPBankTransaction;
use Modules\MysqlCore\Entities\VPBankDailyReport as DailyReport;
use Carbon\Carbon;

class RerunDailyReportTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpbank:rerunDailyReportTransaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Đối soát giao dịch hàng ngày với VPBank';

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
        $end = strtotime('now');
        $start = strtotime("-15 day", $end);
        while($start <= $end)
        {
            $date = date('Ymd', $start);

            Log::channel('cronjob')->info('Run VPBank DailyReportTransaction job');
            //import TCV data
            $yesterday = $date;
            $filename = $yesterday.'.VPB.THUHO.TCV.csv';
            Log::channel('cronjob')->info('Run VPBank DailyReportTransaction filename ' . $filename);
            $count = DailyReport::where(DailyReport::FILE_NAME, $filename)->count();
            $insertData = [];
            if ($count > 0) {
                Log::channel('cronjob')->info('DailyReportTransaction file has been imported: '.$filename);
            } else {
                try {
                    $fileUrl = env('VPB_MOVE_REPORT') . '/' . $filename;
                    $file_headers = get_headers($fileUrl);
                    if(strpos($file_headers[0], '404') !== false) {
                        Log::channel('cronjob')->info('DailyReportTransaction file does not exists: '.$filename);
                    } else {
                        $fileDownload = file_get_contents(env('VPB_MOVE_REPORT') . '/' . $filename);
                        file_put_contents(storage_path('app/' . $filename), $fileDownload);
                        $inputFileName = storage_path('app/' . $filename);

                        $row = 1;
                        $currentTime = Carbon::now('GMT+7')->toDateTimeString();
                        if (($handle = fopen($inputFileName, "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                $num = count($data);
                                $row++;
                                if ($row < 3) {
                                    continue;
                                }
                                if (!isset($data[1])) {
                                    continue;
                                }
                                if (isset($data[1]) && !is_numeric($data[1])) {
                                    continue;
                                }
                                $transaction = [
                                    DailyReport::FILE_NAME                  => $filename,
                                    DailyReport::VIRTUAL_ACCOUNT_NUMBER     => !empty($data[0]) ? $data[0] : "",
                                    DailyReport::AMOUNT                     => !empty($data[1]) ? $data[1] : "",
                                    DailyReport::TRANSACTION_DATE           => !empty($data[2]) ? $data[2] : "",
                                    DailyReport::BOOKING_DATE               => !empty($data[3]) ? $data[3] : "",
                                    DailyReport::TRANSACTION_ID             => !empty($data[4]) ? $data[4] : "",
                                    DailyReport::REMARK                     => !empty($data[5]) ? $data[5] : "",
                                    DailyReport::NOTIFICATION               => !empty($data[6]) ? $data[6] : "",
                                    DailyReport::STATUS                     => DailyReport::STATUS_PENDING,
                                    DailyReport::CREATED_AT                 => $currentTime,
                                    DailyReport::UPDATED_AT                 => $currentTime,
                                ];
                                $insertData[] = $transaction;
                            }
                            fclose($handle);
                        }
                        unlink($inputFileName); //delete file
                    }
                    
                } catch (Exception $e) {
                    Log::channel('cronjob')->info('Run VPBank DailyReportTransaction error ' . $e->getMessage());
                }
            }
            

            //import TCVDB data
            $yesterday = $date;
            $filename = $yesterday.'.VPB.THUHO.TCVDB.csv';
            Log::channel('cronjob')->info('Run VPBank DailyReportTransaction filename ' . $filename);
            $count = DailyReport::where(DailyReport::FILE_NAME, $filename)->count();
            if ($count > 0) {
                Log::channel('cronjob')->info('DailyReportTransaction file has been imported: '.$filename);
            } else {
                try {
                    $fileUrl = env('VPB_MOVE_REPORT') . '/' . $filename;
                    $file_headers = get_headers($fileUrl);
                    if(strpos($file_headers[0], '404') !== false) {
                        Log::channel('cronjob')->info('DailyReportTransaction file does not exists: '.$filename);
                    } else {
                        $fileDownload = file_get_contents(env('VPB_MOVE_REPORT') . '/' . $filename);
                        file_put_contents(storage_path('app/' . $filename), $fileDownload);
                        $inputFileName = storage_path('app/' . $filename);
                        $row = 1;
                        if (($handle = fopen($inputFileName, "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                $num = count($data);
                                $row++;
                                if ($row < 3) {
                                    continue;
                                }
                                if (!isset($data[1])) {
                                    continue;
                                }
                                if (isset($data[1]) && !is_numeric($data[1])) {
                                    continue;
                                }
                                $transaction = [
                                    DailyReport::FILE_NAME                  => $filename,
                                    DailyReport::VIRTUAL_ACCOUNT_NUMBER     => !empty($data[0]) ? $data[0] : "",
                                    DailyReport::AMOUNT                     => !empty($data[1]) ? $data[1] : "",
                                    DailyReport::TRANSACTION_DATE           => !empty($data[2]) ? $data[2] : "",
                                    DailyReport::BOOKING_DATE               => !empty($data[3]) ? $data[3] : "",
                                    DailyReport::TRANSACTION_ID             => !empty($data[4]) ? $data[4] : "",
                                    DailyReport::REMARK                     => !empty($data[5]) ? $data[5] : "",
                                    DailyReport::NOTIFICATION               => !empty($data[6]) ? $data[6] : "",
                                    DailyReport::STATUS                     => DailyReport::STATUS_PENDING,
                                    DailyReport::CREATED_AT                 => $currentTime,
                                    DailyReport::UPDATED_AT                 => $currentTime,
                                ];
                                $insertData[] = $transaction;
                            }
                            fclose($handle);
                        }
                        unlink($inputFileName); //delete file
                    }
                    
                } catch (Exception $e) {
                    Log::channel('cronjob')->info('Run VPBank DailyReportTransaction error ' . $e->getMessage());
                }
            }
            $start = strtotime("+1 day", $start);
            if (empty($insertData)) {
                continue;
            }
            DailyReport::insert($insertData);

            /**
            *
            * Dùng Inner join để đối soát tất cả record trong 2 bản ghi 
            * vpbank_transactions và vpbank_daily_report_transactions
            * Update trạng thái đã đối soát với cả 2 bảng với điều kiệu transactionId và amount khớp.
            *
            */
            $tranTable = 'vpbank_transactions';
            $dailyTable = 'vpbank_daily_report_transactions';
            $innerJoin = DB::table($tranTable)
                ->join($dailyTable, function ($join) use ($tranTable, $dailyTable) {
                    $join->on($tranTable.'.'.VPBankTransaction::TRANSACTION_ID, '=', $dailyTable.'.'.DailyReport::TRANSACTION_ID);
                    $join->on($tranTable.'.'.VPBankTransaction::AMOUNT, '=', $dailyTable.'.'.DailyReport::AMOUNT);
                })
                ->where($tranTable.'.'.VPBankTransaction::DAILY_CONFIRMED, '=', VPBankTransaction::CONFIRMED_PENDING)
                ->select($tranTable.'.'.VPBankTransaction::TRANSACTION_ID.' as id')
                ->get();
            $ids = $innerJoin->pluck("id");
            Log::channel('cronjob')->info('DailyReportTransaction innerjoin result: ' . print_r($ids, true));

            /**
            * Update trạng thái đối soát ở 2 bảng vpbank_transactions và vpbank_daily_report_transactions
            */
            VPBankTransaction::whereIn(VPBankTransaction::TRANSACTION_ID, $ids)
            ->update([VPBankTransaction::DAILY_CONFIRMED => VPBankTransaction::CONFIRMED_SUCCESS]);
            DailyReport::whereIn(DailyReport::TRANSACTION_ID, $ids)
            ->update([DailyReport::STATUS => DailyReport::STATUS_SUCCESS]);
            Log::channel('cronjob')->info('DailyReportTransaction updated confirmed column');

            /**
            * Lấy bản ghi còn lại chưa được đối soát ở bảng vpbank_daily_report_transactions
            * Insert các bản ghi trên vào bảng vpbank_transactions
            */
            $leftJoin = DailyReport::where(DailyReport::STATUS, DailyReport::STATUS_PENDING)
                ->get();
            Log::channel('cronjob')->info('DailyReportTransaction left result: ' . print_r($leftJoin->pluck(DailyReport::TRANSACTION_ID), true));
            $tranIdsUpdate = [];
            foreach ($leftJoin as $key => $value) {
                $tranData = [
                    VPBankTransaction::VIRTUAL_ACCOUNT_NUMBER => $value[DailyReport::VIRTUAL_ACCOUNT_NUMBER],
                    VPBankTransaction::AMOUNT => $value[DailyReport::AMOUNT],
                    VPBankTransaction::REMARK => $value[DailyReport::REMARK],
                    VPBankTransaction::TRANSACTION_ID => $value[DailyReport::TRANSACTION_ID],
                    VPBankTransaction::TRANSACTION_DATE => $value[DailyReport::TRANSACTION_DATE],
                    VPBankTransaction::BOOKING_DATE => $value[DailyReport::BOOKING_DATE],
                    VPBankTransaction::DAILY_CONFIRMED => VPBankTransaction::CONFIRMED_ADDITIONAL,
                ];
                $transaction = VPBankTransaction::create($tranData);
                Log::channel('cronjob')->info('DailyReportTransaction add record to vpbank_transactions table: ' . $transaction->id);
                $tranIdsUpdate[] = $value[DailyReport::TRANSACTION_ID];

            }
            /**
            * Cập nhật trạng thái status các bản ghi đã thêm vào vpbank_transactions
            */
            DailyReport::whereIn(DailyReport::TRANSACTION_ID, $tranIdsUpdate)
                ->update([DailyReport::STATUS => DailyReport::STATUS_SUCCESS]);
            Log::channel('cronjob')->info('DailyReportTransaction updated vpbank_daily_report_transactions status column');
            Log::channel('cronjob')->info('Run VPBank DailyReportTransaction job success');
        }
        
    }

}