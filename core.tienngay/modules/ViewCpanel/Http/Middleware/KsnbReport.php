<?php

namespace Modules\ViewCpanel\Http\Middleware;

use Closure;
use Modules\ViewCpanel\Helpers\Authorization;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Entities\UserCpanel as User;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface as UserCpanelRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;

class KsnbReport
{
    private $roleRepository;
    private $userRepository;

   /**
     * @OA\Info(
     *     version="1.0",
     *     title="API VFCPayment"
     * )
     */
    public function __construct(
        RoleRepository $roleRepository,
        UserCpanelRepository $userRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        log::info("Middleware KsnbReport");
        $user = session('user');
        Log::info('User Info: ' . print_r($user, true));
        if (!$user) {
            echo 'Permission denied!'; exit;
        }
        if (!$this->validToken($user[User::EMAIL])) {
             echo 'Permission denied!'; exit;
        }
        return $next($request);
    }

    protected function valid_Token($email, $token) {
        $userDB = $this->userRepository->findByEmail($email);
        if ($userDB[User::TOKEN_WEB] == $token) {
            return true;
        } else {
            return false;
        }
    }

    //check_role_ksnb tbp ksnb

    public function validToken($email)
    {   

        $users = $this->roleRepository->getEmailKsnb();
        if (in_array($email, $users) || in_array($email, config('viewcpanel.CEO'))){
            return true;
        }else{
            return false;
        }
    }

}
