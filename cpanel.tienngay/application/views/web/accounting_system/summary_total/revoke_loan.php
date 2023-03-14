<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Tháng</th>
            <th>Ngày thu hồi</th>
            <th>Hình thức thu hồi</th>
            <th>Mã GD NH/Phiếu thu</th>
            <th>Số tiền lãi đã thu hồi</th>
            <th>Số tiền gốc đã thu hồi</th>
            <th>Gốc còn lại cuối tháng T+1 </th>
            <th>Gốc còn lại tính từ tháng T+1 đến thời điểm đáo hạn</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $res = $contract->plan_contract;
            $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
            foreach($res as $item) {
                $amountInterest = !empty($item->revoke->amount_interest) ?  $item->revoke->amount_interest : 0;
                $amountRoot = !empty($item->revoke->amount_root) ? $item->revoke->amount_root : 0;
                //$feeInvestor = !empty($contract->fee) ? $contract->fee->percent_interest_investor : 0;
                $feeInvestor = !empty($contract->fee) ? $contract->fee->percent_interest_customer : 0;
                $amountFeeInvestor = $feeInvestor > 0 ? $amountCalculate * $feeInvestor / 100 : 0;
                $feeAdvisory = !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory: 0;
                $amountFeeAdvisory = $amountCalculate * $feeAdvisory / 100;
                $feeExpertise = !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0;
                $amountFeeExpertise = $amountCalculate * $feeExpertise / 100;
                $amountFeeDelayPay = !empty($item->fee_delay_pay) ? $item->fee_delay_pay : 0;
                $amountFeePrePay = !empty($item->fee_prepay) ? $item->fee_prepay : 0;
                $amountFeeExtend = !empty($item->fee_extend) ? $item->fee_extend : 0;
                $total40 = $item->tien_goc_1thang + $amountFeeInvestor + $amountFeeAdvisory + $amountFeeExpertise + $amountFeeDelayPay + $amountFeePrePay + $amountFeeExtend;
        ?>
                <tr>
                    <td><?= !empty($item->time) ? $item->time : ""?></td>
                    <td><?= !empty($item->revoke) ? $this->time_model->convertTimestampToDatetime($item->revoke->date) : ""?></td>
                    <td>
                        <?php
                            if(!empty($item->revoke) && $item->revoke->type == 1){
                                echo "Tiền mặt";
                            } else if(!empty($item->revoke) && $item->revoke->type == 2){
                                echo "Bank";
                            }
                        ?>
                    </td>
                    <td><?= !empty($item->revoke) ? $item->revoke->code : ""?></td>
                    <td><?= formatNumber($amountInterest)?></td>
                    <td><?= formatNumber($amountRoot)?></td>
                    <td><?= formatNumber($total40 - $amountInterest - $amountRoot)?></td>
                    <td><?= formatNumber($total43_a - $amountInterest - $amountRoot)?></td>
                </tr>
        <?php }?>
    </tbody>
</table>
