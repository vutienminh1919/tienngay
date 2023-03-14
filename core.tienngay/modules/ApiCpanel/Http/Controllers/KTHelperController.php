<?php

namespace Modules\ApiCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ApiCpanel\Excel\ImportKT;
use Modules\MongodbCore\Entities\Contract;
use Modules\MongodbCore\Entities\Transaction;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KTHelperController extends BaseController
{

    public function import_20_11_2021(Request $request)
    {
        $count = 0;
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        if ($request->file('file')) {
            $data = Excel::toArray(new ImportKT, $request->file);
            $dataList = data_get($data, '0', []);
            foreach ($dataList as $key => $item) {
                if ($key == 0) continue;
//                if ($key == 20) break;
                $code = data_get($item, '1');
                $total = data_get($item, '5');
                $transaction = Transaction::where('code', $code)->first();
                $codeContract = data_get($transaction, 'code_contract');
                $contract = Contract::where('code_contract', $codeContract)->first();
                if ($transaction && $contract) {
                    // Cập nhật lại
                    $transaction->total = $total;
                    Transaction::where('code', $code)->update([
                        'total' => $total
                    ]);

                    // Chạy lại thanh toán
                    $request = Http::post(env('API_URL_STAGE').'/payment/payment_all_contract', [
                        'id_contract' => data_get($contract, '_id')
                    ]);
                    if ($request->status() == 200) {
                        var_dump($code);
                        $count++;
                    }
                }
            }
        }

        return 'Count success: '. $count;
    }

    public function import_23_11_2021(Request $request)
    {
        $count = 0;
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            'field' => 'required',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        if ($request->file('file')) {
            $data = Excel::toArray(new ImportKT, $request->file);
            $dataList = data_get($data, '0', []);
            foreach ($dataList as $key => $item) {
                if ($key == 0) continue;
                $code = data_get($item, '1');
                $transaction = Transaction::where('code', $code)->first();
                if ($transaction) {
                    $type = $request->get('type');
                    // Date
                    if ($type == 'date') {
                        $date_bank = Date::excelToDateTimeObject(data_get($item, '2'))->format('d/m/Y');
                        $date_bank_carbon = Carbon::createFromFormat('d/m/Y', $date_bank); // Cập nhật lại
                        Transaction::where('code', $code)->update([
                            $request->get('field') => $date_bank_carbon->getTimestamp()
                        ]);
                    }
                    // String
                    if ($type == 'string') {
                        Transaction::where('code', $code)->update([
                            $request->get('field') => (string) data_get($item, '2')
                        ]);
                    }
                    // Number
                    if ($type == 'string') {
                        Transaction::where('code', $code)->update([
                            $request->get('field') => (int) data_get($item, '2')
                        ]);
                    }
                    $count++;
                    var_dump($code);
                }
            }
        }
        return 'Count success: '. $count;
    }

    public function import_25_11_2021(Request $request) {
        $count = 0;
        $client = new \GuzzleHttp\Client();
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        if ($request->file('file')) {
            $data = Excel::toArray(new ImportKT, $request->file);
            $dataList = data_get($data, '0', []);
            foreach ($dataList as $key => $item) {
                if ($key == 0) continue;
                // if ($key > 10) break;
                $code = data_get($item, '0');
                // check lại
                $contract = Contract::where('code_contract', $code)->first();
                if ($contract) {
                    // Chạy lại thanh toán
                    $response = $client->request('POST', $this->getApiUrl('payment/payment_all_contract'), [
                        'form_params' => [
                            'id_contract' => (string) data_get($contract, '_id')
                        ]
                    ]);
                    if ($response->getStatusCode() == 200) {
                        $data_res = json_decode($response->getBody(), true);
                        if (isset($data_res['status']) && $data_res['status'] == 200) {
                            var_dump($code);
                            $count++;
                        }
                    }
                }
            }
        }
        return 'Count success: '. $count;
    }
}
