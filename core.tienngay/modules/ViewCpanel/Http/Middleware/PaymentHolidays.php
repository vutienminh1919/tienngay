<?php


namespace Modules\ViewCpanel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Repositories\StoreRepository;

class PaymentHolidays
{
    private $roleRepo;
    private $groupRoleRepo;
    private $areaRepository;
    const VAN_HANH = 'van-hanh';
    const KE_TOAN = 'ke-toan';
    const QUAN_LY_CAP_CAO = 'quan-ly-cap-cao';
    const CUA_HANG_TRUONG = 'cua-hang-truong';
    const GIAO_DICH_VIEN = 'giao-dich-vien';
    const MARKETTING = 'marketing';

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
        $pgds = $this->roleRepo->getStoreList($userId, false);
        $arrPgdActive = array_column($pgdActive->toArray(), '_id');
        $user['groupRole'] = $groupRole;
        $user['roles']['paymentHolidays'] = [
            'store' => false,
            'update' => false,
            'delete' => false,
            'index' => false,
            'detail' => false
        ];

        if (
            in_array(self::QUAN_LY_CAP_CAO, $groupRole)
        ) {
            $pgds = $pgdActive->toArray();
        }

        if ($isAdmin) {
            $user['roles']['paymentHolidays']['index'] = true;
            $user['roles']['paymentHolidays']['store'] = true;
            $user['roles']['paymentHolidays']['update'] = true;
            $user['roles']['paymentHolidays']['delete'] = true;
            $user['roles']['paymentHolidays']['detail'] = true;
            $pgds = $pgdActive->toArray();
        }
        $user['pgds'] = $pgds;
        Log::channel('cpanel')->info('User Info: ' . json_encode($user));
        session(['user' => $user]);
        return $next($request);
    }

}
