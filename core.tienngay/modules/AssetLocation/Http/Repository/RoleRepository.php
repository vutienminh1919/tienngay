<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\Role;

class RoleRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Role::class;
    }

    public function findManyAsm()
    {
        $asm = 'asm';
        $model = $this->model;
        return $model->where('slug', 'LIKE', "%$asm%")
            ->where('status', 'active')
            ->get();
    }
}
