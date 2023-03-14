<!--Modal THN gửi lại YC định giá tài sản B01a-->
<div id="resendEvalution" class="modal fade liqui_leb" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color: black; text-align: center">GỬI LẠI YÊU CẦU ĐỊNH GIÁ THANH LÝ TÀI SẢN ĐẢM BẢO</h4>
			</div>
			<div class="modal-body tran-text-new">
				<form role="form" class="form-horizontal form-label-left" action="/example"
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">
							<span style="padding-left: 55px; padding-bottom: 10px"><b style="color: black">Thông tin thu hồi</b></span>
						</div>
						<div class="row">
							<input type="hidden" class="id_contract_update" value="" name="contract_id_liq"/>
							<label class="control-label col-md-2 col-xs-12">
								Ngày thu xe <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="date"
									   class="form-control"
									   name="date_seize"
									   id="date_seize_update">
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Người thu xe<span class="text-danger"> *</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages checkNameTaiXe1">
								<input type="text"
									   class="form-control"
									   name="name_person_seize"
									   id="name_person_seize_update"
									   value="">
								</input
								<p class="messages"></p>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 55px; padding-bottom: 10px"><b style="color: black">Thông tin tài sản</b></span>
						</div>

						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Tên tài sản <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="asset_name_update"
									   id="asset_name_update"
									   placeholder="Nhập tên tài sản" disabled>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Nhãn hiệu <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="asset_branch_update"
									   id="asset_branch_update"
									   placeholder="Nhập nhãn hiệu xe" disabled>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Biển số xe <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="license_plates_update"
									   id="license_plates_update"
									   placeholder="Nhập biển số xe" disabled>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Model <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="asset_model_update"
									   id="asset_model_update"
									   minlength="5"
									   maxlength="7"
									   placeholder="Nhập mẫu xe" disabled>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số khung <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="frame_number_update"
									   id="frame_number_update"
									   placeholder="Nhập số khung" disabled>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Số máy <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="engine_number_update"
									   id="engine_number_update"
									   placeholder="Nhập số máy" disabled>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số đăng ký <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="license_number_update"
									   id="license_number_update"
									   minlength="5"
									   maxlength="7"
									   placeholder="Nhập số đăng ký xe" disabled>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Số km đã đi <span class="text-danger">*</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="number_km_update"
									   id="number_km_update"
									   placeholder="Nhập số km đã đi" disabled>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Hình ảnh tài sản đảm bảo <span class="text-danger">* </span>:
							</label>
							<div class="col-md-10 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_liquidation_update">

									</div>
									<label for="upload_liquidation_update">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="upload_liquidation_update"
										   type="file"
										   name="file"
										   data-contain="img_liquidation_update"
										   data-title="Ảnh tài sản đảm bảo"
										   multiple
										   data-type="img_liqui"
										   class="focus">
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Ghi chú:
							</label>
							<div class="col-md-10 col-xs-12 error_messages">
								<textarea class="form-control note_cancel_liq" name="note_cancel_liq" id="note_create_liqui_update" rows="4"></textarea>
							</div>
						</div>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: bold">Đóng</button>
				<?php if ($userSession['is_superadmin'] == 1 || in_array($userSession['email'], $role_cancel_liq)) : ?>
				<button type="button" class="btn btn-danger cancel_liquidation">Hủy thanh lý</button>
				<?php endif; ?>
				<button type="button" id="resend_dgts" class="btn btn-info">Gửi lại</button>
			</div>
		</div>
	</div>
</div>
