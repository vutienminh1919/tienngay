<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Tổng theo dõi
                <br>
                <small>
                    <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Tổng theo dõi</a>
                </small>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                
                <div class="x_panel">
                    <?php 
                        $dataSearch['_GET'] = $_GET;
                        $this->load->view("web/accounting_system/summary_total/search.php", $dataSearch);
                    ?>
                    <div class="table-responsive">
                        <input type="hidden" id="param_url_code_contract" value="<?= !empty($_GET['codeContract']) ? $_GET['codeContract'] : ""?>">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <!--Thông tin khoản vay-->
                                    <th>Mã giao dịch(Vimo hoặc Bank)</th>
                                    <th>Mã hợp đồng vay</th>
                                    <th>Tên NĐT</th>
                                    <th>Mã NĐT</th>
                                    <th>Phòng giao dịch giải ngân</th>
                                    <th>Hình thức cầm cố</th>
                                    <th>Thời hạn vay(ngày)</th>
                                    <th>Ngày giải ngân</th>
                                    <th>Ngày đáo hạn</th>
                                    <th>Tên người vay</th>
                                    <th>Mã người vay ( trùng CMT)</th>
                                    <th>Số tiền giải ngân</th>
                                    <th>Số tiền gia hạn</th>
                                    <th>Tổng giải ngân lũy kế</th>
                                    <th>Tổng volume lũy kế</th>
                                    <th>Mã phụ lục gia hạn</th>
                                    <th>Hình thức trả</th>
                                    <th><span style="font-size: 15px; color:red;">Biểu phí</span></th>
                                    <th><span style="font-size: 15px; color:red;">Lãi+ phí phải thu khách hàng từ thời điểm vay đến thời điểm đáo hạn</span></th>
                                    <th><span style="font-size: 15px; color:red;">Lãi + phí tính đến thời điểm cuối mỗi tháng T</span></th>
                                    <th><span style="font-size: 15px; color:red;">Thu hồi khoản vay</span></th>
                                    <th>Trạng thái</th>
                                    <th>Số gốc phải trả đến thời điểm đáo hạn: </th>
                                    <th>Số lãi phải trả đến thời điểm đáo hạn: </th>
                                    <th><span style="font-size: 15px; color:red;">Thanh toán lãi và gốc cho NĐT</span></th>
                                    <th><span style="font-size: 15px; color:red;">Thông tin khách hàng</span></th>
                                    <th><span style="font-size: 15px; color:red;">Thông tin Nhà đầu tư</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalDisburseAccumulated = 0; // Tổng giải ngân lũy kế
                                    $totalVolumeAccumulated = 0; // Tổng volume lũy kế
                                    foreach($data as $item) {
                                        $countExtend = !empty($item->count_extend) ? $item->count_extend : 0;
                                        $amountExtend = !empty($item->amount_extend) ? $item->amount_extend : 0;
                                        $amountCalculate = !empty($item->amount_extend) ? $item->amount_extend : $item->receiver_infor->amount;
                                        $codeContractExtend = !empty($item->code_contract_extend) ? $item->code_contract_extend : "";
                                ?>
                                    <tr>
                                        <!--Thông tin khoản vay-->
                                        <td>
                                            <?php if(!empty($item->investor_code) && $item->investor_code == 'vimo' && $item->status_create_withdrawal == 'success') {?>
                                                <?= $item->response_get_transaction_withdrawal_status->withdrawal_transaction_id?>
                                            <?php }?>
                                        </td>
                                        <td><?= !empty($item->code_contract) ? $item->code_contract : "";?></td>
                                        <td><?= !empty($item->investor_infor->name) ? $item->investor_infor->name : ""?></td>
                                        <td><?= !empty($item->investor_infor->code) ? $item->investor_infor->code : ""?></td>
                                        <td><?= !empty($item->store->name) ? $item->store->name : ""?></td>
                                        <td><?= !empty($item->loan_infor) ? $item->loan_infor->type_loan->code.'-'.$item->loan_infor->type_property->code : ""?></td>
                                        <td><?= $item->loan_infor->number_day_loan?></td>
                                        <td><?= !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime($item->disbursement_date) : "" ?></td>
                                        <td><?= !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime($item->expire_date) : "" ?></td>
                                        <td><?= $item->customer_infor->customer_name?></td>
                                        <td><?= $item->customer_infor->customer_identify?></td>
                                        <td>
                                            <?php if(empty($item->count_extend)) {?>
                                                <?= formatNumber($item->receiver_infor->amount)?>
                                            <?php }?>
                                        </td>
                                        <td><?= formatNumber($amountExtend)?></td>
                                        <td>
                                            <?php 
                                                $totalDisburseAccumulated = $totalDisburseAccumulated + $item->receiver_infor->amount;
                                                echo formatNumber($totalDisburseAccumulated);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $totalVolumeAccumulated = $totalVolumeAccumulated + $item->receiver_infor->amount + $amountExtend;
                                                echo formatNumber($totalVolumeAccumulated);
                                            ?>
                                        </td>
                                        <td><?= $codeContractExtend?></td>
                                        <td>
                                            <?php
                                                $type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest: "";
                                                if($type_interest == 1){
                                                    echo "Lãi hàng tháng, gốc hàng tháng";
                                                }else{
                                                    echo "Lãi hàng tháng, gốc cuối kỳ";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <!--Biểu phí-->
                                            <?php 
                                                if(!empty($item->code_contract)) {
                                                    $data['contract'] = $item;
                                                    $this->load->view("web/accounting_system/summary_total/fee.php", $data);
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <!--Lãi+ phí phải thu khách hàng từ thời điểm vay đến thời điểm đáo hạn-->
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tháng</th>
                                                        <th>Gốc thu mỗi tháng</th>
                                                        <th>Lãi vay phải trả NĐT</th>
                                                        <th>Phí tư vấn quản lý</th>
                                                        <th>Phí thẩm định và lưu trữ tài sản đảm bảo</th>
                                                        <th>Phí trả chậm</th>
                                                        <th>Phí trả trước</th>
                                                        <th>Phí gia hạn khoản vay</th>
                                                        <th>Tổng phải thu (gốc và lãi) tháng Tn</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $planContracts = $item->plan_contract;
                                                        $amountCalculate = !empty($item->amount_extend) ? $item->amount_extend : $item->receiver_infor->amount;
                                                        $total35 = 0; //Tổng Phí tư vấn quản lý
                                                        $total36 = 0; //Tổng Phí thẩm định và lưu trữ tài sản đảm bảo
                                                        $total37 = 0; //Tổng Phí trả chậm
                                                        $total38 = 0; //Tổng Phí trả trước
                                                        $total39 = 0; //Tổng Phí gia hạn khoản vay

                                                        $total40 = 0;
                                                        $total41 = 0;
                                                        $total42 = 0;
                                                        $total43 = 0;
                                                        foreach($planContracts as $planContract) {
                                                            $calLaivayphaitraNDT = $planContract->tien_goc_1thang + $planContract->tien_goc_con_thang;
                                                    ?>
                                                            <tr>
                                                                <td><?= !empty($planContract->time) ? $planContract->time : ""?></td>
                                                                <td><?= formatNumber($planContract->tien_goc_1thang)?></td>
                                                                <td>
                                                                    <?php
                                                                        //$feeInvestor = !empty($item->fee) ? $item->fee->percent_interest_investor : 0;
                                                                        $feeInvestor = !empty($item->fee) && !empty($item->fee->percent_interest_customer) ? $item->fee->percent_interest_customer : 0;
                                                                        //$amountFeeInvestor = $feeInvestor > 0 ? $amountCalculate * $feeInvestor / 100 : 0;
                                                                        $amountFeeInvestor = getLaiVayPhaiTraNDT_expire($type_interest, $amountCalculate, $feeInvestor, $calLaivayphaitraNDT);
                                                                        
                                                                        $total41 = $total41 + $amountFeeInvestor;
                                                                        echo formatNumber($amountFeeInvestor);
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $feeAdvisory = !empty($item->fee->percent_advisory) ? $item->fee->percent_advisory: 0;
                                                                        $amountFeeAdvisory = $amountCalculate * $feeAdvisory / 100;
                                                                        //$amountFeeAdvisory = $amountFeeAdvisory / 30 * $planContract->count_date_interest;
                                                                        $total35 = $total35 + $amountFeeAdvisory;
                                                                        echo formatNumber($amountFeeAdvisory);
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $feeExpertise = !empty($item->fee->percent_expertise) ? $item->fee->percent_expertise : 0;
                                                                        $amountFeeExpertise = $amountCalculate * $feeExpertise / 100;
                                                                        //$amountFeeExpertise = $amountFeeExpertise / 30 * $planContract->count_date_interest;
                                                                        $total36 = $total36 + $amountFeeExpertise;
                                                                        echo formatNumber($amountFeeExpertise);
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $amountFeeDelayPay = !empty($planContract->fee_delay_pay) ? $planContract->fee_delay_pay : 0;
                                                                        $total37 = $total37 + $amountFeeDelayPay;
                                                                        echo $amountFeeDelayPay;
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $amountFeePrePay = !empty($planContract->fee_prepay) ? $planContract->fee_prepay : 0;
                                                                        $total38 = $total38 + $amountFeePrePay;
                                                                        echo $amountFeePrePay;
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $amountFeeExtend = !empty($planContract->fee_extend) ? $planContract->fee_extend : 0;
                                                                        $total39 = $total39 + $amountFeeExtend;
                                                                        echo $amountFeeExtend;
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $total40 = $planContract->tien_goc_1thang + $amountFeeInvestor + $amountFeeAdvisory + $amountFeeExpertise + $amountFeeDelayPay + $amountFeePrePay + $amountFeeExtend;
                                                                        echo formatNumber($total40);
                                                                    ?>  
                                                                </td>
                                                            </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
                                            <span>Tổng phải thu lãi NĐT từ khi  giải ngân đến thời điểm đáo hạn: <?= formatNumber($total41)?></span>
                                            <br>
                                            <span>Tổng phải thu phí TCV từ khi  giải ngân đến thời điểm đáo hạn: 
                                                <?php 
                                                    $total42 = $total35 + $total36 + $total37 + $total38 + $total39;
                                                    echo formatNumber($total42);
                                                ?>
                                            </span>
                                            <br>
                                            <span>Tổng phải thu (gốc và lãi, phí) từ khi  giải ngân đến thời điểm đáo hạn: 
                                                <?php
                                                    $total43 = $amountCalculate + $total41 + $total42;
                                                    echo formatNumber($total43);
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <!--Lãi + phí tính đến thời điểm cuối mỗi tháng T-->
                                            <?php 
                                                if(!empty($item->code_contract)) {
                                                    $data['contract'] = $item;
                                                    $data['total41_a'] = $total41;
                                                    $data['total42_a'] = $total42;
                                                    $this->load->view("web/accounting_system/summary_total/report_end_month.php", $data);
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <!--Thu hồi khoản vay-->
                                            <?php 
                                                if(!empty($item->code_contract)) {
                                                    $data['contract'] = $item;
                                                    $data['total40_a'] = $total40;
                                                    $data['total43_a'] = $total43;
                                                    $this->load->view("web/accounting_system/summary_total/revoke_loan.php", $data);
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($item->status == 17) echo "Đang vay";
                                            ?>
                                            <!--Tất toán hoặc gia hạn-->
                                        </td>
                                        <td>
                                            <?php
                                                $valColumn78 = 0;
                                                $valColumn78 = (float)$amountCalculate;
                                            ?>
                                                <?= formatNumber($amountCalculate);?>
                                        </td>
                                        <td>
                                            <?php
                                                $valColumn79 = 0;
                                                $valColumn79 = (float)$total41;
                                            ?>
                                            <?= formatNumber($total41);?>
                                        </td>
                                        <td>
                                            <!--Thanh toán lãi và gốc cho NĐT-->
                                            <?php 
                                                if(!empty($item->code_contract)) {
                                                    $data['contract'] = $item;
                                                    $data['total41_a'] = $total41;
                                                    $data['column78'] = $valColumn78;
                                                    $data['column79'] = $valColumn79;
                                                    $this->load->view("web/accounting_system/summary_total/pay_interest_root_investor.php", $data);
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <!--Thông tin khách hàng-->
                                            <?php 
                                                if(!empty($item->code_contract)) {
                                                    $data['contract'] = $item;
                                                    $this->load->view("web/accounting_system/summary_total/customer_infor.php", $data);
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <!--Thông tin NĐT-->
                                            <?php 
                                                if(!empty($item->code_contract)) {
                                                    $data['contract'] = $item;
                                                    $this->load->view("web/accounting_system/summary_total/investor_infor.php", $data);
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("web/accounting_system/modal/pay_investor.php")?>
<script src="<?= base_url("assets")?>/js/accounting_system/index.js"></script>
<script src="<?= base_url("assets")?>/js/numeral.min.js"></script>
