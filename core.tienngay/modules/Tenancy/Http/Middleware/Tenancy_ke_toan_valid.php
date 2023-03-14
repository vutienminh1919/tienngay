<?php


namespace Modules\Tenancy\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Modules\AssetLocation\Http\Repository\UserRepository;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\Tenancy\Http\Controllers\BaseController;

class Tenancy_ke_toan_valid
{
    private $userRepo;
    private $roleRepository;
    private $groupRoleRepository;

    public function __construct(UserRepository $userRepository,
                                RoleRepository $roleRepository,
                                GroupRoleRepository $groupRoleRepository)
    {
        $this->userRepo = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->groupRoleRepository = $groupRoleRepository;
    }
//check group role của kế toán
    public function handle($request, Closure $next)
    {
        $user_id = $request->user->_id;
        $groupRoleUser = $this->groupRoleRepository->getGroupRole($user_id);
        if (in_array('ke-toan', $groupRoleUser) || (!empty($request->user->is_superadmin) && $request->user->is_superadmin == 1)) {
            return $next($request);
        } else {
            return BaseController::sendResponse(BaseController::HTTP_FORBIDDEN, 'Không có quyền');
        }
    }


}
