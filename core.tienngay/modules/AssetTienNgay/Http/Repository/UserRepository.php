<?php


namespace Modules\AssetTienNgay\Http\Repository;

use Modules\AssetTienNgay\Model\User;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }

    public function get_user_add_role($user)
    {
        return $this->model
            ->where(User::TYPE, '1')
            ->where(User::STATUS, User::ACTIVE)
            ->whereNotIn(User::ID, $user)
            ->get();
    }

    public function get_all_user_add_role()
    {
        return $this->model
            ->where(User::TYPE, '1')
            ->where(User::STATUS, User::ACTIVE)
            ->get();
    }
}
