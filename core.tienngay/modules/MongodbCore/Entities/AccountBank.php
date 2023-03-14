<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class AccountBank extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'account_bank';

    protected $guarded = [];

    public $timestamps = FALSE;

    /**
     * Column name table
     */

}
