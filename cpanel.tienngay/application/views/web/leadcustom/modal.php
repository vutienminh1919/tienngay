<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Person Form</h3>
			</div>
			<div class="modal-body form">
				<form id="postLead" method="post" class="form-horizontal">
					<input type="hidden" value="" name="_id"/>
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Họ và Tên :</label>
							<div class="col-md-9">
								<input name="fullname" placeholder="Họ và tên khách hàng" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Hình thức vay</label>
							<div class="col-md-9">
								<select name="type_finance" class="form-control" id="type_finance">
									<?php foreach ($leads = lead_type_finance() as $key => $item) { ?>
										<option value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Hộ khẩu</label>
							<div class="col-md-3">
								<select name="hk_province" class="form-control">
									<?php foreach ($provinces as $key => $item) { ?>
										<option value="<?= $item->code ?>"><?= $item->name ?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
							<div class="col-md-3">
								<select name="hk_district" class="form-control" id="hk_district">
								</select>
								<span class="help-block"></span>
							</div>
							<div class="col-md-3">
								<select name="hk_ward" class="form-control" id="hk_ward">
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Nơi sống</label>
							<div class="col-md-3">
								<select name="ns_province" class="form-control">
									<?php foreach ($provinces as $key => $item) { ?>
										<option value="<?= $item->code ?>"><?= $item->name ?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
							<div class="col-md-3">
								<select name="ns_district" class="form-control" id="ns_district">
								</select>
								<span class="help-block"></span>
							</div>
							<div class="col-md-3">
								<select name="ns_ward" class="form-control" id="ns_ward">
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Đối tượng</label>
							<div class="col-md-9">
								<select name="obj" class="form-control" id="obj">
									<?php foreach ($leads = lead_obj() as $key => $item) { ?>
										<option value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Nơi làm việc</label>
							<div class="col-md-3">
								<input name="com" placeholder="Tên công ty" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
							<label class="control-label col-md-1">Địa chỉ</label>
							<div class="col-md-5">
								<input name="com_address" placeholder="Nhập địa chỉ công ty" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Vị trí/Chức vụ</label>
							<div class="col-md-9">
								<input name="position" placeholder="Vị trí chức vụ" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Thời gian làm việc</label>
							<div class="col-md-9">
								<input name="time_work" placeholder="Thời gian làm việc" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Hợp đồng lao động</label>
							<div class="col-md-3">
								<label class="control-label col-md-3">Có</label>
								<input type="radio" id="has_contract_work" class="col-md-3 radio"
									   name="contract_work" value="true">
								<label class="control-label col-md-3">Không</label>
								<input type="radio" id="no_contract_work" class="col-md-3 radio"
									   name="contract_work" value="false">
								<span class="help-block"></span>
							</div>
							<label class="control-label col-md-3">Giấy tờ xác nhận công việc (Khác)</label>
							<div class="col-md-3">
								<input name="other_contract" placeholder="Giấy tờ xác nhận công việc"
									   class="form-control" type="text">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Hình thức nhận lương</label>
							<div class="col-md-6">
								<label class="control-label col-md-3">Tiền mặt</label>
								<input type="radio" id="salary_pay_mon" class="col-md-3 radio" name="salary_pay"
									   value="true">
								<label class="control-label col-md-3">Chuyển khoản</label>
								<input type="radio" id="salary_pay_card" class="col-md-3 radio" name="salary_pay"
									   value="false">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Thu nhập</label>
							<div class="col-md-3">
								<input name="income" placeholder="Giấy tờ xác nhận công việc" class="form-control"
									   type="text">
							</div>
							<label class="control-label col-md-3">Giấy tờ chứng minh thu nhập khác</label>
							<div class="col-md-3">
								<input name="other_income" placeholder="Giấy tờ chứng minh thu nhập khác"
									   class="form-control" type="text">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Thẩm định nơi làm việc</label>
							<div class="col-md-4">
								<label class="control-label col-md-3">Có</label>
								<input type="radio" id="has_workplace_evaluation" class="col-md-3 radio"
									   name="workplace_evaluation" value="true">
								<label class="control-label col-md-3">Không</label>
								<input type="radio" id="no_workplace_evaluation" class="col-md-3 radio"
									   name="workplace_evaluation" value="false">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Đăng kí xe chính chủ</label>
							<div class="col-md-4">
								<label class="control-label col-md-3">Có</label>
								<input type="radio" id="has_vehicle_registration" class="col-md-3 radio"
									   name="vehicle_registration" value="true">
								<label class="control-label col-md-3">Không</label>
								<input type="radio" id="no_vehicle_registration" class="col-md-3 radio"
									   name="vehicle_registration" value="false">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Nhãn hiệu đời xe</label>
							<div class="col-md-9">
								<select class="form-control" id="property_by_main" name="property_id">
									<?php if (!empty($mainPropertyData)) {
										foreach ($mainPropertyData as $key => $mainProperty) { ?>
											<option class="form-control"
													value="<?= $mainProperty->_id ?>"><?= !empty($mainProperty->name) ? $mainProperty->name : "" ?></option>
										<?php }
									} ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Nhu cầu vay</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="loan_amount">
								<span class="help-block"></span>
							</div>
							<label class="control-label col-md-3">Thời hạn vay</label>
							<div class="col-md-3">
								<select class="form-control" id="loan_time" name="loan_time">
									<?php foreach ($loan_time = loan_time() as $key => $item) { ?>
										<option value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Hình thức trả lãi</label>
							<div class="col-md-3">
								<select class="form-control" id="type_repay" name="type_repay">
									<?php foreach ($type_repay = type_repay() as $key => $item) { ?>
										<option value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
							<label class="control-label col-md-3">Trả góp hàng tháng</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="amout_repay">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Trạng thái TLS</label>
							<div class="col-md-3">
								<select class="form-control" id="status_sale" name="status_sale">
									<?php foreach ($lead_status = lead_status() as $key => $item) { ?>
										<option value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
							<label class="control-label col-md-3">Lý do hủy</label>
							<div class="col-md-3">
								<select class="form-control" id="reason_cancel" name="reason_cancel">
									<?php if (!empty($reason)) {
										foreach ($reason as $key => $obj) { ?>
											<option class="form-control"
													value="<?= $obj->_id ?>"><?= $obj->value ?></option>
										<?php }
									} ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Chuyển đến PGD</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="id_PDG">
								<span class="help-block"></span>
							</div>
							<label class="control-label col-md-3">Thời gian</label>
							<div class="col-md-3">
								<input type="text" class="form-control datepicker" name="time_support">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Địa điểm cụ thể hỗ trợ:</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="address_support">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">TLS ghi chú</label>
							<div class="col-md-9">
								<textarea name="tls_note" placeholder="" class="form-control"></textarea>
								<span class="help-block"></span>
							</div>
						</div>
					</div>
					<div style="text-align: center" id="group-button">
						<button type="button" id="btnSave" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
