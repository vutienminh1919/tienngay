<?php
namespace App\Repository;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{

	public function getModel()
	{
		return \App\Models\Menu::class;
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

	public function getAllParent()
	{
		return $this->model
			->where('status', 'active')
			->whereNull('parent')
			->get();
	}

	public function getAllChildByParent($id)
    {
        return $this->model
            ->where('parent', $id)
            ->get();
    }

}
