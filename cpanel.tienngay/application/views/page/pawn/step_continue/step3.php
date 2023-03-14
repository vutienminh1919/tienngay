
        <div class="x_panel setup-content" id="step-3">
          <div class="x_content">
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Tên người tham chiếu 1<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="fullname_relative_1" value="<?= $contractInfor->relative_infor->fullname_relative_1 ? $contractInfor->relative_infor->fullname_relative_1 : "" ?>" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Mối quan hệ<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="text" id="type_relative_1" value="<?= $contractInfor->relative_infor->type_relative_1 ? $contractInfor->relative_infor->type_relative_1 : "" ?>" required class="form-control"> -->
              <select class="form-control" id="type_relative_1">
                    <option value=""></option>
                    <option value="Bố" <?php if($contractInfor->relative_infor->type_relative_1 == "Bố") echo "selected"?>>Bố</option>
                    <option value="Mẹ" <?php if($contractInfor->relative_infor->type_relative_1 == "Mẹ") echo "selected"?>>Mẹ</option>
                    <option value="Vợ" <?php if($contractInfor->relative_infor->type_relative_1 == "Vợ") echo "selected"?>>Vợ</option>
                    <option value="Chồng" <?php if($contractInfor->relative_infor->type_relative_1 == "Chồng") echo "selected"?>>Chồng</option>
                    <option value="Anh" <?php if($contractInfor->relative_infor->type_relative_1 == "Anh") echo "selected"?>>Anh</option>
                    <option value="Chị" <?php if($contractInfor->relative_infor->type_relative_1 == "Chị") echo "selected"?>>Chị</option>
                    <option value="Em" <?php if($contractInfor->relative_infor->type_relative_1 == "Em") echo "selected"?>>Em</option>
                    <option value="Chú" <?php if($contractInfor->relative_infor->type_relative_1 == "Chú") echo "selected"?>>Chú</option>
                    <option value="Bác" <?php if($contractInfor->relative_infor->type_relative_1 == "Bác") echo "selected"?>>Bác</option>
                    <option value="Bạn bè" <?php if($contractInfor->relative_infor->type_relative_1 == "Bạn bè") echo "selected"?>>Bạn bè</option>
                    <option value="Đồng nghiệp" <?php if($contractInfor->relative_infor->type_relative_1 == "Đồng nghiệp") echo "selected"?>>Đồng nghiệp</option>
                    <option value="Hàng xóm" <?php if($contractInfor->relative_infor->type_relative_1 == "Hàng xóm") echo "selected"?>>Hàng xóm</option>
                    <option value="Khác" <?php if($contractInfor->relative_infor->type_relative_1 == "Khác") echo "selected"?>>Khác</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Telephone_number_relative')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="phone_number_relative_1" value="<?= $contractInfor->relative_infor->phone_number_relative_1 ? $contractInfor->relative_infor->phone_number_relative_1 : "" ?>" required class="form-control">
              </div>
            </div>
			  <div class="form-group row">
				  <label class="control-label col-md-3 col-sm-3 col-xs-12">
					  Bảo mật khoản vay tham chiếu 1 <span class="text-danger">*</span>
				  </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					  <div class="radio-inline text-primary">
						  <label><input type="radio" value="1" name="loan_security_one" <?= (!empty($contractInfor->relative_infor->loan_security_1) && $contractInfor->relative_infor->loan_security_1 == 1) ? 'checked' : '' ?> >Công khai</label>
					  </div>
					  <div class="radio-inline text-danger">
						  <label><input type="radio" value="2" name="loan_security_one" <?= (!empty($contractInfor->relative_infor->loan_security_1) && $contractInfor->relative_infor->loan_security_1 == 2) ? 'checked' : '' ?>>Bảo mật</label>
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
              <?= $this->lang->line('Residential_address')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="hoursehold_relative_1" value="<?= $contractInfor->relative_infor->hoursehold_relative_1 ? $contractInfor->relative_infor->hoursehold_relative_1 : "" ?>" required class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Phản hồi <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="text" id="confirm_relativeInfor1" value="<?= $contractInfor->relative_infor->confirm_relativeInfor_1 ? $contractInfor->relative_infor->confirm_relativeInfor_1 : "" ?>" required class="form-control"> -->
              <textarea type="text" id="confirm_relativeInfor1" required="" class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_1) ? $contractInfor->relative_infor->confirm_relativeInfor_1 : "" ?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Tên người tham chiếu 2<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="fullname_relative_2" value="<?= $contractInfor->relative_infor->fullname_relative_2 ? $contractInfor->relative_infor->fullname_relative_2 : "" ?>" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Mối quan hệ<span class="text-danger">*</span>
              </label>
              <div class="col-lg-6 col-sm-12 col-12">
              <!-- <input type="text" id="type_relative_2" value="<?= $contractInfor->relative_infor->type_relative_2 ? $contractInfor->relative_infor->type_relative_2 : "" ?>" required class="form-control"> -->
              <select class="form-control" id="type_relative_2">
                    <option value=""></option>
                    <option value="Bố" <?php if($contractInfor->relative_infor->type_relative_2 == "Bố") echo "selected"?>>Bố</option>
                    <option value="Mẹ" <?php if($contractInfor->relative_infor->type_relative_2 == "Mẹ") echo "selected"?>>Mẹ</option>
                    <option value="Vợ" <?php if($contractInfor->relative_infor->type_relative_2 == "Vợ") echo "selected"?>>Vợ</option>
                    <option value="Chồng" <?php if($contractInfor->relative_infor->type_relative_2 == "Chồng") echo "selected"?>>Chồng</option>
                    <option value="Anh" <?php if($contractInfor->relative_infor->type_relative_2 == "Anh") echo "selected"?>>Anh</option>
                    <option value="Chị" <?php if($contractInfor->relative_infor->type_relative_2 == "Chị") echo "selected"?>>Chị</option>
                    <option value="Em" <?php if($contractInfor->relative_infor->type_relative_2 == "Em") echo "selected"?>>Em</option>
                    <option value="Chú" <?php if($contractInfor->relative_infor->type_relative_2 == "Chú") echo "selected"?>>Chú</option>
                    <option value="Bác" <?php if($contractInfor->relative_infor->type_relative_2 == "Bác") echo "selected"?>>Bác</option>
                    <option value="Bạn bè" <?php if($contractInfor->relative_infor->type_relative_2 == "Bạn bè") echo "selected"?>>Bạn bè</option>
                    <option value="Đồng nghiệp" <?php if($contractInfor->relative_infor->type_relative_2 == "Đồng nghiệp") echo "selected"?>>Đồng nghiệp</option>
                    <option value="Hàng xóm" <?php if($contractInfor->relative_infor->type_relative_2 == "Hàng xóm") echo "selected"?>>Hàng xóm</option>
                    <option value="Khác" <?php if($contractInfor->relative_infor->type_relative_2 == "Khác") echo "selected"?>>Khác</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Telephone_number_relative')?><span class="text-danger">*</span>
              </label>
              <div class="col-lg-6 col-sm-12 col-12">
              <input type="text" id="phone_number_relative_2" value="<?= $contractInfor->relative_infor->phone_number_relative_2 ? $contractInfor->relative_infor->phone_number_relative_2 : "" ?>" required class="form-control">
              </div>
            </div>
			  <div class="form-group row">
				  <label class="control-label col-md-3 col-sm-3 col-xs-12">
					  Bảo mật khoản vay tham chiếu 2 <span class="text-danger">*</span>
				  </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					  <div class="radio-inline text-primary">
						  <label><input type="radio" value="1" name="loan_security_two" <?= (!empty($contractInfor->relative_infor->loan_security_2) && $contractInfor->relative_infor->loan_security_2 == 1) ? 'checked' : '' ?> >Công khai</label>
					  </div>
					  <div class="radio-inline text-danger">
						  <label><input type="radio" value="2" name="loan_security_two" <?= (!empty($contractInfor->relative_infor->loan_security_2) && $contractInfor->relative_infor->loan_security_2 == 2) ? 'checked' : '' ?>>Bảo mật</label>
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
              <?= $this->lang->line('Residential_address')?><span class="text-danger">*</span>
              </label>
              <div class="col-lg-6 col-sm-12 col-12">
              <input type="text" id="hoursehold_relative_2" value="<?= $contractInfor->relative_infor->hoursehold_relative_2 ? $contractInfor->relative_infor->hoursehold_relative_2 : "" ?>" required class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Phản hồi <span class="text-danger">*</span>
              </label>
              <div class="col-lg-6 col-sm-12 col-12">
              <!-- <input type="text" id="confirm_relativeInfor2" value="<?= $contractInfor->relative_infor->confirm_relativeInfor_2 ? $contractInfor->relative_infor->confirm_relativeInfor_2 : "" ?>" required class="form-control"> -->
              <textarea type="text" id="confirm_relativeInfor2" required="" class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_2) ? $contractInfor->relative_infor->confirm_relativeInfor_2 : "" ?></textarea>
              </div>
            </div>
			  <br>
			  <div class="form-group row">
				  <label class="control-label col-md-3 col-sm-3 col-xs-12">
					  Tên đơn vị tham chiếu 3
				  </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					  <input  type="text" id="fullname_relative_3" required class="form-control" value="<?= $contractInfor->relative_infor->fullname_relative_3 ? $contractInfor->relative_infor->fullname_relative_3 : "" ?>">
				  </div>
			  </div>
			  <div class="form-group row">
				  <label class="control-label col-md-3 col-sm-3 col-xs-12">
					  Địa chỉ
				  </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="address_relative_3" required class="form-control" value="<?= $contractInfor->relative_infor->address_relative_3 ? $contractInfor->relative_infor->address_relative_3 : "" ?>">
				  </div>
			  </div>
			  <div class="form-group row">
				  <label class="control-label col-md-3 col-sm-3 col-xs-12">
					  Số điện thoại
				  </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="phone_relative_3" required class="form-control" value="<?= $contractInfor->relative_infor->phone_relative_3 ? $contractInfor->relative_infor->phone_relative_3 : "" ?>">
				  </div>
			  </div>
			  <div class="form-group row">
				  <label class="control-label col-md-3 col-sm-3 col-xs-12">
					  Bảo mật khoản vay tham chiếu 3
				  </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					  <div class="radio-inline text-primary">
						  <label><input type="radio" value="1" name="loan_security_three" <?= (!empty($contractInfor->relative_infor->loan_security_3) && $contractInfor->relative_infor->loan_security_3 == 1) ? 'checked' : '' ?> >Công khai</label>
					  </div>
					  <div class="radio-inline text-danger">
						  <label><input type="radio" value="2" name="loan_security_three" <?= (!empty($contractInfor->relative_infor->loan_security_3) && $contractInfor->relative_infor->loan_security_3 == 2) ? 'checked' : '' ?>>Bảo mật</label>
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
						  <option value="Xác nhận công việc" <?php if($contractInfor->relative_infor->type_relative_3 == "Xác nhận công việc") echo "selected"?>>Xác nhận công việc</option>
						  <option value="Xác nhận hợp đồng ủy quyền" <?php if($contractInfor->relative_infor->type_relative_3 == "Xác nhận hợp đồng ủy quyền") echo "selected"?>>Xác nhận hợp đồng ủy quyền</option>

					  </select>
				  </div>
			  </div>
			  <div class="form-group row">
				  <label class="control-label col-md-3 col-sm-3 col-xs-12">
					  Phản hồi
				  </label>
				  <div class="col-lg-6 col-sm-12 col-12">
					  <textarea type="text" id="confirm_relativeInfor3" required="" class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor3) ? $contractInfor->relative_infor->confirm_relativeInfor3 : "" ?></textarea>
				  </div>
			  </div>


            <?php 
                $step = !empty($contractInfor->step) ? $contractInfor->step : "1";
                if($step < 3){
                  $step = "3";
                };
            ?>
            <button class="btn btn-primary nextBtnCreate pull-right" data-step="3"  type="button">Tiếp tục</button>
            <button class="btn btn-primary  pull-right save_contract"  type="button" data-step="<?php echo $step?>"  data-toggle="modal" data-target="#saveContract">Lưu lại</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
          </div>
			<!--Modal hợp đồng liên quan-->
			<?php $this->load->view('page/pawn/modal/contract_reference_modal.php'); ?>
        </div>
