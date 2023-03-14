<?php

namespace Modules\PaymentGateway\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MoMoAppTest extends TestCase
{
    // run vendor/bin/phpunit modules/PaymentGateway/Tests/Feature/MoMoAppTest.php

    /**
     * test get bill info
     *
     * @return void
     */
    public function testGetBillInfo()
    {
        $payload = [
            'requestId' => '123sdf23412sdf',
            'referenceId' => '610a4081dc508a16c402a924',
            'paymentOption' => 1
        ];
        $response = $this->post('/paymentgateway/momo/getBillInfo', $payload);

        $response->assertStatus(200);
    }

    /**
     * test notifyPaymentResult
     *
     * @return void
     */
    public function notifyPaymentResult()
    {
        $payload = [
            'requestId' => '2300699797',
            'transactionId' => '2300699797',
            'reference1' => '0000000001',
            'amount' => '395000',
            'date' => '2021-07-31T23:59:59+07:00',
        ];
        $response = $this->post('/paymentgateway/momo/notifyPaymentResult', $payload);

        $response->assertStatus(200);
    }

    /**
     * test get list transaction by month
     *
     * @return void
     */
    public function testListTransactionByMonth()
    {
        $payload = [
            'time' => '2021-08-23',
        ];
        $response = $this->post('/paymentgateway/momo/listTransactionByMonth', $payload);

        $response->assertStatus(200);
    }

    /**
     * test search transaction by special condition
     *
     * @return void
     */
    public function testSearchTransactions()
    {
        $payload = [
            'confirmed' => 1,
            'contract_code_disbursement' => '2018',
            'contract_transaction_id' => null,
            'transactionId' => '23006997',
            'start_date' => '2021-07-01',
            'end_date' => '2021-07-09',
        ];
        $response = $this->post('/paymentgateway/momo/searchTransactions', $payload);

        $response->assertStatus(200);
    }

    /**
     * Allows the partner to get contract list by client info
     *
     * @return void
     */
    public function testGetContractList()
    {
        $payload = [
            'requestId' => '60fe28e9fdf7f870d4160ac7',
            'reference1' => 'HĐCC/ĐKXM/HN901GP/2107/05/GH-02',
        ];
        $response = $this->post('/paymentgateway/momo/getContractList', $payload);

        $response->assertStatus(200);
    }
}
