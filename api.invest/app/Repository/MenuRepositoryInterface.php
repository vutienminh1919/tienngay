<?php
namespace App\Repository;

interface MenuRepositoryInterface extends BaseRepositoryInterface
{

	public function getListPaginate($filter);

	public function getAllParent();

    public function getAllChildByParent($id);

}
