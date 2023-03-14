<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
?>
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
						<h3>Báo cáo tỉ lệ hợp đồng quá hạn
							<br>
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
								<form action="<?php echo base_url('dashboard_thn/index_report_debt') ?>" method="get"
									  style="width: 100%;">
									<div class="col-xs-12 col-lg-3">
										<div class="form-group">
											<label for="">Từ</label>
											<input type="date" name="fdate" class="form-control"
												   value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : "" ?>">
										</div>
									</div>
									<div class="col-xs-12 col-lg-3">
										<div class="form-group">
											<label for="">Đến</label>
											<input type="date" name="tdate" class="form-control"
												   value="<?= isset($_GET['tdate']) ? $_GET['tdate'] : "" ?>">
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
										<button type="button" class="btn btn-primary w-100" onclick="$('#exportdulieu').toggleClass('show');">
											<span class="fa fa-file-excel-o"> Xuất excel</span>
										</button>
									</div>

									<div class="col-xs-12 col-lg-2 text-right">
										<label for="">&nbsp;</label>
										<a target="_blank" type="button" class="btn btn-primary w-100" href="<?= base_url() ?>excel/report_debt_detail?fdate=<?= $fdate . '&tdate=' . $tdate  ?>" >
											<span class="fa fa-file-excel-o"> Xuất excel chi tiết</span>
										</a>
									</div>

									<ul id="exportdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:10px;min-width:250px;">

										<li class="form-group">
											<a
												href="<?= base_url() ?>excel/report_debt_ninety?fdate=<?= $fdate . '&tdate=' . $tdate  ?>"
												target="_blank"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
												Export Báo Cáo Hợp Đồng Quá Hạn > 90 Ngày
											</a>
											<a
												href="<?= base_url() ?>excel/report_debt_product?fdate=<?= $fdate . '&tdate=' . $tdate  ?>"
												target="_blank"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
												Export Báo Cáo Hợp Đồng Quá Hạn Theo Sản Phẩm
											</a>
											<a
												href="<?= base_url() ?>excel/report_debt_area?fdate=<?= $fdate . '&tdate=' . $tdate  ?>"
												target="_blank"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
												Export Báo Cáo Hợp Đồng Quá Hạn 3 Kỳ Đầu
											</a>
											<a
												href="<?= base_url() ?>excel/report_debt_month"
												target="_blank"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
												Export Báo Cáo Thống Kê Hợp Đồng Quá Hạn Theo Năm
											</a>
											<a
												href="<?= base_url() ?>excel/report_debt_district?fdate=<?= $fdate . '&tdate=' . $tdate  ?>"
												target="_blank"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
												Export Báo Cáo Thống Kê Theo Tỉnh
											</a>
											<a
												href="<?= base_url() ?>excel/report_debt_pgd?fdate=<?= $fdate . '&tdate=' . $tdate  ?>"
												target="_blank"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
												Export Báo Cáo Thống Kê Theo PGD
											</a>
										</li>
									</ul>
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

<script type="text/javascript">
	detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');


</script>
<style>
	.x_title span{
		color: #ffffff;
	}
</style>
