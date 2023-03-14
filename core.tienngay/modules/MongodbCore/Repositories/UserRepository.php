<?php

namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\Collaborator;
use Modules\MongodbCore\Repositories\UserRepositoryInterface;
use Modules\MongodbCore\Repositories\BaseRepository;

/**
 *
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return Collaborator::class;
    }

    public function get_list_user_by_my_self($phone_intro)
    {
        $query = $this->model;
        return $query
            ->where(Collaborator::COLUMN_PHONE_INTRODUCE, $phone_intro)
            ->where(Collaborator::COLUMN_USER_TYPE, '1')
            ->where(Collaborator::COLUMN_FORM, '1')
            ->orderBy(Collaborator::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function get_user_info($my_id)
    {
        $query = $this->model;
        return $query
            ->where(Collaborator::COLUMN_ID, $my_id)
            ->first();
    }

    public function findOneByPhone($phone)
    {
        return $this->model
            ->where(function ($query) use ($phone) {
                return $query->where(Collaborator::COLUMN_CTV_PHONE, $phone);
            })
            ->where(Collaborator::COLUMN_STATUS, Collaborator::STATUS_ACTIVE)
            ->first();
    }

    public function findMyUser($my_id)
    {
        return $this->model
            ->where(function ($query) use ($my_id) {
                return $query->where(Collaborator::COLUMN_ID, $my_id);
            })
            ->where(Collaborator::COLUMN_STATUS, Collaborator::STATUS_ACTIVE)
            ->first();
    }

    public function getAllUserMember($filter)
    {
        $model = $this->model;
        $per_page = 15;
        $page = !empty($filter['page']) ? $filter['page'] : 1;
        if (isset($filter['datefrom']) && isset($filter['dateto'])) {
            $from_date = strtotime(trim($filter['datefrom']) . '00:00:00');
            $to_date = strtotime(trim($filter['dateto']) . '23:59:59');
            $model = $model->whereBetween(Collaborator::COLUMN_CREATED_AT, [$from_date, $to_date]);
        }
        if (isset($filter['filter_many'])) {
            $filter_many = $filter['filter_many'];
            $model = $model->where(Collaborator::COLUMN_CTV_NAME, 'like', "%$filter_many%")
                ->orWhere(Collaborator::COLUMN_CTV_PHONE, 'like', "%$filter_many%")
                ->orWhere(Collaborator::COLUMN_USER_ROLE, 'like', "%$filter_many%");
        }
        if (isset($filter['id'])) {
            $id = $filter['id'];
            $user = $this->findMyUser($id);

            if (isset($user['manager_id'])) {
                $model = $model->where(Collaborator::COLUMN_MANAGER_ID, $user['manager_id']);
                $model = $model->where(Collaborator::COLUMN_USER_TYPE, Collaborator::TYPE_COLLABORATOR_GROUP);
            } else {
                $model = $model->where(Collaborator::COLUMN_MANAGER_ID, $id);
            }
        }
        return $model
            ->where(Collaborator::COLUMN_FORM, Collaborator::FORM_USER_GROUP)
            ->orderBy(Collaborator::COLUMN_CREATED_AT, self::DESC)
            ->offset($page)
            ->limit($per_page)
            ->paginate($per_page);
    }

    public function getGroupCtv()
    {
        $query = $this->model;
        return $query
            ->where(Collaborator::COLUMN_STATUS, Collaborator::STATUS_ACTIVE)
            ->where(Collaborator::COLUMN_FORM, Collaborator::FORM_USER_GROUP)
            ->where(Collaborator::COLUMN_ACCOUNT_TYPE, Collaborator::TYPE_ACCOUNT_PARENT)
            ->orderBy(Collaborator::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

    public function toggleActive($id)
    {
        // TODO: Implement toggleActive() method.
    }

    public function find_foreignKey($id, $table, $collection)
    {
        // TODO: Implement find_foreignKey() method.
    }

    public function count_find_foreignKey($id, $table, $collection)
    {
        // TODO: Implement count_find_foreignKey() method.
    }
        //verified success
    public function verifiedUser($id)
    {
        $user = Collaborator::where(Collaborator::COLUMN_ID, $id)->update([Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::VERIFIED]);
        return $user;

    }
        // verified fail
    public function notVerifiedUser($id)
    {
        $user = Collaborator::where(Collaborator::COLUMN_ID, $id)->update([Collaborator::COLUMN_STATUS_VERIFIED => Collaborator::RE_VERIFY]);
        return $user;

    }
        // get old user that doesnt have status
    public function getUserNotVerified()
    {
        $user = Collaborator::where(Collaborator::COLUMN_STATUS_VERIFIED, 'exists', false)->get();
        return $user;

    }


}
