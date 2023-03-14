<div>&nbsp;</div>


	<div class="col-xs-12 form-horizontal form-label-left input_mask">
		<div class="row">
			<input type="hidden"
				   class="form-control input-sm"
				   name="code_contract"
				   value="<?= !empty($contractDB->code_contract) ? $contractDB->code_contract : '' ?>">
			<input type="hidden"
				   class="form-control contract_id"
				   name="contract_id"
				   value="<?= !empty($contractDB->_id->{'$oid'}) ? $contractDB->_id->{'$oid'} : ''; ?>">
			<input type="hidden"
				   class="form-control status_exemptions"
				   name="status_exemptions"
				   value="1">
			<input type="hidden"
				   class="form-control input-sm"
				   name="store_id"
				   value="<?= !empty($contractDB->store->id) ? $contractDB->store->id : '' ?>">
			<input type="hidden"
				   class="form-control input-sm"
				   name="store_name"
				   value="<?= !empty($contractDB->store->name) ? $contractDB->store->name : '' ?>">
			<input type="hidden"
				   class="form-control input-sm"
				   name="store_address"
				   value="<?= !empty($contractDB->store->address) ? $contractDB->store->address : '' ?>">

		</div>
		<br>
		<div class="row">
			<span style="padding-bottom: 10px"><b style="color: black">THÔNG TIN MIỄN GIẢM</b></span>
		</div>
		<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Hợp đồng đề nghị &nbsp;&nbsp;
			</label>
			<div class="col-md-5 col-xs-12 error_messages" style="padding-top: 8px">
				<span style="color: black"><?php echo $contractDB->code_contract_disbursement ?></span>
			</div>
		</div>
		<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Loại miễn giảm &nbsp;&nbsp;
			</label>
			<div class="col-md-2 col-xs-12 " >
				  <input class="form-check-input" type="radio" name="type_payment_exem" value="1" checked>
				  <label class="form-check-label" >Thanh toán</label>
            </div>
            
           <div class="col-md-2 col-xs-12 " >
            <input class="form-check-input" type="radio" name="type_payment_exem" value="2" >
            <label class="form-check-label" >Tất toán</label>
			</div>
		</div>
		<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Xác nhận của CEO qua email &nbsp;&nbsp;
			</label>
			<div class="col-md-2 col-xs-12 " >
				  <input class="form-check-input" type="radio" name="confirm_email" value="1" checked>
				  <label class="form-check-label" >Có</label>
            </div>
		</div>
		<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Đơn miễn giảm (bản giấy) &nbsp;&nbsp;
			</label>
			<div class="col-md-2 col-xs-12 " >
				  <input class="form-check-input" type="radio" name="is_exemption_paper" value="1" checked>
				  <label class="form-check-label" >Có</label>
            </div>

           <div class="col-md-2 col-xs-12 " >
            <input class="form-check-input" type="radio" name="is_exemption_paper" value="2" >
            <label class="form-check-label text-danger" >Không có</label>
			</div>
		</div>
		<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Số tiền KH đề nghị miễn giảm<span class="text-danger"> * </span>
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<input type="text"
					   name="amount_customer_suggest"
					   id="amount_customer_suggest"
					   required class="form-control number"
					   value="" placeholder="Nhập số tiền miễn giảm">
				<p class="messages"></p>
			</div>
			<div class="col-md-1 col-xs-12">
				<label for="" class="control-label">&nbsp;</label>
				<span class="text-danger">VNĐ</span>
			</div>
			<div class="col-md-2 col-xs-12"></div>
			<label class="control-label col-md-1 col-xs-12 text-left" style="font-weight: lighter; color: black">
				Ngày đề nghị<span class="text-danger"> * </span>
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<input type="date"
					   class="form-control"
					   name="date_suggest"
					   id="date_suggest">
				<p class="messages"></p>
			</div>
		</div>
		<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Số ngày quá hạn<span class="text-danger"> * </span>
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<input type="number"
					   name="number_date_late"
					   id="number_date_late"
					   required class="form-control number"
					   value="" placeholder="Nhập số ngày quá hạn">
				<p class="messages"></p>
			</div>
			<div class="col-md-1 col-xs-12">
				<label for="" class="control-label">&nbsp;</label>
				<span class="text-danger">Ngày</span>
			</div>
			<div class="col-md-1 col-xs-12"></div>
			<label class="control-label col-md-2 col-xs-12 text-left" style="font-weight: lighter; color: black">
				Ngày khách hàng ký đơn miễn giảm<span class="text-danger"> * </span>
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<input type="date"
					   class="form-control"
					   name="date_customer_sign"
					   id="date_customer_sign">
				<p class="messages"></p>
			</div>
		</div>
		<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" for=""
				   style="color: black; font-weight: unset">
				Upload hình ảnh<span class="text-danger"> * </span>
			</label>
			<div class="col-md-10 col-xs-12 error_messages">
				<div id="SomeThing" class="simpleUploader error_messages">
					<div class="uploads" id="image_create_exemption">
					</div>
					<label for="upload_exemption">
						<div class="uploader btn btn-primary">
							<span>+</span>
						</div>
					</label>
					<input id="upload_exemption"
						   type="file"
						   name="file"
						   data-contain="image_create_exemption"
						   data-title="Ảnh hồ sơ miễn giảm"
						   multiple
						   data-type="create_img_ex"
						   class="focus">
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left"
				   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
				Ghi chú/Note &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<div class="col-md-10 col-xs-12 error_messages">
				<textarea class="form-control note_suggest_exemptions" rows="3" placeholder="Nhập lưu ý"></textarea>
				<input type="hidden" class="form-control">
				<p class="messages"></p>
				<span style="font-size: 15px;"><i>- Chọn <b>"Ngày đề nghị"</b> làm đơn miễn giảm hợp lệ: <br>
						+ <b>Loại thanh toán:</b> chọn từ <b>"Ngày đến hạn"</b> của kỳ <b>còn phải trả</b> gần ngày giải ngân nhất, đến hết kỳ còn phải trả đó;<br>
						+ <b>Loại tất toán:</b> chọn tự do.<br>

					</i></span>

			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12 col-xs-12 text-right">
				<button id="cancel_create" class="btn btn-secondary">Hủy</button>
				<button id="send_exemptions" class="btn btn-info">Gửi yêu cầu</button>
			</div>
		</div>
	</div>









