<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<?php
$search_thn = !empty($_GET['search_thn']) ? $_GET['search_thn'] : "";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
?>

<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>


<!--	Search-->
  	<div class="right-col_show">
		<button class="show-hide-total-all btn btn-success dropdown-toggle left_col  pull-right"
				onclick="$('#lockdulieu').toggleClass('show');" id="btn">
			<span class="fa fa-search"></span>
		</button>
		<button class="show-hide-total-all btn btn-success dropdown-toggle pull-right"
				onclick="$('#exportdulieu').toggleClass('show');">
			<span class="fa fa-file-excel-o"></span>
		</button>

		<ul id="exportdulieu" class="dropdown-menu dropdown-menu-right"
			style="padding:10px;min-width:250px;">

			<li class="form-group">
				<a
					href="<?= base_url() ?>excel/export_kpi_call_b0b1?fdate=<?= $fdate ?>"
					target="_blank"><i
						class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Export Kpi Call B0-B3
				</a>
				<a
					href="<?= base_url() ?>excel/export_kpi_leader_call_b0b3?fdate=<?= $fdate ?>"
					target="_blank"><i
						class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Export Kpi Leader Call B0-B3
				</a>
				<a
					href="<?= base_url() ?>excel/export_kpi_field_b1b3?fdate=<?= $fdate ?>"
					target="_blank"><i
						class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Export Kpi Field B1-B3
				</a>
				<a
					href="<?= base_url() ?>excel/export_kpi_field_b4?fdate=<?= $fdate ?>"
					target="_blank"><i
						class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Export Kpi Field B4+
				</a>
				<a
					href="<?= base_url() ?>excel/export_kpi_leader_field?fdate=<?= $fdate ?>"
					target="_blank"><i
						class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Export Kpi Leader Field
				</a>
				<a
					href="<?= base_url() ?>excel/export_kpi_thn_all?fdate=<?= $fdate ?>"
					target="_blank"><i
						class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Export Kpi Toàn Phòng
				</a>
				<a
					href="<?= base_url() ?>excel/export_contest?fdate=<?= $fdate ?>"
					target="_blank"><i
						class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Export Thưởng Contest
				</a>
				<a
					href="<?= base_url() ?>excel/export_tong_thuong_thang?fdate=<?= $fdate ?>"
					target="_blank"><i
						class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Export Tổng thưởng tháng
				</a>
			</li>




		</ul>
		<form action="<?php echo base_url('dashboard_thn/view_dashboard_thn') ?>" method="get">
			<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
				style="padding:15px;min-width:250px;">

				<li class="form-group">
					<div class="row">
						<div class="col-xs-12 col-md-8">
						<div class="input-group">
							<input type="month" name="fdate" class="form-control"
								   value="<?= !empty($fdate) ? $fdate : date('Y-m') ?>">
						</div>
						</div>
						<div class="col-xs-12 col-md-2">
						<button class="btn btn-info btn-success" type="submit">
							<i class="fa fa-search" aria-hidden="true"></i>
							Tìm Kiếm
						</button>
						</div>

					</div>
				</li>

			</ul>
		</form>
		<style>
			.right-col_show{
				position: relative;
			}
			#lockdulieu{
				top: 100%;
			}
		</style>
	</div>


	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="dashboard-right-sys">
				<div class="row">
					<div class="col-md-3">
						<div class="left_wiget-bar">
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng gốc còn lại được giao
									</h5>
									<p>
										<?= !empty($tong_du_no_duoc_giao) ? number_format($tong_du_no_duoc_giao) : 0 ?>
									</p>
								</div>

							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng gốc còn lại B0 - B3
									</h5>
									<p>
										<?= !empty($tong_du_no_duoc_giao_b1b3) ? number_format($tong_du_no_duoc_giao_b1b3) : 0 ?>
									</p>
								</div>
							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng gốc còn lại B4 +
									</h5>
									<p>
										<?= !empty($tong_du_no_duoc_giao_field_b4) ? number_format($tong_du_no_duoc_giao_field_b4) : 0 ?>
									</p>
								</div>
							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng gốc còn lại thu được
									</h5>
									<p>
										<?= !empty($tong_du_no_thu_duoc) ? number_format($tong_du_no_thu_duoc) : 0 ?>
									</p>
								</div>

							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng tiền thu được
									</h5>
									<p>
										<?= !empty($tong_tien_thu_duoc) ? number_format($tong_tien_thu_duoc) : 0 ?>
									</p>
								</div>

							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng tiền hoa hồng
									</h5>
									<p>
										<?= !empty($tong_tien_hoa_hong) ? number_format($tong_tien_hoa_hong) : 0 ?>
									</p>
								</div>

							</div>


						</div>
					</div>
					<div class="col-md-9">
						<div class="row" style="margin-bottom: 24px;">
							<div class="col-md-4 ">

								<div class="chart_left" style="height: 100%">
									<div class="chart_left_box">

										<div class="title">
											<h3>
												Tỉ lệ hoàn thành KPI
											</h3>
										</div>
										<div class="card">
											<canvas id="DanhSachHopDong1" height="359" width="359" style="margin: auto; display: block; height: auto; width: 300px;">
											</canvas>
											<div class="chart-center">
												<span><?= !empty($kpi_tp_thn) ? number_format($kpi_tp_thn,2) : 0 ?>%</span>
											</div>
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
															<?php
															$kpi_number = 0;
															if ( !empty($kpi_tp_thn) && $kpi_tp_thn < 100){
																$kpi_number = 100 - $kpi_tp_thn;
															}
															?>
															datasets: [{
																data: [<?= $kpi_number ?>,<?= !empty($kpi_tp_thn) ? number_format($kpi_tp_thn,2) : 0 ?>],
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




										<a target="_blank" class="btn btn_create_kpi" data-toggle="modal"
										   href="<?php echo base_url(); ?>dashboard_thn/setup_kpi_thn">
											Tạo KPI mới
										</a>
									</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="right_wiget-bar total_duno">
									<div class="title">
										<h3 style="color: #0E4D20">
											Tổng gốc còn lại đã giao
										</h3>

										<div class="note">
											<div class="example">
												<div class="bg_exam">
													<div class="bg_exam_box bg_green"></div>
													Đã thu
												</div>
												<div class="bg_exam">
													<div class="bg_exam_box bg_pink"></div>
													Còn lại
												</div>
											</div>
										</div>

									</div>
									<div class="line_bar_list">

										<div class="item_child">
											<div class="title_total">
												<span>Nhóm Call</span>
											</div>
											<div class="item_bar">
												<span>
													Nhóm B0 - B3
													<span style="float: right;">
														<a style="color: #0E9549"><?= number_format($tong_du_no_thu_duoc_b0b3) ?></a> | <a
															style="color: #EBD1D1"><?= !empty($tong_du_no_thu_duoc_b0b3) ? number_format($tong_du_no_duoc_giao_b0b3 - $tong_du_no_thu_duoc_b0b3) : 0 ?></a>
													</span>
												</span>
												<div class="bar_horizontal">
													<div
														style="width: <?= ($tong_du_no_duoc_giao_b0b3 != 0) ? (($tong_du_no_thu_duoc_b0b3) / $tong_du_no_duoc_giao_b0b3) * 100 : 0 ?>%;"
														class="bar_horizontal_child"></div>

												</div>
												<div class="const_percent">
													<span><?= !empty($tong_du_no_duoc_giao_b0b3) ? number_format($tong_du_no_duoc_giao_b0b3) : 0 ?></span>
												</div>
											</div>

										</div>
										<div class="item_child">
											<div class="title_total">
												<span>Nhóm Field</span>
											</div>
											<div class="item_bar">
												<span>
													Nhóm B1 - B3

													<span style="float: right;">
														<a style="color: #0E9549"><?= !empty($tong_du_no_thu_duoc_field_b1b3) ? number_format($tong_du_no_thu_duoc_field_b1b3) : 0 ?></a> | <a
															style="color: #EBD1D1"><?= !empty($tong_du_no_thu_duoc_field_b1b3) ? number_format($tong_du_no_duoc_giao_field_b1b3 - $tong_du_no_thu_duoc_field_b1b3) : 0 ?></a>
													</span>

												</span>
												<div class="bar_horizontal">
													<div
														style="width: <?= $tong_du_no_duoc_giao_field_b1b3 != 0 ? (($tong_du_no_thu_duoc_field_b1b3) / $tong_du_no_duoc_giao_field_b1b3) * 100 : 0 ?>%;"
														class="bar_horizontal_child"></div>
												</div>
												<div class="const_percent">
													<span><?= !empty($tong_du_no_duoc_giao_field_b1b3) ? number_format($tong_du_no_duoc_giao_field_b1b3) : 0 ?></span>
												</div>
											</div>

											<div class="item_bar">
												<span>
													Nhóm B4+

													<span style="float: right;">
														<a style="color: #0E9549"><?= !empty($tong_du_no_thu_duoc_field_b4) ? number_format($tong_du_no_thu_duoc_field_b4) : 0 ?></a> | <a
															style="color: #EBD1D1"><?= !empty($tong_du_no_duoc_giao_field_b4) ? number_format($tong_du_no_duoc_giao_field_b4 - $tong_du_no_thu_duoc_field_b4) : 0 ?></a>
													</span>

												</span>
												<div class="bar_horizontal">
													<div
														style="width: <?= $tong_du_no_duoc_giao_field_b4 != 0 ? number_format(($tong_du_no_thu_duoc_field_b4 / $tong_du_no_duoc_giao_field_b4) * 100) : 0 ?>%;"
														class="bar_horizontal_child"></div>

												</div>
												<div class="const_percent">
													<span><?= !empty($tong_du_no_duoc_giao_field_b4) ? number_format($tong_du_no_duoc_giao_field_b4) : 0 ?></span>
												</div>
											</div>

										</div>
										<div class="item_bar">
												<span>
													<a style="font-weight: bold; color: black">Tổng</a>
													<span style="float: right;">
														<a style="color: #0E9549"><?= number_format($tong_du_no_thu_duoc_field_b4 + $tong_du_no_thu_duoc_field_b1b3 + $tong_du_no_thu_duoc_b0b3) ?></a> | <a
															style="color: #EBD1D1"><?= number_format($tong_du_no_duoc_giao - ($tong_du_no_thu_duoc_field_b4 + $tong_du_no_thu_duoc_field_b1b3 + $tong_du_no_thu_duoc_b0b3)) ?></a>
													</span>
												</span>


											<div class="bar_horizontal">
												<div
													style="width: <?= $tong_du_no_duoc_giao != 0 ? number_format((($tong_du_no_thu_duoc_field_b4 + $tong_du_no_thu_duoc_field_b1b3 + $tong_du_no_thu_duoc_b0b3) / $tong_du_no_duoc_giao) * 100) : 0 ?>%;"
													class="bar_horizontal_child"></div>
											</div>
											<div class="const_percent">
												<span><?= !empty($tong_du_no_duoc_giao) ? number_format($tong_du_no_duoc_giao) : 0 ?></span>
											</div>

										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="row" style="margin-bottom: 20px;">

							<div class="col-md-4">

								<div class="right_wiget-bar">
									<div class="title">
										<h3 style="color: #0CA678">
											Tỉ lệ hoàn thành KPI
										</h3>
									</div>


									<ul class="nav tabs tabss">
										<li data-tab="waitting" class="aos-init aos-animate in active"
											data-aos-delay="1500" data-offset="1500" data-aos-duration="1500"
											data-aos="fade-right">
											<a>
												<h3 class="qt_title">Nhóm Call</h3>
											</a>
										</li>

										<li data-tab="Field-b4" class="aos-init aos-animate" data-aos-delay="1500"
											data-offset="1500" data-aos-duration="1700" data-aos="fade-right">
											<a>
												<h3 class="qt_title">Nhóm Field </h3>
											</a>
										</li>

										<li data-tab="return" class="aos-init aos-animate" data-aos-delay="1500"
											data-offset="1500" data-aos-duration="1700" data-aos="fade-right">
											<a>
												<h3 class="qt_title">Nhóm Field b4+</h3>
											</a>
										</li>
									</ul>

									<div class="tab-contents">
										<div id="waitting" class="tab-panel  aos-init aos-animate active"
											 data-aos-delay="1500" data-offset="1500" data-aos-duration="1600"
											 data-aos="fade-up-down">
											<div class="line_bar_list">
												<?php if (!empty($kpi_call)): ?>
													<?php foreach ($kpi_call as $value): ?>
														<div class="item_child">
															<div class="item_bar">
																<span><?= !empty($value->email) ? $value->email : "" ?></span>
																<div class="bar_horizontal">
																	<div
																		style="width: <?= !empty($value->kpis) ? $value->kpis : "" ?>%;background: #17A2B8;"
																		class="bar_horizontal_child"></div>
																</div>
															</div>
															<div class="const_percent" style="color: #17A2B8">
																<span><?= !empty($value->kpis) ? number_format($value->kpis, 2) : 0 ?>%</span>
															</div>
														</div>
													<?php endforeach; ?>
												<?php endif; ?>


											</div>
											<div class="footer_bar">
												<div class="title_footer">
													<span>Tổng kết</span>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top plus">
																Cao nhất
															</div>
															<?php $count = 1; ?>
															<?php if (!empty($kpi_call_top)): ?>
																<?php foreach ($kpi_call_top as $key => $value): ?>
																	<?php if ($count == count((array)($kpi_call_top))): ?>
																		<div class="percent-data">
																			<div class="percent_place">
																				<?= !empty($key) ? $key : "" ?>
																			</div>
																			<div class="percent_kpi plus">
																				<?= !empty($value) ? number_format($value, 2) : 0 ?>
																				%
																			</div>
																		</div>
																	<?php endif; ?>
																	<?php $count++ ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top minus">
																Thấp nhất
															</div>
															<?php if (!empty($kpi_call_top)): ?>
																<?php foreach ($kpi_call_top as $key => $value): ?>
																	<div class="percent-data">
																		<div class="percent_place">
																			<?= !empty($key) ? $key : "" ?>
																		</div>
																		<div class="percent_kpi minus">
																			<?= !empty($value) ? number_format($value, 2) : 0 ?>
																			%
																		</div>
																	</div>
																	<?php break; ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="Field-b4" class="tab-panel">
											<div class="line_bar_list">
												<?php if (!empty($kpi_field)): ?>
													<?php foreach ($kpi_field as $value): ?>
														<div class="item_child">
															<div class="item_bar">
																<span><?= !empty($value->email) ? $value->email : "" ?></span>
																<div class="bar_horizontal">
																	<div
																		style="width: <?= !empty($value->kpis) ? $value->kpis : "" ?>%;background: #17A2B8;"
																		class="bar_horizontal_child"></div>
																</div>
															</div>
															<div class="const_percent" style="color: #17A2B8">
																<span><?= !empty($value->kpis) ? number_format($value->kpis, 2) : 0 ?>%</span>
															</div>
														</div>
													<?php endforeach; ?>
												<?php endif; ?>


											</div>
											<div class="footer_bar">
												<div class="title_footer">
													<span>Tổng kết</span>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top plus">
																Cao nhất
															</div>
															<?php $count = 1; ?>
															<?php if (!empty($kpi_field_top)): ?>
																<?php foreach ($kpi_field_top as $key => $value): ?>
																	<?php if ($count == count((array)($kpi_field_top))): ?>
																		<div class="percent-data">
																			<div class="percent_place">
																				<?= !empty($key) ? $key : "" ?>
																			</div>
																			<div class="percent_kpi plus">
																				<?= !empty($value) ? number_format($value, 2) : 0 ?>
																				%
																			</div>
																		</div>
																	<?php endif; ?>
																	<?php $count++ ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top minus">
																Thấp nhất
															</div>
															<?php if (!empty($kpi_field_top)): ?>
																<?php foreach ($kpi_field_top as $key => $value): ?>
																	<div class="percent-data">
																		<div class="percent_place">
																			<?= !empty($key) ? $key : "" ?>
																		</div>
																		<div class="percent_kpi minus">
																			<?= !empty($value) ? number_format($value, 2) : 0 ?>
																			%
																		</div>
																	</div>
																	<?php break; ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>

										</div>
										<div id="return" class="tab-panel">
											<div class="line_bar_list">
												<?php if (!empty($kpi_field_b4)): ?>
													<?php foreach ($kpi_field_b4 as $value): ?>
														<div class="item_child">
															<div class="item_bar">
																<span><?= !empty($value->email) ? $value->email : "" ?></span>
																<div class="bar_horizontal">
																	<div
																		style="width: <?= !empty($value->kpis) ? $value->kpis : "" ?>%;background: #17A2B8;"
																		class="bar_horizontal_child"></div>
																</div>
															</div>
															<div class="const_percent" style="color: #17A2B8">
																<span><?= !empty($value->kpis) ? number_format($value->kpis, 2) : 0 ?>%</span>
															</div>
														</div>
													<?php endforeach; ?>
												<?php endif; ?>


											</div>
											<div class="footer_bar">
												<div class="title_footer">
													<span>Tổng kết</span>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top plus">
																Cao nhất
															</div>
															<?php $count = 1; ?>
															<?php if (!empty($kpi_field_top_b4)): ?>
																<?php foreach ($kpi_field_top_b4 as $key => $value): ?>
																	<?php if ($count == count((array)($kpi_field_top_b4))): ?>
																		<div class="percent-data">
																			<div class="percent_place">
																				<?= !empty($key) ? $key : "" ?>
																			</div>
																			<div class="percent_kpi plus">
																				<?= !empty($value) ? number_format($value, 2) : 0 ?>
																				%
																			</div>
																		</div>
																	<?php endif; ?>
																	<?php $count++ ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top minus">
																Thấp nhất
															</div>
															<?php if (!empty($kpi_field_top_b4)): ?>
																<?php foreach ($kpi_field_top_b4 as $key => $value): ?>
																	<div class="percent-data">
																		<div class="percent_place">
																			<?= !empty($key) ? $key : "" ?>
																		</div>
																		<div class="percent_kpi minus">
																			<?= !empty($value) ? number_format($value, 2) : 0 ?>
																			%
																		</div>
																	</div>
																	<?php break; ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>


								</div>

							</div>
							<div class="col-md-8">
								<div class="right_wiget-bar">
									<div class="x_title">
										<h2>Tổng thực thu theo nhóm </h2>
										<div class="clearfix"></div>
									</div>
									<div class="">
										<div class="row">
											<div class="col-12 col-md-6 ">
												<div class="chartwrapper">
													<div class="doughnut_middledata">
														<span class="contract">Tổng</span>
														<br/><?= number_format($tong_du_no_thu_duoc_field_b4 + $tong_du_no_thu_duoc_field_b1b3 + $tong_du_no_thu_duoc_b0b3) ?>
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
																		"Nhóm B0",
																		"Nhóm B1",
																		"Nhóm B2",
																		"Nhóm B3",
																		"Nhóm B4",
																		"Nhóm B5",
																		"Nhóm B6",
																		"Nhóm B7",
																		"Nhóm B8"
																	],
																	datasets: [{
																		data: [
																			<?php if (!empty($total_thuc_thu)): ?>
																			<?php foreach ($total_thuc_thu as $value): ?>
																			<?php echo $value . ',' ?>
																			<?php endforeach; ?>
																			<?php endif; ?>
																		],
																		backgroundColor: [
																			"#0E9549", "#00B493", "#0054B6", "#0DCAF0", "#115C26", "#8600B6", "#FFC107", "#F76707", "#EC1E24"
																		],
																		hoverBackgroundColor: [
																			"#0E9549", "#00B493", "#0054B6", "#0DCAF0", "#115C26", "#8600B6", "#FFC107", "#F76707", "#EC1E24"
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
														<th scope="col">Danh sách nhóm </th>
														<th scope="col">Số tiền & Phần trăm (%)</th>
													</tr>
													</thead>
													<tbody>
													<?php if (!empty($total_thuc_thu)): ?>
														<?php
														$color = ['#0E9549', '#00B493', '#0054B6', '#0DCAF0', '#115C26', '#8600B6', '#FFC107', '#F76707', '#EC1E24'];
														$count = 0;
														?>
														<?php foreach ($total_thuc_thu as $key => $value): ?>
															<tr style="color:<?= $color[$count] ?>">
																<td>
																	<a style="color:<?= $color[$count] ?>"
																	   target="_blank"
																	   class="text-dark">
																		<i class="fa fa-square"></i> &nbsp; Nhóm
																		 <?= $key ?>
																	</a>
																</td>
																<td>
																	<?= number_format($value) ?> (
																	<i><?= $tong_du_no_thu_duoc_field_b4 + $tong_du_no_thu_duoc_field_b1b3 + $tong_du_no_thu_duoc_b0b3 != 0 ? number_format(($value / ($tong_du_no_thu_duoc_field_b4 + $tong_du_no_thu_duoc_field_b1b3 + $tong_du_no_thu_duoc_b0b3)) * 100) : 0 ?></i>%)
																</td>
																<td></td>
															</tr>
															<?php $count++ ?>
														<?php endforeach; ?>
													<?php endif; ?>
													</tbody>
												</table>


											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="row" style="margin-bottom: 20px;">
							<div class="col-12 col-md-6 ">
								<div class="right_wiget-bar total_duno">
									<div class="title ">
										<h3 style="color: #0CA678">
											Tăng trưởng cùng kỳ
										</h3>
									</div>
									<div class="row">
										<form method="get" action="<?php echo base_url('dashboard_thn/view_dashboard_thn') ?>">
										<div class="col-12 col-md-10">
											<select class="form-select form-control"
													aria-label="Default select example" name="search_thn">
												<option value="">Trưởng phòng</option>
												<?php if (!empty($all_arr)): ?>
												<?php foreach ($all_arr as $value): ?>
												<option value="<?= !empty($value) ? $value : '' ?>" <?= !empty($search_thn) && $search_thn == $value  ? "selected" : '' ?> ><?= !empty($value) ? $value : '' ?></option>
												<?php endforeach; ?>
												<?php endif; ?>
											</select>
										</div>

										<div class="col-12 col-md-2">
											<button type="submit" class="btn btn-success btn_search">
												Tìm kiếm
											</button>
										</div>
										</form>
									</div>
									<div class="chartwrapper">
										<canvas id="line-chart"></canvas>
									</div>
								</div>
								<script>
									var chartColors = {
										yellow: '#D4A106',
										green: '#0E9549'
									};

									var config = {
										type: 'bar',
										data: {
											labels: ["T1", "T2", "T3", "T4", "T5", "T6", "T7", "T8", "T9", "T10", "T11", "T12"],
											datasets: [{
												label: "",
												backgroundColor: chartColors.green,
												borderColor: chartColors.green,
												data: [
													<?php if (!empty($kpi_month)): ?>
													<?php foreach ($kpi_month as $value): ?>
													<?= number_format($value,2) . ',' ?>
													<?php endforeach; ?>
													<?php endif; ?>
												],
												fill: false,
											}]
										},
										options: {
											responsive: true,
											title: {
												display: true,
											},
											tooltips: {
												mode: 'label',
											},
											hover: {
												mode: 'nearest',
												intersect: true
											},
											scales: {
												xAxes: [{
													display: true,
													scaleLabel: {
														display: true,
														labelString: 'Tháng'
													}
												}],
												yAxes: [{
													display: true,
													scaleLabel: {
														display: true,
														labelString: 'Phần trăm (%)'
													}
												}]
											}
										}
									};


									var ctx = document.getElementById("line-chart").getContext("2d");
									window.myLine = new Chart(ctx, config);
								</script>
							</div>
							<div class="col-12 col-md-6 ">
								<div class="right_wiget-bar total_duno">
									<div class="title ">
										<h3 style="color: #0CA678">
											Tiền hoa hồng nhân viên
										</h3>
									</div>

									<ul class="nav tabs tabs_area">
										<li data-tab="call" class="aos-init aos-animate in active"
											data-aos-delay="1500" data-offset="1500" data-aos-duration="1500"
											data-aos="fade-right">
											<a>
												<h3 class="qt_title">Nhóm Call</h3>
											</a>
										</li>
										<li data-tab="field" class="aos-init aos-animate" data-aos-delay="1500"
											data-offset="1500" data-aos-duration="1700" data-aos="fade-right">
											<a>
												<h3 class="qt_title">Nhóm Field</h3>
											</a>
										</li>
									</ul>


									<div class="tab-contents">
										<div id="field" class="tab-panels "
											 data-aos-delay="1500" data-offset="1500" data-aos-duration="1600"
											 data-aos="fade-up-down">


											<canvas id="myChart_field" style="width:100%;max-width:600px"></canvas>

											<script>
												<?php if(!empty($arr_field_price)): ?>
												var xValues = [<?php foreach ($arr_field_price as $item): ?><?= "'$item->email'".',' ?><?php endforeach; ?>];
												var yValues = [<?php foreach ($arr_field_price as $item): ?><?= $item->price.',' ?><?php endforeach; ?>];
												var barColors = [<?php foreach ($arr_field_price as $item): ?><?= "'#0E9549'".',' ?><?php endforeach; ?>];
												<?php endif; ?>
												new Chart("myChart_field", {
													type: "horizontalBar",
													data: {
														labels: xValues,
														datasets: [{
															backgroundColor: barColors,
															data: yValues
														}]
													},
													options: {
														legend: {display: false},
														title: {
															display: true,
															text: ""
														}
													}
												});
											</script>

											<div class="footer_bar">
												<div class="title_footer">
													<span>Tổng kết</span>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top plus">
																Cao nhất
															</div>
															<?php $count = 1; ?>
															<?php if (!empty($arr_field_price_top)): ?>
																<?php foreach ($arr_field_price_top as $key => $value): ?>
																	<?php if ($count == count((array)($arr_field_price_top))): ?>
																		<div class="percent-data">
																			<div class="percent_place">
																				<?= !empty($key) ? $key : "" ?>
																			</div>
																			<div class="percent_kpi plus">
																				<?= !empty($value) ? number_format($value) : 0 ?>
																				vnđ
																			</div>
																		</div>
																	<?php endif; ?>
																	<?php $count++ ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top minus">
																Thấp nhất
															</div>
															<?php if (!empty($arr_field_price_top)): ?>
																<?php foreach ($arr_field_price_top as $key => $value): ?>
																	<div class="percent-data">
																		<div class="percent_place">
																			<?= !empty($key) ? $key : "" ?>
																		</div>
																		<div class="percent_kpi minus">
																			<?= !empty($value) ? number_format($value ) : 0 ?>
																			vnđ
																		</div>
																	</div>
																	<?php break; ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="call" class="tab-panels  aos-init aos-animate active">
											<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

											<script>
												<?php if(!empty($arr_call_price)): ?>
												var xValues = [<?php foreach ($arr_call_price as $item): ?><?= "'$item->email'".',' ?><?php endforeach; ?>];
												var yValues = [<?php foreach ($arr_call_price as $item): ?><?= $item->price.',' ?><?php endforeach; ?>];
												var barColors = [<?php foreach ($arr_call_price as $item): ?><?= "'#0E9549'".',' ?><?php endforeach; ?>];
												<?php endif; ?>
												new Chart("myChart", {
													type: "horizontalBar",
													data: {
														labels: xValues,
														datasets: [{
															backgroundColor: barColors,
															data: yValues
														}]
													},
													options: {
														legend: {display: false},
														title: {
															display: true,
															text: ""
														}
													}
												});
											</script>
											<div class="footer_bar">
												<div class="title_footer">
													<span>Tổng kết</span>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top plus">
																Cao nhất
															</div>
															<?php $count = 1; ?>
															<?php if (!empty($arr_call_price_top)): ?>
																<?php foreach ($arr_call_price_top as $key => $value): ?>
																	<?php if ($count == count((array)($arr_call_price_top))): ?>
																		<div class="percent-data">
																			<div class="percent_place">
																				<?= !empty($key) ? $key : "" ?>
																			</div>
																			<div class="percent_kpi plus">
																				<?= !empty($value) ? number_format($value) : 0 ?>
																				vnđ
																			</div>
																		</div>
																	<?php endif; ?>
																	<?php $count++ ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>
													<div class="col-md-12">
														<div class="hight_percent">
															<div class="top minus">
																Thấp nhất
															</div>
															<?php if (!empty($arr_call_price_top)): ?>
																<?php foreach ($arr_call_price_top as $key => $value): ?>
																	<div class="percent-data">
																		<div class="percent_place">
																			<?= !empty($key) ? $key : "" ?>
																		</div>
																		<div class="percent_kpi minus">
																			<?= !empty($value) ? number_format($value) : 0 ?>
																			vnđ
																		</div>
																	</div>
																	<?php break; ?>
																<?php endforeach; ?>
															<?php endif; ?>
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


			</div>

		</div>
	</div>
</div>
<link href="<?php echo base_url(); ?>assets/home/css/dashboard_kd.css" rel="stylesheet">
<script type="text/javascript">
	$('ul.tabss li').click(function () {
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
</script>
<style>
	.total_duno .item_child {
		display: block;
		overflow: hidden;
	}

	.total_duno .item_bar {
		width: calc(100% - 120px);
		position: relative;
	}

	.total_duno .bar_horizontal,
	.total_duno .bar_horizontal_child {
		height: 20px;
		border-radius: 0 !important;
	}

	.total_duno .bar_horizontal {
		background: #EBD1D1;
		color: #525252
	}

	.total_duno .bar_horizontal_child {
		color: #fff;
		background: #0E9549;
		margin-right: 50px;
		text-align: center;
	}

	.title_total {
		position: relative;
		overflow: hidden;
	}

	.title_total span {
		font-weight: 600;
		font-size: 15px;
		display: inline-block;
		margin-bottom: 10px;
	}

	.title_total span:after {
		content: "";
		position: absolute;
		top: 10px;
		width: 100%;
		height: 1px;
		background: #d9d9d9;
		margin-left: 10px;
	}

	.total_duno .item_bar .const_percent span {
		color: #EC1E24
	}

	.total_duno .const_percent {
		position: absolute;
		right: -120px;
		top: 25px;
		z-index: 99;
	}

	.line_bar_list {
		height: auto;
	}

	.chartwrapper .doughnut_middledata {
		font-size: 18px;
	}

	ul.nav.tabs {
		border-bottom: unset;
		width: 100%;
	}

	.bg_exam {
		display: flex;
		align-items: center;
		float: left;
		margin-right: 10px;
	}

	.bg_exam_box {
		width: 15px;
		height: 15px;
		display: inline-block;
		margin-right: 5px;
	}

	.bg_green {
		background: #0E9549;
	}

	.bg_pink {
		background: #EBD1D1;
	}

	.example {
		display: inline-block;
	}

	.note {
		position: absolute;
		right: 15px;
		top: 8px;
	}

	.example {
		display: inline-block;
		width: auto;
	}
	#btn{
		float:right;
	}

</style>
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();

	});

</script>

