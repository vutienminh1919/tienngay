<?php


namespace Modules\AssetTienNgay\Http\Service;


class Firebase
{
    private $title;
    private $message;
    private $image;
    private $data;
    private $type;
    public $contract_id;
    private $badge;
    private $transactionId;
    private $supplies_id;

    public function __construct()
    {
        $this->url = 'https://fcm.googleapis.com/fcm/send';
        $this->key = 'AAAAlr43_Ig:APA91bFgi5dUBQpRlsTvONYewO0kA2gmCV2PNzTjNd1K0l4nuyvljraVp9jP0W_GEOQy-8IdR5NjHa73KSywo8WUk3nXTmJUwcTJmHXEUAKGQnSDIUnT3IjVtocNeke81OLFWOQopjdB';
    }

    public function setBadge($badge)
    {
        $this->badge = $badge;
    }

    private $is_background;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setImage($imageUrl)
    {
        $this->image = $imageUrl;
    }

    public function setPayload($data)
    {
        $this->data = $data;
    }

    public function setIsBackground($is_background)
    {
        $this->is_background = $is_background;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setContractId($contract_id)
    {
        $this->contract_id = $contract_id;
    }

    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function setSuppliesId($supplies_id): void
    {
        $this->supplies_id = $supplies_id;
    }

    public function getMessage()
    {
        $res = array();
        $res['title'] = $this->title;
        $res['body'] = $this->message;
        $res['badge'] = $this->badge;
        return $res;
    }

    public function getData()
    {
        $res = array();
        $res['type'] = $this->type;
        $res['contract_id'] = $this->contract_id;
        $res['transaction_id'] = $this->transactionId;
        $res['supplies_id'] = $this->supplies_id;
        return $res;
    }

    public function send($to, $message, $os = "ios")
    {
        if ($os == "ios") {
            $fields = array(
                'to' => $to,
                'data' => $message,
            );
        } else {
            $fields = array(
                'to' => $to,
                'notification' => $message,
            );
        }

        return $this->sendPushNotification($fields);
    }

    public function sendToTopic($to, $message, $data)
    {
        $fields = [
            'to' => $to,
            'notification' => $message,
            'data' => $data
        ];
        return $this->sendPushNotification($fields);
    }


    public function sendMultiple($registration_ids, $message, $data)
    {
        $fields = array(
            'registration_ids' => $registration_ids,
            'notification' => $message,
            'data' => $data

        );
        return $this->sendPushNotification($fields);
    }

    private function sendPushNotification($fields)
    {
        $headers = array(
            'Authorization: key=' . $this->key,
            'Content-Type: application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
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
        // Close connection
        curl_close($ch);
        return $result;
    }
}
