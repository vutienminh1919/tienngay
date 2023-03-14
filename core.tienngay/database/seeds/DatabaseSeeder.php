<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $listStore = DB::connection('mongodb')->collection('store')
        	->where('status', 'active')->get();
        $countTCV = 0;
        $countTCVDB = 0;
        foreach ($listStore->toArray() as $key => $value) {
            $isTCVDB = DB::connection('mongodb')->collection('role')
                ->where('status', 'active')
                ->where('slug', 'cong-ty-cpcn-tcv-dong-bac')
                ->where("stores." . $value['_id'], 'exists', true)
                ->first();
            if ($isTCVDB) {
            	$countTCVDB++;
            	$code = "00015" . str_pad($countTCVDB, 3, "0", STR_PAD_LEFT);
            } else {
            	$countTCV++;
            	$code = "00012" . str_pad($countTCV, 3, "0", STR_PAD_LEFT);
            }

            DB::connection('mongodb')->collection('store')
            ->where('status', 'active')
            ->where('vpb_store_code', 'exists', false)
            ->where('_id', $value['_id'])
            ->update(['vpb_store_code' => $code], ['upsert' => true]);
            //->unset('vpb_store_code');
        }
    }
}
