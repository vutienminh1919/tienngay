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
						<h3>Báo cáo nhóm vay
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Quản lý HĐ vay</a> / <a href="#">Báo cáo nhóm vay</a>
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
											<div class="form-group">
												<label for="">Từ</label>
												<input type="date" name="fdate" class="form-control"
													   value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : "" ?>">
											</div>
										</div>
										<div class="col-xs-12 col-lg-2">
											<div class="form-group">
												<label for="">Đến</label>
												<input type="date" name="tdate" class="form-control"
													   value="<?= isset($_GET['tdate']) ? $_GET['tdate'] : "" ?>">
											</div>
										</div>
										<div class="col-xs-12 col-lg-2">
											<label for="">Phòng giao dịch</label>
											<select class="form-control" name="code_store" id="selectize_store">
												<option value="">Chọn phòng giao dịch</option>
												<?php if (!empty($storeData)) {
													foreach ($storeData as $p) { ?>
														<option <?php echo $store == $p->_id->{'$oid'} ? 'selected' : '' ?>
																value="<?php echo $p->_id->{'$oid'}; ?>"><?php echo $p->name; ?></option>
													<?php }
												} ?>
											</select>
										</div>
										<div class="col-xs-12 col-lg-2 text-right">
											<label for="">&nbsp;</label>
											<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																								   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
											</button>
										</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive" style="width: 100%;">
								<table id="datatable-buttons" class="table table-striped datatable-buttons">
									<thead>
									<tr>
										<th> PHÒNG GIAO DỊCH</th>
										<th> TỔNG GỐC GIẢI NGÂN</th>
										<th> TỔNG GỐC ĐANG CHO VAY</th>
										<th> TỔNG GỐC CÒN LẠI NHÓM 1<br> -  ĐỦ TIÊU CHUẨN ( DPD < 10 NGÀY)</th>
										<th> TỔNG GỐC CÒN LẠI NHÓM 2 -<br>  CẦN CHÚ Ý ( 10 =< DPD <=90 NGÀY)</th>
										<th> TỔNG GỐC CÒN LẠI NHÓM 3 - <br> DƯỚI TIÊU CHUẨN ( 90 < DPD <= 180 NGÀY)</th>
										<th> TỔNG GỐC CÒN LẠI NHÓM 4 - <br> NGHI NGỜ ( 180 < DPD <=360 NGÀY)</th>
										<th> TỔNG GỐC CÒN LẠI NHÓM 5 -<br>  CÓ KHẢ NĂNG MẤT VỐN ( DPD > 360 NGÀY)</th>
										<th>TỔNG GỐC CÒN LẠI HĐ QUÁ HẠN (NHÓM 3,4,5)</th>
										<th> TỶ LỆ NHÓM 1 <br> THEO GỐC CÒN LẠI GIẢI NGÂN</th>
										<th> TỶ LỆ NHÓM 1 <br>THEO GỐC CÒN LẠI ĐANG CHO VAY</th>
										<th> TỶ LỆ NHÓM 2 <br>THEO GỐC CÒN LẠI GIẢI NGÂN</th>
										<th> TỶ LỆ NHÓM 2 <br>THEO GỐC CÒN LẠI ĐANG CHO VAY</th>
										<th> TỶ LỆ NHÓM 3 <br>THEO GỐC CÒN LẠI GIẢI NGÂN</th>
										<th> TỶ LỆ NHÓM 3 <br>THEO GỐC CÒN LẠI ĐANG CHO VAY</th>
										<th> TỶ LỆ NHÓM 4 <br>THEO GỐC CÒN LẠI GIẢI NGÂN</th>
										<th> TỶ LỆ NHÓM 4 <br>THEO GỐC CÒN LẠI ĐANG CHO VAY</th>
										<th> TỶ LỆ NHÓM 5 <br>THEO GỐC CÒN LẠI GIẢI NGÂN</th>
										<th> TỶ LỆ NHÓM 5 <br>THEO GỐC CÒN LẠI ĐANG CHO VAY</th>
										<th> TỶ LỆ XẤU<br>THEO GỐC CÒN LẠI GIẢI NGÂN</th>
										<th> TỶ LỆ XẤU<br>THEO GỐC CÒN LẠI ĐANG CHO VAY</th>
									</tr>
									</thead>
									<tbody name="list_lead">
									<?php

									if (!empty($reportData)) {
										echo $reportData;
										?>

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
</div>

<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>

<script type="text/javascript">
	detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');


</script>
