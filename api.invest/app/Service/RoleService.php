<?php


namespace App\Service;


use App\Models\Role;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;

class RoleService extends BaseService
{
    protected $roleRepository;
    protected $userRepository;

    public function __construct(RoleRepositoryInterface $roleRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    public function get_user_role()
    {
        $user = $this->userRepository->find(current_user()->id);
        $role = $user->role()->get();
        return $role;
    }

    public function get_user_by_role($slug)
    {
        $role = $this->roleRepository->findOne(['slug' => $slug]);
        $user = $role->user()->get();
        return $user;
    }
}
