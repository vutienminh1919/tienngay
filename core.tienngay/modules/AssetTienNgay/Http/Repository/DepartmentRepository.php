<?php


namespace Modules\AssetTienNgay\Http\Repository;


use Modules\AssetTienNgay\Model\Department;

class DepartmentRepository extends BaseRepository
{
    public function getModel()
    {
        return Department::class;
    }
}
