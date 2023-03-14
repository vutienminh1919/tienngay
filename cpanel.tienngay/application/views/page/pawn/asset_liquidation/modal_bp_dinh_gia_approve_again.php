<!--Modal BP Định giá xử lý lại  B04-->
<div id="bpdg_update_modal" class="modal fade liqui_leb" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center" style="color: black">ĐỊNH GIÁ LẠI TÀI SẢN ĐẢM BẢO</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="main_1" class="form-horizontal form-label-left" action="/example"
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">

							<input type="hidden" value="" name="contract_id_liq"
								   class="form-control contract_id_liq">
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								gốc còn lại:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="debt_remain_root_bpdg_update">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin tài sản đảm bảo</b></span>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Ngày thu xe:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="date_seize_bpdg_update">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3">
								Người thu xe:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="name_person_seize_bpdg_update">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số khung:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="frame_number_bpdg_update">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3">
								Số máy:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="engine_number_bpdg_update">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Biển kiểm soát:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="license_plates_bpdg_update">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3">
								Số đăng ký:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="license_number_bpdg_update">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" for="first-name"
							>
								Ảnh tài sản đảm bảo:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_create_liquidation_update">

									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" for="first-name"
							>
								Hình ảnh trả về:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_thn_return">

									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Ghi chú của TL/TP.QLHDV:
							</label>
							<div class="col-md-9 col-xs-12 error_messages" id="note_create_liq_update">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">BP định giá tài sản xử lý</b></span>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Họ tên người trả giá <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="name_valuation_update"
									   id="name_valuation_update" placeholder="Nhập họ tên người trả giá">
								<p class="messages"></p>
							</div>

							<label class="control-label col-md-3 col-xs-12">
								SĐT người trả giá <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="phone_valuation_update"
									   id="phone_valuation_update" placeholder="Nhập SĐT người trả giá">
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Giá đề xuất tham khảo <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="price_suggest_bpdg_update"
									   id="price_suggest_bpdg_update" placeholder="Nhập giá đề xuất tham khảo">
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Hiệu lực tới ngày <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="date"
									   class="form-control"
									   name="date_effect_bpdg_update"
									   id="date_effect_bpdg_update">
								<p class="messages"></p>
							</div>
							<div class="row">
								<label class="control-label col-md-2 col-xs-12">
									Hình ảnh định giá tài sản <span class="text-danger">(*) </span>:
								</label>
								<div class="col-md-9 col-xs-12 error_messages">
									<div id="SomeThing" class="simpleUploader">
										<div class="uploads" id="img_bpdg_update">

										</div>
										<label for="upload_liquidation_bpdg_update">
											<div class="uploader btn btn-primary">
												<span>+</span>
											</div>
										</label>
										<input id="upload_liquidation_bpdg_update"
											   type="file"
											   name="file"
											   data-contain="img_bpdg_update"
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
								<div class="col-md-9 col-xs-12 error_messages">
									<textarea id="note_bpdg_update" class="form-control" rows="5"></textarea>
								</div>
							</div>
							<br>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning return_create_liq">Trả về</button>
					<button type="button" class="btn btn-info" id="bpdg_approve_again">Định giá lại</button>
				</div>
			</div>
		</div>
	</div>
</div>

