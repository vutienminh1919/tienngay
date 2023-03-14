<div class="col-xs-12 fix_to_col" id="fix_to_col">
	<div class="table_app_all">
		<div class="top">
			<div class="row">
				<div class="col-xs-8">
					<div class="title">
							<span class="tilte_top_tabs">
								tài sản
							</span>
						<div class="chartwrapper">
							<div class="doughnut_middledata">
								<span class="contract">Tổng</span>
								<br/>1.000.000.000
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
												// "Nhóm B0",
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
												data: [23, 21, 14, 10, 102, 24, 21, 34],
												backgroundColor: [
													"#0E9549", "#0054B6", "#0DCAF0", "#115C26", "#8600B6", "#FFC107", "#F76707", "#EC1E24"
												],
												hoverBackgroundColor: [
													"#0E9549", "#0054B6", "#0DCAF0", "#115C26", "#8600B6", "#FFC107", "#F76707", "#EC1E24"
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
				</div>
				<div class="col-xs-4 text-right">
				</div>
			</div>
		</div>
	</div>
</div>








