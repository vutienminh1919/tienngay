<div id="lead_thn_approve" class="modal fade" role="dialog">
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
				<form role="form" id="main_1" class="form-horizontal form-label-left" action=""
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">
							<input type="hidden" value="" name="id_exemption_contract"
								   class="form-control id_exemption_contract">
							<input type="hidden" value="" name="id_contract"
								   class="form-control id_contract">
							<input type="hidden" class="form-control" name="code_contract">
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
							<div class="col-md-9 col-xs-12 error_messages" id="number_code_contract">
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
								<div id="amount_customer_suggest1">
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
								 id="date_suggest_exemption">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3"
								   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 40px;">
								Loại miễn giảm:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="type_suggest_exemption">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3"
								   style="color: black;
								   font-weight: unset;
								   text-align: left;
								   padding-left: 140px;">
								Ngày khách ký đơn:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="date_customer_sign1">
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
							<div class="col-md-3 col-xs-12 error_messages" id="confirm_email">
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
							<div class="col-md-3 col-xs-12 error_messages" id="is_exemption_paper">
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
								Số ngày quá hạn:
							</label>
							<div class="col-md-3 col-xs-12 number_date_late error_messages">
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
									<div class="uploads" id="image_exemption_profile">

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
							<div class="col-md-9 col-xs-12 error_messages" id="note_suggest_exemptions">
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
							<div class="col-md-9 col-xs-12 error_messages" id="note_lead_append">
								<textarea class="form-control note_lead_thn"
										  rows="2"
										  placeholder="Lead QLHĐV nhập ghi chú">
								</textarea>
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="lead_return">Trả về</button>
				<button type="button" class="btn btn-secondary " id="lead_cancel">Không chấp nhận
				</button>
				<button type="button" class="btn btn-info " id="lead_confirm">Duyệt</button>
			</div>
		</div>
	</div>
</div>
