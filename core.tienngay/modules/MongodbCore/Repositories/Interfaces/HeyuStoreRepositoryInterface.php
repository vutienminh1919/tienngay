<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface HeyuStoreRepositoryInterface
{
    public function getAll($data);
    public function detailById($id);
    public function insert($data);
}
