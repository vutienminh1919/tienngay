<?php


namespace Modules\AssetTienNgay\Http\Service;


use Modules\AssetTienNgay\Http\Repository\BaseRepository;
use Modules\AssetTienNgay\Http\Repository\EquipmentRepository;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Model\EquipmentAsset;

class EquipmentService extends BaseService
{
    protected $equipmentRepository;
    protected $userRepository;

    public function __construct(EquipmentRepository $equipmentRepository,
                                UserRepository $userRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
        $this->userRepository = $userRepository;
    }

    public function create($request)
    {
        $equipment = $this->equipmentRepository->findOne([EquipmentAsset::SLUG => slugify($request->name)]);
        if ($equipment) {
            $this->equipmentRepository->update($equipment->_id, [
                EquipmentAsset::STATUS => EquipmentAsset::ACTIVE,
                EquipmentAsset::UPDATED_AT => time(),
                EquipmentAsset::UPDATED_BY => $request->user_info->email,
            ]);
        } else {
            $this->equipmentRepository->create([
                EquipmentAsset::NAME => $request->name,
                EquipmentAsset::SLUG => slugify($request->name),
                EquipmentAsset::STATUS => EquipmentAsset::ACTIVE,
                EquipmentAsset::LEVEL => $request->level,
                EquipmentAsset::CREATED_AT => time(),
                EquipmentAsset::CREATED_BY => $request->user_info->email
            ]);
        }
    }

    public function add_equip($request)
    {
        $equipment = $this->equipmentRepository->findOne([EquipmentAsset::SLUG => $request->name]);
        if ($equipment) {
            $this->equipmentRepository->update($equipment->_id, [
                EquipmentAsset::STATUS => EquipmentAsset::ACTIVE,
                EquipmentAsset::PARENT_ID => $request->parent_id,
                EquipmentAsset::UPDATED_AT => time(),
                EquipmentAsset::UPDATED_BY => $request->user_info->email,
                EquipmentAsset::NAME => $request->name,
                EquipmentAsset::SLUG => slugify($request->name),
            ]);
        } else {
            $this->equipmentRepository->create(
                [
                    EquipmentAsset::NAME => $request->name,
                    EquipmentAsset::SLUG => slugify($request->name),
                    EquipmentAsset::STATUS => EquipmentAsset::ACTIVE,
                    EquipmentAsset::LEVEL => $request->level,
                    EquipmentAsset::CREATED_AT => time(),
                    EquipmentAsset::CREATED_BY => $request->user_info->email,
                    EquipmentAsset::PARENT_ID => $request->parent_id,
                ]
            );
        }
    }

    public function get_parent()
    {
        $data = $this->equipmentRepository->findManySortColumn(
            [EquipmentAsset::LEVEL => '1'],
            EquipmentAsset::CREATED_AT,
            self::DESC);
        return $data;
    }

    public function get_child($request)
    {
        $data = $this->equipmentRepository->findManySortColumn(
            [EquipmentAsset::PARENT_ID => $request->equipment_id],
            EquipmentAsset::CREATED_AT,
            self::DESC);
        return $data;
    }
}
