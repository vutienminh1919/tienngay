<?php


namespace Modules\AssetTienNgay\Http\Service;

use Modules\AssetTienNgay\Http\Repository\BaseRepository;

abstract class BaseService
{
    const DESC = 'DESC';
    const ASC = 'ASC';
    protected $baseRepository;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }
}
