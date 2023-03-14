<?php


namespace Modules\AssetTienNgay\Http\Service;


use Modules\AssetTienNgay\Http\Repository\DepartmentRepository;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Model\Department;

class DepartmentService extends BaseService
{
    protected $departmentRepository;
    protected $userRepository;

    public function __construct(DepartmentRepository $departmentRepository,
                                UserRepository $userRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->userRepository = $userRepository;
    }

    public function create($request)
    {
        $department = $this->departmentRepository->findOne([Department::SLUG => slugify($request->name)]);
        if ($department) {
            if ($department->status != Department::ACTIVE) {
                $this->departmentRepository->update($department->_id, [
                    Department::STATUS => Department::ACTIVE,
                    Department::UPDATED_AT => time(),
                    Department::UPDATED_BY => $request->user_info->email,
                ]);
            }
        } else {
            $this->departmentRepository->create([
                Department::NAME => $request->name,
                Department::TYPE => $request->type,
                Department::SLUG => slugify($request->name),
                Department::STATUS => Department::ACTIVE,
                Department::LEVEL => $request->level,
                Department::CREATED_AT => time(),
                Department::CREATED_BY => $request->user_info->email
            ]);
        }
    }

    public function check_unique($request)
    {
        $message = [];
        $department = $this->departmentRepository->findOne([Department::SLUG => slugify($request->name)]);
        if ($department) {
            if ($department->status == Department::ACTIVE) {
                $message[] = 'Tên đã tồn tại';
            }
        }
        return $message;
    }

    public function add_user($request)
    {
        $user = $this->userRepository->find($request->user_id);
        $user_department = $this->departmentRepository->findOne([Department::USER_ID => $request->user_id]);
        if ($user_department) {
            $this->departmentRepository->update($user_department->_id, [
                Department::STATUS => Department::ACTIVE,
                Department::PARENT_ID => $request->parent_id,
                Department::UPDATED_AT => time(),
                Department::UPDATED_BY => $request->user_info->email,
                Department::NAME => $user->full_name,
                Department::SLUG => slugify($user->full_name),
                Department::USER_NAME => $user->full_name,
            ]);
        } else {
            $this->departmentRepository->create(
                [
                    Department::NAME => $user->full_name,
                    Department::SLUG => slugify($user->full_name),
                    Department::STATUS => Department::ACTIVE,
                    Department::LEVEL => $request->level,
                    Department::CREATED_AT => time(),
                    Department::CREATED_BY => $request->user_info->email,
                    Department::USER_EMAIL => $user->email,
                    Department::USER_ID => $request->user_id,
                    Department::USER_NAME => $user->full_name,
                    Department::PARENT_ID => $request->parent_id,
                ]
            );
        }
    }

    public function get_depart()
    {
        $data = $this->departmentRepository->findManySortColumn(
            [Department::LEVEL => '1'],
            Department::CREATED_AT,
            self::DESC
        );
        return $data;
    }

    public function get_user_depart($request)
    {
        $data = $this->departmentRepository->findManySortColumn(
            [Department::PARENT_ID => $request->depart_id],
            Department::CREATED_AT,
            self::DESC
        );
        return $data;
    }

    public function show($request)
    {
        return $this->departmentRepository->find($request->id);

    }
}
