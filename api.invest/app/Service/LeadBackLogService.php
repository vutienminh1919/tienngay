<?php


namespace App\Service;


use App\Models\Investor;
use App\Repository\InvestorRepositoryInterface;
use App\Repository\LeadBackLogRepositoryInterface;

class LeadBackLogService extends BaseService
{
    protected $investorRepository;
    protected $roleService;
    protected $leadBackLogRepository;

    public function __construct(InvestorRepositoryInterface $investorRepository,
                                LeadBackLogRepositoryInterface $leadBackLogRepository,
                                RoleService $roleService
    )
    {
        $this->investorRepository = $investorRepository;
        $this->leadBackLogRepository = $leadBackLogRepository;
        $this->roleService = $roleService;
    }

    public function saveLeadBackLogDaily()
    {
        $time_start_date = date('Y-m-d') . ' 00:00:00';
        $time_end_date = date('Y-m-d') . ' 23:59:59';
        $current_date = date('d');
        $current_day = date('Y-m-d');
        $tls_id = [];
        $user_tls = $this->roleService->get_user_by_role('telesales');
        foreach ($user_tls as $tl) {
            array_push($tls_id, $tl['id']);
        }
//        $tls_id = $this->investorRepository->getIdTelesales();
        $data_tls_daily = array();
        if (!empty($tls_id)) {
            for ($i = 0; $i < count($tls_id); $i++) {
                $email_telesales = $this->investorRepository->getEmailTelesales($tls_id[$i]);
                $total_lead_backlog = $this->investorRepository->getLeadBackLogToSave($time_end_date, $tls_id[$i]);
                $data_tls_daily[$i]['id_tls'] = $tls_id[$i];
                $data_tls_daily[$i]['email_tls'] = $email_telesales;
                $data_tls_daily[$i]['total_lead_backlog'] = $total_lead_backlog;
            }
        }
        if (!empty($data_tls_daily)) {
            foreach ($data_tls_daily as $key => $tls) {
                $data_insert = [
                    'id_tls' => $tls['id_tls'],
                    'email' => $tls['email_tls'],
                    'total_lead_backlog' => $tls['total_lead_backlog'],
                    'start_date' => $time_start_date,
                    'end_date' => $time_end_date,
                    'date' => $current_date,
                    'created_by' => "app_vfc@tienngay.vn"
                ];
                $this->leadBackLogRepository->create($data_insert);
            }
        }
    }
}
