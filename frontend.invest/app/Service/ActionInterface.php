<?php


namespace App\Service;


interface ActionInterface
{
    const XEM_THANH_TOAN = 'pay/detail_paypal';
    const THANH_TOAN_NDT = 'pay/paypal_investor';
    const CHI_TIET_HOP_DONG = 'contract/detail';
    const EXCEL_HOP_DONG = 'contract/excel';
    const CAP_NHAT_THANH_TOAN = 'pay/update_pay_uq';
    const EXCEL_HOP_DONG_UQ = 'contract/excel_uq';
    const CAP_NHAT_THANH_TOAN_NHIEU_HOP_DONG_UQ = 'contract/pay_many_uq';

    const EXCEL_GIAO_DICH_DAU_TU = 'transaction/excelTransactionInvest';
    const EXCEL_GIAO_DICH_TIEN_TRA = 'transaction/excelTransactionPayment';

    const THEM_LAI_SUAT_CHUNG = 'interest/create_general';

    const THEM_MOI_USER = 'user/create';
    const CAP_NHAT_USER = 'user/update';

    const THEM_MOI_ACTION = 'action/create';
    const CAP_NHAT_ACTION = 'action/update';

    const THEM_MOI_MENU = 'menu/create';
    const CAP_NHAT_MENU = 'menu/update';

    const CHI_TIET_NDT = 'investor/detail';
    const CAP_NHAT_NDT = 'investor/update';
    const EXCEL_NDT = 'investor/excel';
    const THEM_MOI_NDT_UQ = 'investor/add_ndt_uy_quyen';
    const THEM_PHU_LUC_NDT_UQ = 'investor/add_phu_luc_ndt_uy_quyen';
    const CALL_UPDATE_INVESTOR = 'investor/call_update_investor';
    const CALL_INVESTOR = 'investor/call';
    const CALL_LEAD_INVESTOR = 'investor/call_lead';
    const CALL_UPDATE_LEAD_INVESTOR = 'investor/call_update_lead';
    const CALL_UPDATE_INVESTOR_ACTIVE = 'investor/call_update_investor_active';
    const CALL_INVESTOR_ACTIVE = 'investor/call_investor_active';

    const CHANGE_CALL = 'change_call';
    const CONFIG_CALL = 'config_call';

    const THEM_INVESTMENT = 'investment/create';

    const EXCEL_KI_TRA_LAI_NDT_APP = 'pay/excel';
    const EXCEL_KI_TRA_LAI_NDT_UQ = 'pay/excel_uq';

    const IMPORT_LEAD_INVESTOR = 'import/lead_investor';
    const IMPORT_CONTRACT_AUTHORITY = 'import/contract_authority';
    const TIM_KIEM_TLS = 'search_tls';
    const EXCEL_BCNS_CS_NDT = 'export_productivity_care';

    const XEM_CHART_INVEST = 'xem-chart-invest';
    const XEM_CHART_PAYMENT = 'xem-chart-payment';

    const EXCEL_COMMISSION = 'excel-commission';
    const VIEW_DASHBOARD_TELESALES = 'view_dashboard_telesales';
    const VIEW_LOG_KPI = 'view_log_kpi';

    const EXCEL_REPORT = 'excel-report';
}
