<?php


namespace App\Service;


class Firebase
{
    private $title;
    private $message;
    private $image;
    private $data;
    private $type;
    private $contract_id;
    private $badge;
    private $transactionId;

    /**
     * @param mixed $badge
     */
    public function setBadge($badge): void
    {
        $this->badge = $badge;
    }

    /**
     * @param mixed $contract_id
     */
    public function setContractId($contract_id): void
    {
        $this->contract_id = $contract_id;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


    /**
     * Function to set the custom payload (optional)
     *
     * eg:
     *      $payload = array('user' => 'user1');
     *
     * @param array $data Custom data array
     */
    public function setPayload($data)
    {
        $this->data = $data;
    }

    /**
     * Function to specify if is set background (optional)
     *
     * @param bool $is_background
     */
    public function setIsBackground($is_background)
    {
        $this->is_background = $is_background;
    }

    /**
     * Generating the push message array
     *
     * @return array  array of the push notification data to be send
     */
    public function getMessage()
    {
        $res = array();
        $res['title'] = $this->title;
        $res['body'] = $this->message;
        $res['badge'] = $this->badge;
        $res['image'] = $this->image;
        $res['android_channel_id'] = "TienNgay.vn-chanel";
        $res['icon'] = "https://service.tienngay.vn/uploads/avatar/1676544137-8fb8c07ea090f99415fb98bf115a74ab.png";
        $res['click_action'] = "https://dautu.tienngay.vn";
        return $res;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $res = array();
        $res['type'] = $this->type;
        $res['transaction_id'] = $this->transactionId;
        return $res;
    }

    /**
     * Function to send notification to multiple users by firebase registration ids
     *
     * @param array $to array of registration ids of devices (device tokens)
     * @param array $message push notification array returned from getPush()
     * @param string $os platform type
     *
     * @return  array   array of notification data and to addresses
     */
    public function sendMultiple($registration_ids, $message, $data)
    {
        $fields = array(
            'registration_ids' => $registration_ids,
            'notification' => $message,
            'data' => $data,
            "priority" => "high",
        );
        return $this->sendPushNotification($fields);
    }

    /**
     * @param $fields
     * @return bool|string
     */
    private function sendPushNotification($fields)
    {
        $url = env('FIREBASE_URL');
        $headers = array(
            'Authorization: key=' . env('FIREBASE_KEY'),
            'Content-Type: application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }

}
