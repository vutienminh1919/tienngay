<!-- Modal -->
<div id="addnew_xemay_Modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->

			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">
						TẠO TÀI SẢN: XE MÁY</h4>
				</div>
				<div class="modal-body">


					<div class="row form-horizontal">


						<div class="col-xs-12">
							<p>
							<h4>
								Thông tin chủ tài sản:
							</h4>
							</p>
						</div>
						<input type="hidden" name="type_xm" value="XM">
						<div class="form-group col-xs-12">
							<div class="row">
								<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Họ tên chủ tài
									sản <span class="text-danger">*</span></label>
								<div class="col-md-9 col-sm-8 col-xs-12 error_messages">
									<input type="text" class="form-control" name="name_customer" id="name_customer">
									<p class="messages"></p>
								</div>
							</div>
						</div>
						<div class="form-group col-xs-12">
							<div class="row">
								<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Địa chỉ hộ
									khẩu <span class="text-danger">*</span></label>
								<div class="col-md-9 col-sm-8 col-xs-12 error_messages">
									<input type="text" class="form-control" name="address" id="address">
									<p class="messages"></p>
								</div>
							</div>
						</div>
						<div class="form-group col-xs-12">
							<div class="row">
								<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Tên tài sản <span class="text-danger">*</span></label>
								<div class="col-md-9 col-sm-8 col-xs-12 error_messages">
									<input type="text" class="form-control" name="product" id="product">
									<p class="messages"></p>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<p>
							<h4>
								Thông tin tài sản:
							</h4>
							</p>
							<div class="row flex no-gutter">

								<div class="form-group col-xs-12 col-lg ">
									<label class="control-label text-left">Nhãn hiệu <span class="text-danger">*</span></label>
									<div class="error_messages">
										<input type="text" class="form-control" name="nhan_hieu_xm" id="nhan_hieu_xm">
										<p class="messages"></p>
									</div>
								</div>
								<div class="form-group col-xs-6 col-lg">
									<label class="control-label text-left">Model <span class="text-danger">*</span></label>
									<div class="error_messages">
										<input type="text" class="form-control" name="model_xm" id="model_xm">
										<p class="messages"></p>
									</div>
								</div>
								<div class="form-group col-xs-6 col-lg">
									<label class="control-label text-left">Biển số xe <span class="text-danger">*</span></label>
									<div class="error_messages">
										<input type="text" class="form-control" name="bien_so_xm" id="bien_so_xm">
										<p class="messages"></p>
									</div>
								</div>
								<div class="form-group col-xs-6 col-lg">
									<label class="control-label text-left">Số khung <span class="text-danger">*</span></label>
									<div class="error_messages">
										<input type="text" class="form-control" name="so_khung_xm" id="so_khung_xm">
										<p class="messages"></p>
									</div>
								</div>
								<div class="form-group col-xs-6 col-lg">
									<label class="control-label text-left">Số máy <span class="text-danger">*</span></label>
									<div class="error_messages">
										<input type="text" class="form-control" name="so_may_xm" id="so_may_xm">
										<p class="messages"></p>
									</div>
								</div>
								<div class="form-group col-xs-6 col-lg">
									<label class="control-label text-left">Số đăng ký <span class="text-danger">*</span></label>
									<div class="error_messages">
										<input type="text" class="form-control" name="so_dang_ki_xm" id="so_dang_ki_xm">
										<p class="messages"></p>
									</div>
								</div>
								<div class="form-group col-xs-6 col-lg">
									<label class="control-label text-left">Ngày cấp <span class="text-danger">*</span></label>
									<div class="error_messages">
										<input type="date" class="form-control" name="ngay_cap_xm" id="ngay_cap_xm">
										<p class="messages"></p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<strong>
								Ghi chú:
							</strong>
							<div class="error_messages">
								<textarea class="form-control" name="note_xm" id="note_xm"></textarea>
								<p class="messages"></p>
							</div>

						</div>


						<div class="col-xs-12">
							<small>Lưu ý: Upload tối đa 2GB/Ảnh</small>
							<p>
							<div class="form-group ">
								<label class="control-label">Ảnh tài sản <span
											class="red">*</span></label>
								<div id="SomeThing" class="simpleUploader error_messages">
									<div class="uploads" id="uploads_expertise">
									</div>
									<label for="upload_expertise">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="upload_expertise"
										   type="file" name="file"
										   data-contain="uploads_expertise"
										   data-title="Ảnh moto"
										   multiple data-type="moto" class="focus">
								</div>

							</div>
							</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
					<button type="button" class="btn btn-success" id="create_asset_moto">Lưu</button>
				</div>
			</div>
	</div>
</div>

