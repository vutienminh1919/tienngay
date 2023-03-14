<?php


namespace App\Http\Controllers;

use App\Service\LeadBackLogService;

class LeadBackLogController extends Controller
{
    public function __construct(LeadBackLogService $leadBackLogService)
    {
        $this->leadBackLogService = $leadBackLogService;
    }

    public function leadBackLogDaily()
    {
        $this->leadBackLogService->saveLeadBackLogDaily();
    }
}
