<?php


namespace App\Service;


use App\Models\DraftNl;
use App\Repository\DraftNlRepository;
use App\Repository\DraftNlRepositoryInterface;

class DraftNlService extends BaseService
{
    protected $draftRepository;
    protected $nlPayIn;

    public function __construct(DraftNlRepository $draftNlRepository,
                                NganLuongPayIn $nlPayIn)
    {
        $this->draftRepository = $draftNlRepository;
        $this->nlPayIn = $nlPayIn;
    }

    public function create_bill($request)
    {
        $code = 'TN_' . date("Ymd") . '_' . uniqid();
        $bill_new = $this->draftRepository->create([
            DraftNl::COLUMN_INVESTOR_ID => $request->id,
            DraftNl::COLUMN_INVESTMENT_ID => $request->contract_id,
            DraftNl::COLUMN_STATUS => DraftNl::NEW,
            DraftNl::COLUMN_ORDER_CODE => $code,
            DraftNl::COLUMN_CLIENT_CODE => $request->client_code
        ]);
        return $bill_new;
    }

    public function cancel($request)
    {
        $bill = $this->draftRepository->find($request->id);
        if ($bill) {
            if ($bill['status'] != DraftNl::SUCCESS) {
                $this->draftRepository->update($request->id, [DraftNl::COLUMN_STATUS => DraftNl::NEW]);
            }
        }
    }

    public function check_bill($request)
    {
        if (empty($request->id)) {
            return false;
        } else {
            $bill = $this->draftRepository->find($request->id);
            if (!$bill) {
                return false;
            } else {
                if ($bill['status'] != DraftNl::SUCCESS) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
}
