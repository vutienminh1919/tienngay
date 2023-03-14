<?php
namespace App\Repository;

use App\Models\Action;

class ActionRepository extends BaseRepository implements ActionRepositoryInterface
{

	public function getModel()
    {
		return Action::class;
	}

}
