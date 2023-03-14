<!--Modal tạo tài sản thanh lý B01-->
<div id="createSeizeModal" class="modal fade liqui_leb" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color: black; text-align: center">KHỞI TẠO THANH LÝ TÀI SẢN ĐẢM BẢO</h4>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal form-label-left" action="/example"
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">
							<span style="padding-left: 55px; padding-bottom: 10px"><b style="color: black">Thông tin thu hồi</b></span>
						</div>
						<div class="row">
							<input type="hidden" value="" name="contract_id_liq" class="contract_id_liq"/>
							<input type="hidden" class="form-control" name="data_send_approve" value="send_approve">
							<label class="control-label col-md-2 col-xs-12">
								Ngày thu xe <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages">
								<input type="date"
									   class="form-control"
									   name="date_seize"
									   id="date_seize">
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-2 col-xs-12" style="font-weight: initial; color: black">
								Người thu xe<span class="text-danger"> (*)</span>
							</label>
							<div class="col-md-4 col-xs-12 error_messages checkNameTaiXe1">
								<input type="text"
									   class="form-control"
									   name="name_person_seize"
									   id="name_person_seize"
									   value="" placeholder="Nhập tên người thu xe">
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
								Tên tài sản <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="asset_name"
									   id="asset_name"
									   placeholder="Nhập tên tài sản đảm bảo" disabled>
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12 error_messages">
								<button class=" btn btn-primary fa fa-edit asset_name_event" data-toggle="tooltip" title="Sửa tên tài sản" style="color: yellow"></button>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Nhãn hiệu <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="asset_branch"
									   id="asset_branch"
									   placeholder="Nhập nhãn hiệu tài sản đảm bảo" disabled>
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12 error_messages">
								<button class=" btn btn-primary fa fa-edit asset_branch_event" data-toggle="tooltip" title="Sửa tên nhãn hiệu" style="color: yellow"></button>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Biển số xe <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="license_plates"
									   id="license_plates"
									   placeholder="Nhập biển số xe" disabled>
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12 error_messages">
								<button class=" btn btn-primary fa fa-edit license_plates_event" data-toggle="tooltip" title="Sửa biển số xe" style="color: yellow"></button>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Model <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="asset_model"
									   id="asset_model"
									   placeholder="Nhập model tài sản đảm bảo" disabled>
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12 error_messages">
								<button class=" btn btn-primary fa fa-edit asset_model_event" data-toggle="tooltip" title="Sửa tên model" style="color: yellow"></button>
							</div>

						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số khung <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="frame_number"
									   id="frame_number"
									   placeholder="Nhập số khung" disabled>
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12 error_messages">
								<button class=" btn btn-primary fa fa-edit frame_number_event" data-toggle="tooltip" title="Sửa số khung" style="color: yellow"></button>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Số máy <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="engine_number"
									   id="engine_number"
									   placeholder="Nhập số máy" disabled>
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12 error_messages">
								<button class=" btn btn-primary fa fa-edit engine_number_event" data-toggle="tooltip" title="Sửa số máy" style="color: yellow"></button>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số đăng ký <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control license_number"
									   name="license_number"
									   id="license_number"
									   minlength="5"
									   maxlength="7"
									   placeholder="Nhập số đăng ký xe" disabled>

								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12 error_messages">
								<button class=" btn btn-primary fa fa-edit license_number_event" data-toggle="tooltip" title="Sửa số đăng ký xe" style="color: yellow"></button>
							</div>
							<label class="control-label col-md-2 col-xs-12">
								Số km đã đi <span class="text-danger">(*)</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="number_km"
									   id="number_km"
									   placeholder="Nhập số km đã đi" disabled>
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12 error_messages">
								<button class=" btn btn-primary fa fa-edit number_km_event" data-toggle="tooltip" title="Sửa số km đã đi" style="color: yellow"></button>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Hình ảnh tài sản đảm bảo <span class="text-danger">(*) </span>:
							</label>
							<div class="col-md-10 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_liquidation">

									</div>
									<label for="upload_liquidation">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="upload_liquidation"
										   type="file"
										   name="file"
										   data-contain="img_liquidation"
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
								<textarea class="form-control" name="" id="note_create_liqui" rows="4"></textarea>
							</div>
						</div>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: bold">Đóng</button>
				<button type="button" class="btn btn-info seize_vehicle_btnSave">Xác nhận</button>
			</div>
		</div>
	</div>
</div>
