<?php


namespace Modules\AssetLocation\Http\Service;

use Modules\AssetLocation\Http\Repository\GroupRoleRepository;

class GroupRoleService extends BaseService
{
    protected $groupRoleRepository;

    public function __construct(GroupRoleRepository $groupRoleRepository)
    {
        $this->groupRoleRepository = $groupRoleRepository;
    }

    public function getGroupRole($userId)
    {
        $groupRoles = $this->groupRoleRepository->findMany(["status" => "active"]);
        $arr = array();
        foreach ($groupRoles as $groupRole) {
            if (empty($groupRole['users'])) continue;
            foreach ($groupRole['users'] as $item) {
                if (key($item) == $userId) {
                    array_push($arr, $groupRole['slug']);
                    continue;
                }
            }
        }
        return $arr;
    }
}
