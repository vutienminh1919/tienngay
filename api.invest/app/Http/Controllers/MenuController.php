<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Repository\MenuRepositoryInterface;
use App\Repository\RoleRepositoryInterface;

class MenuController extends Controller
{

    public function __construct(
        MenuRepositoryInterface $menu,
        RoleRepositoryInterface $role
    )
    {
        $this->menu_model = $menu;
        $this->role_model = $role;
    }

    public function createMenu(Request $request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($request->get('name'), '-');
        $validate = Validator::make($input, [
            'name' => 'required',
            'slug' => 'unique:menu,slug'
        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'slug.unique' => 'Tên menu đã tồn tại'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Save
        $data = $this->menu_model->create([
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'parent' => $request->get('parent'),
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

    public function menuList(Request $request)
    {
        $filter = $request->only('name');
        $menu_list = $this->menu_model->getListPaginate($filter);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $menu_list
        ]);
    }

    public function addRole(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'role_list' => 'required',
        ], [
            'role_list.required' => 'Bạn chưa nhập role',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Add
        $menu = $this->menu_model->find($request->id);
        if ($menu) {
            $arr_attach = [];
            $arr_role = explode(',', $request->get('role_list'));
            foreach ($arr_role as $role_id) {
                $role_data = $this->role_model->find($role_id);
                if ($role_data) {
                    array_push($arr_attach, $role_data->id);
                }
            }
            $attach = $menu->role()->sync($arr_attach);
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

    public function allParent()
    {
        $menu = $this->menu_model->getAllParent();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $menu
        ]);
    }

    public function toggleActive(Request $request)
    {
        $data = $this->menu_model->toggleActive($request->get('id'));
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    /**
     * @OA\Post(path="/menu/detail/{id}",
     *   tags={"menu"},
     *   summary="Chi tiết menu",
     *   @OA\Parameter(in="path", name="id"),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function detailMenu(Request $request)
    {
        $data = $this->menu_model->find($request->id);
        if ($data) {
            $data['role'] = $data->role()->get();
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công',
                'data' => $data
            ]);
        }
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Error'
        ]);
    }

    /**
     * @OA\Post(path="/menu/update/{id}",
     *   tags={"menu"},
     *   summary="Cập nhật menu",
     *   @OA\Parameter(in="path", name="id"),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(property="name",type="string"),
     *          @OA\Property(property="url",type="string"),
     *          @OA\Property(property="parent",type="string"),
     *        )
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function updateMenu(Request $request)
    {
        $id = $request->id;
        // Validate
        $input = $request->all();
        $input['slug'] = Str::slug($request->get('name'), '-');
        $validate = Validator::make($input, [
            'name' => 'required',
            'slug' => 'unique:menu,slug,' . $id
        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'slug.unique' => 'Tên menu đã tồn tại'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Update
        $menu = $this->menu_model->find($id);
        if ($menu) {
            $data = $this->menu_model->update($id, [
                'name' => $request->get('name'),
                'url' => $request->get('url'),
                'parent' => $request->get('parent'),
                'status' => 'active',
                'slug' => Str::slug($request->get('name'), '-'),
                'created_by' => current_user()->email
            ]);
        }
        // res
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data
        ]);
    }

    /**
     * @OA\Post(path="/menu/sidebar",
     *   tags={"menu"},
     *   summary="Sidebar menu",
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function sidebarMenu()
    {
        $user = current_user();
        if ($user) {
            $data = $user->menu()->get();
            $data = $data->unique('id');
            return response()->json([
                'status' => Controller::HTTP_OK,
                'message' => 'Thành công',
                'data' => $data
            ]);
        }
        // Not find
        return response()->json([
            'status' => Controller::HTTP_BAD_REQUEST,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    /**
     * @OA\Post(path="/menu/all",
     *   tags={"menu"},
     *   summary="All menu",
     *   @OA\Response(response=200, description="successful operation"),
     *   security={{"api_key": {}}}
     * )
     */
    public function allMenu()
    {
        $data = $this->menu_model->getAll();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

}
