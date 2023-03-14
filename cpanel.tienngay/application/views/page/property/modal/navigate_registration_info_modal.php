<div class="modal fade" id="navigate_registration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="theloading" style="display:none">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Tùy chọn xác nhận Blacklist đăng ký/Cavet xe</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="col-xs-12 col-md-4">
							<button id="fill_auto_info" class="btn btn-success">
								<i class="fa fa-spinner"></i>
								<span class="text_title_bbbg_ky">Điền tự động thông tin</span>
							</button>
						</div>
						<div class="col-xs-12 col-md-3">
							<button id="edit_registration_info" class="btn btn-info">
								<i class="fa fa-edit"></i>
								<span class="text_title_bbbg_thanhly"> Sửa thông tin ĐKX/Cavet</span>
							</button>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="confirm_blacklist" class="btn btn-dark">
					<i class="fa fa-save"></i>
					<span class="text_title_ghcc"> Xác nhận</span>
				</button>
			</div>
		</div>
	</div>
</div>
