<?php
namespace App\Repository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

	public function getModel()
	{
		return \App\Models\Role::class;
	}

	public function getAllWithStatusActive()
	{
		return $this->model
			->where('status', 'active')
			->get();
	}

	public function getListPaginate($filter)
	{
		$condition = $this->filterCondition($filter);
		$model = $this->model;
		if ( count($condition) > 0 ) {
			$model = $model->where($condition);
		}
		$model = $model->orderBy('id', 'DESC');
		$model = $model->paginate();
		return $model;
	}

}