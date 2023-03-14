<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class JavaReport extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'contract';
}
