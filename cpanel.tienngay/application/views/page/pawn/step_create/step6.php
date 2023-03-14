<div class="x_panel setup-content" id="step-6">
	<div class="x_content">

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Thẩm định hồ sơ<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<textarea type="text" id="expertise_file" required="" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Thẩm định thực địa<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<textarea type="text" id="expertise_field" required="" class="form-control"></textarea>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" id="giu_xe" style="display: none">
				Nơi cất giữ xe <span class="text-danger"></span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<select class="form-control" name="car_storage" id="car_storage" style="display: none">
					<option value="">-- Nơi cất giữ xe --</option>
					<?php !empty($list_storage) ? $list_storage : ''; ?>
					<?php foreach ($list_storage as $key => $item): ?>
						<option value="<?php echo $item->storage_address ?>"><?php echo $item->storage_address ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

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
									<tbody id="add_company"></tbody>
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
		<br>

		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Ngoại lệ hồ sơ <span class="text-danger"></span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<div class="row">
					<div class="col-md-6">
					<select id="change_exception" class="form-control" name="change_exception" data-placeholder="Các lý do ngoại lệ">
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
						<div style="display: none" id="exception1">
							<div class="row">
								<div class="col-md-10">
						<select   id="lead_exception_E1" class="form-control" name="lead_exception_E1[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E1" >
							<?php foreach (lead_exception_E1() as $key => $item) { ?>
								<option value="<?= $key ?>" <?= ($lead_exception_E1 == $key) ? 'selected' : '' ?>><?= $item ?></option>
							<?php } ?>
						</select>
								</div>
								<div class="col-md-2">
									<i id="exception1_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>

						</div>
						<div style="display: none" id="exception2">
							<div class="row">
								<div class="col-md-10">
						<select  id="lead_exception_E2" class="form-control" name="lead_exception_E2[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E2">
							<?php foreach (lead_exception_E2() as $key => $item) { ?>
								<option value="<?= $key ?>" <?= ($lead_exception_E2 == $key) ? 'selected' : '' ?>><?= $item ?></option>
							<?php } ?>
						</select>
								</div>
								<div class="col-md-2">
									<i id="exception2_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div style="display: none" id="exception3">
							<div class="row">
								<div class="col-md-10">
						<select  id="lead_exception_E3" class="form-control" name="lead_exception_E3[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E3">
							<?php foreach (lead_exception_E3() as $key => $item) { ?>
								<option value="<?= $key ?>" <?= ($lead_exception_E3 == $key) ? 'selected' : '' ?>><?= $item ?></option>
							<?php } ?>
						</select>
								</div>
								<div class="col-md-2">
									<i id="exception3_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div style="display: none" id="exception4">
							<div class="row">
								<div class="col-md-10">
						<select  id="lead_exception_E4" class="form-control" name="lead_exception_E4[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E4">
							<?php foreach (lead_exception_E4() as $key => $item) { ?>
								<option value="<?= $key ?>" <?= ($lead_exception_E4 == $key) ? 'selected' : '' ?>><?= $item ?></option>
							<?php } ?>
						</select>
								</div>
								<div class="col-md-2">
									<i id="exception4_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div style="display: none" id="exception5">
							<div class="row">
								<div class="col-md-10">
						<select  id="lead_exception_E5" class="form-control" name="lead_exception_E5[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E5">
							<?php foreach (lead_exception_E5() as $key => $item) { ?>
								<option value="<?= $key ?>" <?= ($lead_exception_E5 == $key) ? 'selected' : '' ?>><?= $item ?></option>
							<?php } ?>
						</select>
								</div>
								<div class="col-md-2">
									<i id="exception5_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
								</div>
							</div>
						</div>
						<div style="display: none" id="exception6">
							<div class="row">
								<div class="col-md-10">
						<select id="lead_exception_E6" class="form-control" name="lead_exception_E6[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E6">
							<?php foreach (lead_exception_E6() as $key => $item) { ?>
								<option value="<?= $key ?>" <?= ($lead_exception_E6 == $key) ? 'selected' : '' ?>><?= $item ?></option>
							<?php } ?>
						</select>
								</div>
								<div class="col-md-2">
									<i id="exception6_del" class="fa fa-ban text-danger" aria-hidden="true" style="text-align: center"></i>
								</div>
							</div>
						</div>
						<div style="display: none" id="exception7">
							<div class="row">
								<div class="col-md-10">
						<select  id="lead_exception_E7" class="form-control" name="lead_exception_E7[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E7">
							<?php foreach (lead_exception_E7() as $key => $item) { ?>
								<option value="<?= $key ?>" <?= ($lead_exception_E7 == $key) ? 'selected' : '' ?>><?= $item ?></option>
							<?php } ?>
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

		<input id="exception1_value" style="display: none">
		<input id="exception2_value" style="display: none">
		<input id="exception3_value" style="display: none">
		<input id="exception4_value" style="display: none">
		<input id="exception5_value" style="display: none">
		<input id="exception6_value" style="display: none">
		<input id="exception7_value" style="display: none">



		<button class="btn btn-primary nextBtn pull-right" type="button" data-toggle="modal"
				data-target="#createContract">Tạo
		</button>
		<button class="btn btn-secondary  pull-right save_contract" type="button" data-step="6" data-toggle="modal"
				data-target="#saveContract">Lưu
		</button>
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
				<h4 class="modal-title">Xác nhận tạo hợp đồng mới</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-info"
						data-dismiss="modal"><?= $this->lang->line('Cancel') ?></button>
				<button type="button"
						class="btn btn-success btn-create-contract"><?= $this->lang->line('ok') ?></button>
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
								<input required id="company_name_other" name="company_name_other"
									   placeholder="Nhập tên tổ chức khác" class="form-control"
									   type="text" >
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
							<label class="control-label col-md-3">Tiền phải trả hàng kỳ <span class="text-danger"></span>:</label>
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
							<input type="button" id="company_btnSave" class="btn btn-info" value="Lưu">
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


