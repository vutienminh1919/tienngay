<table class="table table-striped table-bordered" name="tbl_pay_interest_investor_<?= $contract->code_contract?>">
    <thead>
        <tr>
            <th>Tháng</th>
            <th>Nguồn tiền trả gốc vay</th>
            <th>Ngày trả</th>
            <th>Số tiền gôc phải trả mỗi tháng</th>
            <th>Số tiền lãi phải trả NĐT mỗi tháng</th>
            <th>Số tiền lãi đã trả</th>
            <th>Số tiền gốc đã trả</th>
            <th>Số còn lại phải trả NĐT tháng T</th>
            <th>Số còn lại phải trả NĐt đến thời điểm đáo hạn</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $planContracts = $contract->plan_contract;
            $type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest: "";
            $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
            $totalPaid = 0;
            foreach($planContracts as $item) {
                
                $amount_interest_paid = !empty($item->pay_investor) ? $item->pay_investor->amount_interest_paid : 0;
                $amount_root_paid = !empty($item->pay_investor) ? $item->pay_investor->amount_root_paid : 0;
                $totalPaid = $totalPaid + $amount_interest_paid + $amount_root_paid;
                $count_date_interest = !empty($item->count_date_interest) ? $item->count_date_interest : 0;
                $calLaivayphaitraNDT = $item->tien_goc_1thang + $item->tien_goc_con_thang;
        ?>
                <tr plan-id="<?= getId($item->_id)?>">
                    <td><?= !empty($item->time) ? $item->time : ""?></td>
                    <td>
                        <span id="resource_pay">
                            <?= !empty($item->pay_investor) ? $item->pay_investor->resource_pay : ""?>
                        </span>
                    </td>
                    <td>
                        <span id="date_pay">
                            <?= !empty($item->pay_investor) ? $item->pay_investor->date_pay : ""?>
                        </span>
                    </td>
                    <td>
                        <?= formatNumber($item->tien_goc_1thang)?>
                    </td>
                    <td>
                        <?php
                            //$feeInvestor = !empty($contract->fee) ? $contract->fee->percent_interest_investor : 0;
                            $feeInvestor = !empty($contract->fee) ? $contract->fee->percent_interest_customer : 0;
                            $amountFeeInvestor = $feeInvestor > 0 ? $amountCalculate * $feeInvestor / 100 : 0;
                            
                            //$amountFeeInvestor = $feeInvestor > 0 ? $calLaivayphaitraNDT * $feeInvestor / 100 : 0;
                            //$amountFeeInvestor = $amountFeeInvestor / 30 * $item->count_date_interest;
                            
                            //$amountFeeInvestor = getLaiVayPhaiTraNDT($type_interest, $amountCalculate, $feeInvestor, $calLaivayphaitraNDT, $item->count_date_interest);
                            echo formatNumber($amountFeeInvestor);
                        ?>
                    </td>
                    <td>
                        <span id="amount_interest_paid">
                            <?= $amount_interest_paid?>
                        </span>
                    </td>
                    <td>
                        <span id="amount_root_paid">
                            <?= $amount_root_paid?>
                        </span>
                    </td>
                    <td>
                        <!--Số còn lại phải trả NĐT tháng T-->
                        <?php
                            $amountNDT = $item->tien_goc_1thang + $amountFeeInvestor - $amount_interest_paid - $amount_root_paid;
                            echo formatNumber($amountNDT);
                        ?>
                    </td>
                    <td>
                        <!--Số còn lại phải trả NĐt đến thời điểm đáo hạn-->
                        <?php
                            $amountExpire = $amountCalculate + $total41_a - $totalPaid;
                            echo formatNumber($amountExpire);
                        ?>
                    </td>
                    <td>
                        <a href="#"
                           data-toggle="modal" 
                           data-target="#plan_modal"
                           data-time="<?= !empty($item->time) ? $item->time : ""?>"
                           data-code-contract="<?= $contract->code_contract?>"
                           data-plan-id="<?= getId($item->_id)?>" class="btn btn-info btn-modal-pay-investor"> Cập nhật </a>
                    </td>
                </tr>
        <?php }?>
    </tbody>
</table>