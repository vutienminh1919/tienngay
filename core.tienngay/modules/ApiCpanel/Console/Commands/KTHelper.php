<?php
namespace Modules\ApiCpanel\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Modules\MongodbCore\Entities\Contract;
use Modules\MongodbCore\Entities\Transaction;
use Modules\ApiCpanel\Excel\ImportKT;

class KTHelper extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kthelper:rerun';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gen mã phòng giao dịch cho VPBank';

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
     * @return mixed
     */
    public function handle()
    {
        $count = 0;
        $client = new \GuzzleHttp\Client();
        $data = Excel::toArray(new ImportKT, storage_path('kthelper/rerun.xlsx'));
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
                        dump($code);
                        $count++;
                    }
                }
            }
        }
        return dump($count);
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

}
