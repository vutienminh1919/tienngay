<!--Modal THN cập nhật thông tin định giá B03-->
<div id="UpdateEvaluation" class="modal fade liqui_leb" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color: black; text-align: center">CẬP NHẬT GIÁ BÁN TÀI SẢN ĐẢM BẢO (THAM KHẢO)</h4>
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
								<div id="debt_root_remain">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>

						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Định giá tham khảo:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="price_suggest_bpdg_display">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Hiệu lực tới ngày:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="date_effect_bpdg_display">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Họ tên người trả giá:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="name_valuation_display">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Số điện thoại người trả giá:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="phone_valuation_display">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Hình ảnh định giá tài sản <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_liquidation_bpdg_display">

									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Hình ảnh tài sản đảm bảo <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_liquidation_thn_create_display">

									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Ghi chú của BP định giá:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea id="note_bpdg_display" class="form-control" rows="5" disabled></textarea>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin cập nhật tài sản thanh lý</b></span>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Giá thanh lý tham khảo <span class="text-danger">(*)</span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="price_suggest_thn"
									   id="price_suggest_thn" placeholder="Nhập giá tham khảo">
								<p class="messages"></p>
							</div>
							<div style="padding-top: 8px"><span class="text-danger">VNĐ</span></div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" for="first-name">
								Upload hình ảnh
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_img_file_send">
									</div>
									<label for="uploadinput_liquidations">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_liquidations"
										   type="file"
										   name="file"
										   data-contain="uploads_img_file_send"
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
								<textarea class="form-control note_cancel_liq" id="note_thn_update" name="note_cancel_liq" rows="4"></textarea>
								<input type="hidden" class="form-control contract_id">
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: bold">Đóng</button>
					<?php if ($userSession['is_superadmin'] == 1 || in_array($userSession['email'], $role_cancel_liq)) : ?>
					<button type="button" class="btn btn-danger cancel_liquidation" >Hủy thanh lý</button>
					<?php endif; ?>
					<button type="button" class="btn btn-info" id="tpthn_update">Cập nhật</button>
				</div>
			</div>
		</div>
	</div>
</div>
