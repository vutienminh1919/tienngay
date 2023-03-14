<?php


namespace Modules\AssetLocation\Http\Service;

use Carbon\Carbon;
use Modules\AssetLocation\Http\Repository\PartnerRepository;
use Modules\AssetLocation\Model\Partner;

class PartnerService extends BaseService
{
    protected $partnerRepository;

    public function __construct(PartnerRepository $partnerRepository)
    {
        $this->partnerRepository = $partnerRepository;
    }

    public function create($request)
    {
        $data = [
            Partner::NAME => $request->name,
            Partner::STATUS => Partner::STATUS_ACTIVE,
            Partner::SLUG => slugify($request->name),
            Partner::CREATED_AT => Carbon::now()->unix(),
            Partner::CREATED_BY => $request->user->email ?? ""
        ];
        return $this->partnerRepository->create($data);
    }

    public function list()
    {
        return $this->partnerRepository->getAll();
    }

}
