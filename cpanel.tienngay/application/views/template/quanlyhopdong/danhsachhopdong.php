
<div class="list-contract right_col" role="main">

	<div class="page-title">
		<div class="title_left">
			<h3 class="page-title">Hội sở/ Quản lý hợp đồng</h3>
		</div>

		<div class="title_right text-right">
			<div class="btn-group">
				<button data-toggle="modal" data-target=".modal-info" class="btn btn-primary">Tạo mới</button>

			</div>
		</div>

	</div>

	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="x_panel table-responsive">
				<div class="col-md-8 col-xs-12 mt-1">
					<h4 class="text-uppercase">DANH SÁCH HỢP ĐỒNG</h4>
				</div>
				<div class="col-md-4 col-xs-12 mt-1 plr-0">
					<button class="btn btn-primary pull-right" style="margin-right: 0px; margin-bottom: 10px">Xuất excel</button>
					<div class="col-md-11 col-xs-12 plr-0">
						<div class="input-group">
							<div class="input-group-btn">
								<select class="form-control" style="width: 220px;border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
									<option  value="" selected>Mã phiếu ghi</option>
									<option  value="">Số điện thoại</option>
									<option  value="">CMND cũ/CCCD/ Hộ chiếu</option>
									<option  value="">Mã phiếu ghi</option>
									<option  value="">Mã hợp đồng</option>
									<option  value="">Tên tài sản</option>
								</select>
							</div>
							<input type="text" class="form-control" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
							<span class="fa fa-search form-control-feedback right" style="border-left: none; font-size: 20px!important; margin-top: 5px; right: 0" aria-hidden="true"></span>
						</div>
					</div>

					<div class="col-md-1 col-xs-12 icon--filter plr-0" >
						<button class="btn btn-primary" onclick="showFilterBox(this)">
								<i class="fa fa-filter show-filter"></i>
						</button>
					</div>


					<div class="col-md-12 col-xs-12 box__filter">
						<div class="col-md-12 col-xs-12  pl-0 pr-0 box-filter ">
							<h3 class="box__title">Thông tin cá nhân
								<i class="fa fa-chevron-down float-right filter-show" style="cursor: pointer" data-id="1"></i>
							</h3>
							<div class="col-md-12 col-xs-12 filter-detail-1 box-filter">
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Họ và tên</label>
										<input type="text" class="form-control" placeholder="Họ và tên">
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Số điện thoại</label>
										<input type="number" class="form-control" placeholder="Số điện thoại">
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">CCCD/ CMND cũ/ Hộ chiếu</label>
										<input type="number" class="form-control" placeholder="022xxx ">
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Khu vực</label>
										<select name="" id="" class="form-control">
											<option value="">- Chọn khu vực - </option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Phòng giao dịch</label>
										<select name="" id="" class="form-control">
											<option value="">- Chọn PGD - </option>
										</select>
									</div>
								</div>
							</div>

						</div>
						<div class="col-md-12 col-xs-12  pl-0 pr-0 box-filter">
							<h3 class="box__title">
								Thông tin hợp đồng
								<i class="fa fa-chevron-right float-right filter-show" style="cursor: pointer" data-id="2"></i>
							</h3>
							<div class="col-md-12 col-xs-12 filter-detail-2 box-filter" style="display: none">
								<div class="col-md-6 col-xs-12 ">
									<div class="form-group">
										<label for="">Mã hợp đồng  </label>
										<input type="text" class="form-control" placeholder="Mã hợp đồng ">
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Mã phiếu ghi</label>
										<input type="text" class="form-control" placeholder="Mã phiếu ghi ">
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Trạng thái hợp đồng</label>
										<select name="" id="" class="form-control">
											<option value="">- Chọn trạng thái hợp đồng - </option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Chương trình ưu đãi</label>
										<select name="" id="" class="form-control">
											<option value="">- Chọn chương trình ưu đãi -  </option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<label for="">Hình thức vay</label>
									<select name="" id="" class="form-control">
										<option value="">- Chọn hình thức vay -  </option>
									</select>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Hình thức trả lãi</label>
										<select name="" id="" class="form-control">
											<option value="">- Chọn hình thức trả lãi - </option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-xs-12  pl-0 pr-0 box-filter">
							<h3 class="box__title">
								Thông tin tài sản
								<i class="fa fa-chevron-right float-right filter-show" style="cursor: pointer" data-id="3"></i>
							</h3>
							<div class="col-md-12 col-xs-12 filter-detail-3 box-filter" style="display: none">
								<div class="col-md-6 col-xs-12">
									<label for="">Loại tài sản</label>
									<select name="" id="" class="form-control">
										<option value="">- Chọn loại tài sản -  </option>
									</select>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="">Tên tài sản</label>
										<input type="text" class="form-control" placeholder="Tên tài sản">
									</div>
								</div>
								<div class="col-md-12-col-xs-12">
									<div class="form-group col-md-12 col-xs-12">
										<label for=""> Thông tin tài sản</label>
										<div class="input-group">
											<div class="input-group-btn">
												<select name="" id="" class="form-control" style="width: 140px">
													<option value="" selected>Số khung</option>
													<option value="">Số máy</option>
													<option value="">Biển số xe</option>
												</select>
											</div>
											<input type="text" class="form-control" placeholder="Thông tin tài sản">
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-xs-12 text-right">
							<button class="btn" style="background-color: white">Xóa</button>
							<button class="btn btn-secondary" onclick="hideFilterBox(this)">Hủy</button>
							<button class="btn btn-primary" onclick="dataFilter(this)">Tìm kiếm</button>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-xs-12 pl-0 pr-0">
					<table class="table mt-1 ">
						<thead>
						<tr>
							<th>STT</th>
							<th>Mã hợp đồng</th>
							<th>Mã phiếu ghi</th>
							<th>Tên khách hàng</th>
							<th>Tài sản</th>
							<th class="text-right">Tiền vay</th>
							<th>Thời hạn vay</th>
							<th>Trạng thái hợp đồng</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<tr  class="collapse-link-config cursor-p" >
							<td>1</td>
							<td>HĐCC/ĐKXM/HCM28ĐXH/2104/02</td>
							<td>000008307</td>
							<td>NGUYỄN TRƯƠNG BẢO HÒA</td>
							<td>Xe Máy Airblade 150 2020</td>
							<td class="text-right">20,000,000</td>
							<td>12 tháng</td>
							<td>Hội sở duyệt gia hạn</td>
							<td>
								<ul class="nav navbar-right panel_toolbox">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</a>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="#"><i class="fa fa-eye"></i> Xem chứng từ</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-file-text-o"></i> Chi tiết hồ sơ</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-edit"></i> Sửa hợp đồng</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-print"></i> In hợp đồng</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-history"></i> Xem lịch sử</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-phone"></i> Gọi</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-calendar-o"></i> Danh sách cuộc gọi</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-book"></i> Hợp đồng liên quan</a>
											</li>
										</ul>
									</li>
									<li><a><i class="fa fa-chevron-right" data-id="1"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="contract-detail-1"  style="display: none">
							<td colspan="9" style="background-color: rgba(242,242,242, 0.4)">
								<div class="col-md-12 col-xs-12 ">
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN KHOẢN VAY</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức vay</span>
												<p class="box--p">Cầm cố</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Loại tài sản</span>
												<p class="box--p">Xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Sản phẩm vay</span>
												<p class="box--p">Vay nhanh xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Tên tài sản</span>
												<p class="box--p">Xe máy Airblade 150 2020</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Khấu hao tài sản</span>
												<p class="box--p">1 năm</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nơi cất giữ xe</span>
												<p class="box--p">-</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Giá trị tài sản</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền được vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền giải ngân</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Mục đích vay tiền</span>
												<p class="box--p">Vay tiêu dùng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức trả lãi</span>
												<p class="box--p">Lãi hàng tháng, gốc hàng tháng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Thời gian vay</span>
												<p class="box--p">90</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Chu kì đóng lãi</span>
												<p class="box--p">30</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN TÀI SẢN</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Họ tên chủ xe</span>
												<p class="box--p">NGUYỄN TRƯƠNG BẢO HÒA</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Biển số xe</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nhãn hiệu</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Model</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số khung</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số máy</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Địa chỉ đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Ngày cấp đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN BẢO HIỂM</h3>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>

									</div>
								</div>
							</td>
						</tr>
						<tr class="collapse-link-config cursor-p">
							<td>2</td>
							<td>HĐCC/ĐKXM/HCM28ĐXH/2104/02</td>
							<td>000008307</td>
							<td>NGUYỄN TRƯƠNG BẢO HÒA</td>
							<td>Xe Máy Airblade 150 2020</td>
							<td class="text-right">20,000,000</td>
							<td>12 tháng</td>
							<td>Hội sở duyệt gia hạn</td>
							<td>
								<ul class="nav navbar-right panel_toolbox">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Xem chứng từ</a>
											</li>
											<li><a href="#">Chi tiết hồ sơ</a>
											</li>
											<li><a href="#">Sửa hợp đồng</a>
											</li>
											<li><a href="#">In hợp đồng</a>
											</li>
											<li><a href="#">Xem lịch sử</a>
											</li>
											<li><a href="#">Gọi</a>
											</li>
											<li><a href="#">Danh sách cuộc gọi</a>
											</li>
											<li><a href="#">Hợp đồng liên quan</a>
											</li>
										</ul>
									</li>
									<li><a><i class="fa fa-chevron-right" data-id="2"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="contract-detail-2"  style="display: none">
							<td colspan="9" style="background-color: rgba(242,242,242, 0.4)">
								<div class="col-md-12 col-xs-12 ">
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN KHOẢN VAY</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức vay</span>
												<p class="box--p">Cầm cố</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Loại tài sản</span>
												<p class="box--p">Xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Sản phẩm vay</span>
												<p class="box--p">Vay nhanh xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Tên tài sản</span>
												<p class="box--p">Xe máy Airblade 150 2020</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Khấu hao tài sản</span>
												<p class="box--p">1 năm</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nơi cất giữ xe</span>
												<p class="box--p">-</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Giá trị tài sản</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền được vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền giải ngân</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Mục đích vay tiền</span>
												<p class="box--p">Vay tiêu dùng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức trả lãi</span>
												<p class="box--p">Lãi hàng tháng, gốc hàng tháng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Thời gian vay</span>
												<p class="box--p">90</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Chu kì đóng lãi</span>
												<p class="box--p">30</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN TÀI SẢN</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Họ tên chủ xe</span>
												<p class="box--p">NGUYỄN TRƯƠNG BẢO HÒA</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Biển số xe</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nhãn hiệu</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Model</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số khung</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số máy</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Địa chỉ đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Ngày cấp đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN BẢO HIỂM</h3>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>

									</div>
								</div>
							</td>
						</tr>
						<tr class="collapse-link-config cursor-p">
							<td>3</td>
							<td>HĐCC/ĐKXM/HCM28ĐXH/2104/02</td>
							<td>000008307</td>
							<td>NGUYỄN TRƯƠNG BẢO HÒA</td>
							<td>Xe Máy Airblade 150 2020</td>
							<td class="text-right">20,000,000</td>
							<td>12 tháng</td>
							<td>Hội sở duyệt gia hạn</td>
							<td>
								<ul class="nav navbar-right panel_toolbox">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Xem chứng từ</a>
											</li>
											<li><a href="#">Chi tiết hồ sơ</a>
											</li>
											<li><a href="#">Sửa hợp đồng</a>
											</li>
											<li><a href="#">In hợp đồng</a>
											</li>
											<li><a href="#">Xem lịch sử</a>
											</li>
											<li><a href="#">Gọi</a>
											</li>
											<li><a href="#">Danh sách cuộc gọi</a>
											</li>
											<li><a href="#">Hợp đồng liên quan</a>
											</li>
										</ul>
									</li>
									<li><a><i class="fa fa-chevron-right" data-id="3"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="contract-detail-3"  style="display: none">
							<td colspan="9" style="background-color: rgba(242,242,242, 0.4)">
								<div class="col-md-12 col-xs-12 ">
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN KHOẢN VAY</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức vay</span>
												<p class="box--p">Cầm cố</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Loại tài sản</span>
												<p class="box--p">Xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Sản phẩm vay</span>
												<p class="box--p">Vay nhanh xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Tên tài sản</span>
												<p class="box--p">Xe máy Airblade 150 2020</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Khấu hao tài sản</span>
												<p class="box--p">1 năm</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nơi cất giữ xe</span>
												<p class="box--p">-</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Giá trị tài sản</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền được vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền giải ngân</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Mục đích vay tiền</span>
												<p class="box--p">Vay tiêu dùng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức trả lãi</span>
												<p class="box--p">Lãi hàng tháng, gốc hàng tháng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Thời gian vay</span>
												<p class="box--p">90</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Chu kì đóng lãi</span>
												<p class="box--p">30</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN TÀI SẢN</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Họ tên chủ xe</span>
												<p class="box--p">NGUYỄN TRƯƠNG BẢO HÒA</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Biển số xe</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nhãn hiệu</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Model</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số khung</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số máy</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Địa chỉ đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Ngày cấp đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN BẢO HIỂM</h3>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>

									</div>
								</div>
							</td>
						</tr>
						<tr class="collapse-link-config cursor-p">
							<td>4</td>
							<td>HĐCC/ĐKXM/HCM28ĐXH/2104/02</td>
							<td>000008307</td>
							<td>NGUYỄN TRƯƠNG BẢO HÒA</td>
							<td>Xe Máy Airblade 150 2020</td>
							<td class="text-right">20,000,000</td>
							<td>12 tháng</td>
							<td>Hội sở duyệt gia hạn</td>
							<td>
								<ul class="nav navbar-right panel_toolbox">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Xem chứng từ</a>
											</li>
											<li><a href="#">Chi tiết hồ sơ</a>
											</li>
											<li><a href="#">Sửa hợp đồng</a>
											</li>
											<li><a href="#">In hợp đồng</a>
											</li>
											<li><a href="#">Xem lịch sử</a>
											</li>
											<li><a href="#">Gọi</a>
											</li>
											<li><a href="#">Danh sách cuộc gọi</a>
											</li>
											<li><a href="#">Hợp đồng liên quan</a>
											</li>
										</ul>
									</li>
									<li><a><i class="fa fa-chevron-right" data-id="4"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="contract-detail-4"  style="display: none">
							<td colspan="9" style="background-color: rgba(242,242,242, 0.4)">
								<div class="col-md-12 col-xs-12 ">
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN KHOẢN VAY</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức vay</span>
												<p class="box--p">Cầm cố</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Loại tài sản</span>
												<p class="box--p">Xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Sản phẩm vay</span>
												<p class="box--p">Vay nhanh xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Tên tài sản</span>
												<p class="box--p">Xe máy Airblade 150 2020</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Khấu hao tài sản</span>
												<p class="box--p">1 năm</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nơi cất giữ xe</span>
												<p class="box--p">-</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Giá trị tài sản</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền được vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền giải ngân</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Mục đích vay tiền</span>
												<p class="box--p">Vay tiêu dùng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức trả lãi</span>
												<p class="box--p">Lãi hàng tháng, gốc hàng tháng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Thời gian vay</span>
												<p class="box--p">90</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Chu kì đóng lãi</span>
												<p class="box--p">30</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN TÀI SẢN</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Họ tên chủ xe</span>
												<p class="box--p">NGUYỄN TRƯƠNG BẢO HÒA</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Biển số xe</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nhãn hiệu</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Model</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số khung</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số máy</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Địa chỉ đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Ngày cấp đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN BẢO HIỂM</h3>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>

									</div>
								</div>
							</td>
						</tr>
						<tr class="collapse-link-config cursor-p">
							<td>5</td>
							<td>HĐCC/ĐKXM/HCM28ĐXH/2104/02</td>
							<td>000008307</td>
							<td>NGUYỄN TRƯƠNG BẢO HÒA</td>
							<td>Xe Máy Airblade 150 2020</td>
							<td class="text-right">20,000,000</td>
							<td>12 tháng</td>
							<td>Hội sở duyệt gia hạn</td>
							<td>
								<ul class="nav navbar-right panel_toolbox">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Xem chứng từ</a>
											</li>
											<li><a href="#">Chi tiết hồ sơ</a>
											</li>
											<li><a href="#">Sửa hợp đồng</a>
											</li>
											<li><a href="#">In hợp đồng</a>
											</li>
											<li><a href="#">Xem lịch sử</a>
											</li>
											<li><a href="#">Gọi</a>
											</li>
											<li><a href="#">Danh sách cuộc gọi</a>
											</li>
											<li><a href="#">Hợp đồng liên quan</a>
											</li>
										</ul>
									</li>
									<li><a ><i class="fa fa-chevron-right" data-id="5"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="contract-detail-5"  style="display: none">
							<td colspan="9" style="background-color: rgba(242,242,242, 0.4)">
								<div class="col-md-12 col-xs-12 ">
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN KHOẢN VAY</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức vay</span>
												<p class="box--p">Cầm cố</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Loại tài sản</span>
												<p class="box--p">Xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Sản phẩm vay</span>
												<p class="box--p">Vay nhanh xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Tên tài sản</span>
												<p class="box--p">Xe máy Airblade 150 2020</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Khấu hao tài sản</span>
												<p class="box--p">1 năm</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nơi cất giữ xe</span>
												<p class="box--p">-</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Giá trị tài sản</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền được vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền giải ngân</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Mục đích vay tiền</span>
												<p class="box--p">Vay tiêu dùng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức trả lãi</span>
												<p class="box--p">Lãi hàng tháng, gốc hàng tháng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Thời gian vay</span>
												<p class="box--p">90</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Chu kì đóng lãi</span>
												<p class="box--p">30</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN TÀI SẢN</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Họ tên chủ xe</span>
												<p class="box--p">NGUYỄN TRƯƠNG BẢO HÒA</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Biển số xe</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nhãn hiệu</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Model</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số khung</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số máy</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Địa chỉ đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Ngày cấp đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN BẢO HIỂM</h3>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>

									</div>
								</div>
							</td>
						</tr>
						<tr class="collapse-link-config cursor-p">
							<td>6</td>
							<td>HĐCC/ĐKXM/HCM28ĐXH/2104/02</td>
							<td>000008307</td>
							<td>NGUYỄN TRƯƠNG BẢO HÒA</td>
							<td>Xe Máy Airblade 150 2020</td>
							<td class="text-right">20,000,000</td>
							<td>12 tháng</td>
							<td>Hội sở duyệt gia hạn</td>
							<td>
								<ul class="nav navbar-right panel_toolbox">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Xem chứng từ</a>
											</li>
											<li><a href="#">Chi tiết hồ sơ</a>
											</li>
											<li><a href="#">Sửa hợp đồng</a>
											</li>
											<li><a href="#">In hợp đồng</a>
											</li>
											<li><a href="#">Xem lịch sử</a>
											</li>
											<li><a href="#">Gọi</a>
											</li>
											<li><a href="#">Danh sách cuộc gọi</a>
											</li>
											<li><a href="#">Hợp đồng liên quan</a>
											</li>
										</ul>
									</li>
									<li><a ><i class="fa fa-chevron-right" data-id="6"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="contract-detail-6"  style="display: none">
							<td colspan="9" style="background-color: rgba(242,242,242, 0.4)">
								<div class="col-md-12 col-xs-12 ">
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN KHOẢN VAY</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức vay</span>
												<p class="box--p">Cầm cố</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Loại tài sản</span>
												<p class="box--p">Xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Sản phẩm vay</span>
												<p class="box--p">Vay nhanh xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Tên tài sản</span>
												<p class="box--p">Xe máy Airblade 150 2020</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Khấu hao tài sản</span>
												<p class="box--p">1 năm</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nơi cất giữ xe</span>
												<p class="box--p">-</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Giá trị tài sản</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền được vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền giải ngân</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Mục đích vay tiền</span>
												<p class="box--p">Vay tiêu dùng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức trả lãi</span>
												<p class="box--p">Lãi hàng tháng, gốc hàng tháng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Thời gian vay</span>
												<p class="box--p">90</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Chu kì đóng lãi</span>
												<p class="box--p">30</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN TÀI SẢN</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Họ tên chủ xe</span>
												<p class="box--p">NGUYỄN TRƯƠNG BẢO HÒA</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Biển số xe</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nhãn hiệu</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Model</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số khung</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số máy</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Địa chỉ đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Ngày cấp đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN BẢO HIỂM</h3>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>

									</div>
								</div>
							</td>
						</tr>
						<tr class="collapse-link-config cursor-p">
							<td>7</td>
							<td>HĐCC/ĐKXM/HCM28ĐXH/2104/02</td>
							<td>000008307</td>
							<td>NGUYỄN TRƯƠNG BẢO HÒA</td>
							<td>Xe Máy Airblade 150 2020</td>
							<td class="text-right">20,000,000</td>
							<td>12 tháng</td>
							<td>Hội sở duyệt gia hạn</td>
							<td>
								<ul class="nav navbar-right panel_toolbox">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Xem chứng từ</a>
											</li>
											<li><a href="#">Chi tiết hồ sơ</a>
											</li>
											<li><a href="#">Sửa hợp đồng</a>
											</li>
											<li><a href="#">In hợp đồng</a>
											</li>
											<li><a href="#">Xem lịch sử</a>
											</li>
											<li><a href="#">Gọi</a>
											</li>
											<li><a href="#">Danh sách cuộc gọi</a>
											</li>
											<li><a href="#">Hợp đồng liên quan</a>
											</li>
										</ul>
									</li>
									<li><a ><i class="fa fa-chevron-right" data-id="7"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="contract-detail-7"  style="display: none">
							<td colspan="9" style="background-color: rgba(242,242,242, 0.4)">
								<div class="col-md-12 col-xs-12 ">
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN KHOẢN VAY</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức vay</span>
												<p class="box--p">Cầm cố</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Loại tài sản</span>
												<p class="box--p">Xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Sản phẩm vay</span>
												<p class="box--p">Vay nhanh xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Tên tài sản</span>
												<p class="box--p">Xe máy Airblade 150 2020</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Khấu hao tài sản</span>
												<p class="box--p">1 năm</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nơi cất giữ xe</span>
												<p class="box--p">-</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Giá trị tài sản</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền được vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền giải ngân</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Mục đích vay tiền</span>
												<p class="box--p">Vay tiêu dùng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức trả lãi</span>
												<p class="box--p">Lãi hàng tháng, gốc hàng tháng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Thời gian vay</span>
												<p class="box--p">90</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Chu kì đóng lãi</span>
												<p class="box--p">30</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN TÀI SẢN</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Họ tên chủ xe</span>
												<p class="box--p">NGUYỄN TRƯƠNG BẢO HÒA</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Biển số xe</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nhãn hiệu</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Model</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số khung</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số máy</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Địa chỉ đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Ngày cấp đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN BẢO HIỂM</h3>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>

									</div>
								</div>
							</td>
						</tr>
						<tr class="collapse-link-config cursor-p">
							<td>8</td>
							<td>HĐCC/ĐKXM/HCM28ĐXH/2104/02</td>
							<td>000008307</td>
							<td>NGUYỄN TRƯƠNG BẢO HÒA</td>
							<td>Xe Máy Airblade 150 2020</td>
							<td class="text-right">20,000,000</td>
							<td>12 tháng</td>
							<td>Hội sở duyệt gia hạn</td>
							<td>
								<ul class="nav navbar-right panel_toolbox">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Xem chứng từ</a>
											</li>
											<li><a href="#">Chi tiết hồ sơ</a>
											</li>
											<li><a href="#">Sửa hợp đồng</a>
											</li>
											<li><a href="#">In hợp đồng</a>
											</li>
											<li><a href="#">Xem lịch sử</a>
											</li>
											<li><a href="#">Gọi</a>
											</li>
											<li><a href="#">Danh sách cuộc gọi</a>
											</li>
											<li><a href="#">Hợp đồng liên quan</a>
											</li>
										</ul>
									</li>
									<li><a ><i class="fa fa-chevron-right" data-id="8"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<tr class="contract-detail-8"  style="display: none">
							<td colspan="9" style="background-color: rgba(242,242,242, 0.4)">
								<div class="col-md-12 col-xs-12 ">
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN KHOẢN VAY</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức vay</span>
												<p class="box--p">Cầm cố</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Loại tài sản</span>
												<p class="box--p">Xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Sản phẩm vay</span>
												<p class="box--p">Vay nhanh xe máy</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Tên tài sản</span>
												<p class="box--p">Xe máy Airblade 150 2020</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Khấu hao tài sản</span>
												<p class="box--p">1 năm</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nơi cất giữ xe</span>
												<p class="box--p">-</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Giá trị tài sản</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền được vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền vay</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số tiền giải ngân</span>
												<p class="box--p">30,000,000 VNĐ</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Mục đích vay tiền</span>
												<p class="box--p">Vay tiêu dùng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Hình thức trả lãi</span>
												<p class="box--p">Lãi hàng tháng, gốc hàng tháng</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Thời gian vay</span>
												<p class="box--p">90</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Chu kì đóng lãi</span>
												<p class="box--p">30</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN TÀI SẢN</h3>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Họ tên chủ xe</span>
												<p class="box--p">NGUYỄN TRƯƠNG BẢO HÒA</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Biển số xe</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Nhãn hiệu</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Model</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số khung</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số máy</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Số đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Địa chỉ đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="box__detail">
												<span class="box--span">Ngày cấp đăng ký</span>
												<p class="box--p">BMWCivicHonDa</p>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<h3 class="box__title">THÔNG TIN BẢO HIỂM</h3>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>
										<div class="col-md-12 col-xs-12 ">
											<div class="box__detail pt-0 pb-0">
												<p class="box--p">Bảo hiểm xe máy (easy) GIC:
													<span class="box--span">GIC_EASY_20</span>
													<span class="box--span--right text-right">348.000 VNĐ</span>
												</p>

											</div>
										</div>

									</div>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<div class="col-dm-12 col-xs-12">
					<div class="col-md-1 col-xs-6 p-0">
						<div class="col-md-6 col-xs-12 p-0">
							<label style="margin-top: 8px">Hiển thị</label>
						</div>
						<div class="col-md-6 col-xs-12 p-0">
							<select name="" id="" class="form-control" style="display: inline">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-success" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-confirm-success">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title">Xác nhận tạo hợp đồng mới</h4>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.</p>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default"
						data-dismiss="modal">Done!</button>
			</div>

		</div>
	</div>
</div>
<div class="modal fade modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-confirm-danger">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box success">
					<i class="fa fa-close"></i>
				</div>
				<h4 class="modal-title">Xác nhận tạo hợp đồng mới</h4>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.</p>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default"
						data-dismiss="modal">Done!</button>
			</div>

		</div>
	</div>
</div>
<div class="modal fade modal-info" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-confirm-info">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box success">
					<i class="fa fa-exclamation"></i>
				</div>
				<h4 class="modal-title">Xác nhận tạo hợp đồng mới</h4>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.</p>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default"
						data-dismiss="modal">Done!</button>
			</div>

		</div>
	</div>
</div>
<div id='toTop'>
	<i class="fa fa-arrow-circle-up"></i>
</div>
<script>
	$('.collapse-link-config').on('click', function(e) {
		if(e.target.tagName.toLowerCase() != "a" && e.target.tagName.toLowerCase() != "i" || e.target.classList[1] == "fa-chevron-right"|| e.target.classList[1] == "fa-chevron-down") {
			let $BOX_PANEL = $(this).closest('.x_panel'),
					$ICON = $(this).find('ul li:last-child i'),
					$BOX_CONTENT = $BOX_PANEL.find('.contract-detail-'+$ICON.data("id"));
			// fix for some div with hardcoded fix class
			if ($BOX_PANEL.attr('style')) {
				$BOX_CONTENT.slideToggle(200, function(){
					$BOX_PANEL.removeAttr('style');
				});
			} else {
				$BOX_CONTENT.slideToggle(200);
				$BOX_PANEL.css('height', 'auto');
			}
			$ICON.toggleClass('fa-chevron-right fa-chevron-down');
		}
	});
	$('.filter-show').on('click', function() {
		var $BOX_PANEL = $(this).closest('.box-filter'),
				$ICON = $(this),
				$BOX_CONTENT = $BOX_PANEL.find('.filter-detail-'+$ICON.data("id"));
		// fix for some div with hardcoded fix class
		if ($BOX_PANEL.attr('style')) {
			$BOX_CONTENT.slideToggle(300, function(){
				$BOX_PANEL.removeAttr('style');
			});
		} else {
			$BOX_CONTENT.slideToggle(300);
			$BOX_PANEL.css('height', 'auto');
		}
		$ICON.toggleClass('fa-chevron-right fa-chevron-down');
	});
	function showFilterBox(){
		if ($('.box__filter').css('display') === 'none'){
			$('.box__filter').slideToggle(300, function(){
				$('.box__filter').css('display', 'block')
			});
		}else{
			$('.box__filter').slideToggle(300, function(){
				$('.box__filter').css('display', 'none')
			});
		}
	}
	function hideFilterBox(){
		$('.box__filter').slideToggle(300, function(){
			$('.box__filter').css('display', 'none')
		});
	}
	function dataFilter(){
		$('.icon--filter .btn-primary').addClass('button--filter');
		$('.box__filter').slideToggle(300, function(){
			$('.box__filter').css('display', 'none')
		});
	}

//	back to top
	$(window).scroll(function() {
		if ($(this).scrollTop()) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});

	$("#toTop").click(function() {
		$("html, body").animate({scrollTop: 0}, 500);
	});
</script>
