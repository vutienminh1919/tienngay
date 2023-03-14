<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Báo cáo tổng hợp
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Quản lý HĐ vay</a> / <a href="#">Báo cáo tổng hợp</a>
							</small>
						</h3>
						<div class="alert alert-danger alert-result" id="div_error"
							 style="display:none; color:white;"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-lg-12">
							<div class="row">
								<form action="<?php echo base_url('accountant/report_debt_group_pgd') ?>" method="get"
									  style="width: 100%;">
									<div class="col-xs-12 col-lg-2">
										<label for="">Chọn tháng/năm xuất excel báo cáo</label>
										<input placeholder="" type="text"
											   class="form-control" datetimepicker name="monthYearExcel"
											   id="monthYearExcel" value="<?= date('Y-m') ?>">
									</div>
									<div class="col-xs-12 col-lg-3">

									</div>

									<div class="col-xs-12 col-lg-2 text-right">
										<label>&nbsp;</label>
										<a style="background-color: #18d102;"
										   href=""
										   class="btn btn-primary w-100" id="excelGeneralReport"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Xuất excel
											tổng hợp</a>
									</div>

									<div class="col-xs-12 col-lg-2 text-right">
										<label>&nbsp;</label>
										<a style="background-color: #18d102;"
														   href=""
														   class="btn btn-primary w-100 " id="excelDetailReport"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Xuất excel
											chi tiết</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>

<script type="text/javascript">
	detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');

	$(document).ready(function () {
		$('[name="monthYearExcel"]').datetimepicker({
			format: 'YYYY-MM'
		});
	});

	$('#excelDetailReport').click(function (event){
		event.preventDefault();
		let a = $('[name="monthYearExcel"]').val();
		let time = a.split('-');
		console.log(time)
		let month = time[1];
		let year = time[0];
		window.open(_url.base_url + "excel/exportDetailCallAndFieldResultTHN?month=" + month + '&year=' + year);

	});

	$('#excelGeneralReport').click(function (event){
		event.preventDefault();
		let a = $('[name="monthYearExcel"]').val();
		let time = a.split('-');
		console.log(time)
		let month = time[1];
		let year = time[0];
		window.open(_url.base_url + "excel/exportReportGeneralTHN?month=" + month + '&year=' + year);

	});

</script>
