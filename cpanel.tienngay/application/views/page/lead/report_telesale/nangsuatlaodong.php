<div class="right_col" role="main">

	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$telesale = !empty($_GET['telesale']) ? $_GET['telesale'] : "";
	?>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>BÁO CÁO NĂNG SUẤT LAO ĐỘNG TELESALE</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Danh sách nhân viên</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">
							<a class="btn btn-success" href="<?php echo base_url('report_telesale/nangsuatlaodong')?>">Reset dữ liệu</a>
							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form class="submit" action="<?php echo base_url('report_telesale/search_nangsuatlaodong') ?>"
								  method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Từ:</label>
													<input type="datetime-local" name="fdate" id="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : '' ?>" >
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Đến:</label>
													<input type="datetime-local" name="tdate" id="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : '' ?>" >
												</div>
											</div>
										</div>
									</li>
									<li class="form-group">
										<label>Nhân viên: </label>
										<select class="form-control" name="telesale">
											<option value="">-- Chọn nhân viên --</option>
											<?php foreach ($list_telesale as $key => $value): ?>
												<option value="<?= $value ?>" <?= (!empty($telesale) && $telesale == "$value") ? "selected" : "" ?>><?= $value ?></option>
											<?php endforeach; ?>
										</select>
									</li>


									<li class="text-right">
										<button  class="btn btn-info search" type="submit">
											<i class="fa fa-search" aria-hidden="true"></i>
											Tìm Kiếm
										</button>
									</li>

								</ul>
							</form>

						</div>

						<div class="col-xs-12 col-md-6">
							<h2>Tổng số nhân viên: <?= !empty($result) ? count($result) : 0 ?></h2>
						</div>

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">Nhân viên</th>
								<th style="text-align: center">Tổng lead phân bổ</th>
								<th style="text-align: center">Tổng lead xử lý</th>
								<th style="text-align: center">Tồn chăm sóc tiếp</th>
								<th style="text-align: center">Tỉ lệ xử lý</th>
								<th style="text-align: center">Lead QLF</th>
								<th style="text-align: center">Tỉ lệ QLF</th>
								<th style="text-align: center">HĐ giải ngân</th>
								<th style="text-align: center">Tỉ lệ Convert</th>
								<th style="text-align: center">TỔNG SỐ TIỀN GIẢI NGÂN</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($result)): ?>
								<?php
								$total_lead_phan_cong = 0;
								$total_lead_phan_cong_ton_cu = 0;
								$total_tong_lead_phan_cong = 0;
								$total_lead_qlf = 0;
								$total_count_hd_giaingan = 0;
								$total_lead_xu_ly = 0;
								$total_lead_xu_ly_ton_cu = 0;
								$total_tong_lead_xu_ly = 0;
								$total_money_giaingan = 0;
								?>
								<?php foreach ($result as $key => $value): ?>
									<?php if ($value->lead_phan_cong == 0) {
										continue;
									} ?>
									<tr>
										<td style="text-align: center"><?= !empty($value->nhanvien) ? $value->nhanvien : "" ?></td>
										<td style="text-align: center"><?= !empty($value->lead_phan_cong) ? number_format($value->lead_phan_cong) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->lead_xu_ly) ? number_format($value->lead_xu_ly) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->lead_xu_ly_ton_cu) ? number_format($value->lead_xu_ly_ton_cu) : 0 ?></td>
										<td style="text-align: center">
											<?= !empty($value->ti_le_xu_ly) ? $value->ti_le_xu_ly : 0 ?>
										</td>
										<td style="text-align: center"><?= !empty($value->lead_qlf) ? number_format($value->lead_qlf) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->ti_le_qlf) ? $value->ti_le_qlf : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->count_hd_giaingan) ? number_format($value->count_hd_giaingan) : 0 ?></td>
										<td style="text-align: center">
											<?= !empty($value->ti_le_convert) ? $value->ti_le_convert : 0 ?>
										</td>
										<td style="text-align: center"><?= !empty($value->total_tien_giaingan) ? number_format($value->total_tien_giaingan) : 0 ?></td>
									</tr>
									<?php
									$total_lead_phan_cong += $value->lead_phan_cong;
									$total_lead_qlf += $value->lead_qlf;
									$total_count_hd_giaingan += $value->count_hd_giaingan;
									$total_lead_xu_ly += $value->lead_xu_ly;
									$total_money_giaingan += $value->total_tien_giaingan;
									if (!empty($total_lead_xu_ly) && !empty($total_lead_phan_cong) && $total_lead_phan_cong != 0){
									$total_ti_le_xu_ly = ($total_lead_xu_ly/$total_lead_phan_cong)*100;
									}else{
									$total_ti_le_xu_ly = 0;
									}
									if (!empty($total_lead_qlf) && !empty($total_count_hd_giaingan) && $total_lead_qlf != 0){
									$total_ti_le_convert = ($total_count_hd_giaingan/$total_lead_qlf)*100;
									}else{
									$total_ti_le_convert  = 0;
									}
									if (!empty($total_lead_qlf) && !empty($total_lead_phan_cong) && $total_lead_phan_cong != 0){
									$total_ti_le_qlf = ($total_lead_qlf/$total_lead_phan_cong)*100;
									}else{
									$total_ti_le_qlf  = 0;
									}
									$total_lead_xu_ly_ton_cu += $value->lead_xu_ly_ton_cu;
									?>
									<?php endforeach; ?>
							<?php endif; ?>
							</tbody>
							<tr style="background-color: #ffbbbb; color: red">
								<th style="text-align: center" colspan="1">TOTAL</th>
								<th style="text-align: center"><?= !empty($total_lead_phan_cong) ? number_format($total_lead_phan_cong) : 0 ?></th>
								<th style="text-align: center"><?= !empty($total_lead_xu_ly) ? number_format($total_lead_xu_ly) : 0 ?></th>
								<th style="text-align: center"><?= !empty($total_lead_xu_ly_ton_cu) ? number_format($total_lead_xu_ly_ton_cu) : 0 ?></th>
								<th style="text-align: center"><?= !empty($total_ti_le_xu_ly) ? number_format($total_ti_le_xu_ly, 2) . "%" : 0 ?></th>
								<th style="text-align: center"><?= !empty($total_lead_qlf) ? number_format($total_lead_qlf) : 0 ?></th>
								<th style="text-align: center"><?= !empty($total_ti_le_qlf) ? number_format($total_ti_le_qlf, 2) . "%" : 0 ?></th>
								<th style="text-align: center"><?= !empty($total_count_hd_giaingan) ? number_format($total_count_hd_giaingan) : 0 ?></th>
								<th style="text-align: center"><?= !empty($total_ti_le_convert) ? number_format($total_ti_le_convert , 2) . "%" : 0 ?></th>
								<th style="text-align: center"><?= !empty($total_money_giaingan) ? number_format($total_money_giaingan) : 0 ?></th>
							</tr>

						</table>
						<div class="">
							<?php echo $pagination ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Modal-->
<script>

$(document).ready(function () {
            $(".search").click(function (event) {
                event.preventDefault();
                let fdate = $("#fdate").val()
                let tdate = $("#tdate").val()
                if ($("#fdate").val() == "" || $("#tdate").val() == "") {
					alert("Hãy nhập đầy đủ ngày/tháng/năm!");
				}else if(fdate.toString()> tdate.toString()){
				alert("Ngày kết thúc không được nhỏ hơn ngày bắt đầu")
				} else{
                $('.submit').submit()
                }
            });
 });
</script>

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>








