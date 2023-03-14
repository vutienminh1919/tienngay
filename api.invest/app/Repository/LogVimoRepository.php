<?php


namespace App\Repository;


use App\Models\LogVimo;

class LogVimoRepository extends BaseRepository implements LogVimoRepositoryInterface
{
    public function getModel()
    {
        return LogVimo::class;
    }

    public function getLogVimo($request)
    {
        return $this->model
            ->limit($request->limit)
            ->offset($request->offset)
            ->orderBy(LogVimo::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }
}
