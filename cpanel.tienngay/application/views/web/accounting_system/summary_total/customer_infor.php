<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Địa chỉ</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Ngân hàng</th>
            <th>Số thẻ ATM</th>
            <th>Tên chủ thẻ ATM</th>
            <th>Số TK</th>
            <th>Tên chủ TK</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?= !empty($contract->current_address->province_name) ? $contract->current_address->province_name : ""?>, 
                <?= !empty($contract->current_address->district_name) ? $contract->current_address->district_name : ""?>, 
                <?= !empty($contract->current_address->ward_name) ? $contract->current_address->ward_name : ""?>, 
            </td>
            <td>
                <?= !empty($contract->customer_infor->customer_email) ? $contract->customer_infor->customer_email : ""?>
            </td>
            <td>
                <?= !empty($contract->customer_infor->customer_phone_number) ? $contract->customer_infor->customer_phone_number : ""?>
            </td>
            <td>
                <?= !empty($contract->receiver_infor->bank_name) ? $contract->receiver_infor->bank_name : ""?>,
            </td>
            <td><?= !empty($contract->receiver_infor->atm_card_number) ? $contract->receiver_infor->atm_card_number : ""?></td>
            <td><?= !empty($contract->receiver_infor->atm_card_holder) ? $contract->receiver_infor->atm_card_holder : ""?></td>
            <td><?= !empty($contract->receiver_infor->bank_account) ? $contract->receiver_infor->bank_account : ""?></td>
            <td><?= !empty($contract->receiver_infor->bank_account_holder) ? $contract->receiver_infor->bank_account_holder : ""?></td>
        </tr>
    </tbody>
</table>