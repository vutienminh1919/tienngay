<?php


namespace Modules\AssetLocation\Http\Repository;


use Modules\AssetLocation\Model\LogNote;

class LogNoteRepository extends BaseRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return LogNote::class;
    }
}
