<?php


namespace Modules\AssetLocation\Model;


class Partner extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'partner_asset_location';
    public $timestamps = FALSE;

    //column
    const NAME = 'name';
    const SLUG = 'slug';
    const STATUS = 'status';

    //status
    const STATUS_BLOCK = 'new';
    const STATUS_ACTIVE = 'active';


}
