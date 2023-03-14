<?php


namespace Modules\AssetLocation\Model;


class SendEmailAlarm extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'data_send_mail_investor';
    public $timestamps = FALSE;
}
