<!--Modal TPQLHĐV duyệt thay CEO  B03-->
<div id="ApproveInstate" class="modal fade liqui_leb" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color: black; text-align: center">DUYỆT ĐỀ XUẤT GIÁ THANH LÝ TÀI SẢN</h4>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal form-label-left" action="/example"
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">
							<input type="hidden" value="" name="contract_id_liq" class="form-control contract_id_liq">
						</div>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin định giá tham khảo</b></span>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Gốc còn lại &nbsp;&nbsp;
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   name="debt_root_remain_approve"
									   id="debt_root_remain_approve"
									   class="form-control text-danger"
									   value="" disabled>
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
							<div style="padding-top: 8px"><span class="text-danger">VNĐ</span></div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Định giá tham khảo:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   name="price_suggest_bpdg_display_approve"
									   id="price_suggest_bpdg_display_approve"
									   required class="form-control number"
									   value="" disabled>
								<p class="messages"></p>
							</div>
							<div style="padding-top: 8px"><span style="color: black">VNĐ</span></div>

						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Tên cá nhân/đơn vị trả giá:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="name_valuation_display_approve"
									   id="name_valuation_display_approve" disabled>
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Số điện thoại cá nhân/đơn vị trả giá:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="phone_valuation_display_approve"
									   id="phone_valuation_display_approve"
									   minlength="10"
									   maxlength="12" disabled>
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Hình ảnh định giá tài sản <span class="text-danger">* </span>:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_liquidation_bpdg_display_approve">

									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Hình ảnh tài sản đảm bảo <span class="text-danger">* </span>:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_liquidation_thn_create_display_approve">

									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Ghi chú của BP định giá:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea id="note_bpdg_display_approve" class="form-control" rows="5" disabled></textarea>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin cập nhật tài sản thanh lý</b></span>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Giá TPQLHĐV gửi CEO <span class="text-danger">(*)</span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="price_suggest_thn_approve"
									   id="price_suggest_thn_approve" placeholder="Nhập giá trình CEO duyệt">
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Giá CEO duyệt <span class="text-danger">(*)</span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="price_refer_ceo_approve"
									   id="price_refer_ceo_approve" placeholder="Nhập giá CEO đã duyệt">
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" for="first-name">
								Upload hình ảnh <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_img_file_approve">
									</div>
									<label for="upload_img_approve">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="upload_img_approve"
										   type="file"
										   name="file"
										   data-contain="uploads_img_file_approve"
										   data-title="Ảnh tài sản thanh lý"
										   data-type="img_file"
										   class="focus"
										   multiple>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12"><span></span>
								Ghi chú:</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_cancel_liq" id="note_thn_update_approve" name="note_cancel_liq" rows="4"></textarea>
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" id="tpthn_return">Trả lại</button>
					<?php if ($userSession['is_superadmin'] == 1 || in_array($userSession['email'], $role_cancel_liq)) : ?>
					<button type="button" class="btn btn-danger cancel_liquidation">Hủy thanh lý</button>
					<?php endif; ?>
					<button type="button" class="btn btn-info" id="tpthn_approve_rep">Duyệt thay CEO</button>
				</div>
			</div>
		</div>
	</div>
</div>
