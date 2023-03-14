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
								Định giá tài sản
							</span>
						</div>
					</div>
					<div class="col-xs-4 text-right">
						<select id="select_asset" class="sellect options">
							<option value="xe máy" selected="">Xe máy</option>
							<option value="ô tô">Ô tô</option>
						</select>		
					</div>
				</div>
			</div>
			<div class="middle table_tabs">
				<div class="clicked nav_tabs_vertical">
					<ul class="nav tabs">
						<li data-tab="khau-hao" class="aos-init aos-animate in active" data-aos-delay="1500" data-offset="1500" data-aos-duration="1500" data-aos="fade-right">
							<h3 class="qt_title">Khấu hao tài sản</h3>
						</li>
						<li data-tab="list" class="aos-init aos-animate" data-aos-delay="1500" data-offset="1500" data-aos-duration="1700" data-aos="fade-right">
							<h3 class="qt_title">Danh sách tài sản</h3>
						</li>
						<li data-tab="history" class="aos-init aos-animate" data-aos-delay="1500" data-offset="1500" data-aos-duration="1800" data-aos="fade-right">
							<h3 class="qt_title">Lịch sử chỉnh sửa</h3>
						</li>
					</ul>
				</div>
				
				<div class="tab-contents">
					<!-- tabs1 -->
					<div id="khau-hao" class="tab-panel  aos-init aos-animate active" data-aos-delay="1500" data-offset="1500" data-aos-duration="1600" data-aos="fade-up-down">
						<div class="btn_list_filter text-right">
							<div class="button_functions">
								<div class="dropdown">
									<button class="btn btn-secondary btn-success dropdown-toggle btn-func" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Chức năng &nbsp<i class="fa fa-caret-down "></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									    <a id="btn_add_dep" class="dropdown-item" href="#">Thêm khấu hao</a>
									    <a id="btn_minus_dep" class="dropdown-item" href="#">Thêm giảm trừ</a>
									    <a id="btn_edit_dep" class="dropdown-item" href="#">Chỉnh sửa giảm trừ</a>
									</div>
								</div>
							</div>
							<div class="button_functions btn-fitler">
								<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
									    <i class="fa fa-filter"></i>
								</button>
								<div class="dropdown-menu drop_select">
								    <select id="sellect-car_company" class="limit_on_page">
										<option value="-1" selected="">Chọn hãng xe</option>
										<option value="20">20</option>
									</select>
									<select id="sellect-segment" class="limit_on_page">
										<option value="-1" selected="">Chọn phân khúc</option>
										<option value="20">20</option>
									</select>
									<button type="button" class="btn btn-outline-success">Tìm kiếm</button>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="" class="table table-striped">
								<thead>
								<tr style="text-align: center">
									<th style="text-align: center">STT</th>
									<th style="text-align: center">Hãng xe</th>
									<th style="text-align: center">Số năm sử dụng</th>
									<th style="text-align: center">Phân khúc</th>
									<th style="text-align: center">Giảm trừ tiêu chuẩn</th>
									<th style="text-align: center">Giảm trừ xe Dv, Biển tỉnh</th>
									<th style="text-align: center">Tổng giảm trừ</th>
									<th style="text-align: center"></th>
								</tr>
								</thead>
								<tbody align="center">
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>1</td>
										<td>Honda</td>
										<td>1</td>
										<td>A</td>
										<td>20%</td>
										<td>5%</td>
										<td>
											25%
										</td>
										<td>
											<a id="details--" href="javascriptvoid:0">
												<img src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
											</a>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>1</td>
										<td>Honda</td>
										<td>1</td>
										<td>A</td>
										<td>20%</td>
										<td>5%</td>
										<td>
											25%
										</td>
										<td>
											<a id="details--" href="javascriptvoid:0">
												<img src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
											</a>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>1</td>
										<td>Honda</td>
										<td>1</td>
										<td>A</td>
										<td>20%</td>
										<td>5%</td>
										<td>
											25%
										</td>
										<td>
											<a id="details--" href="javascriptvoid:0">
												<img src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
											</a>
										</td>
									</tr>

								</tbody>
							</table>
						</div>
						<div class="bottom d_page">
							<div class="row">
								<div class="col-xs-6 text-left">
									Hiển thị &nbsp&nbsp
									<select id="sellect-limit-on_page" class="limit_on_page">
										<option value="10" selected="">10</option>
										<option value="20">20</option>
										<option value="30">30</option>
										<option value="40">40</option>
										<option value="50">50</option>
										<option value="60">60</option>	
									</select>
								</div>
								<div class="col-xs-6 text-right">
									<div class="pagination">
										<?php echo $pagination; ?>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- tabs2 -->
					<div id="list" class="tab-panel ">
						<div class="btn_list_filter text-right">
							<div class="button_functions">
								<div class="dropdown">
									<button class="btn btn-secondary btn-success dropdown-toggle btn-func" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Chức năng &nbsp<i class="fa fa-caret-down "></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									    <a class="dropdown-item" href="#">Xem lịch sử thay đổi</a>
									    <a class="dropdown-item" href="#">Upload tài sản</a>
									    <a class="dropdown-item" href="#">Upload xóa tài sản</a>
									</div>
								</div>
							</div>	
							<div class="button_functions btn-fitler_tab2">
								<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
									    <i class="fa fa-filter"></i>
								</button>
								<div class="dropdown-menu drop_select_tab2">
								    <select id="sellect-segment_tabs2" class="limit_on_page">
										<option value="-1" selected="">Chọn phân khúc</option>
										<option value="20">10</option>
									</select>
									<select id="sellect-Range" class="limit_on_page">
										<option value="-1" selected="">Loại xe</option>
										<option value="20">20</option>
									</select>
									<select id="sellect-Year" class="limit_on_page">
										<option value="-1" selected="">Năm sản xuất</option>
										<option value="20">30</option>
									</select>
									<select id="sellect-type" class="limit_on_page">
										<option value="-1" selected="">hãng</option>
										<option value="20">40</option>
									</select>
									<select id="sellect-Model" class="limit_on_page">
										<option value="-1" selected="">Model - Phân khối</option>
										<option value="20">50</option>
									</select>
									<button type="button" class="btn btn-outline-success">Tìm kiếm</button>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<div class="detele-all">
								<i class="fa fa-remove"></i>&nbsp Xóa
							</div>
							<table id="" class="table table-striped">
								<thead>
								<tr style="text-align: center">
									<th style="text-align: center"><input onclick="selectAll(this)" style="position: relative;left: 7px;" type="checkbox" value="" id="chk-" class="checkbox"></th>
									<th style="text-align: center">STT</th>
									<th style="text-align: center">Năm sản xuất</th>
									<th style="text-align: center">Loại xe</th>
									<th style="text-align: center">Phân khúc</th>
									<th style="text-align: center">Hãng</th>
									<th style="text-align: center">Model + Phân khối</th>
									<th style="text-align: center">Giá đề xuất</th>
									<th width="45px" style="text-align: center"></th>
								</tr>
								</thead>
								<tbody align="center">
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td><input type="checkbox" value="" id="chk-" class="checkbox"></th></td>
										<td>1</td>
										<td>2014</td>
										<td>1</td>
										<td>A</td>
										<td>Yamaha</td>
										<td>MX Kính 150 (Nhập khẩu)</td>
									
										<td>
											40.000.000
										</td>
										<td class="propertype" >
											<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    <a id="details--" href="javascriptvoid:0">
													<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
													<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
												</a>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											    <a id="details-show-info__id__" data-id="" class="dropdown-item show_info_btn_chose" href="javascript:(0)">Xem thông tin</a>
											    <a id="details-show-his-change__id__"  class="dropdown-item show_history_info_btn" href="javascript:(0)">Xem lịch sử thay đổi</a>
											    <a id="details-delete__id__" data-id="" class="dropdown-item delete_btn_chose" href="javascript:(0)">Xóa tài sản</a>
											</div>
											<script type="text/javascript">
												$('#details-delete__id__').on('click', function() {
											        $('#alert_delete_pro_choo').show();
											        $('.ovelay').show();
											    });
											</script>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td><input type="checkbox" value="" id="chk-" class="checkbox"></th></td>
										<td>1</td>
										<td>2014</td>
										<td>1</td>
										<td>A</td>
										<td>Yamaha</td>
										<td>MX Kính 150 (Nhập khẩu)</td>
										
										<td>
											40.000.000
										</td>
										<td class="propertype">
											<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    <a id="details--" href="javascriptvoid:0">
													<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
													<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
												</a>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											    <a id="details-show-info__id__" class="dropdown-item" href="#">Xem thông tin</a>
											    <a id="details-show-his-change__id__" class="dropdown-item" href="#">Xem lịch sử thay đổi</a>
											    <a id="details-delete__id__" class="dropdown-item delete_btn_chose" href="#">Xóa tài sản</a>
											</div>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td><input type="checkbox" value="" id="chk-" class="checkbox"></th></td>
										<td>1</td>
										<td>2014</td>
										<td>1</td>
										<td>A</td>
										<td>Yamaha</td>
										<td>MX Kính 150 (Nhập khẩu)</td>
										
										<td>
											40.000.000
										</td>
										<td class="propertype">
											<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    <a id="details--" href="javascriptvoid:0">
													<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
													<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
												</a>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											    <a id="details-show-info__id__" class="dropdown-item" href="#">Xem thông tin</a>
											    <a id="details-show-his-change__id__" class="dropdown-item" href="#">Xem lịch sử thay đổi</a>
											    <a id="details-delete__id__" class="dropdown-item delete_btn_chose" href="#">Xóa tài sản</a>
											</div>
											
										</td>
									</tr>

								</tbody>
							</table>
						</div>
						<div class="bottom d_page">
							<div class="row">
								<div class="col-xs-6 text-left">
									Hiển thị &nbsp&nbsp
									<select id="sellect-limit-on_page" class="limit_on_page">
										<option value="10" selected="">10</option>
										<option value="20">20</option>
										<option value="30">30</option>
										<option value="40">40</option>
										<option value="50">50</option>
										<option value="60">60</option>	
									</select>
								</div>
								<div class="col-xs-6 text-right">
									<div class="pagination">
										<?php echo $pagination; ?>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- tab3 -->
					<div id="history" class="tab-panel ">
						<div class="btn_list_filter text-right">
							<div class="button_functions btn-fitler_tab3">
								<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
									    <i class="fa fa-filter"></i>
								</button>
								<div class="dropdown-menu drop_select_tab3">
								    <select id="sellect-hang_xe" class="limit_on_page">
										<option value="-1" selected="">Hãng xe</option>
										<option value="20">10</option>
									</select>
									<select id="sellect-time" class="limit_on_page">
										<option value="-1" selected="">Thời gian</option>
										<option value="20">20</option>
									</select>
									<select id="sellect-Petitioner" class="limit_on_page">
										<option value="-1" selected="">Người yêu cầu</option>
										<option value="20">30</option>
									</select>
									<select id="sellect-Executor" class="limit_on_page">
										<option value="-1" selected="">Người thực hiện</option>
										<option value="20">40</option>
									</select>
									<select id="sellect-status" class="limit_on_page">
										<option value="-1" selected="">Trạng thái</option>
										<option value="20">50</option>
									</select>
									<button type="button" class="btn btn-outline-success">Tìm kiếm</button>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="" class="table table-striped">
								<thead>
								<tr style="text-align: center">
									<th style="text-align: center">STT</th>
									<th style="text-align: center">Thời gian</th>
									<th style="text-align: center">Hãng xe</th>
									<th style="text-align: center">Model + Phân khối</th>
									<th style="text-align: center">Người gửi yêu cầu</th>
									<th style="text-align: center">Người thực hiện</th>
									<th style="text-align: right;">Trạng thái</th>
									<th style="text-align: right"></th>
								</tr>
								</thead>
								<tbody align="center">
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>1</td>
										<td>12/7/2021</td>
										<td>Yamaha</td>
										<td>MX Kinh 150(Nhập Khẩu)</td>
										<td>nguyenvn@tienngay.vn</td>
										<td>hongtx@gmail.com</td>
									
										<td align="right">
											<a id="cancel_id__" class="cancel_btn" title="đã hủy">Đã hủy</a>
											<a id="wait_success__" class="wait_success_btn hidden" title="Chờ xác nhận">Chờ xác nhận</a>
											<a id="deleted_id__" class="cancel_btn hidden" title="đã hủy">Đã xóa</a>
											<a id="successed_id__" class="successted_btn hidden" title="Đã xác nhận">Đã xác nhận</a>
										</td>
										<td class="propertype" style="border-bottom: unset;">
											<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    <a id="details--" href="javascriptvoid:0">
													<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
													<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
												</a>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											    <a id="restore__id__" class="dropdown-item restore" href="#">Khôi phục</a>
											</div>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>2</td>
										<td>12/7/2021</td>
										<td>Yamaha</td>
										<td>MX Kinh 150(Nhập Khẩu)</td>
										<td>nguyenvn@tienngay.vn</td>
										<td>hongtx@gmail.com</td>
										
										<td align="right">
											<a id="cancel_id__" class="cancel_btn hidden" title="đã hủy">Đã hủy</a>
											<a id="wait_success__" class="wait_success_btn" title="Chờ xác nhận">Chờ xác nhận</a>
											<a id="deleted_id__" class="cancel_btn hidden" title="đã hủy">Đã xóa</a>
											<a id="successed_id__" class="successted_btn hidden" title="Đã xác nhận">Đã xác nhận</a>
										</td>
										<td class="propertype" style="border-bottom: unset;">
											<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    <a id="details--" href="javascriptvoid:0">
													<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
													<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
												</a>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											    <a id="restore__id__" class="dropdown-item restore" href="#">Khôi phục</a>
											</div>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>3</td>
										<td>12/7/2021</td>
										<td>Yamaha</td>
										<td>MX Kinh 150(Nhập Khẩu)</td>
										<td>nguyenvn@tienngay.vn</td>
										<td>hongtx@gmail.com</td>
										
										<td align="right">
											<a id="cancel_id__" class="cancel_btn hidden" title="đã hủy">Đã hủy</a>
											<a id="wait_success__" class="wait_success_btn hidden" title="Chờ xác nhận">Chờ xác nhận</a>
											<a id="deleted_id__" class="cancel_btn" title="đã hủy">Đã xóa</a>
											<a id="successed_id__" class="successted_btn hidden" title="Đã xác nhận">Đã xác nhận</a>
										</td>
										<td class="propertype" style="border-bottom: unset;">
											<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    <a id="details--" href="javascriptvoid:0">
													<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
													<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
												</a>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											    <a id="restore__id__" class="dropdown-item restore" href="#">Khôi phục</a>
											</div>
										</td>
									</tr>
									<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
										<td>4</td>
										<td>12/7/2021</td>
										<td>Yamaha</td>
										<td>MX Kinh 150(Nhập Khẩu)</td>
										<td>nguyenvn@tienngay.vn</td>
										<td>hongtx@gmail.com</td>
										
										<td align="right">
											<a id="cancel_id__" class="cancel_btn hidden" title="đã hủy">Đã hủy</a>
											<a id="wait_success__" class="wait_success_btn" hidden title="Chờ xác nhận">Chờ xác nhận</a>
											<a id="deleted_id__" class="cancel_btn hidden" title="đã hủy">Đã xóa</a>
											<a id="successed_id__" class="successted_btn " title="Đã xác nhận">Đã xác nhận</a>
										</td>
										<td class="propertype" style="border-bottom: unset;">
											<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    <a id="details--" href="javascriptvoid:0">
													<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
													<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
												</a>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											    <a id="restore__id__" class="dropdown-item restore" href="#">Khôi phục</a>
											</div>
										</td>
									</tr>

								</tbody>
							</table>
						</div>
						<div class="bottom d_page">
							<div class="row">
								<div class="col-xs-6 text-left">
									Hiển thị &nbsp&nbsp
									<select id="sellect-limit-on_page" class="limit_on_page">
										<option value="10" selected="">10</option>
										<option value="20">20</option>
										<option value="30">30</option>
										<option value="40">40</option>
										<option value="50">50</option>
										<option value="60">60</option>	
									</select>
								</div>
								<div class="col-xs-6 text-right">
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
<div class="modal fade" id="add_depreciation" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Thêm khấu hao
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body ">
				<div class="form-group_popup">
					<div class="form_input">
						<label>Nhập tên<span style="color: red;">*</span></label>
						<input type="text" name="name" id="name_add_dep" placeholder="Nhập tên" class="form_input_fields">
					</div>
					<div class="form_input">
						<label>Upload excel</label>
						<input style="display: none;" type="file" name="file" id="file_nodal_tab1" placeholder="Nhập file" class="form_input">
						<div class="sellect_files">
							 <button onclick="document.getElementById('file_nodal_tab1').click()">Chọn tệp</button>
							 <input type="text" name="name" id="name" onclick="document.getElementById('file_nodal_tab1').click()" class="form_input_fields">
						</div>
					</div>
					<div class="company_send text-right">
						<a href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
						<a href="javascript:void(0)" title="Xác nhận" id="btn_xn_id-" class="company_xn btn btn-success">Xác nhận</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="minus_depreciation" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Thêm giảm trừ
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body ">
				<div class="form-group_popup">
					<div class="form_input">
						<label>Nhập tên<span style="color: red;">*</span></label>
						<input type="text" name="name" id="name_minus_dep" placeholder="Nhập tên" class="form_input_fields">
					</div>
					<div class="form_input">
						<label>Upload excel</label>
						<input style="display: none;" type="file" name="file" id="file_nodal_tab2" placeholder="Nhập file" class="form_input">
						<div class="sellect_files">
							 <button onclick="document.getElementById('file_nodal_tab2').click()">Chọn tệp</button>
							 <input type="text" name="file" id="file_tabs2" onclick="document.getElementById('file_nodal_tab2').click()" class="form_input_fields">
						</div>
					</div>
					<div class="company_send text-right">
						<a href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
						<a href="javascript:void(0)" title="Xác nhận" id="btn_xn_id-" class="company_xn btn btn-success">Xác nhận</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_depreciation" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Thêm giảm trừ
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body ">
				<div class="form-group_popup">
					<div class="form_input">
						<div class="row">
							<div class="col-sm-6 text-left">
								Giảm trừ xe dịch vụ biển tỉnh
							</div>
							<div class="col-sm-6 text-right">
								<input class='aiz_switchery' type="checkbox" checked="checked" data-set='status' data-id=""/>
							</div>
						</div>
					</div>
					<div class="company_send text-right">
						<a href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
						<a href="javascript:void(0)" title="Xác nhận" id="btn_xn_id-" class="company_xn btn btn-success">Xác nhận</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="alert_delete_pro_choo" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="delete_property">
		<div class="content">
			<div class="popup_content">
				<h2>Xóa tài sản</h2>
				<p>Nếu xoá tài sản này, mọi lịch sử thay đổi của tài sản cũng sẽ bị xoá đi. Bạn chắc chắn xoá?</p>
			</div>
			<div class="popup_button">
				<div class="row">
					<div class="col-sm-6 text-left">
						<a href="javascript:(0)" title="hủy" class="company_close btn btn-secondary">Hủy</a>
					</div>
					<div class="col-sm-6 text-right">
						<a href="javascript:(0)" title="Xóa" id="" data-value="" data-id="" class="btn btn-danger click_delete_pro">Xóa</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="show_info_item" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal_info">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Xe máy honda Airblade 125
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body_info">
				<div class="modal_body_top">
					<div class="listed">
						<h4>Thông tin xe</h4>
						<div class="row">
							<div class="col-sm-6">
								<p>Thông số tài sản: <strong>Xe ga</strong></p>
							</div>
							<div class="col-sm-6">
								<p>Năm sản xuất: <strong>2018</strong></p>
							</div>
						</div>
					</div>
				</div>
				<div  class="modal_body_middle">
					<div class="title">
						<h4>Cập nhật giá xe và khấu hao</h4>
						<p>
							Giá trị xe: 
							<strong class="show_fe active">51.000.000</strong>
							<input type="text" name="price" class="price_edit display_none form_input" id="edit_id_" value="51.000.000" data-id="" />
						</p>
						<i class="body_click_details fa fa-pencil-square-o"></i>
					</div>
					<div class="tabble_modal_body">
						<table class="table table-striped">
							<thead>
								<tr align="center">
									<td>
										STT
									</td>
									<td>
										Số năm
									</td>
									<td>
										Khấu hao
									</td>
								</tr>
							</thead>
							<tbody>
								<tr align="center">
									<td>
										1
									</td>
									<td>
										1 năm
									</td>
									<td>
										
										<span class="show_fe active">15%</span>
							<input type="text" name="discount" class="discount_edit display_none form_input" id="edit_discount_id_15" value="15%" data-id="" />
									</td>
								</tr>
								<tr align="center">
									<td>
										2
									</td>
									<td>
										2 năm
									</td>
									<td>
										<span class="show_fe active">20%</span>
							<input type="text" name="discount" class="discount_edit display_none form_input" id="edit_discount_id_20" value="20%" data-id="" />
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div  class="modal_body_bottom">
					<div class="company_send text-right">
						<a style="margin-bottom: 10px;" href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
						<a style="margin-bottom: 10px;" href="javascript:void(0)" title="đóng" class="display_none Update_required btn btn-success">Yêu cầu cập nhập</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="show_history_info_item" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal_info">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Lịch sử thay đổi - Xe máy honda Airblade 125
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="list-source_data">
				<div class="scroll-data-top trigger sticky">
					<div class="list_load">
						<div class="list_items">
							<div class="items">
								<div class="dot_stick active">
									<span></span>
								</div>
								<div class="layout-items theme-icon-second items-type-defaults">
									<div class="text-right datecreate item__time_create">
										<span>15/07/2021 15:08:00</span>
									</div>
									<div class="layout_per__change taxonomy__items_show">
										<div class="items__performer">
											<div class="row">
												<div class="col-sm-6">
													<div class="items__inf__old">
														<div class="items__contents">
															<p>Người yêu cầu</p>
															<strong>nguyennv@tienngay.vn</strong>
														</div>
														<div class="items__contents">
															<p>Giá cũ</p>
															<strong>51.000.000đ</strong>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="items__inf__old">
														<div class="items__contents">
															<p>Người thực hiện</p>
															<strong>hongtx@tienngay.vn</strong>
														</div>
														<div class="items__contents">
															<p>Giá cũ</p>
															<strong>45.000.000đ</strong>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="items__table__inyear">
											<table class="table">
												<thead>
													<tr align="center">
														<td>
															STT
														</td>
														<td>
															Số năm
														</td>
														<td>
															Khấu hao cũ
														</td>
														<td>
															Khấu hao mới
														</td>
													</tr>
												</thead>
												<tbody>
													<tr align="center">
														<td>
															1
														</td>
														<td>
															1 năm
														</td>
														<td>
															
															15%
														</td>
														<td>
															
															20%
														</td>
													</tr>
													<tr align="center">
														<td>
															2
														</td>
														<td>
															2 năm
														</td>
														<td>
															
															20%
														</td>
														<td>
															
															25%
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="both"></div>
							</div>
							<div class="items">
								<div class="dot_stick">
									<span></span>
								</div>
								<div class="layout-items theme-icon-second items-type-defaults">
									<div class="text-right datecreate item__time_create">
										<span>15/07/2021 15:08:00</span>
									</div>
									<div class="layout_per__change taxonomy__items_show">
										<div class="items__performer">
											<div class="row">
												<div class="col-sm-6">
													<div class="items__inf__old">
														<div class="items__contents">
															<p>Người yêu cầu</p>
															<strong>nguyennv@tienngay.vn</strong>
														</div>
														<div class="items__contents">
															<p>Giá cũ</p>
															<strong>51.000.000đ</strong>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="items__inf__old">
														<div class="items__contents">
															<p>Người thực hiện</p>
															<strong>hongtx@tienngay.vn</strong>
														</div>
														<div class="items__contents">
															<p>Giá cũ</p>
															<strong>45.000.000đ</strong>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="items__table__inyear">
											<table class="table">
												<thead>
													<tr align="center">
														<td>
															STT
														</td>
														<td>
															Số năm
														</td>
														<td>
															Khấu hao cũ
														</td>
														<td>
															Khấu hao mới
														</td>
													</tr>
												</thead>
												<tbody>
													<tr align="center">
														<td>
															1
														</td>
														<td>
															1 năm
														</td>
														<td>
															
															15%
														</td>
														<td>
															
															20%
														</td>
													</tr>
													<tr align="center">
														<td>
															2
														</td>
														<td>
															2 năm
														</td>
														<td>
															
															20%
														</td>
														<td>
															
															25%
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="both"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div  class="modal-header">
				<div class="company_send text-right">
					<a href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="ovelay"></div>
<script src="<?php echo base_url(); ?>assets/js/property/oto.js"></script>
<style type="text/css">
	.marquee
	{
		display: none;
	}
	.modal
	{
		opacity: 1;
	}
	.company_close.btn-secondary {
	    background: #EFF0F1;
	    color: #000;
	    border: 1px solid;	
	}
	.checkbox
	{
		filter: invert(1%) hue-rotate(290deg) brightness(1);
	}
	.btn_bar
	{
		border-style: none;
		background: unset;
		margin-bottom: 0;
	}
	.hover
	{
		display: none;
	}
	.btn_bar:hover .not_hover
	{
		display: none;
	}
	.btn_bar:hover .hover
	{
		display: block;
		margin-bottom: -4px;
	}
	.propertype
	{
		position: absolute;
	    border-top: unset !important;
    	padding: 6px !important;
	}
	.propertype .dropdown-menu
	{
		left: -105px;
	}
	#alert_delete_pro_choo .delete_property
	{
		position: fixed;
	    width: 378px;
	    height: 175px;
	    background: #fff;
	    top: 0;
	    left: 0;
	    right: 0;
	    bottom: 0;
	    margin: auto;
	    display: flex;
	    align-items: center;
	    border-radius: 5px;
	    border-top: 2px solid #D63939;
	    padding: 0 25px;
	    color: #000;
	}
	#alert_delete_pro_choo .delete_property .popup_content h2
	{
		color: #000;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
	    $('.btn-fitler button.btn-success').on('click', function() {
	        $('.drop_select').toggle();
	    });
	    $('.btn-fitler_tab2 button.btn-success').on('click', function() {
	        $('.drop_select_tab2').toggle();
	    });
	    $('.btn-fitler_tab3 button.btn-success').on('click', function() {
	        $('.drop_select_tab3').toggle();
	    });
	    $('#btn_add_dep').on('click', function() {
	        $('#add_depreciation').show();
	        $('.ovelay').show();
	    });
	    $('#btn_minus_dep').on('click', function() {
	        $('#minus_depreciation').show();
	        $('.ovelay').show();
	    });
	    $('#btn_edit_dep').on('click', function() {
	        $('#edit_depreciation').show();
	        $('.ovelay').show();
	    });
	    $('.show_info_btn_chose').on('click', function() {
	    	var id = $(this).attr("data-id");
	        $('#show_info_item').show();
	        $('.price_edit').hide();
	        $('.discount_edit').hide();
	        $('.Update_required').hide();
	        $('.ovelay').show();
	    });
	    $('.click_delete_pro').on('click', function() {
	    	var id = $(this).attr("data-id");
	        $('#successModal').show();
	        $('.ovelay').show();
	    });
	    $('.show_history_info_btn').on('click', function() {
	    	var id = $(this).attr("data-id");
	        $('#show_history_info_item').show();
	        $('.ovelay').show();
	    });
	    $('.Update_required').on('click', function() {
	        $('#successModal').show();
	        $('.ovelay').show();
	    });
	    $('.body_click_details').on('click', function() {
	        $('.show_fe').toggle();
	        $('.price_edit').toggle();
	        $('.discount_edit').toggle();
	        $('.Update_required').toggle('inline-block');
	    });
	    
	    $('.company_close').on('click', function() {
	    	$('#add_depreciation').hide();
	    	$('#minus_depreciation').hide();
	        $('#edit_depreciation').hide();
	        $('#successModal').hide();
	        $('#successModal').hide();
	        $('#alert_delete_pro_choo').hide();
	        $('#show_info_item').hide();
	        $('#show_history_info_item').hide();
	        $('.ovelay').hide();
	    });
	    $('ul.tabs li').click(function(){
	      var tab_id = $(this).attr('data-tab');
	      $('ul.tabs li').removeClass('active');
	      $('.tab-panel').removeClass('active');
	      $(this).addClass('active');
	      $("#"+tab_id).addClass('active');
	  	})
	  	$('.list_items .items').click(function() {
	  		$('.dot_stick').removeClass('active');
	  		$(this).children().addClass('active');
	      $('.list-source_data').animate({
	        scrollTop: $(this).offset().top - 10
	      }, 1000)
	    })
	});
</script>
<script type="text/javascript">
	function selectAll(invoker)
	{
        var inputElements = document.getElementsByTagName('input');
        for (var i = 0 ; i < inputElements.length ; i++) 
        {
            var myElement = inputElements[i];
            if (myElement.type === "checkbox") 
            {
                myElement.checked = invoker.checked;
            }

        }
        $('.detele-all').toggle();
	}
</script>
<script>
$(document).ready(function () {
   set_switchery();
    function set_switchery() {
        $(".aiz_switchery").each(function () {
            new Switchery($(this).get(0), {
                color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'});
        });
    }
    });
</script>
<link href="<?php echo base_url('assets/')?>/js/switchery/switchery.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/')?>/js/switchery/switchery.min.js"></script>