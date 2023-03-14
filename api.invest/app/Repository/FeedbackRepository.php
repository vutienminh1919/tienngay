<?php


namespace App\Repository;


use App\Models\Feedback;

class FeedbackRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Feedback::class;
    }
}
