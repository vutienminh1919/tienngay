<div class="x_panel">


	<div class="x_content">

		<div class="row">
			<div class="col-xs-12">
				<h4 class="text-danger text-uppercase">
					Thông tin khách hàng và thông tin liên quan:
					<hr>
				</h4>
			</div>

			<div class="col-xs-12">
				<table class="table table-bordered ">
					<tbody>
					<tr>
						<th>Phòng giao dịch <span class="text-danger">*</span></th>
						<td  colspan="3" class="error_messages">
							<select class="form-control" id="stores" style="width:100%;border:0" data-id="<?= $contractInfor->store->id;?>">
								<?php

								foreach($stores as $key =>  $value){

									?>
									<option  data-address="<?= !empty($value->address) ? $value->address : ""?>" data-code-address="<?= !empty($value->code_address_store) ? $value->code_address_store : ""?>" value="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""?>" <?= ($contractInfor->store->id == $value->_id->{'$oid'}) ? 'selected' : '' ;?>><?= !empty($value->name) ? $value->name : ""?></option>
								<?php }?>
							</select>
							<p class="messages"></p>
						</td>
					</tr>
					</tbody>
				</table>
			</div>


			<div class="col-xs-12">
				<p>
					<strong>Thông tin việc làm:</strong>
				</p>

				<table class="table table-bordered">
					<thead>
					<tr>
						<th scope="col" style="text-align: center">Tên công ty <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Địa chỉ công ty <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Số điện thoại công ty <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Vị trí/Chức vụ <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Thu nhập <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Hình thức nhận lương <span class="text-danger">*</span></th>
						<th scope="col" style="text-align: center">Nghề nghiệp <span class="text-danger">*</span></th>
					</tr>
					</thead>
					<tbody>
					<tr>

						<td class="error_messages">
							<input type="text" name="name_company" id="name_company" value="<?= $contractInfor->job_infor->name_company ? $contractInfor->job_infor->name_company : "" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="address_company" id="address_company" value="<?= $contractInfor->job_infor->address_company ? $contractInfor->job_infor->address_company : "" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="phone_number_company" id="phone_number_company" value="<?= !empty($contractInfor->job_infor->phone_number_company) ? $contractInfor->job_infor->phone_number_company : "" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select class="form-control" id="job_position" style="width:100%;border:0">
								<option value="Mới tốt nghiệp" <?= $contractInfor->job_infor->job_position == "Mới tốt nghiệp" ? "selected" : "" ?> >Mới tốt nghiệp</option>
								<option value="Nhân viên /Chuyên viên" <?= $contractInfor->job_infor->job_position == "Nhân viên /Chuyên viên" ? "selected" : "" ?> >Nhân viên /Chuyên viên</option>
								<option value="Chuyên viên chính" <?= $contractInfor->job_infor->job_position == "Chuyên viên chính" ? "selected" : "" ?> >Chuyên viên chính</option>
								<option value="Chuyên viên cao cấp" <?= $contractInfor->job_infor->job_position == "Chuyên viên cao cấp" ? "selected" : "" ?> >Chuyên viên cao cấp</option>
								<option value="Trưởng nhóm/Giám sát" <?= $contractInfor->job_infor->job_position == "Trưởng nhóm/Giám sát" ? "selected" : "" ?> >Trưởng nhóm/Giám sát</option>
								<option value="Trưởng phòng" <?= $contractInfor->job_infor->job_position == "Trưởng phòng" ? "selected" : "" ?> >Trưởng phòng</option>
								<option value="Giám đốc và cấp cao hơn" <?= $contractInfor->job_infor->job_position == "Giám đốc và cấp cao hơn" ? "selected" : "" ?> >Giám đốc và cấp cao hơn</option>
								<option value="Không" <?= $contractInfor->job_infor->job_position == "Không" ? "selected" : "" ?> >Không</option>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="salary" id="salary" value="<?= $contractInfor->job_infor->salary ? $contractInfor->job_infor->salary : "" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select class="form-control" id="receive_salary_via" style="width:100%;border:0">
								<option value="1" <?= $contractInfor->job_infor->receive_salary_via == "1" ? "selected" : "" ?> >Tiền mặt</option>
								<option value="2" <?= $contractInfor->job_infor->receive_salary_via == "2" ? "selected" : "" ?> >Chuyển khoản</option>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select style="width:100%;border:0" class="form-control" id="job">
								<?php
								$job = status_job();
								foreach($job as $key => $value){
									?>
									<option value="<?php echo $value?>" <?= $contractInfor->job_infor->job == $value ? "selected" : "" ?>><?php echo $value?></option>
								<?php }?>
							</select>
							<p class="messages"></p>
						</td>

					</tr>

					</tbody>
				</table>
			</div>

			<div class="col-xs-12">
				<p>
					<strong>Thông tin tham chiếu::</strong>
				</p>

				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
						<tr>
							<th scope="col" style="text-align: center">#</th>
							<th scope="col" style="text-align: center">Tên tham chiếu <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Mối quan hệ <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Số điện thoại <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Địa chỉ cư trú <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Ghi chú <span class="text-danger">*</span></th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<th scope="row" style="text-align: center">1</th>
							<td class="error_messages">
								<input type="text" name="fullname_relative_1" id="fullname_relative_1" value="<?= $contractInfor->relative_infor->fullname_relative_1 ? $contractInfor->relative_infor->fullname_relative_1 : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages" >
								<select class="form-control" id="type_relative_1" style="width:100%;border:0">
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
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="phone_number_relative_1" id="phone_number_relative_1" value="<?= $contractInfor->relative_infor->phone_number_relative_1 ? $contractInfor->relative_infor->phone_number_relative_1 : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="hoursehold_relative_1" id="hoursehold_relative_1" value="<?= $contractInfor->relative_infor->hoursehold_relative_1 ? $contractInfor->relative_infor->hoursehold_relative_1 : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<textarea type="text" name="confirm_relativeInfor1" id="confirm_relativeInfor1" style="width:100%;border:0" placeholder=""><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_1) ? $contractInfor->relative_infor->confirm_relativeInfor_1 : "" ?></textarea>
								<p class="messages"></p>
							</td>
						</tr>
						<tr>
							<th scope="row" style="text-align: center">2</th>
							<td class="error_messages">
								<input type="text" name="fullname_relative_2" id="fullname_relative_2" value="<?= $contractInfor->relative_infor->fullname_relative_2 ? $contractInfor->relative_infor->fullname_relative_2 : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="type_relative_2" style="width:100%;border:0">
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
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="phone_number_relative_2" id="phone_number_relative_2" value="<?= $contractInfor->relative_infor->phone_number_relative_2 ? $contractInfor->relative_infor->phone_number_relative_2 : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="hoursehold_relative_2" id="hoursehold_relative_2" value="<?= $contractInfor->relative_infor->hoursehold_relative_2 ? $contractInfor->relative_infor->hoursehold_relative_2 : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<textarea type="text" name="confirm_relativeInfor2" id="confirm_relativeInfor2" style="width:100%;border:0" placeholder=""><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_2) ? $contractInfor->relative_infor->confirm_relativeInfor_2 : "" ?></textarea>
								<p class="messages"></p>
							</td>
						</tr>
						<tr>
							<th scope="row" style="text-align: center">3</th>
							<td >
								<input type="text" name="fullname_relative_3" id="fullname_relative_3" value="<?= $contractInfor->relative_infor->fullname_relative_3 ? $contractInfor->relative_infor->fullname_relative_3 : "" ?>" style="width:100%;border:0" placeholder="">

							</td>
							<td>
								<select class="form-control" id="type_relative_3" style="width:100%;border:0">
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

							</td>
							<td >
								<input type="text" name="phone_number_relative_3" id="phone_number_relative_3" value="<?= $contractInfor->relative_infor->phone_relative_3 ? $contractInfor->relative_infor->phone_relative_3 : "" ?>" style="width:100%;border:0" placeholder="">
							</td>
							<td >
								<input type="text" name="hoursehold_relative_3" id="hoursehold_relative_3" value="<?= $contractInfor->relative_infor->hoursehold_relative_3 ? $contractInfor->relative_infor->hoursehold_relative_3 : "" ?>" style="width:100%;border:0" placeholder="">

							</td>
							<td>
								<input type="text" name="confirm_relativeInfor3" id="confirm_relativeInfor3" value="<?= $contractInfor->relative_infor->confirm_relativeInfor3 ? $contractInfor->relative_infor->confirm_relativeInfor3 : "" ?>" style="width:100%;border:0" placeholder="">
							</td>
						</tr>

						</tbody>
					</table>
				</div>
			</div>

			<div class="col-xs-12">
				<p>
					<strong>Thông tin tài khoản:</strong>
				</p>

				<div >
					<table class="table table-bordered ">
						<thead>
						<tr>
							<th scope="col" style="text-align: center">Hình thức <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Ngân hàng <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Chi nhánh <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">STK <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Chủ tài khoản <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Số thẻ atm <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Tên chủ thẻ atm <span class="text-danger">*</span></th>

						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="error_messages">
								<select class="form-control" id="type_payout"  onchange="typePayout()" style="width:100%;border:0">
									<option value="2" <?php if($contractInfor->receiver_infor->type_payout == "2") echo "selected"?>>Tài khoản ngân hàng</option>
									<option value="3" <?php if($contractInfor->receiver_infor->type_payout == "3") echo "selected"?>>Thẻ atm</option>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="selectize_bank_vimo" style="width:100%;border:0">
									<?php
									if(!empty($bankNganluongData)){
										foreach($bankNganluongData as $key => $bank){
											if($bank->status=="deactive"){ continue; }

											?>
											<option value="<?= !empty($bank->bank_id) ? $bank->bank_id : "";?>" <?php if($contractInfor->receiver_infor->bank_id == $bank->bank_id) echo 'selected';?>><?= !empty($bank->name) ? $bank->name : "";?> ( <?= !empty($bank->short_name) ? $bank->short_name : "";?> )</option>
										<?php }}?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="bank_branch" id="bank_branch" value="<?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?> style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="bank_account" id="bank_account" value="<?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?> style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="bank_account_holder" id="bank_account_holder" value="<?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?> style="width:100%;border:0" placeholder="" >
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="atm_card_number" id="atm_card_number" value="<?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'disabled';?> style="width:100%;border:0" placeholder="" disabled>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="atm_card_holder" id="atm_card_holder" value="<?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'disabled';?> style="width:100%;border:0" placeholder="" disabled>
								<p class="messages"></p>
							</td>

						</tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<h4 class="text-danger text-uppercase">
					<hr>
					Thông tin khoản vay và tài sản liên quan:
					<hr>
				</h4>
			</div>

			<div class="col-xs-12">
				<p>
					<strong>Thông tin khoản vay:</strong>
				</p>

				<?php
				if (empty($dataInit['type_finance']) && empty($dataInit['main'])) { ?>
					<?php
					$data['configuration_formality'] = $configuration_formality;
					$data['mainPropertyData'] = $mainPropertyData;
					$data['type_finance'] = $type_finance;
					$this->load->view('page/pawn/new_contract/loan_info/loan_info_no_init',$data)
					?>
				<?php } ?>

				<?php if (!empty($dataInit['type_finance']) && !empty($dataInit['main'])) { ?>
					<?php

					$data['configuration_formality'] = $configuration_formality;
					$data['mainPropertyData'] = $mainPropertyData;
					$data['dataInit'] = $dataInit;
					$this->load->view("page/pawn/new_contract/loan_info/loan_infor_have_init", $data);
					?>
				<?php } ?>



			</div>
			<div class="col-xs-12">
				<p>
					<strong>Thông tin tiền:</strong>
				</p>

				<div class="table-responsive">
					<table class="table table-bordered ">
						<thead>
						<tr>
							<th scope="col" style="text-align: center">Số tiền vay <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Mục đích vay <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Thời gian vay <span class="text-danger">*</span></th>
							<th scope="col" style="text-align: center">Hình thức trả tiền <span class="text-danger">*</span></th>


						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="error_messages">
								<input type="text" name="money" id="money" value="<?= $contractInfor->loan_infor->amount_money ? number_format($contractInfor->loan_infor->amount_money) : "" ?>" style="width:100%;border:0" placeholder="" >
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="loan_purpose" style="width:100%;border:0">
									<option value="Tiêu dùng cá nhân" <?= $contractInfor->loan_infor->loan_purpose == "Tiêu dùng cá nhân" ? "selected='selected'" : "" ?>>Tiêu dùng cá nhân</option>
									<option value="Đóng học phí" <?= $contractInfor->loan_infor->loan_purpose == "Đóng học phí" ? "selected='selected'" : "" ?>>Đóng học phí</option>
									<option value="Đóng viện phí" <?= $contractInfor->loan_infor->loan_purpose == "Đóng viện phí" ? "selected='selected'" : "" ?>>Đóng viện phí</option>
									<option value="Du lịch" <?= $contractInfor->loan_infor->loan_purpose == "Du lịch" ? "selected='selected'" : "" ?>>Du lịch</option>
									<option value="Kinh doanh" <?= $contractInfor->loan_infor->loan_purpose == "Kinh doanh" ? "selected='selected'" : "" ?>>Kinh doanh</option>
									<option value="Mua đồ điện tử" <?= $contractInfor->loan_infor->loan_purpose == "Mua đồ điện tử" ? "selected='selected'" : "" ?>>Mua đồ điện tử</option>
									<option value="Mua đồ nội thất" <?= $contractInfor->loan_infor->loan_purpose == "Mua đồ nội thất" ? "selected='selected'" : "" ?>> Mua đồ nội thất</option>
									<option value="Mua xe máy" <?= $contractInfor->loan_infor->loan_purpose == "Mua xe máy" ? "selected='selected'" : "" ?>> Mua xe máy</option>
									<option value="Sửa chữa nhà ở" <?= $contractInfor->loan_infor->loan_purpose == "Sửa chữa nhà ở" ? "selected='selected'" : "" ?>>Sửa chữa nhà ở</option>
									<option value="Các mục đich khác không vi phạm Quy định của pháp luật" <?= $contractInfor->loan_infor->loan_purpose == "Các mục đich khác không vi phạm Quy định của pháp luật" ? "selected='selected'" : "" ?>>Các mục đich khác không vi
										phạm Quy định của pháp luật
									</option>
									<option value="Vay bổ sung vốn kinh doanh Online" id="kdol_v" hidden <?= $contractInfor->loan_infor->loan_purpose == "Vay bổ sung vốn kinh doanh Online" ? "selected='selected'" : "" ?>>Vay bổ sung vốn kinh doanh Online</option>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control " id="number_day_loan" style="width:100%;border:0">
									<option value="">-- Chọn thời gian vay --</option>
									<option id="number_day_loan_motobike" value="1" <?= $contractInfor->loan_infor->number_day_loan / 30 == "1" ? "selected='selected'" : "" ?> >1
										tháng
									</option>
									<option value="3" <?= $contractInfor->loan_infor->number_day_loan / 30 == "3" ? "selected='selected'" : "" ?>>3
										tháng
									</option>
									<option value="6" <?= $contractInfor->loan_infor->number_day_loan / 30 == "6" ? "selected='selected'" : "" ?>>6
										tháng
									</option>
									<option value="9" <?= $contractInfor->loan_infor->number_day_loan / 30 == "9" ? "selected='selected'" : "" ?>>9
										tháng
									</option>
									<option value="12" <?= $contractInfor->loan_infor->number_day_loan / 30 == "12" ? "selected='selected'" : "" ?>>
										12 tháng
									</option>
									<option value="18" <?= $contractInfor->loan_infor->number_day_loan / 30 == "18" ? "selected='selected'" : "" ?>>
										18 tháng
									</option>
									<option value="24" <?= $contractInfor->loan_infor->number_day_loan / 30 == "24" ? "selected='selected'" : "" ?>>
										24 tháng
									</option>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="type_interest" style="width:100%;border:0">
									<option value="">-- Chọn hình thức trả lãi --</option>
									<option value="1" <?= $contractInfor->loan_infor->type_interest == 1 ? "selected='selected'" : "" ?>><?= $this->lang->line('Outstanding_descending') ?></option>
									<option id="type_interest_motobike" value="2" <?= $contractInfor->loan_infor->type_interest == 2 ? "selected='selected'" : "" ?>><?= $this->lang->line('Monthly_interest_principal_maturity') ?></option>
								</select>
								<p class="messages"></p>
							</td>
							<select class="form-control" name="fee_id" style="display: none" style="width:100%;border:0">
								<?php
								foreach ($fee_data as $key => $item) { ?>
									<option <?php echo $item->main == '1' ? 'selected' : '' ?>
										value="<?= $item->_id->{'$oid'} ?>"><?= $item->title ?></option>
								<?php } ?>
							</select>

							<input type="text" id="period_pay_interest" class="form-control" value="30" disabled style="display: none">
						</tr>

						</tbody>
					</table>
				</div>
			</div>
			<div class="col-xs-12">
				<p>
					<strong>Thông tin bảo hiểm:</strong>
				</p>

				<div class="table">
					<table class="table table-bordered ">
						<thead>
						<tr>
							<th scope="col"  style="text-align: center">Bảo hiểm khoản vay &nbsp;&nbsp;&nbsp; <input name='insurrance' <?= ($contractInfor->loan_infor->insurrance_contract == 1) ? "checked" : "" ?> id="insurrance" type="checkbox"></th>
							<th scope="col"  style="text-align: center">Bảo hiểm xe máy(easy) GIC</th>
							<th scope="col"  style="text-align: center">Bảo hiểm phúc lộc thọ</th>
							<th scope="col"  style="text-align: center">Bảo hiểm VBI</th>
							<th scope="col"  style="text-align: center" >Chương trình ưu đãi</th>
							<th scope="col"  style="text-align: center">Ghi chú</th>

						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="error_messages">
								<input type="hidden" id="tilekhoanvay" name="tilekhoanvay" value="<?= $tilekhoanvay ?>">

								<select class="form-control" name="loan_insurance" style="width:100%;border:0">
									<option value="0">-- Chọn bảo hiểm khoản vay --</option>
									<?php $loan_insurance = isset($contractInfor->loan_infor->loan_insurance) ? $contractInfor->loan_infor->loan_insurance : '';
									foreach (loan_insurance() as $key => $item) {
										if (!in_array('hoi-so', $groupRoles)) {
											if ($province_id_store == '01' && $key == '1') continue;
											if ($province_id_store != '01' && $key == '2') continue;
										}
										?>
										<option <?php echo $loan_insurance == $key ? 'selected' : '' ?>
											value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" name="gic_easy" id="gic_easy" style="width:100%;border:0">
									<option value="0">-- Chọn gói bảo hiểm --</option>
									<?php $easy = isset($contractInfor->loan_infor->code_GIC_easy) ? $contractInfor->loan_infor->code_GIC_easy : '';
									foreach (gic_easy() as $key => $item) { ?>
										<option <?php echo $easy == $item ? 'selected' : '' ?> value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<p class="messages"></p>
							</td>

							<td class="error_messages">
								<select class="form-control" name="gic_plt" style="width:100%;border:0">
									<option value="0">-- Chọn gói bảo hiểm --</option>
									<?php $plt = isset($contractInfor->loan_infor->code_GIC_plt) ? $contractInfor->loan_infor->code_GIC_plt : '';
									foreach (gic_plt() as $key => $item) { ?>
										<option <?php echo get_code_plt($plt) == $item ? 'selected' : '' ?>
											value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<?php $code_VBI = [];
								array_push($code_VBI, $contractInfor->loan_infor->maVBI_1);
								array_push($code_VBI, $contractInfor->loan_infor->maVBI_2) ?>
								<select id="selectize_vbi" class="form-control" name="code_vbi[]" multiple="multiple" data-placeholder="Chọn bảo hiểm VBI" style="width:100%;border:0">
									<?php
									$code_maVBI = (isset($code_VBI) && is_array($code_VBI)) ? $code_VBI : array();

									?>
									<option value="1" <?= (is_array($code_maVBI) && in_array("1", $code_maVBI)) ? 'selected' : '' ?> >
										Sốt xuất huyết cá nhân gói đồng
									</option>
									<option value="2" <?= (is_array($code_maVBI) && in_array("2", $code_maVBI)) ? 'selected' : '' ?>>Sốt
										xuất huyết cá nhân gói bạc
									</option>
									<option value="3" <?= (is_array($code_maVBI) && in_array("3", $code_maVBI)) ? 'selected' : '' ?>>Sốt
										xuất huyết cá nhân gói vàng
									</option>
									<option value="4" <?= (is_array($code_maVBI) && in_array("4", $code_maVBI)) ? 'selected' : '' ?>>Sốt
										xuất huyết gia đình 6 người gói đồng
									</option>
									<option value="5" <?= (is_array($code_maVBI) && in_array("5", $code_maVBI)) ? 'selected' : '' ?>>Sốt
										xuất huyết gia đình 6 người gói bạc
									</option>
									<option value="6" <?= (is_array($code_maVBI) && in_array("6", $code_maVBI)) ? 'selected' : '' ?>>Sốt
										xuất huyết gia đình 6 người gói vàng
									</option>
									<option value="7" <?= (is_array($code_maVBI) && in_array("7", $code_maVBI)) ? 'selected' : '' ?>>Ung
										thư vú - nữ giới 18-40 tuổi Lemon
									</option>
									<option value="8" <?= (is_array($code_maVBI) && in_array("8", $code_maVBI)) ? 'selected' : '' ?>>Ung
										thư vú - nữ giới 18-40 tuổi Orange
									</option>
									<option value="9" <?= (is_array($code_maVBI) && in_array("9", $code_maVBI)) ? 'selected' : '' ?>>Ung
										thư vú - nữ giới 18-40 tuổi Pomelo
									</option>
									<option value="10" <?= (is_array($code_maVBI) && in_array("10", $code_maVBI)) ? 'selected' : '' ?>>
										Ung thư vú - nữ giới 41-55 tuổi Lemon
									</option>
									<option value="11" <?= (is_array($code_maVBI) && in_array("11", $code_maVBI)) ? 'selected' : '' ?>>
										Ung thư vú - nữ giới 41-55 tuổi Orange
									</option>
									<option value="12" <?= (is_array($code_maVBI) && in_array("12", $code_maVBI)) ? 'selected' : '' ?>>
										Ung thư vú - nữ giới 41-55 tuổi Pomelo
									</option>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages" rowspan="2">
								<select class="form-control" id="code_coupon" style="width:100%;border:0">
									<option value="">-- Chọn Chương trình ưu đãi --</option>
									<?php
									$coupon = isset($contractInfor->loan_infor->code_coupon) ? $contractInfor->loan_infor->code_coupon : '';
									foreach ($couponData as $key => $item) { ?>
										<option <?php echo $item->code == $coupon ? 'selected' : '' ?>
											value="<?= $item->code ?>"><?= $item->code ?></option>
									<?php } ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages" rowspan="2">
								<textarea type="text" id="note" required class="form-control" style="width:100%;border:0"><?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?></textarea>
								<p class="messages"></p>
							</td>

						</tr>
						<tr>
							<td>
								<?php
								$amount_GIC = (!empty($contractInfor->loan_infor->amount_GIC)) ? $contractInfor->loan_infor->amount_GIC : 0;
								$amount_MIC = (!empty($contractInfor->loan_infor->amount_MIC)) ? $contractInfor->loan_infor->amount_MIC : 0;
								$fee_insurance = ($loan_insurance == "1") ? number_format($amount_GIC) : number_format($amount_MIC);
								?>
								<input type="text" id="fee_gic" class="form-control number" value="<?= $fee_insurance ?>" disabled>
							</td>
							<td>
								<input type="text" id="fee_gic_easy" class="form-control number"
									   value="<?= (isset($contractInfor->loan_infor->amount_GIC_easy)) ? number_format($contractInfor->loan_infor->amount_GIC_easy) : 0 ?>"
									   disabled>
							</td>
							<td>
								<input type="text" id="fee_gic_plt" class="form-control number"
									   value="<?= (isset($contractInfor->loan_infor->amount_GIC_plt)) ? number_format($contractInfor->loan_infor->amount_GIC_plt) : 0 ?>"
									   disabled>
							</td>
							<td>
								<input type="text" id="fee_vbi" class="form-control number" value="<?= (isset($contractInfor->loan_infor->amount_VBI)) ? number_format($contractInfor->loan_infor->amount_VBI) : 0 ?>" disabled>
								<input type="text" id="fee_vbi1" class="form-control number" value="<?= (isset($contractInfor->loan_infor->amount_code_VBI_1)) ? number_format($contractInfor->loan_infor->amount_code_VBI_1) : 0 ?>" style="display: none">
								<input type="text" id="fee_vbi2" class="form-control number" value="<?= (isset($contractInfor->loan_infor->amount_code_VBI_2)) ? number_format($contractInfor->loan_infor->amount_code_VBI_2) : 0 ?>" style="display: none">
								<input type="text" id="code_VBI_1" class="form-control number" value="<?= (isset($contractInfor->loan_infor->code_VBI_1)) ? ($contractInfor->loan_infor->code_VBI_1) : 0 ?>" style="display: none">
								<input type="text" id="code_VBI_2" class="form-control number" value="<?= (isset($contractInfor->loan_infor->code_VBI_2)) ? ($contractInfor->loan_infor->code_VBI_2) : 0 ?>" style="display: none">
								<input type="text" id="maVBI_1" class="form-control number" value="<?= (isset($contractInfor->loan_infor->maVBI_1)) ? ($contractInfor->loan_infor->maVBI_1) : 0 ?>" style="display: none">
								<input type="text" id="maVBI_2" class="form-control number" value="<?= (isset($contractInfor->loan_infor->maVBI_2)) ? ($contractInfor->loan_infor->maVBI_2) : 0 ?>" style="display: none">
							</td>


						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-xs-12">
				<p>
					<strong>Thông tin tài sản:</strong>
				</p>

				<div class="table-responsive">
					<table class="table table-bordered ">
						<!--						<thead>-->
						<!--						<tr>-->
						<!--							<th scope="col">Nhãn hiệu</th>-->
						<!--							<th scope="col">Model</th>-->
						<!--							<th scope="col">Biển số xe</th>-->
						<!--							<th scope="col">Số khung</th>-->
						<!--							<th scope="col">Số máy</th>-->
						<!--							<th scope="col">Họ tên chủ xe</th>-->
						<!--							<th scope="col">Địa chỉ đăng ký</th>-->
						<!--						</tr>-->
						<!--						</thead>-->
						<thead>
						<tr class="properties">
							<?php if (!empty($contractInfor->property_infor)) {
								foreach ($contractInfor->property_infor as $item) { ?>
									<th scope="col"><?= $item->name ?></th>
								<?php }
							} ?>
						</tr>
						</thead>
						<tbody>
						<tr class="properties_b">
							<?php if (!empty($contractInfor->property_infor)) {
								foreach ($contractInfor->property_infor as $item) { ?>
									<?php if ($item->slug == "ngay-cap") { ?>
										<td class='error_messages'>
											<input type='date' name='property_infor' data-slug='<?= $item->slug ?>' data-name='<?= $item->name ?>' style='width:100%;border:0' placeholder='' value="<?= $item->value ?>">
											<p class='messages'></p>
										</td>
									<?php } else { ?>
										<td class='error_messages'>
											<input type='text' name='property_infor' data-slug='<?= $item->slug ?>' data-name='<?= $item->name ?>' style='width:100%;border:0' placeholder='' value="<?= $item->value ?>">
											<p class='messages'></p>
										</td>
									<?php }
								}
							} ?>
						</tr>
						</tbody>
						<!--						<tbody>-->
						<!--						<tr>-->
						<!--							<td>-->
						<!--								<input type="text" name="" value="" style="width:100%;border:0" placeholder="...">-->
						<!--							</td>-->
						<!--							<td>-->
						<!--								<input type="text" name="" value="" style="width:100%;border:0" placeholder="...">-->
						<!--							</td>-->
						<!--							<td>-->
						<!--								<input type="text" name="" value="" style="width:100%;border:0" placeholder="...">-->
						<!--							</td>-->
						<!--							<td>-->
						<!--								<input type="text" name="" value="" style="width:100%;border:0" placeholder="...">-->
						<!--							</td>-->
						<!--							<td>-->
						<!--								<input type="text" name="" value="" style="width:100%;border:0" placeholder="...">-->
						<!--							</td>-->
						<!--							<td>-->
						<!--								<input type="text" name="" value="" style="width:100%;border:0" placeholder="...">-->
						<!--							</td>-->
						<!--							<td>-->
						<!--								<input type="text" name="" value="" style="width:100%;border:0" placeholder="...">-->
						<!--							</td>-->
						<!--						</tr>-->
						<!--						</tbody>-->
					</table>

				</div>

			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<h4 class="text-danger text-uppercase">
					<hr>
					Thông tin thẩm định
					<hr>
				</h4>
			</div>

			<div class="col-xs-12">
				<p>
					<strong>Thông tin quan hệ tín dụng:</strong>
				</p>

				<div class="table-responsive">
					<table class="table table-bordered ">
						<thead>
						<tr>
							<th scope="col" style="text-align: center">Tên tổ chức vay</th>
							<th scope="col" style="text-align: center">Gốc còn lại</th>
							<th scope="col" style="text-align: center">Đã tất toán</th>
							<th scope="col" style="text-align: center">Tiền phải trả hàng kỳ</th>
							<th scope="col" style="text-align: center">Tiền quá hạn</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="error_messages">
								<input type="text" name="company_name" id="company_name" value="<?= !empty($contractInfor->expertise_infor->company_name) ? $contractInfor->expertise_infor->company_name : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="company_debt" id="company_debt" value="<?= !empty($contractInfor->expertise_infor->company_debt) ? $contractInfor->expertise_infor->company_debt : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="company_finalization" id="company_finalization" value="<?= !empty($contractInfor->expertise_infor->company_finalization) ? $contractInfor->expertise_infor->company_finalization : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="company_borrowing" id="company_borrowing" value="<?= !empty($contractInfor->expertise_infor->company_borrowing) ? $contractInfor->expertise_infor->company_borrowing : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="company_out_of_date" id="company_out_of_date" value="<?= !empty($contractInfor->expertise_infor->company_out_of_date) ? $contractInfor->expertise_infor->company_out_of_date : "" ?>" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>

						</tr>

						</tbody>
					</table>
				</div>
			</div>

			<div class="col-xs-12 col-md-6">
				<p>
					<strong>Ghi chú thẩm định:</strong>
				</p>

				<div class="table-responsive">
					<table class="table table-bordered ">
						<tbody>
						<tr>
							<th>Thẩm định hồ sơ <span class="text-danger">*</span></th>
							<td class="error_messages" colspan="2">
								<textarea type="text" name="expertise_file" id="expertise_file" style="width:100%;border:0" placeholder="" ><?= !empty($contractInfor->expertise_infor->expertise_file) ? $contractInfor->expertise_infor->expertise_file : "" ?></textarea>
								<p class="messages"></p>
							</td>
						</tr>
						<tr>
							<th>Thẩm định thực địa <span class="text-danger">*</span></th>
							<td class="error_messages" colspan="2">
								<textarea type="text" name="expertise_field" id="expertise_field" style="width:100%;border:0" placeholder="" ><?= !empty($contractInfor->expertise_infor->expertise_field) ? $contractInfor->expertise_infor->expertise_field : "" ?></textarea>
								<p class="messages"></p>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-xs-12 col-md-6">
				<p>
					<strong>Ngoại lệ hồ sơ:</strong>
				</p>

				<div >
					<table class="table table-bordered ">
						<tbody>
						<tr>
							<th class="error_messages">
								<select id="change_exception" class="form-control" name="change_exception" data-placeholder="Các lý do ngoại lệ" style="width:100%;border:0">
									<option value="">-- Các lý do ngoại lệ --</option>
									<option value="E1">E1: Ngoại lệ về hồ sơ nhân thân</option>
									<option value="E2">E2: Ngoại lệ về thông tin nơi ở</option>
									<option value="E3">E3: Ngoại lệ về thông tin thu nhập</option>
									<option value="E4">E4: Ngoại lệ về thông tin sản phẩm</option>
									<option value="E5">E5: Ngoại lệ về thông tin tham chiếu</option>
									<option value="E6">E6: Ngoại lệ về thông tin lịch sử tín dụng</option>
									<option value="E7">E7: Ngoại lệ tăng giá trị khoản vay</option>
								</select>
							</th>
							<td colspan="2">
								<div <?php if (empty($contractInfor->expertise_infor->exception1_value[0])): ?> style="display: none" <?php endif;?> id="exception1">
									<div class="row">
										<div class="col-md-10">
											<select   id="lead_exception_E1" class="form-control" name="lead_exception_E1[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E1" >
												<?php
												$value1 = (isset($contractInfor->expertise_infor->exception1_value[0]) && is_array($contractInfor->expertise_infor->exception1_value[0]) ) ? $contractInfor->expertise_infor->exception1_value[0] : array();
												?>
												<?php foreach (lead_exception_E1() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E1 == $key) ? 'selected' : '' ?> <?= ( is_array($value1) && in_array("$key", $value1)) ? 'selected' : '' ?> ><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception1_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>

								</div>
								<div <?php if (empty($contractInfor->expertise_infor->exception2_value[0])): ?> style="display: none" <?php endif;?> id="exception2">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E2" class="form-control" name="lead_exception_E2[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E2">
												<?php
												$value2 = (isset($contractInfor->expertise_infor->exception2_value[0]) && is_array($contractInfor->expertise_infor->exception2_value[0]) ) ? $contractInfor->expertise_infor->exception2_value[0] : array();
												?>
												<?php foreach (lead_exception_E2() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E2 == $key) ? 'selected' : '' ?> <?= ( is_array($value2) && in_array("$key", $value2)) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception2_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div <?php if (empty($contractInfor->expertise_infor->exception3_value[0])): ?> style="display: none" <?php endif;?> id="exception3">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E3" class="form-control" name="lead_exception_E3[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E3">
												<?php
												$value3 = (isset($contractInfor->expertise_infor->exception3_value[0]) && is_array($contractInfor->expertise_infor->exception3_value[0]) ) ? $contractInfor->expertise_infor->exception3_value[0] : array();
												?>
												<?php foreach (lead_exception_E3() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E3 == $key) ? 'selected' : '' ?> <?= ( is_array($value3) && in_array("$key", $value3)) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception3_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div <?php if (empty($contractInfor->expertise_infor->exception4_value[0])): ?> style="display: none" <?php endif;?> id="exception4">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E4" class="form-control" name="lead_exception_E4[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E4">
												<?php
												$value4 = (isset($contractInfor->expertise_infor->exception4_value[0]) && is_array($contractInfor->expertise_infor->exception4_value[0]) ) ? $contractInfor->expertise_infor->exception4_value[0] : array();
												?>
												<?php foreach (lead_exception_E4() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E4 == $key) ? 'selected' : '' ?> <?= ( is_array($value4) && in_array("$key", $value4)) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception4_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div <?php if (empty($contractInfor->expertise_infor->exception5_value[0])): ?> style="display: none" <?php endif;?> id="exception5">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E5" class="form-control" name="lead_exception_E5[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E5">
												<?php
												$value5 = (isset($contractInfor->expertise_infor->exception5_value[0]) && is_array($contractInfor->expertise_infor->exception5_value[0]) ) ? $contractInfor->expertise_infor->exception5_value[0] : array();
												?>
												<?php foreach (lead_exception_E5() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E5 == $key) ? 'selected' : '' ?> <?= ( is_array($value5) && in_array("$key", $value5)) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception5_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div <?php if (empty($contractInfor->expertise_infor->exception6_value[0])): ?> style="display: none" <?php endif;?> id="exception6">
									<div class="row">
										<div class="col-md-10">
											<select id="lead_exception_E6" class="form-control" name="lead_exception_E6[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E6">
												<?php
												$value6 = (isset($contractInfor->expertise_infor->exception6_value[0]) && is_array($contractInfor->expertise_infor->exception6_value[0]) ) ? $contractInfor->expertise_infor->exception6_value[0] : array();
												?>
												<?php foreach (lead_exception_E6() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E6 == $key) ? 'selected' : '' ?> <?= ( is_array($value6) && in_array("$key", $value6)) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception6_del" class="fa fa-ban text-danger" aria-hidden="true" style="text-align: center"></i>
										</div>
									</div>
								</div>
								<div <?php if (empty($contractInfor->expertise_infor->exception7_value[0])): ?> style="display: none" <?php endif;?> id="exception7">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E7" class="form-control" name="lead_exception_E7[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E7">
												<?php
												$value7 = (isset($contractInfor->expertise_infor->exception7_value[0]) && is_array($contractInfor->expertise_infor->exception7_value[0]) ) ? $contractInfor->expertise_infor->exception7_value[0] : array();
												?>
												<?php foreach (lead_exception_E7() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E7 == $key) ? 'selected' : '' ?> <?= ( is_array($value7) && in_array("$key", $value7)) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception7_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<input id="exception1_value" style="display: none" value="<?= !empty($contractInfor->expertise_infor->exception1_value[0]) ? "[[".implode(',',$contractInfor->expertise_infor->exception1_value[0])."]]" : "" ?>">
								<input id="exception2_value" style="display: none" value="<?= !empty($contractInfor->expertise_infor->exception2_value[0]) ? "[[".implode(',',$contractInfor->expertise_infor->exception2_value[0])."]]" : "" ?>">
								<input id="exception3_value" style="display: none" value="<?= !empty($contractInfor->expertise_infor->exception3_value[0]) ? "[[".implode(',',$contractInfor->expertise_infor->exception3_value[0])."]]" : "" ?>">
								<input id="exception4_value" style="display: none" value="<?= !empty($contractInfor->expertise_infor->exception4_value[0]) ? "[[".implode(',',$contractInfor->expertise_infor->exception4_value[0])."]]" : "" ?>">
								<input id="exception5_value" style="display: none" value="<?= !empty($contractInfor->expertise_infor->exception5_value[0]) ? "[[".implode(',',$contractInfor->expertise_infor->exception5_value[0])."]]" : "" ?>">
								<input id="exception6_value" style="display: none" value="<?= !empty($contractInfor->expertise_infor->exception6_value[0]) ? "[[".implode(',',$contractInfor->expertise_infor->exception6_value[0])."]]" : "" ?>">
								<input id="exception7_value" style="display: none" value="<?= !empty($contractInfor->expertise_infor->exception7_value[0]) ? "[[".implode(',',$contractInfor->expertise_infor->exception7_value[0])."]]" : "" ?>">
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>


		</div>


		<?php if (($contractInfor->loan_infor->type_loan->code == "CC")): ?>
			<div class="table-responsive" style="width:45%;border:0 " id="giu_xe" >
				<table class="table table-bordered ">
					<thead>
					<th >Nơi cất giữ xe</th>
					</thead>
					<tbody>
					<tr>
						<td class="error_messages">
							<select class="form-control" name="car_storage" id="car_storage" style="width:100%;border:0" >
								<option value="">-- Nơi cất giữ xe --</option>
								<?php !empty($list_storage) ? $list_storage : ''; ?>
								<?php !empty($contractInfor->expertise_infor->car_storage) ? $contractInfor->expertise_infor->car_storage : ''; ?>
								<?php foreach ($list_storage as $key => $item): ?>
									<option value="<?php echo $item->storage_address ?>" <?php if ($item->storage_address == $contractInfor->expertise_infor->car_storage): ?>
										selected <?php endif; ?>><?php echo $item->storage_address ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="messages"></p>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<div class="table-responsive" style="width:45%;border:0; display: none " id="giu_xe" >
				<table class="table table-bordered ">
					<thead>
					<th >Nơi cất giữ xe</th>
					</thead>
					<tbody>
					<tr>
						<td class="error_messages">
							<select class="form-control" name="car_storage" id="car_storage" style="display: none; width:100%;border:0" >
								<option value="">-- Nơi cất giữ xe --</option>
								<?php !empty($list_storage) ? $list_storage : ''; ?>
								<?php !empty($contractInfor->expertise_infor->car_storage) ? $contractInfor->expertise_infor->car_storage : ''; ?>
								<?php foreach ($list_storage as $key => $item): ?>
									<option value="<?php echo $item->storage_address ?>" <?php if ($item->storage_address == $contractInfor->expertise_infor->car_storage): ?>
										selected <?php endif; ?>><?php echo $item->storage_address ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="messages"></p>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		<?php endif; ?>

		<hr class="mt-0">

		<div class="row">

			<div class="col-xs-12 text-right">

				<button class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>
				<button class="btn btn-danger backBtn pull-right" type="button">Back</button>

			</div>
		</div>


	</div>
</div>

<script>
	$(document).ready(function () {

		$('#change_exception').change(function (event) {
			event.preventDefault();
			console.log("xxxx");
			var change_exception = $('#change_exception').val();
			if (change_exception == "E1") {
				$('#exception1').show();
			} else if (change_exception == "E2") {
				$('#exception2').show();
			} else if (change_exception == "E3") {
				$('#exception3').show();
			} else if (change_exception == "E4") {
				$('#exception4').show();
			} else if (change_exception == "E5") {
				$('#exception5').show();
			} else if (change_exception == "E6") {
				$('#exception6').show();
			} else if (change_exception == "E7") {
				$('#exception7').show();
			}
		})

	});

	$('[name="lead_exception_E1[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#lead_exception_E1').val()
		var data1 = [];
		if (value != null) {
			data1.push(value);
		}
		$('#exception1_value').val(JSON.stringify(data1));
	})
	$('[name="lead_exception_E2[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#lead_exception_E2').val()
		var data2 = [];
		if (value != null) {
			data2.push(value);
		}
		$('#exception2_value').val(JSON.stringify(data2));
	})
	$('[name="lead_exception_E3[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#lead_exception_E3').val()
		var data3 = [];
		if (value != null) {
			data3.push(value);
		}
		$('#exception3_value').val(JSON.stringify(data3));
	})
	$('[name="lead_exception_E4[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#lead_exception_E4').val()
		var data4 = [];
		if (value != null) {
			data4.push(value);
		}
		$('#exception4_value').val(JSON.stringify(data4));
	})
	$('[name="lead_exception_E5[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#lead_exception_E5').val()
		var data5 = [];
		if (value != null) {
			data5.push(value);
		}
		$('#exception5_value').val(JSON.stringify(data5));
	})
	$('[name="lead_exception_E6[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#lead_exception_E6').val()
		var data6 = [];
		if (value != null) {
			data6.push(value);
		}
		$('#exception6_value').val(JSON.stringify(data6));
	})
	$('[name="lead_exception_E7[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#lead_exception_E7').val()
		var data7 = [];
		if (value != null) {
			data7.push(value);
		}
		$('#exception7_value').val(JSON.stringify(data7));
	})


	$('#lead_exception_E1').selectize({
		create: false,
		valueField: 'lead_exception_E1',
		labelField: 'name1',
		searchField: 'name1',
		maxItems: 10,
		sortField: {
			field: 'name',
			direction: 'asc'
		}

	});
	$('#lead_exception_E2').selectize({
		create: false,
		valueField: 'lead_exception_E2',
		labelField: 'name2',
		searchField: 'name2',
		maxItems: 10,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#lead_exception_E3').selectize({
		create: false,
		valueField: 'lead_exception_3',
		labelField: 'name3',
		searchField: 'name3',
		maxItems: 10,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#lead_exception_E4').selectize({
		create: false,
		valueField: 'lead_exception_E4',
		labelField: 'name4',
		searchField: 'name4',
		maxItems: 10,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#lead_exception_E5').selectize({
		create: false,
		valueField: 'lead_exception_E5',
		labelField: 'name5',
		searchField: 'name5',
		maxItems: 10,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#lead_exception_E6').selectize({
		create: false,
		valueField: 'lead_exception_E6',
		labelField: 'name6',
		searchField: 'name1',
		maxItems: 10,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('#lead_exception_E7').selectize({
		create: false,
		valueField: 'lead_exception_E7',
		labelField: 'name7',
		searchField: 'name7',
		maxItems: 10,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});

	$(document).ready(function () {

		$('#exception1_del').click(function (event) {
			event.preventDefault();
			$('#exception1').hide();
			$('#lead_exception_E1')[0].selectize.clear();
		});
		$('#exception2_del').click(function (event) {
			event.preventDefault();
			$('#exception2').hide();
			$('#lead_exception_E2')[0].selectize.clear();
		});
		$('#exception3_del').click(function (event) {
			event.preventDefault();
			$('#exception3').hide();
			$('#lead_exception_E3')[0].selectize.clear();
		});
		$('#exception4_del').click(function (event) {
			event.preventDefault();
			$('#exception4').hide();
			$('#lead_exception_E4')[0].selectize.clear();
		});
		$('#exception5_del').click(function (event) {
			event.preventDefault();
			$('#exception5').hide();
			$('#lead_exception_E5')[0].selectize.clear();
		});
		$('#exception6_del').click(function (event) {
			event.preventDefault();
			$('#exception6').hide();
			$('#lead_exception_E6')[0].selectize.clear();
		});
		$('#exception7_del').click(function (event) {
			event.preventDefault();
			$('#exception7').hide();
			$('#lead_exception_E7')[0].selectize.clear();
		});
	});

	$('#company_debt').on('input', function (e) {
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
	}).on('keypress', function (e) {
		if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function (e) {
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});
	$('#company_out_of_date').on('input', function (e) {
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
	}).on('keypress', function (e) {
		if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function (e) {
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});
</script>
