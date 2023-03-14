<?php


namespace App\Service;

use Illuminate\Support\Facades\Session;

class Notification
{
    public function get_notification_user()
    {
        $response = Api::post('notification/get_notification_user', ['id' => Session::get('user')['id'], 'limit' => 5, 'offset' => 0]);
        $noti = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $noti = isset($response['data']) ? $response['data'] : [];

        }
        return $noti;
    }

    public function count_notification()
    {
        $response = Api::post('notification/count_unread_noti_user', ['id' => Session::get('user')['id']]);
        $total = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $total = isset($response['data']) ? $response['data'] : [];

        }
        return $total;
    }
}
