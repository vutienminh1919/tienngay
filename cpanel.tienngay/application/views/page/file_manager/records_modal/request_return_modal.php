<div id="xacnhanyeucautra" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Xử lý yêu cầu trả hồ sơ sau tất toán</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_5">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body">
				<!--Start Template input document-->
				<?php $this->load->view('page/file_manager/list_input_document.php') ; ?>
				<!--End Template input document-->
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
										<textarea type="text" class="form-control" id="ghichu_5"
												  name="ghichu_5"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn_return_v2"></div>
							<label for="uploadinput_5">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_5" type="file" name="file"
								   data-contain="uploads_fileReturn_return_v2"
								   data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_return_v2">Xác nhận</button>
			</div>
		</div>
	</div>
</div>
