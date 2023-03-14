<?php


namespace Modules\AssetTienNgay\Http\Service;


use Modules\AssetTienNgay\Http\Controllers\View\UserController;
use Modules\AssetTienNgay\Http\Repository\ActionRepository;
use Modules\AssetTienNgay\Http\Repository\ActionUserRepository;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Model\ActionUser;

class ActionUserService extends BaseService
{
    protected $actionUserRepository;
    protected $userRepository;
    protected $actionRepository;

    public function __construct(ActionUserRepository $actionUserRepository,
                                UserRepository $userRepository,
                                ActionRepository $actionRepository)
    {
        $this->actionUserRepository = $actionUserRepository;
        $this->userRepository = $userRepository;
        $this->actionRepository = $actionRepository;
    }

    public function create($request)
    {
        $action = $this->actionUserRepository->findOne([ActionUser::USER_ID => $request->user_id]);
        if ($action) {
            $data = [
                ActionUser::ACTIONS => explode(',', $request->actions),
                ActionUser::UPDATED_AT => time(),
                ActionUser::UPDATED_BY => $request->user_info->email,
            ];
            $this->actionUserRepository->update($action['_id'], $data);
        } else {
            $data = [
                ActionUser::USER_ID => $request->user_id,
                ActionUser::ACTIONS => explode(',', $request->actions),
                ActionUser::CREATED_AT => time(),
                ActionUser::CREATED_BY => $request->user_info->email,
            ];
            $this->actionUserRepository->create($data);
        }
    }

    public function show($request)
    {
        $action = $this->actionUserRepository->findOne([ActionUser::USER_ID => $request->user_id]);
        $action['user'] = $this->userRepository->find($request->user_id);
        $actions = [];
        if (!empty($action['actions']) && count($action['actions']) > 0) {
            foreach ($action['actions'] as $ac) {
                $data = $this->actionRepository->find($ac);
                if ($data) {
                    array_push($actions, $data);
                }
            }
        }
        $action['actions'] = $actions;
        return $action;
    }

    public function get_slug_action_user($request)
    {
        $action = $this->actionUserRepository->findOne([ActionUser::USER_ID => $request->user_info->_id]);
        $actions = [];
        if (!empty($action['actions']) && count($action['actions']) > 0) {
            foreach ($action['actions'] as $ac) {
                $data = $this->actionRepository->find($ac);
                if ($data) {
                    array_push($actions, $data['slug']);
                }
            }
        }
        return $actions;
    }
}
