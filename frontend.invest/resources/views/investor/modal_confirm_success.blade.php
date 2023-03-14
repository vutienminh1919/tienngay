<div class="modal" tabindex="-1" role="dialog" id="success-confirm-modal">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-status bg-success"></div>
			<div class="modal-body text-center py-4">
				<img src="{{ asset('images/icon-handshake2.svg') }}">
				<h3>Xác nhận nhà đầu tư</h3>
				<div class="text-muted">Xác nhận trở thành nhà đầu tư thành công</div>
			</div>
			<div class="modal-footer">
				<div class="w-100">
					<div class="row">
						<div class="col text-center">
							<a href="{{ route('investor_new_list') }}" class="btn">
								Đóng
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
