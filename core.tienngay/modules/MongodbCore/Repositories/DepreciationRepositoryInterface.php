<?php
namespace Modules\MongodbCore\Repositories;

interface DepreciationRepositoryInterface extends RepositoryInterface
{
    public function search($data);
}