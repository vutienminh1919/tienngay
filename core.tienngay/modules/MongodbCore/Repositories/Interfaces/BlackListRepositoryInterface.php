<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface BlackListRepositoryInterface
{
    public function createProperty($data=[]);

    public function createHcns($data = []);

    public function findExemtion($data);
}
