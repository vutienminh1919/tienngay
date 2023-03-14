<?php


namespace Modules\MongodbCore\Repositories;

use Modules\MongodbCore\Entities\Contract;
use Modules\MongodbCore\Entities\Lead;
use Modules\MongodbCore\Entities\Mic_tnds;
use Modules\MongodbCore\Entities\Pti_vta_bn;
use Modules\MongodbCore\Entities\Vbi_sxh;
use Modules\MongodbCore\Entities\Vbi_utv;
use Modules\MongodbCore\Entities\Gic_plt_bn;
use Modules\MongodbCore\Entities\Collaborator;
use Modules\MongodbCore\Entities\Commission_setup;


class DonVayRepository extends BaseRepository implements DonVayRepositoryInterface
{

    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Lead::class;
    }

    public function getAllLoanOrder($filter)
    {
        $query = $this->model;
        $per_page = 15;
        $page = !empty($filter['page']) ? $filter['page'] : 1;
        if (isset($filter['datefrom']) && isset($filter['dateto'])) {
            $from_date = strtotime(trim($filter['datefrom']) . '00:00:00');
            $to_date = strtotime(trim($filter['dateto']) . '23:59:59');
            $query = $query->whereBetween(Lead::COLUMN_CREATED_AT, [$from_date, $to_date]);
        }
        if (isset($filter['filter_many'])) {
            $filter_many = $filter['filter_many'];
            $query = $query->where(Lead::COLUMN_PHONE_NUMBER, 'like', "%$filter_many%")
                ->orWhere(Lead::COLUMN_FULL_NAME, 'like', "%$filter_many%")
                ->orWhere(Lead::COLUMN_GROUP_CTV_PHONE, 'like', "%$filter_many%");
        }
        if (isset($filter['status'])) {
            $query = $query->where(Lead::COLUMN_STATUS_WEB, $filter['status']);
        }
        $user = Collaborator::where(Collaborator::COLUMN_ID, $filter["ctv_code"])->first();
        if (!empty($user)) {
            if (isset($user['manager_id'])) {
                $query = $query->where(Lead::COLUMN_CTV_CODE, $filter["ctv_code"]);
            }
        }
        $leads = $query->where(Lead::COLUMN_GROUP_CTV_PHONE, $filter["manager_phone"])
            ->where(Lead::COLUMN_ORDER_TYPE, Lead::ORDER_LOAN)
            ->where(Lead::COLUMN_ACCOUNT_TYPE, Lead::ACCOUNT_MEMBER)
            ->orderBy(Lead::COLUMN_CREATED_AT, self::DESC)
            ->offset($page)
            ->limit($per_page)
            ->paginate($per_page);

        if (!empty($leads)) {
            foreach ($leads as $lead) {
                if (in_array($lead->type_finance, Lead::TYPE_FINANCE_APPLY_COMMISSION_ARRAY)) {
                    $lead->dichvusanpham = "Hợp đồng vay";
                    $check_contract = Contract::where('customer_infor.id_lead', (string)$lead->_id)
                        ->orderBy('created_at', 'DESC')
                        ->select('status','loan_infor.amount_loan','loan_infor.type_loan','loan_infor.loan_product')
                        ->get();
                    if (!empty($check_contract)) {
                        foreach ($check_contract as $contract) {
                            $status = $contract->status;
                            if ($contract->status == 3) {
                                $lead->status_web = "Thất bại";
                            } elseif ($status >= 17 && $status != 18 && $status != 35 && $status != 36) {
                                $lead->status_web = "Thành công";
//                                if (in_array($contract->loan_infor['loan_product']['code'], ['1', '2', '3', '10', '11'])) {
//                                    $query->where('_id', $lead->_id)->update(["type_finance" => '4']);
//                                } elseif (in_array($contract->loan_infor['loan_product']['code'], ['6', '7'])) {
//                                    $query->where('_id', $lead->_id)->update(["type_finance" => '3']);
//                                } elseif (in_array($contract->loan_infor['loan_product']['code'], ['4'])) {
//                                    $query->where('_id', $lead->_id)->update(["type_finance" => '2']);
//                                } elseif (in_array($contract->loan_infor['loan_product']['code'], ['5'])) {
//                                    $query->where('_id', $lead->_id)->update(["type_finance" => '1']);
//                                } elseif (in_array($contract->loan_infor['loan_product']['code'], ['18'])) {
//                                    $query->where('_id', $lead->_id)->update(["type_finance" => '7']);
//                                } elseif (in_array($contract->loan_infor['loan_product']['code'], ['16'])) {
//                                    $query->where('_id', $lead->_id)->update(["type_finance" => '8']);
//                                } elseif (in_array($contract->loan_infor['loan_product']['code'], ['17'])) {
//                                    $query->where('_id', $lead->_id)->update(["type_finance" => '9']);
//                                } elseif (in_array($contract->loan_infor['loan_product']['code'], ['14'])) {
//                                    $query->where('_id', $lead->_id)->update(["type_finance" => '6']);
//                                }
                            } else {
                                $lead->status_web = "Đang xử lý";
                            }
                            $lead->price = $contract->loan_infor['amount_loan'];
                            $lead->mahoahong = $contract->loan_infor['type_loan']['text'];
                            if ($contract->loan_infor['loan_product']['code'] == "16" || $contract->loan_infor['loan_product']['code'] == "17"){
                                if ($contract->loan_infor['amount_loan'] > 200000000){
                                    $lead->mahoahong = "nha-dat-2";
                                } else {
                                    $lead->mahoahong = "nha-dat-1";
                                }
                            }
                        }
                    }
                }
                $tien_hoa_hong = 0;
                $log_commission_setup = "";
                if (!empty($lead->mahoahong)) {
                    if (in_array($lead->mahoahong, ["Cho vay", "Cầm cố", "nha-dat-2", "nha-dat-1"])) {
                        $commission_setup = Commission_setup::where('product_type.code', 'KV')->where('status','active')->get();
                        if ($lead->mahoahong == "Cho vay") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[1]['percent']/100;
                        }
                        if ($lead->mahoahong == "Cầm cố") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[0]['percent']/100;
                        }
                        if ($lead->mahoahong == "nha-dat-1") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[2]['percent']/100;
                        }
                        if ($lead->mahoahong == "nha-dat-2") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[3]['percent']/100;
                        }
                        $log_commission_setup = $commission_setup[0]->_id;
                    }
                }
                if (!empty($lead->status_sale) && $lead->status_sale == "19"){
                    $lead->status_web = "Thất bại";
                }
                $query->where('_id', $lead->_id)->update(
                    [
                        "status_web" => !empty($lead->status_web) ? $lead->status_web : "Đang xử lý",
                        'price' => !empty($lead->price) ? $lead->price : 0,
                        'tien_hoa_hong' => !empty($tien_hoa_hong) ? $tien_hoa_hong : 0,
                        'commission_setup_id' => !empty($log_commission_setup) ? $log_commission_setup : "",
                    ]
                );
            }
        }
        return $leads;
    }

    public function getAllInsuranceOrder($filter)
    {
        $query = $this->model;
        $per_page = 15;
        $page = !empty($filter['page']) ? $filter['page'] : 1;
        if (isset($filter['datefrom']) && isset($filter['dateto'])) {
            $from_date = strtotime(trim($filter['datefrom']) . '00:00:00');
            $to_date = strtotime(trim($filter['dateto']) . '23:59:59');
            $query = $query->whereBetween(Lead::COLUMN_CREATED_AT, [$from_date, $to_date]);
        }
        if (isset($filter['filter_many'])) {
            $filter_many = $filter['filter_many'];
            $query = $query->where(Lead::COLUMN_PHONE_NUMBER, 'like', "%$filter_many%")
                ->orWhere(Lead::COLUMN_FULL_NAME, 'like', "%$filter_many%")
                ->orWhere(Lead::COLUMN_GROUP_CTV_PHONE, 'like', "%$filter_many%");
        }
        if (isset($filter['status'])) {
            $query = $query->where(Lead::COLUMN_STATUS_WEB, $filter['status']);
        }
        $user = Collaborator::where(Collaborator::COLUMN_ID, $filter["ctv_code"])->first();
        if (!empty($user)) {
            if (isset($user['manager_id'])) {
                $query = $query->where(Lead::COLUMN_CTV_CODE, $filter["ctv_code"]);
            }
        }
        $leads = $query->where(Lead::COLUMN_GROUP_CTV_PHONE, $filter['manager_phone'])
            ->where(Lead::COLUMN_ACCOUNT_TYPE, Lead::ACCOUNT_MEMBER)
            ->where(Lead::COLUMN_ORDER_TYPE, Lead::ORDER_INSURANCE)
            ->orderBy(Lead::COLUMN_CREATED_AT, self::DESC)
            ->offset($page)
            ->limit($per_page)
            ->paginate($per_page);
        if (!empty($leads)) {
            foreach ($leads as $lead) {
                $lead_phone = $lead->phone_number;
                $type_finance = $lead->type_finance;
                if ($type_finance == 10) {
                    $insurance_pti = Pti_vta_bn::where(Pti_vta_bn::COLUMN_CUSTOMER_PHONE, $lead_phone)
                        ->where('type_pti', 'BN')
                        ->select('status','price')
                        ->get();
                    if (!empty($insurance_pti)) {
                        foreach ($insurance_pti as $pti) {
                            if (!empty($pti->data_origin->sel_ql) && $pti->data_origin->sel_year) {
                                $product_name_pti = "Bảo hiểm Vững Tâm An " . $pti->data_origin->sel_ql . ' - ' . $pti->data_origin->sel_year;
                            } else {
                                $product_name_pti = "Bảo hiểm Vững Tâm An";
                            }
                            $lead->dichvusanpham = $product_name_pti;
                            if ($pti->status == 1) {
                                $lead->status_web = "Thành công";
                            } elseif ($pti->status == 3) {
                                $lead->status_web = "Thất bại";
                            } else {
                                $lead->status_web = "Đang xử lý";
                            }

                            $lead->price = $pti->price;
                            $lead->mahoahong = "pti-vung-tam-an";
                        }
                    }
                }
                if ($type_finance == 11) {
                    $insurance_gic_plt_bn = Gic_plt_bn::where(Gic_plt_bn::COLUMN_CUSTOMER_PHONE, $lead_phone)
                        ->orderBy('created_at', 'DESC')
                        ->select('status','price')
                        ->get();
                    if (!empty($insurance_gic_plt_bn)) {
                        foreach ($insurance_gic_plt_bn as $plt) {
                            if (!empty($plt->request->code_GIC_plt)) {
                                $product_name_plt = "Bảo hiểm Phúc Lộc Thọ - " . $plt->request->code_GIC_plt;
                            } else {
                                $product_name_plt = "Bảo hiểm Phúc Lộc Thọ";
                            }
                            $lead->dichvusanpham = $product_name_plt;
                            if ($plt->status == 1) {
                                $lead->status_web = "Thành công";
                            } elseif ($plt->status == 3) {
                                $lead->status_web = "Thất bại";
                            } else {
                                $lead->status_web = "Đang xử lý";
                            }
                            $lead->price = $plt->price;
                            $lead->mahoahong = "bh-phuc-loc-tho";
                        }
                    } else {
                        $lead->dichvusanpham = "Bảo hiểm Phúc Lộc Thọ";
                    }
                }
                if ($type_finance == 12) {
                    $insurance_vbi_utv = Vbi_utv::where(Vbi_utv::COLUMN_CUSTOMER_PHONE, $lead_phone)
                        ->orderBy('created_at', 'DESC')
                        ->select('status','fee')
                        ->get();
                    if (!empty($insurance_vbi_utv)) {
                        foreach ($insurance_vbi_utv as $utv) {
                            if (!empty($utv->goi_bh)) {
                                $product_name_utv = $utv->goi_bh;
                            } else {
                                $product_name_utv = "Bảo hiểm Ung thư vú";
                            }
                            $lead->dichvusanpham = $product_name_utv;
                            if ($utv->status == 1) {
                                $lead->status_web = "Thành công";
                            } elseif ($utv->status == 3) {
                                $lead->status_web = "Thất bại";
                            } else {
                                $lead->status_web = "Đang xử lý";
                            }
                            $lead->price = $utv->fee;
                            $lead->mahoahong = "ung-thu-vu";
                        }
                    }
                }
                if ($type_finance == 13) {
                    $insurance_vbi_sxh = Vbi_sxh::where(Vbi_sxh::COLUMN_CUSTOMER_PHONE, $lead_phone)
                        ->orderBy('created_at', 'DESC')
                        ->select('status','fee')
                        ->get();
                    if (!empty($insurance_vbi_sxh)) {
                        foreach ($insurance_vbi_sxh as $sxh) {
                            if (!empty($sxh->goi_bh)) {
                                $product_name_sxh = $sxh->goi_bh;
                            } else {
                                $product_name_sxh ="Bảo hiểm Sốt xuất huyết";
                            }
                            $lead->dichvusanpham = $product_name_sxh;
                            if ($sxh->status == 1) {
                                $lead->status_web = "Thành công";
                            } elseif ($sxh->status == 3) {
                                $lead->status_web = "Thất bại";
                            } else {
                                $lead->status_web = "Đang xử lý";
                            }
                            $lead->price = $sxh->fee;
                            $lead->mahoahong = "sot-xuat-huyet";
                        }
                    }
                }
                if ($type_finance == 14) {
                    $lead->dichvusanpham = "Bảo hiểm TNDS xe máy/ô tô";
                    $insurance_mic_tnds = Mic_tnds::where(Mic_tnds::COLUMN_CUSTOMER_PHONE, $lead_phone)
                        ->orderBy('created_at', 'DESC')
                        ->select('status','mic_fee')
                        ->get();
                    if (!empty($insurance_mic_tnds)) {
                        foreach ($insurance_mic_tnds as $mic_tnds) {
                            if ($mic_tnds->status == 1) {
                                $lead->status_web = "Thành công";
                            } elseif ($mic_tnds->status == 3) {
                                $lead->status_web = "Thất bại";
                            } else {
                                $lead->status_web = "Đang xử lý";
                            }
                            $lead->price = $mic_tnds->mic_fee;
                            $lead->mahoahong = "bh-tnds";
                        }
                    }
                }
                $tien_hoa_hong = 0;
                $log_commission_setup = "";
                if (!empty($lead->mahoahong)){
                    if (in_array($lead->mahoahong, ["bh-phuc-loc-tho", "pti-vung-tam-an", "bh-tnds", "sot-xuat-huyet", "ung-thu-vu"])) {
                        $commission_setup = Commission_setup::where('product_type.code', 'BH')->where('status','active')->get();
                        if ($lead->mahoahong == "pti-vung-tam-an") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[0]['percent']/100;
                        }
                        if ($lead->mahoahong == "sot-xuat-huyet") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[1]['percent']/100;
                        }
                        if ($lead->mahoahong == "bh-tnds") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[4]['percent']/100;
                        }
                        if ($lead->mahoahong == "ung-thu-vu") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[2]['percent']/100;
                        }
                        if ($lead->mahoahong == "bh-phuc-loc-tho") {
                            $tien_hoa_hong = $lead->price * $commission_setup[0]->product_list[5]['percent']/100;
                        }
                        $log_commission_setup = $commission_setup[0]->_id;
                    }
                }
                if (!empty($lead->status_sale) && $lead->status_sale == "19"){
                    $lead->status_web = "Thất bại";
                }
                $query->where(Lead::COLUMN_ID, $lead->_id)->update(
                    [
                        'price' => !empty($lead->price) ? $lead->price : 0,
                        "status_web" => !empty($lead->status_web) ? $lead->status_web : "Đang xử lý",
                        'tien_hoa_hong' => !empty($tien_hoa_hong) ? $tien_hoa_hong : 0,
                        'commission_setup_id' => !empty($log_commission_setup) ? $log_commission_setup : ""
                    ]
                );
            }
        }
        return $leads;
    }


    public function toggleActive($id)
    {
        // TODO: Implement toggleActive() method.
    }

    public function find_foreignKey($id, $table, $collection)
    {
        // TODO: Implement find_foreignKey() method.
    }

    public function count_find_foreignKey($id, $table, $collection)
    {
        // TODO: Implement count_find_foreignKey() method.
    }
}
