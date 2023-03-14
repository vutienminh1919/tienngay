<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<style>
		body {
			font-size: 1em !important;
		}

		body .name_bb {
			font-size: 18px;
		}

		body .table_infor_bg {
			font-size: 14px;
		}

		body .table_bg {
			font-size: 14px;
		}

		body .table_sign_twoway {
			font-size: 14px;
		}

		.block_ {
			display: block;
			font-weight: bold;
			line-height: 1.2;
			margin-top: 6pt;
			margin-right: 0;
			margin-bottom: 6pt;
			margin-left: 0;
			padding: 0;
			text-align: center;
		}

		.table_infor_bg .block_receiver {

		}

		.block_address {
			text-align: center;
		}

		.table_bg {
			border: 1px solid black;
			border-collapse: collapse;
			border-spacing: 10px;
			width: 100%;
		}

		.table_bg th {
			border: 1px solid black;
			height: 40px;
		}

		.table_bg td {
			border: 1px solid black;
			white-space: nowrap;
			padding: 8px;
		}

		.name_bb {
			text-align: center;
			padding-top: 5px;
		}

		.block_date {
			text-align: right;
		}

		.infor_bg {
			padding-left: 15px;
		}

		.sign_place_s {
			border-right-color: currentColor;
			border-right-style: none;
			border-right-width: 1pt;
			display: table-cell;
			padding-bottom: 0.5ex;
			padding-left: 57.4pt;
			padding-right: 5.4pt;
			padding-top: 0.5ex;
			text-align: inherit;
			vertical-align: top;
			width: 500pt;
		}

		.sign_place_r {
			border-left-color: currentColor;
			border-left-style: none;
			border-left-width: 1pt;
			border-right-color: currentColor;
			border-right-style: none;
			border-right-width: 1pt;
			display: table-cell;
			padding-bottom: 0.5ex;
			padding-left: 5.4pt;
			padding-right: 5.4pt;
			padding-top: 0.5ex;
			text-align: inherit;
			vertical-align: top;
			width: 177pt;
		}

	</style>
</head>
<body>
<div>
	<p class="block_">CÔNG TY CỔ PHẦN CÔNG NGHỆ TIỆN NGAY</p>
	<p class="block_address">Địa chỉ : Tầng 15 Khối B, tòa nhà Sông Đà, đường Phạm Hùng, phường Mỹ Đình 1, Quận Nam Từ Liêm, Hà
		Nội</p>
	<p class="name_bb"><b>BIÊN BẢN BÀN GIAO HỒ SƠ MIỄN GIẢM <?= !empty($profile->type_exception) && $profile->type_exception == 2 ? ' THANH LÝ XE' : (!empty($profile->type_exception) && $profile->type_exception == 1 ? ' NGOẠI LỆ' : ''); ?></b> <br>
		<span style="padding-top: 5px; font-size: 16px;">Số: <?php echo $profile->profile_name; ?></span>
		<br>&#x2581;&#x2581;&#x2581;&#x2581;&#x2581;&#x2581;&#x2581;&#x2581;&#x2581;</p>

	<p style="text-align: center"></p>
	<p class="block_date"><i><?php echo $profile->province_doc; ?>, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></i></p>
	<table class="table_infor_bg">
		<tbody>
			<tr>
				<td class="block_sender">
					<p>
						<b>1. Bên bàn giao</b>
					</p>
					<p class="infor_bg">- Họ tên: <?= $profile->user_send ? $profile->user_send : ''; ?></p>
					<p class="infor_bg">- Chức vụ: <?= $profile->position_user_send ? $profile->position_user_send : '';; ?></p>
					<p class="infor_bg">- Địa chỉ: <?= $profile->address_send ? $profile->address_send : '';; ?></p>
				</td>
				<td class="block_receiver">
					<p>
						<b>2. Bên nhận bàn giao</b>
					</p>
					<p class="infor_bg">- Họ tên: <?= $profile->user_receive ? $profile->user_receive : '';; ?></p>
					<p class="infor_bg">- Chức vụ: <?= $profile->position_user_receive ? $profile->position_user_receive : '';; ?></p>
					<p class="infor_bg">- Địa chỉ: <?= $profile->address_receive ? $profile->address_receive : '';; ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="block">
		<b>3. Chi tiết bàn giao</b>
	</p>
	<table class="table_bg">
		<thead>
		<tr class="calibre2" style="text-align: center">
			<th scope="col">STT</th>
			<th scope="col">MÃ PHIẾU GHI</th>
			<th scope="col">MÃ HỢP ĐỒNG</th>
			<th scope="col">KHÁCH HÀNG</th>
			<th scope="col">LOẠI MIỄN GIẢM</th>
			<th scope="col">ẢNH MAIL XÁC NHẬN</th>
			<?php if (!empty($profile->type_exception) && $profile->type_exception == 2) : ?>
			<th scope="col">BIÊN BẢN BÀN GIAO XE</th>
			<?php elseif (!empty($profile->type_exception) && $profile->type_exception == 1) : ?>

			<?php else : ?>
				<th scope="col">ĐƠN MIỄN GIẢM</th>
			<?php endif; ?>
			<th scope="col">BIÊN BẢN BÀN GIAO HỒ SƠ (02 bản)</th>
			<th scope="col">GHI CHÚ</th>
		</tr>
		</thead>
		<tbody class="calibre1">
		<?php if (!empty($profiles)) : ?>
			<?php foreach ($profiles as $key => $profile) : ?>
		<tr>
			<td><?= ++$key ?></td>
			<td><?= !empty($profile->code_contract) ? $profile->code_contract : ''; ?></td>
			<td><?= !empty($profile->code_contract_disbursement) ? $profile->code_contract_disbursement : ''; ?></td>
			<td><?= !empty($profile->customer_name) ? $profile->customer_name : ''; ?></td>
			<td><?= (!empty($profile->type_payment_exem) && $profile->type_payment_exem == 1) ? 'Thanh toán kỳ ' . $profile->ky_tra  : 'Tất toán'; ?></td>
			<td style="text-align: center"><?= (!empty($profile->confirm_email) && $profile->confirm_email == 1) ? '&times;' : '-'; ?></td>
			<?php if (!empty($profile->type_exception) && $profile->type_exception == 2) : ?>
			<td style="text-align: center"><?= (!empty($profile->bbbgx) && $profile->bbbgx == 1) ? '&times;' : '-'; ?></td>
			<?php elseif (!empty($profile->type_exception) && $profile->type_exception == 1) : ?>

			<?php else : ?>
			<td style="text-align: center"><?= (!empty($profile->is_exemption_paper) && $profile->is_exemption_paper == 1) ? '&times;' : '-'; ?></td>
			<?php endif; ?>
			<td style="text-align: center">&times;</td>
			<td><?= !empty($profile->profile_note) ? $profile->profile_note : ''; ?></td>

		</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<br>
	<br>
	<table class="table_sign_twoway">
		<tbody>
		<tr>
			<th class="sign_place_s">BÊN BÀN GIAO</th>
			<th class="sign_place_r">BÊN NHẬN BÀN GIAO</th>
		</tr>
		</tbody>
	</table>
</div>
</body>
</html>
