<?php
namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class BlackList extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'blacklist';

    public $timestamps = false;


//    protected $fillable = ['_id', 'page', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];


    const ID = "_id";
    const NAME = "name";
    const PHONE = "phone_number";
    const IDENTIFY = "identify";
    const PASSPORT = "passport";
    const ID_HCNS = "id_hcns";
    const ID_PROPERTY = "id_property";
    const ID_EXEMTION = "id_exemtion";
    const ID_CONTRACT_EXEMTION = "id_contract_exemtion";
    const CREATED_AT = "created_at";
    const CREATED_BY = "created_by";
    const UPDATED_AT = "updated_at";
    const UPDATED_BY = "updated_by";




    protected $guarded = [];

}
