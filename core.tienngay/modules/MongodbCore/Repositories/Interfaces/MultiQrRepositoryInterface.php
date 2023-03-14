<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface MultiQrRepositoryInterface
{

    /**
     * create the specified resource in storage.
     *
     * @param  array  $data
     * @return Collection
     */
    public function create($data);

    /**
     * Find the specified resource in storage.
     *
     * @param  array  $data
     * @return Collection
     */
    public function find($id);
}
