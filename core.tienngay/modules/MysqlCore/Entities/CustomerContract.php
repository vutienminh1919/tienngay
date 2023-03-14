<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerContract extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     * Linking customer_id with contract_code
     *
     * @var string
     */
    protected $table = 'customer_contracts';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Column name table
     */
    const ID                = 'id';
    const CUSTOMER_ID       = 'customer_id';
    const CONTRACT_CODE     = 'contract_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::CUSTOMER_ID,
        self::CONTRACT_CODE,
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
