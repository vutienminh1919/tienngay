<?php
$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : "";
$name_property = !empty($_GET['name_property']) ? $_GET['name_property'] : "";
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
					<div class="col-xs-8">
						<div class="title">
							<span class="tilte_top_tabs">
								Danh sách cuộc gọi 
							</span>
						</div>
					</div>
					<div class="middle table_tabs">
				<div class="clicked nav_tabs_vertical">
					<div class="col-xs-10">
						<div class="thongke">
							<div class="col-xs-3 no-pad">
								<label>Không nghe máy</label>
								<div class="discount khongnghe styleType">
									20.8%
								</div>
							</div>
							<div class="col-xs-3 no-pad">
								<label>Thuê bao</label>
								<div class="discount thuebao styleType">
									20.8%
								</div>
							</div>
							<div class="col-xs-3 no-pad">
								<label>Máy bận</label>
								<div class="discount mayban styleType">
									20.8%
								</div>
							</div>
							<div class="col-xs-3 no-pad">
								<label>Khách hàng dập máy trước</label>
								<div class="discount nghemay styleType">
									20.8%
								</div>
							</div>
						</div>
						
					</div>
					<div class="col-xs-2 total">
							Tổng 300 cuộc
						</div>
					<div class="col-xs-8">
						<ul class="nav tabs">
							<li  class="aos-init aos-animate in active" data-aos-delay="1500" data-offset="1500" data-aos-duration="1500" data-aos="fade-right">
								<h3 class="qt_title">Tất cả</h3>
							</li>
							<li class="aos-init aos-animate" data-aos-delay="1500" data-offset="1500" data-aos-duration="1700" data-aos="fade-right">
								<a href=""><h3 class="qt_title">Cuộc gọi 03s - 10s</h3></a>
							</li>
							<li class="aos-init aos-animate" data-aos-delay="1500" data-offset="1500" data-aos-duration="1800" data-aos="fade-right">
								<a href=""><h3 class="qt_title">Cuộc gọi 10s trở lên</h3></a>
							</li>
						</ul>
					</div>
					<div class="col-xs-4 text-right">
						Excel
					</div>
					<div class="clear" style="clear: both;">
				</div>
				<div class="tab-contents" style="margin-top: 15px">
					<div class="tab-panel  aos-init aos-animate active" data-aos-delay="1500" data-offset="1500" data-aos-duration="1600" data-aos="fade-up-down">
						<div class="table-responsive">
							<table id="" class="table table-striped">
								<thead>
								<tr style="text-align: center">
									<th style="text-align: center">STT</th>
									<th style="text-align: center">Nhân viên</th>
									<th style="text-align: center">Số điện thoại </th>
									<th style="text-align: center">Khách hàng</th>
									<th style="text-align: center">Thời gian bắt đầu</th>
									<th style="text-align: center">Thời gian kết thúc</th>
									<th style="text-align: center">Thời gian call</th>
									<th style="text-align: center">Trạng thái </th>
								</tr>
								</thead>
								<tbody align="center">
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>1</td>
										<td>tuanhva@tienngay.vn</td>
										<td><span class="text-success">0961123569</span></td>
										<td>Nguyễn Huyền My</td>
										<td>32/12/2022 10:00:00 </td>
										<td>32/12/2022 10:00:00</td>
										<td>
											10.2s
										</td>
										<td>
											<span class="status nghemay">
												Nghe máy
											</span>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>2</td>
										<td>tuanhva@tienngay.vn</td>
										<td><span class="text-success">0961123569</span></td>
										<td>Nguyễn Huyền My</td>
										<td>32/12/2022 10:00:00 </td>
										<td>32/12/2022 10:00:00 </td>
										<td>
											10.2s
										</td>
										<td>
											<span class="status khongnghe">
												Không nghe
											</span>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>3</td>
										<td>tuanhva@tienngay.vn</td>
										<td><span class="text-success">0961123569</span></td>
										<td>Nguyễn Huyền My</td>
										<td>32/12/2022 10:00:00 </td>
										<td>32/12/2022 10:00:00 </td>
										<td>
											10.2s
										</td>
										<td>
											<span class="status mayban">
												Máy bận
											</span>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>4</td>
										<td>tuanhva@tienngay.vn</td>
										<td><span class="text-success">0961123569</span></td>
										<td>Nguyễn Huyền My</td>
										<td>32/12/2022 10:00:00 </td>
										<td>32/12/2022 10:00:00 </td>
										<td>
											10.2s
										</td>
										<td>
											<span class="status thuebao">
												Thuê bao
											</span>
										</td>
									</tr>

								</tbody>
							</table>
						</div>
						<div class="bottom d_page">
							<div class="row">
								<div class="col-xs-12 text-right">
									<div class="pagination">
										<?php echo $pagination; ?>
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
<style type="text/css">
	.khongnghe{
		background: linear-gradient(0deg, rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85)), #CD7B00;
		color: #CD7B00;
	}
	.nghemay{
		background: linear-gradient(0deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), #0E9549;
		color: #0E9549;
	}
	.mayban{
		background: #BCD4F0;
		color: #0054B6;
	}
	.thuebao{
		background: #EBD1D1;
		color: #9B1919;
	}
	.styleType{
		padding: 5px 0;
		text-align: center;
		font-weight: 600;
    	font-size: 17px;
	}
	.no-pad{
		padding: 0;
	}
	.tilte_top_tabs{
		margin-bottom: 20px;
		display: block;
	}
	.tabs{
		margin-top: 15px;
		border: none !important;
	}
	.total{
		font-weight: 600;
	    font-size: 17px;
	    height: 59px;
	    display: flex;
	    align-items: center;
	    justify-content: flex-end;
	}
	.status{
		padding: 0 3px;
		border-radius: 5px;
		display: block;
	}
</style>