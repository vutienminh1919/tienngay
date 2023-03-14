<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Tháng</th>
            <th>Số ngày tính lãi tháng T</th>
            <th>Lãi vay phải trả NĐT</th>
            <th>Thuế TNCN phải nộp thay cho NĐT</th>
            <th>Phí tư vấn quản lý</th>
            <th>Phí thẩm định và lưu trữ tài sản đảm bảo</th>
            <th>Phí trả chậm</th>
            <th>Phí trả trước</th>
            <th>Phí gia hạn khoản vay</th>
            <th>Tổng phải thu lãi + phí tháng T</th>
            <th>Tổng phải thu khách hàng cuối tháng T (bao gồm gôc+ lãi)</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $res = $contract->plan_contract;
            $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
            $type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest: "";
            $total35 = 0; //Tổng Phí tư vấn quản lý
            $total36 = 0; //Tổng Phí thẩm định và lưu trữ tài sản đảm bảo
            $total37 = 0; //Tổng Phí trả chậm
            $total38 = 0; //Tổng Phí trả trước
            $total39 = 0; //Tổng Phí gia hạn khoản vay
            
            $total42 = 0;
            $total43 = 0;
            $amountFeeInvestor = 0;
            $sumAmountFeeInvestor = 0;
            $total = 0;
            $total3 = 0;
            foreach($res as $item) {
                $count_date_interest = !empty($item->count_date_interest) ? $item->count_date_interest : 0;
                $calLaivayphaitraNDT = $item->tien_goc_1thang + $item->tien_goc_con_thang;
        ?>
                <tr>
                    <td><?= !empty($item->time) ? $item->time : ""?></td>
                    <td><?= $count_date_interest?></td>
                    <td>
                        <?php
                            //$feeInvestor = !empty($contract->fee) ? $contract->fee->percent_interest_investor : 0;
                            $feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : 0;
                            $amountFeeInvestor = getLaiVayPhaiTraNDT_end_month($type_interest, $amountCalculate, $feeInvestor, $calLaivayphaitraNDT, $item->count_date_interest);
                            $sumAmountFeeInvestor = $sumAmountFeeInvestor + $amountFeeInvestor;
                            
                            //echo formatNumber($amountFeeInvestor);
                            echo formatNumber($item->tien_lai_1thang);
                        ?>
                    </td>
                    <td>
                        <?php
                            //$tax = $amountFeeInvestor * 0.05;
                            $tax = $item->tien_lai_1thang * 0.05;
                            echo formatNumber($tax);
                        ?>
                    </td>
                    <td>
                        <?php
                            $feeAdvisory = !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory: 0;
                            $amountFeeAdvisory = $amountCalculate * $feeAdvisory / 100;
                            $amountFeeAdvisory = $amountFeeAdvisory / 30 * $item->count_date_interest;
                            //var_dump($amountFeeAdvisory);
                            $total35 = $total35 + $amountFeeAdvisory;
                            echo formatNumber($amountFeeAdvisory);
                        ?>
                    </td>
                    <td>
                        <?php
                            $feeExpertise = !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0;
                            $amountFeeExpertise = $amountCalculate * $feeExpertise / 100;
                            $amountFeeExpertise = $amountFeeExpertise / 30 * $item->count_date_interest;
                            $total36 = $total36 + $amountFeeExpertise;
                            echo formatNumber($amountFeeExpertise);
                        ?>
                    </td>
                    <td>
                        <?php
                            $amountFeeDelayPay = !empty($item->fee_delay_pay) ? $item->fee_delay_pay : 0;
                            $total37 = $total37 + $amountFeeDelayPay;
                            echo $amountFeeDelayPay;
                        ?>
                    </td>
                    <td>
                        <?php
                            $amountFeePrePay = !empty($item->fee_prepay) ? $item->fee_prepay : 0;
                            $total38 = $total38 + $amountFeePrePay;
                            echo $amountFeePrePay;
                        ?>
                    </td>
                    <td>
                        <?php
                            $amountFeeExtend = !empty($item->fee_extend) ? $item->fee_extend : 0;
                            $total39 = $total39 + $amountFeeExtend;
                            echo $amountFeeExtend;
                        ?>
                    </td>
                    <td>
                        <!--Tổng phải thu lãi+ phí tháng T-->
                        <?php
                            $total = $amountFeeInvestor + $amountFeeAdvisory + $amountFeeExpertise + $amountFeeDelayPay + $amountFeePrePay + $amountFeeExtend;
                            $total3 = $total3 + $total;
                            echo formatNumber($total);
                        ?>  
                    </td>
                    <td>
                        <!--Tổng phải thu khách hàng cuối tháng T (bao gồm gôc+ lãi)-->
                        <?php
                            $amount1 = getAmonutByTypePay($type_interest, $amountCalculate, $calLaivayphaitraNDT);
                            //$total1 = $total + $contract->receiver_infor->amount;
                            $total1 = $total + $amount1;
                            echo formatNumber($total1);
                        ?>  
                    </td>
                </tr>
        <?php }?>
    </tbody>
</table>
<strong style="">Lãi dự thu đến thời điểm đáo hạn: </strong>
<br>
<span>- Lãi NDT dự thu đến thời điểm đáo hạn: <?= formatNumber($total41_a - $sumAmountFeeInvestor)?></span>
<br>
<span>- Phí dự thu đến thời điểm đáo hạn: <?= formatNumber($total42_a - $total3 + $sumAmountFeeInvestor)?></span>