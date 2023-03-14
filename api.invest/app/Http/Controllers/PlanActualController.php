<?php

namespace App\Http\Controllers;

use App\Service\ContractService;
use App\Service\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanActualController extends Controller
{
    //
    public function __construct(ContractService $contractService,
                                TransactionService $transactionService){
        $this->contractService = $contractService;
        $this->transaction_service = $transactionService;
    }

    public function getDataInvestor(Request $request){

        $data = [];
        $month = !empty($request->month) ? date('m', strtotime($request->month)) : date('m');
        $year = !empty($request->month) ? date('Y', strtotime($request->month)) : date('Y');
        $endDayMonth = $this->lastday($month, $year);
        $total_ndt_hoptac = 0;
        $total_app_ndt_nl = 0;
        $total_app_ndt_vimo = 0;
        $total_vndt = 0;
        for ($i = 0; $i < $endDayMonth; $i++) {
            $day = $i + 1;
            $day = date('d', strtotime("$year-$month-$day"));

            $data[$i]['ngay_thang'] = "$day/$month/$year";

            $startDay =  strtotime(("$year-$month-$day") . ' 00:00:00');
            $endDay = strtotime(("$year-$month-$day") . ' 23:59:59');

            //Nđt hợp tác
            $status = "UQ";
            $data[$i]['ndt_hoptac'] = $this->contractService->sumPayNdtHopTac($startDay,$endDay, $status);

            //App NĐT Ngân Lượng
            $status = "bank";
            $data[$i]['app_ndt_nl'] = $this->contractService->sumPayNdt($startDay,$endDay,$status);

            //App NĐT Vimo
            $status = "vimo";
            $data[$i]['app_ndt_vimo'] = $this->contractService->sumPayNdt($startDay,$endDay,$status);

            //Nđt hợp tác
            $status = "vndt";
            $data[$i]['vndt'] = $this->contractService->sumPayNdtHopTac($startDay,$endDay, $status);

            $total_ndt_hoptac += $data[$i]['ndt_hoptac'];
            $total_app_ndt_nl += $data[$i]['app_ndt_nl'];
            $total_app_ndt_vimo += $data[$i]['app_ndt_vimo'];
            $total_vndt += $data[$i]['vndt'];
        }

        $response = [
            'status' => Controller::HTTP_OK,
            'data' => $data,
            'total_ndt_hoptac' => $total_ndt_hoptac,
            'total_app_ndt_nl' => $total_app_ndt_nl,
            'total_app_ndt_vimo' => $total_app_ndt_vimo,
            'total_vndt' => $total_vndt,
        ];
        return response()->json($response);

    }

    function lastday($month = '', $year = '')
    {
        if (empty($month)) {
            $month = date('m');
        }
        if (empty($year)) {
            $year = date('Y');
        }
        $result = strtotime("{$year}-{$month}-01");
        $result = strtotime('-1 second', strtotime('+1 month', $result));
        return date('d', $result);
    }

    public function sumPayNdt(Request $request){
        $status = $request->status;
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $check_ndt = $request->check_ndt;

        $startDay =  strtotime(("$year-$month-$day") . ' 00:00:00');
        $endDay = strtotime(("$year-$month-$day") . ' 23:59:59');

        if ($check_ndt == 1){
            $total = $this->contractService->sumPayNdt($startDay,$endDay,$status);
        } elseif ($check_ndt == 2){
            $total = $this->contractService->sumPayNdtHopTac($startDay,$endDay,$status);
        }

        $response = [
            'status' => Controller::HTTP_OK,
            'data' => $total,
        ];
        return response()->json($response);
    }

    public function sumPayNdtActual(Request $request){
        $status = $request->status;
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $check_ndt = $request->check_ndt;

        $startDay =  date("$year-$month-$day 00:00:00");
        $endDay = date("$year-$month-$day 23:59:59");

        if ($check_ndt == 1){
            $total = $this->transaction_service->sumPayNdtActual($startDay,$endDay,$status);
        } elseif ($check_ndt == 2){
            $total = $this->transaction_service->sumPayNdtHopTacActual($startDay,$endDay,$status);
        }

        $response = [
            'status' => Controller::HTTP_OK,
            'data' => $total,
        ];
        return response()->json($response);
    }

    public function sumTransactionWallet(Request $request){
        $status = $request->status;
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;

        $startDay =  date("$year-$month-$day 00:00:00");
        $endDay = date("$year-$month-$day 23:59:59");

        $total = $this->transaction_service->sumTransactionWallet($startDay,$endDay,$status);

        $response = [
            'status' => Controller::HTTP_OK,
            'data' => $total,
        ];
        return response()->json($response);
    }

    public function sumTransactionWalletLastMonth(Request $request){

        $status = $request->status;
        $year = $request->year;
        $month = $request->month;

        $new_start = strtotime ( '-1 month' , strtotime ( "$year-$month-01" ));
        $year = date('Y', $new_start);
        $month = date('m', $new_start);
        $startDay = date("Y-m-d 00:00:00" , $new_start);
        $endDayMonth = $this->lastday($month, $year);
        $endDay = date("$year-$month-$endDayMonth 23:59:59");

        if ($request->status == "UQ"){
            $total = $this->transaction_service->sumTransactionWallet_UQ($startDay,$endDay,$status);
        } else {
            $total = $this->transaction_service->sumTransactionWallet($startDay,$endDay,$status);
        }


        $response = [
            'status' => Controller::HTTP_OK,
            'data' => $total,
        ];
        return response()->json($response);

    }



}
