<!-- Modal -->
<div id="addnew_sodo_Modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">
					TẠO TÀI SẢN: SỔ ĐỎ
				</h3>
			</div>
			<div class="modal-body">

				<div class="row">

					<div class="col-xs-12">

						<h3>
							Thông tin Người sử dụng đất, chủ sở hữu nhà ở và tài sản gắn liền với đất
						</h3>
						<div class="row">
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Họ tên chủ
										tài
										sản <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="ten_khach_hang"
											   id="ten_khach_hang">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Năm
										sinh <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="nam_sinh" id="nam_sinh">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">CMT/CCCD <span
												class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="cmt" id="cmt">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Địa chỉ hộ
										khẩu <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="dia_chi" id="dia_chi">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Người liên
										quan <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="nguoi_lien_quan"
											   id="nguoi_lien_quan">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Năm sinh
										người
										liên quan <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="nam_sinh_nguoi_lien_quan"
											   id="nam_sinh_nguoi_lien_quan">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">CMT/CCCD
										người
										liên quan <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="cmt_nguoi_lien_quan"
											   id="cmt_nguoi_lien_quan">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Địa chỉ hộ
										khẩu
										người liên quan <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="dia_chi_nguoi_lien_quan"
											   id="dia_chi_nguoi_lien_quan">
										<p class="messages"></p>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="col-xs-12">

						<h3>
							Thông tin thửa đất, nhà ở và tài sản khác gắn liền với đất
						</h3>

						<p>
						<h4>Thửa đất <span class="text-danger">(*)</span></h4>
						</p>
						<div class="row">
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Thửa đất
										số <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="thua_dat_so" id="thua_dat_so">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Địa
										chỉ <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="dia_chi_nha_dat"
											   id="dia_chi_nha_dat">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Diện
										tích (m<sup>2</sup>) <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="number" class="form-control" name="dien_tich_nha_dat"
											   id="dien_tich_nha_dat">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Hình thức sử
										dụng <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="hinh_thuc_su_dung"
											   id="hinh_thuc_su_dung">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Mục đích sử
										dụng <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="muc_dich_su_dung"
											   id="muc_dich_su_dung">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Thời hạn sử
										dụng (/năm)<span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="number" class="form-control" name="thoi_han_su_dung_dat"
											   id="thoi_han_su_dung_dat">
										<p class="messages"></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<p>
						<h4>
							Thông tin nhà ở
						</h4>
						</p>
						<div class="row">
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Loại nhà
										ở <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="loai_nha_o" id="loai_nha_o">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Diện tích xây
										dựng (m<sup>2</sup>)<span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="number" class="form-control" name="dien_tich_nha_o"
											   id="dien_tich_nha_o">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Kết
										cấu <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="ket_cau_nha_o"
											   id="ket_cau_nha_o">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Cấp
										(hạng) <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="cap_nha_o" id="cap_nha_o">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Số
										tầng <span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="number" class="form-control" name="so_tang_nha_o"
											   id="so_tang_nha_o">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Thời hạn sở
										hữu (năm)<span class="text-danger">*</span> </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="number" class="form-control" name="thoi_gian_song"
											   id="thoi_gian_song">
										<p class="messages"></p>
									</div>
								</div>
							</div>

						</div>

					</div>
					<div class="col-xs-12 col-md-6">
						<p>
						<h4>
							Thông tin công trình xây dựng khác
						</h4>
						</p>

						<div class="row">
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Hạng mục công
										trình </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="ten_cong_trinh_khac"
											   id="ten_cong_trinh_khac">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Diện tích xây
										dựng (m<sup>2</sup>) </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="number" class="form-control" name="dien_tich_cong_trinh_khac"
											   id="dien_tich_cong_trinh_khac">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Hình thức sở
										hữu </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="hinh_thuc_so_huu"
											   id="hinh_thuc_so_huu">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Cấp công
										trình </label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="text" class="form-control" name="cap_cong_trinh"
											   id="cap_cong_trinh">
										<p class="messages"></p>
									</div>
								</div>
							</div>
							<div class="form-group col-xs-12 error_messages">
								<div class="row">
									<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Thời hạn sở
										hữu (năm)</label>
									<div class="col-md-9 col-sm-8 col-xs-12 ">
										<input type="number" class="form-control" name="thoi_gian_su_huu"
											   id="thoi_gian_su_huu">
										<p class="messages"></p>
									</div>
								</div>
							</div>

						</div>


					</div>


					<div class="col-xs-12">
						<small>Lưu ý: Upload tối đa 2GB/Ảnh</small>
						<p>
						<div class="form-group ">
							<label class="control-label">Ảnh tài sản<span
										class="red">*</span></label>
							<div id="SomeThing" class="simpleUploader error_messages">
								<div class="uploads" id="uploads_expertise2">
								</div>
								<label for="upload_expertise2">
									<div class="btn btn-primary uploader">
										<span>+</span>
									</div>
								</label>
								<input id="upload_expertise2"
									   type="file" name="file"
									   data-contain="uploads_expertise2"
									   data-title="Ảnh nhà đất"
									   multiple data-type="tc" class="focus">
							</div>

						</div>
						</p>
					</div>


				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-success" id="add_new_so_do">Lưu</button>
			</div>
		</div>
	</div>
</div>
