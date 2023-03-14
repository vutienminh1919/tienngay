<?php


namespace App\Http\Controllers;


use App\Service\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function create(Request $request)
    {
        $this->feedbackService->create($request);
        return Controller::send_response(Controller::HTTP_OK, Controller::SUCCESS);
    }
}
