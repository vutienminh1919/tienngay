<!-- page content -->
<?php $code = !empty($_GET['code']) ? $_GET['code'] : '' ?>
<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">

			<div class="page-title">
				<div class="title_left">
					<h3>Chi tiết giao dịch đóng tiền</h3>
				</div>
				<div class="title_right text-right">
					<a class="btn btn-info" href="<?php echo base_url() ?>vbi_tnds/index?tab=transaction">
						<i class="fa fa-chevron-left" aria-hidden="true"></i>
						Trở lại
					</a>

				</div>
			</div>
		</div>


		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">

						<div class="col-xs-12 text-right">

							<h2>Giao dịch: <?php echo $code ?></h2>
						</div>
					</div>


					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">


						<div class="table-responsive">
							<table class="table table-bordered m-table table-hover table-calendar table-report ">
								<thead style="background:#3f86c3; color: #ffffff;">
								<tr>
									<th>Tên khách hàng</th>
									<th>Số điện thoại</th>
									<th>Số tiền đóng</th>
									<th>Ngày mua BH</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($vbis as $vbi) { ?>
									<tr>
										<th><?php echo $vbi->customer_info->customer_name ?></th>
										<th><?php echo $vbi->customer_info->customer_phone ?></th>
										<th><?php echo number_format($vbi->fee) . " VND" ?></th>
										<th><?php echo date('d/m/Y H:i:s', $vbi->created_at) ?></th>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->


<script src="<?php echo base_url() ?>assets/js/vbi_tnds/index.js"></script>
