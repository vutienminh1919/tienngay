<div class="x_panel setup-content" id="step-3">
	<div class="x_content">
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Tên người tham chiếu 1<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="fullname_relative_1" required class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Mối quan hệ<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<!-- <input type="text" id="type_relative_1" required class="form-control"> -->
				<select class="form-control" id="type_relative_1">
					<option value=""></option>
					<option value="Bố">Bố</option>
					<option value="Mẹ">Mẹ</option>
					<option value="Vợ">Vợ</option>
					<option value="Chồng">Chồng</option>
					<option value="Anh">Anh</option>
					<option value="Chị">Chị</option>
					<option value="Em">Em</option>
					<option value="Chú">Chú</option>
					<option value="Bác">Bác</option>
					<option value="Bạn bè">Bạn bè</option>
					<option value="Đồng nghiệp">Đồng nghiệp</option>
					<option value="Hàng xóm">Hàng xóm</option>
					<option value="Khác">Khác</option>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('Telephone_number_relative') ?><span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="phone_number_relative_1" required class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Bảo mật khoản vay tham chiếu 1 <span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="radio-inline text-primary">
					<label><input type="radio" value="1" name="loan_security_one" checked>Công khai</label>
				</div>
				<div class="radio-inline text-danger">
					<label><input type="radio" value="2" name="loan_security_one">Bảo mật</label>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="checkbox-inline ">
					<label><input name='phone_number_relative_1' value="1" type="checkbox">
						&nbsp;
						Hợp đồng liên quan
					</label>
				</div>

			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('Residential_address') ?><span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="hoursehold_relative_1" required class="form-control">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Phản hồi <span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<!-- <input type="text" id="confirm_relativeInfor1" required class="form-control"> -->
				<textarea type="text" id="confirm_relativeInfor1" required="" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Tên người tham chiếu 2<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="fullname_relative_2" required class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Mối quan hệ<span class="text-danger">*</span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<!-- <input type="text" id="type_relative_2" required class="form-control"> -->
				<select class="form-control" id="type_relative_2">
					<option value=""></option>
					<option value="Bố">Bố</option>
					<option value="Mẹ">Mẹ</option>
					<option value="Vợ">Vợ</option>
					<option value="Chồng">Chồng</option>
					<option value="Anh">Anh</option>
					<option value="Chị">Chị</option>
					<option value="Em">Em</option>
					<option value="Chú">Chú</option>
					<option value="Bác">Bác</option>
					<option value="Bạn bè">Bạn bè</option>
					<option value="Đồng nghiệp">Đồng nghiệp</option>
					<option value="Hàng xóm">Hàng xóm</option>
					<option value="Khác">Khác</option>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('Telephone_number_relative') ?><span class="text-danger">*</span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<input type="text" id="phone_number_relative_2" required class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Bảo mật khoản vay tham chiếu 2 <span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="radio-inline text-primary">
					<label><input type="radio" value="1" name="loan_security_two" id="" checked>Công khai</label>
				</div>
				<div class="radio-inline text-danger">
					<label><input type="radio" value="2" name="loan_security_two" id="">Bảo mật</label>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="checkbox-inline ">
					<label><input name='phone_number_relative_2' value="1" type="checkbox">
						&nbsp;
						Hợp đồng liên quan
					</label>
				</div>

			</div>
		</div>


		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('Residential_address') ?><span class="text-danger">*</span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<input type="text" id="hoursehold_relative_2" required class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Phản hồi <span class="text-danger">*</span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<!-- <input type="text" id="confirm_relativeInfor2" required class="form-control"> -->
				<textarea type="text" id="confirm_relativeInfor2" required="" class="form-control"></textarea>
			</div>
		</div>
		<br>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Tên đơn vị tham chiếu 3
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="fullname_relative_3" required class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Địa chỉ
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="address_relative_3" required class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Số điện thoại
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="phone_relative_3" required class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Bảo mật khoản vay tham chiếu 3
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="radio-inline text-primary">
					<label><input type="radio" value="1" name="loan_security_three">Công khai</label>
				</div>
				<div class="radio-inline text-danger">
					<label><input type="radio" value="2" name="loan_security_three" id="">Bảo mật</label>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Mục đích tham chiếu
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<select class="form-control" id="type_relative_3">
					<option value=""></option>
					<option value="Xác nhận công việc">Xác nhận công việc</option>
					<option value="Xác nhận hợp đồng ủy quyền">Xác nhận hợp đồng ủy quyền</option>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Phản hồi
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<textarea type="text" id="confirm_relativeInfor3" required="" class="form-control"></textarea>
			</div>
		</div>


		<button class="btn btn-primary nextBtnCreate pull-right" data-step="3" type="button">Tiếp tục</button>
		<button class="btn btn-primary  pull-right save_contract" type="button" data-step="3" data-toggle="modal"
				data-target="#saveContract">Lưu lại
		</button>
		<button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
	</div>
	<!--Modal hợp đồng liên quan-->
	<?php $this->load->view('page/pawn/modal/contract_reference_modal.php'); ?>

</div>
