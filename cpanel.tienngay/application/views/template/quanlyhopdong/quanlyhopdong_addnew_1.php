


<!-- Modal -->
<div class="modal fade" id="dsHopDongLienQuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Danh sách hợp đồng liên quan</h5>
			</div>
			<div class="modal-body">
				<table class="table jambo_table">
					<thead>
					<tr>
						<td>STT</td>
						<td>Mã hợp đồng</td>
						<td>Cửa hàng</td>
						<td>Trạng thái</td>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="x_panel">
	<div class="row">
		<div class="col-xs-12">
			<h4 class="text-uppercase bg-secondary">
				Thông tin nhận dạng:
				<hr>
			</h4>
		</div>
		<input type="hidden" hidden id="isBlacklist" value="2">
		<div class="col-xs-12">
			<strong>Loại khách hàng:</strong>
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" id="new-customer-tab" style="cursor: pointer" class="active">
					<a href="#new-customer" aria-controls="new-customer"  role="tab" data-toggle="tab" aria-expanded="true">
						<input type="radio" name="customer" checked="checked"  style="cursor: pointer">
						Khách hàng mới
					</a>
				</li>
				<li role="presentation" id="old-customer-tab" style="cursor: pointer" class="">
					<a href="#old-customer" aria-controls="old-customer" role="tab"  data-toggle="tab" aria-expanded="false">
						<input type="radio" name="customer" style="cursor: pointer">
						Khách hàng cũ
					</a>
				</li>
			</ul>
		</div>
		<div id="myTabContentBH" class="tab-content col-md-12 col-xs-12 nopadding">
			<div role="tabpanel" class="tab-pane fade active in" id="new-customer" aria-labelledby="home-tab">
				<div class="col-md-12 col-xs-12">
					<div class="form-group mb-3">
						<div class="col-md-12 col-xs-12 nopadding">
							<div class="x_title" style="padding-left: 0">
								<strong><i class="fa fa-user" aria-hidden="true"></i> So khớp CCCD và chân dung</strong>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân, Hộ chiếu</p>
								<div class="row">
									<div class="col-xs-12 col-md-4 text-left form-add-image">
										<div>
											<p>Mặt trước</p>
											<img id="imgImg_mattruoc" style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;" src="<?php echo base_url();?>assets/imgs/icon/background-add.svg" alt="">
											<input type="file" data-preview="imgInp004" style="visibility: hidden;">
										</div>
									</div>
									<div class="col-md-4 col-xs-12 text-center form-add-image">
										<p class="text-left" style="margin-left: 12%">Mặt sau</p>
										<img id="imgImg_matsau" style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;" src="<?php echo base_url();?>assets/imgs/icon/background-add.svg" alt="">
										<input type="file" data-preview="imgInp005" style="visibility: hidden;">
									</div>
									<div class="col-xs-12 col-md-4 text-right form-add-image">
										<p class="text-left" style="margin-left: 24%">Ảnh chân dung</p>
										<img id="imgImg_chandung" style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;" src="<?php echo base_url();?>assets/imgs/icon/background-add.svg" alt="">
										<input type="file" data-preview="imgInp006" style="visibility: hidden;">
									</div>
								</div>
								<div id="cvs_customer_info" class="row" style="display: none;">
									<div class="col-md-12 col-xs-12">
										<h4>Thông tin khách hàng</h4>
										<div class="text-center" id="Identify_loading" style="display: none;">
											<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
											<div >Đang xử lý...</div>
										</div>
										<table class="table table-bordered">
											<tbody id='list_info_Identify'>

											</tbody>
										</table>
										<div class="col-md-12 text-center">
											<button type="button" class="btn btn-primary apply_info_Identify" style="margin-bottom: 15px;">Áp dụng</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12 col-xs-12 text-right checking-user p-0">
							<span class="ml-1" style="float:left">Thông tin nhận dạng</span>
							<button type="button" class="btn btn-github return_Face_Identify m-0">Chọn lại</button>
							<button type="button" class="btn btn-warning identification_Face_search m-0">Blacklist</button>
							<button class="btn btn-primary identification_Face_Identify m-0">
								Nhận dạng
							</button>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 table-responsive plr-0" >
						<h2>KẾT QUẢ: 86%</h2>
						<table class="table jambo_table">
							<thead >
							<tr class="text-nowrap">
								<td>Họ và tên</td>
								<td>Số CCCD</td>
								<td>Giới tính</td>
								<td>Ngày sinh</td>
								<td>Nơi ĐK HKTT</td>
								<td>Quê quán</td>
							</tr>
							</thead>
							<tbody>
							<tr class="text-nowrap">
								<td>Hoàng Thị Khuê</td>
								<td>12345678901</td>
								<td>Nữ</td>
								<td>01/01/1111</td>
								<td>Xóm 1, Phường Phúc La, Quận Hà Đông, Hà Nội</td>
								<td>Xóm 1, Phường Phúc La, Quận Hà Đông, Hà Nội</td>
							</tr>
							</tbody>
						</table>
						<div class="col-md-12 col-xs-12" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px">
							<button class="btn btn-primary" >Áp dụng</button>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 row mt-1" >
						<div class="col-md-6 col-sm-6 col-xs-12 mt-1">
							<div class="x_panel" style="height: 100%">
								<div class="x_title">
									<h4 class="text-uppercase">Thông tin khách hàng</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form class="form-horizontal form-label-left">

										<div class="col-xs-12 col-md-12">
											<div class="form-group">
												<label class="text-nowrap" >
													Họ tên khách hàng <span class="red">*</span>
												</label>
												<input type="text" id="customer_name" name="customer_name"  required="required" class="form-control" placeholder="Họ và tên">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Ngày sinh <span class="red">*</span>
												</label>
												<input type="date" id="customer_BOD"  name="customer_BOD" required="required" class="form-control">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label>Giới tính</label>
												<select class="form-control" >
													<option value="nam">Nam</option>
													<option value="nu">Nữ</option>
												</select>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Loại giấy tờ <span class="red">*</span></label>
												<select class="form-control" id="chooseExhibit">
													<option value="">- Chọn loại giấy tờ - </option>
													<option value="cmtnd">Chứng minh thư nhân dân </option>
													<option value="cccd">Căn cước công dân </option>
													<option value="passport">Hộ chiếu </option>
												</select>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label>Số <span class="red">*</span></label>
												<input  class="form-control" type="number" id="exhibit" placeholder="Số CCCD">

											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Ngày cấp <span class="red">*</span>
												</label>
												<input type="date"  required="required" class="form-control">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Nơi cấp <span class="red">*</span>
												</label>
												<input type="text"  required="required" class="form-control" placeholder="Nơi cấp">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Số điện thoại <span class="red">*</span>
												</label>
												<input type="number"  required="required" class="form-control" placeholder="SĐT">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Email
												</label>
												<input type="email"  required="required" class="form-control" placeholder="Email">
											</div>
										</div>

										<div class="col-md-12 col-xs-12">
											<div class="form-group">
												<label >Số CMND cũ
												</label>
												<input type="number"  required="required" class="form-control" placeholder="Số CMND cũ">
											</div>
										</div>
										<div class="col-md-12 col-xs-12">
											<div class="form-group">
												<label >Nguồn khách hàng
												</label>
												<select class="form-control">
													<option>- Chọn nguồn khách hàng - </option>
													<option>Option one</option>
													<option>Option two</option>
													<option>Option three</option>
													<option>Option four</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary pull-right" style="margin-right: 10px" data-toggle="modal" data-target="#dsHopDongLienQuan">
												<i class="fa fa-file-text-o mr-1" aria-hidden="true" style="margin-right: 3px"></i>
												Kiểm tra
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 mt-1">
							<div class="x_panel" style="height: 100%">
								<div class="x_title">
									<h4 class="text-uppercase">Địa chỉ thường trú</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form class="form-horizontal form-label-left">
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Tỉnh/ Thành phố <span class="red">*</span>
											</label>
											<select class="form-control">
												<option>- Chọn tỉnh/ thành phố -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<labe>Quận/ Huyện <span class="red">*</span>
											</labe>
											<select class="form-control">
												<option>- Chọn quận/ huyện -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Phường/ Xã <span class="red">*</span></label>
											<select class="form-control">
												<option>- Chọn phường/ xã -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Thôn/Xóm/Tổ</label>
											<input type="text" class="form-control">

										</div>

									</form>
								</div>
								<div class="x_title">
									<h4 class="text-uppercase">Địa chỉ tạm trú (nếu có)</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form class="form-horizontal form-label-left">

										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Tỉnh/ Thành phố</label>
											<select class="form-control">
												<option>- Chọn tỉnh/ thành phố -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Quận/ Huyện</label>
											<select class="form-control">
												<option>- Chọn quận/ huyện -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Phường/ Xã </label>
											<select class="form-control">
												<option>- Chọn phường/ xã -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Thôn/Xóm/Tổ</label>
											<input type="text" class="form-control">
										</div>


									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="old-customer" aria-labelledby="profile-tab">
				<div class="col-md-12 col-xs-12">
					<h4 class="text-uppercase" style="margin-left: 15px">Tìm kiếm thông tin khách hàng</h4>
					<form class="form-horizontal form-label-left">

						<div class="form-group col-md-7">
							<label class="control-label col-md-5 col-sm-5 col-lg-4 col-xs-12 text-nowrap text-left" >
								Số CMT/CCCD/Số hộ chiếu <span class="red">*</span>
							</label>
							<div class="col-md-7 col-sm-7 col-lg-8 col-xs-12">
								<input type="text" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-1 col-sm-3 col-xs-12 text-right">
								<button type="submit" class="btn btn-primary">
									Tìm kiếm
								</button>
							</div>
						</div>
					</form>

					<div class="form-group mb-3">
						<div class="col-md-12 col-xs-12 nopadding">
							<div class="x_title" style="padding-left: 0">
								<strong><i class="fa fa-user" aria-hidden="true"></i> So khớp CCCD và chân dung</strong>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân, Hộ chiếu</p>
								<div class="row">
									<div class="col-xs-12 col-md-4 text-left form-add-image">
										<div>
											<p>Mặt trước</p>
											<img id="imgImg_mattruoc" style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;" src="<?php echo base_url();?>assets/imgs/icon/background-add.svg" alt="">
											<input type="file" data-preview="imgInp004" style="visibility: hidden;">
										</div>
									</div>
									<div class="col-md-4 col-xs-12 text-center form-add-image">
										<p class="text-left" style="margin-left: 12%">Mặt sau</p>
										<img id="imgImg_matsau" style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;" src="<?php echo base_url();?>assets/imgs/icon/background-add.svg" alt="">
										<input type="file" data-preview="imgInp005" style="visibility: hidden;">
									</div>
									<div class="col-xs-12 col-md-4 text-right form-add-image">
										<p class="text-left" style="margin-left: 24%">Ảnh chân dung</p>
										<img id="imgImg_chandung" style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;" src="<?php echo base_url();?>assets/imgs/icon/background-add.svg" alt="">
										<input type="file" data-preview="imgInp006" style="visibility: hidden;">
									</div>
								</div>
								<div id="cvs_customer_info" class="row" style="display: none;">
									<div class="col-md-12 col-xs-12">
										<h4>Thông tin khách hàng</h4>
										<div class="text-center" id="Identify_loading" style="display: none;">
											<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
											<div >Đang xử lý...</div>
										</div>
										<table class="table table-bordered">
											<tbody id='list_info_Identify'>

											</tbody>
										</table>
										<div class="col-md-12 text-center">
											<button type="button" class="btn btn-primary apply_info_Identify" style="margin-bottom: 15px;">Áp dụng</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12 col-xs-12 text-right checking-user p-0">
							<span class="ml-1" style="float:left">Thông tin nhận dạng</span>
							<button type="button" class="btn btn-github return_Face_Identify m-0">Chọn lại</button>
							<button type="button" class="btn btn-warning identification_Face_search m-0">Blacklist</button>
							<button class="btn btn-primary identification_Face_Identify m-0">
								Nhận dạng
							</button>
						</div>
					</div>
					<div class="col-md-12 col-xs-12 alert alert-success mt-1 plr-0">
						<p style="text-align: center">Không phát hiện trong backlist</p>
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12 row mt-1" >
						<div class="col-md-6 col-sm-6 col-xs-12 mt-1">
							<div class="x_panel" style="height: 100%">
								<div class="x_title">
									<h4 class="text-uppercase">Thông tin khách hàng</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form class="form-horizontal form-label-left">

										<div class="col-xs-12 col-md-12">
											<div class="form-group">
												<label class="text-nowrap" >
													Họ tên khách hàng <span class="red">*</span>
												</label>
												<input type="text" id="customer_name" name="customer_name"  required="required" class="form-control" placeholder="Họ và tên">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Ngày sinh <span class="red">*</span>
												</label>
												<input type="date" id="customer_BOD"  name="customer_BOD" required="required" class="form-control">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label>Giới tính</label>
												<select class="form-control" >
													<option value="nam">Nam</option>
													<option value="nu">Nữ</option>
												</select>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Loại giấy tờ <span class="red">*</span></label>
												<select class="form-control" id="chooseExhibit">
													<option value="">- Chọn loại giấy tờ - </option>
													<option value="cmtnd">Chứng minh thư nhân dân </option>
													<option value="cccd">Căn cước công dân </option>
													<option value="passport">Hộ chiếu </option>
												</select>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label>Số <span class="red">*</span></label>
												<input  class="form-control" type="number" id="exhibit" placeholder="Số CCCD">

											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Ngày cấp <span class="red">*</span>
												</label>
												<input type="date"  required="required" class="form-control">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Nơi cấp <span class="red">*</span>
												</label>
												<input type="text"  required="required" class="form-control" placeholder="Nơi cấp">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Số điện thoại <span class="red">*</span>
												</label>
												<input type="number"  required="required" class="form-control" placeholder="SĐT">
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<label >Email
												</label>
												<input type="email"  required="required" class="form-control" placeholder="Email">
											</div>
										</div>

										<div class="col-md-12 col-xs-12">
											<div class="form-group">
												<label >Số CMND cũ
												</label>
												<input type="number"  required="required" class="form-control" placeholder="Số CMND cũ">
											</div>
										</div>
										<div class="col-md-12 col-xs-12">
											<div class="form-group">
												<label >Nguồn khách hàng
												</label>
												<select class="form-control">
													<option>- Chọn nguồn khách hàng - </option>
													<option>Option one</option>
													<option>Option two</option>
													<option>Option three</option>
													<option>Option four</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary pull-right" style="margin-right: 10px" data-toggle="modal" data-target="#dsHopDongLienQuan">
												<i class="fa fa-file-text-o mr-1" aria-hidden="true" style="margin-right: 3px"></i>
												Kiểm tra
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 mt-1">
							<div class="x_panel" style="height: 100%">
								<div class="x_title">
									<h4 class="text-uppercase">Địa chỉ thường trú</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form class="form-horizontal form-label-left">
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Tỉnh/ Thành phố <span class="red">*</span>
											</label>
											<select class="form-control">
												<option>- Chọn tỉnh/ thành phố -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<labe>Quận/ Huyện <span class="red">*</span>
											</labe>
											<select class="form-control">
												<option>- Chọn quận/ huyện -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Phường/ Xã <span class="red">*</span></label>
											<select class="form-control">
												<option>- Chọn phường/ xã -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Thôn/Xóm/Tổ</label>
											<input type="text" class="form-control">

										</div>

									</form>
								</div>
								<div class="x_title">
									<h4 class="text-uppercase">Địa chỉ tạm trú (nếu có)</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form class="form-horizontal form-label-left">

										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Tỉnh/ Thành phố</label>
											<select class="form-control">
												<option>- Chọn tỉnh/ thành phố -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Quận/ Huyện</label>
											<select class="form-control">
												<option>- Chọn quận/ huyện -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Phường/ Xã </label>
											<select class="form-control">
												<option>- Chọn phường/ xã -</option>
												<option>Option one</option>
												<option>Option two</option>
												<option>Option three</option>
												<option>Option four</option>
											</select>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12">
											<label>Thôn/Xóm/Tổ</label>
											<input type="text" class="form-control">
										</div>


									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
