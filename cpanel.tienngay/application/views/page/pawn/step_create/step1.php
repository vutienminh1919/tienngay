<div class="x_panel setup-content" id="step-1">
    <div class="x_content">
        <div class="x_title">
            <strong><i class="fa fa-user" aria-hidden="true"></i> So khớp CMTND và chân dung</strong>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân, Hộ chiếu (Ảnh có định dạng "jpeg", "png", "jpg", dung lượng < 2MB)</p>
            <div class="row">
                <div class="col-xs-12 col-md-4 text-left">
                    <div>
                        <img id="imgImg_mattruoc" class="w-100" style="max-width: 350px; max-height: 250px;" src="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" alt="">
                        <p>Mặt trước CMT</p>
                        <input type="file" id="input_cmt_search" data-preview="imgInp001" style="visibility: hidden;">
                    </div>
                    <div class="text-left">
                        <strong>Ảnh giấy tờ tuỳ thân:</strong>
                        <ul>
                            <li>Mặt trước rõ, đủ 4 góc.</li>

                            <li>Không chụp giấy tờ tuỳ thân photo, chụp thông qua màn hình thiết bị điện tử.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 text-left">
                    <img id="imgImg_matsau" class="w-100" style="max-width: 350px; max-height: 250px;" src="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" alt="">
                    <p>Mặt sau CMT</p>
                    <input type='file' id="imgInp_Face" data-preview="imgInp002" style="visibility: hidden;">
                </div>
                <div class="col-xs-12 col-md-4 text-left">
                    <img id="imgImg_chandung" class="w-100" style="max-width: 350px; max-height: 250px;" src="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" alt="">
                    <p>Ảnh chân dung</p>
                    <input type='file' id="imgInp_Identify" data-preview="imgInp002" style="visibility: hidden;"  />
                    <div class="">
                        <strong>  Ảnh chân dung chụp:</strong>
                        <ul>
                            <li>Chụp cận mặt, rõ, thẳng góc, không bị che, không chụp quá xa.</li>
                            <li>Không chụp chân dung từ ảnh, chụp thông qua màn hình thiết bị điện tử.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <p><b>Bước 1:</b> Upload 3 ảnh mặt trước + mặt sau CMT, ảnh chân dung</p>
<!--                <p><b>Bước 2:</b> Click vào nút <b>Kiểm trả blacklist</b></p>-->
                <p><b>Bước 2:</b> Click vào nút <b>Nhận dạng</b> để so khớp chân dung</p>
                <small>Lưu ý: Bằng cách tải lên các ảnh, tệp ở đây, bạn đồng ý để chúng được lưu trữ tạm thời trong tập dữ liệu đào tạo của chúng tôi cho mục đích duy nhất là cải thiện công nghệ của Computer Vision Việt Nam.</small>
            </div>
            <div class="clearfix"></div>
            <br><br>
            <p></p>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-danger return_Face_Identify">Chọn lại</button>
<!--                    <button type="button" class="btn btn-primary identification_Face_search">Kiểm tra blacklist</button>-->
                    <button type="button" class="btn btn-primary identification_Face_Identify">Nhận dạng</button>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 alert alert-success alert-dismissible text-center">
                </div>
            </div>
            <div class="row">
                <h1 class="text-center text-primary face_identify_results" ></h1>
            </div>
            <table class="table table-bordered" style="white-space: normal">
                <tbody id='list_info_Face_search'>

                </tbody>
            </table>
            <div id="cvs_customer_info" class="row" style="display: none;">
                <div class="col-md-12">
                    <h4>Thông tin khách hàng</h4>
                    <div class="text-center" id="Identify_loading" style="display: none;">
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                        <div >Đang xử lý...</div>
                    </div>
                    <table class="table table-bordered">
                        <tbody id='list_info_Identify'>

                        </tbody>
                    </table>
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary apply_info_Identify">Áp dụng</button>
                    </div>
                </div>
            </div>
            <input type="text" hidden id="idLead_Identify" value="<?php echo $id_lead ?>">
            <input type="text" hidden id="idContract_Identify" value="<?php echo $id_contract ?>">
            <input type="hidden" hidden id="isBlacklist" value="2">
        </div>
        <div class="x_title">
            <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Customer_information')?></strong>
            <div class="clearfix"></div>
        </div>
        <!-- <input type="date" name="DateName" id="DateID" min="2000-01-01" max="2100-12-31"/> -->
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Customer_information')?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="radio-inline text-primary">
                    <label>  <input type="radio" value="1" name="status_customer" checked><?= $this->lang->line('new_customer')?></label>
                </div>
                <div class="radio-inline text-danger">
                    <label><input type="radio" value="2" name="status_customer"><?= $this->lang->line('Old_customer')?></label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Customer_name')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="customer_name" value="<?= !empty($lead_info->fullname) ? $lead_info->fullname : "" ?>" required class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('phone_number')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                $id_lead_get=(isset($_GET['id_lead'])) ? $_GET['id_lead'] : '';
                if(isset($lead_info->phone_number)){ ?>
                    <input type="text" required value="<?= !empty($lead_info->phone_number) ? hide_phone($lead_info->phone_number) : "" ?>" class="form-control phone-autocomplete customer_phone_number" >
                    <input type="hidden" required id="customer_phone_number"  value="<?= !empty($lead_info->phone_number) ? ($lead_info->phone_number) : "" ?>" class="form-control phone-autocomplete" >
                    <input type="hidden" id="id_lead"  class="form-control" value="<?= !empty($lead_info->_id->{'$oid'}) ? $lead_info->_id->{'$oid'} : $id_lead_get ?>">
                <?php }else{ ?>
                     <input type="hidden" id="id_lead"  class="form-control" value="">
                    <input type="text"  required id="customer_phone_number" value="" class="form-control phone-autocomplete" >
                <?php } ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox-inline ">
                    <label><input name='check_phone' value="1" type="checkbox">
                        &nbsp;
                        Hợp đồng liên quan
                    </label>
                </div>

            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Email <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="email" required id="customer_email" value="<?= !empty($lead_info->email) ? $lead_info->email : "" ?>" class="form-control email-autocomplete">
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('identify_current')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" maxlength="12" required id="customer_identify" class="form-control identify-autocomplete" value="<?= !empty($lead_info->identify_lead) ? $lead_info->identify_lead : "" ?>">
            </div>
        </div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('date_range')?><span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="date" required id="date_range" class="form-control" min="1940-12-31" max="2100-12-31">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('issued_by')?><span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" required id="issued_by" class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('identify_old')?>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" maxlength="12" id="customer_identify_old" class="form-control identify-old-autocomplete">
			</div>
		</div>
		<hr>

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Số hộ chiếu:
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" minlength="8" maxlength="12" required id="passport_number" class="form-control" value="">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Nơi cấp hộ chiếu:
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" required id="passport_address" class="form-control" value="">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Ngày cấp hộ chiếu:
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="date" required id="passport_date" class="form-control" value="">
			</div>
		</div>


		<hr>
<!--		<div class="form-group row">-->
<!--			<label class="control-label col-md-3 col-sm-3 col-xs-12">-->
<!--				Nguồn khách hàng <span class="text-danger">*</span>-->
<!--			</label>-->
<!--			<div class="col-md-6 col-sm-6 col-xs-12">-->
<!--				<select class="form-control" id="customer_resources">-->
<!--					--><?php //if(!isset($lead_info)){ ?>
<!--						<option value="hoiso" >KH từ hội sở</option>-->
<!--						<option value="tukiem">KH Tự Kiếm</option>-->
<!--						<option value="vanglai">KH Vãng Lai</option>-->
<!--					--><?php //}else{ ?>
<!--						<option value="hoiso" >KH từ hội sở</option>-->
<!--					--><?php //} ?>
<!--				</select>-->
<!--			</div>-->
<!--		</div>-->
		<?php if(!empty($lead_info->source)){
			$check_source = $lead_info->source;
		} else {
			$check_source = 0;
		}
		?>
		<?php if (!empty($store_digital) && $store_digital == 1) : ?>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Chọn loại hợp đồng KH muốn ký <span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="radio-inline text-primary">
					<label><input type="radio" value="1" name="type_contract_sign" id="choose_contract_digital" checked>Hợp đồng điện tử</label>
				</div>
				<div class="radio-inline text-danger">
					<label><input type="radio" value="2" name="type_contract_sign" id="choose_contract_paper">Hợp đồng bản giấy</label>
				</div>
			</div>
		</div>
			<div class="form-group row" id="receive_notifi_sign">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Chọn hình thức nhận thông báo ký số hợp đồng điện tử <span class="text-danger">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="radio-inline text-primary">
						<label><input type="radio" value="1" name="status_email" checked>Nhận thông báo qua Email</label>
					</div>
					<div class="radio-inline text-danger">
						<label><input type="radio" value="2" name="status_email">Nhận thông báo qua tin nhắn SMS</label>
					</div>
				</div>
			</div>
		<?php endif;?>
		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Nguồn khách hàng <span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<select class="form-control" id="customer_resources" <?= (!empty($check_source) && $check_source != 0) ? "disabled" : "" ?>>
						<option value="1" <?= ($check_source == "1") ? "selected" : "" ?> >Digital</option>
						<option value="2" <?= ($check_source == "2") ? "selected" : "" ?> >TLS Tự kiếm</option>
						<option value="3" <?= ($check_source == "3") ? "selected" : "" ?> >Tổng đài</option>
						<option value="4" <?= ($check_source == "4") ? "selected" : "" ?> >Giới thiệu</option>
						<option value="5" <?= ($check_source == "5") ? "selected" : "" ?> >Đối tác</option>
						<option value="6" <?= ($check_source == "6") ? "selected" : "" ?> >Fanpage</option>
						<option value="7" <?= ($check_source == "7") ? "selected" : "" ?> >Nguồn khác</option>
						<option value="12" <?= ($check_source == "12") ? "selected" : "" ?> >Nguồn App Mobile</option>
						<option value="8" <?= ($check_source == "8") ? "selected" : "" ?> >KH vãng lai</option>
						<option value="9" <?= ($check_source == "9") ? "selected" : "" ?> >KH tự kiếm</option>
						<option value="10" <?= $check_source == "10" ? "selected" : "" ?> >Cộng tác viên</option>
						<option value="11" <?= ($check_source == "11") ? "selected" : "" ?> >KH giới thiệu KH</option>
						<option value="VM" <?= ($check_source == "VM") ? "selected" : "" ?> >Nguồn vay mượn</option>
						<option value="VPS" <?= ($check_source == "VPS") ? "selected" : "" ?> >Nguồn VPS</option>
						<option value="MB" <?= ($check_source == "MB") ? "selected" : "" ?> >Nguồn MB</option>
						<option value="14" <?= ($check_source == "14") ? "selected" : "" ?> >Tool FB</option>
						<option value="15" <?= ($check_source == "15") ? "selected" : "" ?> >Tiktok</option>
						<option value="16" <?= ($check_source == "16") ? "selected" : "" ?> >Remarketing</option>
						<option value="Homedy" <?= ($check_source == "Homedy") ? "selected" : "" ?> >Homedy</option>
						<option value="Merchant" <?= ($check_source == "Merchant") ? "selected" : "" ?> >Nguồn Merchant</option>
						<option value="17" <?= ($check_source == "17") ? "selected" : "" ?> >Nguồn ngoài</option>
				</select>
			</div>
		</div>

		<div id="show_hide_presenter" <?= $lead_info->source == 11 ? "" : "style='display: none'" ?>>
			<br><br>
		<div class="x_title">
			<strong><i class="fa fa-user" aria-hidden="true"></i>Thông tin KH giới thiệu</strong>
			<div class="clearfix"></div>
		</div>

			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Họ và tên:<span class="text-danger">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" required id="presenter_name" class="form-control" value="<?= !empty($lead_info->presenter_name) ? $lead_info->presenter_name : "" ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Số điện thoại:<span class="text-danger">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" required id="customer_phone_introduce" class="form-control" value="<?= !empty($lead_info->customer_phone_introduce) ? $lead_info->customer_phone_introduce : "" ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Ngân hàng:<span class="text-danger">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" required id="presenter_bank" class="form-control" value="<?= !empty($lead_info->presenter_bank) ? $lead_info->presenter_bank : "" ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Số tài khoản:<span class="text-danger">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" required id="presenter_stk" class="form-control" value="<?= !empty($lead_info->presenter_stk) ? $lead_info->presenter_stk : "" ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					CMND/CCCD/CMT cũ:<span class="text-danger">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" required id="presenter_cmt" class="form-control" value="<?= !empty($lead_info->presenter_cmt) ? $lead_info->presenter_cmt : "" ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">
					Upload ảnh CMT:<span class="text-danger">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">

					<div id="SomeThing" class="simpleUploader">
						<div class="uploads" id="uploads_presenter_cmt">
						</div>
						<label for="uploadinput">
							<div class="block uploader">
								<span>+</span>
							</div>
						</label>
						<input id="uploadinput" type="file" name="file"
							   data-contain="uploads_presenter_cmt" data-title="Hồ sơ nhân thân" multiple
							   data-type="cmt" class="focus">
					</div>
				</div>
			</div>
			<hr>
		</div>


		<div class="form-group row" style="display: none" id="list_ctv_hide">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Cộng tác viên <span class="text-danger"></span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<select class="form-control" name="list_ctv" id="list_ctv">
					<option value="">-- Chọn cộng tác viên --</option>
					<?php !empty($list_ctv) ? $list_ctv : ''; ?>
					<?php foreach ($list_ctv as $key => $value): ?>
						<option value="<?php echo $value->ctv_code ?>"><?php echo $value->ctv_code. " - " .$value->ctv_name ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>


		<div class="form-group row">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="checkbox-inline ">
					<label><input name='check_customer_identify' value="1" type="checkbox">
						&nbsp;
						Hợp đồng liên quan
					</label>
				</div>
			</div>
		</div>


        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Sex')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="radio-inline text-primary">
                    <label><input name='customer_gender' id="has_gender" value="1" checked type="radio">&nbsp;<?= $this->lang->line('male')?></label>
                </div>
                <div class="radio-inline text-danger">
                    <label><input name='customer_gender' id="no_gender" value="2" type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Birthday')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!-- <div class="input-group date" id="myDatepicker1"> -->
                <input type="date" id="customer_BOD" type='text' class="form-control"  max="2100-12-31" min="1900-01-01" value="<?= !empty($lead_info->dob_lead) ? $lead_info->dob_lead : "" ?>"/>
                <!-- <input id="customer_BOD" type='date' min='1960-01-01' max='2002-30-12'> -->
                <!-- <input type="text" class="form-control">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span> -->
                <!-- </div> -->
                <!-- <script>
                $('#myDatepicker1').datetimepicker({format: 'DD-MM-YYYY'});
                </script> -->
            </div>
        </div>



        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Marital_status')?><span class="text-danger">*</span>
            </label>
            <div class="col-lg-6 col-sm-12 col-12">
                <div class="radio-inline text-primary">
                    <label><input name='marriage' checked="" value="1" type="radio">&nbsp;Đã kết hôn</label>
                </div>
                <div class="radio-inline text-primary">
                    <label><input name='marriage' value="2" type="radio">&nbsp;Chưa kết hôn</label>
                </div>
                <div class="radio-inline text-primary">
                    <label><input name='marriage' value="3" type="radio">&nbsp;Ly hôn</label>
                </div>
            </div>
        </div>

        <!--địa chỉ hộ khẩu-->
        <div class="x_title">
            <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('The_address')?></strong>
            <div class="clearfix"></div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Province_City1')?> <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="selectize_province_current_address">
                    <option value=""><?= $this->lang->line('Province_City2')?></option>
                    <?php
                    if(!empty($provinceData)){
                        $ns_province=  !empty($lead_info->ns_province) ? $lead_info->ns_province : '';
                        foreach($provinceData as $key => $province){

                            ?>
                            <option <?= $ns_province == $province->code ? "selected" : "" ?> value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
                        <?php }}?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('District')?> <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="selectize_district_current_address">
                    <option value=""><?= $this->lang->line('District1')?></option>
                    <?php
                    if(!empty($districtData_ns)){
                        $ns_district=  !empty($lead_info->ns_district) ? $lead_info->ns_district : '';
                        foreach($districtData_ns as $key => $district){
                            ?>
                            <option <?= $ns_district == $district->code ? "selected" : "" ?> value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
                        <?php }}?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Wards')?> <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="selectize_ward_current_address">
                    <option value=""> <?= $this->lang->line('Wards1')?></option>
                    <?php
                    if(!empty($wardData_ns)){
                        $ns_ward=  !empty($lead_info->ns_ward) ? $lead_info->ns_ward : '';
                        foreach($wardData_ns as $key => $ward){
                            ?>
                            <option <?= $ns_ward == $ward->code ? "selected" : "" ?> value="<?= !empty($ward->code) ? $ward->code : "";?>"><?= !empty($ward->name) ? $ward->name : "";?></option>
                        <?php }}?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('address_is_in')?> <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="current_stay_current_address"  value="<?= $lead_info->address ? $lead_info->address : "" ?>" required class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Residence_form')?> <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="form_residence_current_address">
                    <option value="Tạm trú"> Tạm trú</option>
                    <option value="Thường trú"> Thường trú</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Time_live')?> <span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="time_life_current_address" required class="form-control">
            </div>
        </div>
        <!--địa chỉ đang ở-->
        <div class="x_title">
            <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Household_address')?></strong>
            <div class="clearfix"></div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Province_City1')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control"   id="selectize_province_household">
                    <option value=""><?= $this->lang->line('Province_City2')?></option>
                    <?php
                    if(!empty($provinceData)){
                        $hk_province=  !empty($lead_info->hk_province) ? $lead_info->hk_province : '';
                        foreach($provinceData as $key => $province){
                            ?>
                            <option <?= $hk_province == $province->code ? "selected" : "" ?> value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
                        <?php }}?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('District')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control"   id="selectize_district_household">
                    <option value=""><?= $this->lang->line('District1')?></option>
                    <?php
                    if(!empty($districtData_hk)){
                        $hk_district=  !empty($lead_info->hk_district) ? $lead_info->hk_district : '';
                        foreach($districtData_hk as $key => $district){
                            ?>
                            <option <?= $hk_district == $district->code ? "selected" : "" ?> value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
                        <?php }}?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('Wards')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control"   id="selectize_ward_household">
                    <option value=""><option value=""><?= $this->lang->line('Wards1')?></option>
                    <?php
                    if(!empty($wardData_hk)){
                        $hk_ward=  !empty($lead_info->hk_ward) ? $lead_info->hk_ward : '';
                        foreach($wardData_hk as $key => $ward){
                            ?>
                            <option <?= $hk_ward == $ward->code ? "selected" : "" ?> value="<?= !empty($ward->code) ? $ward->code : "";?>"><?= !empty($ward->name) ? $ward->name : "";?></option>
                        <?php }}?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $this->lang->line('address_is_in')?><span class="text-danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="address_household" required class="form-control">
            </div>
        </div>
        <button class="btn btn-primary  pull-right save_contract" data-step="1"   type="button" data-toggle="modal" data-target="#saveContract">Lưu lại</button>
        <button class="btn btn-primary nextBtnCreate pull-right" data-step="1"  type="button">Tiếp tục</button>
    </div>
</div>


<!-- Modal -->
<div id="checkContract" class="modal fade" role="dialog" style="z-index: 999999">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Danh sách hợp đồng</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th>#</th>

                        <th>Mã Hợp Đồng</th>
                        <th>Cửa Hàng</th>
                        <th>Trạng Thái</th>

                    </tr>
                    </thead>
                    <tbody id='list_contract_check'>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="checkContractFalse" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Danh sách hợp đồng</h4>
            </div>
            <div class="modal-body">
                Không có thông tin liên quan
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--Modal hợp đồng liên quan-->
<?php $this->load->view('page/pawn/modal/contract_reference_modal.php'); ?>

<!--Modal hợp đồng liên quan All-->
<?php $this->load->view('page/pawn/modal/contract_reference_all_modal.php'); ?>

<script>
	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 1000000000, //10MB,
			multiple: true,
			limit: 10,
			start: function (file) {
				fileType = file.type;
				fileName = file.name;
				//upload started
				this.block = $('<div class="block"></div>');
				this.progressBar = $('<div class="progressBar"></div>');
				this.block.append(this.progressBar);
				$('#' + contain).append(this.block);
			},
			data: {
				'type_img': type,
				'contract_id': contractId
			},
			progress: function (progress) {
				//received progress
				this.progressBar.width(progress + "%");
			},
			success: function (data) {
				//upload successful
				this.progressBar.remove();
				if (data.code == 200) {
					//Video Mp4
					if (fileType == 'video/mp4') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file_presenter_cmt"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);

					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file_presenter_cmt"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_file_presenter_cmt"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(content);
						this.block.append(data);
					}
				} else {
					//our application returned an error
					var error = data.msg;
					this.block.remove();
					alert(error);
				}
			},
			error: function (error) {

				var msg = error.msg;
				this.block.remove();
				alert("File không đúng định dạng");
			}
		});
	});

	function deleteImage(thiz) {
		var thiz_ = $(thiz);
		var key = $(thiz).data("key");
		var type = $(thiz).data("type");
		var id = $(thiz).data("id");
		// var res = confirm("Bạn có chắc chắn muốn xóa");
		if (confirm("Bạn có chắc chắn muốn xóa ?")){
			$(thiz_).closest("div .block").remove();
		}

	}
</script>

<script>
	$(document).ready(function () {
	let phone_number_source = $("#customer_phone_number").val();
	let formData = new FormData();
	formData.append('phone_number_source', phone_number_source);
	if (phone_number_source) {
		$.ajax({
			url: _url.base_url + 'lead_custom/check_phone_source',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function(){$(".theloading").show();},
			success: function (data) {
				$(".theloading").hide();
				console.log(data)
				if (data.status == 200) {
					if (typeof data.check_phone.data.source != "undefined") {
						$("#customer_resources").val(data.check_phone.data.source);
						$("#customer_resources").prop('disabled', true);
						if (data.check_phone.data.source == 10) {
							$('#list_ctv_hide').show();
						}
						if (data.check_phone.data.source == 11) {
							$('#show_hide_presenter').show();

							$('#presenter_name').val(data.check_phone.data.presenter_name)
							$('#customer_phone_introduce').val(data.check_phone.data.customer_phone_introduce)
							$('#presenter_bank').val(data.check_phone.data.presenter_bank)
							$('#presenter_stk').val(data.check_phone.data.presenter_stk)
							$('#presenter_cmt').val(data.check_phone.data.presenter_cmt)
						}
					}
					if (typeof data.check_phone.data.source_pgd != "undefined") {
						$("#customer_resources").val(data.check_phone.data.source_pgd);
						$("#customer_resources").prop('disabled', true);
						$('#list_ctv_hide').hide();
					}
					toastr.error("Thời gian lead được tạo: " + data.check_phone.time + " ngày");
				} else {
					$("#customer_resources").val(1);
					$("#customer_resources").prop('disabled', false);
					$('#list_ctv_hide').hide();
					$('#show_hide_presenter').hide();

					$('#presenter_name').val("")
					$('#customer_phone_introduce').val("")
					$('#presenter_bank').val("")
					$('#presenter_stk').val("")
					$('#presenter_cmt').val("")
					$('#uploads_presenter_cmt').empty()
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	}
	});
</script>
