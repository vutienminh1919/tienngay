<?php


namespace Modules\ViewCpanel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Repositories\StoreRepository;

class HeyuValid
{
    private $roleRepo;
    private $groupRoleRepo;
    const VAN_HANH = 'van-hanh';
    const KE_TOAN = 'ke-toan';
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
        $pgdActive = $this->storeRepository->getActiveList();
        $arrPgdActive = array_column($pgdActive->toArray(), '_id');
        $user['groupRole'] = $groupRole;
        $user['roles']['heyu'] = [
            'view' => false,
            'edit' => false,
            'create' => false,
            'delete' => false,
            'handoverApprove' => false,
            'handoverCancel'  => false,
            'importHeyu' => false,
            'editHeyuStore' => false,
            'viewHistory' => false,
            'showEdit' => false,
            'showStore' => true,
            'showHandover' => true
        ];

        if (
            in_array(self::VAN_HANH, $groupRole) ||
            in_array(self::KE_TOAN, $groupRole) ||
            in_array(self::QUAN_LY_CAP_CAO, $groupRole)
        ) {
            $user['roles']['heyu']['showStore'] = false;
            $user['roles']['heyu']['showHandover'] = false;
            $user['roles']['heyu']['view'] = true;
            $user['roles']['heyu']['editHeyuStore'] = true;
            $user['roles']['heyu']['viewHistory'] = true;
            $pgdActive = $this->storeRepository->getActiveList();
            $pgds = $pgdActive->toArray();
        } else {
            $pgds = $this->roleRepo->getStoreList($userId, false);
        }
        if(in_array(self::VAN_HANH, $groupRole)){
             $user['roles']['heyu']['showEdit'] = true;
        }
        if (in_array(self::CUA_HANG_TRUONG, $groupRole)) {
            $user['roles']['heyu']['create'] = true;
            $user['roles']['heyu']['view'] = true;
            $user['roles']['heyu']['edit'] = true;
            $user['roles']['heyu']['delete'] = true;
            $user['roles']['heyu']['handoverApprove'] = true;
            $user['roles']['heyu']['handoverCancel'] = true;
            $user['roles']['heyu']['importHeyu'] = true;
            $user['roles']['heyu']['viewHistory'] = true;
        } else if (
            in_array(self::GIAO_DICH_VIEN, $groupRole)
        ) {
            $user['roles']['heyu']['showStore'] = false;
            $user['roles']['heyu']['create'] = true;
            $user['roles']['heyu']['view'] = true;
            $user['roles']['heyu']['viewHistory'] = true;
        }
        if ($isAdmin) {
            $user['roles']['heyu']['view'] = true;
            $user['roles']['heyu']['edit'] = true;
            $user['roles']['heyu']['create'] = true;
            $user['roles']['heyu']['delete'] = true;
            $user['roles']['heyu']['handoverApprove'] = true;
            $user['roles']['heyu']['handoverCancel'] = true;
            $user['roles']['heyu']['importHeyu'] = true;
            $user['roles']['heyu']['editHeyuStore'] = true;
            $user['roles']['heyu']['viewHistory'] = true;
            $user['roles']['heyu']['showEdit'] = true;
            $user['roles']['heyu']['showStore'] = true;
            $user['roles']['heyu']['showHandover'] = true;
            $pgdActive = $this->storeRepository->getActiveList();
            $pgds = $pgdActive->toArray();
        }
        $user['pgds'] = $pgds;
        Log::channel('cpanel')->info('User Info: ' . json_encode($user));
        session(['user' => $user]);
        return $next($request);
    }

}
