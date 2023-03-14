<?php


namespace App\Service;


use App\Models\Call;
use App\Models\LogCall;
use App\Repository\CallRepositoryInterface;
use App\Repository\LogCallRepositoryInterface;

class LogCallService extends BaseService
{
    protected $logCallRepository;
    protected $callRepository;

    public function __construct(LogCallRepositoryInterface $logCallRepository,
                                CallRepositoryInterface $callRepository)
    {
        $this->logCallRepository = $logCallRepository;
        $this->callRepository = $callRepository;
    }


    public function add_log_call($request)
    {
        $call = $this->callRepository->findOne([Call::COLUMN_INVESTOR_ID => $request->id]);
        if (!$call) {
            $call_new = $this->callRepository->create([
                Call::COLUMN_INVESTOR_ID => $request->id,
                Call::COLUMN_STATUS => $request->status,
                Call::COLUMN_NOTE => $request->note,
                Call::COLUMN_CALL_NOTE => $request->call_note,
                Call::COLUMN_CREATED_BY => current_user()->email,
            ]);
            $this->logCallRepository->create([
                LogCall::COLUMN_CALL_ID => $call_new->id,
                LogCall::COLUMN_NEW => json_encode($call_new),
                LogCall::COLUMN_CREATED_BY => current_user()->email,
            ]);
        } else {
            $this->callRepository->update($call->id, [
                Call::COLUMN_STATUS => $request->status,
                Call::COLUMN_NOTE => $request->note,
                Call::COLUMN_CALL_NOTE => $request->call_note,
                Call::COLUMN_UPDATED_BY => current_user()->email,
            ]);
            $this->logCallRepository->create([
                LogCall::COLUMN_CALL_ID => $call->id,
                LogCall::COLUMN_OLD => json_encode($call),
                LogCall::COLUMN_NEW => json_encode(['status' => $request->status, 'note' => $request->note, 'call_note' => $request->call_note]),
                LogCall::COLUMN_CREATED_BY => current_user()->email,
            ]);
        }
    }

    public function add_log_call_lead($request)
    {
        $call = $this->callRepository->findOne([Call::COLUMN_LEAD_INVESTOR_ID => $request->id]);
        if (!$call) {
            $call_new = $this->callRepository->create([
                Call::COLUMN_LEAD_INVESTOR_ID => $request->id,
                Call::COLUMN_STATUS => $request->status,
                Call::COLUMN_NOTE => $request->note,
                Call::COLUMN_CALL_NOTE => $request->call_note,
                Call::COLUMN_CREATED_BY => current_user()->email,
            ]);
            $this->logCallRepository->create([
                LogCall::COLUMN_CALL_ID => $call_new->id,
                LogCall::COLUMN_NEW => json_encode($call_new),
                LogCall::COLUMN_CREATED_BY => current_user()->email,
            ]);
        } else {
            $this->callRepository->update($call->id, [
                Call::COLUMN_STATUS => $request->status,
                Call::COLUMN_NOTE => $request->note,
                Call::COLUMN_CALL_NOTE => $request->call_note,
                Call::COLUMN_UPDATED_BY => current_user()->email,
            ]);
            $this->logCallRepository->create([
                LogCall::COLUMN_CALL_ID => $call->id,
                LogCall::COLUMN_OLD => json_encode($call),
                LogCall::COLUMN_NEW => json_encode(['status' => $request->status, 'note' => $request->note, 'call_note' => $request->call_note]),
                LogCall::COLUMN_CREATED_BY => current_user()->email,
            ]);
        }
    }
}
