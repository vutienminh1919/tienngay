<?php


namespace App\Http\Controllers;


use App\Repository\UserRepository;
use App\Service\CommissionService;
use App\Service\EventService;
use App\Service\UserService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function create(Request $request)
    {
        $validate = $this->eventService->validate_create($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }
        $check = $this->eventService->check_create($request);
        if(count($check) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $check[0]
            ]);
        }
        $this->eventService->create($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS
        ]);
    }

    public function list(Request $request)
    {
        $data = $this->eventService->list($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $data
        ]);
    }

    public function update_status(Request $request)
    {
        $this->eventService->update_status($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
        ]);
    }

    public function show(Request $request)
    {
        $data = $this->eventService->show($request->id);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS,
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $validate = $this->eventService->validate_create($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }
        $check = $this->eventService->check_create($request);
        if(count($check) > 0) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $check[0]
            ]);
        }
        $this->eventService->update($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => Controller::SUCCESS
        ]);
    }
}
