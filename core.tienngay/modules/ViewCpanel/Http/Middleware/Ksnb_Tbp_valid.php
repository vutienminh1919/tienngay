<?php


namespace Modules\ViewCpanel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface;
use Modules\MongodbCore\Repositories\KsnbRepository;
use Modules\MongodbCore\Entities\UserCpanel as User;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\ReportsKsnb\Service\ApiCall;

class Ksnb_Tbp_valid
{
    private $userRepo;
    private $ksnbRepository;
    private $roleRepository;
    private $groupRoleRepository;

    public function __construct(UserCpanelRepositoryInterface $userRepository,
                                KsnbRepository $ksnbRepository,
                                RoleRepository $roleRepository,
                                GroupRoleRepository $groupRoleRepository
                                )
    {
        $this->userRepo = $userRepository;
        $this->ksnbRepository = $ksnbRepository;
        $this->roleRepository = $roleRepository;
        $this->groupRoleRepository = $groupRoleRepository;

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
        $idReport = $request->id;
        Log::info('User Info: ' . print_r($user, true));
        if (!$user) {
            echo 'Permission denied!'; exit;
        }
        if (!$this->validToken($user["email"], $idReport)) {
             echo 'Permission denied!'; exit;
        }
        return $next($request);
    }

    public function validte_Token($email, $token)
    {
        $user = $this->userRepo->findByEmail($email);
        if ($user[User::TOKEN_WEB] == $token) {
            return true;
        } else {
            return false;
        }
    }

// check_role_ksnb only staff transgress and tpgg and asm

    public function validToken($email, $idReport)
    {
        $currentUser = session('user');
        $user = ApiCall::getUserEmail($email);
        if ($user['status'] !== Response::HTTP_OK){
            return false;
        }
        if (empty($user['data'])) { // check is admin
            return true;
        }
        $emailksnb = $this->groupRoleRepository->getEmailGroupKsnb();
        $emailReport = $this->ksnbRepository->getEmailAll($idReport);
        if (in_array($emailReport, $user['data'])) {
            return true;
        }elseif (in_array($currentUser['email'], $emailksnb)){
            return true;
        }else {
            return false;
        }

    }


}
