
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Biên Lai</title>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Jura:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" >
	<script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>

</head>
<?php
$content_billing = '';
if (!empty($transaction->note)) {
	if (is_array($transaction->note)) {
		foreach ($transaction->note as $key => $note) {
			$content_billing .= billing_content($note).";";
		}
	} else {
		$content_billing = $transaction->note;
	}
}
?>
<body>


<main>

	<section>

		<div class="container">
			<div class="row">
				<div class="col-12">
					<img src="https://tienngay.vn/assets/frontend/images/logo.svg" alt="">
				</div>
				<div class="col-12 text-center">
					<h3 >
						<strong> BIÊN NHẬN THU TIỀN</strong>
					</h3>
					<p>Số: <?= !empty($transaction->code_billing) ? $transaction->code_billing : "" ?> <br>
						Liên 1: Nhân viên Tienngay.vn lưu <br>
						<i> <?= !empty($transaction->created_at) ? date("H:i", $transaction->created_at) : "";?> Ngày <?= !empty($transaction->created_at) ? date("d", $transaction->created_at) : "";?> Tháng <?= !empty($transaction->created_at) ? date("m", $transaction->created_at) : "";?> Năm <?= !empty($transaction->created_at) ? date("Y", $transaction->created_at) : "";?> </i>
					</p>
				</div>
			</div>
			<div class="row theinfos">
				<div class="col-6">
					Nhân viên thu tiền: <span class="thedata"> <?= !empty($transaction->user_full_name) ? $transaction->user_full_name : $transaction->created_by;?></span>
				</div>
				<div class="col-6">
					Mã số nhân viên: <span class="thedata"> <?= !empty($transaction->created_by) ? $transaction->created_by : "";?></span>
				</div>
				<div class="col-12">
					Tên chủ hợp đồng: <span class="thedata"> <?= !empty($transaction->customer_name) ? $transaction->customer_name : "";?></span>
				</div>
				<div class="col-12">
					Hợp đồng số:<span class="thedata"> <?= !empty($transaction->code_contract_disbursement) ? $transaction->code_contract_disbursement : "";?></span>
				</div>

				<div class="col-6">
					Tên người nộp tiền:<span class="thedata"> <?= !empty($transaction->customer_bill_name) ? $transaction->customer_bill_name : "";?></span>
				</div>
				<div class="col-6">
					Quan hệ với chủ hợp đồng:<span class="thedata"> <?= !empty($transaction->relative_with_contract_owner) ? $transaction->relative_with_contract_owner : "";?></span>
				</div>

				<div class="col-12">
					Điện thoại người nộp tiền:<span class="thedata"> <?= !empty($transaction->customer_bill_phone) ? $transaction->customer_bill_phone : "";?></span>
				</div>
				<div class="col-12">
					Số tiền bằng số:<span class="thedata"> <?= !empty($transaction->total) ? number_format($transaction->total ,0 ,',' ,',') . " đ" : number_format($transaction->total ,0 ,',' ,',') . " đ"?></span>
				</div>
				<div class="col-12">
					Số tiền bằng chữ:<span class="thedata qcont"> <?= !empty($transaction->total) ? convert_number_to_words($transaction->total) : "";?></span>
				</div>
				<div class="col-12 mb-3">
					Nội dung thu:<span class="thedata"><?php echo rtrim($content_billing,";").".";?></span>
				</div>
			</div>
			<br>
			<div class="row">


				<div class="col-4 text-center">

					<p>
						<strong> Trưởng phòng giao dịch </strong>  <br>
						<small> <i>(Ký ghi rõ họ tên) </i> </small>
					</p>
				</div>

				<div class="col-4 text-center">
					<p>  <strong>Nhân viên thu tiền	</strong>  <br>
						<small> <i>(Ký ghi rõ họ tên) </i> </small>    </p>
				</div>

				<div class="col-4 text-center">
					<p>  <strong> Người nộp tiền</strong>  <br>
						<small> <i>(Ký ghi rõ họ tên) </i> </small> </p>
				</div>


			</div>
		</div>

	</section>

	<section>

		<div class="container">
			<div class="row">
				<div class="col-12">
					<img src="https://tienngay.vn/assets/frontend/images/logo.svg" alt="">
				</div>
				<div class="col-12 text-center">
					<h3 >
						<strong> BIÊN NHẬN THU TIỀN</strong>
					</h3>
					<p>Số: <?= !empty($transaction->code_billing) ? $transaction->code_billing : "" ?> <br>
						Liên 2: Khách hàng lưu <br>
						<i> <?= !empty($transaction->created_at) ? date("H:i", $transaction->created_at) : "";?> Ngày <?= !empty($transaction->created_at) ? date("d", $transaction->created_at) : "";?> Tháng <?= !empty($transaction->created_at) ? date("m", $transaction->created_at) : "";?> Năm <?= !empty($transaction->created_at) ? date("Y", $transaction->created_at) : "";?> </i>
					</p>
				</div>
			</div>
			<div class="row theinfos">
				<div class="col-6">
					Nhân viên thu tiền: <span class="thedata"> <?= !empty($transaction->user_full_name) ? $transaction->user_full_name : $transaction->created_by;?></span>
				</div>
				<div class="col-6">
					Mã số nhân viên: <span class="thedata"> <?= !empty($transaction->created_by) ? $transaction->created_by : "";?></span>
				</div>
				<div class="col-12">
					Tên chủ hợp đồng: <span class="thedata"> <?= !empty($transaction->customer_name) ? $transaction->customer_name : "";?></span>
				</div>
				<div class="col-12">
					Hợp đồng số:<span class="thedata"> <?= !empty($transaction->code_contract_disbursement) ? $transaction->code_contract_disbursement : "";?></span>
				</div>

				<div class="col-6">
					Tên người nộp tiền:<span class="thedata"> <?= !empty($transaction->customer_bill_name) ? $transaction->customer_bill_name : "";?></span>
				</div>
				<div class="col-6">
					Quan hệ với chủ hợp đồng:<span class="thedata"> <?= !empty($transaction->relative_with_contract_owner) ? $transaction->relative_with_contract_owner : "";?></span>
				</div>

				<div class="col-12">
					Điện thoại người nộp tiền:<span class="thedata"> <?= !empty($transaction->customer_bill_phone) ? $transaction->customer_bill_phone : "";?></span>
				</div>
				<div class="col-12">
					Số tiền bằng số:<span class="thedata"> <?= !empty($transaction->total) ? number_format($transaction->total ,0 ,',' ,',') . " đ" : number_format($transaction->total ,0 ,',' ,',') . " đ"?></span>
				</div>
				<div class="col-12">
					Số tiền bằng chữ:<span class="thedata qcont"> <?= !empty($transaction->total) ? convert_number_to_words($transaction->total) : "";?></span>
				</div>
				<div class="col-12 mb-3">
					Nội dung thu:<span class="thedata"><?php echo rtrim($content_billing,";").".";?></span>
				</div>
			</div>
			<br>
			<div class="row">


				<div class="col-4 text-center">

					<p>
						<strong> Trưởng phòng giao dịch </strong>  <br>
						<small> <i>(Ký ghi rõ họ tên) </i> </small>
					</p>
				</div>

				<div class="col-4 text-center">
					<p>  <strong>Nhân viên thu tiền	</strong>  <br>
						<small> <i>(Ký ghi rõ họ tên) </i> </small>    </p>
				</div>

				<div class="col-4 text-center">
					<p>  <strong> Người nộp tiền</strong>  <br>
						<small> <i>(Ký ghi rõ họ tên) </i> </small> </p>
				</div>


			</div>
		</div>

	</section>
</main>

<style >
	html,
	body {
		font-family: 'Noto Serif', serif;
		font-size: 16px;
		line-height: 1.2;
	}


	main {
		height: 1500px;
	}
	section {
		height: 50%;
		padding-top: 10mm
	}

	.theinfos {
		font-weight: bold;
	}
	.theinfos .col-12,
	.theinfos .col-6 {

		margin-bottom: 15px;
	}


	.thedata {
		font-family: 'Jura', sans-serif;
		/*font-size: 18px;*/
		font-weight: 500;
		display: inline-block;
		margin-left: 5px;
	}
	.qcont:first-letter{
		text-transform: capitalize
	}
</style>
</body>
<script>
	window.onbeforeprint = function () {
		var formData = {
			code_transaction: '<?= $transaction->_id->{'$oid'} ?>',
		};
		$.ajax({
			url: "/ajax/saveTransactionPrint",
			type: "POST",
			data: formData,
			success: function (data) {
				console.log(data);
			},
			error: function (data) {
				console.log(data);
			}
		});
	}
</script>

</html>
