<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class HeyuStore extends Model
{
    protected $connection = "mongodb";

    protected $collection = "heyu_store";

    protected $primarykey = "_id";

     protected $guarded = [];

    public $timestamps = false;

    const ID = '_id'; // primary key
    const STORE = 'store'; //  PGD
    const STORE_ID = 'id'; //  id PGD
    const STORE_NAME = 'name'; //  name PGD
    const COAT = 'coat'; // so luong ao
    const TOTAL_COAT = 'total_coat'; // so luong ao
    const HELMET = 'helmet'; // so luong mu bh
    const SHIRT = 'shirt'; // so luong ao phong
    const TOTAL_SHIRT = 'total_shirt'; // so luong ao phong
    const DETAIL = 'detail'; //chi tiết
    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_AT = 'updated_at';
    const UPDATED_BY = 'updated_by';
    const LOG = "logs"; // log update
    const STATUS = 'status';

    //size ao khoac + ao phong
    const SIZE_S = 's'; // size s
    const SIZE_M = 'm'; // size m
    const SIZE_L = 'l'; // size l
    const SIZE_XL = 'xl'; // size xl
    const SIZE_XXL = 'xxl'; // size xxl
    const SIZE_XXXL = 'xxxl'; // size xxxl

    //status
    const ACTIVE = 'active';
    const BLOCK = 'block';


}
