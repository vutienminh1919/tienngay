<?php
namespace Modules\VPBank\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Modules\MongodbCore\Entities\Role;
use Modules\MongodbCore\Entities\Store;
use Carbon\Carbon;

class StoreGenCode extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpbank:storeGenCode';

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
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        Log::channel('cronjob')->info('Run VPBank StoreGenCode job');
        // Lấy danh sách phòng TCVĐB
        $storeTcvdb = [];
        $roleTcvdb = Role::where(Role::SLUG, 'cong-ty-cpcn-tcv-dong-bac')->first();
        if ($roleTcvdb) {
            $storeTcvdb = $roleTcvdb->stores;
        }
        $arrStoreTcvdb = array_keys(data_get($storeTcvdb, '0', []));
        // Clear lại index
        // $store = Store::all();
        // foreach ($store as $key => $item) {
        //     Store::where('_id', $item->_id)->update([
        //         Store::VPB_STORE_CODE => 0,
        //         Store::STORE_CODE => 0
        //     ]);
        // }
        // Lấy danh sách Phòng
        $store = Store::all();
        foreach ($store as $key => $item) {
            if ( !$item->vpb_store_code ) {
                if ( in_array($item->_id, $arrStoreTcvdb) ) {
                    // Lấy số cuối cùng
                    $lastCode = Store::whereIn('_id', $arrStoreTcvdb)->orderBy(Store::STORE_CODE, "DESC")->first();
                    $numberSave = ($lastCode->store_code) ? $lastCode->store_code + 1 : 1;
                    if ( strlen($numberSave) < 3 ) {
                        $strSave =  (strlen($numberSave) == 1) ? '00'.$numberSave : '0'.$numberSave ;
                    }
                    $strSave = config('vpbank.company.tcvdb').$strSave;
                    Store::where('_id', $item->_id)->update([
                        Store::VPB_STORE_CODE => $strSave,
                        Store::STORE_CODE => $numberSave
                    ]);
                    Log::channel('cronjob')->info('Run VPBank StoreGenCode:'. $item->name. ':'. $strSave);
                    dump($item->name. ':'. $strSave);
                } else {
                    // Lấy số cuối cùng
                    $lastCode = Store::whereNotIn('_id', $arrStoreTcvdb)->orderBy(Store::STORE_CODE, "DESC")->first();
                    $numberSave = ($lastCode->store_code) ? $lastCode->store_code + 1 : 1;
                    if ( strlen($numberSave) < 3 ) {
                        $strSave =  (strlen($numberSave) == 1) ? '00'.$numberSave : '0'.$numberSave ;
                    }
                    $strSave = config('vpbank.company.tcv').$strSave;
                    Store::where('_id', $item->_id)->update([
                        Store::VPB_STORE_CODE => $strSave,
                        Store::STORE_CODE => $numberSave
                    ]);
                    Log::channel('cronjob')->info('Run VPBank StoreGenCode:'. $item->name. ':'. $strSave);
                    dump($item->name. ':'. $strSave);
                }
            }
        }
    }

}