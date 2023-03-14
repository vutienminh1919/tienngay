<div class="modal" tabindex="-1" role="dialog" id="confirm-new-modal">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-status bg-success"></div>
			<div class="modal-body text-center py-4">
				<img src="{{ asset('images/icon-handshake.svg') }}">
				<h3>Xác nhận nhà đầu tư</h3>
				<div class="text-muted">Bạn có chắc chắn muốn xác nhận nhà đầu tư này?</div>
			</div>
			<div class="modal-footer">
				<div class="w-100">
					<div class="row">
						<div class="col">
							<a href="javascript:void(0);" class="btn btn-white w-100" data-bs-dismiss="modal">
								Hủy bỏ
							</a>
						</div>
						<div class="col">
							<a href="javascript:void(0);" id="confirm-btn" class="btn btn-primary w-100">
								Xác nhận
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>