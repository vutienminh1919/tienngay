<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="row">
					<div class="col-xs-8">
						<div class="title">
							<h3 class="tilte_top_tabs" style="margin-bottom: 0">
								Hoang Ha Kim Ngan
							</h3>
							<span>Trưởng phòng giao dịch: <span style="color: #333;">81 giải phóng</span> </span>
						</div>
					</div>
				</div>
			</div>
			<div class="dashboard-right-sys">


				<div class="row">
					<div class="col-md-3">
						<div class="left_wiget-bar">
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tổng tiền giải ngân
									</h5>
									<p>
										6.554.000.000
									</p>
								</div>
								<div class="right">
									<img src="<?php echo base_url('assets/home/') ?>images/money1.png" title="img1">
								</div>


							</div>
							<div class="row mb-3">
								<div class="col-md-6">
									<input type="date" class="form-control" id="from">
								</div>
								<div class="col-md-6 mb-3">
									<input type="date" class="form-control" id="to">
								</div>
							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại
									</h5>
									<p>
										6.554.000.000
									</p>
								</div>
								<div class="right">
									<img src="<?php echo base_url('assets/home/') ?>images/money2.png" title="img1">
								</div>


							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại quá hạn T + 10
									</h5>
									<p>
										6.554.000.000
									</p>
								</div>
								<div class="right">
									<img src="<?php echo base_url('assets/home/') ?>images/money3.png" title="img1">
								</div>


							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại quá hạn T+10 tháng trước <span>30/11/2021</span>
									</h5>
									<p>
										6.554.000.000
									</p>
								</div>
								<div class="right">
									<img src="<?php echo base_url('assets/home/') ?>images/money4.png" title="img1">
								</div>


							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Gốc còn lại quá hạn T+10 tháng này <span>12/11/2021</span>
									</h5>
									<p>
										6.554.000.000
									</p>
								</div>
								<div class="right">
									<img src="<?php echo base_url('assets/home/') ?>images/money5.png" title="img1">
								</div>


							</div>
							<div class="const_box_show">
								<div class="left_box">
									<h5>
										Tiền giải ngân mới
									</h5>
									<p>
										6.554.000.000
									</p>
								</div>
								<div class="right">
									<img src="<?php echo base_url('assets/home/') ?>images/money6.png" title="img1">
								</div>

							</div>

							<div class="const_box_show" data-toggle="modal" data-target="#baohiem">
								<div class="left_box">
									<h5>
										Doanh số bảo hiểm
									</h5>
									<p>
										6.554.000.000
									</p>
								</div>
								<div class="right">
									<img src="<?php echo base_url('assets/home/') ?>images/money7.png" title="img1">
								</div>
							</div>
							<div class="const_box_show" data-toggle="modal" data-target="#doanhso">
								<div class="left_box">
									<h5>
										Tổng tiền hoa hồng
									</h5>
									<p>
										6.554.000.000
									</p>
								</div>
								<div class="right">
									<img src="<?php echo base_url('assets/home/') ?>images/money8.png" title="img1">
								</div>
							</div>

						</div>
					</div>
					<div class="col-md-9">
						<div class="row" style="margin: 0 0 20px 0; width: calc( 100% + 7px);">
							<div class="col-md-4 chart_left">
								<div class="chart_left_box">

									<div class="title">
										<h3>
											Tỉ lệ hoàn thành KPI
										</h3>
									</div>
									<div class="card">
										<div class="donut-chart chart1">
											<div class="slice one"></div>
											<div class="slice two"></div>
											<div class="chart-center">
												<span>69.96%</span>
											</div>
										</div>
									</div>
									<div class="btn btn_create_kpi" data-toggle="modal" data-target="#create_kpi">
										Tạo KPI mới
									</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="right_wiget-bar">
									<div class="title">
										<h3 style="color: #0CA678">
											Tạo khách hàng tiềm năng
										</h3>
									</div>
									<div class="form">
										<div class="input-group">
											<label>Tên khách hàng  <span style="color: red">*</span></label>
											<div class="form-group">
												<input type="text" class="form-control" id="money_gn" name="money_gn"
													   placeholder="Nhập tên khách hàng">
											</div>
										</div>
										<div class="input-group">
											<label>Số điện thoại <span style="color: red">*</span></label>
											<div class="form-group">
												<input type="text" class="form-control" id="money_gn" name="money_gn"
													   placeholder="Nhập số điện thoại">
											</div>
										</div>
										<div class="input-group">
											<label>CCCD/CMTND<span style="color: red">*</span></label>
											<div class="form-group">
												<input type="text" class="form-control" id="money_gn" name="money_gn"
													   placeholder="Nhập CCCD/CMTND">
											</div>
										</div>
										<div class="input-group">
											<label>Địa chỉ <span style="color: red">*</span></label>
											<div class="form-group">
												<input type="text" class="form-control" id="money_gn" name="money_gn"
													   placeholder="Nhập địa chỉ  ">
											</div>
										</div>
										<div class="input-group">
											<label>Nguồn khách hàng<span style="color: red">*</span></label>
											<div class="form-group">
												<select class="form-control" id="money_gn" name="money_gn"
												>
													<option value="">Website</option>
													<option value="">langdipage</option>
												</select>
											</div>
										</div>
										<div class="input-group">

											<div class="btn btn_create_kh">
												Tạo KPI mới
											</div>

										</div>
									</div>
								</div>
							</div>


						</div>
						<div class="x_panel tile">
							<div class="x_title">
								<h2>Biểu đồ tổng hợp</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="row">
									<div class="col-12 col-md-6 ">
										<div class="chartwrapper">
											<div class="doughnut_middledata">
												149
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
																data: [23, 24, 21, 14, 10, 102, 24],
																backgroundColor: [
																	"#2fb39c", "#bcc4d5", "#445d75", "#9a5ab2", "#3398da", "#a30041", "#2778a5"
																],
																hoverBackgroundColor: [
																	"#2fb39c", "#bcc4d5", "#445d75", "#9a5ab2", "#3398da", "#a30041", "#2778a5"
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
											<tr style="color:#2fb39c">
												<td>
													<a style="color:#2fb39c" target="_blank"
													   href="https://cpanel.tienngay.vn/pawn/search?status=1&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Mới:
													</a>
												</td>
												<td>
													23
													(<i>15</i>%)
												</td>

											</tr>
											<tr style="color:#bcc4d5">
												<td>
													<a style="color:#bcc4d5" target="_blank"
													   href="https://cpanel.tienngay.vn/pawn/search?status=2&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Chờ CHT duyệt:
													</a>
												</td>
												<td>
													0
													(<i>0</i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#445d75">
												<td>
													<a style="color:#445d75" target="_blank"
													   href="https://cpanel.tienngay.vn/pawn/search?status=5&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Chờ HS duyệt:
													</a>
												</td>
												<td>
													0
													(<i>0</i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#9a5ab2">
												<td>
													<a style="color:#9a5ab2" target="_blank"
													   href="https://cpanel.tienngay.vn/pawn/search?status=6&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Hội sở đã duyệt:
													</a>
												</td>
												<td>
													0
													(<i>0</i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#3398da">
												<td>
													<a style="color:#3398da" target="_blank"
													   href="https://cpanel.tienngay.vn/pawn/search?status=15&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Chờ giải ngân: </a>
												</td>
												<td>
													0
													(<i>0</i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#a30041">
												<td>
													<a style="color:#a30041" target="_blank"
													   href="https://cpanel.tienngay.vn/pawn/search?ngay_giai_ngan=2&amp;status=17&amp;fdate=2021-11-01&amp;tdate=2021-11-08"
													   class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Đang vay:
													</a>
												</td>
												<td>
													102
													(<i>68</i>%)
												</td>
												<td></td>
											</tr>
											<tr style="color:#2778a5">
												<td>
													<a style="color:#2778a5" target="_blank" href="#" class="text-dark">
														<i class="fa fa-square"></i> &nbsp;
														Khác: 24 </a>
												</td>
												<td>
													24
													(<i>16</i>%)
												</td>
												<td></td>
											</tr>
											</tbody>
										</table>


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
												<h3 class="qt_title">Đang chờ xử lý</h3>
											</a>
										</li>
										<li data-tab="return" class="aos-init aos-animate" data-aos-delay="1500"
											data-offset="1500" data-aos-duration="1700" data-aos="fade-right">
											<a>
												<h3 class="qt_title">Trả lại chăm sóc khách hàng</h3>
											</a>
										</li>
										<li data-tab="cancel" class="aos-init aos-animate" data-aos-delay="1500"
											data-offset="1500" data-aos-duration="1800" data-aos="fade-right">
											<a aria-expanded="true">
												<h3 class="qt_title">Đã hủy</h3>
											</a>
										</li>
									</ul>
									<div class="search">
										<input type="text" id="search" placeholder="Nhập từ khoá tìm kiếm..."
											   class="form-control" name="search">
										<button type="button" class="btn btn-success btn_search">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
								<div class="tab-contents">
									<div id="waitting" class="tab-panel  aos-init aos-animate active"
										 data-aos-delay="1500" data-offset="1500" data-aos-duration="1600"
										 data-aos="fade-up-down">
										<table class="table table-striped">
											<thead>
											<tr style="text-align: center">
												<th style="text-align: left;">STT</th>
												<th style="text-align: left">Tên hợp đồng giải ngân</th>
												<th style="text-align: center">Tiền hoa hồng</th>
												<th style="text-align: center">Ngày giải ngân</th>
												<th style="text-align: center">Trạng thái</th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td style="text-align: left;">1</td>
												<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
												<td style="text-align: center">12.000.000</td>
												<td style="text-align: center">03/05/2021</td>
												<td style="text-align: center">Đang chờ xử lý</td>
											</tr>
											<tr>
												<td style="text-align: left;">1</td>
												<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
												<td style="text-align: center">12.000.000</td>
												<td style="text-align: center">03/05/2021</td>
												<td style="text-align: center">Đang chờ xử lý</td>
											</tr>
											</tbody>
										</table>
									</div>
									<div id="return" class="tab-panel">
										<table class="table table-striped">
											<thead>
											<tr style="text-align: center">
												<th style="text-align: left;">STT</th>
												<th style="text-align: left">Tên hợp đồng giải ngân</th>
												<th style="text-align: center">Tiền hoa hồng</th>
												<th style="text-align: center">Ngày giải ngân</th>
												<th style="text-align: center">Trạng thái</th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td style="text-align: left;">1</td>
												<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
												<td style="text-align: center">12.000.000</td>
												<td style="text-align: center">03/05/2021</td>
												<td style="text-align: center">Trả lại cskh</td>
											</tr>
											<tr>
												<td style="text-align: left;">1</td>
												<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
												<td style="text-align: center">12.000.000</td>
												<td style="text-align: center">03/05/2021</td>
												<td style="text-align: center">Trả lại cskh</td>
											</tr>
											</tbody>
										</table>
									</div>
									<div id="cancel" class="tab-panel">
										<table class="table table-striped">
											<thead>
											<tr style="text-align: center">
												<th style="text-align: left;">STT</th>
												<th style="text-align: left">Tên hợp đồng giải ngân</th>
												<th style="text-align: center">Tiền hoa hồng</th>
												<th style="text-align: center">Ngày giải ngân</th>
												<th style="text-align: center">Trạng thái</th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td style="text-align: left;">1</td>
												<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
												<td style="text-align: center">12.000.000</td>
												<td style="text-align: center">03/05/2021</td>
												<td style="text-align: center">Đã huỷ</td>
											</tr>
											<tr>
												<td style="text-align: left;">1</td>
												<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
												<td style="text-align: center">12.000.000</td>
												<td style="text-align: center">03/05/2021</td>
												<td style="text-align: center">Đã huỷ</td>
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
<div class="modal fade" id="baohiem" tabindex="-1" role="dialog" aria-labelledby="baohiem" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="baohiem">Doanh số bảo hiểm</h3>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<thead>
					<tr style="text-align: center">
						<th style="text-align: left;">STT</th>
						<th style="text-align: left">Tên hợp đồng giải ngân</th>
						<th style="text-align: center">Tiền hoa hồng</th>
						<th style="text-align: center">Tỷ trọng</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td style="text-align: left;">1</td>
						<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
						<td style="text-align: center">12.000.000</td>
						<td style="text-align: center">69.96%</td>
					</tr>
					<tr>
						<td style="text-align: left;">1</td>
						<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
						<td style="text-align: center">12.000.000</td>
						<td style="text-align: center">69.96%</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="doanhso" tabindex="-1" role="dialog" aria-labelledby="doanhso" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="baohiem">Tổng tiền hoa hồng</h3>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<thead>
					<tr style="text-align: center">
						<th style="text-align: left;">STT</th>
						<th style="text-align: left">Tên hợp đồng giải ngân</th>
						<th style="text-align: center">Tiền hoa hồng</th>
						<th style="text-align: center">Tỷ trọng</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td style="text-align: left;">1</td>
						<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
						<td style="text-align: center">12.000.000</td>
						<td style="text-align: center">69.96%</td>
					</tr>
					<tr>
						<td style="text-align: left;">1</td>
						<td style="text-align: left">HĐCC/ĐKXM/HN901GP/2109/23/GH-01</td>
						<td style="text-align: center">12.000.000</td>
						<td style="text-align: center">69.96%</td>
					</tr>
					</tbody>
				</table>
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

					<div class="item_child">
						<div class="item_bar">
							<span>81 Giải Phóng</span>
							<div class="bar_horizontal">
								<div style="width: 20%;background: #D63939;"
									 class="bar_horizontal_child"></div>
							</div>
						</div>
						<div class="const_percent" style="color: #D63939">
							<span>20%</span>
						</div>
					</div>
					<div class="item_child">
						<div class="item_bar">
							<span>81 Giải Phóng</span>
							<div class="bar_horizontal">
								<div style="width: 30%;background: #17A2B8;"
									 class="bar_horizontal_child"></div>
							</div>
						</div>
						<div class="const_percent" style="color: #17A2B8">
							<span>30%</span>
						</div>
					</div>
					<div class="item_child">
						<div class="item_bar">
							<span>81 Giải Phóng</span>
							<div class="bar_horizontal">
								<div style="width: 60%;background: #0CA678;"
									 class="bar_horizontal_child"></div>
							</div>
						</div>
						<div class="const_percent" style="color: #0CA678">
							<span>60%</span>
						</div>
					</div>
					<div class="item_child">
						<div class="item_bar">
							<span>81 Giải Phóng</span>
							<div class="bar_horizontal">
								<div style="width: 100%;background: #0E9549;"
									 class="bar_horizontal_child"></div>
							</div>
						</div>
						<div class="const_percent" style="color: #0E9549">
							<span>200%</span>
						</div>
					</div>
					<div class="item_child">
						<div class="item_bar">
							<span>81 Giải Phóng</span>
							<div class="bar_horizontal">
								<div style="width: 20%;background: #D63939;"
									 class="bar_horizontal_child"></div>
							</div>
						</div>
						<div class="const_percent" style="color: #D63939">
							<span>20%</span>
						</div>
					</div>
					<div class="item_child">
						<div class="item_bar">
							<span>81 Giải Phóng</span>
							<div class="bar_horizontal">
								<div style="width: 20%;background: #D63939;"
									 class="bar_horizontal_child"></div>
							</div>
						</div>
						<div class="const_percent" style="color: #D63939">
							<span>20%</span>
						</div>
					</div>


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
									<div class="percent_place">
										81 Giải Phóng
									</div>
									<div class="percent_kpi plus">
										200%
									</div>
								</div>
								<div class="percent-data">
									<div class="percent_place">
										81 Giải Phóng
									</div>
									<div class="percent_kpi plus">
										200%
									</div>
								</div>
								<div class="percent-data">
									<div class="percent_place">
										81 Giải Phóng
									</div>
									<div class="percent_kpi plus">
										200%
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
										81 Giải Phóng
									</div>
									<div class="percent_kpi minus">
										20%
									</div>
								</div>
								<div class="percent-data">
									<div class="percent_place">
										81 Giải Phóng
									</div>
									<div class="percent_kpi minus">
										20%
									</div>
								</div>
								<div class="percent-data">
									<div class="percent_place">
										81 Giải Phóng
									</div>
									<div class="percent_kpi minus">
										20%
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
<div class="modal fade" id="create_kpi" tabindex="-1" role="dialog" aria-labelledby="create_kpi" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-box_create">
				<h3 class="header_name">
					Tạo KPI nhân viên
				</h3>
				<div class="row">
					<div class="col-md-4" style="border-right:1px solid #D9D9D9; ">
						<div class="area_box_wrapper">
							<div class="header_area_name">
								<h4>Danh sách nhân viên</h4>
								<div class="search_area_div">
									<input type="text" id="search_area" placeholder="Tìm kiếm..." class="form-control"
										   name="search_area"/>
									<i class="fa fa-search"></i>
								</div>
							</div>
							<div class="list-area">
								<ul class="tabs_area tabs_nav_area">
									<li class="active" data-tab="area_1">
										Nguyễn Cao Kỳ Duyên
									</li>
									<li class="" data-tab="area_2">
										Nguyễn Ngọc Lan Khuê
									</li>
									<li class="" data-tab="area_3">
										Đỗ Mỹ Linh
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="tab-contents">
							<div id="area_1" class="tab-panels active">
								<div class="infor_area_details">
									<div class="infor_show">
										<h3>
											Nguyễn Cao Kỳ Duyên
										</h3>
									</div>
									<div class="month_kpi_before">
										<div class="footer_bar">
											<div class="title_footer">
												<span>KPI tháng trước</span>
											</div>
										</div>
										<div class="block_com_data">
											<table>
												<thead>
												<th>Tiêu chí đánh giá</th>
												<th>Đã đặt</th>
												<th>Hoàn thành</th>
												</thead>
												<tbody>
												<tr>
													<td>Số tiền giải ngân</td>
													<td style="color: #0E9549">50.000.000</td>
													<td style="color: #EC1E24">69,96%</td>
												</tr>
												<tr>
													<td>Số tiền bảo hiểm</td>
													<td style="color: #0E9549">50.000.000</td>
													<td style="color: #EC1E24">69,96%</td>
												</tr>
												<tr>
													<td>Số lượng khách hàng mới</td>
													<td style="color: #0E9549">25</td>
													<td style="color: #EC1E24">69,96%</td>
												</tr>
												<tr>
													<td>Số tiền HĐ quá hạn</td>
													<td style="color: #0E9549">50.000.000</td>
													<td style="color: #EC1E24">69,96%</td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="month_kpi_after">
							<div class="footer_bar">
								<div class="title_footer">
									<span>KPI tháng này</span>
								</div>
							</div>
							<div class="form">
								<div class="input-group">
									<label>Số tiền giải ngân <span style="color: red">*</span></label>
									<div class="form-group">
										<input type="text" class="form-control" id="money_gn" name="money_gn"
											   placeholder="Nhập số tiền giải ngân">
										<div class="add-on">
											VND
										</div>
									</div>
								</div>
								<div class="input-group">
									<label>Số tiền bảo hiểm<span style="color: red">*</span></label>
									<div class="form-group">
										<input type="text" class="form-control" id="money_gn" name="money_gn"
											   placeholder="Nhập số tiền bảo hiểm">
										<div class="add-on">
											VND
										</div>
									</div>
								</div>
								<div class="input-group">
									<label>Số lượng khách hàng mới<span style="color: red">*</span></label>
									<div class="form-group">
										<input type="text" class="form-control" id="money_gn" name="money_gn"
											   placeholder="Nhập số lượng khách mới">
										<div class="add-on">
											VND
										</div>
									</div>
								</div>
								<div class="input-group">
									<label>Số tiền HĐ quá hạn<span style="color: red">*</span></label>
									<div class="form-group">
										<input type="text" class="form-control" id="money_gn" name="money_gn"
											   placeholder="Nhập số tiền sợ xấu ">
										<div class="add-on">
											VND
										</div>
									</div>
								</div>
								<div class="input-group">

									<div class="btn btn_create_kpi_after">
										Tạo KPI mới
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
</script>
