<?php


namespace Modules\ViewCpanel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Repositories\StoreRepository;

class ReportLogTransaction
{
    private $roleRepo;
    private $groupRoleRepo;

    const VAN_HANH = 'van-hanh';
    const KE_TOAN = 'ke-toan';
    const KE_TOAN_THU = 'ke-toan-thu';
    const KE_TOAN_TRUONG = 'tpb-ke-toan';
    const QUAN_LY_CAP_CAO = 'quan-ly-cap-cao';
    const CUA_HANG_TRUONG = 'cua-hang-truong';
    const GIAO_DICH_VIEN = 'giao-dich-vien';

    public function __construct(
        RoleRepository $roleRepository,
        GroupRoleRepository $groupRoleRepository,
        StoreRepository $storeRepository
    ){
        $this->roleRepo = $roleRepository;
        $this->groupRoleRepo = $groupRoleRepository;
        $this->storeRepository = $storeRepository;
    }
     /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $user = session('user');
        Log::channel('cpanel')->info('User Info: ' . print_r($user, true));
        if (!$user) {
            echo 'Permission denied!'; exit;
        }
        $email = $user['email'];
        $userId = $user['_id'];
        $isAdmin = (isset($user['is_superadmin']) && (int) $user['is_superadmin'] == 1) ? 1 : 0;
        $groupRole = $this->groupRoleRepo->getGroupRoleByUserId($userId);
        $user['groupRole'] = $groupRole;
        $user['roles']['reportLogTransaction'] = [
            'index' => false,
            'search' => false
        ];

        if (
            in_array(self::KE_TOAN_THU, $groupRole) || 
            in_array(self::KE_TOAN_TRUONG, $groupRole)
        ) {
            $user['roles']['reportLogTransaction'] = [
                'index' => true,
                'search' => true
            ];
        }
        if ($isAdmin) {
            $user['roles']['reportLogTransaction'] = [
                'index' => true,
                'search' => true
            ];
        }
        Log::channel('cpanel')->info('User Info: ' . json_encode($user));
        session(['user' => $user]);
        return $next($request);
    }

}
