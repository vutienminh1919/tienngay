<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\UserCpanel as User;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class UserCpanelRepository implements UserCpanelRepositoryInterface
{

    /**
     * @var Model
     */
     protected $userModel;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user) {
        $this->userModel = $user;
    }

    /**
     * Find the specified resource in storage.
     *
     * @param  string  $email
     * @return Collection
     */
    public function findByEmail($email) {
        $user = $this->userModel::select([
                    User::EMAIL,
                    User::STATUS,
                    User::FULL_NAME,
                    User::TOKEN_WEB,
                    User::PHONE_NUMBER,
                    User::IDENTITY_CARD,
                    User::IS_SUPERADMIN
                ])
                ->where(User::EMAIL, $email)
                ->where(User::STATUS, 'active')
                ->first();
        return $user->toArray();
    }


    public function getUserNameByEmail($email)
    {
        $result = $this->userModel::where("email", $email)->get(['email', 'full_name']);
        return $result;
    }

    public function getUserActive($email)
    {
        $result = $this->userModel->where(User::STATUS,User::ACTIVE)->where(User::EMAIL,$email)
        ->first(['_id']);
        if(!empty($result['_id'])) {
            return true;
        }
        return false;
    }

    public function getAllEmailActive($email)
    {
        $result = $this->userModel::where(User::STATUS, User::ACTIVE)
        ->where(User::EMAIL, 'like', "%$email%")
        ->get(['email','full_name']);
        return $result;
    }

    public function getAll($selectFileds = false)
    {
        $listEmail = [];
        if ($selectFileds) {
            $list = $this->userModel::where(User::STATUS, User::ACTIVE)
            ->where(User::EMAIL, 'like', '%@tienngay.vn')
            ->where(User::EMAIL, 'not regexp', '/test/i')
            ->get($selectFileds);
        } else {
            $list = $this->userModel::where(User::STATUS, User::ACTIVE)->get();
        }
        return $list;

    }

     public function getUserWaitingAuth()
    {
        $result = $this->userModel->where(User::AUTH,User::WAIT)->where(User::STATUS, User::ACTIVE)->where(User::TYPE, User::APPKH)->get();
        return $result->toArray();

    }
        // verified success
    public function verifiedUser($id)
    {
        $user = User::where(User::ID, $id)->update([User::AUTH => User::VERIFIED]);
        return $user;

    }
        // verified fail
    public function notVerifiedUser($id)
    {
        $user = User::where(User::ID, $id)->update([User::AUTH => User::RE_VERIFED, User::FRONT_CARD => "", User::BACK_CARD => "", User::AVATAR => ""]);
        return $user;
    }

      public function find_user_active($where)
    {
        $query = $this->userModel;
        foreach ($where as $key => $item) {
            $query = $query->where($key, $item);
        }
        return $query->first();
    }

    public function findUserByEmail($email) {
        $user = $this->userModel
        ->where(User::EMAIL, $email)
        ->where(User::STATUS, 'active')
        ->first();
        if ($user) {
            return $user;
        }
        return false;
    }
}
