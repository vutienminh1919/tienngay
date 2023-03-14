<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'role';

    /**
     * initial constants
     */
    const NAME                  = 'name';
    const SLUG                  = 'slug';
    const STATUS                = 'status';
    const ID                    = '_id';
    const STORES                = 'stores';
    const USERS                 = 'users';
    /**
     * end initial constants
     */

    const ACTIVE                = 'active';
    const DEACTIVE              = 'deactive';
    protected $guarded = [];

    public $timestamps = FALSE;
    /**
     * Column name table
     */



}
