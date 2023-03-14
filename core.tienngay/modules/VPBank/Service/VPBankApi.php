<?php

namespace Modules\VPBank\Service;

class VPBankApi
{

    /**
    *
    * VAN (000XX000000-000XX999999)
    */
    public function apiCreateVituarlAccount($data, $tcvdb = false) {

        // MainAccInfo
        $mainAccInfo = collect([]);
        $mainAccInfo->put('mainCustomerNo', data_get($data, 'mainCustomerNo'));
        $mainAccInfo->put('mainAcctNo', data_get($data, 'mainAcctNo'));
        $mainAccInfo->put('partner', data_get($data, 'partner'));
        $mainAccInfo->put('partnerCode', data_get($data, 'partnerCode'));
        // VirtualAccInfo
        $virtualAccInfo = collect([]);
        $virtualAccInfo->put('virtualAccName', data_get($data, 'virtualAccName'));
        $virtualAccInfo->put('virtualAccNo', data_get($data, 'virtualAccNo'));
        $virtualAccInfo->put('virtualMobile', data_get($data, 'virtualMobile'));
        $virtualAccInfo->put('virtualGroup', data_get($data, 'virtualGroup'));
        $virtualAccInfo->put('virtualAltKey', data_get($data, 'virtualAltKey'));
        $virtualAccInfo->put('status', data_get($data, 'status'));
        if ( data_get($data, 'openDate') != null  ) {
            $virtualAccInfo->put('openDate', data_get($data, 'openDate'));
        }
        if ( data_get($data, 'valueDate') != null  ) {
            $virtualAccInfo->put('valueDate', data_get($data, 'valueDate'));
        }
        if ( data_get($data, 'expiryDate') != null  ) {
            $virtualAccInfo->put('expiryDate', data_get($data, 'expiryDate'));
        }
        // Data
        $data = collect([]);
        $data->put("mainAccInfo", $mainAccInfo);
        $data->put("virtualAccInfo", $virtualAccInfo);
        // Call API
        // dd($data->toArray());
        $response = ApiCall::post(
            '/virtual-account/v1.0/create', 
            $data->toArray(), 
            ['Content-Type: application/json'], 
            $tcvdb
        );
        
        return $response;
    }

    public function apiUpdateVituarlAccount($data, $tcvdb = false) {
        // MainAccInfo
        $mainAccInfo = collect([]);
        $mainAccInfo->put('partner', data_get($data, 'partner'));
        // VirtualAccInfo
        $virtualAccInfo = collect([]);
        $virtualAccInfo->put('virtualAccId', data_get($data, 'virtualAccId'));
        if ( data_get($data, 'virtualAccName') != null  ) {
            $virtualAccInfo->put('virtualAccName', data_get($data, 'virtualAccName'));
        }
        if ( data_get($data, 'virtualAltKey') != null  ) {
            $virtualAccInfo->put('virtualAltKey', data_get($data, 'virtualAltKey'));
        }
        if ( data_get($data, 'status') != null  ) {
            $virtualAccInfo->put('status', data_get($data, 'status'));
        }
        if ( data_get($data, 'valueDate') != null  ) {
            $virtualAccInfo->put('valueDate', data_get($data, 'valueDate'));
        }
        if ( data_get($data, 'expiryDate') != null  ) {
            $virtualAccInfo->put('expiryDate', data_get($data, 'expiryDate'));
        }
        // Data
        $data = collect([]);
        $data->put("mainAccInfo", $mainAccInfo);
        $data->put("virtualAccInfo", $virtualAccInfo);
        // Call API
        // dd($data->toArray());
        $response = ApiCall::put(
            '/virtual-account/v1.0/update', 
            $data->toArray(), 
            ['Content-Type: application/json'], 
            $tcvdb
        );
        return $response;
    }

    // public function apiGetBankList() {
    //     $response = ApiCall::get('/b2b/v1/bank');
    //     return $response;
    // }

    // public function apiGetBranchList($data) {
    //     $response = ApiCall::get('/b2b/v1/bank/branch', [
    //         'BankNo' => $data
    //     ]);
    //     return $response;
    // }

    // public function apiGetBeneficiaryInfo($data) {
    //     $response = ApiCall::get('/b2b/v1/beneficiary/info', [
    //         'benType' => data_get($data, 'benType')
    //     ], [
    //         'bankId' => data_get($data, 'bankId'),
    //         'benNumber' => data_get($data, 'benNumber'),
    //     ]);
    //     return $response;
    // }

    public function signature_verify($data, $signature) {
        $pubkey = $this->loadCert();
        $check_signature = openssl_verify($data, base64_decode($signature), $pubkey, OPENSSL_ALGO_SHA1);
        if ($check_signature == 1) {
            return true;
        }
        return false;
    }

    protected function loadCert() {
        $file = file_get_contents(__DIR__ . '/../'. '/vpbankpub.cer');
        if (!$file) {
         throw new \Exception('loadx509Cert::file_get_contents ERROR');
        }
        $pubkey = openssl_pkey_get_public($file);
        $detail = openssl_pkey_get_details($pubkey);
        openssl_free_key($pubkey);
        if (!$detail) {
         throw new \Exception('loadX509Cert::openssl_pkey_get_details ERROR');
        }
        return $detail["key"];
    }

}
