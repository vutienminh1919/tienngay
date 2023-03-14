<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface UserCpanelRepositoryInterface
{

    /**
     * Find the specified resource in storage.
     *
     * @param  string  $email
     * @return Collection
     */
    public function findByEmail($email);
}
