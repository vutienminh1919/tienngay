<div class="modal fade" id="xacnhankhdatattoan" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_xacnhankhdatattoan"></h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_21">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<!--Start Template input document-->
						<?php $this->load->view('page/file_manager/list_input_document.php') ; ?>
						<!--End Template input document-->
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_21"
										  name="ghichu_approve_20"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_21"></div>
									<label for="uploadinput_21">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_21" type="file" name="file"
										   data-contain="uploads_fileReturn_21" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
							<button type="button" id="borrowed_xacnhankhdatattoan" class="btn btn-success">Xác nhận</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
