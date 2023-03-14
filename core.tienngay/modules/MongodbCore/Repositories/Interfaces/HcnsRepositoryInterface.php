<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface HcnsRepositoryInterface
{
    public function createRecord($data=[]);

    public function updateRecord($data=[], $id);

    public function getAllRecord();

    public function findRecord($id);
}