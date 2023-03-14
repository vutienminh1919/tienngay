<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$search_status = !empty($_GET['search_status']) ? $_GET['search_status'] : "";

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
					<div class="col-xs-12 col-lg-8">
						<div class="title">
							<h3 class="tilte_top_tabs" style="margin-bottom: 0">
								Dashboard
							</h3>
							<?php
							if (in_array("giam-doc-kinh-doanh", $groupRoles) && $count11 == 0) { ?>
								<span>Giám đốc kinh doanh</span>
							<?php } else { ?>
								<span>Quản lý cấp cao</span>
							<?php } ?>


						</div>
					</div>
					<div class="col-xs-12 col-lg-4 mb-3 text-right">

						<label>&nbsp;</label>

						<label>&nbsp;</label>
						<a style="    float: revert;width: 170px !important;"
						   href="<?= base_url() ?>excel/exportAllBaohiem?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
						   class="btn btn-primary w-100" target="_blank"><i
								class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
							Excel bảo hiểm
						</a>


						<button class="show-hide-total-all btn btn-success dropdown-toggle"
								onclick="$('#exportdulieu').toggleClass('show');">
							<span class="fa fa-file-excel-o"></span>
						</button>

						<ul id="exportdulieu" class="dropdown-menu dropdown-menu-right"
							style="padding:10px;min-width:250px;">

							<li class="form-group">
								<a
									href="<?= base_url() ?>excel/exportKpiCvkd?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
									target="_blank"><i
										class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
									Export hoa hồng CVKD
								</a>
							</li>
							<li class="form-group">
								<a
									href="<?= base_url() ?>excel/exportKpiPGD?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
									target="_blank"><i
										class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
									Export hoa hồng PGD
								</a>
							</li>
							<li class="form-group">
								<a
									href="<?= base_url() ?>excel/exportKpiASM?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
									target="_blank"><i
										class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
									Export hoa hồng ASM
								</a>
							</li>
							<li class="form-group">
								<a
									href="<?= base_url() ?>excel/exportKpiRSM?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
									target="_blank"><i
										class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
									Export hoa hồng RSM
								</a>
							</li>
							<li class="form-group">
								<a
									href="<?= base_url() ?>excel/exportAllDuNo?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
									target="_blank"><i
										class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
									Excel gốc còn lại
								</a>
							</li>
							<p>== BC gốc còn lại T+10 (Không tính BĐS) ==</p>
							<li class="form-group">
								<a
									href="<?= base_url() ?>excel/exportPGD_NIN_BDS?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
									target="_blank"><i
										class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
									Excel gốc còn lại T+10 PGD
								</a>
							</li>
							<li class="form-group">
								<a
									href="<?= base_url() ?>excel/exportUser_NIN_BDS?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
									target="_blank"><i
										class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
									Excel gốc còn lại T+10 GDV
								</a>
							</li>


						</ul>


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
				<div class="dashboard-right-sys">

					<?php
					if (!function_exists('contract_status')) {
						function contract_status($status = null)
						{
							$result = '';
							$leadstatus = [
								1 => "Mới",
								2 => "Chờ trưởng PGD duyệt",
								3 => "Đã hủy",
								4 => "Trưởng PGD không duyệt",
								5 => "Chờ hội sở duyệt",
								6 => "Đã duyệt",
								7 => "Kế toán không duyệt",
								8 => "Hội sở không duyệt",
								9 => "Chờ ngân lượng xử lý",
								10 => "Giải ngân ngân lượng thất bại",
								11 => "Chờ TP quản lý hợp đồng vay duyệt gia hạn",
								12 => "Chờ TP quản lý hợp đồng vay duyệt cơ cấu",
								13 => "TP quản lý hợp đồng vay không duyệt gia hạn",
								14 => "TP quản lý hợp đồng vay không duyệt cơ cấu",
								15 => "Chờ giải ngân",
								16 => "Đã tạo lệnh giải ngân thành công",
								17 => "Đang vay",
								18 => "Giải ngân thất bại",
								19 => "Đã tất toán",
								20 => "Đã quá hạn",
								21 => "Chờ trưởng PGD duyệt gia hạn",
								22 => "Trưởng PGD không duyệt gia hạn",
								23 => "Chờ trưởng PGD duyệt cơ cấu",
								24 => "Trưởng PGD không duyệt cơ cấu",
								25 => "Chờ hội sở duyệt gia hạn",
								26 => "Hội sở không duyệt gia hạn",
								27 => "Chờ hội sở duyệt cơ cấu",
								28 => "Hội sở không duyệt cơ cấu",
								29 => "Chờ tạo phiếu thu gia hạn",
								30 => "Chờ ASM duyệt gia hạn",
								31 => "Chờ tạo phiếu thu cơ cấu",
								32 => "Chờ ASM duyệt cơ cấu",
								33 => "Đã gia hạn",
								34 => "Đã cơ cấu",
								35 => "Chờ ASM duyệt",
								36 => "ASM không duyệt",
								37 => "Chờ thanh lý",
								38 => "Chờ CEO duyệt thanh lý",
								39 => "Chờ TP THN xác nhận thanh lý",
								40 => "Đã thanh lý",
								41 => "ASM không duyệt gia hạn",
								42 => "ASM không duyệt cơ cấu",
								43 => "CEO không duyệt thanh lý xe"
							];
							if ($status === null) return $leadstatus;
							foreach ($leadstatus as $key => $item) {
								if ($key == $status) {
									$result = $item;
								}
							}
							return $result;
						}
					}
					$tong_kpi = 0;
					$du_no_tang_net = 0;
					$total_baohiem = 0;
					$giai_ngan = 0;
					$bao_hiem = 0;

					foreach ($data_area as $key => $kpi) {
						if ($kpi->name == "Priority" || $kpi->name == "NextPay") {
							continue;
						}
						if (!empty($kpi->kpi->giai_ngan_CT)) {
							$giai_ngan_CT += $kpi->kpi->giai_ngan_CT;
						}
						if (!empty($kpi->kpi->bao_hiem_CT)) {
							$bao_hiem_ct += $kpi->kpi->bao_hiem_CT;
						}
						if (!empty($kpi->kpi->du_no_CT)) {
							$du_no_CT += $kpi->kpi->du_no_CT;
						}
						if (!empty($kpi->kpi->nha_dau_tu)) {
							$nha_dau_tu_CT += $kpi->kpi->nha_dau_tu;
						}

					}

					if (!empty($giai_ngan_CT) && $giai_ngan_CT != 0) {
						$du_no = round(($data->total_du_no_trong_han_t10 / $du_no_CT) * $kpi->kpi->du_no_TT);
					}
					if (!empty($bao_hiem_ct) && $bao_hiem_ct != 0) {
						$bao_hiem = round(($data->total_doanh_so_bao_hiem / $bao_hiem_ct) * $kpi->kpi->bao_hiem_TT);
					}
					if (!empty($giai_ngan_CT) && $giai_ngan_CT != 0) {
						$giai_ngan = round(($data->total_so_tien_vay / $giai_ngan_CT) * $kpi->kpi->giai_ngan_TT);
					}
					if (!empty($nha_dau_tu_CT) && $nha_dau_tu_CT != 0) {
						$nha_dau_tu = round(($data->total_nha_dau_tu / $nha_dau_tu_CT) * $kpi->kpi->nha_dau_tu_TT);
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

					$tong_kpi = $giai_ngan + $bao_hiem + $du_no + $nha_dau_tu;

					$total_tien_hoa_hong = 0;
					if (!empty($tong_kpi)) {
						if ($tong_kpi >= 80 && $tong_kpi < 90) {
							$total_tien_hoa_hong = 13000000 + $data->tien_hoa_hong_nha_dau_tu;
						} elseif ($tong_kpi >= 90 && $tong_kpi < 95) {
							$total_tien_hoa_hong = 16000000 + $data->tien_hoa_hong_nha_dau_tu;
						} elseif ($tong_kpi >= 95 && $tong_kpi < 110) {
							$total_tien_hoa_hong = 18000000 + $data->tien_hoa_hong_nha_dau_tu;
						} elseif ($tong_kpi >= 110) {
							$total_tien_hoa_hong = 20000000 + $data->tien_hoa_hong_nha_dau_tu;
						} else {
							$total_tien_hoa_hong = $data->tien_hoa_hong_nha_dau_tu;
						}
					}

					?>
					<div class="row">
						<div class="col-xs-12 col-md-3">
							<div class="left_wiget-bar">

								<?php
								if (in_array("giam-doc-kinh-doanh", $groupRoles)) { ?>
								<div class="const_box_show">
									<div class="left_box">
										<h5>
											Tổng tiền hoa hồng
										</h5>
										<p>
											<?= !empty($total_tien_hoa_hong) ? number_format($total_tien_hoa_hong) : 0 ?>
										</p>
									</div>
								</div>
								<?php } ?>

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
											Gốc còn lại tăng nét T+10
										</h5>
										<p>
											<?= (!empty($data->total_du_no_trong_han_t10)) ? number_format($data->total_du_no_trong_han_t10) : 0 ?>
										</p>
									</div>
								</div>
								<?php
								if ($userSession['email'] == "hailm@tienngay.vn" || $userSession['email'] == "manhld@tienngay.vn") { ?>
									<div class="const_box_show">
										<div class="left_box">
											<h5>
												Gốc còn lại tăng net
											</h5>
											<p>
												<?= (!empty($data->du_no_tang_net)) ? number_format($data->du_no_tang_net) : 0 ?>
											</p>
										</div>
									</div>
								<?php } ?>


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
								<div class="col-xs-12 col-md-4 chart_left">
									<div class="chart_left_box">
										<style>
											.tooltip * {
												background: #005f57 !important;
											}
										</style>
										<div class="title">
											<h3 title="Chỉ tiêu giải ngân: <?= number_format($giai_ngan_CT) ?> | Chỉ tiêu gốc còn lại trong hạn tăng net: <?= number_format($du_no_CT) ?> | Chỉ tiêu bảo hiểm: <?= number_format($bao_hiem_ct)?> | Chỉ tiêu NĐT: <?= number_format($nha_dau_tu_CT)?>"
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
										<a class="btn btn_create_kpi" data-toggle="modal"
										   href="<?= base_url() ?>kpi/listKPI_area" target="_blank">
											Tạo KPI mới
										</a>
									</div>
								</div>

								<div class="col-xs-12 col-md-8">
									<div class="right_wiget-bar">
										<div class="title">
											<h3 style="color: #0CA678">
												Tỉ lệ hoàn thành KPI khu vực
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
											//var_dump($data_area);
											$arr_kpi_vung = [];
											$arr_view_sort = [];
											foreach ($data_area as $key => $kpi) {
												$giai_ngan = 0;
												$bao_hiem = 0;
												$du_no = 0;
												$nha_dau_tu = 0;
												if (in_array("giam-doc-kinh-doanh", $groupRoles) && ($kpi->name == "Priority" || $kpi->name == "NextPay")) {
													continue;
												}

												if (!empty($kpi->kpi->giai_ngan_CT))
													$giai_ngan = round(($kpi->giai_ngan / $kpi->kpi->giai_ngan_CT) * $kpi->kpi->giai_ngan_TT);
												if (!empty($kpi->kpi->bao_hiem_CT))
													$bao_hiem = round(($kpi->bao_hiem / $kpi->kpi->bao_hiem_CT) * $kpi->kpi->bao_hiem_TT);
												if (!empty($kpi->kpi->du_no_CT))
													$du_no = round(($kpi->du_no_tang_net / $kpi->kpi->du_no_CT) * $kpi->kpi->du_no_TT);
												if (!empty($kpi->kpi->nha_dau_tu))
													$nha_dau_tu = round(($kpi->nha_dau_tu / $kpi->kpi->nha_dau_tu) * $kpi->kpi->nha_dau_tu_TT);

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

												$name = $kpi->name;

												$giai_ngan = is_numeric($giai_ngan) ? $giai_ngan : 0;
												$bao_hiem = is_numeric($bao_hiem) ? $bao_hiem : 0;
												$du_no = is_numeric($du_no) ? $du_no : 0;
												$nha_dau_tu = is_numeric($nha_dau_tu) ? $nha_dau_tu : 0;

												$arr_kpi_vung += ["$tong" => "$name"];
												$arr_view_sort += ["$name" => "$tong"];


											}
											arsort($arr_view_sort)
											?>

											<?php foreach ($arr_view_sort as $key_sort => $area_sort): ?>
												<?php foreach ($data_area as $item): ?>
													<?php if ($key_sort == $item->name): ?>
														<a target="_blank" class="item_child"
														   href="<?php echo base_url(); ?>kpi/detail_code_area_dashboard?code_area=<?= !empty($item->kpi->area->code) ? $item->kpi->area->code : '' ?>">
															<div class="item_bar">
																<?php
																$giai_ngan = 0;
																$bao_hiem = 0;
																$du_no = 0;
																$nha_dau_tu = 0;
																if (in_array("giam-doc-kinh-doanh", $groupRoles) && ($kpi->name == "Priority" || $kpi->name == "NextPay")) {
																	continue;
																}

																if (!empty($item->kpi->giai_ngan_CT))
																	$giai_ngan = round(($item->giai_ngan / $item->kpi->giai_ngan_CT) * $item->kpi->giai_ngan_TT);
																if (!empty($item->kpi->bao_hiem_CT))
																	$bao_hiem = round(($item->bao_hiem / $item->kpi->bao_hiem_CT) * $item->kpi->bao_hiem_TT);
																if (!empty($item->kpi->du_no_CT))
																	$du_no = round(($item->du_no_tang_net / $item->kpi->du_no_CT) * $item->kpi->du_no_TT);
																if (!empty($item->kpi->nha_dau_tu))
																	$nha_dau_tu = round(($item->nha_dau_tu / $item->kpi->nha_dau_tu) * $item->kpi->nha_dau_tu_TT);

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

																$name = $item->name;

																$giai_ngan = is_numeric($giai_ngan) ? $giai_ngan : 0;
																$bao_hiem = is_numeric($bao_hiem) ? $bao_hiem : 0;
																$du_no = is_numeric($du_no) ? $du_no : 0;
																$nha_dau_tu = is_numeric($nha_dau_tu) ? $nha_dau_tu : 0;
																?>
																<span> <?= $item->name ?></span>
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
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endforeach; ?>

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
														<a style="color:#F59F00" target="_blank" href="#"
														   class="text-dark">
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
						<a target="_blank" class="btn_href" id="href" href="">Xem chi tiết</a>
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


	<div class="modal" id="modal_setup_kpi" hidden>
		<div class="modal_content">
			<header class="w3-container w3-teal">
				<span class="w3-button w3-display-topright" data-dismiss="modal">&times;</span>
				<h2>Thông báo Set KPI tháng <?= date('m') ?></h2>
			</header>
			<div class="w3-container body">
				<p>Vui lòng cài đặt KPI khu vực</p>
			</div>
			<div class="modal-footer_kpi">
				<a target="_blank" type="button"
				   style="margin-bottom: 0;font-size: 15px; background-color: white; color: black"
				   class="btn btn-secondary" id="setup_kpi">Cài đặt KPI</a>
			</div>
		</div>
	</div>

	<style>
		.modal_content {
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

		.w3-teal h2 {
			margin: 0;
		}

		.w3-container.body {
			padding: 15px;
			font-size: 16px;
		}

		.modal-footer_kpi {
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

		function show_kpi_pgd(thiz) {
			let kpi = $(thiz).data("kpi");
			let fdate = $(thiz).data("fdate");

			console.log(kpi)
			$.ajax({
				url: _url.base_url + 'kpi/detail_code_area_dashboard?code_area%5B%5D=' + kpi,
				type: "POST",
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();

					console.log(11111)

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
				$.ajax({
					url: _url.base_url + 'exemptions/push_noti_api',
					type: "POST",
					dataType: 'json',
					processData: false,
					contentType: false,
					success: function (data) {
						console.log(data)
						if (data.code == 200) {

							$('#modal_setup_kpi').modal("show");
							$('#setup_kpi').attr("href", "<?php echo base_url(); ?>" + data.click_action);
						}
						$('#thongbaoModal_0').modal('hidden');

					},

				});


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


	<style>
		.dropdown-menu > li > a {
			color: #000;
			font-size: 14px;
		}

		.dropdown-menu > li > a {
			padding: 0;
		}

		.form-group {
			margin-bottom: 7px;
			border-bottom: 1px dashed;
			padding-bottom: 7px;
		}

		.form-group:last-child {
			margin-bottom: 0;
		}

		.dropdown-menu {
			border: 1px solid #323436;
		}
	</style>
