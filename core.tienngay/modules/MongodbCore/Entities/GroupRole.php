<?php


namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class GroupRole extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'group_role';

    /**
     * initial constants
     */

    const NAME = 'name';
    const SLUG = 'slug';
    const STATUS = 'status';
    const USERS ='users';
    /**
     * end initial constants
     */

    const ACTIVE = 'active';
    const DEACTIVE = 'deactive';
    protected $guarded = [];

    public $timestamps = FALSE;
    /**
     * Column name table
     */

}
