<?php


namespace Modules\AssetTienNgay\Http\Service;


use Modules\AssetTienNgay\Http\Repository\BaseRepository;
use Modules\AssetTienNgay\Http\Repository\DeviceRepository;
use Modules\AssetTienNgay\Http\Repository\NotificationRepository;
use Modules\AssetTienNgay\Model\DeviceAsset;
use Modules\AssetTienNgay\Model\NotificationAsset;

class NotificationService extends BaseService
{
    protected $notificationRepository;
    protected $deviceRepository;
    protected $firebase;

    public function __construct(NotificationRepository $notificationRepository,
                                DeviceRepository $deviceRepository,
                                Firebase $firebase)
    {
        $this->notificationRepository = $notificationRepository;
        $this->deviceRepository = $deviceRepository;
        $this->firebase = $firebase;
    }

    public function badge($request)
    {
        $data = $this->notificationRepository->count([
            NotificationAsset::USER_ID => (string)$request->user_info->_id,
            NotificationAsset::STATUS => NotificationAsset::UNREAD
        ]);
        return $data;
    }

    public function notification($request)
    {
        $data = $this->notificationRepository->load_more(
            [NotificationAsset::USER_ID => (string)$request->user_info->_id],
            $request->limit,
            $request->offset,
            NotificationAsset::CREATED_AT,
            self::DESC);
        return $data;
    }

    public function read_notification($request)
    {
        $this->notificationRepository->update($request->id, [NotificationAsset::STATUS => NotificationAsset::READ]);
    }

    public function notification_web($request)
    {
        $data = $this->notificationRepository->paginate(
            [NotificationAsset::USER_ID => (string)$request->user_info->_id],
            15,
            NotificationAsset::CREATED_AT,
            self::DESC);
        return $data;
    }

    public function notification_limit($request)
    {
        $data = $this->notificationRepository->load_more(
            [NotificationAsset::USER_ID => (string)$request->user_info->_id],
            5,
            0,
            NotificationAsset::CREATED_AT,
            self::DESC);
        return $data;
    }

    public function push_notification($log, $user_id, $message, $title, $request)
    {
        $data_notification = [
            NotificationAsset::ACTION => $log['type'],
            NotificationAsset::NOTE => $log['note'],
            NotificationAsset::USER_ID => $user_id,
            NotificationAsset::STATUS => NotificationAsset::UNREAD, //1: new, 2 : read, 3: block,
            NotificationAsset::MESSAGE => $message,
            NotificationAsset::CREATED_BY => $request->user_info->email,
            NotificationAsset::CREATED_AT => time(),
            NotificationAsset::SUPPLIES_ID => $log['supplies_id'],
            NotificationAsset::LINK => "/supplies/show/" . $log['supplies_id'],
            NotificationAsset::TITLE => $title
        ];
        $this->notificationRepository->create($data_notification);
        $device = $this->deviceRepository->findOne([DeviceAsset::USER_ID => $user_id]);
        if ($device) {
            $bagde = $this->notificationRepository->count(
                [
                    NotificationAsset::USER_ID => $user_id,
                    NotificationAsset::STATUS => NotificationAsset::UNREAD
                ]);
            $to = [];
            $to[] = $device['device'];
            $this->firebase->setTitle($title);
            $this->firebase->setMessage($message);
            $this->firebase->setBadge((int)$bagde);
            $message = $this->firebase->getMessage();
            $this->firebase->setType($log['type']);
            $this->firebase->setSuppliesId($log['supplies_id']);
            $data = $this->firebase->getData();
            $result = $this->firebase->sendMultiple($to, $message, $data);
        }
    }
}
