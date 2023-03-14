<?php
namespace Modules\MongodbCore\Repositories;

interface DepreciationBaseRepositoryInterface extends BaseRepositoryInterface
{
    public function search($data);
}
