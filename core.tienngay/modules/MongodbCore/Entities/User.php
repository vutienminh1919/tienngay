<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'user';

    protected $guarded = [];

    public $timestamps = FALSE;
    /**
     * Column name table
     */




}
