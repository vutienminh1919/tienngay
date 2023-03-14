<div class="modal fade" id="update_quantity_records" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_traveyeucautattoan">BỔ SUNG SỐ LƯỢNG HỒ SƠ SAU LƯU KHO</h3>
			</div>
			<div class="theloading" style="display:none">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="id_records">
						<!--Start Template input document-->
						<?php $this->load->view('page/file_manager/list_input_document_update.php') ; ?>
						<!--End Template input document-->
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Mã lưu kho </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" class="form-control" id="code_storage"
									   name="code_storage">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="note_records"
										  name="note_records"></textarea>
							</div>
						</div>
						<div style="text-align: right">
							<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
							<button type="button" id="submit_update_records" class="btn btn-success">Xác nhận</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
