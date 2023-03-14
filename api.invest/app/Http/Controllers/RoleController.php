<?php

namespace App\Http\Controllers;

use App\Models\ConfigCall;
use App\Repository\ConfigCallRepository;
use App\Repository\ConfigCallRepositoryInterface;
use App\Service\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\MenuRepositoryInterface;

class RoleController extends Controller
{

    public function __construct(
        RoleRepositoryInterface $role,
        UserRepositoryInterface $user,
        MenuRepositoryInterface $menu,
        ConfigCallRepositoryInterface $configCall,
        RoleService $roleService
    )
    {
        $this->role_model = $role;
        $this->user_model = $user;
        $this->menu_model = $menu;
        $this->config_call = $configCall;
        $this->roleService = $roleService;
    }

    public function createRole(Request $request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($request->get('name'), '-');
        $validate = Validator::make($input, [
            'name' => 'required',
            'slug' => 'unique:role,slug'
        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'slug.unique' => 'Tên nhóm đã tồn tại'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Save
        $data = $this->role_model->create([
            'name' => $request->get('name'),
            'status' => 'active',
            'slug' => Str::slug($request->get('name'), '-'),
            'created_by' => current_user()->email
        ]);
        // res
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data
        ]);
    }

    public function addUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_list' => 'required',
        ], [
            'user_list.required' => 'User không để trống',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }
        // Add
        $role = $this->role_model->find($request->id);
        if ($role) {
            $arr_attach = [];
            $arr_user = explode(',', $request->get('user_list'));
            $data_insert = [];
            foreach ($arr_user as $user) {
                $user_position = explode(':', $user);
                $data_insert[$user_position[0]] = [
                    'position' => $user_position[1],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            $attach = $role->user()->sync($data_insert);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công'
            ]);
        }
        // Not find
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    public function addMenu(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'menu_list' => 'required',
        ], [
            'menu_list.required' => 'Bạn chưa nhập danh sách menu',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Add
        $role = $this->role_model->find($request->id);
        if ($role) {
            $arr_attach = [];
            $arr_menu = explode(',', $request->get('menu_list'));
            foreach ($arr_menu as $menu_id) {
                $menu_data = $this->menu_model->find($menu_id);
                if ($menu_data) {
                    array_push($arr_attach, $menu_data->id);
                }
            }
            $attach = $role->menu()->sync($arr_attach);
            if ($attach) {
                return response()->json([
                    'status' => Controller::HTTP_OK,
                    'message' => 'Thành công'
                ]);
            }
        }
        // Not find
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    public function allRole()
    {
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $this->role_model->getAllWithStatusActive()
        ]);
    }

    public function roleList(Request $request)
    {
        $filter = $request->only('name');
        $role_list = $this->role_model->getListPaginate($filter);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $role_list
        ]);
    }

    public function toggleActive(Request $request)
    {
        $data = $this->role_model->toggleActive($request->get('id'));
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    /**
     * @OA\Post(path="/role/detail/{id}",
     *   tags={"role"},
     *   summary="Chi tiết role",
     *   @OA\Parameter(in="path", name="id"),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function roleDetail(Request $request)
    {
        $role = $this->role_model->find($request->id);
        $role['user'] = $role->user()->get();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $role
        ]);
    }

    public function updateRole(Request $request)
    {
        $id = $request->id;
        $input = $request->all();
        $input['slug'] = Str::slug($request->get('name'), '-');
        $validate = Validator::make($input, [
            'name' => 'required',
            'slug' => 'unique:role,slug,' . $id
        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'slug.unique' => 'Tên nhóm đã tồn tại'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Update
        $role = $this->role_model->find($id);
        if ($role) {
            $data = $this->role_model->update($id, [
                'name' => $request->get('name'),
                'status' => ($request->get('status') == 'active') ? 'active' : 'deactive',
                'slug' => Str::slug($request->get('name'), '-'),
            ]);
            return response()->json([
                'status' => Controller::HTTP_OK,
                'data' => $data
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'data' => 'Dữ liệu không tồn tại'
        ]);
    }

    public function getRoleUser(Request $request)
    {
        $user = $this->user_model->find($request->id);
        $user->role = $user->role;
        $roles = [];
        foreach ($user->role as $role) {
            array_push($roles, $role->slug);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'roles' => $roles
        ]);
    }

    public function get_user_role_telesales(Request $request)
    {
        $role = $this->role_model->findOne(['slug' => $request->slug]);
        $role->user = $role->user;
        $config = $this->config_call->findOne([ConfigCall::COLUMN_DATE => date('Y-m-d')]);
        if ($config) {
            $cskh = explode(',', $config->telesales);
        } else {
            $cskh = [];
        }
        $data = [];
        foreach ($role->user as $item) {
            if (in_array($item->id, $cskh)) {
                $item->checked = true;
            } else {
                $item->checked = false;
            }
            if ($item->pivot->position != 3) {
                array_push($data, $item);
            }
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data
        ]);
    }

    public function get_role_user()
    {
        $data = [];
        $roles = $this->roleService->get_user_role();
        foreach ($roles as $role) {
            array_push($data, $role->slug);
        }
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }
}
