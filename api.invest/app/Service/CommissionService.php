<?php


namespace App\Service;


use App\Models\Commission;
use App\Repository\CommissionRepository;
use App\Repository\CommissionRepositoryInterface;

class CommissionService extends BaseService
{
    protected $commissionRepository;

    public function __construct(CommissionRepositoryInterface $commissionRepository)
    {
        $this->commissionRepository = $commissionRepository;
    }

    public function create($request)
    {
        $this->commissionRepository->create([
            Commission::NAME => $request->name,
            Commission::SLUG => slugify($request->name),
            Commission::MIN => $request->min,
            Commission::MAX => $request->max,
            Commission::COMMISSION => $request->commission,
            Commission::STATUS => Commission::ACTIVE,
            Commission::COLUMN_CREATED_BY=> current_user()->email
        ]);
    }
}
