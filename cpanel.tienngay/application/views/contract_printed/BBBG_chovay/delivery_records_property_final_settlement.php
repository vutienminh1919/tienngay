<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>BIÊN BẢN BÀN GIAO TÀI SẢN - SAU KHI THANH LÝ THỎA THUẬN BA BÊN</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

</head>
<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$mydate = getdate(date("U"));
$ngay_giai_ngan = isset($contract->disbursement_date) ? date('d/m/Y', $contract->disbursement_date) : '';
$ten_tai_san = isset($contract->loan_infor->name_property->text) ? $contract->loan_infor->name_property->text : '';
$loai_tai_san = isset($contract->loan_infor->type_property->text) ? $contract->loan_infor->type_property->text : '';
$customer_identify = isset($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : '';
$identify_issued_by = isset($contract->customer_infor->issued_by) ? $contract->customer_infor->issued_by : '';
$customer_name = isset($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : '';
$dangkycapngay = ($ngaycapdangky) ? date('d/m/Y', strtotime($ngaycapdangky)) : '';
$identify_issued_by = isset($contract->customer_infor->issued_by) ? $contract->customer_infor->issued_by : '';

?>
<body>
<!-- Page Content -->
<section>
	<div class="container">

		<div class="row ">
			<!-- Header -->
			<div class="col-3">
				<img src="https://tienngay.vn/assets/home/images/logo.png" alt="">
			</div>
			<div class="col-9 text-center mb-3">
				<h4 style="font-weight:bold;">
					BIÊN BẢN BÀN GIAO TÀI SẢN
				</h4>
				<p class="text-center">
					<strong>
						(Sau khi thanh lý Thỏa thuận ba bên)
					</strong>
				</p>
				<p class="text-center">
					<strong>
						<i>
							Số: <?= !empty($code_delivery_records) ? $code_delivery_records . "………… - TL" : 'BBBG/………………/………………/………' ?>
						</i>
					</strong>
				</p>
			</div>
			<div class="col-12">
				<p>

				</p>

			</div>
			<div class="col-12">
				<p>
					<i> - Căn cứ Thỏa thuận ba bên số:
						<strong><?= empty($code_contract) ? '…………............................……' : $code_contract ?></strong>
						ngày giải
						ngân <?= !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date) + 7 * 60 * 60) : '...............................' ?>
						;</i>
				</p>
				<p>
					<i> - Căn cứ Biên bản bàn giao tài sản số:………………….……….ký ngày……../…….../……………</i>
				</p>
			</div>
			<div class="col-12">
				<p>Hôm nay, ngày <?php
					if ($mydate['mday'] < 10) {
						echo "0" . $mydate['mday'];
					} else {
						echo $mydate['mday'];
					}

					?> tháng <?php if ($mydate['mon'] < 3) {
						echo "0" . $mydate['mon'];
					} else {
						echo $mydate['mon'];
					}
					?> năm <?= $mydate['year'] ?>, tại Phòng giao
					dịch: <?= ($contract->store->address) ? $contract->store->address : '………………………………………………………………' ?></p>
				<p>Chúng tôi gồm có:</p>
			</div>
			<div class="col-12 mb-3" style="padding-left:8px;">
				<table class="table table-sm table-borderless">
					<thead>
					<tr>
						<th scope="col" colspan="2">BÊN A <span class="float-right">: </span></th>
						<th scope="col" colspan="7">
							Ông/bà <?= !empty($customer_name) ? $customer_name : "…………………………………………………………………" ?></th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td colspan="2">Ngày sinh <span class="float-right">: </span></td>
						<td colspan="7"><?= ($customerDOB) ? ($customerDOB) : "……………………………" ?></td>
					</tr>
					<tr>
						<td colspan="2">CCCD/CMND số <span class="float-right">: </span></td>
						<td colspan="7"><?= ($customer_identify) ? $customer_identify : '……………………………' ?></td>
					</tr>
					<tr>
						<td colspan="2">Ngày cấp <span class="float-right">: </span></td>
						<td colspan="7"><?= ($identify_date_range) ? $identify_date_range : '…………………' ?></td>
					</tr>
					<tr>
						<td colspan="2">Cơ quan cấp <span class="float-right">: </span></td>
						<td colspan="7"><?= ($identify_issued_by) ? $identify_issued_by : '…………………' ?></td>
					</tr>
					<tr>
						<td colspan="2">Địa chỉ nơi ở hiện tại <span class="float-right">: </span></td>
						<td colspan="7"><?= ($address) ? $address : '……………………………' ?></td>
					</tr>
					<tr>
						<td colspan="2">Số điện thoại liên hệ <span class="float-right">: </span></td>
						<td colspan="7"><?= ($customerPhone) ? $customerPhone : '……………………………' ?></td>
					</tr>
					<tr>
						<td colspan="2">Quan hệ với chủ hợp đồng <span class="float-right">: </span></td>
						<td colspan="7">……………………………</td>
					</tr>
					</tbody>
				</table>

				<table class="table table-sm table-borderless">
					<thead>
					<tr>
						<th scope="col" colspan="2">BÊN B <span class="float-right">: </span></th>
						<th scope="col" colspan="7">CÔNG TY CỔ PHẦN CÔNG NGHỆ TIỆN NGAY</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td colspan="2">Địa chỉ trụ sở chính <span class="float-right">:</td>
						<td colspan="7"> Tầng 15, Khối B, Tòa nhà Sông Đà, đường Phạm Hùng, Phường Mỹ Đình 1, Quận Nam
							Từ Liêm, Thành phố Hà Nội
						</td>
					</tr>
					<tr>
						<td colspan="2">Mã số thuế <span class="float-right">: </span></td>
						<td colspan="7"> 0108908686</td>
					</tr>
					<tr>
						<td colspan="2">Đại diện <span class="float-right">: </span></td>
						<td colspan="7"> Ông/bà
							<strong><?= ($storeRepresentative) ? $storeRepresentative : '……………………………' ?></strong></td>
					</tr>
					<tr>
						<td colspan="2">Chức vụ <span class="float-right">: </span></td>
						<td colspan="7">Trưởng phòng giao dịch</td>
					</tr>
					<tr>
						<td colspan="2">Ủy quyền số <span class="float-right">: </span></td>
						<td colspan="3">……………………………</td>
						<td colspan="3">Ký ngày: ……………………………</td>

					</tr>

					</tbody>
				</table>
			</div>

			<div class="col-12 mb-3">
				<p>
					Bên B theo chỉ định của Bên cho Vay, giữ tài sản và giấy tờ nêu trên với mục đích làm căn cứ bảo đảm
					cho nghĩa vụ thanh toán của Bên A đối với Số Tiền Vay theo Thỏa thuận ba bên số
					<strong><?= empty($code_contract) ? '…………………………………………………………' : $code_contract ?></strong> ký
					ngày <?= !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date) + 7 * 60 * 60) : '...............................' ?>
					. Sau khi bàn bạc và thống nhất, các bên đồng ý cùng thanh lý Thỏa thuận ba bên Số:
					<strong><?= empty($code_contract) ? '…………………………………………………………' : $code_contract ?></strong> ký
					ngày <?= !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date) + 7 * 60 * 60) : '...............................' ?>
					, đồng thời tiến hành bàn giao lại tài sản theo nội dung sau:
				</p>
			</div>

			<div class="col-12">
				<table class="table table-bordered">
					<thead>
					<tr>
						<th scope="col" style="width:75px;">STT</th>
						<th scope="col">Tên Tài Sản</th>
						<th scope="col">Bên Bàn Giao</th>
						<th scope="col">Bên Nhận Bàn Giao</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<th scope="row">1</th>
						<td>

							<p>Ô tô/Xe máy BKS: <?= ($bienkiemsoat) ? $bienkiemsoat : '…………….' ?></p>
							<p>Đăng ký số <?= ($sodangky) ? $sodangky : '……………' ?>
								ngày <?= ($dangkycapngay) ? $dangkycapngay : '……………' ?></p>
							<p>Nhãn hiệu:<?= ($nhanhieu) ? $nhanhieu : '…………….' ?> </p>
							<p>Tình trạng tài sản: Đã qua sử dụng</p>


						</td>
						<td rowspan="2">

							<p>
								<?php
								if ($mydate['hours'] < 10) {
									echo "0" . $mydate['hours'];
								} else {
									echo $mydate['hours'];
								}
								?> giờ
								<?php if ($mydate['minutes'] < 10) {
									echo "0" . $mydate['minutes'];
								} else {
									echo $mydate['minutes'];
								} ?> phút
							</p>
							<p>Ngày <?php
								if ($mydate['mday'] < 10) {
									echo "0" . $mydate['mday'] . "/";
								} else {
									echo $mydate['mday'] . "/";
								}
								if ($mydate['mon'] < 3) {
									echo "0" . $mydate['mon'];
								} else {
									echo $mydate['mon'];
								}
								?>/<?= $mydate['year'] ?>
							</p>

						</td>
						<td rowspan="2">
							<p>
								<?php
								if ($mydate['hours'] < 10) {
									echo "0" . $mydate['hours'];
								} else {
									echo $mydate['hours'];
								}
								?> giờ
								<?php if ($mydate['minutes'] < 10) {
									echo "0" . $mydate['minutes'];
								} else {
									echo $mydate['minutes'];
								} ?> phút
							</p>
							<p>Ngày <?php
								if ($mydate['mday'] < 10) {
									echo "0" . $mydate['mday'] . "/";
								} else {
									echo $mydate['mday'] . "/";
								}
								if ($mydate['mon'] < 3) {
									echo "0" . $mydate['mon'];
								} else {
									echo $mydate['mon'];
								}
								?>/<?= $mydate['year'] ?>
							</p>

						</td>
					</tr>
					<tr>
						<th scope="row">2</th>
						<td>
							<p>Giấy tờ liên quan đến tài sản:</p>
							<p>
							<p>- Đăng ký xe (bản gốc)</p>
							<p>+ Số: <?= ($sodangky) ? $sodangky : '……………' ?> ngày
								cấp: <?= ($dangkycapngay) ? $dangkycapngay : '……………' ?></p>
							<p>+ Số khung: <?= ($sokhung) ? $sokhung : '…………….' ?></p>
							<p>+ Số máy: <?= ($somay) ? $somay : '…………….' ?></p>
							<p>+ Model: <?= ($model) ? $model : '…………….' ?></p>
						</td>
					</tr>
					</tbody>
				</table>
			</div>

			<div class="col-12 mb-3">
				Biên bản bàn giao tài sản này có hiệu lực kể từ ngày ký. Biên bản bàn giao tài sản này được lập thành 02
				(hai) bản có giá trị pháp lý như nhau, Bên A và Bên B giữ 01 (một) bản.
			</div>

			<div class="col-6">
				<p class=" text-center"><strong> BÊN A</strong></p>
			</div>

			<div class="col-6">
				<p class=" text-center"><strong> ĐẠI DIỆN BÊN B</strong></p>
			</div>


		</div>
	</div>
</section>

</body>


<style>
	table {
		table-layout: fixed
	}

	html, body {

		font-family: "Times New Roman", sans-serif;
		font-size: 14pt;
		/* line-height: 1.281; */
		color: #000;
	}

	p {
		margin: 0;
		text-align: justify;
	}


	ul {
		padding-left: 15px;
		text-align: justify;
	}

	ol {
		padding-left: 30px;
		text-align: justify;
	}

	ol {
		list-style: none;
		counter-reset: my-awesome-counter;
	}

	ol li {
		counter-increment: my-awesome-counter;
		position: relative;
	}

	ol li::before {
		content: counter(my-awesome-counter) ". ";
		position: absolute;
		left: -30px;
		display: block;
		width: 30px;
		text-align: left;
	}

	ol li,
	ul li {
		text-align: justify;
	}

	ul {
		list-style:
	}

	section {
		page-break-after: always;
	}

	.row-no-gutter {
		margin: 0;
	}

	.row-no-gutter > * {
		padding: 0;
	}

	.row-small-gutter {
		margin-left: -7.5px;
		margin-right: -7.5px;
	}

	.row-small-gutter > * {
		padding-left: 7.5px;
		padding-right: 7.5px;
	}

	.row-large-gutter {
		margin-left: -50px;
		margin-right: -50px;
	}

	.row-large-gutter > * {
		padding-left: 50px;
		padding-right: 50px;
	}

	.table-fixed {
		table-layout: fixed;
		width: 100%;
	}

	table p {
		text-align: initial;
	}

	table,
	.table {
		margin: 0
	}

	.table-sm td,
	.table-sm th {
		padding-top: 0;
		padding-bottom: 0;
	}


	.table-bordered td,
	.table-bordered th,
	.table-bordered p {
		border-color: #000 !important;
		vertical-align: middle;
		font-size: 14pt;
	}

	.dieukhoan {
		column-gap: 40px;
		display: list-item;
		list-style: none;
		column-count: 3;
		font-size: 10px;
		text-align: justify;
	}

	.dieukhoan > p {
		padding-left: 30px;
		position: relative;
	}

	.dieukhoan > p > span {
		display: block;
	}

	.dieukhoan > p > span:first-child {
		position: absolute;
		left: 0;
		top: 0;
	}

	/*.qcont {*/
	/*	display: inline-block*/
	/*}*/
	/*.qcont:first-letter {*/
	/*	text-transform: capitalize*/
	/*}*/


</style>

</html>
