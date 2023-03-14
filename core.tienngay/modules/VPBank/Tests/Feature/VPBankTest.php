<?php

namespace Modules\VPBank\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Http\Response;

class VPBankTest extends TestCase
{
    // run vendor/bin/phpunit modules/VPBank/Tests/Feature/VPBankTest.php

    /**
     * test listTransactionByMonth
     *
     * @return void
     */
    public function listTransactionByMonth()
    {
        $time = date ("Y-m-d");
        $payload = [
            'time' => $time,
        ];
        $response = $this->post('/vpbank/transaction/getListByMonth', $payload);

        $response->assertStatus(200);
    }

    /**
     * test searchTransactions
     *
     * @return void
     */
    public function searchTransactions()
    {
        $time = date ("Y-m-d");
        $payload = [
            'end_date' => $time,
            'storeValue' => '0001200'.rand(1,10)
        ];
        $response = $this->post('/vpbank/transaction/searchTransactions', $payload);

        $response->assertStatus(200);
    }

    /**
     * test notification
     *
     * @return void
     */
    public function notification()
    {
        $time = strtotime("now");
        $payload = [
            'masterAccountNumber' => '236465632',
            'virtualAccountNumber' => (string)rand(10000000000,11000000000),
            'virtualName' => 'NGO VAN ' . rand(10,500),
            'amount' => rand(100000,500000),
            'remark' => 'NHAN TU CK IBFT VFC0175187777 - From card to card',
            'transactionId' => 'FT'. $time,
            'transactionDate' => date("Y-m-d H:s:i", $time),
            'bookingDate' => date("Y-m-d", $time),
        ];
        $response = $this->post('/vpbank/transaction/notification', $payload);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

}
