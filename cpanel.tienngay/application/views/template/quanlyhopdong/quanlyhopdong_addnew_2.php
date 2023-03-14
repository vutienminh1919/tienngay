<div class="modal fade" id="kiemTraThamChieu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg in" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Danh sách hợp đồng liên quan</h5>
			</div>
			<div class="modal-body table-responsive">
				<table class="table jambo_table">
					<thead>
					<tr class="text-nowrap">
						<td>STT</td>
						<td>Mã hợp đồng</td>
						<td>Cửa hàng</td>
						<td>Trạng thái</td>
					</tr>
					</thead>
					<tbody>
					<tr class="text-nowrap">
						<td>1</td>
						<td>123456789123</td>
						<td>123 Phùng Hưng</td>
						<td>Không</td>
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
<div class="x_panel pl-0 pr-0">
	<div class="x_content pl-0 pr-0">

		<!-- start accordion -->
		<div class="accordion p-0" id="accordion1" role="tablist" aria-multiselectable="true">
			<div class="panel p-0">
				<a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
					<h5 class="text-uppercase panel-title">thông tin khách hàng và thông tin liên quan</h5>

				</a>
				<div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						<div class="form-group col-md-12 col-xs-12">
							<div class="col-md-12 col-xs-12">
								<label class="control-label col-md-3 col-sm-3 col-xs-12 text-nowrap">
									PHÒNG GIAO DỊCH <span class="red">*</span>
								</label>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<select class="form-control">
										<option>- Chọn phòng giao dịch -</option>
										<option>Option one</option>
										<option>Option two</option>
										<option>Option three</option>
										<option>Option four</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-xs-12 nopadding information-job__user" >
							<div class="col-md-6 col-sm-6 col-xs-12" >
								<div class="x_panel" style="height: 100%">
									<div class="x_title">
										<h4 class="text-uppercase">Thông tin công việc</h4>
										<div class="clearfix"></div>
									</div>
									<div class="x_content ">
										<br />
										<form data-parsley-validate class="form-horizontal form-label-left">

											<div class="form-group col-md-12 col-sm-12 col-xs-12">
												<label>
													Tên công ty <span class="red">*</span>
												</label>
												<input type="text" required="required" class="form-control" placeholder="Tên công ty">

											</div>
											<div class="form-group col-md-12 col-sm-12 col-xs-12">
												<label class="">Địa chỉ <span class="red">*</span></label>
												<input  class="form-control" type="text" placeholder="Địa chỉ">

											</div>
											<div class="form-group col-md-6 col-xs-12">
												<label>SĐT <span class="red">*</span></label>
												<input  class="form-control" type="number" placeholder="SĐT">

											</div>
											<div class="form-group col-md-6 col-xs-12">
												<label>Thời gian làm việc </label>
												<input  class="form-control" type="text" placeholder="Thời gian làm việc">
											</div>
											<div class="form-group col-md-6 col-xs-12">
												<label>Nghề nghiệp <span class="red">*</span></label>
												<select class="form-control">
													<option>- Chọn nghề nghiệp -</option>
													<option>Option one</option>
													<option>Option two</option>
													<option>Option three</option>
													<option>Option four</option>
												</select>
											</div>
											<div class="form-group col-md-6 col-xs-12">
												<label>Chức vụ <span class="red">*</span></label>
												<select class="form-control">
													<option>- Chọn chức vụ -</option>
													<option>Option one</option>
													<option>Option two</option>
													<option>Option three</option>
													<option>Option four</option>
												</select>
											</div>
											<div class="form-group col-md-6 col-xs-12">
												<label>Thu nhập <span class="red">*</span></label>
												<input id="salary" class="form-control" type="text" placeholder="Thu nhập">
											</div>
											<div class="form-group col-md-6 col-xs-12">
												<label>Hình thức nhận lương <span class="red">*</span></label>
												<select class="form-control">
													<option>- Chọn hình thức nhận lương - </option>
													<option>Option one</option>
													<option>Option two</option>
													<option>Option three</option>
													<option>Option four</option>
												</select>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12" >
								<div class="x_panel" style="height: 100%">
									<div class="x_title">
										<h4 class="text-uppercase">Thông tin tài khoản</h4>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<div class="col-xs-12">
											<ul id="myTab2" class="nav nav-tabs bar_tabs" role="tablist" style="margin-top: 0">
												<li role="presentation" class="active">
													<a href="#bankCard" id="theNganHang" aria-controls="bankCard" role="tab" data-toggle="tab" aria-expanded="true">
														<input type="radio"  value="1" name="atm" checked>
														Thẻ ngân hàng
													</a>
												</li>
												<li role="presentation" class="">
													<a href="#atm" role="tab" id="cayATM" aria-controls="atm" data-toggle="tab" aria-expanded="false">
														<input type="radio" value="2" name="atm">
														ATM
													</a>
												</li>
											</ul>
										</div>
										<div id="myTabContent2" class="tab-content col-md-12 col-xs-12 nopadding">
											<div role="tabpanel" class="tab-pane fade active in col-md-12 col-xs-12 nopadding" id="bankCard" aria-labelledby="home-tab">
												<div class="form-group col-md-6 col-xs-12">
													<label>Ngân hàng <span class="red">*</span>
													</label>
													<select class="form-control">
														<option>Choose option</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</div>
												<div class="form-group col-md-6 col-xs-12">
													<label>Chi nhánh <span class="red">*</span>
													</label>
													<input  class="form-control" type="text" placeholder="Chi nhánh">

												</div>
												<div class="form-group col-md-6 col-xs-12">
													<label>Chủ tài khoản  <span class="red">*</span></label>
													<input  class="form-control" type="text" placeholder="Chủ tài khoản">
												</div>
												<div class="form-group col-md-6 col-xs-12">
													<label >Số tài khoản  <span class="red">*</span></label>
													<input  class="form-control" type="number" placeholder="Số tài khoản">
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="atm" aria-labelledby="profile-tab">
												<div class="form-group col-md-6 col-xs-12 ">
													<label>Số thẻ ATM  <span class="red">*</span></label>
													<input  class="form-control" type="number" placeholder="Số thẻ">
												</div>
												<div class="form-group col-md-6 col-xs-12 ">
													<label>Tên chủ thẻ ATM  <span class="red">*</span></label>
													<input  class="form-control" type="text" placeholder="Tên chủ thẻ">

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 mt-1" style="height: 100%">
							<div class="x_panel" >
								<div class="x_title">
									<h4 class="text-uppercase">Thông tin tham chiếu</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<table class="table jambo_table" id="table-thamchieu">
										<thead class="desktop-table__reference">
											<tr>
												<td style="width: 80px;">STT</td>
												<td>Tên người tham chiếu</td>
												<td>Mối quan hệ</td>
												<td>Địa chỉ</td>
												<td>SĐT</td>
												<td style="width: 300px;">Ghi chú</td>
												<td></td>
											</tr>
										</thead>
										<tbody class="desktop-table__reference">
											<tr>
												<td>
													<input type="text" class="form-control input-form" placeholder="">
												</td>
												<td>
													<input type="text" class="form-control input-form" placeholder="">
												</td>
												<td>
													<select class="form-control choose-relationsip">
														<option>- Chọn mối quan hệ -</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</td>
												<td>
													<input type="text" class="form-control input-form" placeholder="">
												</td>
												<td>
													<input type="text" class="form-control input-form" placeholder="">
												</td>
												<td>
													<textarea class="input-form" rows="1" cols="5" name=""  ></textarea>
												</td>
												<td class="text-right">
													<a type="submit" class="btn btn-primary" data-toggle="modal" data-target="#kiemTraThamChieu">
														<i class="fa fa-file-text-o mr-1" aria-hidden="true" style="margin-right: 3px"></i>
														Kiểm tra
													</a>
												</td>
											</tr>
											<tr>
												<td>
													<input type="text" class="form-control input-form" placeholder="">
												</td>
												<td>
													<input type="text" class="form-control input-form" placeholder="">
												</td>
												<td>
													<select class="form-control choose-relationsip">
														<option>- Chọn mối quan hệ -</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</td>
												<td>
													<input type="text" class="form-control input-form" placeholder="">
												</td>
												<td>
													<input type="text" class="form-control input-form" placeholder="">
												</td>
												<td>
													<textarea class="input-form" rows="1" cols="5" name=""></textarea>
												</td>
												<td class="text-right">
													<a type="submit" class="btn btn-primary" data-toggle="modal" data-target="#kiemTraThamChieu">
														<i class="fa fa-file-text-o mr-1" aria-hidden="true" style="margin-right: 3px"></i>
														Kiểm tra
													</a>
												</td>
											</tr>
										</tbody>
										<tbody class="mobile-table__reference">
											<tr>
												<td class="text-nowrap">Họ và tên <span class="red">*</span></td>
												<td>
													<input type="text" class="form-control input-form" placeholder="Họ và tên">
												</td>
											</tr>
											<tr>
												<td class="text-nowrap">Mối quan hệ <span class="red">*</span></td>
												<td>
													<select class="form-control choose-relationsip">
														<option>- Chọn mối quan hệ -</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</td>
											</tr>
											<tr>
												<td class="text-nowrap">Địa chỉ <span class="red">*</span></td>
												<td>
													<input type="text" class="form-control input-form" placeholder="Địa chỉ">
												</td>
											</tr>
											<tr>
												<td class="text-nowrap">SĐT <span class="red">*</span></td>
												<td>
													<input type="text" class="form-control input-form" placeholder="SĐT">
												</td>
											</tr>
											<tr>
												<td class="text-nowrap">Ghi chú</td>
												<td>
													<input type="text" class="form-control input-form" placeholder="Ghi chú">
												</td>
											</tr>
											<tr>
												<td></td>
												<td class="text-right"><a class="btn btn-primary " data-toggle="modal" data-target="#kiemTraThamChieu">Kiểm tra</a></td>
											</tr>
										</tbody>
										<tbody class="mobile-table__reference">
											<tr>
												<td class="text-nowrap">Họ và tên <span class="red">*</span></td>
												<td>
													<input type="text" class="form-control input-form" placeholder="Họ và tên">
												</td>
											</tr>
											<tr>
												<td class="text-nowrap">Mối quan hệ <span class="red">*</span></td>
												<td>
													<select class="form-control choose-relationsip">
														<option>- Chọn mối quan hệ -</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</td>
											</tr>
											<tr>
												<td class="text-nowrap">Địa chỉ <span class="red">*</span></td>
												<td>
													<input type="text" class="form-control input-form" placeholder="Địa chỉ">
												</td>
											</tr>
											<tr>
												<td class="text-nowrap">SĐT <span class="red">*</span></td>
												<td>
													<input type="text" class="form-control input-form" placeholder="SĐT">
												</td>
											</tr>
											<tr>
												<td class="text-nowrap">Ghi chú</td>
												<td>
													<input type="text" class="form-control input-form" placeholder="Ghi chú">
												</td>
											</tr>
											<tr>
												<td></td>
												<td class="text-right"><a class="btn btn-primary " data-toggle="modal" data-target="#kiemTraThamChieu">Kiểm tra</a></td>
											</tr>
										</tbody>
									</table>
									<div class="pull-right" style="cursor: pointer" id="themNguoiThamChieu">
										<span class="blue"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm người tham chiếu </span>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="panel p-0">
				<a class="panel-heading collapsed" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo">
					<h5 class="text-uppercase panel-title">thông tin vay và tài sản liên quan</h5>
				</a>
				<div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						<div class="col-md-12 col-sm-12 col-xs-12 nopadding" >
							<div class="x_panel" >
								<div class="x_title">
									<h4 class="text-uppercase">Thông tin khoản vay</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form data-parsley-validate class="form-horizontal form-label-left">
										<div class="col-md-6 col-xs-12 pr-0 pl-0">
											<div class="form-group">
												<div class="col-md-12 col-xs-12 nopadding">
												<span class="col-md-12 col-sm-12 col-xs-12">
													Hình thức vay <span class="red">*</span>
												</span>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<select class="form-control">
															<option>- Chọn hình thức vay - </option>
															<option>Option one</option>
															<option>Option two</option>
															<option>Option three</option>
															<option>Option four</option>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 col-xs-12 mt-1 nopadding">
												<span class="col-md-12 col-sm-12 col-xs-12">
													Sản phẩm vay <span class="red">*</span>
												</span>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<select class="form-control">
															<option>- Chọn sản phẩm vay - </option>
															<option>Option one</option>
															<option>Option two</option>
															<option>Option three</option>
															<option>Option four</option>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 col-xs-12 mt-1 nopadding">
												<span class="col-md-12 col-sm-12 col-xs-12">
													Tài sản vay <span class="red">*</span>
												</span>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<select class="form-control">
															<option>- Chọn tài sản vay - </option>
															<option>Option one</option>
															<option>Option two</option>
															<option>Option three</option>
															<option>Option four</option>
														</select>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="col-md-12 col-xs-12 mt-1 nopadding">
													<span class="col-md-12 col-sm-12 col-xs-12">
															Giá trị tài sản
													</span>
													<div class="col-md-12 col-sm-12 col-xs-12 pr-0">
														<div class="input-group">
															<input type="text" class="form-control"  readonly>
															<span class="input-group-btn">
																	<button type="button" class="btn btn-secondary" disabled>VNĐ</button>
																</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-xs-12 pr-0 pl-0">
											<div class="form-group">
												<div class="col-md-12 col-xs-12 nopadding">
												<span class="col-md-12 col-sm-12 col-xs-12">
													Loại tài sản <span class="red">*</span>
												</span>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<select class="form-control">
															<option>- Chọn loại tài sản - </option>
															<option>Option one</option>
															<option>Option two</option>
															<option>Option three</option>
															<option>Option four</option>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 col-xs-12 mt-1 nopadding">
													<span class="col-md-12 col-sm-12 col-xs-12">
														Địa chỉ giữ xe <span class="red">*</span>
													</span>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<select class="form-control">
															<option>- Chọn địa chỉ giữ xe -</option>
															<option>Option one</option>
															<option>Option two</option>
															<option>Option three</option>
															<option>Option four</option>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 col-xs-12 mt-1 nopadding">
													<span class="col-md-12 col-sm-12 col-xs-12" >
														Khấu hao tài sản
													</span>
													<div class="col-md-12 col-sm-12 col-xs-12"  style="height: 34px">
														<select type="text" id="select-depreciation" placeholder="- Chọn khấu hao -"> </select>
													</div>
<!--													information-depreciation-->
													<!--<div class="col-xs-12 col-md-10">
														<div class="">
															<ul class="to_do">
																<div class="col-md-6">
																	<li style="margin: 0; padding: 0">
																		<label>
																			<input type="checkbox" class="flat"> Bổ máy </label>
																	</li>
																	<li style="margin: 0; padding: 0">
																		<label>
																			<input type="checkbox" class="flat"> Tai nạn phần đầu, đuôi (bị nhẹ)</label>
																	</li>
																	<li style="margin: 0; padding: 0">
																		<label>
																			<input type="checkbox" class="flat"> Tai nạn phần đầu, đuôi (bị nặng)</label>
																	</li>
																	<li style="margin: 0; padding: 0">
																		<label>
																			<input type="checkbox" class="flat"> Tai nạn hai bên cửa</label>
																	</li>
																</div>
																<div class="col-md-6">
																	<li style="margin: 0; padding: 0">
																		<label>
																			<input type="checkbox" class="flat"> Sơn xước, xấu quá 50%</label>
																	</li>
																	<li style="margin: 0; padding: 0">
																		<label>
																			<input type="checkbox" class="flat"> Đèn pha xước nhẹ, ố vàng</label>
																	</li>
																	<li style="margin: 0; padding: 0">
																		<label>
																			<input type="checkbox" class="flat"> Đèn xước sâu, vỡ phải thay</label>
																	</li>
																	<li style="margin: 0; padding: 0">
																		<label>
																			<input type="checkbox" class="flat"> Nội thất xấu quá 50%</label>
																	</li>
																</div>
															</ul>
														</div>
													</div>-->
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12 p-0">
													<span class="col-md-12 col-sm-12 col-xs-12">
													Số tiền được vay
													</span>
													<div class="col-md-12 col-sm-12 col-xs-12 pr-0">
														<div class="input-group">
															<input type="number" class="form-control"  readonly>
															<span class="input-group-btn">
															  		<button type="button" class="btn btn-secondary" disabled>VNĐ</button>
															</span>
														</div>
													</div>
												</div>
											</div>

										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 pl-0 pr-0" >
							<div class="x_panel" style="height: 100%">
								<div class="x_title">
									<h4 class="text-uppercase">Thông tin vay tiền</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form data-parsley-validate class="form-horizontal form-label-left" >
										<div class="col-md-6 col-xs-12 pr-0 pl-0">
											<div class="form-group">
												<label class="col-md-12 col-sm-12 col-xs-12">
													Số tiền vay <span class="red">*</span>
												</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" id="money" class="form-control" placeholder="Số tiền vay">
												</div>

											</div>
											<div class="form-group">
												<label class="col-md-12 col-sm-12 col-xs-12">
												Mục đích vay <span class="red">*</span>
												</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<select class="form-control">
														<option>- Chọn mục đích vay -</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 col-xs-12 mt-1 nopadding">
												<label class="col-md-12 col-sm-12 col-xs-12">
													Gói phí <span class="red">*</span>
												</label>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<select class="form-control">
															<option>Biểu phí chuẩn</option>
															<option>Biểu phí nhà đất</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-xs-12 pr-0 pl-0">
											<div class="form-group">
													<label class="col-md-12 col-sm-12 col-xs-12">
															Hình thức trả tiền <span class="red">*</span>
													</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<select class="form-control">
														<option>- Chọn hình thức trả tiền -</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-12 col-sm-12 col-xs-12">
													Thời gian vay <span class="red">*</span>
												</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<select class="form-control">
														<option value="">3 tháng</option>
														<option value="">6 tháng</option>
														<option value="">12 tháng</option>
													</select>
												</div>
											</div>

										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 mt-1 p-0 " >
							<div class="x_panel">
								<div class="x_title">
									<h4 class="text-uppercase">Thông tin bảo hiểm</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content p-0">
									<div class="" role="tabpanel" data-example-id="togglable-tabs">
										<ul id="myTabBaoHiem" class="nav nav-tabs bar_tabs" role="tablist">
											<li class="li-tab active" id="li-tab1"  data-id="1" role="presentation" >
												<label for="bh-khoanvay" >
													<input  id="bh-khoanvay" type="checkbox" checked="checked">
													<span class="span-opacity">Bảo hiểm khoản vay</span>
												</label>
											</li>
											<li class="li-tab" id="li-tab2" data-id="2"  role="presentation">
												<label for="bh-xemay" >
													<input  id="bh-xemay" type="checkbox">
													<span class="span-opacity">Bảo hiểm GIC</span>
												</label>
											</li>
											<li class="li-tab" id="li-tab3" data-id="3" role="presentation">
												<label for="bh-plt" >
													<input  id="bh-plt" type="checkbox">
													<span class="span-opacity">
														Bảo hiểm MIC
													</span>
												</label>
											</li>
											<li class="li-tab" id="li-tab4" data-id="4" role="presentation">
												<label for="bh-vib" >
													<input  id="bh-vib" type="checkbox">
													<span class="span-opacity">
														Bảo hiểm VIB
													</span>
												</label>
											</li>
											<li class="li-tab" id="li-tab5" data-id="5" role="presentation">
												<label for="bh-khac" >
													<input  id="bh-khac" type="checkbox">
													<span class="span-opacity">
														CT ưu đãi khác
													</span>
												</label>
											</li>
										</ul>
										<div id="myTabContentBaoHiem" class="tab-content">
											<div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
												<div class="form-group col-md-9 col-xs-12">
													<label>Hãng bảo hiểm</label>
													<input type="text" class="form-control" value="Bảo hiểm GIC" readonly>

												</div>
												<div class="form-group col-md-3 col-xs-12">
													<label>Thành tiền</label>
													<div class="input-group">
														<input type="text" class="form-control" readonly value="182.000">
														<span class="input-group-btn">
															<button type="button" class="btn btn-secondary" disabled="">VNĐ</button>
														</span>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
												<div class="form-group col-md-9 col-xs-12">
													<label>Bảo hiểm xe máy (easy) GIC</label>
													<select class="form-control" name="bh-xemay" placeholder="- Chọn gói bảo hiểm -">
														<option value="" selected="selected">GIC_EASY_20</option>
														<option value="">GIC_EASY_40</option>
														<option value="">GIC_EASY_70</option>
													</select>

												</div>
												<div class="form-group col-md-3 col-xs-12">
													<label>Thành tiền</label>
													<div class="input-group">
														<input type="text" class="form-control" readonly="">
														<span class="input-group-btn">
															  		<button type="button" class="btn btn-secondary" disabled="">VNĐ</button>
														    	</span>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
												<div class="form-group col-md-9 col-xs-12">
													<label>Bảo hiểm phúc lộc thọ</label>
													<select class="form-control" name="bh-plt" placeholder="- Chọn gói bảo hiểm -">
														<option value="" selected="selected">Phúc</option>
														<option value="">Lộc</option>
														<option value="">Thọ</option>
													</select>
												</div>
												<div class="form-group col-md-3 col-xs-12">
													<label>Thành tiền</label>
													<div class="input-group">
														<input type="text" class="form-control" readonly="">
														<span class="input-group-btn">
															  		<button type="button" class="btn btn-secondary" disabled="">VNĐ</button>
														    	</span>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
												<div class=" form-group col-md-9 col-xs-12">
													<label>Chọn bảo hiểm VBI</label>
													<select id="select-bh-vbi"  placeholder="- Chọn gói bảo hiểm -"
													></select>
												</div>
												<div class=" form-group col-md-3 col-xs-12">
													<label>Thành tiền</label>
													<div class="input-group">
														<input type="text" class="form-control" readonly="">
														<span class="input-group-btn">
															  		<button type="button" class="btn btn-secondary" disabled="">VNĐ</button>
														    	</span>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
												<div class="form-group col-md-9 col-xs-12">
													<label>Chọn coupon</label>
													<select class="form-control" name="bh-khac" placeholder="- Chọn gói bảo hiểm -">
														<option value="" selected="selected">cbnv-tap-doan-vay-xm-oto-ky-han-3-thang</option>
														<option value="">cbnv-cong-ty-vay-xm-oto-ky-han-3-thang</option>
														<option value="">cbnv-tap-doan-vay-xm-oto-ky-han-3-thang</option>
													</select>
												</div>
												<div class="form-group col-md-3 col-xs-12">
													<label>Thành tiền</label>
													<div class="input-group">
														<input type="text" class="form-control" readonly="">
														<span class="input-group-btn">
															  		<button type="button" class="btn btn-secondary" disabled="">VNĐ</button>
														    	</span>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
								<div class="x_content total-insurance" style="border-top: 1px solid;">
									<div class="col-md-12 col-xs-12 mt-1" id="box__total">
										<div class="col-md-9 col-xs-8">
											<p>
												<span class="text-bold">1. Bảo hiểm GIC: </span>
												<p>Bảo hiểm khoản vay, GIC_EASY_20</p>
											</p>
										</div>
										<div class="col-md-3 col-xs-4 text-right  pl-0">
											<span class="float-right price-item">348.000 VNĐ</span>
										</div>
										<div class="col-md-9 col-xs-8">
											<p>
												<span class="text-bold">2. Bảo hiểm VIB: </span>
												<p>Sốt xuất huyết cá nhân gói bạc, Ung thư vú - nữ giới 18-40 tuổi Lenon</p>
											</p>
										</div>
										<div class="col-md-3 col-xs-4 text-right pl-0" >
											<span class="float-right price-item">182.000 VNĐ</span>
										</div>
										<div class="col-md-9 col-xs-8">
										</div>
										<div class="col-md-3 col-xs-4 pl-0 pt-1"  style="border-top: 2px solid #cccccc;">
											<div style="display: inline">
												<span class="span-desktop" style="font-size: 16px ">Tổng:</span>
											</div>
											<div class="pull-right price-total ">
												<p >530.000 VNĐ</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-0 " >
							<div class="x_panel" style="height: 100%" >
								<div class="x_title">
									<h4 class="text-uppercase">Thông tin tài sản</h4>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form  data-parsley-validate class="form-horizontal form-label-left">
										<div class="form-group">
											<div class="col-md-3 col-xs-12">
												<label>Ảnh đăng ký xe</label>
											</div>
											<div class="col-md-6 col-xs-12">
												<div class="col-md-6 col-xs-12">
													<p>Mặt trước ĐKX <span class="red">*</span></p>
													<img id="imgImg_mattruoc_DKX" style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;" src="<?php echo base_url();?>assets/imgs/icon/background-add.svg" alt="">
													<input type="file" data-preview="imgInp007" style="visibility: hidden;">
													<h4 class="text-success">Tỉ lệ nhận dạng 99.1%</h4>
												</div>
												<div class="col-md-6 col-xs-12">
													<p>Mặt sau ĐKX <span class="red">*</span></p>
													<img id="imgImg_matsau_DKX" style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;" src="<?php echo base_url();?>assets/imgs/icon/background-add.svg" alt="">
													<input type="file" data-preview="imgInp008" style="visibility: hidden;">
													<h4 class="text-success">Tỉ lệ nhận dạng 86%</h4>
													<div class="pull-right">
														<button class="btn btn-secondary">Chọn lại</button>
														<button class="btn btn-primary">Áp dụng</button>
													</div>
												</div>
											</div>
											<div class="col-md-3 col-xs-12"></div>
										</div>
										<div class="col-md-6 col-xs-12 mt-1">
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Thửa đất số <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Thửa đất số">
											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Địa chỉ <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Địa chỉ">
											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Diện tích (m2)<span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Diện tích (m2)">
											</div>
										</div>
										<div class="col-md-6 col-xs-12 mt-1">
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Mục đích sử dụng<span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Mục đích sử dụng">

											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Hình thức sử dụng <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Hình thức sử dụng">
											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Hình thức sử dụng <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Hình thức sử dụng">
											</div>
										</div>
										<div class="col-md-6 col-xs-12 mt-1">
											<div class="form-group col-md-12 col-xs-12">
												<label >
													Họ tên chủ xe <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Họ tên chủ xe">

											</div>
											<div class="form-group col-md-12 col-xs-12 ">
												<label>
													Nhãn hiệu <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Nhãn hiệu">
											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Số khung <span class="red">*</span>
												</label>
												<input type="number" class="form-control" placeholder="Số khung">

											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Số đăng ký <span class="red">*</span>
												</label>
												<input type="number" class="form-control" placeholder="Số đăng ký">

											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Ngày cấp đăng ký <span class="red">*</span>
												</label>
												<input type="date" class="form-control" placeholder="Ngày cấp đăng ký">
											</div>



										</div>
										<div class="col-md-6 col-xs-12 mt-1">
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Biển số xe <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Biển số xe">

											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Model <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Model">

											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Số máy <span class="red">*</span>
												</label>
												<input type="number" class="form-control" placeholder="Số máy">

											</div>
											<div class="form-group col-md-12 col-xs-12">
												<label>
													Địa chỉ đăng ký <span class="red">*</span>
												</label>
												<input type="text" class="form-control" placeholder="Địa chỉ đăng ký">

											</div>
										</div>
									</form>
								</div>
							</div>
						</div>


					</div>
				</div>
			</div>
			<div class="panel p-0">
				<a class="panel-heading collapsed" role="tab" id="headingThree1" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree">
					<h5 class="text-uppercase panel-title">Thông tin thẩm định</h5>
				</a>
				<div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
						<div class="col-md-12 col-sm-12 col-xs-12" style="height: 100%">
							<div class="x_panel" >
								<br />
								<form data-parsley-validate class="form-horizontal form-label-left">
									<div class="form-group mr-3" style="display: flex">
										<div class="col-md-2 col-xs-12">
											<p class="text-uppercase text-bold font-weight-500">
												Thẩm định hồ sơ<span class="red">*</span>
											</p>
										</div>
										<div class="col-md-10-col-xs-12 form-group">
											<textarea class="form-control" rows="10" cols="170" id="thamdinh-hs" name="thamdinh-hs"></textarea>
										</div>
									</div>
									<div class="form-group mr-3" style="display: flex">
										<div class="col-md-2 col-xs-12">
											<p class="text-uppercase text-bold font-weight-500">
												Thẩm định thực địa <span class="red">*</span>
											</p>
										</div>
										<div class="col-md-10-col-xs-12 form-group">
											<textarea class="form-control" rows="10" cols="170" id="thamdinh-td" name="thamdinh-td"></textarea>
										</div>
									</div>

								</form>
								<div class="col-md-12 col-xs-12 mt-1 plr-0">
									<div class="col-md-2 col-xs-12 mt-1 pr-0" style="margin-right: -5px"><h4>NGOẠI LỆ HỒ SƠ</h4></div>
									<div class="col-md-5 col-xs-12 mt-1 plr-0">
										<select class="form-control" id="change_exception" name="change_exception">
											<option >- Các lý do ngoại lệ -</option>
											<option value="exception1">E1: Ngoại lệ về hồ sơ nhân thân</option>
											<option value="exception2">E2: Ngoại lệ về thông tin nơi ở</option>
											<option value="exception3">E3: Ngoại lệ về thông tin thu nhập</option>
											<option value="exception4">E4: Ngoại lệ về thông tin sản phẩm</option>
											<option value="exception5">E5: Ngoại lệ về thông tin tham chiếu</option>
											<option value="exception6">E6: Ngoại lệ về thông tin lịch sử tín dụng</option>
											<option value="exception7">E7: Ngoại lệ tăng giá trị khoản vay</option>
										</select>
									</div>
									<div class="col-md-5 col-xs-12 mt-1 exception-detail">
										<div class="exception1" style="display: none">
											<select id="select-ngoai-le-e1" class="" placeholder="- Các lý do ngoại lệ E1 -">
											</select>
										</div>
										<div class="exception2" style="display: none">
											<select id="select-ngoai-le-e2" class="" placeholder="- Các lý do ngoại lệ E2 -">
											</select>
										</div>
										<div class="exception3" style="display: none">
											<select id="select-ngoai-le-e3" class="" placeholder="- Các lý do ngoại lệ E3 -">
											</select>
										</div>
										<div class="exception4" style="display: none">
											<select id="select-ngoai-le-e4" class="" placeholder="- Các lý do ngoại lệ E4 -">
											</select>
										</div>
										<div class="exception5" style="display: none">
											<select id="select-ngoai-le-e5" class="" placeholder="- Các lý do ngoại lệ E5 -">
											</select>
										</div>
										<div class="exception6" style="display: none">
											<select id="select-ngoai-le-e6" class="" placeholder="- Các lý do ngoại lệ E6 -">
											</select>
										</div>
										<div class="exception7" style="display: none">
											<select id="select-ngoai-le-e7" class="" placeholder="- Các lý do ngoại lệ E7 -">
											</select>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12" >
							<div class="x_panel" >
								<h4 class="text-uppercase" style="padding-left: 5px">Thông tin quan hệ tín dụng</h4>

								<div class="x_content ">
									<br />
									<div class="table-responsive">
										<table class="table jambo_table" id="table-tindung">
											<thead class="text-nowrap">
											<tr>
												<th >STT</th>
												<th>Tên tổ chức cho vay</th>
												<th>Gốc còn lại</th>
												<th>Đã tất toán</th>
												<th>Tiền phải trả hàng kỳ</th>
												<th>Tiền quá hạn</th>
												<th>Ghi chú</th>
												<th></th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td >
													<input style="width: 80px;" type="text" class="form-control input-form" placeholder=""/>
												</td>
												<td>
													<select class="form-control choose-relationsip">
														<option>- Chọn tổ chức cho vay -</option>
														<option>Option one</option>
														<option>Option two</option>
														<option>Option three</option>
														<option>Option four</option>
													</select>
												</td>
												<td class="text-right">
													<input type="number" class="form-control input-form" placeholder=""/>
												</td>
												<td class="text-right">
													<input type="number" class="form-control input-form" placeholder=""/>
												</td>
												<td class="text-right">
													<input type="number" class="form-control input-form" placeholder=""/>
												</td>
												<td class="text-right">
													<input type="number" class="form-control input-form" placeholder=""/>
												</td>
												<td>
													<textarea class="input-form" cols="5" rows="1"></textarea>
												</td>
												<td>
												</td>
											</tr>
											</tbody>
										</table>
									</div>

									<div class="pull-right" style="cursor: pointer" id="themThongTinTinDung">
										<span class="blue"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm thông tin </span>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end of accordion -->


	</div>
</div>

