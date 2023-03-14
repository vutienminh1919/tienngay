<?php


namespace Modules\AssetTienNgay\Http\Service;


use Modules\AssetTienNgay\Http\Repository\ActionRepository;
use Modules\AssetTienNgay\Model\ActionAsset;

class ActionService extends BaseService
{
    protected $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function validate_create($request)
    {
        $message = [];
        if (empty($request->name)) {
            $message[] = "Tên thao tác không để trống";
        }
        $menu = $this->actionRepository->findOne([ActionAsset::SLUG => slugify($request->name)]);
        if ($menu) {
            $message[] = "Tên thao tác đã tồn tại";
        }
        return $message;
    }

    public function create($request)
    {
        $data = [
            ActionAsset::NAME => $request->name,
            ActionAsset::SLUG => slugify($request->name),
            ActionAsset::STATUS => ActionAsset::ACTIVE,
            ActionAsset::CREATED_AT => time(),
            ActionAsset::CREATED_BY => $request->user_info->email,
        ];
        $this->actionRepository->create($data);
    }

    public function list($request)
    {
        $data = $this->actionRepository->paginate(
            [
                ActionAsset::STATUS => ActionAsset::ACTIVE
            ],
            20,
            ActionAsset::CREATED_AT,
            self::DESC
        );
        return $data;
    }

    public function get_action_add_user($request)
    {
        $actions_id = $request->actions_id;
        if (isset($actions_id) && count($actions_id) > 0) {
            $actions = $this->actionRepository->get_action_add_user($actions_id);
        }else{
            $actions = $this->actionRepository->get_all_action_add_user($actions_id);
        }
        return $actions;
    }
}
