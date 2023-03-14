<div class="modal fade" id="send_borrow_to_qlhs" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title" style="text-align: center">GỬI YÊU CẦU MƯỢN TỚI QUẢN LÝ HỒ SƠ</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" class="id_borrowed">
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Mã hợp đồng</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<p class="code_contract_text" style="font-style: italic; font-weight: bold;"></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú của nhân viên </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<p class="note_nv_qlkv"></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_file_borrow"></div>
									<label for="uploadinput_borrowed_tpkv">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_borrowed_tpkv"
										   type="file"
										   name="file"
										   data-contain="uploads_file_borrow"
										   data-title="Hồ sơ nhân thân" multiple
										   data-type="file_borrow" class="focus">
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text"
										  class="form-control note_qlkv"
										  name="note_qlkv">
								</textarea>
							</div>
						</div>
						<div style="text-align: right">
							<button type="button" id="borrowed_send_to_qlhs" class="btn btn-info">Xác nhận</button>
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
