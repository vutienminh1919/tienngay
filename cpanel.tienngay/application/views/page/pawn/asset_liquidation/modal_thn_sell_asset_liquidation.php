<!--Modal TP QLHĐV bán tài sản thanh lý  B05-->
<div id="thn_sell_asset" class="modal fade liqui_leb" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center" style="color: black">CẬP NHẬT THÔNG TIN BÁN TÀI SẢN THANH LÝ</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="main_1" class="form-horizontal form-label-left" action="/example"
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">

							<input type="hidden" value="" name="contract_id_liq"
								   class="form-control contract_id_liq">
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin bán tài sản thanh lý</b></span>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số tiền TP.QLHDV gửi duyệt:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="price_thn_send_ceo"
									   id="price_thn_send_ceo" disabled>
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Số tiền CEO duyệt bán:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="price_ceo_approve"
									   id="price_ceo_approve" disabled>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Họ tên người mua <span class="text-danger"> (*) </span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="name_buyer_new"
									   id="name_buyer_new" placeholder="Nhập họ tên người mua">
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Số điện thoại người mua <span class="text-danger"> (*) </span>:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="phone_buyer_new"
									   id="phone_buyer_new" placeholder="Nhập SĐT người mua">
								<p class="messages"></p>
							</div>
						</div>

						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Số tiền thực tế bán được <span class="text-danger"> (*) </span>
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="price_real_sold"
									   id="price_real_sold" placeholder="Nhập số tiền thực bán">
								<p class="messages"></p>
							</div>
							<label class="control-label col-md-3 col-xs-12">
								Ngày bán <span class="text-danger"> (*) </span>
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="date"
									   class="form-control"
									   name="date_sold"
									   id="date_sold" placeholder="Nhập số tiền thực bán">
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Chi phí phụ:
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   class="form-control"
									   name="fee_sold"
									   id="fee_sold" placeholder="Nhập phụ phí (nếu có)">
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Upload hình ảnh <span class="text-danger"> (*) </span>:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_sold_asset">

									</div>
									<label for="upload_img_sold_asset">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="upload_img_sold_asset"
										   type="file"
										   name="file"
										   data-contain="img_sold_asset"
										   data-title="Ảnh tài sản bán được"
										   multiple
										   data-type="img_liqui"
										   class="focus">
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12"><span></span>
								Ghi chú:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea id="note_sold_asset" class="form-control note_cancel_liq" name="note_cancel_liq" rows="5"></textarea>
							</div>
						</div>
						<br>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: bold">Đóng</button>
					<?php if ($userSession['is_superadmin'] == 1 || in_array($userSession['email'], $role_cancel_liq)) : ?>
					<button type="button" class="btn btn-danger cancel_liquidation">Hủy thanh lý</button>
					<?php endif; ?>
					<button type="button" class="btn btn-info" id="thn_update_sold">Xác nhận</button>
				</div>
			</div>
		</div>
	</div>
</div>
