<?php
$type = $_GET['type'] ? $_GET['type'] : 'XM';
$from_date = !empty($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = !empty($_GET['to_date']) ? $_GET['to_date'] : '';
$hang_xe_blacklist = !empty($_GET['hang_xe_blacklist']) ? $_GET['hang_xe_blacklist'] : '';
$hang_xe_filter = !empty($_GET['hang_xe']) ? $_GET['hang_xe'] : '';
$bien_so_xe_blacklist = !empty($_GET['bien_so_xe_blacklist']) ? $_GET['bien_so_xe_blacklist'] : '';
$so_khung_blacklist = !empty($_GET['so_khung_blacklist']) ? $_GET['so_khung_blacklist'] : '';
$so_may_blacklist = !empty($_GET['so_may_blacklist']) ? $_GET['so_may_blacklist'] : '';
$phone_blacklist = !empty($_GET['phone_blacklist']) ? $_GET['phone_blacklist'] : '';
$identify_passport_blacklist = !empty($_GET['identify_passport_blacklist']) ? $_GET['identify_passport_blacklist'] : '';

?>

<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
		<?php if ($this->session->flashdata('error')) { ?>
			<div class="alert alert-danger alert-result">
				<?= $this->session->flashdata('error') ?>
			</div>
		<?php } ?>
		<?php if ($this->session->flashdata('success')) { ?>
			<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
		<?php } ?>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="row">
					<div class="col-xs-12 col-md-8">
						<div class="title">
							<span class="tilte_top_tabs">
								 BLACKLIST TÀI SẢN
							</span>

						</div>
					</div>
					<div class="col-xs-12 col-md-4 text-right">
						<select id="select_type" class="sellect options" name="property">
							<option value="XM" <?php echo ($type == 'XM') ? 'selected' : '' ?>>Xe máy</option>
							<option value="OTO" <?php echo ($type == 'OTO') ? 'selected' : '' ?>>Ô tô</option>
						</select>
					</div>
				</div>
			</div>
			<div class="middle table_tabs">
				<div class="clicked nav_tabs_vertical nav tabs">

				</div>

				<div class="tab-contents">
					<!-- tab valuation-->
					<div role="tabpanel" class="tab-pane fade in"
						 id="dinh-gia-tai-san"
						 aria-labelledby="khau-hao-tab">
						<div class="row">
							<div class="col-md-6 col-sx-12 text-left btn_list_filter">

							</div>
							<div class="col-md-6 col-sx-12 btn_list_filter text-right">
								<div class="button_functions btn-filter">
									<a class="btn btn-secondary btn-success" data-toggle="modal"
									   data-target="#add_property" <?= in_array('bo-phan-dinh-gia', $groupRoles) ? "" : 'style="display:none"' ?>>
										Import Blacklist
									</a>
									<div class="button_functions btn-fitler">
										<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
											Tìm kiếm <i class="fa fa-filter"></i>
										</button>
										<div class="dropdown-menu drop_select">
											<input id="from_date" class="limit_on_page"
												   name="from_date" type="date"
												   placeholder="Từ ngày" style="margin-left: 45px;">
											<input id="to_date" class="limit_on_page"
												   name="to_date" type="date"
												   placeholder="Đến ngày" style="margin-left: 45px;">
											<div class="hang_xe_blacklist_css" style="margin-left: 45px; width: 300px;">
												<select id="hang_xe_blacklist"
														name="hang_xe_blacklist" type="text"
														placeholder="Hãng xe">
													<option value="">Chọn hãng xe</option>
													<?php foreach ($branch_property as $property_branch) : ?>
														<option <?php if (!empty($hang_xe_filter) && $hang_xe_filter == $property_branch->id ) echo 'selected';?> value="<?php echo !empty($property_branch->id) ? $property_branch->id : '' ?>">
															<?php echo !empty($property_branch->name) ? $property_branch->name : '' ?>
														</option>
													<?php endforeach; ?>
												</select>
											</div>

											<input id="bien_so_xe_blacklist" class="limit_on_page"
												   name="bien_so_xe_blacklist" type="text"
												   placeholder="Biển số xe" style="margin-left: 45px;">
											<input id="so_khung_blacklist" class="limit_on_page"
												   name="so_khung_blacklist" type="text"
												   placeholder="Số khung" style="margin-left: 45px;">
											<input id="so_may_blacklist" class="limit_on_page"
												   name="so_may_blacklist" type="text"
												   placeholder="Số máy" style="margin-left: 45px;">
											<input id="phone_blacklist" class="limit_on_page"
												   name="phone_blacklist" type="number"
												   placeholder="Số điện thoại" style="margin-left: 45px;">
											<input id="identify_blacklist" class="limit_on_page"
												   name="identify_passport_blacklist" type="text"
												   placeholder="Số cmnd/cccd/hộ chiếu" style="margin-left: 45px;">
											<a class=" btn btn-outline-danger" id="reset"
											   href="<?= base_url('property/blacklist') ?>">Reset bộ lọc</a>
											<button type="button" class="btn btn-outline-success"
													id="search_blacklist">
												Tìm kiếm
											</button>

										</div>
										<a href="<?= base_url('Property/exportBlacklistCavet?from_date=') . $from_date.
											'&to_date=' . $to_date .
											'&hang_xe=' . $hang_xe_filter .
											'&bien_so_xe_blacklist=' . $bien_so_xe_blacklist .
											'&so_khung_blacklist=' . $so_khung_blacklist .
											'&so_may_blacklist=' . $so_may_blacklist .
											'&phone_blacklist=' . $phone_blacklist .
											'&identify_passport_blacklist=' . $identify_passport_blacklist
											?>" target="_blank" class="btn btn-info">
											Xuất excel <i class="fa fa-file-excel-o"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<div>
								<h3>Danh sách blacklist tài sản </h3>
								<h4 class="text-success">Hiển thị (<span
											class="text-danger"><?php echo !empty($total_rows) ? $total_rows : 0 ?></span>)
									kết quả</h4>
							</div>
							<hr>
							<table id="" class="table table-striped">
								<thead>
								<tr style="text-align: center">
									<th style="text-align: center">STT</th>
									<th style="text-align: center">Loại xe</th>
									<th style="text-align: center">Hãng xe</th>
									<th style="text-align: center">Số khung</th>
									<th style="text-align: center">Số máy</th>
									<th style="text-align: center">Biển số xe</th>
									<th style="text-align: center">Người tạo</th>
									<th style="text-align: center">Ngày tạo</th>
									<th style="text-align: center">Trạng thái</th>
									<th style="text-align: center">Chức năng</th>
								</tr>
								</thead>
								<tbody align="center">
								<?php if (!empty($property)) : ?>
									<?php foreach ($property as $key => $value) : ?>
										<tr>
											<td><?php echo ++$key ?></td>
											<td><?php echo $value->code == 'XM' ? '<i class="fa fa-motorcycle "></i>' : '<i class="fa fa-car"></i>' ?></td>
											<td><?php echo !empty($value->brand_name) ? $value->brand_name : '' ?></td>
											<td><?php echo !empty($value->chassis_number) ? $value->chassis_number : '' ?></td>
											<td><?php echo !empty($value->engine_number) ? $value->engine_number : '' ?></td>
											<td><?php echo !empty($value->vehicle_number) ? $value->vehicle_number : '' ?></td>
											<td><?php echo !empty($value->created_by) ? $value->created_by : '' ?></td>
											<td><?php echo !empty($value->created_at) ? date('d/m/Y', $value->created_at) : '' ?></td>
											<?php if ($value->status == 'active') : ?>
												<td>
													<span style="font-size: 14px" class="label label-success">Đã xác nhận</span>
												</td>
											<?php else : ?>
												<td>
													<span style="font-size: 14px" class="label label-warning">Đang chờ cập nhật</span>
												</td>
											<?php endif; ?>
											<td>
												<div class="dropdown">
													<button class="btn btn-primary dropdown-toggle" type="button"
															id="dropdownMenuButton" data-toggle="dropdown"
															aria-haspopup="true" aria-expanded="false">
														Chức năng <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" style="z-index: 99999">
														<li>
															<a class="dropdown-item"
															   href="<?= base_url('property/blacklistDetail?id=' . $value->_id->{'$oid'}) ?>"
															   type="button"
															   data-id="<?= $value->_id->{'$oid'} ?>">
																Chi tiết
															</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="9" class="text-center">Không có dữ liệu</td>
									</tr>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
						<div>
							<nav class="text-right">
								<?php echo $pagination; ?>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add_property" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h3 class="text-primary" style="text-align: left">
						Thêm blacklist <?php echo $type == 'XM' ? 'Xe máy' : 'Ôtô' ?>
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body ">
				<div class="form-group_popup">
					<div class="form_input">
						<label>Upload excel</label>
						<div class="form-group">
							<input type="file" name="import" class="form-control"
								   placeholder="sothing">
						</div>
					</div>
					<div class="company_send text-right">
						<button type="button" class="company_close btn btn-secondary" data-dismiss="modal">Đóng</button>
						<?php if ($type == 'XM') : ?>
							<button type="button" class="btn btn-success" id="import_xe_may">Xác nhận
							</button>
						<?php else: ?>
							<button type="button" class="btn btn-success" id="import_oto">Xác nhận
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.btn-filter .dropdown-menu {
		left: -135px;
		width: auto;
		padding: 10px;
	}

	#select_type {
		background: #FFFFFF;
		border: 1px solid #cccc;
		border-radius: 3px;
		width: 200px;
		padding: 5px;
		color: #232E3C;
	}

	.limit_on_page {
		width: 300px !important;
		height: 35px;
		margin-left: 50px; !important;
	}

	#reset {
		background: transparent;
		border: 1px solid #ff0b00;
		color: #d9534f;
		float: left;
		margin-top: 10px;
	}

	@media (max-width: 768px) {
		.btn_list_filter {
			display: block;
		}

		.btn-filter .dropdown-menu {
			left: 0px;
			width: auto;
			padding: 10px;
		}
	}

	@media (max-width: 912px) {
		.btn_list_filter {
			display: block;
		}

		.btn-filter .dropdown-menu {
			left: 0px;
			width: auto;
			padding: 10px;
		}
	}
</style>

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/property/new/index.js"></script>
<script>
	$(document).ready(function () {
		$('.btn-filter button.btn-success').on('click', function () {
			$('.drop_select').toggle();
		});

		$("#select_type").change(function () {
			let type = $("select[name='property']").val()
			window.location.href = _url.base_url + "property/blacklist?type=" + type;
		})

		$('#search_blacklist').click(function () {
			let from_date = $("input[name='from_date']").val()
			let to_date = $("input[name='to_date']").val()
			let type = $("select[name='property']").val()
			let bien_so_xe_blacklist = $("input[name='bien_so_xe_blacklist']").val()
			let hang_xe_blacklist = $("select[name='hang_xe_blacklist']").val()
			let so_khung_blacklist = $("input[name='so_khung_blacklist']").val()
			let so_may_blacklist = $("input[name='so_may_blacklist']").val()
			let phone_blacklist = $("input[name='phone_blacklist']").val()
			let identify_passport_blacklist = $("input[name='identify_passport_blacklist']").val()
			window.location.href = _url.base_url + "property/blacklist?type=" + type + "&bien_so_xe=" + bien_so_xe_blacklist +
				"&hang_xe=" + hang_xe_blacklist + "&so_khung=" + so_khung_blacklist + "&so_may=" + so_may_blacklist + "&phone=" +
				phone_blacklist + "&identify_passport=" + identify_passport_blacklist + "&from_date=" + from_date + "&to_date=" + to_date
		})

		$('.delete_property').click(function (event) {
			event.preventDefault();
			let id = $(this).attr("data-id-delete")
			console.log(id)
			let formData = new FormData();
			formData.append('id', id);
			if (confirm('Bạn chắc chắn muốn xóa tài sản này ?')) {
				$.ajax({
					url: _url.base_url + 'property/requestBlacklistDelete',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						if (data.code == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.msg);
							setTimeout(function () {
								window.location.href = _url.base_url + 'property/requestBlacklist';
							}, 2000);
						} else {
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
						}
					},
					error: function () {
						$(".theloading").hide();
						console.log('error')
						alert('error')
					}
				});
			}
		});

		$("#import_xe_may").click(function (event) {
			event.preventDefault();
			let type = $("select[name='property']").val()
			var inputimg = $('input[name=import]');
			var fileToUpload = inputimg[0].files[0];
			var formData = new FormData();
			formData.append('upload_file', fileToUpload);
			formData.append('type', type);

			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'property/importBlacklistXM',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$('#add_property').hide();
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.res) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property/blacklist?type=' + type;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property/blacklist?type=' + type;
						}, 2000);
					}

				},
				error: function (data) {
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text("error");
					setTimeout(function () {
						window.location.href = _url.base_url + 'property/blacklist?type=' + type;
					}, 2000);
				}
			});
		});

		$("#import_oto").click(function (event) {
			event.preventDefault();
			let type = $("select[name='property']").val()
			var inputimg = $('input[name=import]');
			var fileToUpload = inputimg[0].files[0];
			var formData = new FormData();
			formData.append('upload_file', fileToUpload);
			formData.append('type', type);

			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'property/importBlacklistOTO',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$('#add_property').hide();
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.res) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property/blacklist?type=' + type;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property/blacklist?type=' + type;
						}, 2000);
					}

				},
				error: function (data) {
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text("error");
					setTimeout(function () {
						window.location.href = _url.base_url + 'property/blacklist?type=' + type;
					}, 2000);
				}
			});
		});

		$('#hang_xe_blacklist').selectize({
			create: false,
			valueField: 'code',
			labelField: 'name',
			searchField: 'name',
			maxItems: 1,
			sortField: {
				field: 'name',
				direction: 'asc'
			}
		})

	});
</script>



