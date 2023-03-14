<!--Modal bộ phận định giá tài sản xử lý B02-->
<div id="bpdg_processing_modal" class="modal fade liqui_leb" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center" style="color: black">ĐỊNH GIÁ TÀI SẢN ĐẢM BẢO</h4>
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
								Gốc còn lại:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="debt_remain_root_bpdg">
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
								<div id="date_seize_bpdg">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Người thu xe:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="name_person_seize_bpdg">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Tên tài sản:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="asset_name_bpdg">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Nhãn hiệu:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="asset_branch_bpdg">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Biển số xe:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="license_plates_bpdg">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Model:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="asset_model_bpdg">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số khung:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="frame_number_bpdg">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Số máy:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="engine_number_bpdg">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số đăng ký:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="license_number_bpdg">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Số km đã đi:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="number_km_bpdg">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" for="first-name">
								Ảnh tài sản đảm bảo:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_create_liquidation">

									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12"><span></span>
								Ghi chú của TL/TP.QLHDV:</label>
							<div class="col-md-9 col-xs-12 error_messages note_cancel_liq" id="note_create_liq">
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
									   name="name_valuation"
									   id="name_valuation" placeholder="Nhập họ tên người trả giá">
								<p class="messages"></p>
							</div>

							<label class="control-label col-md-3 col-xs-12">
								Số điện thoại người trả giá <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="phone_valuation"
									   id="phone_valuation" placeholder="Nhập SĐT người trả giá">
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
									   name="price_suggest_bpdg"
									   id="price_suggest_bpdg" placeholder="Nhập giá đề xuất tham khảo">
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Hiệu lực tới ngày <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="date"
									   class="form-control"
									   name="date_effect_bpdg"
									   id="date_effect_bpdg">
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Hình ảnh định giá tài sản <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_liquidation_bpdg">

									</div>
									<label for="upload_liquidation_bpdg">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="upload_liquidation_bpdg"
										   type="file"
										   name="file"
										   data-contain="img_liquidation_bpdg"
										   data-title="Ảnh tài sản đảm bảo"
										   multiple
										   data-type="img_liqui"
										   class="focus">
								</div>
							</div>
						</div>

						<div class="row">
							<label class="control-label col-md-2 col-xs-12"><span></span>
								Ghi chú:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea id="note_bpdg" class="form-control" rows="5"></textarea>
							</div>
						</div>
						<br>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning return_create_liq" id="">Trả về</button>
					<button type="button" class="btn btn-info" id="bpdg_approve">Gửi định giá</button>
				</div>
			</div>
		</div>
	</div>
</div>
