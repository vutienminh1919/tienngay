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
							<select class="form-control" id="stores" style="width:100%;border:0">
								<?php
								foreach($stores as $key =>  $value){
									if($value->status !='active')
										continue;
									?>
									<option data-phone="<?= !empty($value->phone) ? $value->phone : ""?>" data-address="<?= !empty($value->address) ? $value->address : ""?>" data-code-address="<?= !empty($value->code_address_store) ? $value->code_address_store : ""?>" value="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""?>" <?= ($lead_info->id_PDG && $lead_info->id_PDG==$value->_id->{'$oid'}) ? 'selected' : ''; ?>  ><?= !empty($value->name) ? $value->name : ""?></option>
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
<div class="table-responsive">
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
							<input type="text" name="name_company" id="name_company" value="<?= $lead_info->com ? $lead_info->com : "" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="address_company" id="address_company" value="<?= $lead_info->com_address ? $lead_info->com_address : "" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="phone_number_company" id="phone_number_company" value="" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select class="form-control" id="job_position" style="width:100%;border:0">
								<option value="Mới tốt nghiệp">Mới tốt nghiệp</option>
								<option value="Nhân viên /Chuyên viên">Nhân viên /Chuyên viên</option>
								<option value="Chuyên viên chính">Chuyên viên chính</option>
								<option value="Chuyên viên cao cấp">Chuyên viên cao cấp</option>
								<option value="Trưởng nhóm/Giám sát">Trưởng nhóm/Giám sát</option>
								<option value="Trưởng phòng">Trưởng phòng</option>
								<option value="Giám đốc và cấp cao hơn">Giám đốc và cấp cao hơn</option>
								<option value="Không">Không</option>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<input type="text" name="salary" id="salary" value="<?= $lead_info->income ? $lead_info->income : "0" ?>" style="width:100%;border:0" placeholder="">
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<?php $salary_pay = ($lead_info->salary_pay) ? $lead_info->salary_pay : ''; ?>
							<select class="form-control" id="receive_salary_via" style="width:100%;border:0">
								<option value="1" <?= ($salary_pay == '1') ? "selected" : "" ?> >Tiền mặt</option>
								<option value="2" <?= ($salary_pay == '2') ? "selected" : "" ?> >Chuyển khoản</option>
							</select>
							<p class="messages"></p>
						</td>
						<td class="error_messages">
							<select style="width:100%;border:0" class="form-control" id="job">
								<?php
								$job = status_job();
								foreach ($job as $key => $value) {
									?>
									<option value="<?php echo $value ?>"><?php echo $value ?></option>
								<?php } ?>
							</select>
							<p class="messages"></p>
						</td>

					</tr>

					</tbody>
				</table>
</div>
			</div>

			<div class="col-xs-12">
				<p>
					<strong>Thông tin tham chiếu:</strong>
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
							<th scope="row"  style="text-align: center">1</th>
							<td class="error_messages">
								<input type="text" name="fullname_relative_1" id="fullname_relative_1" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages" >
								<select class="form-control" id="type_relative_1" style="width:100%;border:0">
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
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="phone_number_relative_1" id="phone_number_relative_1" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="hoursehold_relative_1" id="hoursehold_relative_1" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<textarea type="text" name="confirm_relativeInfor1" id="confirm_relativeInfor1"  style="width:100%;border:0" placeholder=""></textarea>
								<p class="messages"></p>
							</td>
						</tr>
						<tr>
							<th scope="row"  style="text-align: center">2</th>
							<td class="error_messages">
								<input type="text" name="fullname_relative_2" id="fullname_relative_2" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="type_relative_2" style="width:100%;border:0">
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
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="phone_number_relative_2" id="phone_number_relative_2" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="hoursehold_relative_2" id="hoursehold_relative_2" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<textarea type="text" name="confirm_relativeInfor2" id="confirm_relativeInfor2"  style="width:100%;border:0" placeholder=""></textarea>
								<p class="messages"></p>
							</td>
						</tr>
						<tr>
							<th scope="row"  style="text-align: center">3</th>
							<td >
								<input type="text" name="fullname_relative_3" id="fullname_relative_3" value="" style="width:100%;border:0" placeholder="">

							</td>
							<td>
								<select class="form-control" id="type_relative_3" style="width:100%;border:0">
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

							</td>
							<td >
								<input type="text" name="phone_number_relative_3" id="phone_number_relative_3" value="" style="width:100%;border:0" placeholder="">
							</td>
							<td >
								<input type="text" name="hoursehold_relative_3" id="hoursehold_relative_3" value="" style="width:100%;border:0" placeholder="">

							</td>
							<td>
								<textarea type="text" name="confirm_relativeInfor3" id="confirm_relativeInfor3" style="width:100%;border:0" placeholder=""></textarea>
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

				<div class="table-responsive" >
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
									<option value="2">Tài khoản ngân hàng</option>
									<option value="3">Thẻ atm</option>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="selectize_bank_vimo" style="width:100%;border:0">
									<?php
									if (!empty($bankNganluongData)) {
										foreach ($bankNganluongData as $key => $bank) {
											if ($bank->status == "deactive") {
												continue;
											}
											?>
											<option value="<?= !empty($bank->bank_id) ? $bank->bank_id : ""; ?>"><?= !empty($bank->name) ? $bank->name : ""; ?>
												( <?= !empty($bank->short_name) ? $bank->short_name : ""; ?> )
											</option>
										<?php }
									} ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="bank_branch" id="bank_branch" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="bank_account" id="bank_account" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="bank_account_holder" id="bank_account_holder" value="" style="width:100%;border:0" placeholder="" >
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="atm_card_number" id="atm_card_number" value="" style="width:100%;border:0" placeholder="" disabled>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="atm_card_holder" id="atm_card_holder" value="" style="width:100%;border:0" placeholder="" disabled>
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
<div class="table-responsive">
				<?php
				$type_finance = ($lead_info->type_finance) ? $lead_info->type_finance : '';

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
								<input type="text" name="money" id="money" value="0" style="width:100%;border:0" placeholder="" >
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control" id="loan_purpose" style="width:100%;border:0">
									<option value="Tiêu dùng cá nhân">Tiêu dùng cá nhân</option>
									<option value="Đóng học phí">Đóng học phí</option>
									<option value="Đóng viện phí">Đóng viện phí</option>
									<option value="Du lịch">Du lịch</option>
									<option value="Kinh doanh">Kinh doanh</option>
									<option value="Mua đồ điện tử">Mua đồ điện tử</option>
									<option value="Mua đồ nội thất"> Mua đồ nội thất</option>
									<option value="Mua xe máy"> Mua xe máy</option>
									<option value="Sửa chữa nhà ở">Sửa chữa nhà ở</option>
									<option value="Các mục đich khác không vi phạm Quy định của pháp luật">Các mục đich khác không vi
										phạm Quy định của pháp luật
									</option>
									<option value="Vay bổ sung vốn kinh doanh Online" id="kdol_v" hidden>Vay bổ sung vốn kinh doanh Online</option>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select class="form-control " id="number_day_loan" style="width:100%;border:0">
									<option value="">-- Chọn thời gian vay --</option>
									<option id="number_day_loan_motobike" value="1" <?= ($lead_info->loan_time && $lead_info->loan_time == 1) ? "selected" : ''; ?> >1
										tháng
									</option>
									<option value="3" <?= ($lead_info->loan_time && $lead_info->loan_time == 3) ? "selected" : ''; ?>>3
										tháng
									</option>
									<option value="6" <?= ($lead_info->loan_time && $lead_info->loan_time == 6) ? "selected" : ''; ?>>6
										tháng
									</option>
									<option value="9" <?= ($lead_info->loan_time && $lead_info->loan_time == 9) ? "selected" : ''; ?>>9
										tháng
									</option>
									<option value="12" <?= ($lead_info->loan_time && $lead_info->loan_time == 12) ? "selected" : ''; ?>>
										12 tháng
									</option>
									<option value="18" <?= ($lead_info->loan_time && $lead_info->loan_time == 18) ? "selected" : ''; ?>>
										18 tháng
									</option>
									<option value="24" <?= ($lead_info->loan_time && $lead_info->loan_time == 24) ? "selected" : ''; ?>>
										24 tháng
									</option>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<?php $type_repay = ($lead_info->type_repay) ? $lead_info->type_repay : ''; ?>
								<select class="form-control" id="type_interest" style="width:100%;border:0">
									<option value="">-- Chọn hình thức trả lãi --</option>
									<option value="1" <?= ($type_repay == '1') ? "selected" : "" ?>><?= $this->lang->line('Outstanding_descending') ?></option>
									<option id="type_interest_motobike" value="2" <?= ($type_repay == '2') ? "selected" : "" ?>><?= $this->lang->line('Monthly_interest_principal_maturity') ?></option>
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

				<div class="table-responsive">
					<table class="table table-bordered ">
						<thead>
						<tr>
							<th scope="col" style="text-align: center">Bảo hiểm khoản vay &nbsp;&nbsp;&nbsp;	<input name='insurrance' value="1" checked id="insurrance" type="checkbox"></th>
							<th scope="col" style="text-align: center">Bảo hiểm xe máy(easy) GIC</th>
							<th scope="col" style="text-align: center">Bảo hiểm phúc lộc thọ</th>
							<th scope="col" style="text-align: center">Bảo hiểm VBI</th>
							<th scope="col" style="text-align: center">Chương trình ưu đãi</th>
							<th scope="col" style="text-align: center" >Ghi chú</th>

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
										if ($province_id_store == '01' && $key == '1') continue;
										if ($province_id_store != '01' && $key == '2') continue;
										// if( $key=='2') continue;
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
										<option <?php echo $plt == $item ? 'selected' : '' ?> value="<?= $key ?>"><?= $item ?></option>
									<?php } ?>
								</select>
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<select id="selectize_vbi" class="form-control" name="code_vbi[]" multiple="multiple" data-placeholder="Chọn bảo hiểm VBI" style="width:100%;border:0">
									<?php foreach (lead_VBI() as $key => $item) { ?>
										<option value="<?= $key ?>" <?= ($lead_VBI == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
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
								<textarea type="text" id="note" required class="form-control" style="width:100%;border:0"></textarea>
								<p class="messages"></p>
							</td>

						</tr>
						<tr>
							<td>
								<input type="text" id="fee_gic" class="form-control number" value="0" disabled>
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
								<input type="text" id="fee_vbi" class="form-control number" value="0" disabled>
								<input type="text" id="fee_vbi1" class="form-control number" value="0" style="display: none">
								<input type="text" id="fee_vbi2" class="form-control number" value="0" style="display: none">
								<input type="text" id="code_VBI_1" class="form-control number"  style="display: none">
								<input type="text" id="code_VBI_2" class="form-control number"  style="display: none">
								<input type="text" id="maVBI_1" class="form-control number" value="0" style="display: none">
								<input type="text" id="maVBI_2" class="form-control number" value="0" style="display: none">
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
						</tr>
						</thead>
						<tbody>
						<tr class="properties_b">
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
							<th scope="col" style="text-align: center">Tên tổ chức vay </th>
							<th scope="col" style="text-align: center">Gốc còn lại </th>
							<th scope="col" style="text-align: center">Đã tất toán </th>
							<th scope="col" style="text-align: center">Tiền phải trả hàng kỳ </th>
							<th scope="col" style="text-align: center">Tiền quá hạn </th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="error_messages">
								<input type="text" name="company_name" id="company_name" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="company_debt" id="company_debt" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="company_finalization" id="company_finalization" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="company_borrowing" id="company_borrowing" value="" style="width:100%;border:0" placeholder="">
								<p class="messages"></p>
							</td>
							<td class="error_messages">
								<input type="text" name="company_out_of_date" id="company_out_of_date" value="" style="width:100%;border:0" placeholder="">
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
						<tr  class="hidden-md hidden-lg">
							<th >Thẩm định hồ sơ <span class="text-danger">*</span></th>
						</tr>
						<tr >
							<th class="hidden-xs hidden-sm" >Thẩm định hồ sơ <span class="text-danger">*</span></th>
							<td class="error_messages" colspan="2">
								<textarea type="text" name="expertise_file" id="expertise_file"  style="width:100%;border:0" placeholder="" ></textarea>
								<p class="messages"></p>
							</td>
						</tr>
						<tr  class="hidden-md hidden-lg">
							<th >Thẩm định thực địa <span class="text-danger">*</span></th>
						</tr>
						<tr>
							<th class="hidden-xs hidden-sm">Thẩm định thực địa <span class="text-danger">*</span></th>
							<td class="error_messages" colspan="2">
								<textarea type="text" name="expertise_field" id="expertise_field"  style="width:100%;border:0" placeholder="" ></textarea>
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

				<div  class="hidden-xs hidden-sm" >
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
								<div style="display: none" id="exception1">
									<div class="row">
										<div class="col-md-10">
											<select   id="lead_exception_E1" class="form-control" name="lead_exception_E1[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E1" >
												<?php foreach (lead_exception_E1() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E1 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception1_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>

								</div>
								<div style="display: none" id="exception2">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E2" class="form-control" name="lead_exception_E2[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E2">
												<?php foreach (lead_exception_E2() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E2 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception2_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception3">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E3" class="form-control" name="lead_exception_E3[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E3">
												<?php foreach (lead_exception_E3() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E3 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception3_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception4">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E4" class="form-control" name="lead_exception_E4[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E4">
												<?php foreach (lead_exception_E4() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E4 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception4_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception5">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E5" class="form-control" name="lead_exception_E5[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E5">
												<?php foreach (lead_exception_E5() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E5 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception5_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception6">
									<div class="row">
										<div class="col-md-10">
											<select id="lead_exception_E6" class="form-control" name="lead_exception_E6[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E6">
												<?php foreach (lead_exception_E6() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E6 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception6_del" class="fa fa-ban text-danger" aria-hidden="true" style="text-align: center"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception7">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E7" class="form-control" name="lead_exception_E7[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E7">
												<?php foreach (lead_exception_E7() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E7 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception7_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<input id="exception1_value" style="display: none">
								<input id="exception2_value" style="display: none">
								<input id="exception3_value" style="display: none">
								<input id="exception4_value" style="display: none">
								<input id="exception5_value" style="display: none">
								<input id="exception6_value" style="display: none">
								<input id="exception7_value" style="display: none">
							</td>
						</tr>
						</tbody>
					</table>
				</div>

				<div  class="hidden-md hidden-lg" >
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

						</tr>
						<tr>
							<td>
								<div style="display: none" id="exception1">
									<div class="row">
										<div class="col-md-10">
											<select   id="lead_exception_E1" class="form-control" name="lead_exception_E1[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E1" >
												<?php foreach (lead_exception_E1() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E1 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception1_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>

								</div>
								<div style="display: none" id="exception2">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E2" class="form-control" name="lead_exception_E2[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E2">
												<?php foreach (lead_exception_E2() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E2 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception2_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception3">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E3" class="form-control" name="lead_exception_E3[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E3">
												<?php foreach (lead_exception_E3() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E3 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception3_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception4">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E4" class="form-control" name="lead_exception_E4[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E4">
												<?php foreach (lead_exception_E4() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E4 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception4_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception5">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E5" class="form-control" name="lead_exception_E5[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E5">
												<?php foreach (lead_exception_E5() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E5 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception5_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception6">
									<div class="row">
										<div class="col-md-10">
											<select id="lead_exception_E6" class="form-control" name="lead_exception_E6[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E6">
												<?php foreach (lead_exception_E6() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E6 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception6_del" class="fa fa-ban text-danger" aria-hidden="true" style="text-align: center"></i>
										</div>
									</div>
								</div>
								<div style="display: none" id="exception7">
									<div class="row">
										<div class="col-md-10">
											<select  id="lead_exception_E7" class="form-control" name="lead_exception_E7[]" multiple="multiple" data-placeholder="Các lý do ngoại lệ E7">
												<?php foreach (lead_exception_E7() as $key => $item) { ?>
													<option value="<?= $key ?>" <?= ($lead_exception_E7 == $key) ? 'selected' : '' ?>><?= $item ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-2">
											<i id="exception7_del" class="fa fa-ban text-danger" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								<input id="exception1_value" style="display: none">
								<input id="exception2_value" style="display: none">
								<input id="exception3_value" style="display: none">
								<input id="exception4_value" style="display: none">
								<input id="exception5_value" style="display: none">
								<input id="exception6_value" style="display: none">
								<input id="exception7_value" style="display: none">
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>


		</div>



		<div class="table-responsive" style="width:45%;border:0 ; display: none" id="giu_xe" >
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
							<?php foreach ($list_storage as $key => $item): ?>
								<option value="<?php echo $item->storage_address ?>"><?php echo $item->storage_address ?></option>
							<?php endforeach; ?>
						</select>
						<p class="messages"></p>
					</td>
				</tr>
				</tbody>
			</table>
		</div>


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
