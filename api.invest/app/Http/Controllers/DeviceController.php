<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Repository\DeviceRepositoryInterface;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct(
        UserRepositoryInterface $user,
        InvestorRepositoryInterface $investor,
        RoleRepositoryInterface $role,
        DeviceRepositoryInterface $device
    )
    {
        $this->user_model = $user;
        $this->investor_model = $investor;
        $this->role_model = $role;
        $this->device_model = $device;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_device(Request $request)
    {
        $device = $this->device_model->findOne([Device::COLUMN_USER_ID => $request->user_id, Device::COLUMN_PLATFORM => $request->platform]);
        if ($device) {
            $this->device_model->update($device['id'], [
                Device::COLUMN_DEVICE_TOKEN => $request->device,
            ]);
        } else {
            $this->device_model->create([
                Device::COLUMN_DEVICE_TOKEN => $request->device,
                Device::COLUMN_USER_ID => $request->user_id,
                Device::COLUMN_PLATFORM => $request->platform
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công'
        ]);
    }

    public function update_device(Request $request)
    {
        $this->device_model->update($request->id, [Device::COLUMN_DEVICE_TOKEN => $request->device]);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công'
        ]);
    }

    public function get_device_user(Request $request)
    {
        $user = $this->device_model->find_foreignKey($request->id, 'user', 'user_id');
        if (count($user) > 0) {
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => Controller::HTTP_UNAUTHORIZED,
                'message' => 'Thành công',
            ]);
        }
    }

    public function delete_device(Request $request)
    {
        $this->device_model->delete_field(Device::COLUMN_DEVICE_TOKEN, $request->device_token);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }

    public function collect_device(Request $request)
    {
        $device = $this->device_model->findOne([
            Device::COLUMN_DEVICE_TOKEN => $request->device,
            Device::COLUMN_PLATFORM => $request->platform
        ]);
        if (!$device) {
            $this->device_model->create([
                Device::COLUMN_DEVICE_TOKEN => $request->device,
                Device::COLUMN_PLATFORM => $request->platform
            ]);
        }
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }
}
