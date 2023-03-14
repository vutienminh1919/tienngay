<?php


namespace App\Repository;


use App\Models\Event;

class EventRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Event::class;
    }

    public function list($request)
    {
        $model = $this->model;
        return $model
            ->orderBy(Event::STATUS, self::ASC)
            ->orderBy(Event::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }
}
