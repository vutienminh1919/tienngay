<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$search_status = !empty($_GET['search_status']) ? $_GET['search_status'] : "";
$code_area = !empty($_GET['code_area']) ? $_GET['code_area'] : "";

$contract_total = (!empty($data->contract_total)) ? $data->contract_total : 0;
$contract_moi = (!empty($data->contract_moi)) ? $data->contract_moi : 0;
$contract_dang_xl = (!empty($data->contract_dang_xl)) ? $data->contract_dang_xl : 0;
$contract_cho_pd = (!empty($data->contract_cho_pd)) ? $data->contract_cho_pd : 0;
$contract_da_duyet = (!empty($data->contract_da_duyet)) ? $data->contract_da_duyet : 0;
$contract_cho_gn = (!empty($data->contract_cho_gn)) ? $data->contract_cho_gn : 0;
$contract_da_gn = (!empty($data->contract_da_gn)) ? $data->contract_da_gn : 0;
$contract_khac = (!empty($data->contract_khac)) ? $data->contract_khac : 0;

?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="row">
					<div class="col-xs-10 col-lg-8">
						<div class="title">
							<h3 class="tilte_top_tabs" style="margin-bottom: 0">
								Dashboard
							</h3>
							<?php
							$name_area = "";
							if (!empty($code_area)) {
								if ($code_area == "KV_HN1" || $code_area == "KV_HN2") {
									$name_area = "Hà Nội";
								} elseif ($code_area == "KV_QN") {
									$name_area = "Đông Bắc";
								} elseif ($code_area == "KV_MK") {
									$name_area = "Mekong";
								} elseif ($code_area == "KV_HCM1") {
									$name_area = "Hồ Chí Minh";
								} elseif ($code_area == "KV_HCM2") {
									$name_area = "Hồ Chí Minh 2";
								} elseif ($code_area == "KV_BTB") {
									$name_area = "Bắc Trung Bộ";
								}
							}
							?>
							<span>Quản lý khu vực - <?= $name_area ?></span>
						</div>
					</div>
					<div class="col-xs-2 col-lg-4 mb-3 text-right">

						<button class="show-hide-total-all btn btn-success dropdown-toggle"
								onclick="$('#lockdulieu').toggleClass('show');">
							<span class="fa fa-search"></span>
						</button>
						<form action="<?php echo base_url('kpi/detail_code_area_dashboard') ?>" method="get">
							<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
								style="padding:15px;min-width:250px;">

								<li class="form-group">
									<div class="row">
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Từ:</label>
												<input type="date" class="form-control" name="fdate"
													   value="<?= !empty($fdate) ? $fdate : date('Y-m-01') ?>">
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Đến:</label>
												<input type="date" class="form-control" name="tdate"
													   value="<?= !empty($tdate) ? $tdate : date('Y-m-d') ?>">
											</div>
											<input type="hidden" class="form-control" name="code_area"
												   value="<?= !empty($code_area) ? $code_area : '' ?>">
										</div>
									</div>
								</li>

								<li class="text-right">
									<button class="btn btn-info btn-success" type="submit">
										<i class="fa fa-search" aria-hidden="true"></i>
										Tìm Kiếm
									</button>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
			<div class="dashboard-right-sys">

				<?php
				$tong_du_no_tang_net = !empty($data->total_du_no_trong_han_t10) ? $data->total_du_no_trong_han_t10 : 0;
				$tong_bao_hiem = 0;

				foreach ($report_kpi as $key => $kpi) {
					$tong_bao_hiem += $kpi->sum_bao_hiem;
				}

				foreach ($data_kpi as $key => $value) {
					$tong_chi_tieu_du_no_tang_net += $value->du_no_CT;
					$tong_TT_du_no_tang_net = $value->du_no_TT;

					$tong_chi_tieu_bao_hiem += $value->bao_hiem_CT;
					$tong_TT_bao_hiem = $value->bao_hiem_TT;

					$tong_chi_tieu_giai_ngan += $value->giai_ngan_CT;
					$tong_TT_giai_ngan = $value->giai_ngan_TT;

					$tong_chi_tieu_nha_dau_tu += $value->nha_dau_tu;
					$tong_TT_nha_dau_tu = $value->nha_dau_tu_TT;
				}

				if ($tong_chi_tieu_du_no_tang_net != 0) {
					$du_no = round(($tong_du_no_tang_net / $tong_chi_tieu_du_no_tang_net) * $tong_TT_du_no_tang_net);
				}
				if ($tong_chi_tieu_bao_hiem != 0) {
					$bao_hiem = round(($tong_bao_hiem / $tong_chi_tieu_bao_hiem) * $tong_TT_bao_hiem);
				}
				if ($tong_chi_tieu_giai_ngan != 0) {
					$giai_ngan = round(($data->total_so_tien_vay / $tong_chi_tieu_giai_ngan) * $tong_TT_giai_ngan);
				}
				if ($tong_chi_tieu_nha_dau_tu != 0) {
					$nha_dau_tu = round(($data->total_nha_dau_tu / $tong_chi_tieu_nha_dau_tu) * $tong_TT_nha_dau_tu);
				}

				if ($du_no > 40) {
					$du_no = 40;
				} elseif ($du_no < 0){
					$du_no = 0;
				}
				if ($bao_hiem > 40) {
					$bao_hiem = 40;
				}
				if ($giai_ngan > 40) {
					$giai_ngan = 40;
				}
				if ($nha_dau_tu > 20) {
					$nha_dau_tu = 20;
				}


				$tong_kpi = $du_no + $bao_hiem + $giai_ngan + $nha_dau_tu;
				?>


				<div class="row">
					<div class="col-xs-12 col-md-3">
						<div class="left_wiget-bar">

							<div class="const_box_show" data-toggle="modal">
								<div class="left_box">
									<h5>
										Tổng tiền hoa hồng
									</h5>
									<p>
										<?php
										$total_tien_hoa_hong = 0;
										if (!empty($tong_kpi)) {
											if ($tong_kpi >= 80 && $tong_kpi < 90) {
												$total_tien_hoa_hong = 5000000;
											} elseif ($tong_kpi >= 90 && $tong_kpi < 95) {
												$total_tien_hoa_hong = 7000000;
											} elseif ($tong_kpi >= 95 && $tong_kpi < 110) {
												$total_tien_hoa_hong = 10000000;
											} elseif ($tong_kpi >= 110) {
												$total_tien_hoa_hong = 12000000;
											}
										}
										$total_tien_hoa_hong = $total_tien_hoa_hong + $data->tien_hoa_hong_nha_dau_tu;

										?>
										<?= (!empty($total_tien_hoa_hong)) ? number_format($total_tien_hoa_hong) : 0 ?>
									</p>
								</div>
							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tiền giải ngân mới kỳ này
									</h5>
									<p>
										<?= (!empty($data->total_so_tien_vay->{'$numberLong'})) ? number_format($data->total_so_tien_vay->{'$numberLong'}) : number_format($data->total_so_tien_vay) ?>
									</p>
								</div>
							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại tăng net trong kỳ
									</h5>
									<p>
										<?= (!empty($data->total_du_no_trong_han_t10)) ? number_format($data->total_du_no_trong_han_t10) : 0 ?>
									</p>
								</div>
							</div>

							<div class="const_box_show" data-toggle="modal" data-target="#baohiem">
								<div class="left_box">
									<h5>
										Doanh số bảo hiểm kỳ này
									</h5>
									<p>
										<?= (!empty($data->total_doanh_so_bao_hiem)) ? number_format($data->total_doanh_so_bao_hiem) : 0 ?>
									</p>
								</div>
							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng tiền giải ngân
									</h5>
									<p>
										<?= (!empty($data->total_so_tien_vay_old->{'$numberLong'})) ? number_format($data->total_so_tien_vay_old->{'$numberLong'}) : number_format($data->total_so_tien_vay_old) ?>
									</p>
								</div>
							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại quản lý
									</h5>
									<p>
										<?= (!empty($data->total_du_no_dang_cho_vay_old->{'$numberLong'})) ? number_format($data->total_du_no_dang_cho_vay_old->{'$numberLong'}) : number_format($data->total_du_no_dang_cho_vay_old) ?>
									</p>
								</div>

							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại trong hạn T+10 hiện tại
									</h5>
									<p>
										<?= (!empty($data->total_du_no_trong_han_t10_old)) ? number_format($data->total_du_no_trong_han_t10_old) : 0 ?>
									</p>
								</div>

							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại trong hạn T+10 kỳ trước
									</h5>
									<p>
										<?= (!empty($data->total_du_no_trong_han_t10_thang_truoc)) ? number_format($data->total_du_no_trong_han_t10_thang_truoc) : 0 ?>
									</p>
								</div>
							</div>


						</div>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="row" style="margin: 0 0 20px 0; width: calc( 100% + 7px);">
							<div class="col-md-4 chart_left">
								<div class="chart_left_box">

									<style>
										.tooltip * {
											background: #005f57 !important;
										}
									</style>
									<div class="title">
										<h3 title="Chỉ tiêu giải ngân: <?= number_format($tong_chi_tieu_giai_ngan) ?> | Chỉ tiêu gốc còn lại trong hạn tăng net: <?= number_format($tong_chi_tieu_du_no_tang_net) ?> | Chỉ tiêu bảo hiểm: <?= number_format($tong_chi_tieu_bao_hiem) ?> | Chỉ tiêu NĐT: <?= number_format($tong_chi_tieu_nha_dau_tu)?>"
											data-toggle="tooltip">
											Tỉ lệ hoàn thành KPI
										</h3>
									</div>
									<div class="card">
										<div class="chart-center">
											<span><?= !empty($tong_kpi) ? $tong_kpi : 0 ?>%</span>
										</div>
										<canvas id="DanhSachHopDong1" height="400" width="400"
												style="margin: auto; display: block; height: auto; width: 300px;">
										</canvas>

										<?php
										$chart = $tong_kpi;
										if ($chart >= 100) {
											$chart_1 = 0;
										} else {
											$chart_1 = 100 - $chart;
										}
										?>

										<script>
											if ($('#DanhSachHopDong1').length) {

												var chart_doughnut_settings = {
													type: 'doughnut',
													tooltipFillColor: "rgba(51, 51, 51, 0.55)",
													data: {
														labels: [
															"Chưa hoàn thành",
															"Hoàn thành",
														],
														datasets: [{
															data: [<?= !empty($chart_1) ? $chart_1 : 0 ?>,<?= !empty($chart) ? $chart : 0 ?>],
															backgroundColor: [
																"#bcc4d5", '#EC1E24'
															],
															hoverBackgroundColor: [
																"#bcc4d5", "#EC1E24"
															],
															datalabels: {
																display: false,
																color: '#fff',
																formatter: function (value, context) {
																	if (value == 0) {
																		return '';
																	} else {
																		return value;
																	}

																}
															}
														}]
													},

													options: {
														display: false,
														legend: false,
														responsive: false,

													}
												}


												$('#DanhSachHopDong1').each(function () {

													var chart_element = $(this);
													new Chart(chart_element, chart_doughnut_settings);

												});

											}
										</script>

									</div>
									<a class="btn btn_create_kpi" href="<?= base_url() ?>kpi/listKPI_pgd"
									   target="_blank">
										Tạo KPI mới
									</a>
								</div>
							</div>

							<div class="col-md-8">
								<div class="right_wiget-bar">
									<div class="title">
										<h3 style="color: #0CA678">
											Tỉ lệ hoàn thành KPI PGD
										</h3>
										<div class="box_hd">
											<a href="#" class="box box_bh">
												Giải ngân
											</a>
											<a href="#" class="box box_dn">
												Gốc còn lại trong hạn tăng net
											</a>
											<a href="#" class="box box_gn">
												Bảo hiềm
											</a>
											<a href="#" class="box box_ndt">
												Nhà đầu tư
											</a>
										</div>
									</div>
									<div class="line_bar_list">
										<?php
										$arr_kpi_vung = [];

										foreach ($report_kpi as $key => $kpi) {
											if (!empty($kpi->kpi->giai_ngan_CT))
												$giai_ngan = round(($kpi->total_giai_ngan_chi_tieu_ti_trong / $kpi->kpi->giai_ngan_CT) * $kpi->kpi->giai_ngan_TT);
											if (!empty($kpi->kpi->bao_hiem_CT))
												$bao_hiem = round(($kpi->sum_bao_hiem / $kpi->kpi->bao_hiem_CT) * $kpi->kpi->bao_hiem_TT);
											if (!empty($kpi->kpi->du_no_CT))
												$du_no = round(($kpi->du_no_tang_net / $kpi->kpi->du_no_CT) * $kpi->kpi->du_no_TT);
											if (!empty($kpi->kpi->nha_dau_tu))
												$nha_dau_tu = round(($kpi->sum_nha_dau_tu / $kpi->kpi->nha_dau_tu) * $kpi->kpi->nha_dau_tu_TT);

											$name = (!in_array('cua-hang-truong', $groupRoles) || (in_array('phat-trien-san-pham', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles))) ? $kpi->store->name : $kpi->user_email;
											$link = (in_array('cua-hang-truong', $groupRoles)) ? base_url('kpi/listDetailKPI_user') . '?customer_email=' . $kpi->user_email : base_url('kpi/listDetailKPI_pgd') . '?code_store%5B%5D=' . $kpi->store->id;

											$giai_ngan = is_numeric($giai_ngan) ? $giai_ngan : 0;
											$bao_hiem = is_numeric($bao_hiem) ? $bao_hiem : 0;
											$du_no = is_numeric($du_no) ? $du_no : 0;
											$nha_dau_tu = is_numeric($nha_dau_tu) ? $nha_dau_tu : 0;

											if (empty($kpi->total_giai_ngan_chi_tieu_ti_trong)) {
												$giai_ngan = 0;
											}
											if (empty($kpi->sum_bao_hiem)) {
												$bao_hiem = 0;
											}
											if (empty($kpi->du_no_tang_net)) {
												$du_no = 0;
											}
											if (empty($kpi->sum_nha_dau_tu)) {
												$nha_dau_tu = 0;
											}

											if ($du_no > 40) {
												$du_no = 40;
											} elseif ($du_no < 0){
												$du_no = 0;
											}
											if ($bao_hiem > 40) {
												$bao_hiem = 40;
											}
											if ($giai_ngan > 40) {
												$giai_ngan = 40;
											}
											if ($nha_dau_tu > 20) {
												$nha_dau_tu = 20;
											}

											$tong = $giai_ngan + $bao_hiem + $du_no + $nha_dau_tu;

											$arr_kpi_vung += ["$tong" => "$name"];
											?>
											<a class="item_child" target="_blank" data-toggle="modal"
											   href="<?php echo base_url(); ?>kpi/detail_asm_dashboard?store_id=<?= !empty($kpi->store->id) ? $kpi->store->id : '' ?>">
												<div class="item_bar">
													<span><?= $name ?></span>
													<div class="bar_horizontal">
														<div style="width: <?=($giai_ngan/140)*100?>%;background: #2fb344;z-index: 10;"
															 class="bar_horizontal_child"></div>
														<div style="width: <?=($bao_hiem/140)*100?>%;background: #D63939;z-index: 9;"
															 class="bar_horizontal_child"></div>
														<div style="width: <?=($du_no/140)*100?>%;background: #337ab7;z-index: 8;"
															 class="bar_horizontal_child"></div>
														<div style="width: <?=($nha_dau_tu/140)*100?>%;background: #ff7d31;z-index: 7;"
															 class="bar_horizontal_child"></div>
													</div>
												</div>
												<div class="const_percent" style="color: #D63939">
													<span><?= $tong ?>%</span>
												</div>
											</a>
										<?php } ?>
									</div>

									<div class="footer_bar">
										<div class="title_footer">
											<span>Tổng kết</span>
										</div>
										<div class="row">
											<?php
											ksort($arr_kpi_vung);
											if (!empty($arr_kpi_vung)):?>

												<div class="col-md-6">
													<div class="hight_percent">
														<div class="top plus">
															Cao nhất
														</div>
														<div class="percent-data">
															<div class="percent_place">
																<?php
																$i = 0;
																foreach ($arr_kpi_vung as $key => $value) {
																	if ($i == 0) {
																		$ten_thapnhat = $value;
																		$phantram_thapnhat = $key;
																	}
																	if ($i == count($arr_kpi_vung) - 1) {
																		$ten_caonhat = $value;
																		$phantram_caonhat = $key;
																	}
																	$i++;

																}
																?>
																<?= $ten_caonhat ?>
															</div>
															<div class="percent_kpi plus">
																<?= $phantram_caonhat ?>%
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="hight_percent">
														<div class="top minus">
															Thấp nhất
														</div>
														<div class="percent-data">
															<div class="percent_place">
																<?= $ten_thapnhat ?>
															</div>
															<div class="percent_kpi minus">
																<?= $phantram_thapnhat ?>%
															</div>
														</div>
													</div>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>

							</div>


						</div>
						<div class="x_panel tile" style="margin-bottom: 0">
							<div class="x_title">
								<h2>Biểu Đồ Hợp Đồng</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="row">
									<div class="col-12 col-md-6 ">
										<div class="chartwrapper">
											<div class="doughnut_middledata">
												<?= $contract_total ?>
												<br/>
												<span class="contract">hợp đồng</span>
											</div>
											<canvas id="DanhSachHopDong" height="300"
													style="margin: auto;  display: block;">
											</canvas>
											<script>
												if ($('#DanhSachHopDong').length) {
													var chart_doughnut_settings = {
														type: 'doughnut',
														tooltipFillColor: "rgba(51, 51, 51, 0.55)",
														data: {
															labels: [
																"Mới",
																"Đang xử lý",
																"Chờ CHT phê duyệt",
																"Hội sở đã duyệt",
																"Chờ giải ngân",
																"Đang vay",
																"Khác"
															],
															datasets: [{
																data: [<?=$contract_moi ?>, <?=$contract_dang_xl ?>, <?=$contract_cho_pd?>, <?=$contract_da_duyet ?>, <?=$contract_cho_gn ?>, <?=$contract_da_gn ?>, <?=$contract_khac ?>],
																backgroundColor: [
																	"#EC1E24", "#bcc4d5", "#AE3EC9", "#4263EB", "#F76707", "#0E9549", "#F59F00"
																],
																hoverBackgroundColor: [
																	"#EC1E24", "#bcc4d5", "#AE3EC9", "#4263EB", "#F76707", "#0E9549", "#F59F00"
																],
																datalabels: {
																	display: false,
																	color: '#fff',
																	formatter: function (value, context) {
																		if (value == 0) {
																			return '';
																		} else {
																			return value;
																		}

																	}
																}
															}]
														},

														options: {
															display: false,
															legend: false,
															responsive: false,

														}
													}
													$('#DanhSachHopDong').each(function () {
														var chart_element = $(this);
														new Chart(chart_element, chart_doughnut_settings);
													});
												}
											</script>
										</div>
									</div>
									<div class="col-12 col-md-6 ">
										<table class="table table-borderless">
											<thead>
											<tr>
												<th scope="col">Trạng thái</th>
												<th scope="col">Số lượng (%)</th>

											</tr>
											</thead>
											<tbody>
											<tr style="color:#EC1E24">
												<td>
													<a style="color:#EC1E24" target="_blank"
													   href="https://lms.tienngay.vn/pawn/search?status=1&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Mới:
													</a>
												</td>
												<td>
													<?= $contract_moi ?>
													(<i><?= ($contract_total > 0) ? round(($contract_moi / $contract_total) * 100) : 0 ?></i>%)
												</td>

											</tr>
											<tr style="color:#AE3EC9">
												<td>
													<a style="color:#AE3EC9" target="_blank"
													   href="https://lms.tienngay.vn/pawn/search?status=2&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Chờ CHT duyệt:
													</a>
												</td>
												<td>
													<?= $contract_dang_xl ?>
													(<i><?= ($contract_total > 0) ? round(($contract_dang_xl / $contract_total) * 100) : 0 ?></i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#17A2B8">
												<td>
													<a style="color:#17A2B8" target="_blank"
													   href="https://lms.tienngay.vn/pawn/search?status=5&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Chờ HS duyệt:
													</a>
												</td>
												<td>
													<?= $contract_cho_pd ?>
													(<i><?= ($contract_total > 0) ? round(($contract_cho_pd / $contract_total) * 100) : 0 ?></i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#4263EB">
												<td>
													<a style="color:#4263EB" target="_blank"
													   href="https://lms.tienngay.vn/pawn/search?status=6&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Hội sở đã duyệt:
													</a>
												</td>
												<td>
													<?= $contract_da_duyet ?>
													(<i><?= ($contract_total > 0) ? round(($contract_da_duyet / $contract_total) * 100) : 0 ?></i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#F76707">
												<td>
													<a style="color:#F76707" target="_blank"
													   href="https://lms.tienngay.vn/pawn/search?status=15&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Chờ giải ngân: </a>
												</td>
												<td>
													<?= $contract_cho_gn ?>
													(<i><?= ($contract_total > 0) ? round(($contract_cho_gn / $contract_total) * 100) : 0 ?></i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#0E9549">
												<td>
													<a style="color:#0E9549" target="_blank"
													   href="https://lms.tienngay.vn/pawn/search?ngay_giai_ngan=2&amp;status=17&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Đang vay:
													</a>
												</td>
												<td>
													<?= $contract_da_gn ?>
													(<i><?= ($contract_total > 0) ? round(($contract_da_gn / $contract_total) * 100) : 0 ?></i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#F59F00">
												<td>
													<a style="color:#F59F00" target="_blank" href="#" class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Khác: </a>
												</td>
												<td>
													<?= $contract_khac ?>
													(<i><?= ($contract_total > 0) ? round(($contract_khac / $contract_total) * 100) : 0 ?></i>%)
												</td>
												<td></td>
											</tr>
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
</div>


<div class="modal fade" id="kpi" tabindex="-1" role="dialog" aria-labelledby="kpi" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="right_wiget-bar">
				<div class="title">
					<h3 style="color: #0CA678">
						Tỉ lệ hoàn thành KPI phòng giao dịch
					</h3>
				</div>
				<div class="line_bar_list">
					<div id="child"></div>

				</div>
				<div class="footer_bar">
					<div class="title_footer">
						<span>Tổng kết</span>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="hight_percent">
								<div class="top plus">
									Cao nhất
								</div>
								<div class="percent-data">
									<div id="result_data_cn" class="result_data_tn"></div>
								</div>

							</div>
						</div>
						<div class="col-md-6">
							<div class="hight_percent">
								<div class="top minus">
									Thấp nhất
								</div>
								<div class="percent-data">
									<div id="result_data_tn" class="result_data_tn"></div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<link href="<?php echo base_url(); ?>assets/home/css/dashboard_kd.css" rel="stylesheet">
<script type="text/javascript">
	$('ul.tabs li').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('ul.tabs li').removeClass('active');
		$('.tab-panel').removeClass('active');
		$(this).addClass('active');
		$("#" + tab_id).addClass('active');
	})
	$('ul.tabs_area li').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('ul.tabs_area li').removeClass('active');
		$('.tab-panels').removeClass('active');
		$(this).addClass('active');
		$("#" + tab_id).addClass('active');
	})


	function show_kpi_user(thiz) {

		$("#child").empty();
		$("#result_data_cn").empty();
		$("#result_data_tn").empty();

		let kpi = $(thiz).data("kpi");
		let fdate = $(thiz).data("fdate");

		var formData = new FormData();
		formData.append('fdate', fdate);

		$.ajax({
			url: _url.base_url + 'kpi/listDetailKPI_user_v2?store_id=' + kpi,
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data)
				$(".theloading").hide();
				let html = "";
				let arr_tong = [];
				let arr_name = [];
				if (data.status == 200) {
					for (let i = 0; i < data.data.length; i++) {
						let giai_ngan = 0;
						let bao_hiem = 0;
						let khach_hang_moi = 0;

						if (data.data[i].kpi.giai_ngan_CT > 0) {
							giai_ngan = Math.round((data.data[i].du_no_tang_net / data.data[i].kpi.giai_ngan_CT) * (data.data[i].kpi.giai_ngan_TT));
						}
						if (data.data[i].kpi.bao_hiem_CT > 0) {
							bao_hiem = Math.round((data.data[i].sum_bao_hiem / data.data[i].kpi.bao_hiem_CT) * (data.data[i].kpi.bao_hiem_TT));
						}
						if (giai_ngan > 84) {
							giai_ngan = 84;
						}
						if (bao_hiem > 36) {
							bao_hiem = 36;
						}

						tong = giai_ngan + bao_hiem;

						html += '<div class="item_child"><div class="item_bar"><span>T' + data.data[i].month + ' - ' + data.data[i].user_email + '</span><div class="bar_horizontal"><div style="width: ' + giai_ngan + '%;background: #0CA678; z-index: 10;" class="bar_horizontal_child"></div><div style="width: ' + bao_hiem + '%;background: #D63939; z-index: 9;" class="bar_horizontal_child"></div><div style="width: ' + khach_hang_moi + '%;background: #219dd1; z-index: 8;" class="bar_horizontal_child"></div></div></div><div class="const_percent" style="color: #D63939"><span>' + tong + '%</span></div></div>'

						arr_tong.push(tong)
						arr_name.push('T' + data.data[i].month + " - " + data.data[i].user_email)

					}

					var result = arr_tong.reduce(function (result, field, index) {
						result[arr_name[index]] = field;
						return result;
					}, {})

					var masterList_ = sortObject(result);

					let txt_tn = ""
					let txt_cn = ""

					for (let j = 0; j < masterList_.length; j++) {
						console.log(masterList_)
						if (j < 3) {
							txt_tn += '<div class="item_percent"> <div class="percent_place">' + masterList_[j].key + '</div><div class="percent_kpi plus">' + masterList_[j].value + '%</div></div>'
						}
						if (j > masterList_.length - 4) {
							txt_cn += '<div class="item_percent"><div class="percent_place">' + masterList_[j].key + '</div><div class="percent_kpi plus">' + masterList_[j].value + '%</div></div>'
						}

					}

					// $('#href').attr('href', _url.base_url + 'kpi/listDetailKPI_user?customer_email=' + email)
					$("#result_data_tn").append(txt_tn);
					$("#result_data_cn").append(txt_cn);
					$("#child").append(html);


				}


				$("#kpi").modal("show");


			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});
	}

	function sortObject(obj) {
		var arr = [];
		for (var prop in obj) {
			if (obj.hasOwnProperty(prop)) {
				arr.push({
					'key': prop,
					'value': obj[prop]
				});
			}
		}
		arr.sort(function (a, b) {
			return a.value - b.value;
		});
		return arr;
	}
</script>

<script type="text/javascript">

	$(window).on('load', function () {
		var getcookie = getCookie("modal");
		if (getcookie) {
			$('#thongbaoModal_0').modal('hidden');
		} else {
			$('#thongbaoModal_0').modal('show');
		}
	});
	$(document).ready(function () {
		$("#close_load").click(function (event) {
			setCookie("modal", "hidden", 1)
		});
		$("#thongbaoModal_0").click(function (event) {
			setCookie("modal", "hidden", 1)
		});
		$(window).keydown(function (event) {
			if (event.keyCode == 116) {
				setCookie("modal", "hidden", 1)
			}
		});
	});
</script>

<script>
	function setCookie(cname, cvalue, exdays) {
		const d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		let expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		let name = cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for (let i = 0; i < ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
</script>
<script>
	$(document).ready(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
