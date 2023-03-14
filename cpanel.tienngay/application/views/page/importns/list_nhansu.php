<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3> Danh sách nhân sự
						<br>
						<small>
							<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh sách nhân sự</a>
						</small>
					</h3>
				</div>

			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">

							<div class="table-responsive">
								<table id="datatable-buttons" class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										<th>Mã nhân viên</th>
										<th>Họ và tên</th>
										<th>Số điện thoại</th>
										<th>Email</th>
										<th>Chức vụ</th>
										<th>Bộ phận</th>
									</tr>
									</thead>
									<tbody>
									<?php
									if(!empty($personnelData)) {
										$stt = 0;
										foreach($personnelData as $key => $personnel){
											if($personnel->status != 'block'){
												$stt++;

												?>
												<tr>
													<td><?php echo $stt ?></td>
													<td><?= !empty($personnel->customer_code) ?  $personnel->customer_code : ""?></td>
													<td><?= !empty($personnel->customer_name) ?  $personnel->customer_name : ""?></td>
													<td><?= !empty($personnel->customer_phone) ?  $personnel->customer_phone : ""?></td>
													<td><?= !empty($personnel->title) ?  $personnel->title : ""?></td>
													<td><?= !empty($personnel->position) ?  $personnel->position : ""?></td>
													<td><?= !empty($personnel->part) ?  $personnel->part : ""?></td>

												</tr>
											<?php } }}?>

									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/investors/index.js"></script>
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>

<style type="text/css">
	.w-25 {
		width: 8%!important;
	}
</style>

