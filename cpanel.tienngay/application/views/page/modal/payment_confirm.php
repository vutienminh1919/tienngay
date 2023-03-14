<div id="billingConfirm" class="modal fade">
    <div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <div class="icon-box danger">
					<i class="fa fa-times"></i>
				</div> -->
                 <div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title"><?= $this->lang->line('Payment_confirmation')?>?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<!-- <p>Thêm giao dịch vào đơn hàng</p> -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal"> <?= $this->lang->line('Cancel')?></button>
        	    <button type="button" class="btn btn-success payment"><?= $this->lang->line('ok')?></button>
			</div>
		</div>
	</div>
</div>