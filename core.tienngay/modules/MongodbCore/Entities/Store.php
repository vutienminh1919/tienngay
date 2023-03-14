<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Store extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'store';

    const VPB_STORE_CODE = 'vpb_store_code';
    const STORE_CODE = 'store_code';
    const CODE_AREA = 'code_area';

    /**
     * initial constants
     */
    const ID                    = '_id';
    const NAME                  = 'name';
    const ADDRESS               = 'address';
    const STATUS                = 'status';
    const TYPE                  = 'type';
    const TYPE_PGD              = 'type_pgd';
    const COMPANY               = 'company';
    /**
     * end initial constants
     */

    const ACTIVE                = 'active';
    const DEACTIVE              = 'deactive';
    const PGD_HD                = "1";//đang hoạt động
    const PGD_TTB               = "2";//trung tâm bán
    const PGD_CC                = "3";//đã cơ cấu

    const COMPANY_TCV           = "1";
    const COMPANY_TCV_DB        = "2";
    const COMPANY_TCV_HCM       = "3";

}
