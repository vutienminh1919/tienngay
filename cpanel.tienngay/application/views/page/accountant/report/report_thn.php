<!-- page content -->
<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
?>
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
						<h3>Báo cáo dữ liệu T+10</h3>
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
								<form action="<?php echo base_url('excel/indexExportExcelT10') ?>" method="get"
									  style="width: 100%;">
									<div class="col-xs-12 col-lg-3">
										<div class="form-group">
											<label for="">Chọn tháng</label>
											<input type="month" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : date('Y-m') ?>">
										</div>
									</div>

									<div class="col-xs-12 col-lg-2 text-right">
										<label for="">&nbsp;</label>
										<button type="submit" class="btn btn-primary w-100">
											<i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search') ?>
										</button>
									</div>

									<div class="col-xs-12 col-lg-2 text-right">
										<label for="">&nbsp;</label>
										<a style="background-color: #18d102;" href="<?php echo base_url('/excel/exportExcelT10') ?>?fdate=<?= isset($_GET['fdate']) ? $_GET['fdate'] : "" ?>" class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Xuất excel</a>
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


<style>
	.page-title {
		min-height: 0px;
	}
</style>
<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>

