<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\Api;

class EventController extends Controller
{
    public function list()
    {
        // List
        $response = Api::post('event/list');

        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = $response['data'] ?? [];
        }

        return view('event.list', compact('data'));
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $data = [
            'event' => $request->event,
            'title' => $request->title,
            'month' => $request->month,
            'day' => $request->day,
            'hour' => $request->hour,
            'object' => $request->object,
            'repeat' => $request->repeat,
            'date' => $request->date,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'image' => $request->image,
        ];
        $response = Api::post('event/create', $data);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thêm mới thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Thêm mới không thành công'
            ]);
        }
    }

    public function update_status(Request $request)
    {
        $data = [
            'id' => $request->id,
        ];
        $response = Api::post('event/update_status', $data);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Cập nhật thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Cập nhật không thành công'
            ]);
        }
    }

    public function show($id)
    {
        $data = [];
        $response = Api::post('event/show', ['id' => $id]);
        if (isset($response['status']) && $response['status'] == 200) {
            $data = $response['data'] ?? [];
        }
        return view('event.update', compact('data'));
    }

    public function update(Request $request)
    {
        $data = [
            'event' => $request->event,
            'title' => $request->title,
            'month' => $request->month,
            'day' => $request->day,
            'hour' => $request->hour,
            'object' => $request->object,
            'repeat' => $request->repeat,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'id' => $request->id,
            'date' => $request->date,
            'image' => $request->image,
        ];
        $response = Api::post('event/update', $data);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Cập nhật thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Cập nhật không thành công'
            ]);
        }
    }
}
