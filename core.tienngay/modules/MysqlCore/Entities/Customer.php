<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     * Customer who are have our company's contract
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Column name table
     */
    const ID                        = 'id';
    const NAME                      = 'name';
    const EMAIL                     = 'email';
    const PHONE                     = 'phone';
    const CUSTOMER_IDENTITY         = 'customer_identity';
    const CUSTOMER_IDENTITY_OLD     = 'customer_identity_old';
    const PASSPORT                  = 'passport';
    const DATE_OF_BIRTH             = 'date_of_birth';
    const CURRENT_ADDRESS           = 'current_address';
    const HOUSEHOLD_ADDRESS         = 'household_address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::ID,
        self::NAME,
        self::EMAIL,
        self::PHONE,
        self::CUSTOMER_IDENTITY,
        self::CUSTOMER_IDENTITY_OLD,
        self::PASSPORT,
        self::DATE_OF_BIRTH,
        self::CURRENT_ADDRESS,
        self::HOUSEHOLD_ADDRESS,
    ];

    /**
     * Get table name function
     *
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }


}
