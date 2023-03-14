<?php

namespace App\Http\Controllers;

use App\Repository\ActionRepositoryInterface;
use App\Repository\MenuRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActionController extends Controller
{

    public function __construct(
        MenuRepositoryInterface $menu,
        ActionRepositoryInterface $action
    ) {
        $this->menu_model = $menu;
        $this->action_model = $action;
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'name' => 'required',
        ], [
            'name.required' => 'Bạn chưa nhập tên'
        ]);
        if ( $validate->fails() ) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Save
        $data = $this->action_model->create([
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'menu_id' => $request->get('menu_id'),
            'status' => 'active',
            'created_by' => current_user()->email
        ]);
        // res
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'name' => 'required',
        ], [
            'name.required' => 'Bạn chưa nhập tên'
        ]);
        if ( $validate->fails() ) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()
            ]);
        }
        // Save
        $data = $this->action_model->update($request->id, [
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'menu_id' => $request->get('menu_id'),
            'status' => 'active',
            'created_by' => current_user()->email
        ]);
        // res
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data
        ]);
    }

    public function detail(Request $request)
    {
        $data = $this->action_model->find($request->id);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    public function allAction()
    {
        $data = $this->action_model->getAll();
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

}
