<div class="modal-dialog" style="
    width: 80%;
">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			<h3 class="modal-title" style="text-align: center">GỌI CHO KHÁCH HÀNG</h3>
		</div>
		<div class="modal-body">
			<button type="button" class="btn btn-primary btnSave">Lưu</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Thoát</button>
			<?php if (date('H') < 8 || date("H") > 16) { ?>
				<div class="alert alert-danger">
					<strong>Cảnh báo: Bây giờ là <?= date('H:i:s') ?></strong> Cuộc gọi quảng cáo sẽ không được thực
					hiện trước 8h và sau 17h, vi phạm sẽ bị phạt tới 100 triệu, bạn có chắc chắn đây không phải cuộc gọi
					quảng cáo ?
				</div>
			<?php } ?>
			<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
			<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
			<button id="tool" class="btn btn-info tool_dinh_gia" style="position: absolute;right: 10px"><i
						class="fa fa-info" aria-hidden="true"></i> Tool
			</button>

			<input id="number" name="phone_number" type="hidden" value=""/>
			<p id="status" style="margin-left: 125px;"></p>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<span class='div_error'></span>
			</div>
			<div class="alert alert-success alert-dismissible text-center" style="display:none" id="div_success1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<span class='div_success'></span>
			</div>
			<div class="row mb-5">
				<div class="col-xs-12 tool_property" style="display: none">
					<div class="x_panel">
						<?php $this->load->view('page/property/template/loan_info_have_init_new', ['configuration_formality' => $configuration_formality, 'main_PropertyData' => $main_PropertyData]) ?>
					</div>
				</div>
			</div>
			<div class="row">

				<div class="col-xs-12">
					<input type="hidden" value="" name="_id"/>

					<div class="form-group">
						<label class="control-label col-md-3">Họ và Tên :</label>
						<div class="col-md-9">
							<input name="fullname" placeholder="Họ và tên khách hàng" class="form-control"
								   id="ho_va_ten"
								   type="text">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Email :</label>
						<div class="col-md-9">
							<input name="email" placeholder="Email khách hàng" class="form-control"
								   type="text">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Ngày sinh :</label>
						<div class="col-md-9">
							<input name="dob_lead" placeholder="Ngày sinh khách hàng" class="form-control"
								   type="date" max="2021-12-31" min="1900-01-01">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">CMND/CCCD :</label>
						<div class="col-md-9">
							<input name="identify_lead" placeholder="CMND/CCCD khách hàng" class="form-control"
								   type="text" maxlength="12">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Sim chính chủ</label>
						<div class="col-md-9">
							<select class="form-control" id="sim_chinh_chu" name="sim_chinh_chu">

								<option value="sim_chinh_chu">Sim chính chủ</option>
								<option value="sim_khong_chinh_chu">Sim không chính chủ</option>

							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Sản phẩm vay</label>
						<div class="col-md-9">
							<select name="type_finance" class="form-control" id="type_finance">
								<?php foreach ($lead_type_finance as $key => $item) { ?>
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
						<label class="control-label col-md-3">Địa chỉ :</label>
						<div class="col-md-9">
							<input name="address" placeholder="Địa chỉ" class="form-control"
								   type="text">
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
							<label><input id="has_contract_work" name='contract_work' value="1"
										  type="radio">&nbsp;Có</label>
							<label><input id="no_contract_work" name='contract_work' value="2" type="radio">&nbsp;Không</label>

						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Giấy tờ xác nhận công việc (Khác)</label>
						<div class="col-md-3">
							<input name="other_contract" placeholder="Giấy tờ xác nhận công việc"
								   class="form-control" type="text">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Hình thức nhận lương</label>
						<div class="col-md-3">
							<label><input id="salary_pay_mon" name='salary_pay' value="1" type="radio">&nbsp;Tiền
								mặt</label>
							<label><input id="salary_pay_card" name='salary_pay' value="2" type="radio">&nbsp;Chuyển
								khoản</label>


						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Thu nhập</label>
						<div class="col-md-3">
							<input name="income" placeholder="Thu nhập" class="form-control"
								   type="text">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Giấy tờ chứng minh thu nhập khác</label>
						<div class="col-md-3">
							<input name="other_income" placeholder="Giấy tờ chứng minh thu nhập khác"
								   class="form-control" type="text">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Thẩm định nơi làm việc</label>
						<div class="col-md-3">
							<label><input id="has_workplace_evaluation" name='workplace_evaluation' value="1"
										  type="radio">&nbsp;Có</label>
							<label><input id="no_workplace_evaluation" name='workplace_evaluation' value="2"
										  type="radio">&nbsp;Không</label>


						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Đăng kí xe chính chủ</label>
						<div class="col-md-3">
							<label><input id="has_vehicle_registration" name='vehicle_registration' value="1"
										  type="radio">&nbsp;Có</label>
							<label><input id="no_vehicle_registration" name='vehicle_registration' value="2"
										  type="radio">&nbsp;Không</label>

						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Nhãn hiệu đời xe</label>
						<div class="col-md-3">
							<select class="form-control" id="property_by_main" name="property_id"
									style="min-width: 150px;">
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
												value="<?= $key ?>"><?= $obj ?></option>
									<?php }
								} ?>
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Chuyển đến PGD</label>
						<div class="col-md-3">

							<select class="form-control" id="id_PDG" name="id_PDG">
								<option class="form-control" value="">Chọn phòng giao dịch</option>
								<?php if (!empty($storeData)) {
									foreach ($storeData as $key => $obj) {
										if ($obj->status != "active")
											continue;
										?>
										<option class="form-control"
												value="<?= $obj->_id->{'$oid'} ?>"><?= $obj->name ?></option>
									<?php }
								} ?>
							</select>
							<span class="help-block"></span>
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Nguồn</label>
						<div class="col-md-3">
							<select name="source" class="form-control" id="source">
								<?php
								foreach (lead_nguon() as $key => $obj) { ?>
									<option class="form-control"
											value="<?= $key ?>"><?= $obj ?></option>

								<?php } ?>
							</select>
							<span class="help-block"></span>

						</div>
						<!--  <label class="control-label col-md-3">Dư nợ:</label>
									 <div class="col-md-3">
										 <input type="text" class="form-control" name="debt">
										 <span class="help-block"></span>
									 </div> -->
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Trạng thái lead PGD</label>
						<div class="col-md-3">
							<select class="form-control" id="status_pgd" name="status_pgd">
								<?php foreach (status_pgd() as $key => $item) { ?>
									<option value="<?= $key ?>"><?= $item ?></option>
								<?php } ?>
							</select>
							<span class="help-block"></span>
						</div>
						<label class="control-label col-md-3">Địa điểm cụ thể hỗ trợ:</label>
						<div class="col-md-3">
							<input type="text" class="form-control" name="address_support">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3">Lý do lead PGD</label>
						<div class="col-md-3 ">
							<select class="form-control" name="reason_return" id="reason_return" required>
								<option value="">-- Chọn lý do --</option>
								<?php
								foreach (reason_return() as $key => $reason_return) { ?>
									<option value="<?= $key ?>"><?= $reason_return ?></option>
								<?php } ?>
							</select>
							<span class="help-block"></span>
							<!--							</div>-->

							<!--							<div class="col-md-3 show_reason_cancel">-->
							<select class="form-control" name="reason_cancel_pgd" id="reason_cancel_pgd" required>
								<option value="">-- Chọn lý do --</option>
								<?php if (!empty($reasonData)) {
									foreach ($reasonData as $reason) {
										if ($reason->status != "active")
											continue;
										?>
										<option value="<?= $reason->code_reason ?>"><?= $reason->reason_name ?></option>
									<?php }
								} ?>

							</select>
							<span class="help-block"></span>
							<!--							</div>-->

							<!--							<div class="col-md-3 show_reason_process">-->
							<select class="form-control" name="reason_process" id="reason_process" required>
								<option value="">-- Chọn lý do --</option>
								<?php
								foreach (reason_process() as $key => $status_process) { ?>
									<option value="<?= $key ?>"><?= $status_process ?></option>
								<?php } ?>
							</select>
							<span class="help-block"></span>
							<!--							</div>-->
						</div>
					</div>
					<!-- <div class="form-group">
						<label class="control-label col-md-3">UTM Source:</label>
						<div class="col-md-3">
							<input type="text" class="form-control" name="utm_source">
							<span class="help-block"></span>
						</div>
					</div> -->
					<!-- <div class="form-group">
						<label class="control-label col-md-3">UTM Campaign:</label>
						<div class="col-md-3">
							<input type="text" class="form-control" name="utm_campaign">
							<span class="help-block"></span>
						</div>
					</div> -->
					<div class="form-group">
						<label class="control-label col-md-3">Qualified</label>
						<div class="col-md-3">
							<label><input id="has_qualified" name='qualified' value="1" type="radio">&nbsp;Có</label>
							<label><input id="no_qualified" name='qualified' value="2" type="radio">&nbsp;Không</label>
							<span class="help-block"></span>

						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-md-3">TLS ghi chú</label>
						<div class="col-md-3">
							<textarea name="tls_note" rows="4" cols="100" placeholder=""
									  class="form-control"></textarea>
							<span class="help-block"></span>

						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3">PGD ghi chú</label>
						<div class="col-md-3">
							<textarea name="pgd_note" id="pgd_note" rows="4" cols="100" placeholder=""
									  class="form-control"></textarea>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3">Thời gian khách hẹn</label>
						<div class="col-md-3" style="height: 107px">
							<input name="thoi_gian_khach_hen"
								   class="form-control" type="datetime-local">
							<span class="help-block"></span>
						</div>
					</div>

					<br>

					<div class="col-md-12 text-right" style="margin-top: 20px">
						<button id="history-note-button" class="btn btn-info">Lịch sử ghi chú</button>
						<div class="history-note" id="history-note" style="overflow-x: scroll; white-space: normal; margin-bottom: 20px">
							<table id="datatable-buttons" class="table table-striped dataTable no-footer dtr-inline"
								   role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; text-align: left;">
								<thead>
								<tr role="row">
									<th>#
									</th>
									<th>Thời gian
									</th>
									<th>NV Telesale
									</th>
									<th>Tên khách hàng
									</th>
									<th>TT Trước
									</th>
									<th>TT Cuối
									</th>
									<th>Lý do hủy TLS
									</th>
									<th>Ghi chú TLS
									</th>
								</tr>
								</thead>
								<tbody id="tbody_lead_log_modal">

								</tbody>
							</table>
						</div>
					</div>


					<div class="row ">
						<div style="text-align: center" id="group-button" class="col-md-12">
							<button type="button" class="btn btn-primary btnSave">Lưu</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>


			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error2">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<span class='div_error'></span>
			</div>
			<div class="alert alert-success alert-dismissible text-center" style="display:none" id="div_success2">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<span class='div_success'></span>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
	$(document).ready(function () {
		$('#tool').click(function () {
			$('.tool_property').toggle()
		})
		$('#history-note-button').click(function () {
			$('.history-note').toggle()
		})
	})
</script>
<style>
	#history-note{
		display: none;
	}
</style>
