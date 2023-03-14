<?php


namespace Modules\ViewCpanel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ViewCpanel\Helpers\Authorization;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface;
use Modules\MongodbCore\Entities\UserCpanel as User;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\Hcns\Service\HcnsApi;

class hcnsUser
{
    private $userRepo;
    private $roleRepository;
    private $groupRoleRepository;

    public function __construct(UserCpanelRepositoryInterface $userRepository,
                                RoleRepository $roleRepository,
                                GroupRoleRepository $groupRoleRepository
                                )
    {
        $this->userRepo = $userRepository;
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
        if (!empty($request->input('access_token'))) {
            Log::info('Access_token: ' . print_r($request->input('access_token'), true));
            $user = Authorization::validateToken($request->input('access_token'), true);
            $token = $request->input('access_token');
            if (!empty($user->email)) {
                if ($this->validte_Token($user->email, $token)) {
                    $userDB = $this->userRepo->findByEmail($user->email);
                    session(['user' => $userDB]);
                } else {
                    echo 'Permission denied!'; exit;
                }
            }
        }
        $user = session('user');
        Log::info('User Info: ' . print_r($user, true));
        if (!$user) {
            echo 'Permission denied!'; exit;
        }
        if (!$this->validte_Token($user[User::EMAIL], $user[User::TOKEN_WEB])) {
            echo 'Permission denied!'; exit;
        }
        if (!$this->getHcns($user[User::EMAIL])) {
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

    public function getHcns($email)
    {

        $url = config('routes.hcns.black_list.getAllHcns');
        $result = Http::asForm()->post($url);
        if (in_array($email, $result->json()['data'])) {
            return true;
        }else {
            return false;
        }
    }

}
