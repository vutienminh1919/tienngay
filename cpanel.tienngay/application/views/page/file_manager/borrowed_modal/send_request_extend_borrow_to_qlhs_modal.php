<div class="modal fade" id="send_request_extend_to_qlhs" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title title_giahanthoigianmuon" style="text-align: center" id=""></h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_25">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" class="id_borrow_extend">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Thời gian trả đề xuất:</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<p class="time_extend"></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú đề xuất:</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<p class="note_suggest"></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Thời gian trả</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="" class="form-control" placeholder="dd/mm/yyyy" id="time_extend_input">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Lý do gia hạn mượn</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control note_extend" id=""
										  name="note_extend"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh tình trạng ĐKX hiện tại</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_file_extend_qlhs"></div>
									<label for="upload_input_extend_borrow_qlhs">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="upload_input_extend_borrow_qlhs" type="file" name="file"
										   data-contain="uploads_file_extend_qlhs" data-title="Ảnh gia hạn thời gian mượn" multiple
										   data-type="file_borrow" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="send_req_extend_to_qlhs" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
									aria-label="Close">
								Bỏ qua
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
