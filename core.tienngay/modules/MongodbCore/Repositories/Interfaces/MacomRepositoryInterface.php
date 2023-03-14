<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface MacomRepositoryInterface
{

    public function create($data = []);
    public function update($data = [], $id);
    public function findById($id);
    // public function get_all($data = []);
}
