<?php


namespace App\Service;


use App\Models\Feedback;
use App\Repository\FeedbackRepository;

class FeedbackService extends BaseService
{
    protected $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function create($request)
    {
        $data = [
            Feedback::NAME => $request->name ?? null,
            Feedback::EMAIL => $request->email ?? null,
            Feedback::PHONE => $request->phone ?? null,
            Feedback::DESCRIPTION => $request->description ?? null,
            Feedback::STATUS => Feedback::NOT_ANSWER
        ];
        return $this->feedbackRepository->create($data);
    }
}
