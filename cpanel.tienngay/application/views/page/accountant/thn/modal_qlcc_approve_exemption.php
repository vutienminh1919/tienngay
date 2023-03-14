<div id="qlcc_approve" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color: black">XỬ LÝ ĐƠN MIỄN GIẢM</h4>
			</div>
			<div class="modal-body">
				<div class="col-xs-12 form-horizontal form-label-left input_mask">
					<div class="row">
						<input type="hidden" value="" name="id_exemption_contract_modal_qlcc"
							   class="form-control id_exemption_contract_modal_qlcc">
						<input type="hidden" value="" name="id_contract_modal_qlcc"
							   class="form-control id_contract_modal_tp">
						<input type="hidden" class="form-control" name="code_contract_modal_qlcc">
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
						<div class="col-md-9 col-xs-12" id="number_code_contract_modal_qlcc">
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
							<div id="amount_customer_suggest_modal_qlcc">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<label class="control-label col-md-3"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 140px;">
							Ngày đề nghị:
						</label>
						<div class="col-md-3 col-xs-12"
							 id="date_suggest_exemption_modal_qlcc">
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
								<div class="uploads" id="image_exemption_profile_modal_qlcc">

								</div>
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
						<div class="col-md-9 col-xs-12 error_messages" id="note_suggest_exemptions_modal_qlcc">
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
							Ghi chú/Note của Lead THN:
						</label>
						<div class="col-md-9 col-xs-12 error_messages" id="note_lead_append_modal_qlcc">
								<textarea class="form-control note_lead_append_modal_qlcc"
										  rows="2"
										  placeholder="Lead THN nhập ghi chú">
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
						<div class="col-md-3 col-xs-12">
							<div id="amount_tp_suggest">
								<span class="help-block"></span>
								<p class="messages"></p>
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
							Lý do duyệt:
						</label>
						<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_tp_thn_modal_qlcc"
										  rows="2" id="note_tp_thn_modal_tp" name="note_tp_thn_modal_qlcc"
										  placeholder="TP THN nhập ghi chú">
								</textarea>
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>
					<div style="padding-top: 33px"></div>
					<br>
					<div class="row">
							<span style="padding-bottom: 10px"><b
									style="color: black">THÔNG TIN XỬ LÝ CỦA QUẢN LÝ CẤP CAO</b></span>
					</div>
					<div class="row">
						<label class="control-label col-md-3 col-xs-12"
							   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
							Lý do duyệt:
						</label>
						<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_qlcc"
										  rows="2" id="note_qlcc" name="note_qlcc"
										  placeholder="Quản lý cấp cao nhập ghi chú">
								</textarea>
							<span class="help-block"></span>
							<p class="messages"></p>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" id="qlcc_cancel">Không chấp nhận</button>
						<button type="button" class="btn btn-info" id="qlcc_confirm">Duyệt</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
