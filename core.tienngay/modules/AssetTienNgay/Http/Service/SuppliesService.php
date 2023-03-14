<?php


namespace Modules\AssetTienNgay\Http\Service;


use Carbon\Carbon;
use Modules\AssetTienNgay\Http\Repository\CodeRepository;
use Modules\AssetTienNgay\Http\Repository\LogSuppliesRepository;
use Modules\AssetTienNgay\Http\Repository\MenuAssetRepository;
use Modules\AssetTienNgay\Http\Repository\NotificationRepository;
use Modules\AssetTienNgay\Http\Repository\SuppliesRepository;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Http\Repository\WarehouseRepository;
use Modules\AssetTienNgay\Model\CodeAsset;
use Modules\AssetTienNgay\Model\LogSuppliesAsset;
use Modules\AssetTienNgay\Model\MenuAsset;
use Modules\AssetTienNgay\Model\NotificationAsset;
use Modules\AssetTienNgay\Model\SuppliesAsset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class SuppliesService extends BaseService
{
    protected $suppliesRepository;
    protected $logSuppliesRepository;
    protected $menuRepository;
    protected $userRepository;
    protected $roleService;
    protected $upload;
    protected $notificationService;
    protected $notificationRepository;
    protected $codeRepository;
    protected $codeService;
    protected $sendEmail;

    public function __construct(SuppliesRepository $suppliesRepository,
                                LogSuppliesRepository $logSuppliesRepository,
                                MenuAssetRepository $menuRepository,
                                UserRepository $userRepository,
                                RoleService $roleService,
                                Upload $upload,
                                NotificationService $notificationService,
                                NotificationRepository $notificationRepository,
                                CodeRepository $codeRepository,
                                CodeService $codeService,
                                SendEmail $sendEmail)
    {
        $this->suppliesRepository = $suppliesRepository;
        $this->logSuppliesRepository = $logSuppliesRepository;
        $this->menuRepository = $menuRepository;
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
        $this->upload = $upload;
        $this->notificationService = $notificationService;
        $this->notificationRepository = $notificationRepository;
        $this->codeRepository = $codeRepository;
        $this->codeService = $codeService;
        $this->sendEmail = $sendEmail;
    }

    public function create($request)
    {
        $data = [
            SuppliesAsset::NAME => $request->name,
            SuppliesAsset::SLUG => slugify($request->name),
            SuppliesAsset::CODE => $request->code,
            SuppliesAsset::PRICE => (int)$request->price,
            SuppliesAsset::SUPPLIER => $request->supplier,
            SuppliesAsset::SLUG_SUPPLIER => slugify($request->supplier),
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_MOI,
            SuppliesAsset::PURCHASE_DATE => strtotime($request->purchase_date),
            SuppliesAsset::DESCRIPTION => isset($request->description) ? $request->description : "",
            SuppliesAsset::IMAGE_AVATAR_ASSET => isset($request->image_avatar_asset) ? $request->image_avatar_asset : '',
            SuppliesAsset::IMAGE_ASSET => isset($request->image_asset) ? $request->image_asset : '',
            SuppliesAsset::WAREHOUSE_ID => $request->warehouse_id,
            SuppliesAsset::WARRANTY_PERIOD => strtotime($request->warranty_period),
            SuppliesAsset::EQUIPMENT_ID => $request->equipment_id,
            SuppliesAsset::EQUIPMENT_CHILD_ID => $request->equipment_child_id,
            SuppliesAsset::CREATED_AT => time(),
            SuppliesAsset::CREATED_BY => $request->user_info->email,
            SuppliesAsset::FLAG => SuppliesAsset::ACTIVE,
        ];
        $supplies = $this->suppliesRepository->create($data);
        $this->logSuppliesRepository->create(
            [
                LogSuppliesAsset::NEW => $supplies,
                LogSuppliesAsset::NEW_STATUS => SuppliesAsset::THIET_BI_MOI,
                LogSuppliesAsset::TYPE => LogSuppliesAsset::CREATE,
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::IMAGE_DESCRIPTION => isset($request->image_asset) ? $request->image_asset : '',
                LogSuppliesAsset::CREATED_BY => $request->user_info->email,
                LogSuppliesAsset::SUPPLIES_ID => $supplies['_id']
            ]
        );
    }

    public function get_all_paginate($request)
    {
        $data_department = $this->roleService->get_department_manager_by_user_administrative($request);
        $request->data_department = $data_department;
        $data_warehouse = $this->roleService->get_warehouse_manager_by_user_administrative($request);
        $request->data_warehouse = $data_warehouse;
        $data_equipment = $this->roleService->get_equipment_manager_by_user_administrative($request);
        $request->data_equipment = $data_equipment;
        $data = $this->suppliesRepository->get_all_paginate($request);
        foreach ($data as $datum) {
            if (isset($datum->warehouse_id)) {
                $datum->ware = $this->menuRepository->find($datum->warehouse_id);
            }
            if (isset($datum->department_id)) {
                $datum->depart = $this->menuRepository->find($datum->department_id);
            }
            if (isset($datum->user_id)) {
                $datum->user = $this->userRepository->find($datum->user_id);
            }
            if (isset($datum->equipment_id)) {
                $datum->equip = $this->menuRepository->find($datum->equipment_id);
            }
            if (isset($datum->equipment_child_id)) {
                $datum->equip_child = $this->menuRepository->find($datum->equipment_child_id);
            }
            if (!empty($datum->image_avatar_asset) && count($datum->image_avatar_asset) > 0) {
                foreach ($datum->image_avatar_asset as $item) {
                    $datum->avatar = $item['path'];
                }
            }
            if (!empty($datum->status_request)) {
                $datum->type_request = category_request($datum->status_request);
                $datum->color_type_request = color_category_request($datum->status_request);
            }
        }
        return $data;
    }

    public function get_count_all($request)
    {
        $data = [];
        $data_department = $this->roleService->get_department_manager_by_user_administrative($request);
        $request->data_department = $data_department;
        $data_warehouse = $this->roleService->get_warehouse_manager_by_user_administrative($request);
        $request->data_warehouse = $data_warehouse;
        $data_equipment = $this->roleService->get_equipment_manager_by_user_administrative($request);
        $request->data_equipment = $data_equipment;
        $data['total'] = $this->suppliesRepository->get_count_all($request);
        $request->status = SuppliesAsset::THIET_BI_CHO_XU_LY;
        $data['warning'] = $this->suppliesRepository->get_count_all($request);
        $request->status = SuppliesAsset::THIET_BI_DANG_SU_DUNG;
        $data['using'] = $this->suppliesRepository->get_count_all($request);
        $request->status = SuppliesAsset::THIET_BI_LUU_KHO;
        $data['saving'] = $this->suppliesRepository->get_count_all($request);
        $request->status = SuppliesAsset::THIET_BI_HONG;
        $data['fail'] = $this->suppliesRepository->get_count_all($request);
        $request->status = SuppliesAsset::THIET_BI_MOI;
        $data['new'] = $this->suppliesRepository->get_count_all($request);
        return $data;
    }

    public function show($request)
    {
        $data = $this->suppliesRepository->find($request->supplies_id);
        if (isset($data['warehouse_id'])) {
            $data['ware'] = $this->menuRepository->find($data['warehouse_id']);
        }
        if (isset($data['department_id'])) {
            $data['depart'] = $this->menuRepository->find($data['department_id']);
        }
        if (isset($data['user_id'])) {
            $data['user'] = $this->userRepository->find($data['user_id']);
        }
        if (isset($data['equipment_id'])) {
            $data['equip'] = $this->menuRepository->find($data['equipment_id']);
        }
        if (isset($data['equipment_child_id'])) {
            $data['equip_child'] = $this->menuRepository->find($data['equipment_child_id']);
        }
        $data['log'] = $this->logSuppliesRepository->findManySortColumn(
            [LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id],
            LogSuppliesAsset::CREATED_AT,
            self::DESC
        );
        foreach ($data['log'] as $log) {
            if (isset($log['new']['user_id'])) {
                $user = $this->userRepository->find($log['new']['user_id']);
                $log['user'] = $user;
            }
        }
        $data['request'] = $this->logSuppliesRepository->findRequest($request->supplies_id);
        if (!empty($data['status_request'])) {
            $data['type_request'] = category_request($data['status_request']);
            $data['color_type_request'] = color_category_request($data['status_request']);
        }
        return $data;
    }

    public function list_app($request)
    {
        $role = $this->roleService->get_slug_role_user($request);
        if ($role) {
            $data = $this->suppliesRepository->get_list_app($request);
            $fitter = true;
        } else {
            $fitter = false;
            $request->user_id = $request->user_info->_id;
            $data = $this->suppliesRepository->get_list_app($request);
        }
        $result = [];
        $result['fitter'] = $fitter;
        $result['data'] = [];
        foreach ($data as $key => $datum) {
            if (!empty($datum->image_avatar_asset) && count($datum->image_avatar_asset) > 0) {
                foreach ($datum->image_avatar_asset as $value) {
                    $image = $value['path'];
                }
            } else {
                $image = SuppliesAsset::IMAGE_LOGO;
            }
            $result['data'][$key]['_id'] = $datum->_id;
            if ($datum->status != SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
                $result['data'][$key]['tinh_trang'] = supplies_status($datum->status);
                $result['data'][$key]['color_status'] = color_status($datum->status);
            } else {
                if (!empty($datum->status_receive) && $datum->status_receive == true) {
                    $result['data'][$key]['tinh_trang'] = supplies_status($datum->status);
                    $result['data'][$key]['color_status'] = color_status($datum->status);

                } else {
                    $result['data'][$key]['tinh_trang'] = "Chờ tiếp nhận thiết bị";
                    $result['data'][$key]['color_status'] = '#ffd700';

                }
            }
            $result['data'][$key]['ten_thiet_bi'] = $datum->name;
            $result['data'][$key]['anh_thiet_bi'] = $image;
            $result['data'][$key]['nguoi_su_dung'] = 'Chưa có';
            if (!empty($datum->user_id)) {
                $user = $this->userRepository->find($datum->user_id);
                $result['data'][$key]['nguoi_su_dung'] = $user['email'];
            }
            $result['data'][$key]['phong_ban'] = "Chưa có";
            if (isset($datum->department_id)) {
                $depart = $this->menuRepository->find($datum->department_id);
                $result['data'][$key]['phong_ban'] = $depart['name'];
            }
        }
        return $result;
    }

    public function show_app($request)
    {
        $result = [];
        $data = $this->suppliesRepository->find($request->supplies_id);
        if ($data) {
            $result['nguoi_tao'] = $data['created_by'];
            $result['ngay_tao'] = date('d/m/Y', $data['created_at']);
            if (!empty($data['user_id'])) {
                $user = $this->userRepository->find($data->user_id);
                $result['nguoi_su_dung'] = $user->full_name;
            } else {
                $result['nguoi_su_dung'] = '';
            }
            $result['_id'] = $data['_id'];
            $result['ma_thiet_bi'] = !empty($data['code']) ? $data['code'] : $data['_id'];
            $result['ten_thiet_bi'] = $data['name'];
            if ($data['status'] != SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
                $result['tinh_trang'] = supplies_status($data['status']);
                $result['color_status'] = color_status($data['status']);
            } else {
                if (!empty($data['status_receive']) && $data['status_receive'] == true) {
                    $result['tinh_trang'] = supplies_status($data['status']);
                    $result['color_status'] = color_status($data['status']);

                } else {
                    $result['tinh_trang'] = "Chờ tiếp nhận thiết bị";
                    $result['color_status'] = '#ffd700';

                }
            }
            $result['ghi_chu'] = check_undefined($data['description']);
            $data['image_asset'] = check_undefined($data['image_avatar_asset']);
            $result['hinh_anh'] = [];
            if (!empty($data['image_asset']) && count($data['image_asset']) > 0) {
                foreach ($data['image_asset'] as $datum) {
                    $result['hinh_anh'][] = $datum['path'];
                }
            } else {
                $result['hinh_anh'][] = SuppliesAsset::IMAGE_LOGO;
            }
            $role = $this->roleService->get_slug_role_user($request);
            if ($role) {
                if ($data['status'] == SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
                    if (!empty($data['status_receive']) && $data['status_receive'] == true) {
                        $result['permission'] = true;
                        $result['btn_confirm'] = false;
                    } else {
                        $result['permission'] = false;
                        $result['btn_confirm'] = true;
                    }
                } else {
                    $result['permission'] = false;
                    $result['btn_confirm'] = false;
                }
            } else {
                if (!empty($data['user_id'])) {
                    if ($data['user_id'] == $request->user_info->_id) {
                        if ($data['status'] == SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
                            if (!empty($data['status_receive']) && $data['status_receive'] == true) {
                                $result['permission'] = true;
                                $result['btn_confirm'] = false;
                            } else {
                                $result['permission'] = false;
                                $result['btn_confirm'] = true;
                            }
                        } else {
                            $result['permission'] = false;
                            $result['btn_confirm'] = false;
                        }
                    } else {
                        $result['permission'] = false;
                        $result['btn_confirm'] = false;
                    }
                } else {
                    $result['permission'] = false;
                    $result['btn_confirm'] = false;
                }
            }
            return $result;
        } else {
            return null;
        }
    }

    public function get_all($request)
    {
        $data_department = $this->roleService->get_department_manager_by_user_administrative($request);
        $request->data_department = $data_department;
        $data_warehouse = $this->roleService->get_warehouse_manager_by_user_administrative($request);
        $request->data_warehouse = $data_warehouse;
        $data_equipment = $this->roleService->get_equipment_manager_by_user_administrative($request);
        $request->data_equipment = $data_equipment;
        $data = $this->suppliesRepository->get_all($request);
        foreach ($data as $datum) {
            if (!empty($datum['user_id'])) {
                $datum['user'] = $this->userRepository->find($datum->user_id);
            }
        }

        return $data;
    }

    public function validate_create($request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required",
//            "price" => "required",
//            "supplier" => "required",
//            "purchase_date" => "required|before:tomorrow",
            "equipment_id" => "required",
            "equipment_child_id" => "required",
            "warehouse_id" => "required",
//            "warranty_period" => "required",
//            "image_avatar_asset" => "required",
//            "image_asset" => "required",
        ], [
            "name.required" => "Tên thiết bị không được để trống!",
//            "price.required" => "Giá thiết bị không được để trống!",
//            "supplier.required" => "Nhà cung cấp thiết bị không được để trống!",
//            "purchase_date.required" => "Ngày mua thiết bị không được để trống!",
//            "purchase_date.before" => "Ngày mua thiết bị không lớn hơn ngày hiện tại!",
            "equipment_id.required" => "Loại thiết bị không được để trống!",
            "equipment_child_id.required" => "Dòng thiết bị không được để trống!",
            "warehouse_id.required" => "Kho lưu trữ không được để trống!",
//            "warranty_period.required" => "Thời hạn bảo hành không được để trống!",
//            "image_avatar_asset.required" => "Ảnh đại diện thiết bị không được để trống!",
//            "image_asset.required" => "Ảnh mô tả thiết bị không được để trống!",
        ]);

        return $validate;
    }

    public function assign_user($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::DEPARTMENT_ID => $request->department_id,
            SuppliesAsset::USER_ID => $request->user_id,
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
            SuppliesAsset::DATE_RECEIVE => strtotime($request->delivery_date),
            SuppliesAsset::DATE_STORAGE => '',
            SuppliesAsset::WAREHOUSE_ID => '',
            SuppliesAsset::STATUS_RECEIVE => false,
            SuppliesAsset::DATE_STATUS_RECEIVE => '',
        ]);

        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::ASSIGN,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => $request->note,
            LogSuppliesAsset::USER_RECEIVE => $request->user_id,
            LogSuppliesAsset::DELIVERY_DATE => strtotime($request->delivery_date),
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::CREATED_BY => $request->user_info->email
        ]);
        if (!empty($request->user_id)) {
            $message = "Thiết bị " . $supplies_new['name'] . ' vừa được cập nhật cho bạn, vui lòng xác nhận khi nhận được thiết bị';
            $title = "Bàn giao thiết bị";
            $this->notificationService->push_notification($log, $request->user_id, $message, $title, $request);
        }
        if (empty($supplies_new['code']) || $supplies_new['code'] == null) {
            $this->code($supplies_new);
        }
    }

    public function change_user($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::DEPARTMENT_ID => $request->department_id,
            SuppliesAsset::USER_ID => $request->user_id,
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
            SuppliesAsset::DATE_RECEIVE => strtotime($request->delivery_date),
            SuppliesAsset::DATE_STORAGE => '',
            SuppliesAsset::WAREHOUSE_ID => '',
            SuppliesAsset::STATUS_RECEIVE => false,
            SuppliesAsset::DATE_STATUS_RECEIVE => '',
        ]);

        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::CHANGE,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => $request->note,
            LogSuppliesAsset::USER_RECEIVE => $request->user_id,
            LogSuppliesAsset::DELIVERY_DATE => strtotime($request->delivery_date),
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::CREATED_BY => $request->user_info->email
        ]);
        if (!empty($request->user_id)) {
            $message = "Thiết bị " . $supplies_new['name'] . ' vừa được cập nhật cho bạn, vui lòng xác nhận khi nhận được thiết bị';
            $title = "Bàn giao thiết bị";
            $this->notificationService->push_notification($log, $request->user_id, $message, $title, $request);
        }
        if (empty($supplies_new['code']) || $supplies_new['code'] == null) {
            $this->code($supplies_new);
        }
    }

    public function storage($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::DEPARTMENT_ID => '',
            SuppliesAsset::USER_ID => '',
            SuppliesAsset::DATE_RECEIVE => '',
            SuppliesAsset::RECEPTION_STAFF => '',
            SuppliesAsset::STATUS_REQUEST => '',
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_LUU_KHO,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
            SuppliesAsset::DATE_STORAGE => strtotime($request->storage_date),
            SuppliesAsset::WAREHOUSE_ID => $request->warehouse_id,
            SuppliesAsset::DATE_STATUS_RECEIVE => '',
            SuppliesAsset::STATUS_RECEIVE => '',
        ]);

        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::STORAGE,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => SuppliesAsset::THIET_BI_LUU_KHO,
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => $request->note,
            LogSuppliesAsset::DATE_STORAGE => strtotime($request->storage_date),
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::CREATED_BY => $request->user_info->email
        ]);
        if (!empty($supplies_old['user_id'])) {
            $message = "P.HCNS đã xác nhận lưu kho thiết bị " . $supplies_old['name'];
            $title = "Xác nhận lưu kho";
            $this->notificationService->push_notification($log, $supplies_old['user_id'], $message, $title, $request);
        }
    }

    public function broken($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::DEPARTMENT_ID => '',
            SuppliesAsset::USER_ID => '',
            SuppliesAsset::DATE_RECEIVE => '',
            SuppliesAsset::RECEPTION_STAFF => '',
            SuppliesAsset::STATUS_REQUEST => '',
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_HONG,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
            SuppliesAsset::DATE_STORAGE => strtotime($request->storage_date),
            SuppliesAsset::WAREHOUSE_ID => $request->warehouse_id,
            SuppliesAsset::DATE_STATUS_RECEIVE => '',
            SuppliesAsset::STATUS_RECEIVE => '',
        ]);

        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::BROKEN,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => SuppliesAsset::THIET_BI_HONG,
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => $request->note,
            LogSuppliesAsset::DATE_STORAGE => strtotime($request->storage_date),
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::CREATED_BY => $request->user_info->email
        ]);
        if (!empty($supplies_old['user_id'])) {
            $message = "P.HCNS đã xác nhận thiết bị " . $supplies_old['name'] . " bị hỏng và cập nhật lưu kho";
            $title = "Xác nhận hỏng và lưu kho";
            $this->notificationService->push_notification($log, $supplies_old['user_id'], $message, $title, $request);
        }
    }

    public function upload($request)
    {
        $data = [];
        if ($_FILES['file']) {
            $cfile = new \CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
            $push_upload = $this->upload->pushUpload($cfile);
            if (isset($push_upload->code) && $push_upload->code == 200) {
                $data['path'] = $push_upload->path;
                $data['file_type'] = $_FILES['file']["type"];
                $data['file_name'] = $_FILES['file']["name"];
                $data['key'] = uniqid();
            }
        }
        return $data;
    }

    public function check_upload($request)
    {
        $message = [];
        if (empty($_FILES['file'])) {
            $message[] = "File không để trống";
        }

        if (!empty($_FILES['file']) && $_FILES['file']['size'] > 15000000) {
            $message[] = "Kích thước quá lớn";
        }

        $acceptFormat = array("jpeg", "png", "jpg");
        if (!empty($_FILES['file']) && in_array($_FILES['file']['type'], $acceptFormat)) {
            $message[] = "Định dạng không cho phép";
        }
        return $message;
    }

    public function send_request($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_CHO_XU_LY,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::STATUS_REQUEST => $request->type_request
        ]);
        $data_image = [];
        if (!empty($request->image_description)) {
            foreach ($request->image_description as $value) {
                $data_image[$value['key']] = $value;
            }
        }

        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => (int)$request->type_request,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => SuppliesAsset::THIET_BI_CHO_XU_LY,
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => $request->note,
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::USER_RECEIVE => $supplies_new['user_id'],
            LogSuppliesAsset::CREATED_BY => $request->user_info->email,
            LogSuppliesAsset::IMAGE_DESCRIPTION => $data_image
        ]);
        $user_hcns = $this->roleService->get_user_manager_supplies($supplies_old['department_id']);
        if (count($user_hcns) > 0) {
            $message = "Nhân sự " . $request->user_info->email . " gửi yêu cầu " . category_request($request->type_request) . ' cho thiết bị ' . $supplies_new['name'];
            $title = category_request($request->type_request);
            foreach ($user_hcns as $user) {
                $this->notificationService->push_notification($log, $user, $message, $title, $request);
            }
        }

        if ($request->type_request == 3) {
            $department = $this->menuRepository->findAttributesToArray($supplies_new['department_id']);
            $equipment = $this->menuRepository->findAttributesToArray($supplies_new['equipment_id']);

            if (in_array($equipment['slug'], ['dien-dan-dung', 'xay-dung-co-ban'])) {
                $data_send = [
                    'name_asset' => $supplies_new['name'] ?? '',
                    'code_asset' => $supplies_new['code'] ?? "",
                    'department' => $department['name'] ?? "",
                    'employee' => $request->user_info->email ?? "",
                    'note' => $request->note ?? "",
                    'time' => date('d-m-Y H:i:s'),
                    'link' => env('URL_ASSET_CMS') . 'supplies/show/' . $request->supplies_id,
                    'email' => 'xdcb@tienngay.vn',
                    "code" => "vfc_send_device_error_report"
                ];
                $this->sendEmail->send_Email($data_send);
            }
        }
    }

    public function validate_send_request($request)
    {
        $message = [];
        if (empty($request->supplies_id)) {
            $message[] = "Id thiết bị không để trống";
        }
        if (empty($request->type_request)) {
            $message[] = "Loại yêu cầu không để trống";
        }
        if (empty($request->note)) {
            $message[] = "Ghi chú không để trống";
        }
//        if (empty($request->image_description)) {
//            $message[] = "Ảnh mô tả không để trống";
//        }

        $supplies = $this->suppliesRepository->findOne([SuppliesAsset::ID => $request->supplies_id]);
        if ($supplies['status'] == SuppliesAsset::THIET_BI_CHO_XU_LY) {
            $message[] = "Thiết bị đang có yêu cầu chờ xử lý, không thể tạo thêm yêu cầu";
        }

        if ($request->user_info->_id != $supplies['user_id']) {
            $message[] = "Bạn không phải người sử dụng thiết bị này";
        }

        if ($supplies['status'] == SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
            if (!empty($supplies['status_receive']) && $supplies['status_receive'] == false) {
                $message[] = "Bạn chưa xác nhận tiếp nhận thiết bị, không thể gửi yêu cầu";
            }
        }
        return $message;
    }

    public function accept($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::RECEPTION_STAFF => $request->user_info->email,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
        ]);

        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::ACCEPT,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => $request->note,
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::CREATED_BY => $request->user_info->email
        ]);
        $message = "BP.HCNS đã tiếp nhận yêu cầu " . category_request($supplies_old['status_request']) . " của bạn về thiết bị " . $supplies_new['name'] . ' và sẽ phản hồi trong thời gian sớm nhất';
        $title = "Tiếp nhận yêu cầu";
        $this->notificationService->push_notification($log, $supplies_new['user_id'], $message, $title, $request);
    }

    public function validate_assign_user($request)
    {
        $validate = Validator::make($request->all(), [
            "department_id" => "required",
//            "user_id" => "required",
            "delivery_date" => "required|before:tomorrow",
        ], [
            "department_id.required" => "Phòng ban không để trống",
//            "user_id.required" => "Nhân viên không để trống",
            "delivery_date.required" => "Ngày ban giao không để trống",
            "delivery_date.before" => "Ngày ban giao không lớn hơn ngày hiện tại",
        ]);

        return $validate;
    }

    public function validate_change_user($request)
    {
        $validate = Validator::make($request->all(), [
            "department_id" => "required",
//            "user_id" => "required",
            "delivery_date" => "required|before:tomorrow",
        ], [
            "department_id.required" => "Phòng ban không để trống",
//            "user_id.required" => "Nhân viên không để trống",
            "delivery_date.required" => "Ngày ban giao không để trống",
            "delivery_date.before" => "Ngày ban giao không lớn hơn ngày hiện tại",
        ]);

        return $validate;
    }

    public function validate_storage($request)
    {
        $validate = Validator::make($request->all(), [
            "warehouse_id" => "required",
            "storage_date" => "required|before:tomorrow",
        ], [
            "warehouse_id.required" => "Kho lưu trữ không để trống",
            "storage_date.required" => "Ngày lưu kho không để trống",
            "storage_date.before" => "Ngày lưu kho không lớn hơn ngày hiện tại",
        ]);

        return $validate;
    }

    public function validate_broken($request)
    {
        $validate = Validator::make($request->all(), [
            "warehouse_id" => "required",
            "storage_date" => "required|before:tomorrow",
        ], [
            "warehouse_id.required" => "Kho lưu trữ không để trống",
            "storage_date.required" => "Ngày lưu kho không để trống",
            "storage_date.before" => "Ngày lưu kho không lớn hơn ngày hiện tại",
        ]);

        return $validate;
    }

    public function validate_update_info($request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required",
            "price" => "required",
            "supplier" => "required",
            "purchase_date" => "required|before:tomorrow",
            "equipment_id" => "required",
            "equipment_child_id" => "required",
            "warehouse_id" => "required",
            "warranty_period" => "required",
        ], [
            "name.required" => "Tên thiết bị không được để trống!",
            "price.required" => "Giá thiết bị không được để trống!",
            "supplier.required" => "Nhà cung cấp thiết bị không được để trống!",
            "purchase_date.required" => "Ngày mua thiết bị không được để trống!",
            "purchase_date.before" => "Ngày mua thiết bị lớn hơn ngày hiện tại!",
            "equipment_id.required" => "Loại thiết bị không được để trống!",
            "equipment_child_id.required" => "Dòng thiết bị không được để trống!",
            "warehouse_id.required" => "Kho lưu trữ không được để trống!",
            "warranty_period.required" => "Thời hạn bảo hành không được để trống!",
        ]);

        return $validate;
    }

    public function update_info($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $data = [
            SuppliesAsset::NAME => $request->name,
            SuppliesAsset::SLUG => slugify($request->name),
            SuppliesAsset::PRICE => (int)$request->price,
            SuppliesAsset::SUPPLIER => $request->supplier,
            SuppliesAsset::SLUG_SUPPLIER => slugify($request->supplier),
            SuppliesAsset::PURCHASE_DATE => strtotime($request->purchase_date),
            SuppliesAsset::DESCRIPTION => isset($request->description) ? $request->description : "",
            SuppliesAsset::WAREHOUSE_ID => $request->warehouse_id,
            SuppliesAsset::WARRANTY_PERIOD => strtotime($request->warranty_period),
            SuppliesAsset::EQUIPMENT_ID => $request->equipment_id,
            SuppliesAsset::EQUIPMENT_CHILD_ID => $request->equipment_child_id,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
        ];
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, $data);
        $this->logSuppliesRepository->create(
            [
                LogSuppliesAsset::OLD => $supplies_old,
                LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
                LogSuppliesAsset::NEW => $supplies_new,
                LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
                LogSuppliesAsset::TYPE => LogSuppliesAsset::UPDATE,
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email,
                LogSuppliesAsset::SUPPLIES_ID => $supplies_new['_id'],
                LogSuppliesAsset::NOTE => $request->description
            ]
        );
    }

    public function validate_verified($request)
    {
        $validate = Validator::make($request->all(), [
            "inventory_date" => "required|before:tomorrow",
        ], [
            "inventory_date.required" => "Ngày kiểm kê không để trống",
            "inventory_date.before" => "Ngày kiểm kê không lớn hơn ngày hiện tại",
        ]);
        return $validate;
    }

    public function verified($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::INVENTORY_DATE => strtotime($request->inventory_date),
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
        ]);

        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::VERIFIED,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => $request->note,
            LogSuppliesAsset::INVENTORY_DATE => strtotime($request->inventory_date),
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::CREATED_BY => $request->user_info->email
        ]);
        $message = "BP.HCNS đã xác thực kiểm kê về thiết bị " . $supplies_new['name'] . " .Xin cảm ơn";
        $title = "Xác thực kiểm kê";
        $this->notificationService->push_notification($log, $supplies_new['user_id'], $message, $title, $request);
    }

    public function validate_update_image($request)
    {
        $validate = Validator::make($request->all(), [
            "image_asset" => "required",
        ], [
            "image_asset.required" => "Hình ảnh không để trống",
        ]);

        return $validate;
    }

    public function update_image($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $data = [
            SuppliesAsset::IMAGE_ASSET => $request->image_asset,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
        ];
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, $data);
        $this->logSuppliesRepository->create(
            [
                LogSuppliesAsset::OLD => $supplies_old,
                LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
                LogSuppliesAsset::NEW => $supplies_new,
                LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
                LogSuppliesAsset::TYPE => LogSuppliesAsset::UPDATE,
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email,
                LogSuppliesAsset::SUPPLIES_ID => $supplies_new['_id'],
            ]
        );
    }

    public function validate_confirm($request)
    {
        $message = [];
        if (empty($request->supplies_id)) {
            $message[] = "Id thiết bị không để trống";
        }
        if (empty($request->note)) {
            $message[] = "Ghi chú không để trống";
        }
        if (empty($request->image_description)) {
            $message[] = "Ảnh mô tả không để trống";
        }
        $supplies = $this->suppliesRepository->findOne([SuppliesAsset::ID => $request->supplies_id]);
        if ($supplies['status'] != SuppliesAsset::THIET_BI_DANG_SU_DUNG) {
            $message[] = "Gửi yêu cầu không hợp lệ";
        } else {
            if (!empty($supplies['status_receive']) && $supplies['status_receive'] !== false) {
                $message[] = "Gửi yêu cầu không hợp lệ";
            }
        }
        if ($request->user_info->_id != $supplies['user_id']) {
            $message[] = "Bạn không phải người sử dụng thiết bị này";
        }
        return $message;
    }

    public function confirm($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::STATUS_RECEIVE => true,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::DATE_STATUS_RECEIVE => time(),
        ]);
        $data_image = [];
        foreach ($request->image_description as $value) {
            $data_image[$value['key']] = $value;
        }
        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::CONFIRM,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => $request->note,
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::DATE_STATUS_RECEIVE => time(),
            LogSuppliesAsset::USER_RECEIVE => $supplies_new['user_id'],
            LogSuppliesAsset::CREATED_BY => $request->user_info->email,
            LogSuppliesAsset::IMAGE_DESCRIPTION => $data_image
        ]);

        $user_hcns = $this->roleService->get_user_manager_supplies($supplies_old['department_id']);
        if (count($user_hcns) > 0) {
            $message = "Nhân sự " . $request->user_info->email . ' đã xác nhận tiếp nhận thiết bị ' . $supplies_new['name'];
            $title = "Tiếp nhận thiết bị";
            foreach ($user_hcns as $user) {
                $this->notificationService->push_notification($log, $user, $message, $title, $request);
            }
        }
    }

    public function validate_import_use($request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required",
//            "price" => "required",
//            "supplier" => "required",
//            "purchase_date" => "required|date|before:tomorrow",
            "equipment_child_id" => "required",
//            "warranty_period" => "required|date",
            "user_id" => "required",
//            "delivery_date" => "required|date",
        ], [
            "name.required" => "Tên thiết bị không được để trống!",
//            "price.required" => "Giá thiết bị không được để trống!",
//            "supplier.required" => "Nhà cung cấp thiết bị không được để trống!",
//            "purchase_date.required" => "Ngày mua thiết bị không được để trống!",
//            "purchase_date.date" => "Ngày mua thiết bị không đúng định dạng YYYY-mm-dd",
//            "purchase_date.before" => "Ngày mua thiết bị không lớn hơn ngày hiện tại!",
            "equipment_child_id.required" => "Dòng thiết bị không được để trống!",
//            "warranty_period.required" => "Thời hạn bảo hành không được để trống!",
//            "warranty_period.date" => "Thời hạn bảo hành không đúng định dạng YYYY-mm-dd",
            "user_id.required" => "Nhân viên không được để trống!",
//            "delivery_date.required" => "Ngày bàn giao không được để trống!",
//            "delivery_date.date" => "Ngày bàn giao không đúng định dạng YYYY-mm-dd",
        ]);

        return $validate;
    }

    public function import_use($request)
    {
        $message = [];
        if (!empty($request->user_id)) {
            $category_user = $this->menuRepository->findOne([MenuAsset::NAME => $request->user_id, MenuAsset::STATUS => MenuAsset::ACTIVE]);
            if ($category_user) {
                $category_departmant = $this->menuRepository->find($category_user['parent_id']);
            } else {
                $message[] = "Không tìn thấy thông tin nhân viên " . "(" . $request->user_id . ")";
                return $message;
            }
        } else {
            $message[] = "Nhân viên đang trống";
            return $message;
        }

        if (!empty($request->equipment_child_id)) {
            $category_equipment_child = $this->menuRepository->findOne([MenuAsset::SLUG => slugify($request->equipment_child_id)]);
            if ($category_equipment_child) {
                $category_equipment = $this->menuRepository->find($category_equipment_child['parent_id']);
            } else {
                $message[] = "Không tìn thấy thông tin tương ứng dòng thiết bị " . "(" . $request->equipment_child_id . ")";
                return $message;
            }
        } else {
            $message[] = "Dòng thiết bị đang trống";
            return $message;
        }
        $data = [
            SuppliesAsset::NAME => $request->name,
            SuppliesAsset::SLUG => slugify($request->name),
            SuppliesAsset::CODE => $request->code,
            SuppliesAsset::PRICE => (int)$request->price,
            SuppliesAsset::SUPPLIER => $request->supplier,
            SuppliesAsset::SLUG_SUPPLIER => slugify($request->supplier),
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
            SuppliesAsset::PURCHASE_DATE => strtotime($request->purchase_date),
            SuppliesAsset::DESCRIPTION => !empty($request->note) ? $request->note : 'Import dữ liệu',
            SuppliesAsset::WARRANTY_PERIOD => strtotime($request->warranty_period),
            SuppliesAsset::EQUIPMENT_ID => $category_equipment['_id'],
            SuppliesAsset::EQUIPMENT_CHILD_ID => $category_equipment_child['_id'],
            SuppliesAsset::DEPARTMENT_ID => $category_departmant['_id'],
            SuppliesAsset::USER_ID => $category_user['user_id'],
            SuppliesAsset::CREATED_AT => time(),
            SuppliesAsset::CREATED_BY => $request->user_info->email,
            SuppliesAsset::FLAG => SuppliesAsset::ACTIVE,
            SuppliesAsset::DATE_RECEIVE => strtotime($request->delivery_date),
            SuppliesAsset::DATE_STATUS_RECEIVE => strtotime($request->delivery_date),
            SuppliesAsset::STATUS_RECEIVE => true,
        ];
        $supplies = $this->suppliesRepository->create($data);
        $this->logSuppliesRepository->create(
            [
                LogSuppliesAsset::NEW => $supplies,
                LogSuppliesAsset::NEW_STATUS => $supplies['status'],
                LogSuppliesAsset::TYPE => LogSuppliesAsset::IMPORT,
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email,
                LogSuppliesAsset::SUPPLIES_ID => $supplies['_id'],
                LogSuppliesAsset::USER_RECEIVE => $request->user_id,
                LogSuppliesAsset::DELIVERY_DATE => strtotime($request->delivery_date),
                LogSuppliesAsset::DATE_STATUS_RECEIVE => strtotime($request->delivery_date),
                LogSuppliesAsset::NOTE => !empty($request->note) ? $request->note : 'Import dữ liệu',
            ]
        );
        return $message;
    }

    public function validate_import_save($request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required",
//            "price" => "required",
//            "supplier" => "required",
//            "purchase_date" => "required|date|before:tomorrow",
            "equipment_child_id" => "required",
//            "warranty_period" => "required|date",
            "warehouse_id" => "required",
//            "date_storage" => "required|date",

        ], [
            "name.required" => "Tên thiết bị không được để trống!",
//            "price.required" => "Giá thiết bị không được để trống!",
//            "supplier.required" => "Nhà cung cấp thiết bị không được để trống!",
//            "purchase_date.required" => "Ngày mua thiết bị không được để trống!",
//            "purchase_date.date" => "Ngày mua thiết bị không đúng định dạng YYYY-mm-dd!",
//            "purchase_date.before" => "Ngày mua thiết bị không lớn hơn ngày hiện tại!",
            "equipment_child_id.required" => "Dòng thiết bị không được để trống!",
//            "warranty_period.required" => "Thời hạn bảo hành không được để trống!",
//            "warranty_period.date" => "Thời hạn bảo hành không đúng định dạng YYYY-mm-dd!",
            "warehouse_id.required" => "Kho lưu trữ không được để trống!",
//            "date_storage.required" => "Ngày lưu kho không được để trống!",
//            "date_storage.date" => "Ngày lưu kho không đúng định dạng YYYY-mm-dd!",
        ]);

        return $validate;
    }

    public function import_save($request)
    {
        $message = [];
        if (!empty($request->warehouse_id)) {
            $category_warehouse = $this->menuRepository->findOne([MenuAsset::SLUG => slugify($request->warehouse_id)]);
            if (!$category_warehouse) {
                $message[] = "Không tìn thấy thông tin kho tương ứng " . "(" . $request->warehouse_id . ")";
                return $message;
            }
        }

        if (!empty($request->equipment_child_id)) {
            $category_equipment_child = $this->menuRepository->findOne([MenuAsset::SLUG => slugify($request->equipment_child_id)]);
            if ($category_equipment_child) {
                $category_equipment = $this->menuRepository->find($category_equipment_child['parent_id']);
            } else {
                $message[] = "Không tìn thấy thông tin tương ứng dòng thiết bị " . "(" . $request->equipment_child_id . ")";
                return $message;
            }
        }
        $data = [
            SuppliesAsset::NAME => $request->name,
            SuppliesAsset::SLUG => slugify($request->name),
            SuppliesAsset::CODE => $request->code,
            SuppliesAsset::PRICE => (int)$request->price,
            SuppliesAsset::SUPPLIER => $request->supplier,
            SuppliesAsset::SLUG_SUPPLIER => slugify($request->supplier),
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_LUU_KHO,
            SuppliesAsset::PURCHASE_DATE => strtotime($request->purchase_date),
            SuppliesAsset::DESCRIPTION => !empty($request->note) ? $request->note : 'Import dữ liệu',
            SuppliesAsset::WARRANTY_PERIOD => strtotime($request->warranty_period),
            SuppliesAsset::EQUIPMENT_ID => $category_equipment['_id'],
            SuppliesAsset::EQUIPMENT_CHILD_ID => $category_equipment_child['_id'],
            SuppliesAsset::WAREHOUSE_ID => $category_warehouse['_id'],
            SuppliesAsset::CREATED_AT => time(),
            SuppliesAsset::CREATED_BY => $request->user_info->email,
            SuppliesAsset::FLAG => SuppliesAsset::ACTIVE,
            SuppliesAsset::DATE_STORAGE => strtotime($request->date_storage),
        ];
        $supplies = $this->suppliesRepository->create($data);
        $this->logSuppliesRepository->create(
            [
                LogSuppliesAsset::NEW => $supplies,
                LogSuppliesAsset::NEW_STATUS => $supplies['status'],
                LogSuppliesAsset::TYPE => LogSuppliesAsset::IMPORT,
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email,
                LogSuppliesAsset::NOTE => !empty($request->note) ? $request->note : 'Import dữ liệu',
                LogSuppliesAsset::DATE_STORAGE => strtotime($request->date_storage),
                LogSuppliesAsset::SUPPLIES_ID => $supplies['_id']
            ]
        );
        return $message;
    }

    public function validate_import_fail($request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required",
//            "price" => "required",
//            "supplier" => "required",
//            "purchase_date" => "required|date|before:tomorrow",
            "equipment_child_id" => "required",
//            "warranty_period" => "required|date",
            "warehouse_id" => "required",
//            "date_storage" => "required|date",

        ], [
            "name.required" => "Tên thiết bị không được để trống!",
//            "price.required" => "Giá thiết bị không được để trống!",
//            "supplier.required" => "Nhà cung cấp thiết bị không được để trống!",
//            "purchase_date.required" => "Ngày mua thiết bị không được để trống!",
//            "purchase_date.date" => "Ngày mua thiết bị không đúng định dạng YYYY-mm-dd!",
//            "purchase_date.before" => "Ngày mua thiết bị không lớn hơn ngày hiện tại!",
            "equipment_child_id.required" => "Dòng thiết bị không được để trống!",
//            "warranty_period.required" => "Thời hạn bảo hành không được để trống!",
//            "warranty_period.date" => "Thời hạn bảo hành không đúng định dạng YYYY-mm-dd!",
            "warehouse_id.required" => "Kho lưu trữ không được để trống!",
//            "date_storage.required" => "Ngày lưu kho không được để trống!",
//            "date_storage.date" => "Ngày lưu kho không đúng định dạng YYYY-mm-dd!",
        ]);

        return $validate;
    }

    public function import_fail($request)
    {
        $message = [];
        if (!empty($request->warehouse_id)) {
            $category_warehouse = $this->menuRepository->findOne([MenuAsset::SLUG => slugify($request->warehouse_id)]);
            if (!$category_warehouse) {
                $message[] = "Không tìn thấy thông tin kho tương ứng " . "(" . $request->warehouse_id . ")";
                return $message;
            }
        }

        if (!empty($request->equipment_child_id)) {
            $category_equipment_child = $this->menuRepository->findOne([MenuAsset::SLUG => slugify($request->equipment_child_id)]);
            if ($category_equipment_child) {
                $category_equipment = $this->menuRepository->find($category_equipment_child['parent_id']);
            } else {
                $message[] = "Không tìn thấy thông tin tương ứng dòng thiết bị " . "(" . $request->equipment_child_id . ")";
                return $message;
            }
        }
        $data = [
            SuppliesAsset::NAME => $request->name,
            SuppliesAsset::SLUG => slugify($request->name),
            SuppliesAsset::CODE => $request->code,
            SuppliesAsset::PRICE => (int)$request->price,
            SuppliesAsset::SUPPLIER => $request->supplier,
            SuppliesAsset::SLUG_SUPPLIER => slugify($request->supplier),
            SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_HONG,
            SuppliesAsset::PURCHASE_DATE => strtotime($request->purchase_date),
            SuppliesAsset::DESCRIPTION => !empty($request->note) ? $request->note : 'Import dữ liệu',
            SuppliesAsset::WARRANTY_PERIOD => strtotime($request->warranty_period),
            SuppliesAsset::EQUIPMENT_ID => $category_equipment['_id'],
            SuppliesAsset::EQUIPMENT_CHILD_ID => $category_equipment_child['_id'],
            SuppliesAsset::WAREHOUSE_ID => $category_warehouse['_id'],
            SuppliesAsset::CREATED_AT => time(),
            SuppliesAsset::CREATED_BY => $request->user_info->email,
            SuppliesAsset::FLAG => SuppliesAsset::ACTIVE,
            SuppliesAsset::DATE_STORAGE => strtotime($request->date_storage),
        ];
        $supplies = $this->suppliesRepository->create($data);
        $this->logSuppliesRepository->create(
            [
                LogSuppliesAsset::NEW => $supplies,
                LogSuppliesAsset::NEW_STATUS => $supplies['status'],
                LogSuppliesAsset::TYPE => LogSuppliesAsset::IMPORT,
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email,
                LogSuppliesAsset::NOTE => !empty($request->note) ? $request->note : 'Import dữ liệu',
                LogSuppliesAsset::DATE_STORAGE => strtotime($request->date_storage),
                LogSuppliesAsset::SUPPLIES_ID => $supplies['_id']
            ]
        );
        return $message;
    }

    public function get_all_paginate_dashboard($request)
    {
        $data_department = $this->roleService->get_department_manager_by_user_administrative($request);
        $request->data_department = $data_department;
        $data_warehouse = $this->roleService->get_warehouse_manager_by_user_administrative($request);
        $request->data_warehouse = $data_warehouse;
        $data_equipment = $this->roleService->get_equipment_manager_by_user_administrative($request);
        $request->data_equipment = $data_equipment;
        $data = $this->suppliesRepository->get_all_paginate_dashboard($request);
        foreach ($data as $datum) {
            if (isset($datum->warehouse_id)) {
                $datum->ware = $this->menuRepository->find($datum->warehouse_id);
            }
            if (isset($datum->department_id)) {
                $datum->depart = $this->menuRepository->find($datum->department_id);
            }
            if (isset($datum->user_id)) {
                $datum->user = $this->userRepository->find($datum->user_id);
            }
            if (isset($datum->equipment_id)) {
                $datum->equip = $this->menuRepository->find($datum->equipment_id);
            }
            if (isset($datum->equipment_child_id)) {
                $datum->equip_child = $this->menuRepository->find($datum->equipment_child_id);
            }
            if (!empty($datum->image_avatar_asset) && count($datum->image_avatar_asset) > 0) {
                foreach ($datum->image_avatar_asset as $item) {
                    $datum->avatar = $item['path'];
                }
            }
            if (!empty($datum->status_request)) {
                $datum->type_request = category_request($datum->status_request);
                $datum->color_type_request = color_category_request($datum->status_request);
            }
        }
        return $data;
    }

    public function get_all_dashboard($request)
    {
        $data_department = $this->roleService->get_department_manager_by_user_administrative($request);
        $request->data_department = $data_department;
        $data_warehouse = $this->roleService->get_warehouse_manager_by_user_administrative($request);
        $request->data_warehouse = $data_warehouse;
        $data_equipment = $this->roleService->get_equipment_manager_by_user_administrative($request);
        $request->data_equipment = $data_equipment;
        $data = $this->suppliesRepository->get_all_dashboard($request);
        foreach ($data as $datum) {
            if (!empty($datum['user_id'])) {
                $datum['user'] = $this->userRepository->find($datum->user_id);
            }
        }

        return $data;
    }

    public function get_count_all_dashboard($request)
    {
        $data = [];
        $data_department = $this->roleService->get_department_manager_by_user_administrative($request);
        $request->data_department = $data_department;
        $data_warehouse = $this->roleService->get_warehouse_manager_by_user_administrative($request);
        $request->data_warehouse = $data_warehouse;
        $data_equipment = $this->roleService->get_equipment_manager_by_user_administrative($request);
        $request->data_equipment = $data_equipment;
        $data['total'] = $this->suppliesRepository->get_count_all_dashboard($request);
        $request->status = SuppliesAsset::THIET_BI_CHO_XU_LY;
        $data['warning'] = $this->suppliesRepository->get_count_all_dashboard($request);
        $request->status = SuppliesAsset::THIET_BI_DANG_SU_DUNG;
        $data['using'] = $this->suppliesRepository->get_count_all_dashboard($request);
        $request->status = SuppliesAsset::THIET_BI_LUU_KHO;
        $data['saving'] = $this->suppliesRepository->get_count_all_dashboard($request);
        $request->status = SuppliesAsset::THIET_BI_HONG;
        $data['fail'] = $this->suppliesRepository->get_count_all_dashboard($request);
        $request->status = SuppliesAsset::THIET_BI_MOI;
        $data['new'] = $this->suppliesRepository->get_count_all_dashboard($request);
        return $data;
    }

    public function validate_update_info_general($request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required",
        ], [
            "name.required" => "Tên thiết bị không được để trống!",
        ]);

        return $validate;
    }

    public function update_info_general($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $data = [
            SuppliesAsset::NAME => $request->name,
            SuppliesAsset::SLUG => slugify($request->name),
            SuppliesAsset::CODE => $request->code,
            SuppliesAsset::PRICE => (int)$request->price,
            SuppliesAsset::SUPPLIER => $request->supplier,
            SuppliesAsset::SLUG_SUPPLIER => slugify($request->supplier),
            SuppliesAsset::PURCHASE_DATE => strtotime($request->purchase_date),
            SuppliesAsset::DESCRIPTION => isset($request->description) ? $request->description : "",
            SuppliesAsset::WARRANTY_PERIOD => strtotime($request->warranty_period),
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
        ];
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, $data);
        $this->logSuppliesRepository->create(
            [
                LogSuppliesAsset::OLD => $supplies_old,
                LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
                LogSuppliesAsset::NEW => $supplies_new,
                LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
                LogSuppliesAsset::TYPE => LogSuppliesAsset::UPDATE,
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email,
                LogSuppliesAsset::SUPPLIES_ID => $supplies_new['_id'],
                LogSuppliesAsset::NOTE => $request->description
            ]
        );
    }

    public function clear_supplies($request)
    {
        $supplies = $this->suppliesRepository->find($request->id);
        $logs = $this->logSuppliesRepository->findMany([LogSuppliesAsset::SUPPLIES_ID => $request->id]);
        foreach ($logs as $log) {
            $this->logSuppliesRepository->delete($log['_id']);
        }
        $noti = $this->notificationRepository->findMany([NotificationAsset::SUPPLIES_ID => $request->id]);
        if (count($noti) > 0) {
            foreach ($noti as $value) {
                $this->notificationRepository->delete($value['_id']);
            }
        }
        $this->suppliesRepository->delete($request->id);
    }

    public function assign_many($request)
    {
        $supplies = $request->supplies;
        foreach ($supplies as $supply) {
            $supplies_old = $this->suppliesRepository->findAttributesToArray($supply);
            $supplies_new = $this->suppliesRepository->update($supply, [
                SuppliesAsset::DEPARTMENT_ID => $request->phong_ban,
                SuppliesAsset::USER_ID => $request->nhan_vien,
                SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
                SuppliesAsset::UPDATED_AT => time(),
                SuppliesAsset::UPDATED_BY => $request->user_info->email,
                SuppliesAsset::DATE_RECEIVE => strtotime($request->ngay_ban_giao),
                SuppliesAsset::DATE_STORAGE => '',
                SuppliesAsset::WAREHOUSE_ID => '',
                SuppliesAsset::STATUS_RECEIVE => false,
                SuppliesAsset::DATE_STATUS_RECEIVE => '',
            ]);

            $log = $this->logSuppliesRepository->create([
                LogSuppliesAsset::TYPE => LogSuppliesAsset::ASSIGN,
                LogSuppliesAsset::OLD => $supplies_old,
                LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
                LogSuppliesAsset::NEW => $supplies_new,
                LogSuppliesAsset::NEW_STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
                LogSuppliesAsset::SUPPLIES_ID => $supply,
                LogSuppliesAsset::NOTE => $request->ghi_chu,
                LogSuppliesAsset::USER_RECEIVE => $request->nhan_vien,
                LogSuppliesAsset::DELIVERY_DATE => strtotime($request->ngay_ban_giao),
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email
            ]);
            if (!empty($request->nhan_vien)) {
                $message = "Thiết bị " . $supplies_new['name'] . ' vừa được cập nhật cho bạn, vui lòng xác nhận khi nhận được thiết bị';
                $title = "Bàn giao thiết bị";
                $this->notificationService->push_notification($log, $request->nhan_vien, $message, $title, $request);
            }
            if (empty($supplies_new['code']) || $supplies_new['code'] == null) {
                $this->code($supplies_new);
            }
        }
    }

    public function validate_assign_many($request)
    {
        $validate = Validator::make($request->all(), [
            "phong_ban" => "required",
//            "nhan_vien" => "required",
            "ngay_ban_giao" => "required|before:tomorrow",
            'supplies' => 'required'
        ], [
            "phong_ban.required" => "Phòng ban không để trống",
//            "nhan_vien.required" => "Nhân viên không để trống",
            "ngay_ban_giao.required" => "Ngày ban giao không để trống",
            "ngay_ban_giao.before" => "Ngày ban giao không lớn hơn ngày hiện tại",
            "supplies.required" => "Thiết bị cần bàn giao không để trống",
        ]);

        return $validate;
    }

    public function office_confirm($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::STATUS_RECEIVE => true,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::DATE_STATUS_RECEIVE => time(),
        ]);
        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::OFFICE_CONFIRM,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::NOTE => !empty($request->note) ? $request->note : '',
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::DATE_STATUS_RECEIVE => time(),
            LogSuppliesAsset::USER_RECEIVE => !empty($supplies_new['user_id']) ? $supplies_new['user_id'] : '',
            LogSuppliesAsset::CREATED_BY => $request->user_info->email,
            LogSuppliesAsset::IMAGE_DESCRIPTION => isset($request->image_asset) ? $request->image_asset : '',
        ]);

        if (!empty($supplies_old['user_id'])) {
            $message = 'Hành chính nhân sự đã xác nhận bàn giao thiết bị ' . $supplies_new['name'];
            $title = "Xác nhận bàn giao";
            $this->notificationService->push_notification($log, $supplies_new['user_id'], $message, $title, $request);
        }
    }

    public function update_status_supplies($request)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($request->supplies_id);
        $supplies_new = $this->suppliesRepository->update($request->supplies_id, [
            SuppliesAsset::DEPARTMENT_ID => '',
            SuppliesAsset::USER_ID => '',
            SuppliesAsset::DATE_RECEIVE => '',
            SuppliesAsset::RECEPTION_STAFF => '',
            SuppliesAsset::STATUS_REQUEST => '',
            SuppliesAsset::STATUS => (int)$request->status,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::UPDATED_BY => $request->user_info->email,
            SuppliesAsset::DATE_STORAGE => time(),
            SuppliesAsset::DATE_STATUS_RECEIVE => '',
            SuppliesAsset::STATUS_RECEIVE => '',
        ]);
        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::SWITCH_STATUS,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
            LogSuppliesAsset::SUPPLIES_ID => $request->supplies_id,
            LogSuppliesAsset::DATE_STORAGE => time(),
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::CREATED_BY => $request->user_info->email
        ]);
    }

    public function report($request)
    {
        $data = $this->suppliesRepository->report($request);
        foreach ($data as $datum) {
            if (!empty($datum->warehouse_id)) {
                $datum->ware = $this->menuRepository->find($datum->warehouse_id);
            }
            if (!empty($datum->department_id)) {
                $datum->depart = $this->menuRepository->find($datum->department_id);
            }
            if (!empty($datum->user_id)) {
                $datum->user = $this->userRepository->find($datum->user_id);
            }
            if (!empty($datum->equipment_id)) {
                $datum->equip = $this->menuRepository->find($datum->equipment_id);
            }
            if (!empty($datum->equipment_child_id)) {
                $datum->equip_child = $this->menuRepository->find($datum->equipment_child_id);
            }
        }
        return $data;
    }

    public function validate_report($request)
    {
        $message = [];
        if (count($request->supplies) <= 0 || empty($request->supplies)) {
            $message[] = 'Không có thiết bị để in';
        }
        $data = $this->suppliesRepository->report($request);
        $data_user = [];
        foreach ($data as $datum) {
            if (!empty($datum->user_id)) {
                array_push($data_user, $datum->user_id);
            }
        }
        $data_user_new = array_unique($data_user);
        if (count($data_user_new) > 1) {
            $message[] = 'Danh sách in thiết bị đang có nhiều hơn 1 nhân sự';
        }
        return $message;
    }

    public function transfer_department($request)
    {
        $supplies = $this->suppliesRepository->findMany([SuppliesAsset::USER_ID => $request->user_id]);
        foreach ($supplies as $supply) {
            $this->suppliesRepository->update($supply['_id'], [SuppliesAsset::DEPARTMENT_ID => $request->depart_id]);
        }
    }

    public function get_warehouse_paginate($request)
    {
        $data_department = $this->roleService->get_department_manager_by_user_administrative($request);
        $request->data_department = $data_department;
        $data_warehouse = $this->roleService->get_warehouse_manager_by_user_administrative($request);
        $request->data_warehouse = $data_warehouse;
        $data_equipment = $this->roleService->get_equipment_manager_by_user_administrative($request);
        $request->data_equipment = $data_equipment;
        $data = $this->suppliesRepository->get_warehouse_paginate($request);
        foreach ($data as $datum) {
            if (isset($datum->warehouse_id)) {
                $datum->ware = $this->menuRepository->find($datum->warehouse_id);
            }
            if (isset($datum->department_id)) {
                $datum->depart = $this->menuRepository->find($datum->department_id);
            }
            if (isset($datum->user_id)) {
                $datum->user = $this->userRepository->find($datum->user_id);
            }
            if (isset($datum->equipment_id)) {
                $datum->equip = $this->menuRepository->find($datum->equipment_id);
            }
            if (isset($datum->equipment_child_id)) {
                $datum->equip_child = $this->menuRepository->find($datum->equipment_child_id);
            }
            if (!empty($datum->image_avatar_asset) && count($datum->image_avatar_asset) > 0) {
                foreach ($datum->image_avatar_asset as $item) {
                    $datum->avatar = $item['path'];
                }
            }
            if (!empty($datum->status_request)) {
                $datum->type_request = category_request($datum->status_request);
                $datum->color_type_request = color_category_request($datum->status_request);
            }
        }
        return $data;
    }

    public function get_count_warehouse($request)
    {
        $data = [];
        $data_department = $this->roleService->get_department_manager_by_user_administrative($request);
        $request->data_department = $data_department;
        $data_warehouse = $this->roleService->get_warehouse_manager_by_user_administrative($request);
        $request->data_warehouse = $data_warehouse;
        $data_equipment = $this->roleService->get_equipment_manager_by_user_administrative($request);
        $request->data_equipment = $data_equipment;
        $data['total'] = $this->suppliesRepository->get_count_warehouse($request);
        return $data;
    }

    public function general_code()
    {
        $supplies = $this->suppliesRepository->find_supplies_assgin_code();
        foreach ($supplies as $supply) {
            if (empty($supply['code']) || $supply['code'] == null) {
                $this->code($supply);
            }
        }
    }

    public function code($supply)
    {
        $a = 'TB';
        $count = 1;
        $equip = $this->menuRepository->find($supply['equipment_child_id']);
        if (!empty($equip['sign'])) {
            $a = $equip['sign'];
            $count_code = $this->codeRepository->findOne([
                CodeAsset::DEPARTMENT_ID => $supply['department_id'],
                CodeAsset::EQUIPMENT_CHILD_ID => $supply['equipment_child_id']
            ]);
            if (empty($count_code)) {
                $b = '001';
                $this->codeRepository->create([
                    CodeAsset::DEPARTMENT_ID => $supply['department_id'],
                    CodeAsset::EQUIPMENT_CHILD_ID => $supply['equipment_child_id'],
                    CodeAsset::COUNT => $b
                ]);
            } else {
                $max = $count_code['count'] + 1;
                $b = gen_code($max);
                $this->codeRepository->update($count_code['_id'], [CodeAsset::COUNT => $max]);
            }
            $c = 'VFC';
            $d = 'BP';
            $department = $this->menuRepository->find($supply['department_id']);
            if (!empty($department['sign'])) {
                $d = $department['sign'];
            }

            $e = '';
            if (!empty($supply['purchase_date'])) {
                $e = '-' . date('y', $supply['purchase_date']);
            }
            $code = $a . '-' . $b . '-' . $c . '-' . $d . $e;
            $this->suppliesRepository->update($supply['_id'], [SuppliesAsset::CODE => $code]);
        }
    }

    public function get_all_data($request)
    {
        $data = $this->suppliesRepository->get_all_data($request);
        foreach ($data as $datum) {
            if (isset($datum->warehouse_id)) {
                $datum->ware = $this->menuRepository->find($datum->warehouse_id);
            }
            if (isset($datum->department_id)) {
                $datum->depart = $this->menuRepository->find($datum->department_id);
            }
            if (isset($datum->user_id)) {
                $datum->user = $this->userRepository->find($datum->user_id);
            }
            if (isset($datum->equipment_id)) {
                $datum->equip = $this->menuRepository->find($datum->equipment_id);
            }
            if (isset($datum->equipment_child_id)) {
                $datum->equip_child = $this->menuRepository->find($datum->equipment_child_id);
            }
            if (!empty($datum->image_avatar_asset) && count($datum->image_avatar_asset) > 0) {
                foreach ($datum->image_avatar_asset as $item) {
                    $datum->avatar = $item['path'];
                }
            }
            if (!empty($datum->status_request)) {
                $datum->type_request = category_request($datum->status_request);
                $datum->color_type_request = color_category_request($datum->status_request);
            }
        }
        return $data;
    }

    public function validate_recall_many($request)
    {
        $validate = Validator::make($request->all(), [
            "kho_luu_tru" => "required",
            "ngay_luu_kho" => "required|before:tomorrow",
            'supplies' => 'required'
        ], [
            "kho_luu_tru.required" => "Kho lưu trữ không để trống",
            "ngay_luu_kho.required" => "Ngày lưu kho không để trống",
            "ngay_luu_kho.before" => "Ngày lưu kho không lớn hơn ngày hiện tại",
            "supplies.required" => "Thiết bị lưu kho không để trống",
        ]);

        return $validate;
    }

    public function recall_many($request)
    {
        $supplies = $request->supplies;
        foreach ($supplies as $supply) {
            $supplies_old = $this->suppliesRepository->findAttributesToArray($supply);
            $supplies_new = $this->suppliesRepository->update($supply, [
                SuppliesAsset::DEPARTMENT_ID => '',
                SuppliesAsset::USER_ID => '',
                SuppliesAsset::DATE_RECEIVE => '',
                SuppliesAsset::RECEPTION_STAFF => '',
                SuppliesAsset::STATUS_REQUEST => '',
                SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_LUU_KHO,
                SuppliesAsset::UPDATED_AT => time(),
                SuppliesAsset::UPDATED_BY => $request->user_info->email,
                SuppliesAsset::DATE_STORAGE => strtotime($request->ngay_luu_kho),
                SuppliesAsset::WAREHOUSE_ID => $request->kho_luu_tru,
                SuppliesAsset::DATE_STATUS_RECEIVE => '',
                SuppliesAsset::STATUS_RECEIVE => '',
            ]);

            $log = $this->logSuppliesRepository->create([
                LogSuppliesAsset::TYPE => LogSuppliesAsset::STORAGE,
                LogSuppliesAsset::OLD => $supplies_old,
                LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
                LogSuppliesAsset::NEW => $supplies_new,
                LogSuppliesAsset::NEW_STATUS => SuppliesAsset::THIET_BI_LUU_KHO,
                LogSuppliesAsset::SUPPLIES_ID => $supply,
                LogSuppliesAsset::NOTE => $request->ghi_chu_luu_kho,
                LogSuppliesAsset::DATE_STORAGE => strtotime($request->ngay_luu_kho),
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email
            ]);
            if (!empty($supplies_old['user_id'])) {
                $message = "P.HCNS đã xác nhận lưu kho thiết bị " . $supplies_old['name'];
                $title = "Xác nhận lưu kho";
                $this->notificationService->push_notification($log, $supplies_old['user_id'], $message, $title, $request);
            }
        }
    }

    public function cron_office_confirm($id)
    {
        $supplies_old = $this->suppliesRepository->findAttributesToArray($id);
        $supplies_new = $this->suppliesRepository->update($id, [
            SuppliesAsset::STATUS_RECEIVE => true,
            SuppliesAsset::UPDATED_AT => time(),
            SuppliesAsset::DATE_STATUS_RECEIVE => time(),
        ]);
        $log = $this->logSuppliesRepository->create([
            LogSuppliesAsset::TYPE => LogSuppliesAsset::OFFICE_CONFIRM,
            LogSuppliesAsset::OLD => $supplies_old,
            LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
            LogSuppliesAsset::NEW => $supplies_new,
            LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
            LogSuppliesAsset::SUPPLIES_ID => $id,
            LogSuppliesAsset::NOTE => '',
            LogSuppliesAsset::CREATED_AT => time(),
            LogSuppliesAsset::DATE_STATUS_RECEIVE => time(),
            LogSuppliesAsset::USER_RECEIVE => !empty($supplies_new['user_id']) ? $supplies_new['user_id'] : '',
            LogSuppliesAsset::CREATED_BY => 'system',
        ]);
        return $log;
    }

    public function validate_verify_many($request)
    {
        $validate = Validator::make($request->all(), [
            'supplies' => 'required'
        ], [
            "supplies.required" => "Thiết bị lưu kho không để trống",
        ]);

        return $validate;
    }

    public function verify_many($request)
    {
        $supplies = $request->supplies;
        foreach ($supplies as $supply) {
            $supplies_old = $this->suppliesRepository->findAttributesToArray($supply);
            $supplies_new = $this->suppliesRepository->update($supply, [
                SuppliesAsset::INVENTORY_DATE => Carbon::now()->unix(),
                SuppliesAsset::STATUS => SuppliesAsset::THIET_BI_DANG_SU_DUNG,
                SuppliesAsset::UPDATED_AT => time(),
                SuppliesAsset::UPDATED_BY => $request->user_info->email,
            ]);

            $log = $this->logSuppliesRepository->create([
                LogSuppliesAsset::TYPE => LogSuppliesAsset::VERIFIED,
                LogSuppliesAsset::OLD => $supplies_old,
                LogSuppliesAsset::OLD_STATUS => $supplies_old['status'],
                LogSuppliesAsset::NEW => $supplies_new,
                LogSuppliesAsset::NEW_STATUS => $supplies_new['status'],
                LogSuppliesAsset::SUPPLIES_ID => $supply,
                LogSuppliesAsset::NOTE => $request->note,
                LogSuppliesAsset::INVENTORY_DATE => Carbon::now()->unix(),
                LogSuppliesAsset::CREATED_AT => time(),
                LogSuppliesAsset::CREATED_BY => $request->user_info->email
            ]);
        }
        return;
    }
}
