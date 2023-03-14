<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql';

    protected $table = 'user';
}
