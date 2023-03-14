<?php


namespace Modules\AssetLocation\Http\Service;


use Modules\AssetLocation\Http\Repository\WardRepository;

class WardService extends BaseService
{
    protected $wardRepository;

    public function __construct(WardRepository $wardRepository)
    {
        $this->wardRepository = $wardRepository;
    }

    public function ward($request)
    {
        return $this->wardRepository->findMany(['parent_code' => $request->ward]);
    }
}
