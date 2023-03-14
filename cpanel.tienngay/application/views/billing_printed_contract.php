<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=768px, initial-scale=1, shrink-to-fit=no">
	<title></title>
	<link href="https://fonts.googleapis.com/css?family=Noto+Serif:400,700&display=swap&subset=vietnamese" rel="stylesheet">
	<link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/starter-template/">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<style media="print">
		@media print {
			* {
				font-family: 'Noto Serif', serif;
				color: #000 !important;
				font-size: 21px;
			}
			strong {
				font-size: 32px;
			}
			td, th {
				font-size: 32px;
				padding: 0;
			}
			.table:not(.table-sm) td,
			.table:not(.table-sm) th {
				padding: 0.5rem
			}
		}
	</style>
</head>
<body>


<main role="main" class="container pt-3">
	<div class="row mb-3">
		<div class="col-12  text-center">
			<p>
				<img src="https://tienngay.vn/assets/frontend/images/logo.svg" alt="" style="width:200px">
			</p>
		</div>
		<div class="col-12  text-center">
			<p class="h2 mb-3">Công ty Cổ phần Công nghệ Tài chính Việt</p>
			<p class="h3 mb-1">www.TienNgay.vn Hotline: <?php echo $hotline?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<h2 class="text-center" style="font-weight:700">BIÊN NHẬN THANH TOÁN</h2>
		</div>
		<div class="col-12  p-2">
			<table class="table table-borderless table-sm" style="table-layout:fixed">

				<tbody>
				<tr>
					<td>Phòng giao dịch : <?= !empty($transaction->store->name) ? $transaction->store->name : '' ?></td>
					<td>Khách hàng: <?php echo $transaction->customer_bill_name ?></td>
				</tr>
				<tr>
					<td>Nhân viên: <?= !empty($transaction->user_full_name) ? $transaction->user_full_name : $transaction->created_by ?></td>
					<td>SĐT: <?php echo $transaction->customer_bill_phone ?></td>
				</tr>
				<tr>
					<td>Thời gian: <?= !empty($transaction->created_at) ? date('d/m/Y H:i:s', intval($transaction->created_at) ) : "" ?></td>
					<td>
						<?php
						$method = '';
						if (intval($transaction->payment_method) == 0) {
							$method = $transaction->payment_method;
						} else {
							if (intval($transaction->payment_method) == 1) {
								$method = 'Tiền mặt';
							}
						}
						echo 'Phương thức: '.$method;
						?>
					</td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="col-12 ">
			<p>
				<strong>Mã phiếu thu: <?php echo $transaction->code?></strong>
			</p>
			<table class="table ">
				<thead class="thead-light">
				<tr>
					<th scope="col" class="text-center">STT</th>
					<th scope="col">Dịch vụ</th>
					<th scope="col" class="text-center">Mã hợp đồng</th>
					<th scope="col" class="text-right">Số tiền</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($transaction)){?>
					<tr>
						<td class="text-center">1</td>
						<td>
							Thanh toán hợp đồng<br>
							<small>TienNgay.vn</small><br>
						</td>
						<td class="text-center">
							<!-- <?= !empty($transaction->code_contract) ? $transaction->code_contract : "" ?>  -->
							<?= !empty($transaction->code_contract_disbursement) ? $transaction->code_contract_disbursement : "" ?> 
					
						</td>
						<td class="text-right">
							<?= !empty($transaction->total) ? number_format($transaction->total ,0 ,',' ,',') : number_format($transaction->total ,0 ,',' ,',')?>
						</td>
					</tr>
					<?php }
				 ?>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="2" class="text-right">
						<h4 style="font-weight:700">
							Tổng tiền :
						</h4>
					</td>
					<td colspan="3" class="text-right">
						<h4 style="font-weight:700">
							<?php echo number_format($transaction->total ,0 ,',' ,',')?> đ
						</h4>
					</td>
				</tr>
				</tfoot>
			</table>
		</div>

		<div class="col-6">

		</div>
		<div class="col-6 text-center">

			<h4 style="font-weight:700">ĐÃ THANH TOÁN</h4>
			<strong class="h5"><?= !empty($transaction->user_full_name) ? $transaction->user_full_name : $transaction->created_by ?></strong>
		</div>
	</div>



</main><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



</body>
</html>
