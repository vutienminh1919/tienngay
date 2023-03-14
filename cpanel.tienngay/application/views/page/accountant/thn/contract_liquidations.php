<div class="theloading" style="display:none">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
	<span>Đang Xử Lý...</span>
</div>

<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
	?>
	<div class="row top_tiles">

		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>

		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Quản lý hợp đồng có tài sản thanh lý
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#>">Quản
									lý hợp đồng có tài sản thanh lý</a>
							</small>
						</h3>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12 ">
							<div class="row">
								<form action="<?php echo base_url('accountant/contract_liquidations') ?>" method="get" style="width: 100%;">
									<div class="col-xs-12">
										<div class="row">
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label> Từ </label>
													<input type="date" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label> Đến </label>
													<input type="date" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">

												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Phòng giao dịch</label>
												<select id="province" class="form-control" name="store">
													<option value=""><?= $this->lang->line('All') ?></option>
													<?php foreach ($storeData as $p) {
														if ($p->status != 'active') continue;
														?>
														<option <?php echo $store == $p->id ? 'selected' : '' ?>
																value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Họ và tên</label>
												<input type="text" name="customer_name" class="form-control"
													   placeholder="Tên khách hàng"
													   value="<?php echo $customer_name; ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Số điện thoại</label>
												<input type="text" name="customer_phone_number" class="form-control"
													   placeholder="Số điện thoại"
													   value="<?php echo $customer_phone_number; ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Mã hợp đồng</label>
												<input type="text" name="code_contract_disbursement"
													   class="form-control" placeholder="Mã hợp đồng"
													   value="<?php echo $code_contract_disbursement; ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Mã phiếu ghi</label>
												<input type="text" name="code_contract"
													   class="form-control" placeholder="Mã phiếu ghi"
													   value="<?php echo $code_contract; ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Trạng thái</label>
												<select class="form-control" name="status" >
													<option value="">-- Tất cả --</option>
													<?php foreach ( contract_status() as $key => $item) :
														if (!in_array($key, [19,40,44,45,46,47,48,49])) continue; ?>
														<option <?php echo $status == $key ? 'selected' : '' ?> value="<?php echo $key; ?>"><?php echo $item; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<button type="submit" class="btn btn-primary w-100"><i
															class="fa fa-search" aria-hidden="true"></i> Tìm kiếm
												</button>
											</div>
											<?php if ($userSession['is_superadmin'] == 1 || in_array('tbp-thu-hoi-no', $groupRoles)) : ?>
											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<a style="background-color: #18d102;"
												   href="<?= base_url() ?>Excel/export_contract_liquidation?code_contract_disbursement=<?= $code_contract_disbursement . '&fdate=' . $fdate . '&tdate=' . $tdate . '&customer_name=' . $customer_name . '&phone_number=' . $phone_number . '&store=' . $store . '&status=' . $status . '&code_contract=' . $code_contract ?>"
												   class="btn btn-primary w-100" target="_blank"><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
													Xuất excel
												</a>
											</div>
											<?php endif;?>
										</div>
								</form>
							</div>
						</div>
						<!--						<div class="clearfix"></div>-->

						<div>
							<div class="row">
								<div class="col-xs-12">
									<div class="table-responsive">
										<div>Hiển thị (<span class="text-danger"><?php echo $result_count; ?></span>)
											kết quả
										</div>
										<table id="" class="table table-striped table-bordered">
											<thead>
											<tr>
												<th>STT</th>
												<th>Thao tác</th>
												<th>Mã hợp đồng</th>
												<th>Mã phiếu ghi</th>
												<th>Khách hàng</th>
												<th>Số điện thoại</th>
												<th>Ngày tạo yêu cầu thanh lý</th>
												<th>Ngày bán tài sản thanh lý</th>
												<th>Số tiền định giá</th>
												<th>Số tiền TP.QLHDV gửi duyệt</th>
												<th>Số tiền CEO duyệt</th>
												<th>Số tiền thực bán</th>
												<th>Chi phí thanh lý</th>
												<th>Số tiền giảm trừ</th>
												<th>Trạng thái</th>
												<th>Phòng giao dịch</th>
											</tr>
											</thead>
											<tbody>
											<?php
											if (!empty($contractLiquidations)) {
												foreach ($contractLiquidations as $key => $contract) {
													?>
													<tr>
														<td><?php echo ++$key + $page ?></td>
														<td style="text-align: -webkit-center;">
														<?php if ( $userSession['is_superadmin'] == 1 || in_array($userSession['email'], $role_liq) ) : ?>
															<!--QLHĐV khởi tạo YC định giá tài sản thanh lý => START-->
															<?php if (in_array($contract->status, array(17, 20))) { ?>
																	<a class="btn btn-info btn-sm"
																	   onclick="showModal_contract('<?= $contract->_id->{'$oid'} ?>')"
																	   href="javascript:void(0)">
																		Khởi tạo thanh lý tài sản
																	</a>
															<?php } ?>
															<!--QLHĐV khởi tạo YC định giá tài sản thanh lý => END-->
															<!--QLHĐV tạo lại YC định giá tài sản thanh lý => START-->
															<?php if (in_array($contract->status, array(45))) { ?>
																	<a href="javascript:void(0)"
																	   onclick="thn_tao_lai_thanh_ly('<?= $contract->_id->{'$oid'} ?>')"
																	   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																	   class="btn btn-info btn-sm tp_thn_duyet">
																		QLHĐV tạo lại thanh lý tài sản
																	</a>
															<?php } ?>
															<!--QLHĐV tạo lại YC định giá tài sản thanh lý => END-->
															<!--QLHĐV tạo phiếu thu thanh lý tài sản => START-->
															<?php if ($contract->status == 40) { ?>
															<a class="btn btn-info btn-sm" target="_blank"
															   href="<?php echo base_url("accountant/view_v2?id=") . $contract->_id->{'$oid'} . '#tab_content14';?>">
																Làm thanh toán
															</a>
															<?php } ?>
															<!--QLHĐV tạo phiếu thu thanh lý tài sản => END-->
														<?php endif; ?>
															<?php if ($userSession['is_superadmin'] == 1 || in_array("tbp-thu-hoi-no", $groupRoles)) : ?>
																<!--TPQLHĐV Cập nhật giá tham khảo tài sản thanh lý => START-->
																<?php if (!empty($contract->status) && $contract->status == 46) { ?>
																		<a href="javascript:void(0)"
																		   onclick="tpthn_update_refer('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="btn btn-info btn-sm tp_thn_duyet">
																			TP QLHĐV cập nhật giá tham khảo
																		</a>
																<?php } ?>
																<!--TPQLHĐV Cập nhật giá tham khảo tài sản thanh lý => START-->
																<!--TPQLHĐV duyệt thanh lý thay CEO  => START-->
																<?php if (!empty($contract->status) && $contract->status == 47) { ?>
																		<a href="javascript:void(0)"
																		   onclick="tpthn_approve_rep('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="btn btn-info btn-sm tp_thn_duyet">
																			TP QLHĐV duyệt thanh lý thay CEO
																		</a>
																<?php } ?>
																<!--TPQLHĐV duyệt thanh lý thay CEO  => END-->
																<!--TPQLHĐV bán tài sản thanh lý  => START-->
																<?php if (!empty($contract->status) && $contract->status == 48) { ?>
																		<a href="javascript:void(0)"
																		   onclick="tpthn_sell_asset_liquidation('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="btn btn-info btn-sm tp_thn_duyet">
																			TP QLHĐV bán tài sản thanh lý
																		</a>
																<?php } ?>
																<!--TPQLHĐV bán tài sản thanh lý  => END-->
															<?php endif; ?>
															<!--BPĐG định giá tài sản thanh lý => START-->
															<?php if (in_array('bo-phan-dinh-gia', $groupRoles)) : ?>
																<?php if (!empty($contract->status) && $contract->status == 44) { ?>
																		<a href="javascript:void(0)"
																		   onclick="bp_dinh_gia_xu_ly('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="btn btn-info btn-sm">
																			BP Định giá xử lý
																		</a>
																<?php } ?>
																<?php if (!empty($contract->status) && $contract->status == 49) { ?>
																		<a href="javascript:void(0)"
																		   onclick="bp_dinh_gia_lai('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="btn btn-info btn-sm tp_thn_duyet">
																			BPĐG định giá lại
																		</a>
																<?php } ?>
															<?php endif; ?>
															<!--BPĐG định giá tài sản thanh lý => END-->
														</td>
														<td>
															<a title="Xem chi tiết thanh toán"
															   data-toggle="tooltip"
															   class="link"
															   target="_blank"
															   style="color: #0ba1b5;text-decoration: underline;"
															   href="<?php echo base_url("accountant/view_v2?id=") . $contract->_id->{'$oid'};?>"><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : $contract->code_contract ?>
															</a>
														</td>
														<td>
															<a title="Xem chi tiết hợp đồng"
															   data-toggle="tooltip"
															   class="link"
															   target="_blank"
															   style="color: #0ba1b5;text-decoration: underline;"
															   href="<?php echo base_url("pawn/detail?id=") . $contract->_id->{'$oid'};?>"><?= !empty($contract->code_contract) ? $contract->code_contract : $contract->code_contract ?>
															</a>
														</td>
														<td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></td>
														<td><?= !empty($contract->customer_infor->customer_phone_number) ? hide_phone($contract->customer_infor->customer_phone_number) : "" ?></td>
														<td><?= !empty($contract->liquidation_info->created_at_request) ? date('d/m/Y', intval($contract->liquidation_info->created_at_request)) : " - " ?></td>
														<td><?= !empty($contract->liquidation_info->created_at_liquidations) ? date('d/m/Y', intval($contract->liquidation_info->created_at_liquidations)) : " - " ?></td>
														<td><?= !empty($contract->liquidation_info->bpdg->price_suggest_bpdg) ? number_format($contract->liquidation_info->bpdg->price_suggest_bpdg, 0, '.', '.') : 0 ?></td>
														<td><?= !empty($contract->liquidation_info->thn->price_suggest_thn_send_ceo) ? number_format($contract->liquidation_info->thn->price_suggest_thn_send_ceo, 0, '.', '.') : 0 ?></td>
														<td><?= !empty($contract->liquidation_info->thn->price_refer_ceo) ? number_format($contract->liquidation_info->thn->price_refer_ceo, 0, '.', '.') : 0 ?></td>
														<td><?= !empty($contract->liquidation_info->price_real_sold) ? number_format($contract->liquidation_info->price_real_sold, 0, '.', '.') : 0 ?></td>
														<td><?= !empty($contract->liquidation_info->fee_sold) ? number_format($contract->liquidation_info->fee_sold, 0, '.', '.') : 0 ?></td>
														<td><?= !empty($contract->total_deductible) ? number_format($contract->total_deductible, 0, '.', '.') : 0 ?></td>
														<td><?= !empty($contract->status) ? contract_status($contract->status) : "" ?></td>
														<td><?= !empty($contract->store->name) ? ($contract->store->name) : "" ?></td>
													</tr>
												<?php }
											} ?>
											</tbody>
										</table>
										<div class="">
											<?php echo $pagination ?>
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
</div>

<!--Modal tạo tài sản thanh lý B01-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_create_request_liquidation_asset.php'); ?>

<!--Modal bộ phận định giá tài sản xử lý B02-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_bp_dinh_gia_xu_ly.php'); ?>

<!--Modal BP Định giá xử lý lại  B04-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_bp_dinh_gia_approve_again.php'); ?>

<!--Modal QLHĐV gửi lại định giá tài sản B01a-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_thn_send_to_bpdg_again.php'); ?>

<!--Modal hủy duyệt yêu cầu tạo thanh lý tài sản-->
<div class="modal fade" id="approve_liquidations" tabindex="-1" role="dialog" aria-labelledby=""
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve" style="text-align: center;color: black"></h5>
				<hr>
				<div class="form-group">
					<input type="hidden" class="form-control" id="data_send_approve" value="cancel_approve">
					<label style="color: black; font-weight: unset">Ghi chú</label>
					<textarea class="form-control note" rows="5"></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				<p class="text-right">
					<button class="btn btn-danger cancel_approve_liquidation_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<!--Modal QLHĐV cập nhật thông tin định giá B03-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_tpthn_cap_nhat_gia_ban.php'); ?>

<!--Modal QLHĐV duyệt thay CEO  B03-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_tpthn_approve_instate_ceo.php'); ?>

<!--Modal TP QLHĐV bán tài sản thanh lý  B05-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_thn_sell_asset_liquidation.php'); ?>

<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<script>
	var delta = 0;
	$(document).on('click', '*[data-toggle="lightbox"]', function (event) {
		//$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		return $(this).ekkoLightbox({
			onShow: function (elem) {
				var html = '<button type="button" class="rotate btn btn-link" ><i class="fa fa-repeat"></i></button>';
				console.log(html);
				$(elem.currentTarget).find('.modal-header').prepend(html);
				var delta = 0;
			},
			onNavigate: function (direction, itemIndex) {
				var delta = 0;
				if (window.console) {
					return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
				}
			}
		});
	});
	$('body').on('click', 'button.rotate', function () {
		delta = delta + 90;
		$('.ekko-lightbox-item img').css({
			'-webkit-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'-moz-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)'
		});

	});
</script>
<script>
	$(document).ready(function () {
		$("#confirm_liquidation_event").on("click", function () {
			$("#confirm_liquidation_event").prop("checked", true);
			$("#disagree").prop("checked", false);
		});
		$("#disagree").on("click", function () {
			$("#confirm_liquidation_event").prop("checked", false);
			$("#disagree").prop("checked", true);
		});

	});
	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4","pdf"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 20000000, //10MB,
			multiple: true,
			limit: 10,
			start: function (file) {
				fileType = file.type;
				fileName = file.name;
				//upload started
				this.block = $('<div class="block"></div>');
				this.progressBar = $('<div class="progressBar"></div>');
				this.block.append(this.progressBar);
				$('#' + contain).append(this.block);
			},
			data: {
				'type_img': type,
				'contract_id': contractId
			},
			progress: function (progress) {
				//received progress
				this.progressBar.width(progress + "%");
			},
			success: function (data) {
				//upload successful
				this.progressBar.remove();
				if (data.code == 200) {
					//Video Mp4
					if (fileType == 'video/mp4') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);

					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//pdf
					else if(fileType == 'application/pdf') {
						var item = "";
						item += '<a  href="'+data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt=""><img style="display:none" data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_file"  data-key="'+data.key+'" src="'+data.path+'" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(content);
						this.block.append(data);
					}

				} else {
					//our application returned an error
					var error = data.msg;
					this.block.remove();
					alert(error);
				}
			},
			error: function (error) {

				var msg = error.msg;
				this.block.remove();
				alert("File không đúng định dạng");
			}
		});
	});
	$(document).ready(function() {
		$("#vung_mien").on("change", function() {
			var vung_mien = $("#vung_mien").val();
			var data={"code_area":vung_mien};
			$.ajax({
				type: "POST",
				url :  _url.base_url + '/accountant/getStoreByArea',
				datatype: "JSON",
				data: data,
				success: function(data)
				{
					var results = data["data"];
					$("#store option").remove();
					$('#store').append($('<option>', {value: '', text: '-- Chọn PGD --'}));
					for(var i = 0; i< results.length; i++) {
						$('#store').append($('<option>', {value: results[i]["_id"]['$oid'], text: results[i]['name']}));
					}
				}
			});
		});
	})

</script>
