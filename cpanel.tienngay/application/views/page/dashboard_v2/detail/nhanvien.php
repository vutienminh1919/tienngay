<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$search_status = !empty($_GET['search_status']) ? $_GET['search_status'] : "";
$name = !empty($_GET['name']) ? $_GET['name'] : "";

$contract_total=(!empty($data->contract_total)) ? $data->contract_total : 0;
$contract_moi=(!empty($data->contract_moi)) ? $data->contract_moi : 0;
$contract_dang_xl=(!empty($data->contract_dang_xl)) ? $data->contract_dang_xl : 0;
$contract_cho_pd=(!empty($data->contract_cho_pd)) ? $data->contract_cho_pd : 0;
$contract_da_duyet=(!empty($data->contract_da_duyet)) ? $data->contract_da_duyet : 0;
$contract_cho_gn=(!empty($data->contract_cho_gn)) ? $data->contract_cho_gn : 0;
$contract_da_gn=(!empty($data->contract_da_gn)) ? $data->contract_da_gn : 0;
$contract_khac=(!empty($data->contract_khac)) ? $data->contract_khac : 0;

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
					<div class="col-xs-12 col-lg-8">
						<div class="title">
							<h3 class="tilte_top_tabs" style="margin-bottom: 0">
								Dashboard
							</h3>
							<span>Chuyên viên kinh doanh - <?= $name ?></span>
						</div>
					</div>
					<div class="col-xs-12 col-lg-4 mb-3 text-right">
						<button class="show-hide-total-all btn btn-success dropdown-toggle"
								data-toggle="modal"  data-target="#add_lead">
							<span class="fa fa-plus"></span> Tạo khách hàng tiềm năng
						</button>
						<button class="show-hide-total-all btn btn-success dropdown-toggle"
								onclick="$('#lockdulieu').toggleClass('show');">
							<span class="fa fa-search"></span>
						</button>
						<form action="<?php echo base_url('kpi/detail_lead_dashboard') ?>" method="get">
							<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
								style="padding:15px;min-width:250px;">

								<li class="form-group">
									<div class="row">
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Từ:</label>
												<input type="date" class="form-control" name="fdate" value="<?= !empty($fdate) ?  $fdate :  date('Y-m-01')?>">
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Đến:</label>
												<input type="date" class="form-control" name="tdate" value="<?= !empty($tdate) ?  $tdate : date('Y-m-d')?>" >
											</div>
											<input type="hidden" class="form-control" name="name" value="<?= !empty($name) ?  $name : '' ?>" >
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
				$date = getdate();
				$kpiPercent_ToTal = 0;
				$month_check = $date['mon']-1;
				if (!empty($fdate) && $fdate != ""){
					$month_check = date('m', strtotime($fdate)) - 1;
				}

				$data_kpichitieu_dsGiaiNgan = explode(",", $data_kpichitieu_dsGiaiNgan);
				$data_kpichitieu_dsBaoHiem = explode(",", $data_kpichitieu_dsBaoHiem);

				$data_kpidatduoc_dsGiaiNgan = explode(",", $data_kpidatduoc_dsGiaiNgan);
				$data_kpidatduoc_dsBaoHiem = explode(",", $data_kpidatduoc_dsBaoHiem);

				$datakpi_titrong_dsGiaiNgan = explode(",", $datakpi_titrong_dsGiaiNgan);
				$datakpi_titrong_dsBaoHiem = explode(",", $datakpi_titrong_dsBaoHiem);

				$data_kpichitieu_duno = explode(",", $data_kpichitieu_duno);
				$data_kpititrong_duno = explode(",", $data_kpititrong_duno);

				$data_kpichitieu_nhadautu = explode(",", $data_kpichitieu_nhadautu);
				$data_kpititrong_nhadautu = explode(",", $data_kpititrong_nhadautu);

				if (!empty($data_kpichitieu_dsGiaiNgan[$month_check] != 0)){
					$kpiPercent_dsGiaiNgan = round(($data->total_giai_ngan_chi_tieu_ti_trong / $data_kpichitieu_dsGiaiNgan[$month_check]) * $datakpi_titrong_dsGiaiNgan[$month_check]);
				}

				if (!empty($data_kpichitieu_dsBaoHiem[$month_check] != 0)){
					$kpiPercent_dsBaoHiem = round(($data->total_doanh_so_bao_hiem / $data_kpichitieu_dsBaoHiem[$month_check]) * $datakpi_titrong_dsBaoHiem[$month_check]);
				}

				if (!empty($data_kpichitieu_duno[$month_check] != 0)){
					$kpiPercent_dsDuNo = round(($data->total_du_no_trong_han_t10 / $data_kpichitieu_duno[$month_check]) * $data_kpititrong_duno[$month_check]);
				}

				if (!empty($data_kpichitieu_nhadautu[$month_check] != 0)){
					$kpiPercent_dsNhaDauTu = round(($data->total_nha_dau_tu / $data_kpichitieu_nhadautu[$month_check]) * $data_kpititrong_nhadautu[$month_check]);
				}

				//kpi
				$du_no_tang_net = 0;
				$kpi_new = 0;
				if (($data->total_du_no_trong_han_t10 != 0)) {
					$du_no_tang_net = $data->total_du_no_trong_han_t10;
				}


				if ($kpiPercent_dsDuNo > 40) {
					$kpiPercent_dsDuNo = 40;
				} elseif ($kpiPercent_dsDuNo < 0){
					$kpiPercent_dsDuNo = 0;
				}
				if ($kpiPercent_dsBaoHiem > 40) {
					$kpiPercent_dsBaoHiem = 40;
				}
				if ($kpiPercent_dsGiaiNgan > 40) {
					$kpiPercent_dsGiaiNgan = 40;
				}
				if ($kpiPercent_dsNhaDauTu > 20) {
					$kpiPercent_dsNhaDauTu = 20;
				}

				$kpi_new = $kpiPercent_dsDuNo + $kpiPercent_dsBaoHiem + $kpiPercent_dsGiaiNgan + $kpiPercent_dsNhaDauTu;

				$tong_tien_hoa_hong = 0;
				if($kpi_new >= 60 && $kpi_new < 80){
					$tong_tien_hoa_hong = ($data->total_tien_hoa_hong + ($data->total_du_no_trong_han_t10 * 0.3/100) + ($data->total_du_no_trong_han_t10_old * 0.1/100)) * 0.6 + $data->total_tien_hoa_hong_bao_hiem + $data->tien_hoa_hong_nha_dau_tu;
				} elseif ($kpi_new >= 80 && $kpi_new < 100){
					$tong_tien_hoa_hong = ($data->total_tien_hoa_hong + ($data->total_du_no_trong_han_t10 * 0.3/100) + ($data->total_du_no_trong_han_t10_old * 0.1/100)) * 0.8 + $data->total_tien_hoa_hong_bao_hiem + $data->tien_hoa_hong_nha_dau_tu;
				} elseif ($kpi_new >= 100 && $kpi_new < 120){
					$tong_tien_hoa_hong = ($data->total_tien_hoa_hong + ($data->total_du_no_trong_han_t10 * 0.3/100) + ($data->total_du_no_trong_han_t10_old * 0.1/100)) * 1 + $data->total_tien_hoa_hong_bao_hiem + $data->tien_hoa_hong_nha_dau_tu;
				} elseif ($kpi_new >= 120){
					$tong_tien_hoa_hong = ($data->total_tien_hoa_hong + ($data->total_du_no_trong_han_t10 * 0.3/100) + ($data->total_du_no_trong_han_t10_old * 0.1/100)) * 1.2 + $data->total_tien_hoa_hong_bao_hiem + $data->tien_hoa_hong_nha_dau_tu;
				} else {
					$tong_tien_hoa_hong = $data->total_tien_hoa_hong_bao_hiem + $data->tien_hoa_hong_nha_dau_tu;
				}

				?>



				<div class="row">
					<div class="col-xs-12 col-md-3">
						<div class="left_wiget-bar">

							<div class="const_box_show" data-toggle="modal" >
								<div class="left_box">
									<h5>
										Tổng tiền hoa hồng
									</h5>
									<p>
										<?=(!empty($tong_tien_hoa_hong)) ? number_format($tong_tien_hoa_hong) : 0 ?>
									</p>
								</div>
							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại tăng net trong kỳ
									</h5>
									<p>
										<?=(!empty($data->total_du_no_trong_han_t10)) ? number_format($data->total_du_no_trong_han_t10) : 0 ?>
									</p>
								</div>
							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tiền giải ngân mới kỳ này
									</h5>
									<p>
										<?=(!empty($data->total_so_tien_vay->{'$numberLong'})) ? number_format($data->total_so_tien_vay->{'$numberLong'}) :  number_format($data->total_so_tien_vay) ?>
									</p>
								</div>
							</div>


							<div class="const_box_show" data-toggle="modal" data-target="#baohiem">
								<div class="left_box">
									<h5>
										Doanh số bảo hiểm kỳ này
									</h5>
									<p>
										<?=(!empty($data->total_doanh_so_bao_hiem)) ? number_format($data->total_doanh_so_bao_hiem) : 0 ?>
									</p>
								</div>
							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng tiền giải ngân
									</h5>
									<p>
										<?=(!empty($data->total_so_tien_vay_old->{'$numberLong'})) ? number_format($data->total_so_tien_vay_old->{'$numberLong'}) :  number_format($data->total_so_tien_vay_old) ?>
									</p>
								</div>
							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại quản lý
									</h5>
									<p>
										<?=(!empty($data->total_du_no_dang_cho_vay_old->{'$numberLong'})) ? number_format($data->total_du_no_dang_cho_vay_old->{'$numberLong'}) :  number_format($data->total_du_no_dang_cho_vay_old) ?>
									</p>
								</div>

							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại trong hạn T+10 hiện tại
									</h5>
									<p>
										<?=(!empty($data->total_du_no_trong_han_t10_old)) ? number_format($data->total_du_no_trong_han_t10_old) : 0 ?>
									</p>
								</div>

							</div>

							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại trong hạn T+10 kỳ trước
									</h5>
									<p>
										<?=(!empty($data->total_du_no_trong_han_t10_thang_truoc)) ? number_format($data->total_du_no_trong_han_t10_thang_truoc) : 0 ?>
									</p>
								</div>
							</div>



						</div>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="row" style="margin: 0 0 20px 0; width: calc( 100% + 7px);">
							<div class="col-md-4 chart_left">
								<div class="chart_left_box">

									<div class="title">
										<!--										<h3  data-toggle="modal" data-target="#kpi" style="cursor: pointer">-->
										<style>
											.tooltip * {
												background: #005f57 !important;
											}
										</style>
										<div class="title">
											<h3 title="Chỉ tiêu giải ngân: <?= !empty(($data_kpichitieu_dsGiaiNgan[$month_check])) ? number_format($data_kpichitieu_dsGiaiNgan[$month_check]) : 0  ?> | Chỉ tiêu gốc còn lại trong hạn tăng net: <?= !empty($data_kpichitieu_duno[$month_check]) ? number_format($data_kpichitieu_duno[$month_check]) : 0  ?> | Chỉ tiêu bảo hiểm: <?= !empty(($data_kpichitieu_dsBaoHiem[$month_check])) ? number_format($data_kpichitieu_dsBaoHiem[$month_check]) : 0  ?> | Chỉ tiêu NĐT: <?= !empty(($data_kpichitieu_nhadautu[$month_check])) ? number_format($data_kpichitieu_nhadautu[$month_check]) : 0  ?>" data-toggle="tooltip">
												Tỉ lệ hoàn thành KPI
											</h3>
										</div>
										<?php

										$data_kpichitieu_dsGiaiNgan = implode(",", $data_kpichitieu_dsGiaiNgan);
										$data_kpichitieu_dsBaoHiem = implode(",", $data_kpichitieu_dsBaoHiem);


										$data_kpidatduoc_dsGiaiNgan = implode(",", $data_kpidatduoc_dsGiaiNgan);
										$data_kpidatduoc_dsBaoHiem = implode(",", $data_kpidatduoc_dsBaoHiem);


										$datakpi_titrong_dsGiaiNgan = implode(",", $datakpi_titrong_dsGiaiNgan);
										$datakpi_titrong_dsBaoHiem = implode(",", $datakpi_titrong_dsBaoHiem);

										?>
									</div>
									<div class="card">
										<div class="chart-center">
											<span><?= $kpi_new ?>%</span>
										</div>
										<?php
										if ($kpi_new >= 100){
											$chart_1 = 0;
										} else {
											$chart_1 = 100 - $kpi_new;
										}
										?>
										<canvas id="DanhSachHopDong1" height="400" width="400" style="margin: auto; display: block; height: auto; width: 300px;"></canvas>

										<script>
											if ($('#DanhSachHopDong1').length){

												var chart_doughnut_settings = {
													type: 'doughnut',
													tooltipFillColor: "rgba(51, 51, 51, 0.55)",
													data: {
														labels: [
															"Chưa hoàn thành",
															"Hoàn thành",
														],
														datasets: [{
															data: [<?= !empty($chart_1) ? $chart_1 : 0 ?>,<?= !empty($kpi_new) ? $kpi_new :0 ?>],
															backgroundColor: [
																"#bcc4d5",'#EC1E24'
															],
															hoverBackgroundColor: [
																"#bcc4d5", "#EC1E24"
															],
															datalabels : {
																display: false,
																color: '#fff',
																formatter: function(value, context) {
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



												$('#DanhSachHopDong1').each(function(){

													var chart_element = $(this);
													new Chart( chart_element, chart_doughnut_settings);

												});

											}
										</script>
									</div>
								</div>
							</div>

							<div class="col-md-8">
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
														<?=$contract_total ?>
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
															   href="https://cpanel.tienngay.vn/pawn/search?status=1&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
															   class="text-dark">
																<i class="fa fa-square"></i> &nbsp;
																Mới:
															</a>
														</td>
														<td>
															<?=$contract_moi ?>
															(<i><?=($contract_total>0) ? round(($contract_moi/$contract_total)*100) : 0 ?></i>%)
														</td>

													</tr>
													<tr style="color:#AE3EC9">
														<td>
															<a style="color:#AE3EC9" target="_blank"
															   href="https://cpanel.tienngay.vn/pawn/search?status=2&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
															   class="text-dark">
																<i class="fa fa-square"></i> &nbsp;
																Chờ CHT duyệt:
															</a>
														</td>
														<td>
															<?=$contract_dang_xl ?>
															(<i><?=($contract_total>0) ? round(($contract_dang_xl/$contract_total)*100) : 0 ?></i>%)
														</td>
														<td></td>
													</tr>
													<tr style="color:#17A2B8">
														<td>
															<a style="color:#17A2B8" target="_blank"
															   href="https://cpanel.tienngay.vn/pawn/search?status=5&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
															   class="text-dark">
																<i class="fa fa-square"></i> &nbsp;
																Chờ HS duyệt:
															</a>
														</td>
														<td>
															<?=$contract_cho_pd ?>
															(<i><?=($contract_total>0) ? round(($contract_cho_pd/$contract_total)*100) : 0 ?></i>%)
														</td>
														<td></td>
													</tr>
													<tr style="color:#4263EB">
														<td>
															<a style="color:#4263EB" target="_blank"
															   href="https://cpanel.tienngay.vn/pawn/search?status=6&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
															   class="text-dark">
																<i class="fa fa-square"></i> &nbsp;
																Hội sở đã duyệt:
															</a>
														</td>
														<td>
															<?=$contract_da_duyet ?>
															(<i><?=($contract_total>0) ? round(($contract_da_duyet/$contract_total)*100) : 0 ?></i>%)
														</td>
														<td></td>
													</tr>
													<tr style="color:#F76707">
														<td>
															<a style="color:#F76707" target="_blank"
															   href="https://cpanel.tienngay.vn/pawn/search?status=15&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
															   class="text-dark">
																<i class="fa fa-square"></i> &nbsp;
																Chờ giải ngân: </a>
														</td>
														<td>
															<?=$contract_cho_gn ?>
															(<i><?=($contract_total>0) ? round(($contract_cho_gn/$contract_total)*100) : 0 ?></i>%)
														</td>
														<td></td>
													</tr>
													<tr style="color:#0E9549">
														<td>
															<a style="color:#0E9549" target="_blank"
															   href="https://cpanel.tienngay.vn/pawn/search?ngay_giai_ngan=2&amp;status=17&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
															   class="text-dark">
																<i class="fa fa-square"></i> &nbsp;
																Đang vay:
															</a>
														</td>
														<td>
															<?=$contract_da_gn ?>
															(<i><?=($contract_total>0) ? round(($contract_da_gn/$contract_total)*100) : 0 ?></i>%)
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
															<?=$contract_khac ?>
															(<i><?=($contract_total>0) ? round(($contract_khac/$contract_total)*100) : 0 ?></i>%)
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

						<div class="x_panel tile">
							<div class="x_title">
								<h2>Danh sách Hợp Đồng</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">

								<div class="tabs_or_search">
									<ul class="nav tabs">
										<li data-tab="waitting" class="aos-init aos-animate in active"
											data-aos-delay="1500" data-offset="1500" data-aos-duration="1500"
											data-aos="fade-right">
											<a>
												<h3 class="qt_title">Tổng sổ: <?= !empty($count) ? number_format($count) : 0 ?></h3>
											</a>
										</li>
									</ul>
									<form action="<?php echo base_url('report_kpi/kpi_domain_v2') ?>" method="get" >

										<div class="search">
											<select class="form-control" name="search_status">
												<option value="Đang xử lý" <?php echo $search_status == 'Đang xử lý' ? 'selected' : '' ?>>
													Đang xử lý
												</option>
												<option value="Đã hủy" <?php echo $search_status == 'Đã hủy' ? 'selected' : '' ?>>
													Đã hủy
												</option>
												<option value="Đang vay" <?php echo $search_status == 'Đang vay' ? 'selected' : '' ?>>
													Đang vay
												</option>
											</select>
											<button type="submit" class="btn btn-success btn_search">
												<i class="fa fa-search"></i>
											</button>
										</div>
									</form>

								</div>
								<div class="tab-contents">
									<div id="waitting" class="tab-panel aos-init aos-animate active"
										 data-aos-delay="1500" data-offset="1500" data-aos-duration="1600"
										 data-aos="fade-up-down">
										<table class="table table-striped">
											<thead>
											<tr style="text-align: center">
												<th style="text-align: left;">STT</th>
												<th style="text-align: left">Mã phiếu ghi</th>
												<th style="text-align: left">Mã hợp đồng</th>
												<th style="text-align: left">PGD</th>

												<th style="text-align: center">Ngày tạo</th>
												<th style="text-align: center">Ngày giải ngân</th>
												<th style="text-align: center">Trạng thái</th>
											</tr>
											</thead>
											<tbody>
											<?php if (!empty($contractData)): ?>
												<?php foreach ($contractData as $key => $value): ?>
													<tr>
														<td style="text-align: left;"><?= ++$key ?></td>
														<td style="text-align: left"><?= !empty($value->code_contract) ? $value->code_contract : "" ?></td>
														<td style="text-align: left"><a target="_blank" href="<?php echo base_url("pawn/detail?id=") . $value->_id->{'$oid'} ?>"
																						class="dropdown-item"><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></a></td>

														<td style="text-align: left"><?= !empty($value->store->name) ? $value->store->name : "" ?></td>

														<td style="text-align: center"><?= !empty($value->created_at) ? date("d/m/Y H:i:s", $value->created_at) : "" ?></td>
														<td style="text-align: center"><?= !empty($value->disbursement_date) ? date("d/m/Y H:i:s", $value->disbursement_date) : "" ?></td>
														<td style="text-align: center"><?= !empty($value->status) ? contract_status($value->status) : "" ?></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
											</tbody>
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


			</div>

		</div>
	</div>
</div>


<div class="modal fade in" id="kpi" tabindex="-1" role="dialog" aria-labelledby="kpi" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="right_wiget-bar">
				<div class="title">
					<h3 style="color: #0CA678">
						Tỉ lệ hoàn thành KPI chuyên viên kinh doanh
					</h3>
				</div>

				<canvas id="kpi_detailvung" height="450" class="w-100"></canvas>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add_lead" tabindex="-1" role="dialog" aria-labelledby="add_lead" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="title">
					<h3 style="color: #0CA678; float: left">
						Tạo khách hàng tiềm năng
					</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div style="height: auto;margin-top: 0;clear: both" class="form">
					<div class="input-group">
						<label>Tên khách hàng  <span style="color: red">*</span></label>
						<div class="form-group">
							<input type="text" class="form-control" id="customer_fullname" name="customer_fullname"
								   placeholder="Nhập tên khách hàng">
						</div>
					</div>
					<div class="input-group">
						<label>Số điện thoại <span style="color: red">*</span></label>
						<div class="form-group">
							<input type="text" class="form-control" id="customer_phone" name="customer_phone"
								   placeholder="Nhập số điện thoại">
						</div>
					</div>
					<div class="input-group">
						<label>CCCD/CMTND</label>
						<div class="form-group">
							<input type="text" class="form-control" id="identify_lead" name="identify_lead"
								   placeholder="Nhập CCCD/CMTND">
						</div>
					</div>
					<div class="input-group">
						<label>Địa chỉ </label>
						<div class="form-group">
							<input type="text" class="form-control" id="address" name="address"
								   placeholder="Nhập địa chỉ  ">
						</div>
					</div>
					<div class="input-group">
						<label>Nguồn khách hàng<span style="color: red">*</span></label>
						<div class="form-group">
							<select class="form-control " name="customer_source" id="customer_source">

								<?php foreach (lead_nguon_pgd() as $key1 => $item1) { ?>
									<option value="<?= $key1 ?>" <?= ($source_pgd == $key1) ? 'selected' : '' ?>><?= $item1 ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="input-group">

						<div class="btn btn_create_kh" id="submit_lead">
							Thêm lead khách hàng
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


	$('#submit_lead').click(function (){

		let customer_fullname = $('#customer_fullname').val();
		let customer_phone = $('#customer_phone').val();
		let identify_lead = $('#identify_lead').val();
		let address = $('#address').val();
		let customer_source = $('#customer_source').val();

		$.ajax({
			url: _url.base_url + 'lead_custom/pgd_insert_lead_v2',
			method: "POST",
			data: {
				customer_fullname: customer_fullname,
				customer_phone: customer_phone,
				identify_lead: identify_lead,
				address: address,
				customer_source: customer_source,

			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data.msg)
				$(".theloading").hide();
				if (data.status == 200) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + 'lead_custom/list_transfe_office';
					}, 3000);
				} else {

					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					setTimeout(function () {
						$('#errorModal').modal('hide');
					}, 3000);
				}
			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});

	})
</script>
<script>
	if ($('#kpi_detailvung').length){

		var du_no_tang_net = 0;

		var data_kpichitieu_dsGiaiNgan = [<?=$data_kpichitieu_dsGiaiNgan ?>];
		var data_kpichitieu_dsBaoHiem = [<?=$data_kpichitieu_dsBaoHiem ?>];



		var data_kpidatduoc_dsGiaiNgan = [<?=$data_kpidatduoc_dsGiaiNgan ?>];
		var data_kpidatduoc_dsBaoHiem = [<?=$data_kpidatduoc_dsBaoHiem ?>];


		var datakpi_titrong_dsGiaiNgan = [<?=$datakpi_titrong_dsGiaiNgan ?>];
		var datakpi_titrong_dsBaoHiem = [<?=$datakpi_titrong_dsBaoHiem ?>];


		var data_kpiPercent_dsGiaiNgan = [];
		var data_kpiPercent_dsBaoHiem = [];

//  var data_kpiPercent_tlNoQuaHan = [];

		var data_kpiPercent_ToTal_label = [];
		var data_kpiPercent_ToTal = [];

		data_kpichitieu_dsGiaiNgan.forEach(KPI_Percent_convert);

		function KPI_Percent_convert(item, index) {
			var kpiPercent_dsGiaiNgan = Math.round((data_kpidatduoc_dsGiaiNgan[index] / data_kpichitieu_dsGiaiNgan[index]) * datakpi_titrong_dsGiaiNgan[index]);
			data_kpiPercent_dsGiaiNgan.push(kpiPercent_dsGiaiNgan);

			var kpiPercent_dsBaoHiem = Math.round((data_kpidatduoc_dsBaoHiem[index] / data_kpichitieu_dsBaoHiem[index]) * datakpi_titrong_dsBaoHiem[index]);
			data_kpiPercent_dsBaoHiem.push(kpiPercent_dsBaoHiem);


			// var kpiPercent_tlNoQuaHan = Math.round((data_kpidatduoc_tlNoQuaHan[index] / data_kpichitieu_tlNoQuaHan[index]) * 100);
			// data_kpiPercent_tlNoQuaHan.push(kpiPercent_tlNoQuaHan);

			if (kpiPercent_dsGiaiNgan > 84){
				kpiPercent_dsGiaiNgan = 84;
			}
			if (kpiPercent_dsBaoHiem > 36){
				kpiPercent_dsBaoHiem = 36;
			}

			var kpiPercent_ToTal = kpiPercent_dsGiaiNgan + kpiPercent_dsBaoHiem;




			data_kpiPercent_ToTal_label.push(kpiPercent_ToTal);
			data_kpiPercent_ToTal.push(0);
		}

		var chart_doughnut_settings = {
			type: 'bar',
			data: {

				labels: ["Tháng 1","Tháng 2","Tháng 3","Tháng 4","Tháng 5","Tháng 6","Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12"],
				datasets: [
					{
						type: 'bar',
						label: 'DS giải ngân',
						data: data_kpiPercent_dsGiaiNgan,
						backgroundColor: '#E74C3C',
						datalabels: {
							display: false,
							align: 'center',
							anchor: 'center',
							color: '#fff',
							formatter: function(value, context) {
								return value + '%';
							}
						}
					},{
						type: 'bar',
						label: 'DS bảo hiểm',
						data: data_kpiPercent_dsBaoHiem,
						backgroundColor: '#26B99A',
						datalabels: {
							display: false,
							align: 'center',
							anchor: 'center',
							color: '#fff',
							formatter: function(value, context) {
								return value + '%';
							}
						}
					},{
						type: 'bar',
						label: 'SL khách hàng mới',
						data: data_kpiPercent_slKhachHangMoi,
						backgroundColor: '#337ab7',
						datalabels: {
							display: false,
							align: 'center',
							anchor: 'center',
							color: '#fff',
							formatter: function(value, context) {
								return value + '%';
							}
						}
					},
					{
						type: 'bar',
						label: 'Tổng KPI',
						data: data_kpiPercent_ToTal,
						backgroundColor: '#2A3F54',
						datalabels: {
							align: 'end',
							anchor: 'end',
							color: '#2A3F54',
							formatter: function(value, context) {

								return data_kpiPercent_ToTal_label[context.dataIndex] + '%';
							}
						}
					}

				]},
			options: {
				legend: {
					position: 'bottom'
				},
				responsive: true,
				tooltips: false,
				layout: {
					padding: {
						top: 25,
					}
				},
				scales: {
					xAxes: [{
						stacked: true,
						maxBarThickness: 32,
					}],
					yAxes: [{
						stacked: true,
						maxBarThickness: 32,
					}]
				},
				plugins: {
					datalabels: {
						display: true,
						font: {
							weight: 'bold',
							size: 14
						},
					}
				},
			}
		}

		$('#kpi_detailvung').each(function(){

			var chart_element = $(this);
			var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

		});

	}
</script>

<script type="text/javascript">

	$(window).on('load', function () {
		var getcookie = getCookie("modal");
		if(getcookie)
		{
			$('#thongbaoModal_0').modal('hidden');
		}
		else
		{
			$('#thongbaoModal_0').modal('show');
		}
	});
	$( document ).ready(function() {
		$("#close_load").click(function(event) {
			setCookie("modal","hidden",1)
		});
		$("#thongbaoModal_0").click(function(event) {
			setCookie("modal","hidden",1)
		});
		$(window).keydown(function(event){
			if(event.keyCode == 116) {
				setCookie("modal","hidden",1)
			}
		});
	});
</script>

<script>
	function setCookie(cname, cvalue, exdays) {
		const d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		let expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	function getCookie(cname) {
		let name = cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for(let i = 0; i <ca.length; i++) {
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
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
