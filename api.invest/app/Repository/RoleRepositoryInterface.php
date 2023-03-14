<?php
namespace App\Repository;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{

	public function getAllWithStatusActive();

	public function getListPaginate($filter);
}