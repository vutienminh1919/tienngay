<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$search_status = !empty($_GET['search_status']) ? $_GET['search_status'] : "";

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
							<span>Trưởng phòng giao dịch</span>
						</div>
					</div>
					<div class="col-xs-12 col-lg-4 mb-3 text-right">
						<button class="show-hide-total-all btn btn-success dropdown-toggle">
							<a target="_blank" style="color: white" href="<?php echo base_url("pawn/createContract") ?>"><i
										class="fa fa-plus" aria-hidden="true"></i> Tạo hợp đồng
							</a>
						</button>

						<button class="show-hide-total-all btn btn-success dropdown-toggle"
								data-toggle="modal"  data-target="#add_lead">
								<span class="fa fa-plus"></span> Tạo khách hàng tiềm năng
						</button>
						<a style="    float: revert;width: 120px !important;"
						   href="<?= base_url() ?>excel/exportDashboard_lead?fdate=<?= $fdate . '&tdate=' . $tdate  ?>"
						   class="btn btn-primary w-100" target="_blank"><i
									class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
							Xuất excel
						</a>
						<a style="    float: revert;width: 170px !important;"
						   href="<?= base_url() ?>excel/exportAllBaohiem?fdate=<?= $fdate . '&tdate=' . $tdate  ?>"
						   class="btn btn-primary w-100" target="_blank"><i
								class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
							Excel bảo hiểm
						</a>
						<button class="show-hide-total-all btn btn-success dropdown-toggle"
								onclick="$('#lockdulieu').toggleClass('show');">
							<span class="fa fa-search"></span>
						</button>
						<form action="<?php echo base_url('report_kpi/kpi_domain_v2') ?>" method="get">
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
				if (!empty($report_kpi)){
					foreach ($report_kpi as $key => $kpi) {
						$tong_bao_hiem += $kpi->sum_bao_hiem;
					}
				}

				foreach ($data_kpi as $key => $value) {

					$tong_chi_tieu_du_no_tang_net += $value->kpi->du_no_CT;
					$tong_TT_du_no_tang_net += $value->kpi->du_no_TT;

					$tong_chi_tieu_bao_hiem += $value->kpi->bao_hiem_CT;
					$tong_TT_bao_hiem += $value->kpi->bao_hiem_TT;

					$tong_chi_tieu_giai_ngan += $value->kpi->giai_ngan_CT;
					$tong_TT_giai_ngan += $value->kpi->giai_ngan_TT;

					$tong_chi_tieu_nha_dau_tu += $value->kpi->nha_dau_tu;
					$tong_TT_nha_dau_tu += $value->kpi->nha_dau_tu_TT;
				}

				if ($tong_chi_tieu_du_no_tang_net != 0) {
					$du_no = round(($tong_du_no_tang_net / $tong_chi_tieu_du_no_tang_net) * $data_kpi[0]->kpi->du_no_TT);
				}
				if ($tong_chi_tieu_bao_hiem != 0) {
					$bao_hiem = round(($data->total_doanh_so_bao_hiem / $tong_chi_tieu_bao_hiem) * $data_kpi[0]->kpi->bao_hiem_TT);
				}
				if ($tong_chi_tieu_giai_ngan != 0) {
					$giai_ngan = round(($data->total_giai_ngan_chi_tieu_ti_trong / $tong_chi_tieu_giai_ngan) * $data_kpi[0]->kpi->giai_ngan_TT);
				}
				if ($tong_chi_tieu_nha_dau_tu != 0) {
					$nha_dau_tu = round(($data->total_nha_dau_tu / $tong_chi_tieu_nha_dau_tu) * $data_kpi[0]->kpi->nha_dau_tu_TT);
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

				$tong_tien_hoa_hong = 0;
				if($tong_kpi >= 60 && $tong_kpi < 80){
					$tong_tien_hoa_hong = ($data->total_tien_hoa_hong + ($data->total_du_no_trong_han_t10 * 0.2/100) + ($data->total_du_no_trong_han_t10_old * 0.03/100)) * 0.6 ;
				} elseif ($tong_kpi >= 80 && $tong_kpi < 100){
					$tong_tien_hoa_hong = ($data->total_tien_hoa_hong + ($data->total_du_no_trong_han_t10 * 0.2/100) + ($data->total_du_no_trong_han_t10_old * 0.03/100)) * 0.8 ;
				} elseif ($tong_kpi >= 100 && $tong_kpi < 120){
					$tong_tien_hoa_hong = ($data->total_tien_hoa_hong + ($data->total_du_no_trong_han_t10 * 0.2/100) + ($data->total_du_no_trong_han_t10_old * 0.03/100)) * 1 ;
				} elseif ($tong_kpi >= 120){
					$tong_tien_hoa_hong = ($data->total_tien_hoa_hong + ($data->total_du_no_trong_han_t10 * 0.2/100) + ($data->total_du_no_trong_han_t10_old * 0.03/100)) * 1.2 ;
				} else {
					$tong_tien_hoa_hong = 0;
				}
				$tong_tien_hoa_hong = $tong_tien_hoa_hong + $data->tien_hoa_hong_nha_dau_tu;
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
										Tiền giải ngân mới kỳ này
									</h5>
									<p>
										<?=(!empty($data->total_so_tien_vay->{'$numberLong'})) ? number_format($data->total_so_tien_vay->{'$numberLong'}) :  number_format($data->total_so_tien_vay) ?>
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
									<style>
										.tooltip * {
											background: #005f57 !important;
										}
									</style>
									<div title="Chỉ tiêu giải ngân: <?= number_format($tong_chi_tieu_giai_ngan) ?> | Chỉ tiêu gốc còn lại trong hạn tăng net: <?= number_format($tong_chi_tieu_du_no_tang_net) ?> | Chỉ tiêu bảo hiểm: <?= number_format($tong_chi_tieu_bao_hiem) ?> | Chỉ tiêu NĐT: <?= number_format($tong_chi_tieu_nha_dau_tu) ?> " data-toggle="tooltip">
										<h3  data-toggle="modal" data-target="#kpi" style="cursor: pointer; color: red">
											Tỉ lệ hoàn thành KPI
										</h3>
									</div>
									<div class="card">
										<div class="chart-center">
											<span><?= !empty($tong_kpi) ? $tong_kpi : 0 ?>%</span>
										</div>
										<canvas id="DanhSachHopDong1" height="400" width="400" style="margin: auto; display: block; height: auto; width: 300px;">
										</canvas>
										<?php
										$chart = $tong_kpi;
										if ($chart >= 100){
											$chart_1 = 0;
										} else {
											$chart_1 = 100 - $chart;
										}
										?>

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
															data: [<?= !empty($chart_1) ? $chart_1 : 0 ?>,<?= !empty($chart) ? $chart :0 ?>],
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
									<a class="btn btn_create_kpi" href="<?= base_url() ?>kpi/listKPI_gdv" target="_blank">
										Tạo KPI mới
									</a>
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
						$tong = 0;
						if (!empty($kpi->kpi->giai_ngan_CT))
							$giai_ngan = round(($kpi->total_giai_ngan_chi_tieu_ti_trong / $kpi->kpi->giai_ngan_CT) * $kpi->kpi->giai_ngan_TT);
						if (!empty($kpi->kpi->bao_hiem_CT))
							$bao_hiem = round(($kpi->sum_bao_hiem / $kpi->kpi->bao_hiem_CT) * $kpi->kpi->bao_hiem_TT);
						if (!empty($kpi->kpi->du_no_CT))
							$du_no = round(($kpi->du_no_tang_net / $kpi->kpi->du_no_CT) * $kpi->kpi->du_no_TT);
						if (!empty($kpi->kpi->nha_dau_tu))
							$nha_dau_tu = round(($kpi->sum_nha_dau_tu / $kpi->kpi->nha_dau_tu) * $kpi->kpi->nha_dau_tu_TT);

						$name= !empty($kpi->user_email) ? $kpi->user_email : "";
						$link=(in_array('cua-hang-truong', $groupRoles)) ? base_url('kpi/listDetailKPI_user').'?customer_email='.$kpi->user_email : base_url('kpi/listDetailKPI_pgd').'?code_store%5B%5D='.$kpi->store->id;
						$giai_ngan=is_numeric( $giai_ngan)  ?  $giai_ngan : 0;
						$bao_hiem=is_numeric( $bao_hiem) ?  $bao_hiem : 0;
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
						<a class="item_child" target="_blank" data-toggle="modal" href="<?php echo base_url(); ?>kpi/detail_lead_dashboard?name=<?= !empty($name) ? $name : '' ?>">
							<div class="item_bar">
								<span><?=$name?></span>
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
								<span><?=$tong?>%</span>
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
						if(!empty($arr_kpi_vung)):?>

							<div class="col-md-6">
								<div class="hight_percent">
									<div class="top plus">
										Cao nhất
									</div>
									<div class="percent-data">
										<div class="percent_place">
											<?php
											$i = 0;
											foreach ($arr_kpi_vung as $key => $value){
												if ($i == 0){
													$ten_thapnhat = $value;
													$phantram_thapnhat = $key;
												}
												if ($i == count($arr_kpi_vung)-1){
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

<div class="modal" id="modal_setup_kpi" hidden>
	<div class="modal_content">
		<header class="w3-container w3-teal">
			<span class="w3-button w3-display-topright" data-dismiss="modal">&times;</span>
			<h2>Thông báo Set KPI tháng <?= date('m') ?></h2>
		</header>
		<div class="w3-container body">
			<p>Vui lòng cài đặt KPI giao dịch viên</p>
		</div>
		<div class="modal-footer_kpi">
			<a target="_blank" type="button" style="margin-bottom: 0;font-size: 15px; background-color: white; color: black" class="btn btn-secondary" id="setup_kpi" >Cài đặt KPI</a>
		</div>
	</div>
</div>

<style>
	.modal_content{
		position: absolute;
		z-index: 9999;
		left: 0;
		right: 0;
		width: 400px;
		background: #fff;
		margin: 0 auto;
		top: 30%;
		text-align: left;
	}
	.w3-teal {
		background: #0a5a2c;
		padding: 15px;
		color: #fff;
		position: relative;
	}
	span.w3-button.w3-display-topright {
		position: absolute;
		right: 9px;
		top: 0;
		font-size: 30px;
		cursor: pointer;
	}
	.w3-teal h2{
		margin: 0;
	}
	.w3-container.body{
		padding: 15px;
		font-size: 16px;
	}
	.modal-footer_kpi{
		background: #0a5a2c;
	}
	.modal-footer_kpi {
		background: #0a5a2c;
		padding: 10px 15px;
	}
</style>

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

<script type="text/javascript">

	$(window).on('load', function () {
		var getcookie = getCookie("modal");
		if(getcookie)
		{
			$.ajax({
				url: _url.base_url + 'exemptions/push_noti_api',
				type: "POST",
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (data) {
					console.log(data)
					if (data.code == 200){

						$('#modal_setup_kpi').modal("show");
						$('#setup_kpi').attr("href", "<?php echo base_url(); ?>" + data.click_action);
					}
					$('#thongbaoModal_0').modal('hidden');

				},

			});
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
