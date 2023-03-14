<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
<link
	href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css">
<style>
	.modal-dialog {
		width: 80%;
		height: auto;
		margin: 0;
		padding: 0;
	}

	.modal-content {
		height: auto;
		min-height: 100%;
		border-radius: 0;
	}

	.select2-container {
		width: 100% !important;
	}

	.select2-search--dropdown .select2-search__field {
		width: 98%;
	}
</style>
<div class="right_col" role="main" style="min-height: 1160px;">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Danh sách Lead
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">Danh sách
							khách hàng</a>
					</small>
				</h3>
			</div>
			<div class="title_right text-right">
				<button id="addlead" class="btn btn-info "><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới</button>
			</div>
		</div>
		<?php
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
		$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
		?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">
					<div class="x_title">
						<div class="row">
							<div class="col-xs-12">
								<?php if ($this->session->flashdata('error')) { ?>
									<div class="alert alert-danger alert-result">
										<?= $this->session->flashdata('error') ?>
									</div>
								<?php } ?>
								<?php if ($this->session->flashdata('success')) { ?>
									<div
										class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
								<?php } ?>
								<div class="row">
									<form action="<?php echo base_url('leadcustom/search') ?>" methd="get"
										  style="width: 100%;">
										<div class="col-lg-3">
											<div class="input-group">
												<span
													class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
												<input type="date" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : "" ?>">
											</div>
										</div>
										<div class="col-lg-3">
											<div class="input-group">
												<span
													class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
												<input type="date" name="tdate" class="form-control"
													   value="<?= !empty($tdate) ? $tdate : "" ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<select class="form-control" name="status_sale">
												<?php foreach ($lead_status = lead_status() as $key => $item) {
													if ($key == $status_sale) {
														?>
														<option value="<?= $key ?>" selected><?= $item ?></option>
													<? } else {
														?>
														<option value="<?= $key ?>"><?= $item ?></option>
													<? }
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<input type="text" class="form-control" name="fullname"
												   placeholder="Nhập tên "
												   value="<?= !empty($fullname) ? $fullname : "" ?>">
										</div>
										<div class="col-lg-2 text-right">
											<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																								   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table id="datatable-buttons" class="table table-striped">
							<thead>
							<tr>
								<th>#</th>
								<th>CSKH</th>
								<th>NGÀY THÁNG</th>
								<th>NGUỒN</th>
								<th>HỌ VÀ TÊN</th>
								<th>SỐ ĐIỆN THOẠI</th>
								<th>TRẠNG THÁI LEAD</th>
								<th>LÝ DO HỦY</th>
								<th>CHUYỂN ĐẾN PGD</th>
								<th>XÁC NHẬN</th>
								<th>THAO TÁC</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($leads as $key => $item) { ?>
								<tr>
									<td><?php echo $key + 1 ?></td>
									<td></td>
									<td><?= !empty($item->created_at) ? date('d/m/Y', $item->created_at) : "" ?></td>
									<td></td>
									<td><?= $item->fullname ?></td>
									<td class="callmodal"
										id="<?= $item->_id->{'$oid'} ?>"><?= !empty($item->phone_number) ? $item->phone_number : "" ?></td>
									<td><?= ($item->status_sale) ? lead_status((int)$item->status_sale) : lead_status(0) ?></td>
									<td><?php if (!empty($item->reason_cancel)) {
											foreach ($reason as $key => $value) {
												if ($value->_id == $item->reason_cancel) {
													echo $value->value;
												}
											}
										} else {
											echo "";
										}
										?></td>
									<td><?php if (!empty($item->id_PDG)) {
											foreach ($storeData as $key => $value) {
												if ($value->_id->{'$oid'} == $item->id_PDG) {
													echo $value->name;
												}
											}
										} else {
											echo "";
										}
										?></td>
									<td><?= !empty($item->confirm) ? $item->confirm : "" ?></td>
									<td class="text-right">
										<a href="#" class="btn btn-primary"
										   onclick="detail('<?= $item->_id->{'$oid'} ?>')">
											<i class="fa fa-edit"></i> Chi Tiết
										</a>
										<a href="#" class="btn btn-primary"
										   onclick="delete_lead('<?= $item->_id->{'$oid'} ?>')">
											<i class="fa fa-trash"></i> Hủy
										</a>
										<button class="btn btn-primary"
												onclick="window.location.href='<?= base_url("lead/displayUpdate/") . getId($item->_id) ?>'">
											<i class="fa fa-arrow-circle-o-right"></i> Chuyển đến PGD
										</button>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
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
										<? } ?>
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
										<? } ?>
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
										<? } ?>
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
										<? } ?>
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
										<? } ?>
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
										<? } ?>
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
										<?php foreach ($lead_status = lead_status() as $key => $item) {
											if ($key == 0) { ?>
												<option value="<?= $key ?>" class="no_status_sale"><?= $item ?></option>
											<? } else {
												?>
												<option value="<?= $key ?>"><?= $item ?></option>
											<? }
										} ?>
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
									<select class="form-control" id="id_PDG" name="id_PDG">
										<?php if (!empty($storeData)) {
											foreach ($storeData as $key => $obj) { ?>
												<option class="form-control"
														value="<?= $obj->_id->{'$oid'} ?>"><?= $obj->name ?></option>
											<?php }
										} ?>
									</select>
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
</div>
<script src="<?= base_url("assets") ?>/js/role/search.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $('.callmodal').on('click', function () {
        var id = this.id;
        $.ajax({
            url: '<?= base_url("leadcustom/showLeadInfo/")?>' + id,
            type: "GET",
            dateType: "JSON",
            success: function (result) {
                $('.modal-title').text('Call' + ' ' + result.data.phone_number);
                $('[name="_id"]').val(result.data._id.$oid);
                $('[name="fullname"]').val(result.data.fullname);
                check_drop_box(result.data.type_finance, 'type_finance', 'Chọn hình thức vay');
                check_drop_box(result.data.hk_province, 'hk_province', 'Chọn tỉnh/thành');
                check_drop_box(result.data.ns_province, 'ns_province', 'Chọn tỉnh/thành');
                get_district_by_province(result.data.hk_province, result.data.hk_district, type = 'hk_district');
                get_district_by_province(result.data.ns_province, result.data.ns_district, type = 'ns_district');
                get_ward_by_district(result.data.hk_district, result.data.hk_ward, type = 'hk_ward');
                get_ward_by_district(result.data.ns_district, result.data.ns_ward, type = 'ns_ward');
                check_drop_box(result.data.obj, 'obj', 'Chọn đối tượng');
                check_drop_box(result.data.status_sale, 'status_sale', 'Mới');
                check_drop_box(result.data.id_PDG, 'id_PDG', 'Chọn phòng GD');
                check_drop_box(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
                $('[name="com"]').val(result.data.com);
                $('[name="com_address"]').val(result.data.com_address);
                $('[name="position"]').val(result.data.position);
                $('[name="time_work"]').val(result.data.time_work);
                check_radio(result.data.contract_work, ['#has_contract_work', '#no_contract_work']);
                $('[name="other_contract"]').val(result.data.other_contract);
                check_radio(result.data.salary_pay, ['#salary_pay_mon', '#salary_pay_card']);
                $('[name="income"]').val(result.data.income);
                $('[name="loan_amount"]').val(result.data.loan_amount);
                $('[name="amout_repay"]').val(result.data.amout_repay);
                $('[name="time_support"]').val(result.data.time_support);
                $('[name="other_income"]').val(result.data.other_income);
                $('[name="address_support"]').val(result.data.address_support);
                $('[name="tls_note"]').val(result.data.tls_note);
                check_radio(result.data.workplace_evaluation, ['#has_workplace_evaluation', '#no_workplace_evaluation']);
                check_radio(result.data.vehicle_registration, ['#has_vehicle_registration', '#no_vehicle_registration']);
                $('input').removeAttr("readonly");
                $('select').removeAttr("disabled");
                $('textarea').removeAttr("readonly");
                $('.form-control').parent().removeClass('has-error');
                $('.help-block').empty();
                $('#modal_form').modal('show');
            }
        });
    });

    $('#addlead').on('click', function () {
        $('#modal_form').modal('show');
    });

    function detail(id) {
        $.ajax({
            url: '<?= base_url("leadcustom/showLeadInfo/")?>' + id,
            type: "GET",
            dateType: "JSON",
            success: function (result) {
                $('.modal-title').text('Call' + ' ' + result.data.phone_number);
                $('[name="_id"]').val(result.data._id.$oid);
                $('[name="fullname"]').val(result.data.fullname);
                check_drop_box(result.data.type_finance, 'type_finance', 'Chọn hình thức vay');
                check_drop_box(result.data.hk_province, 'hk_province', 'Chọn tỉnh/thành');
                check_drop_box(result.data.ns_province, 'ns_province', 'Chọn tỉnh/thành');
                get_district_by_province(result.data.hk_province, result.data.hk_district, type = 'hk_district');
                get_district_by_province(result.data.ns_province, result.data.ns_district, type = 'ns_district');
                get_ward_by_district(result.data.hk_district, result.data.hk_ward, type = 'hk_ward');
                get_ward_by_district(result.data.ns_district, result.data.ns_ward, type = 'ns_ward');
                check_drop_box(result.data.obj, 'obj', 'Chọn đối tượng');
                check_drop_box(result.data.status_sale, 'status_sale', 'Mới');
                check_drop_box(result.data.id_PDG, 'id_PDG', 'Chọn phòng GD');
                check_drop_box(result.data.reason_cancel, 'reason_cancel', 'Chọn lý do');
                $('[name="com"]').val(result.data.com);
                $('[name="com_address"]').val(result.data.com_address);
                $('[name="position"]').val(result.data.position);
                $('[name="time_work"]').val(result.data.time_work);
                check_radio(result.data.contract_work, ['#has_contract_work', '#no_contract_work']);
                $('[name="other_contract"]').val(result.data.other_contract);
                check_radio(result.data.salary_pay, ['#salary_pay_mon', '#salary_pay_card']);
                $('[name="income"]').val(result.data.income);
                $('[name="loan_amount"]').val(result.data.loan_amount);
                $('[name="amout_repay"]').val(result.data.amout_repay);
                $('[name="time_support"]').val(result.data.time_support);
                $('[name="other_income"]').val(result.data.other_income);
                $('[name="address_support"]').val(result.data.address_support);
                $('[name="tls_note"]').val(result.data.tls_note);
                check_radio(result.data.workplace_evaluation, ['#has_workplace_evaluation', '#no_workplace_evaluation']);
                check_radio(result.data.vehicle_registration, ['#has_vehicle_registration', '#no_vehicle_registration']);
                $('#modal_form input').attr('readonly', 'readonly');
                $('#modal_form textarea').attr('readonly', 'readonly');
                $('#modal_form select').prop('disabled', true);
                $('.form-control').parent().removeClass('has-error');
                $('.help-block').empty();
                $('#modal_form').modal('show');
            }
        });
    }

    function delete_lead(id) {
        Swal.fire({
            title: 'Hủy Lead?',
            text: "Bạn chắc chắn muốn hủy lead",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url("leadcustom/lead_delete?_id=")?>' + id,
                    type: "GET",
                    dateType: "JSON",
                    success: function (result) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then((result) => {
                            if (result.value) {
                                window.location.reload();
							}
						})
                    }
                });
            }
        });
    }


    $('#btnSave').on('click', function () {
        $.ajax({
            url: '<?= base_url("leadcustom/save_lead")?>',
            type: "POST",
            dateType: "JSON",
            data: $('form').serialize(),
            success: function (data) {
                if (data.data == null) {
                    $('#modal_form').modal('show');
                    window.location.reload();
                } else {
                    var err = data.data;
                    if (err.fullname != null) {
                        $('[name="fullname"]').parent().addClass('has-error');
                        $('[name="fullname"]').next().html(err.fullname);
                    }
                    if (err.com != null) {
                        $('[name="com"]').parent().addClass('has-error');
                        $('[name="com"]').next().html(err.com);
                    }
                }
            }
        });
    });

    $('[name="time_support"]').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    $('#property_by_main').select2();

    $('[name="hk_province"]').on('change', function (event) {
        event.preventDefault();
        remove_old_data('.hk_ward');
        let province_id = $(this).children("option:selected").val();
        get_district_by_province(province_id, null, 'hk_district');
    });

    $('[name="ns_province"]').on('change', function (event) {
        event.preventDefault();
        remove_old_data('.ns_ward');
        let province_id = $(this).children("option:selected").val();
        get_district_by_province(province_id, null, 'ns_district');
    });

    $('[name="hk_district"]').on('change', function (event) {
        event.preventDefault();
        let district_id = $(this).children("option:selected").val();
        get_ward_by_district(district_id, null, 'hk_ward');
    });

    $('[name="ns_district"]').on('change', function (event) {
        event.preventDefault();
        let district_id = $(this).children("option:selected").val();
        get_ward_by_district(district_id, null, 'ns_ward');
    });

    function check_radio(check = 'false', type) {
        if (check == 'true') {
            $(type[0]).prop('checked', true);
        } else {
            $(type[1]).prop('checked', true);
        }
    }

    function check_drop_box(check = null, type, text) {
        remove_old_data('.no_' + type);
        if (check != null && check != 0) {
            $('[name="' + type + '"]').val(check);
        } else {
            $('[name="' + type + '"]').prepend('<option value="" class="no_' + type + '" selected>-- ' + text + ' --</option>');
        }
    }

    function get_district_by_province(province, district = null, type) {
        remove_old_data('.' + type);
        if (district == null) {
            $('[name="' + type + '"]').append('<option value="" class="' + type + '">-- Chọn quận/huyện --</option>');
        }
        $.ajax({
            url: '<?= base_url("leadcustom/get_district_by_province/")?>' + province,
            type: "GET",
            dateType: "JSON",
            success: function (result) {
                let districts = result.data;
                for (i = 0; i < districts.length; i++) {
                    if (districts[i].code == district) {
                        $('[name="' + type + '"]').append('<option value="' + districts[i].code + '" class="' + type + '" selected >' + districts[i].name + '</option>');
                    } else {
                        $('[name="' + type + '"]').append('<option value="' + districts[i].code + '" class="' + type + '" >' + districts[i].name + '</option>');
                    }
                }
            }
        });
    }

    function get_ward_by_district(district, ward = null, type) {
        remove_old_data('.' + type);
        if (ward == null) {
            $('[name="' + type + '"]').append('<option value="" class="' + type + '">-- Chọn xã/phường --</option>');
        }
        $.ajax({
            url: '<?= base_url("leadcustom/get_ward_by_district/")?>' + district,
            type: "GET",
            dateType: "JSON",
            success: function (result) {
                let ward = result.data;
                for (i = 0; i < ward.length; i++) {
                    if (ward[i].code == ward) {
                        $('[name="' + type + '"]').append('<option value="' + ward[i].code + '"  class="' + type + '" selected >' + ward[i].name + '</option>');
                    } else {
                        $('[name="' + type + '"]').append('<option value="' + ward[i].code + '"  class="' + type + '" >' + ward[i].name + '</option>');
                    }
                }
            }
        });
    }

    function remove_old_data(oid) {
        $(oid).remove();
    }
</script>
