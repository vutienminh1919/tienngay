<?php


namespace App\Service;


use App\Models\Rate;
use App\Repository\RateInterfaceRepository;

class RateService extends BaseService
{
    protected $rateRepository;

    public function __construct(RateInterfaceRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function create($request)
    {
        $this->rateRepository->create([
            Rate::POINT => $request->point,
            Rate::NOTE => $request->note,
            Rate::USER_ID => $request->id,
        ]);
    }

    public function rate_user($user_id)
    {
        $rate = $this->rateRepository->findOneDesc([Rate::USER_ID => $user_id]);
        return $rate;
    }


}
