<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang xử lý...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Tạo Qr chuyển khoản bán Sim
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">
								Tạo Qr chuyển khoản bán Sim
							</a>
						</small>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<div class="row flex justify-content-center">
					<div class="col-xs-12 col-md-8">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-cc-paypal"></i> Tạo Qr chuyển khoản bán Sim
							</div>
							<div class="panel panel-default">
								<div class="row">
									<div class="col-sx-12 col-md-6 mb-3">
										<label class="form-label text-bold">Loại giao dịch :<span
													class="text-danger">*</span></label>
										<select class="form-control type_transaction" type="text"
												name="type_transaction">
											<option value="">Chọn loại giao dịch</option>
											<option value="SIMR55">Bộ KIT R55</option>
											<option value="SIMTD">Bộ KIT THÁC ĐỔ</option>
										</select>
									</div>

									<div class="col-sx-12 col-md-6 mb-3">
										<label class="form-label text-bold">Số lượng :<span
													class="text-danger">*</span></label>
										<div class="form-group">
											<input type="number" name="quantity" id="quantity"
												   class="form-control quantity"
												   placeholder="Nhập số lượng">
										</div>
									</div>
									<div class="col-sx-12 col-md-6 mb-3">
										<label class="form-label text-bold">Số tiền
											&nbsp; <span
													class="text-danger">*</span></label>
										<div class="form-group">
											<input type="text" name="amount"
												   class="form-control amount text-danger"
												   value="0" disabled>
										</div>
									</div>
									<div class="col-sx-12 col-md-6 mb-3">
										<label class="form-label text-bold">Phòng giao dịch :<span
													class="text-danger">*</span></label>
										<select class="form-control store" type="text"
												name="store">
											<option value="">Chọn phòng giao dịch</option>
											<?php foreach ($stores as $store) :
												if (in_array($store->_id->{'$oid'}, $storeDataCentral)) continue; ?>
												<option value="<?php echo $store->code_address_store ?>"><?php echo $store->name ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<br>
						</div>
						<div class="x_panel">
							<div class="panel panel-body text-right">
								<a class="btn btn-primary btn-create-qr" id="btn-create-qr">Tạo Qr
								</a>
							</div>
							<div class="x_content">
								<div class="dashboarditem_line2 blue box-image-qr" style="display: none">
									<div class="panel panel-default" style="text-align: center">
										<img src="" class="img_qr" style="width: auto; height: auto">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url() ?>assets/js/qr/index.js"></script>
