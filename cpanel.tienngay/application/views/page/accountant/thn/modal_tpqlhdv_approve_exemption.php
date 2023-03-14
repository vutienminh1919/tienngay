<div id="tp_thn_approve" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<div class="theloading" style="display:none">
					<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
					<span>Đang Xử Lý...</span>
				</div>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color: black">XỬ LÝ ĐƠN MIỄN GIẢM</h4>
			</div>
			<div class="modal-body">
				<div class="col-xs-12 form-horizontal form-label-left input_mask">
					<div class="row">
						<input type="hidden" value="" name="id_exemption_contract_modal_tp"
							   class="form-control id_exemption_contract_modal_tp">
						<input type="hidden" value="" name="id_contract_modal_tp"
							   class="form-control id_contract_modal_tp">
						<input type="hidden" class="form-control" name="code_contract_modal_tp">
						<input type="hidden" class="form-control data_send_approve" value="send_tp">
					</div>
					<br>
					<div class="row">
						<span style="padding-bottom: 10px"><b style="color: black">THÔNG TIN MIỄN GIẢM</b></span>
					</div>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Hợp đồng đề nghị:
						</label>
						<div class="col-md-3 col-xs-12" id="number_code_contract_modal_tp">
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
						<label class="control-label col-md-3"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 140px;">
							Ngày đề nghị:
						</label>
						<div class="col-md-3 col-xs-12"
							 id="date_suggest_exemption_modal_tp">
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Số tiền KH đề nghị miễn giảm:
						</label>
						<div class="col-md-3 col-xs-12 error_messages">
							<div id="amount_customer_suggest_modal_tp">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<label class="control-label col-md-3"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 140px;">
							Ngày khách ký đơn:
						</label>
						<div class="col-md-3 col-xs-12"
							 id="date_customer_sign_modal_tp">
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>
					<div class="row">
						<label class="control-label col-md-3"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Loại miễn giảm:
						</label>
						<div class="col-md-3 col-xs-12"
							 id="type_suggest_exemption_modal_tp">
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
						<label class="control-label col-md-3"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 140px;">
							Số ngày quá hạn:
						</label>
						<div class="col-md-3 col-xs-12 number_date_late">
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Email CEO xác nhận:
						</label>
						<div class="col-md-3 col-xs-12 error_messages" id="confirm_email_tp">
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 140px;">
							Đơn miễn giảm (bản giấy):
						</label>
						<div class="col-md-3 col-xs-12 error_messages" id="is_exemption_paper_tp">
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>
					<br>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12" for="first-name"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Hình ảnh hồ sơ miễn giảm:
						</label>
						<div class="col-md-9 col-xs-12 error_messages">
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="image_exemption_profile_modal_tp">

								</div>
								<label for="upload_exemption">
									<div class="uploader btn btn-primary">
										<span>+</span>
									</div>
								</label>
								<input id="upload_exemption"
									   type="file"
									   name="file"
									   data-contain="image_exemption_profile_modal_tp"
									   data-title="Ảnh hồ sơ miễn giảm"
									   multiple
									   data-type="create_img_ex"
									   class="focus">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Ghi chú/Note của đơn miễn giảm:
						</label>
						<div class="col-md-9 col-xs-12 error_messages" id="note_suggest_exemptions_modal_tp">
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>
					<div style="padding-top: 33px"></div>
					<br>
					<div class="row">
							<span style="padding-bottom: 10px"><b
									style="color: black">THÔNG TIN XỬ LÝ CỦA TRƯỞNG NHÓM</b></span>
					</div>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Ghi chú/Note của Lead QLHĐV:
						</label>
						<div class="col-md-9 col-xs-12 error_messages" id="note_lead_append_modal_tp">
								<textarea class="form-control note_lead_append_modal_tp"
										  rows="2"
										  placeholder="Lead QLHĐV nhập ghi chú">
								</textarea>
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>
					<div style="padding-top: 33px"></div>
					<br>
					<div class="row">
							<span style="padding-bottom: 10px"><b
									style="color: black">THÔNG TIN XỬ LÝ TỪ TP QUẢN LÝ HĐ VAY</b></span>
					</div>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Số tiền đề xuất duyệt:
						</label>
						<div class="col-md-3 col-xs-12 error_messages">
							<div id="hide_amount_tp">
								<input type="text"
									   name="amount_tp_thn_suggest_modal_tp"
									   id="amount_tp_thn_suggest_modal_tp"
									   required class="form-control number"
									   value="" placeholder="Từ 200.000đ">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<br>
						<div class="col-md-1 col-xs-12" id="hide_dvt">
							<label for="" class="control-label">&nbsp;</label>
							<span class="text-danger">đồng</span>
						</div>
					</div>
					<br>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Lý do duyệt:
						</label>
						<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_tp_thn_modal_tp"
										  rows="2" id="note_tp_thn_modal_tp" name="note_tp_thn_modal_tp"
										  placeholder="TP QLHĐV nhập ghi chú">
								</textarea>
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>

					<div class="alert alert-danger text-center" style="display:none"></div>

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" id="tp_cancel">Hủy</button>
						<button type="button" class="btn btn-warning" id="tp_return">Trả về</button>
						<button type="button" class="btn btn-info" id="tp_confirm">Duyệt</button>
						<button type="button" class="btn btn-success" id="tp_send_up">Gửi lên cấp cao hơn
						</button>
					</div>

					<div class="modal-footer" style="color: black">
						<div id="data_send_high">
							<div class="row">
								<div class="col-md-9 col-xs-12">
								</div>
								<div class="col-sm-3 col-xs-12 text-left" style="text-indent: 20px">
									<p><b>Chọn tài khoản gửi lên: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> <span> <u
												id="send_cc" data-toggle="collapse"
												data-target="#show-hide-email-cc">Cc</u></span>
									</p>
								</div>
							</div>
							<form>
								<?php if (!empty($groupRolesHighManager)) {
									foreach ($groupRolesHighManager as $key => $user) { ?>
										<div class="row">
											<div class="col-md-9 col-xs-12">
											</div>
											<div class="col-sm-3 col-xs-12">
												<div class="checkbox text-left">
													<label class="send-hight checkcontainer">
														<input type="radio" name="user_receive_approve"
															   class="checkbox_email_high"
															   value="<?= $key ? $key : '' ?>"><?= $user->email ? $user->email : '' ?>
														<span class="radiobtn"></span>
													</label>
												</div>
											</div>
										</div>
									<?php }
								} ?>
							</form>
						</div>
						<br>
						<div id="show-hide-email-cc" class="collapse">
							<div class="row">
								<div class="col-md-9 col-xs-12">
								</div>
								<div class="col-md-3 col-xs-12 text-left" style="text-indent: 20px">
									<p class=""><b>Chọn tài khoản Cc:</b></p>
								</div>
							</div>
							<form>
								<?php if (!empty($groupRolesReceiveEmail)) {
									foreach ($groupRolesReceiveEmail as $key => $user) { ?>
										<div class="row">
											<div class="col-md-9 col-xs-12">
											</div>
											<div class="col-md-3 col-xs-12">
												<div class="checkbox text-left">
													<label class="send-cc">
														<input type="checkbox" name="user_receive_cc[]"
															   class="checkbox_email_cc"
															   value="<?= $key ? $key : '' ?>"><?= $user->email ? $user->email : '' ?>
													</label>
												</div>
											</div>
										</div>
									<?php }
								} ?>
								<div class="row">
									<div class="col-md-10 col-xs-12">
									</div>
									<div class="col-md-2 col-xs-12">
										<button type="button" class="btn btn-success" id="confirm_send">Gửi
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

