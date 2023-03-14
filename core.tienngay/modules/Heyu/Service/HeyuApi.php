<?php

namespace Modules\Heyu\Service;

use Modules\Heyu\Service\ApiCall;

class HeyuApi
{

	/**
    * Nạp tiền Heyu theo mã Thành viên
    * @param $data Array
    * @return $response Array
    */
    public function charge($data) {
        $mainData = collect([]);
        $mainData->put('code', data_get($data, 'code'));
        $mainData->put('amount', data_get($data, 'amount'));
        $mainData->put('orderId', data_get($data, 'orderId'));
        // Call API
        $response = ApiCall::post(
            '/api/v1.0/topup/charge',
            $mainData->toArray(),
            ['Content-Type: application/json']
        );
        return $response;
    }

    /**
    * Tìm thông tin tài xế theo mã Thành viên
    * @param $data Array
    * @return $response Array
    */
    public function findUserByCode($data) {
        $mainData = collect([]);
        $mainData->put('code', data_get($data, 'code'));
        // Call API
        $response = ApiCall::post(
            '/api/v1.0/topup/find-user-by-code',
            $mainData->toArray(),
            ['Content-Type: application/json']
        );
        return $response;
    }

    /**
    * Tra cứu lịch sử nạp
    * @param $data Array
    * @return $response Array
    */
    public function getTransactions($data) {
        $mainData = collect([]);
        $mainData->put('page', data_get($data, 'page'));
        $mainData->put('limit', data_get($data, 'limit'));
        $mainData->put('sort', data_get($data, 'sort'));
        // Call API
        $response = ApiCall::post(
            '/api/v1.0/topup/list-transaction',
            $mainData->toArray(),
            ['Content-Type: application/json']
        );
        return $response;
    }

    /**
    * Tìm thông đồng phục tài xế theo mã Thành viên
    * @param $data Array
    * @return $response Array
    */
    public function getStatus($data) {
        $mainData = collect([]);
        $mainData->put('code', data_get($data, 'code'));
        // Call API
        $response = ApiCall::post(
            '/api/v1.0/uniform/get-status',
            $mainData->toArray(),
            ['Content-Type: application/json']
        );
        return $response;
    }

    /**
    * Xác nhận giao đồng phục cho tài xế
    * @param $data Array
    * @return $response Array
    */
    public function handover($data) {
        $mainData = collect([]);
        $mainData->put('code', data_get($data, 'code'));
        $mainData->put('id', data_get($data, 'storeId'));
        $mainData->put('coatSize', data_get($data, 'coatSize', ''));
        $mainData->put('shirtSize', data_get($data, 'shirtSize', ''));
        // Call API
        $response = ApiCall::post(
            '/api/v1.0/uniform/handover',
            $mainData->toArray(),
            ['Content-Type: application/json']
        );
        return $response;
    }

    /**
    * Tra cứu thông tin đồng phục hiện tại các cơ sở của TienNgay
    * @param $data Array
    * @return $response Array
    */
    public function inventory($data) {
        $mainData = collect([]);
        $mainData->put('ids', data_get($data, 'storeIds'));
        // Call API
        $response = ApiCall::post(
            '/api/v1.0/uniform/inventory',
            $mainData->toArray(),
            ['Content-Type: application/json']
        );
        return $response;
    }
}
