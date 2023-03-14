<!-- Modal -->
<div id="addnew_oto_Modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					TẠO TÀI SẢN: Ô TÔ</h4>
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
					<input name="type_oto" type="hidden" value="OTO">
					<div class="form-group col-xs-12 error_messages">
						<div class="row">
							<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Họ tên chủ tài
								sản <span class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-8 col-xs-12 ">
								<input type="text" class="form-control" name="customer_name_oto"
									   id="customer_name_oto">
								<p class="messages"></p>
							</div>
						</div>
					</div>
					<div class="form-group col-xs-12 error_messages">
						<div class="row">
							<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Địa chỉ hộ
								khẩu <span class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-8 col-xs-12 ">
								<input type="text" class="form-control" name="address_oto" id="address_oto">
								<p class="messages"></p>
							</div>
						</div>
					</div>
					<div class="form-group col-xs-12 error_messages">
						<div class="row">
							<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Tên tài sản <span
										class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-8 col-xs-12 ">
								<input type="text" class="form-control" name="product_oto" id="product_oto">
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

							<div class="form-group col-xs-12 col-lg error_messages">
								<label class="control-label text-left">Nhãn hiệu <span
											class="text-danger">*</span></label>

								<input type="text" class="form-control" name="nhan_hieu_oto" id="nhan_hieu_oto">
								<p class="messages"></p>
							</div>
							<div class="form-group col-xs-6 col-lg error_messages">
								<label class="control-label text-left">Model <span class="text-danger">*</span></label>

								<input type="text" class="form-control" name="model_oto" id="model_oto">
								<p class="messages"></p>
							</div>
							<div class="form-group col-xs-6 col-lg error_messages">
								<label class="control-label text-left">Biển số xe <span
											class="text-danger">*</span></label>

								<input type="text" class="form-control" name="bien_so_xe_oto" id="bien_so_xe_oto">
								<p class="messages"></p>
							</div>
							<div class="form-group col-xs-6 col-lg error_messages">
								<label class="control-label text-left">Số khung <span
											class="text-danger">*</span></label>

								<input type="text" class="form-control" name="so_khung_oto" id="so_khung_oto">
								<p class="messages"></p>
							</div>
							<div class="form-group col-xs-6 col-lg error_messages">
								<label class="control-label text-left">Số máy <span class="text-danger">*</span></label>

								<input type="text" class="form-control" name="so_may_oto" id="so_may_oto">
								<p class="messages"></p>
							</div>
							<div class="form-group col-xs-6 col-lg error_messages">
								<label class="control-label text-left">Số đăng ký <span
											class="text-danger">*</span></label>

								<input type="text" class="form-control" name="so_dang_ki_oto" id="so_dang_ki_oto">
								<p class="messages"></p>
							</div>
							<div class="form-group col-xs-6 col-lg error_messages">
								<label class="control-label text-left">Ngày cấp <span
											class="text-danger">*</span></label>

								<input type="date" class="form-control" name="ngay_cap_oto" id="ngay_cap_oto">
								<p class="messages"></p>
							</div>

						</div>

					</div>

					<div class="col-xs-12 error_messages">
						<strong>
							Ghi chú
						</strong>
						<textarea class="form-control" name="note_oto" id="note_oto"></textarea>
						<p class="messages"></p>
					</div>


					<div class="col-xs-12">
						<small>Lưu ý: Upload tối đa 2GB/Ảnh</small>
						<p>
						<div class="form-group ">
							<label class="control-label">Ảnh tài sản <span
										class="red">*</span></label>
							<div id="SomeThing" class="simpleUploader error_messages">
								<div class="uploads" id="uploads_expertise1">
								</div>
								<label for="upload_expertise1">
									<div class="btn btn-primary uploader">
										<span>+</span>
									</div>
								</label>
								<input id="upload_expertise1"
									   type="file" name="file"
									   data-contain="uploads_expertise1"
									   data-title="Ảnh oto"
									   multiple data-type="oto" class="focus">
							</div>

						</div>
						</p>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-success" id="create_asset_oto">Lưu</button>
			</div>
		</div>
	</div>
</div>
<script>
	function addOTO() {
		$("#main_1").trigger("reset");
		// $('.block').css("display", "none");
	}
</script>
