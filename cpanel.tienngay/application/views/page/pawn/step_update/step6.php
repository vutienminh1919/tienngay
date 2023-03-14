<div class="x_panel setup-content" id="step-6">
	<div class="x_content">

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Thẩm định hồ sơ<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<textarea type="text" id="expertise_file" required=""
						  class="form-control"><?= !empty($contractInfor->expertise_infor->expertise_file) ? $contractInfor->expertise_infor->expertise_file : "" ?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Thẩm định thực địa<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<textarea type="text" id="expertise_field" required=""
						  class="form-control"><?= !empty($contractInfor->expertise_infor->expertise_field) ? $contractInfor->expertise_infor->expertise_field : "" ?></textarea>
			</div>
		</div>
		<?php if (($contractInfor->loan_infor->type_loan->code == "CC")): ?>
			<div class="form-group row">
				<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" id="giu_xe">
					Nơi cất giữ xe <span class="text-danger"></span>
				</label>
				<div class="col-lg-6 col-sm-12 col-12">
					<select class="form-control" name="car_storage" id="car_storage">
						<option value="">-- Nơi cất giữ xe --</option>
						<?php !empty($list_storage) ? $list_storage : ''; ?>
						<?php !empty($contractInfor->expertise_infor->car_storage) ? $contractInfor->expertise_infor->car_storage : ''; ?>
						<?php foreach ($list_storage as $key => $item): ?>
							<option value="<?php echo $item->storage_address ?>" <?php if ($item->storage_address == $contractInfor->expertise_infor->car_storage): ?>
								selected <?php endif; ?>><?php echo $item->storage_address ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php else: ?>
			<div class="form-group row">
				<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" id="giu_xe" style="display: none">
					Nơi cất giữ xe <span class="text-danger"></span>
				</label>
				<div class="col-lg-6 col-sm-12 col-12">
					<select class="form-control" name="car_storage" id="car_storage" style="display: none">
						<option value="">-- Nơi cất giữ xe --</option>
						<?php !empty($list_storage) ? $list_storage : ''; ?>
						<?php !empty($contractInfor->expertise_infor->car_storage) ? $contractInfor->expertise_infor->car_storage : ''; ?>
						<?php foreach ($list_storage as $key => $item): ?>
							<option value="<?php echo $item->storage_address ?>" <?php if ($item->storage_address == $contractInfor->expertise_infor->car_storage): ?>
								selected <?php endif; ?>><?php echo $item->storage_address ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php endif; ?>

		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Thông tin quan hệ tín dụng <span class="text-danger"></span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">

							<div class="table-responsive">

								<table class="table table-striped hide-show-column" id="datatable-button">
									<thead>
									<tr>
										<th>Tên tổ chức vay</th>
										<th>Gốc còn lại</th>
										<th>Đã tất toán</th>
										<th>Tiền phải trả hàng kỳ</th>
										<th>Quá hạn</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody id="add_company">

									<?php if (empty($company_storage)): ?>
										<tr>
											<td></td>
										<tr>
									<?php else: ?>
										<?php foreach ($company_storage as $value): ?>
											<tr id="company-<?php echo $value->_id->{'$oid'} ?>">
												<td><?= !empty($value->company_name != "khac") ? $value->company_name : $value->company_name_other ?></td>
												<td><?= !empty($value->company_debt) ? $value->company_debt : "" ?></td>
												<td><?= !empty($value->company_finalization) ? $value->company_finalization : "" ?></td>
												<td><?= !empty($value->company_borrowing) ? $value->company_borrowing : "" ?></td>
												<td><?= !empty($value->company_out_of_date) ? $value->company_out_of_date : "" ?></td>
												<td>
													<button class="del-company"
															data-id="<?php echo $value->_id->{'$oid'} ?>"><i
																class="fa fa-trash" style="color: red"
																aria-hidden="true"></i></button>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
									</tbody>
								</table>

							</div>
						</div>
					</div>
				</div>
				<div class="title_right text-right">
					<button class="btn btn-info modal_company" data-toggle="modal" data-target="#addNewCompanyModal"><i
								class="fa fa-plus" aria-hidden="true"></i> Thêm mới
					</button>
				</div>
			</div>
		</div>
		<input id="customer_phone_number1" value="<?php echo $contractInfor->customer_infor->customer_phone_number ?>"
			   hidden>

		<br>

		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Ngoại lệ hồ sơ <span class="text-danger"></span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<div class="row">
					<div class="col-md-6">
						<select id="change_exception" class="form-control" name="change_exception"
								data-placeholder="Các lý do ngoại lệ">
							<option value="">-- Các lý do ngoại lệ --</option>
							<option value="E1">E1: Ngoại lệ về hồ sơ nhân thân</option>
							<option value="E2">E2: Ngoại lệ về thông tin nơi ở</option>
							<option value="E3">E3: Ngoại lệ về thông tin thu nhập</option>
							<option value="E4">E4: Ngoại lệ về thông tin sản phẩm</option>
							<option value="E5">E5: Ngoại lệ về thông tin tham chiếu</option>
							<option value="E6">E6: Ngoại lệ về thông tin lịch sử tín dụng</option>
							<option value="E7">E7: Ngoại lệ tăng giá trị khoản vay</option>
						</select>
					</div>
					<div class="col-md-6">
						<div id="exception1" <?php if (empty($contractInfor->expertise_infor->exception1_value[0])): ?> style="display: none" <?php endif; ?>>
							<div class="row">
								<div class="col-md-10">
									<select id="lead_exception_E1" class="form-control" name="lead_exception_E1[]"
											multiple="multiple" data-placeholder="Các lý do ngoại lệ E1">
										<?php
										$value1 = (isset($contractInfor->expertise_infor->exception1_value[0]) && is_array($contractInfor->expertise_infor->exception1_value[0])) ? $contractInfor->expertise_infor->exception1_value[0] : array();
										?>
										<option value="1" <?= (is_array($value1) && in_array("1", $value1)) ? 'selected' : '' ?> >
											E1.1: Ngoại lệ về tuổi vay
										</option>
										<option value="2" <?= (is_array($value1) && in_array("2", $value1)) ? 'selected' : '' ?> >
											E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều
											kiện
										</option>
									</select>
								</div>
								<div class="col-md-2">
									<i id="exception1_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div id="exception2" <?php if (empty($contractInfor->expertise_infor->exception2_value[0])): ?> style="display: none" <?php endif; ?>>
							<div class="row">
								<div class="col-md-10">
									<select id="lead_exception_E2" class="form-control" name="lead_exception_E2[]"
											multiple="multiple" data-placeholder="Các lý do ngoại lệ E2">
										<?php
										$value2 = (isset($contractInfor->expertise_infor->exception2_value[0]) && is_array($contractInfor->expertise_infor->exception2_value[0])) ? $contractInfor->expertise_infor->exception2_value[0] : array();
										?>
										<option value="3" <?= (is_array($value2) && in_array("3", $value2)) ? 'selected' : '' ?> >
											E2.1: Khách hàng KT3 tạm trú dưới 6 tháng
										</option>
										<option value="4" <?= (is_array($value2) && in_array("4", $value2)) ? 'selected' : '' ?> >
											E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác minh qua
											chủ nhà trọ
										</option>
									</select>
								</div>
								<div class="col-md-2">
									<i id="exception2_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div id="exception3" <?php if (empty($contractInfor->expertise_infor->exception3_value[0])): ?> style="display: none" <?php endif; ?>>
							<div class="row">
								<div class="col-md-10">
									<select id="lead_exception_E3" class="form-control" name="lead_exception_E3[]"
											multiple="multiple" data-placeholder="Các lý do ngoại lệ E3">
										<?php
										$value3 = (isset($contractInfor->expertise_infor->exception3_value[0]) && is_array($contractInfor->expertise_infor->exception3_value[0])) ? $contractInfor->expertise_infor->exception3_value[0] : array();
										?>
										<option value="5" <?= (is_array($value3) && in_array("5", $value3)) ? 'selected' : '' ?> >
											E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu nhập
										</option>

									</select>
								</div>
								<div class="col-md-2">
									<i id="exception3_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div id="exception4" <?php if (empty($contractInfor->expertise_infor->exception4_value[0])): ?> style="display: none" <?php endif; ?>>
							<div class="row">
								<div class="col-md-10">
									<select id="lead_exception_E4" class="form-control" name="lead_exception_E4[]"
											multiple="multiple" data-placeholder="Các lý do ngoại lệ E4">
										<?php
										$value4 = (isset($contractInfor->expertise_infor->exception4_value[0]) && is_array($contractInfor->expertise_infor->exception4_value[0])) ? $contractInfor->expertise_infor->exception4_value[0] : array();
										?>
										<option value="6" <?= (is_array($value4) && in_array("6", $value4)) ? 'selected' : '' ?> >
											E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành của công ty
											(đất, giấy tờ khác...)
										</option>
										<option value="7" <?= (is_array($value4) && in_array("7", $value4)) ? 'selected' : '' ?> >
											E4.2: Ngoại lệ về lãi suất sản phẩm
										</option>

									</select>
								</div>
								<div class="col-md-2">
									<i id="exception4_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div id="exception5" <?php if (empty($contractInfor->expertise_infor->exception5_value[0])): ?> style="display: none" <?php endif; ?>>
							<div class="row">
								<div class="col-md-10">
									<select id="lead_exception_E5" class="form-control" name="lead_exception_E5[]"
											multiple="multiple" data-placeholder="Các lý do ngoại lệ E5">
										<?php
										$value5 = (isset($contractInfor->expertise_infor->exception5_value[0]) && is_array($contractInfor->expertise_infor->exception5_value[0])) ? $contractInfor->expertise_infor->exception5_value[0] : array();
										?>
										<option value="8" <?= (is_array($value5) && in_array("8", $value5)) ? 'selected' : '' ?> >
											E5.1: Ngoại lệ về điều kiện đối với người tham chiếu
										</option>
										<option value="9" <?= (is_array($value5) && in_array("9", $value5)) ? 'selected' : '' ?> >
											E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ thống phonet
										</option>

									</select>
								</div>
								<div class="col-md-2">
									<i id="exception5_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div id="exception6" <?php if (empty($contractInfor->expertise_infor->exception6_value[0])): ?> style="display: none" <?php endif; ?>>
							<div class="row">
								<div class="col-md-10">
									<select id="lead_exception_E6" class="form-control" name="lead_exception_E6[]"
											multiple="multiple" data-placeholder="Các lý do ngoại lệ E6">
										<?php
										$value6 = (isset($contractInfor->expertise_infor->exception6_value[0]) && is_array($contractInfor->expertise_infor->exception6_value[0])) ? $contractInfor->expertise_infor->exception6_value[0] : array();
										?>
										<option value="10" <?= (is_array($value6) && in_array("10", $value6)) ? 'selected' : '' ?> >
											E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân hàng khác
										</option>
									</select>
								</div>
								<div class="col-md-2">
									<i id="exception6_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div id="exception7" <?php if (empty($contractInfor->expertise_infor->exception7_value[0])): ?> style="display: none" <?php endif; ?>>
							<div class="row">
								<div class="col-md-10">
									<select id="lead_exception_E7" class="form-control" name="lead_exception_E7[]"
											multiple="multiple" data-placeholder="Các lý do ngoại lệ E7">
										<?php
										$value7 = (isset($contractInfor->expertise_infor->exception7_value[0]) && is_array($contractInfor->expertise_infor->exception7_value[0])) ? $contractInfor->expertise_infor->exception7_value[0] : array();
										?>
										<option value="11" <?= (is_array($value7) && in_array("11", $value7)) ? 'selected' : '' ?> >
											E7.1: Khách hàng vay lại có lịch sử trả tiền tốt
										</option>
										<option value="12" <?= (is_array($value7) && in_array("12", $value7)) ? 'selected' : '' ?> >
											E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp
										</option>
										<option value="13" <?= (is_array($value7) && in_array("13", $value7)) ? 'selected' : '' ?> >
											E7.3: KH làm việc tại các công ty là đối tác chiến lược
										</option>
										<option value="14" <?= (is_array($value7) && in_array("14", $value7)) ? 'selected' : '' ?> >
											E7.4: Giá trị định giá tài sản cao
										</option>
									</select>
								</div>
								<div class="col-md-2">
									<i id="exception7_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<input id="exception1_value" style="display: none"
			   value="<?= !empty($contractInfor->expertise_infor->exception1_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception1_value[0]) . "]]" : "" ?>">
		<input id="exception2_value" style="display: none"
			   value="<?= !empty($contractInfor->expertise_infor->exception2_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception2_value[0]) . "]]" : "" ?>">
		<input id="exception3_value" style="display: none"
			   value="<?= !empty($contractInfor->expertise_infor->exception3_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception3_value[0]) . "]]" : "" ?>">
		<input id="exception4_value" style="display: none"
			   value="<?= !empty($contractInfor->expertise_infor->exception4_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception4_value[0]) . "]]" : "" ?>">
		<input id="exception5_value" style="display: none"
			   value="<?= !empty($contractInfor->expertise_infor->exception5_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception5_value[0]) . "]]" : "" ?>">
		<input id="exception6_value" style="display: none"
			   value="<?= !empty($contractInfor->expertise_infor->exception6_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception6_value[0]) . "]]" : "" ?>">
		<input id="exception7_value" style="display: none"
			   value="<?= !empty($contractInfor->expertise_infor->exception7_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception7_value[0]) . "]]" : "" ?>">

<!--		--><?php //if (!in_array($contractInfor->status, [7, 15, 17, 19])): ?>
			<button class="btn btn-primary nextBtn pull-right" type="button" data-toggle="modal"
					data-target="#createContract">Cập nhật
			</button>
<!--		--><?php //endif; ?>
		<button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
	</div>
</div>


<!-- Modal HTML -->
<div id="createContract" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title">Xác nhận cập nhật hợp đồng </h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-info"
						data-dismiss="modal"><?= $this->lang->line('Cancel') ?></button>
				<button type="button"
						class="btn btn-success btn-update-contract"><?= $this->lang->line('ok') ?></button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="addNewCompanyModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm thông tin quan hệ tín dụng </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="_id"/>
						<div class="form-group">
							<label class="control-label col-md-3">Tên tổ chức vay<span
										class="text-danger"></span>:</label>
							<div class="col-md-9">
								<select class="form-control" name="company_name" id="company_name">
									<option value="JACCS">JACCS</option>
									<option value="TPBank-TPFICO">TPBank-TPFICO</option>
									<option value="Tima">Tima</option>
									<option value="Fecredit">Fecredit</option>
									<option value="Vietmoney">Vietmoney</option>
									<option value="OCB(Com-b)">OCB(Com-b)</option>
									<option value="Maritime Bank">Maritime Bank</option>
									<option value="ATM Online">ATM Online</option>
									<option value="Doctor Dong">Doctor Dong</option>
									<option value="Mirea Asset">Mirea Asset</option>
									<option value="F88">F88</option>
									<option value="Dongshopsun">Dongshopsun</option>
									<option value="Happy Money">Happy Money</option>
									<option value="khac">Khác</option>
								</select>
							</div>
						</div>

						<div class="form-group" id="show_company_name" style="display: none">
							<label class="control-label col-md-3"><span class="text-danger"></span></label>
							<div class="col-md-9">
								<input id="company_name_other" name="company_name_other"
									   placeholder="Nhập tên tổ chức khác" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Gốc còn lại <span
										class="text-danger"></span>:</label>
							<div class="col-md-9">
								<input id="company_debt" name="company_debt" placeholder="Nhập gốc còn lại"
									   class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Đã tất toán <span class="text-danger"></span>:</label>
							<div class="col-md-9">
								<input id="company_finalization" name="company_finalization"
									   placeholder="Nhập trạng thái tất toán" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Tiền phải trả hàng kỳ <span
										class="text-danger"></span>:</label>
							<div class="col-md-9">
								<input id="company_borrowing" name="company_borrowing"
									   placeholder="Nhập trạng thái đang vay" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Quá hạn <span class="text-danger"></span>:</label>
							<div class="col-md-9">
								<input id="company_out_of_date" name="company_out_of_date"
									   placeholder="Nhập trạng thái quá hạn" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>


						<div style="text-align: center" id="group-button">
							<button type="button" id="company_btnUpdate" class="btn btn-info">Lưu</button>
							<button type="button" class="btn btn-primary company_close" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>





