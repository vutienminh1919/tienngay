<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Mã nhà đầu tư</th>
            <th>Địa chỉ</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Thông tin TK trả NĐT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= !empty($contract->investor_infor->code) ? $contract->investor_infor->code : ""?>, </td>
            <td><?= !empty($contract->investor_infor->address) ? $contract->investor_infor->address : ""?></td>
            <td><?= !empty($contract->investor_infor->email) ? $contract->investor_infor->email : ""?></td>
            <td><?= !empty($contract->investor_infor->phone) ? $contract->investor_infor->phone : ""?>,</td>
            <td><?= !empty($contract->investor_infor->bank_ìnor) ? $contract->investor_infor->bank_ìnor : ""?></td>
        </tr>
    </tbody>
</table>
