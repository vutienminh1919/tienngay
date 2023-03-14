<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Notification extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'notification';

    protected $guarded = [];

    public $timestamps = FALSE;
    /**
     * Column name table
     */




}
