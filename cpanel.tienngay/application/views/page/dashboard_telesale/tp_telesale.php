<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="dashboard-right-sys">
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="row" style="margin-bottom: 20px;">

							<!-- -------------------------- -->
							<div class="col-md-12 col-xs-12 text-top">
								<h5>Báo cáo tháng</h5>
							</div>
							<div class="col-md-12 col-xs-12 top-ip " style="padding-left: 0px; padding-right:0px">
								<div class="col-md-2 col-xs-12 card-mobile" style="padding-left: 0px; padding-right:0px">
									<div class="card-ip">

										<form class="submit" action="<?php echo base_url('dashboard_telesale/index_dashboard_telesale') ?>"
											  method="get">
										<div class="sum-ip">
											<p>Từ ngày </p>
											<input type="date" name="fdate" id="fdate" value="<?= !empty($fdate) ? $fdate : '' ?>">
										</div><br>

										<div class="sum-ip">
											<p>Đến ngày </p>
											<input type="date" name="tdate" id="tdate" value="<?= !empty($tdate) ? $tdate : '' ?>">
										</div>
											<div class="sum-ip">
												<button><span class="fa fa-search"></span> Tìm kiếm</button>
											</div>
										</form>
									</div>

								</div>
								<div class="col-md-2 col-xs-12">
									<div class="card_item" style="border: 1px solid #EC1E24;">
										<h5>Tổng Lead về</h5>
										<h2 style="color: #9B1919;"><?= !empty($total_lead) ? number_format($total_lead) : 0 ?></h2>
									</div>
								</div>
								<div class="col-md-2 col-xs-12">
									<div class="card_item" style="border: 1px solid #0E9549;">
										<h5>Tổng Lead xử lý</h5>
										<h2 style="color: #0E9549;"><?= !empty($total_lead_update) ? number_format($total_lead_update) : 0 ?></h2>
									</div>
								</div>
								<div class="col-md-2 col-xs-12">
									<div class="card_item" style="border: 1px solid #0E9549;">
										<h5>Tổng Lead QLF</h5>
										<h2 style="color: #0E9549;"><?= !empty($total_lead_qlf) ? number_format($total_lead_qlf) : 0 ?></h2>
									</div>
								</div>
								<div class="col-md-2 col-xs-12">
									<div class="card_item" style="border: 1px solid #EC1E24;">
										<h5>Tổng hợp đồng giải ngân</h5>
										<h2 style="color: #9B1919;"><?= !empty($count_hd_giaingan) ? number_format($count_hd_giaingan) : 0 ?></h2>
									</div>
								</div>
								<div class="col-md-2 col-xs-12 card-right">
									<div class="card_item" style="border: 1px solid #0E9549;">
										<h5>Tổng tiền giải ngân</h5>
										<h2 style="color: #0E9549;"><?= !empty($price_hd_giaingan) ? number_format($price_hd_giaingan) : 0 ?></h2>
									</div>
								</div>
							</div>
							<div class="row" style="margin-bottom: 20px;">

								<div class="col-md-12">
									<div class="right_wiget-bar">
										<h2>Lead theo trạng thái </h2>
										<div class="x_content">
											<div class="row">
												<div class="col-12 col-xs-12 col-md-6  ">
													<div class="chartwrapper">
														<div class="doughnut_middledata">
															<span class="contract">Tổng</span>
															<br /><?= !empty($total_lead_status) ? number_format($total_lead_status) : 0 ?>
														</div>
														<canvas id="DanhSachHopDong" height="300" style="margin: auto;  display: block;">
														</canvas>
														<script>
															if ($('#DanhSachHopDong').length) {
																var chart_doughnut_settings = {
																	type: 'doughnut',
																	tooltipFillColor: "rgba(51, 51, 51, 0.55)",
																	data: {
																		labels: [
																			"Mới",
																			"Đồng ý vay",
																			"Đang suy nghĩ",
																			"Đang chờ duyệt",
																			"Đã ký hợp đồng",
																			"Đã ra PGD",
																			"Chờ gọi lại",
																			"Huỷ"
																		],
																		datasets: [{
																			data: [
																				<?php if (!empty($data)): ?>
																				<?php foreach ($data as $value): ?>
																				<?php echo $value . "," ?>
																				<?php endforeach; ?>
																				<?php endif; ?>
																			],
																			backgroundColor: [
																				"#0E9549", "#0054B6", "#0DCAF0", "#115C26", "#8600B6", "#FFC107", "#F76707", "#EC1E24"
																			],
																			hoverBackgroundColor: [
																				"#0E9549", "#0054B6", "#0DCAF0", "#115C26", "#8600B6", "#FFC107", "#F76707", "#EC1E24"
																			],
																			datalabels: {
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
																$('#DanhSachHopDong').each(function() {
																	var chart_element = $(this);
																	new Chart(chart_element, chart_doughnut_settings);
																});
															}
														</script>
													</div>
												</div>
												<div class="col-12 col-xs-12 col-md-5 ">
													<table class="table table-borderless">
														<thead>
														<tr>
															<th scope="col">Trạng thái lead</th>
															<th scope="col">Số Lượng</th>
															<th scope="col">Phần trăm</th>
														</tr>
														</thead>
														<tbody>
														<?php $arr_color = ['#0E9549','#0054B6','#0DCAF0','#115C26','#8600B6','#FFC107','#F76707','#EC1E24'];
														$count = 0;
														?>
														<?php if (!empty($data)): ?>
														<?php foreach ($data as $key => $value): ?>
														<tr style="color:<?= $arr_color[$count] ?>>">
															<td>
																<a style="color:<?= $arr_color[$count] ?>" target="_blank"  class="text-dark">
																	<i class="fa fa-square"></i> &nbsp; <?= $key ?>
																</a>
															</td>
															<td style="color:<?= $arr_color[$count] ?>"><?= number_format($value) ?></td>
															<td style="color:<?= $arr_color[$count] ?>">

																<i><?= $total_lead_status != 0 ? number_format((($value / $total_lead_status)*100),2) : 0 ?></i>%
															</td>

														</tr>
															<?php $count++; ?>
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
							<div class="row fix-col" style="margin-bottom: 20px;">
								<div class="col-12 col-xs-12 col-md-12 ">
									<div class="right_wiget-bar total_duno wiget-bar11">
										<div class="title ">
											<h3 style="color: #115C26">
												Thông số nhân viên
											</h3>
										</div>
										<div class="row">
											<div class="col-12 col-xs-12 col-md-2 ">
											</div>
											<div class="col-12 col-xs-4 col-md-2 col_text">
												<h5 style="color: #0E9549;">Cao nhất</h5>
											</div>
											<div class="col-12 col-xs-2 col-md-2 ">
											</div>
											<div class="col-12 col-xs-4 col-md-2 col_text">
												<h5 style="color: #EC1E24;">Thấp nhất</h5>
											</div>
											<div class="col-12 col-xs-0 col-md-4 ">
											</div>

										</div>

										<?php $count = 0;
										$name_top = "";
										$price_top = 0;
										$name_bot = "";
										$price_bot = 0;
										?>
										<?php if (!empty($sort_convert_tele)): ?>
											<?php foreach ($sort_convert_tele as $key => $value): ?>
												<?php if ($count == 0): ?>
													<?php $name_bot = $key ?>
													<?php $price_bot = number_format($value,2) ?>
												<?php endif; ?>
												<?php if ($count == (count((array)$sort_convert_tele)-1)): ?>
													<?php $name_top = $key ?>
													<?php $price_top = number_format($value,2) ?>
												<?php endif; ?>
												<?php $count++ ?>
											<?php endforeach; ?>
										<?php endif; ?>
										<div class="row">
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #474747;">Tỉ lệ convert</h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #8C8C8C;"><?= $name_top  ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #0E9549;"><?= $price_top  ?>%</h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #8C8C8C;"><?= $name_bot  ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-4 col_text">
												<h5 style="color: #EC1E24;"><?= $price_bot ?>%</h5>
											</div>

										</div>

										<?php $count = 0;
										$name_top = "";
										$price_top = 0;
										$name_bot = "";
										$price_bot = 0;
										?>
										<?php if (!empty($sort)): ?>
											<?php foreach ($sort as $key => $value): ?>
												<?php if ($count == 0): ?>
													<?php $name_bot = $key ?>
													<?php $price_bot = number_format($value) ?>
												<?php endif; ?>
												<?php if ($count == (count((array)$sort)-1)): ?>
													<?php $name_top = $key ?>
													<?php $price_top = number_format($value) ?>
												<?php endif; ?>
												<?php $count++ ?>
											<?php endforeach; ?>
										<?php endif; ?>

										<div class="row">
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #474747;">Tổng Lead QLF</h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color:  #8C8C8C;">
													<?= $name_top ?>
												</h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #0E9549;"><?= $price_top ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #8C8C8C;"><?= $name_bot ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-4 col_text">
												<h5 style="color: #EC1E24;"><?= $price_bot ?></h5>
											</div>

										</div>

										<div class="table1">
											<table class="table">
												<thead>
												<tr class="table_sticky" >
													<th scope="col">STT</th>
													<th scope="col">Nhân viên </th>
													<th scope="col">Tổng Lead xử lý</th>
													<th scope="col">Tổng Lead QLF</th>
													<th scope="col">Tỉ lệ QLF</th>
													<th scope="col">Tổng số hợp đồng giải ngân</th>
													<th scope="col">Tỉ lệ Convert</th>
													<th scope="col">Tổng tiền giải ngân </th>
												</tr>
												</thead>
												<tbody class="body1">
											<?php if(!empty($table_telesale)): ?>
											<?php foreach ($table_telesale as $key => $value): ?>
												<tr>
													<td scope="row" style="color: #8C8C8C;"><?= ++$key ?></td>
													<td style="color: #8C8C8C; text-align: left"><?= !empty($value->name) ? $value->name : "" ?></td>
													<td style="color: #115C26;"><?= !empty($value->lead_xu_ly) ? number_format($value->lead_xu_ly) : 0 ?></td>
													<td style="color: #9B1919;"><?= !empty($value->lead_qlf) ? number_format($value->lead_qlf) : 0 ?></td>
													<td style="color: #066578;"><?= !empty($value->ti_le) ? ($value->ti_le) : 0.00 ?>%</td>
													<td style="color: #066578;"><?= !empty($value->count_hd_giaingan) ? number_format($value->count_hd_giaingan) : 0 ?></td>
													<td style="color: #AA8105;"><?= !empty($value->ti_le_convert) ? ($value->ti_le_convert) : 0.00 ?>%</td>
													<td style="color: #115C26;"><?= !empty($value->price_giaingan) ? number_format($value->price_giaingan) : 0 ?></td>
												</tr>
											<?php endforeach; ?>
												<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<div class="col-12 col-xs-12 col-md-12 ">
									<div class="right_wiget-bar total_duno wiget-bar-button">
										<div class="title ">
											<h3 style="color: #115C26">
												Thông số PGD
											</h3>
										</div>
										<div class="row">
											<div class="col-12 col-xs-12 col-md-2 ">
											</div>
											<div class="col-12 col-xs-4 col-md-2 col_text">
												<h5 style="color: #0E9549;">Cao nhất</h5>
											</div>
											<div class="col-12 col-xs-2 col-md-2 ">
											</div>
											<div class="col-12 col-xs-4 col-md-2 col_text">
												<h5 style="color: #EC1E24;">Thấp nhất</h5>
											</div>
											<div class="col-12 col-xs-0 col-md-4 ">
											</div>

										</div>
										<?php $count = 0;
										$name_top = "";
										$price_top = 0;
										$name_bot = "";
										$price_bot = 0;
										?>
										<?php if (!empty($sort_convert)): ?>
											<?php foreach ($sort_convert as $key => $value): ?>
												<?php if ($count == 0): ?>
													<?php $name_bot = $key ?>
													<?php $price_bot = number_format($value,2) ?>
												<?php endif; ?>
												<?php if ($count == (count((array)$sort_convert)-1)): ?>
													<?php $name_top = $key ?>
													<?php $price_top = number_format($value,2) ?>
												<?php endif; ?>
												<?php $count++ ?>
											<?php endforeach; ?>
										<?php endif; ?>
										<div class="row">
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #474747;">Tỉ lệ convert</h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #8C8C8C;"><?= $name_top  ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #0E9549;"><?= $price_top  ?>%</h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #8C8C8C;"><?= $name_bot  ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-4 col_text">
												<h5 style="color: #EC1E24;"><?= $price_bot ?>%</h5>
											</div>

										</div>
										<?php $count = 0;
										$name_top = "";
										$price_top = 0;
										$name_bot = "";
										$price_bot = 0;
										?>
										<?php if (!empty($sort_price)): ?>
											<?php foreach ($sort_price as $key => $value): ?>
												<?php if ($count == 0): ?>
													<?php $name_bot = $key ?>
													<?php $price_bot = number_format($value) ?>
												<?php endif; ?>
												<?php if ($count == (count((array)$sort_price)-1)): ?>
													<?php $name_top = $key ?>
													<?php $price_top = number_format($value) ?>
												<?php endif; ?>
												<?php $count++ ?>
											<?php endforeach; ?>
										<?php endif; ?>
										<div class="row">
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #474747;">Tổng tiền giải ngân</h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #8C8C8C;"><?= $name_top ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #0E9549;"><?= $price_top ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-2 col_text">
												<h5 style="color: #8C8C8C;"><?= $name_bot  ?></h5>
											</div>
											<div class="col-12 col-xs-6 col-md-4 col_text">
												<h5 style="color: #EC1E24;"><?= $price_bot ?></h5>
											</div>

										</div>
										<div class="table2">
											<table class="table">
												<thead>
												<tr class="table_sticky">
													<th scope="col">STT</th>
													<th scope="col">Phòng giao dịch</th>
													<th scope="col">Khu Vực</th>
													<th scope="col">Tổng Lead QLF</th>
													<th scope="col">Tổng số hợp đồng giải ngân</th>
													<th scope="col">Tỉ lệ Convert</th>
													<th scope="col">Tổng tiền giải ngân </th>
												</tr>
												<style>
													.table_sticky {
														background: white;
														position: sticky;
														top: 0; /* Don't forget this, required for the stickiness */
														box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
													}
												</style>
												</thead>
												<tbody class="body1">
												<?php if(!empty($table_store)): ?>
													<?php foreach ($table_store as $key => $value): ?>
														<tr>
															<td scope="row" style="color: #8C8C8C;"><?= ++$key ?></td>
															<td style="color: #8C8C8C; text-align: left"><?= !empty($value->name) ? $value->name : "" ?></td>
															<td style="color: #8C8C8C; text-align: left"><?= !empty($value->code_area) ? $value->code_area : "" ?></td>
															<td style="color: #9B1919;"><?= !empty($value->lead_qlf) ? number_format($value->lead_qlf) : 0 ?></td>
															<td style="color: #0054B6;"><?= !empty($value->count_hd_giaingan) ? number_format($value->count_hd_giaingan) : 0 ?></td>
															<td style="color: #AA8105;"><?= !empty($value->ti_le_convert) ? ($value->ti_le_convert) : 0 ?>%</td>
															<td style="color: #115C26;"><?= !empty($value->price_giaingan) ? number_format($value->price_giaingan) : 0 ?></td>
														</tr>
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


				</div>

			</div>
		</div>
	</div>
	<link href="<?php echo base_url(); ?>assets/home/css/dashboard_kd.css" rel="stylesheet">
	<script type="text/javascript">
		$('ul.tabs li').click(function() {
			var tab_id = $(this).attr('data-tab');
			$('ul.tabs li').removeClass('active');
			$('.tab-panel').removeClass('active');
			$(this).addClass('active');
			$("#" + tab_id).addClass('active');
		})
		$('ul.tabs_area li').click(function() {
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

		.total_duno .item_bar span {
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

		.wiget-bar11 {
			border: 1px solid #EBEBEB;
			box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
			border-radius: 8px;
		}

		/* __________________ */
		/* .card-right{
			padding-right: 0px;
		} */

		table {
			border-collapse: inherit;
			border-spacing: 0;
		}

		.card-ip {
			display: flex;
			flex-direction: column;
			width: 90%;
			height: 120px;
		}
		.sum-ip{
			width: 100%;
			position: relative;
			/* margin-top:10px; */
		}
		.sum-ip p{
			position: absolute;
			top: -25%;
			left: 3%;

			font-weight: 600;
			font-size: 10px;
		}
		.sum-ip button{
			margin-top: 10px;
			border-radius: 2px;
			border: 1px solid #C0C0C0 ;
			color: #ffffff;
			background-color: #0e9549;
			padding: 6px;

		}
		.card-ip input {
			width: 100%;
			height: 32px;
			background: #FFFFFF;
			border: 1px solid #D9D9D9;
			border-radius: 5px;
			border-top: none;
			padding: 10px;
		}
		.text-top h5 {
			font-style: normal;
			font-weight: 600;
			font-size: 20px;
			line-height: 16px;
			display: flex;
			align-items: center;
			color: #0E4D20;
			padding-bottom: 10px;
		}

		.card_item {
			display: flex;
			flex-direction: column;
			/* align-items: center; */
			padding: 10px 4px;
			width: 100%;
			height: 120px;
			background: #FFFFFF;
			box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
			border-radius: 8px;
			padding-left: 8px;
		}

		.card_item h5 {
			font-style: normal;
			font-weight: 600;
			font-size: 14px;
			line-height: 24px;
			color: #595959;

		}

		.card_item h2 {
			font-style: normal;
			font-weight: 600;
			font-size: 24px;
			line-height: 20px;
		}

		.right_wiget-bar {
			margin-top: 24px;
			border: 1px solid #EBEBEB;
			box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
			border-radius: 8px;
		}

		.right_wiget-bar h2 {
			color: #0E4D20;
			font-style: normal;
			font-weight: 600;
			font-size: 20px;
			line-height: 24px;
		}

		.col_text h5 {
			font-style: normal;
			font-weight: 600;
			font-size: 16px;
			line-height: 16px;
		}


		.table1 {
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 16px;
			/* padding-top: 24px; */
			margin-top: 24px;
			overflow-y: auto;
			overflow-x: hidden;
			height: 400px;
			border: 1px solid #E8E8E8;
			border-radius: 8px;

		}

		.table1 thead th {
			text-align: center;
			background: #F0F0F0;
		}

		.table1 td {
			text-align: center;
		}

		.table1 th {
			text-align: center;
		}

		.table2 {
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 16px;
			margin-top: 24px;
			height: 400px;
			overflow-y: auto;
			overflow-x: hidden;
			border: 1px solid #E8E8E8;
			border-radius: 8px;

		}

		.table2 thead th {
			text-align: center;
			background: #F0F0F0;
		}

		.table2 td {
			text-align: center;
		}

		.table2 th {
			text-align: center;
		}

		.right_wiget-bar h3 {
			font-style: normal;
			font-weight: 600;
			font-size: 20px;
			line-height: 24px;
		}



		.fix-col {
			display: flex;
			flex-direction: column;
			gap: 24px;
		}

		.wiget-bar-button {
			border: 1px solid #EBEBEB;
			/* Elevation 1 */

			box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
			border-radius: 8px;
		}

		@media only screen and (min-width:1030px) and (max-width:1440px) {
			.card-ip {
				display: flex;
				flex-direction: column;
				/* padding: 0px 16px; */
				/* gap: 10px; */
				height: 120px;
			}

			.card-ip p {
				font-style: normal;
				font-weight: 600;
				font-size: 16px;
				line-height: 16px;
				display: flex;
				align-items: center;
				color: #595959;
			}

			.card_item {
				display: flex;
				flex-direction: column;
				/* align-items: center; */
				padding: 10px 4px;
				width: 100%;
				background: #FFFFFF;
				box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
				border-radius: 8px;
				padding-left: 8px;
			}

			.card_item h5 {
				font-style: normal;
				font-weight: 600;
				font-size: 13px;
				line-height: 24px;
				color: #595959;

			}

			.card_item h2 {
				font-style: normal;
				font-weight: 600;
				font-size: 22px;
				line-height: 20px;
			}
		}

		@media only screen and (min-width:1023px) and (max-width:1229px) {
			.card-ip {
				display: flex;
				flex-direction: column;
				height: 120px;

			}

			.card-ip h5 {
				font-style: normal;
				font-weight: 600;
				font-size: 16px;
				line-height: 16px;
				display: flex;
				align-items: center;
				color: #595959;
			}

			.card_item {
				display: flex;
				flex-direction: column;
				/* align-items: center; */
				padding: 10px 4px;
				width: 100%;
				background: #FFFFFF;
				box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
				border-radius: 8px;
				padding-left: 8px;
			}

			.chartwrapper {
				width: 80%;
			}

			.card_item h5 {
				font-style: normal;
				font-weight: 600;
				font-size: 9px;
				line-height: 24px;
				color: #595959;

			}

			.card_item h2 {
				font-style: normal;
				font-weight: 600;
				font-size: 16px;
				line-height: 20px;
			}
		}

		@media only screen and (min-width:1800px) and (max-width:1950px) {
			.card-ip {
				display: flex;
				flex-direction: column;
				height: 120px;

			}

			.card-ip h5 {
				font-style: normal;
				font-weight: 600;
				font-size: 16px;
				line-height: 16px;
				display: flex;
				align-items: center;
				color: #595959;
			}

			.card_item {
				display: flex;
				flex-direction: column;
				/* align-items: center; */
				padding: 10px 4px;
				width: 100%;
				background: #FFFFFF;
				box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
				border-radius: 8px;
				padding-left: 8px;
			}


			.card_item h5 {
				font-style: normal;
				font-weight: 600;
				font-size: 16px;
				line-height: 24px;
				color: #595959;

			}

			.card_item h2 {
				font-style: normal;
				font-weight: 600;
				font-size: 24px;
				line-height: 20px;
			}
		}

		@media only screen and (max-width :46.1875em) {
			.top-ip {
				display: flex;
				flex-direction: column;
				gap: 20px;
			}

			.card-mobile {
				width: 100%;
				padding: 0px;
			}

			.card-ip {
				display: flex;
				flex-direction: column;
				width: 100%;
				height: 120px;
				padding: 0px 10px;
			}

			.table1 {
				overflow: scroll;
			}

			.table2 {
				overflow: scroll;


			}
		}
	</style>
