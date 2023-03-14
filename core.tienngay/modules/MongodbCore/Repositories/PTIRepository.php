<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\Pti_vta_bn as PTIModel;
use Modules\MongodbCore\Repositories\Interfaces\PTIRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class PTIRepository implements PTIRepositoryInterface
{

    /**      
     * @var Model      
     */     
     protected $ptiModel;

    /**
     * PTIRepository constructor.
     *
     * @param PTIModel $pti
     */
    public function __construct(PTIModel $pti) {
        $this->ptiModel = $pti;
    }
}
