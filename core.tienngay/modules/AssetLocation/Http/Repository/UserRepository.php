<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\User;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return User::class;
    }
}
