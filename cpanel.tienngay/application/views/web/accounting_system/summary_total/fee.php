<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>% lãi vay/tháng</th>
            <th>% phí tư vấn/tháng</th>
            <th>% phí thẩm định, quản lý</th>
            <th>% Phí trả chậm</th>
            <th>Số tiền phí trả chậm</th>
            <th>% Phí trả trước 1/3 thời hạn vay</th>
            <th>% Phí trả trước 2/3 thời hạn vay</th>
            <th>% Phí trả trước trong các TH còn lại</th>
            <th>Phí gia hạn khoản vay</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($contract->fee)) {?>
            <tr>
                <td>
                    <?= !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : 0?>
                </td>
                <td>
                    <?= !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory : 0?>
                </td>
                <td>
                    <?= !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0?>
                </td>
                <td>
                    <?= !empty($contract->fee->penalty_percent) ? $contract->fee->penalty_percent : 0?>
                </td>
                <td>
                    <?= !empty($contract->fee->penalty_amount) ? formatNumber($contract->fee->penalty_amount) : 0?>
                </td>
                <td>
                    <?= !empty($contract->fee->percent_prepay_phase_1) ? $contract->fee->percent_prepay_phase_1 : 0?>
                </td>
                <td>
                    <?= !empty($contract->fee->percent_prepay_phase_2) ? $contract->fee->percent_prepay_phase_2 : 0?>
                </td>
                <td>
                    <?= !empty($contract->fee->percent_prepay_phase_3) ? $contract->fee->percent_prepay_phase_3 : 0?>
                </td>
                <td>
                    <?= !empty($contract->fee->extend) ? formatNumber($contract->fee->extend) : 0?>
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>