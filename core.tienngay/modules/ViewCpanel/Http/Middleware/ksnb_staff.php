<?php


namespace Modules\ViewCpanel\Http\Middleware;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface;
use Modules\MongodbCore\Repositories\KsnbRepository;
use Modules\MongodbCore\Entities\UserCpanel as User;

class ksnb_staff
{
    private $userRepo;
    private $ksnbRepository;

    public function __construct(UserCpanelRepositoryInterface $userRepository,
                                KsnbRepository $ksnbRepository
                                )
    {
        $this->userRepo = $userRepository;
        $this->ksnbRepository = $ksnbRepository;

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
        log::info("Middleware ksnb_staff");
        $user = session('user');
        $idReport = $request->id;
        Log::info('User Info: ' . print_r($user, true));
        if (!$user) {
            echo 'Permission denied!'; exit;
        }
        if (!$this->validToken($idReport)) {
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

// check_role_ksnb only staff transgress

    public function validToken($idReport)
    {
        $currentUser = session('user');
        $emailReport = $this->ksnbRepository->getEmailAll($idReport);
        if (in_array($currentUser['email'], $emailReport) || in_array($currentUser['email'], config('viewcpanel.CEO'))) {
            return true;
        } else {
            return false;
        }
    }
}
