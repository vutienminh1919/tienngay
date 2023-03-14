<?php


namespace Modules\AssetLocation\Http\Service;


use Modules\AssetLocation\Http\Repository\BaseRepository;

class BaseService
{
    const DESC = 'DESC';
    const ASC = 'ASC';
    protected $baseRepository;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }
}
