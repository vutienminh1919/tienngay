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
                      <img id="imgImg_mattruoc" class="w-100" style="max-width: 350px; max-height: 250px;" alt=""
                           src="<?= $contractInfor->customer_infor->img_id_front ? $contractInfor->customer_infor->img_id_front : "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" ?>"
                      >
                      <p>Mặt trước CMT</p>
                      <input type="file" id="input_cmt_search" data-preview="imgInp001" style="visibility: hidden;"
                             value="<?= $contractInfor->customer_infor->img_id_back ? $contractInfor->customer_infor->img_id_back : "" ?>"
                      >
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
                  <img id="imgImg_matsau" class="w-100" style="max-width: 350px; max-height: 250px;" alt=""
                       src="<?= $contractInfor->customer_infor->img_id_back ? $contractInfor->customer_infor->img_id_back : "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" ?>"
                  >
                  <p>Mặt sau CMT</p>
                  <input type='file' id="imgInp_Face" data-preview="imgInp002" style="visibility: hidden;"
                         value="<?= $contractInfor->customer_infor->img_id_back ? $contractInfor->customer_infor->img_id_back : "" ?>"
                  >
              </div>
              <div class="col-xs-12 col-md-4 text-left">
                  <img id="imgImg_chandung" class="w-100" style="max-width: 350px; max-height: 250px;" alt=""
                       src="<?= $contractInfor->customer_infor->img_portrait ? $contractInfor->customer_infor->img_portrait : "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" ?>"
                  >
                  <p>Ảnh chân dung</p>
                  <input type='file' id="imgInp_Identify" data-preview="imgInp002" style="visibility: hidden;"
                         value="<?= $contractInfor->customer_infor->img_portrait ? $contractInfor->customer_infor->img_portrait : "" ?>"
                  />
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
<!--              <p><b>Bước 2:</b> Click vào nút <b>Kiểm trả blacklist</b></p>-->
              <p><b>Bước 2:</b> Click vào nút <b>Nhận dạng</b> để so khớp chân dung</p>
              <small>Lưu ý: Bằng cách tải lên các ảnh, tệp ở đây, bạn đồng ý để chúng được lưu trữ tạm thời trong tập dữ liệu đào tạo của chúng tôi cho mục đích duy nhất là cải thiện công nghệ của Computer Vision Việt Nam.</small>
          </div>
          <div class="clearfix"></div>
          <br><br>
          <p></p>
          <div class="row">
              <div class="col-md-12 text-center">
                  <button type="button" class="btn btn-danger return_Face_Identify">Chọn lại</button>
<!--                  <button type="button" class="btn btn-primary identification_Face_search">Kiểm tra blacklist</button>-->
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
          <input type="hidden" hidden id="isBlacklist" value="<?= (!empty($contractInfor->customer_infor->is_blacklist)) ? $contractInfor->customer_infor->is_blacklist : "" ?>">
      </div>
    <div class="x_title">
        <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Customer_information')?></strong>
        <div class="clearfix"></div>
    </div>
      <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Customer_information')?>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="radio-inline text-primary">
            <label><input type="radio" value="1" name="status_customer" <?= !empty($contractInfor->customer_infor->status_customer) && $contractInfor->customer_infor->status_customer == 1 ? "checked" : "" ?>><?= $this->lang->line('new_customer')?></label>
        </div>
        <div class="radio-inline text-danger">
            <label><input type="radio" value="2" name="status_customer" <?= !empty($contractInfor->customer_infor->status_customer) &&  $contractInfor->customer_infor->status_customer == 2 ? "checked" : "" ?>><?= $this->lang->line('Old_customer')?></label>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Customer_name')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="customer_name" required value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_name : "" ?>" class="form-control">
      </div>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('phone_number')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?php if(!empty($contractInfor->customer_infor->id_lead)){ ?>
          <input type="text" required value="<?= $contractInfor->customer_infor->customer_phone_number ? hide_phone($contractInfor->customer_infor->customer_phone_number) : "" ?>" class="form-control phone-autocomplete customer_phone_number" >
          <input type="hidden" required id="customer_phone_number" value="<?= $contractInfor->customer_infor->customer_phone_number ? ($contractInfor->customer_infor->customer_phone_number) : "" ?>" class="form-control phone-autocomplete" >
         
        <?php }else{ ?>
           <input type="text" required id="customer_phone_number" value="<?= $contractInfor->customer_infor->customer_phone_number ? $contractInfor->customer_infor->customer_phone_number : "" ?>" class="form-control phone-autocomplete" >
           <?php } ?>
        </div>
          <input type="hidden" id="id_lead"  class="form-control" value="<?= (isset($contractInfor->customer_infor->id_lead))  ? $contractInfor->customer_infor->id_lead : '' ?>">
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
        <input type="email" required id="customer_email" value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_email : "" ?>" class="form-control email-autocomplete">
        <div id="results" class="smartsearchresult "></div>
      </div>
    </div>

    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('identify_current')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" maxlength="12" required id="customer_identify" value="<?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>" class="form-control identify-autocomplete">
         <div id="resultsIdentify" class="smartsearchresult "></div>
      </div>
    </div>
	  <div class="form-group row">
		  <label class="control-label col-md-3 col-sm-3 col-xs-12">
			  <?= $this->lang->line('date_range')?><span class="text-danger">*</span>
		  </label>
		  <div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="date" required id="date_range" min="1940-12-31" max="2100-12-31" value="<?= $contractInfor->customer_infor->date_range ? $contractInfor->customer_infor->date_range : "" ?>" class="form-control">
		  </div>
	  </div>
	  <div class="form-group row">
		  <label class="control-label col-md-3 col-sm-3 col-xs-12">
			  <?= $this->lang->line('issued_by')?><span class="text-danger">*</span>
		  </label>
		  <div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" required id="issued_by" value="<?= $contractInfor->customer_infor->issued_by ? $contractInfor->customer_infor->issued_by : "" ?>" class="form-control">
		  </div>
	  </div>
	  <div class="form-group row">
		  <label class="control-label col-md-3 col-sm-3 col-xs-12">
			  <?= $this->lang->line('identify_old')?>
		  </label>
		  <div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" maxlength="12" id="customer_identify_old" value="<?= $contractInfor->customer_infor->customer_identify_old ? $contractInfor->customer_infor->customer_identify_old : "" ?>" class="form-control identify-old-autocomplete">
			  <div id="resultsIdentifyOld" class="smartsearchresult "></div>
		  </div>
	  </div>

	  <hr>

	  <div class="form-group row">
		  <label class="control-label col-md-3 col-sm-3 col-xs-12">
			  Số hộ chiếu:
		  </label>
		  <div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" maxlength="12" required id="passport_number" class="form-control" value="<?= $contractInfor->customer_infor->passport_number ? $contractInfor->customer_infor->passport_number : "" ?>">
		  </div>
	  </div>

	  <div class="form-group row">
		  <label class="control-label col-md-3 col-sm-3 col-xs-12">
			  Nơi cấp hộ chiếu:
		  </label>
		  <div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" required id="passport_address" class="form-control" value="<?= $contractInfor->customer_infor->passport_address ? $contractInfor->customer_infor->passport_address : "" ?>">
		  </div>
	  </div>

	  <div class="form-group row">
		  <label class="control-label col-md-3 col-sm-3 col-xs-12">
			  Ngày cấp hộ chiếu:
		  </label>
		  <div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="date" required id="passport_date" class="form-control" value="<?= $contractInfor->customer_infor->passport_date ? $contractInfor->customer_infor->passport_date : "" ?>">
		  </div>
	  </div>


	  <hr>
	  <input type="hidden" value="<?= !empty($contractInfor->code_contract) ? $contractInfor->code_contract : '';?>" id="code_contract_digital">
	  <?php if (!empty($store_digital) && $store_digital == 1) : ?>
		  <div class="form-group row">
			  <label class="control-label col-md-3 col-sm-3 col-xs-12">
				  Chọn loại hợp đồng KH muốn ký <span class="text-danger">*</span>
			  </label>
			  <div class="col-md-6 col-sm-6 col-xs-12">
				  <div class="radio-inline text-primary">
					  <label><input type="radio" value="1" name="type_contract_sign" id="choose_contract_digital" <?= !empty($contractInfor->customer_infor->type_contract_sign) && $contractInfor->customer_infor->type_contract_sign == 1 ? 'checked' : '';?>>Hợp đồng điện tử</label>
				  </div>
				  <div class="radio-inline text-danger">
					  <label><input type="radio" value="2" name="type_contract_sign" id="choose_contract_paper" <?= !empty($contractInfor->customer_infor->type_contract_sign) && $contractInfor->customer_infor->type_contract_sign == 2 ? 'checked' : '';?>>Hợp đồng bản giấy</label>
				  </div>
			  </div>
		  </div>
	 	 <?php if (!empty($contractInfor->customer_infor->type_contract_sign) && ($contractInfor->customer_infor->type_contract_sign == 1)) { ?>
		  <div class="form-group row" id="receive_notifi_sign">
			  <label class="control-label col-md-3 col-sm-3 col-xs-12">
				  Chọn hình thức nhận thông báo ký số hợp đồng điện tử <span class="text-danger">*</span>
			  </label>
			  <div class="col-md-6 col-sm-6 col-xs-12">
				  <div class="radio-inline text-primary">
					  <label><input type="radio" value="1" name="status_email" <?= !empty($contractInfor->customer_infor->status_email) && $contractInfor->customer_infor->status_email == 1 ? 'checked' : '';?>>Nhận thông báo qua Email</label>
				  </div>
				  <div class="radio-inline text-danger">
					  <label><input type="radio" value="2" name="status_email" <?= !empty($contractInfor->customer_infor->status_email) && $contractInfor->customer_infor->status_email == 2 ? 'checked' : '';?>>Nhận thông báo qua tin nhắn SMS</label>
				  </div>
			  </div>
		  </div>

	 	 <?php } else { ?>
			  <div class="form-group row d-none" id="receive_notifi_sign" >
				  <label class="control-label col-md-3 col-sm-3 col-xs-12">
					  Chọn hình thức nhận thông báo ký số hợp đồng điện tử <span class="text-danger">*</span>
				  </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					  <div class="radio-inline text-primary">
						  <label><input type="radio" value="1" name="status_email" <?= !empty($contractInfor->customer_infor->status_email) && $contractInfor->customer_infor->status_email == 1 ? 'checked' : '';?>>Nhận thông báo qua Email</label>
					  </div>
					  <div class="radio-inline text-danger">
						  <label><input type="radio" value="2" name="status_email" <?= !empty($contractInfor->customer_infor->status_email) && $contractInfor->customer_infor->status_email == 2 ? 'checked' : '';?>>Nhận thông báo qua tin nhắn SMS</label>
					  </div>
				  </div>
			  </div>
	 	 <?php } ?>
	  <?php endif;?>
	  <div class="form-group row">
		  <label class="control-label col-md-3 col-sm-3 col-xs-12">
			  Nguồn khách hàng <span class="text-danger">*</span>
		  </label>
		  <div class="col-md-6 col-sm-6 col-xs-12">
			  <select class="form-control" id="customer_resources" <?= (!empty($contractInfor->customer_infor->id_lead)) ?  'disabled' : "" ; ?> >
				  <option value="1" <?= $contractInfor->customer_infor->customer_resources == "1" ? "selected" : "" ?>>Digital</option>
				  <option value="2" <?= $contractInfor->customer_infor->customer_resources == "2" ? "selected" : "" ?>>TLS Tự kiếm</option>
				  <option value="3" <?= $contractInfor->customer_infor->customer_resources == "3" ? "selected" : "" ?>>Tổng đài</option>
				  <option value="4" <?= $contractInfor->customer_infor->customer_resources == "4" ? "selected" : "" ?>>Giới thiệu</option>
				  <option value="5" <?= $contractInfor->customer_infor->customer_resources == "5" ? "selected" : "" ?>>Đối tác</option>
				  <option value="6" <?= $contractInfor->customer_infor->customer_resources == "6" ? "selected" : "" ?>>Fanpage</option>
				  <option value="7" <?= $contractInfor->customer_infor->customer_resources == "7" ? "selected" : "" ?>>Nguồn khác</option>
				  <option value="12" <?= $contractInfor->customer_infor->customer_resources == "12" ? "selected" : "" ?>>Nguồn App Mobile</option>
				  <option value="8" <?= $contractInfor->customer_infor->customer_resources == "8" ? "selected" : "" ?>>KH vãng lai</option>
				  <option value="9" <?= $contractInfor->customer_infor->customer_resources == "9" ? "selected" : "" ?>>KH tự kiếm</option>
				  <option value="10" <?= $contractInfor->customer_infor->customer_resources == "10" ? "selected" : "" ?>>Cộng tác viên</option>
				  <option value="11" <?= $contractInfor->customer_infor->customer_resources == "11" ? "selected" : "" ?>>KH giới thiệu KH</option>
				  <option value="VM" <?= $contractInfor->customer_infor->customer_resources == "VM" ? "selected" : "" ?>>Nguồn vay mượn</option>
				  <option value="VPS" <?= $contractInfor->customer_infor->customer_resources == "VPS" ? "selected" : "" ?>>Nguồn VPS</option>
				  <option value="MB" <?= $contractInfor->customer_infor->customer_resources == "MB" ? "selected" : "" ?>>Nguồn MB</option>
				  <option value="14" <?= ($contractInfor->customer_infor->customer_resources == "14") ? "selected" : "" ?> >Tool FB</option>
				  <option value="15" <?= ($contractInfor->customer_infor->customer_resources == "15") ? "selected" : "" ?> >Tiktok</option>
				  <option value="16" <?= ($contractInfor->customer_infor->customer_resources == "16") ? "selected" : "" ?> >Remarketing</option>
				  <option value="Homedy" <?= ($contractInfor->customer_infor->customer_resources == "Homedy") ? "selected" : "" ?> >Homedy</option>
				  <option value="Merchant" <?= ($contractInfor->customer_infor->customer_resources == "Merchant") ? "selected" : "" ?> >Nguồn Merchant</option>
				  <option value="17" <?= ($contractInfor->customer_infor->customer_resources == "17") ? "selected" : "" ?> >Nguồn ngoài</option>
			  </select>
		  </div>
	  </div>

	  <div id="show_hide_presenter" <?= $contractInfor->customer_infor->customer_resources == 11 ? "" : "style='display: none'" ?>>
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
				  <input type="text" required id="presenter_name" class="form-control" value="<?= !empty($contractInfor->customer_infor->presenter_name) ? $contractInfor->customer_infor->presenter_name : "" ?>">
			  </div>
		  </div>
		  <div class="form-group row">
			  <label class="control-label col-md-3 col-sm-3 col-xs-12">
				  Số điện thoại:<span class="text-danger">*</span>
			  </label>
			  <div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" required id="customer_phone_introduce" class="form-control" value="<?= !empty($contractInfor->customer_infor->customer_phone_introduce) ? $contractInfor->customer_infor->customer_phone_introduce : "" ?>">
			  </div>
		  </div>
		  <div class="form-group row">
			  <label class="control-label col-md-3 col-sm-3 col-xs-12">
				  Ngân hàng:<span class="text-danger">*</span>
			  </label>
			  <div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" required id="presenter_bank" class="form-control" value="<?= !empty($contractInfor->customer_infor->presenter_bank) ? $contractInfor->customer_infor->presenter_bank : "" ?>">
			  </div>
		  </div>
		  <div class="form-group row">
			  <label class="control-label col-md-3 col-sm-3 col-xs-12">
				  Số tài khoản:<span class="text-danger">*</span>
			  </label>
			  <div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" required id="presenter_stk" class="form-control" value="<?= !empty($contractInfor->customer_infor->presenter_stk) ? $contractInfor->customer_infor->presenter_stk : "" ?>">
			  </div>
		  </div>
		  <div class="form-group row">
			  <label class="control-label col-md-3 col-sm-3 col-xs-12">
				  CMND/CCCD/CMT cũ:<span class="text-danger">*</span>
			  </label>
			  <div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" required id="presenter_cmt" class="form-control" value="<?= !empty($contractInfor->customer_infor->presenter_cmt) ? $contractInfor->customer_infor->presenter_cmt : "" ?>">
			  </div>
		  </div>
		  <div class="form-group row">
			  <label class="control-label col-md-3 col-sm-3 col-xs-12">
				  Upload ảnh CMT:<span class="text-danger">*</span>
			  </label>
			  <div class="col-md-6 col-sm-6 col-xs-12">

				  <div id="SomeThing" class="simpleUploader">
					  <div class="uploads" id="uploads_presenter_cmt">
						  <?php
						  $key_identify = 0;
						  foreach((array)$contractInfor->customer_infor->img_file_presenter_cmt as $key=>$value) {
							  $key_identify++;
							  if(empty($value)) continue;?>
							  <div class="block">
								  <!--//Image-->
								  <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
<!--									  <span class="timestamp">--><?php //echo date('d/m/Y H:i:s', basename($value->path));?><!--</span>-->
									  <a href="<?= $value->path ?>" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-toggle="lightbox"  data-gallery="uploads_identify" data-max-width="992" data-type="image" data-title="Hồ sơ nhân thân">
										  <img name="img_file_presenter_cmt" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='identify' class="w-100" src="<?= $value->path?>" alt="">
									  </a>
								  <?php }?>
								  <!--Audio-->
								  <?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
<!--									  <span class="timestamp">--><?php //echo date('d/m/Y H:i:s', basename($value->path));?><!--</span>-->
									  <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
										  <img name="img_file_presenter_cmt" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
										  <img name="img_file_presenter_cmt" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='identify' class="w-100" src="<?= $value->path?>" alt="">
									  </a>

								  <?php }?>
								  <!--Video-->
								  <?php if($value->file_type == 'video/mp4') {?>
<!--									  <span class="timestamp">--><?php //echo date('d/m/Y H:i:s', basename($value->path));?><!--</span>-->
									  <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
										  <img name="img_file_presenter_cmt" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
										  <img name="img_file_presenter_cmt" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='identify' class="w-100" src="<?= $value->path?>" alt="">
									  </a>

								  <?php }?>
								  <button type="button" onclick="deleteImage(this)" data-id="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>" data-type="identify" data-key='<?= $key?>' class="cancelButton "><i class="fa fa-times-circle"></i></button>
							  </div>
						  <?php }?>
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
		  <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" id="giu_xe">
			  Cộng tác viên <span class="text-danger"></span>
		  </label>
		  <div class="col-lg-6 col-sm-12 col-12">
			  <select class="form-control" name="list_ctv" id="list_ctv">
				  <option value="">-- Chọn cộng tác viên --</option>
				  <?php !empty($list_ctv) ? $list_ctv : ''; ?>
				  <?php !empty($contractInfor->customer_infor->list_ctv) ? $contractInfor->customer_infor->list_ctv : ''; ?>
				  <?php foreach ($list_ctv as $key => $item): ?>
					  <option value="<?php echo $item->ctv_code ?>" <?php if ($item->ctv_code == $contractInfor->customer_infor->list_ctv): ?>
						  selected <?php endif; ?>><?php echo $item->ctv_code. " - " .$item->ctv_name ?>
					  </option>
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
          <label><input name='customer_gender' value="1" <?= $contractInfor->customer_infor->customer_gender == 1 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('male')?></label>
        </div>
        <div class="radio-inline text-danger">
        <label><input name='customer_gender' value="2" <?= $contractInfor->customer_infor->customer_gender == 2 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Birthday')?><span class="text-danger">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="date" id="customer_BOD" type='text' value="<?= $contractInfor->customer_infor->customer_BOD ? $contractInfor->customer_infor->customer_BOD : "" ?>" class="form-control" />
      </div>
    </div>


    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
      <?= $this->lang->line('Marital_status')?><span class="text-danger">*</span>
      </label>
      <div class="col-lg-6 col-sm-12 col-12">
        <div class="radio-inline text-primary">
        <label><input name='marriage' value="1" <?= $contractInfor->customer_infor->marriage == 1 ? "checked" : "" ?> type="radio">&nbsp;Đã kết hôn</label>
        </div>
        <div class="radio-inline text-primary">
        <label><input name='marriage' value="2" <?= $contractInfor->customer_infor->marriage == 2 ? "checked" : "" ?> type="radio">&nbsp;Chưa kết hôn</label>
        </div>
        <div class="radio-inline text-primary">
        <label><input name='marriage' value="3" <?= $contractInfor->customer_infor->marriage == 3 ? "checked" : "" ?> type="radio">&nbsp;Ly hôn</label>
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
                    foreach($provinceData as $key => $province){
                ?>
                    <option <?= $contractInfor->current_address->province == $province->code ? "selected" : "" ?> value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
                <?php }}?>
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('District')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="selectize_district_current_address">
              <option value=""><?= $this->lang->line('District1')?></option>
              <?php 
              if(!empty($districtData)){
                  foreach($districtData as $key => $district){
              ?>
                  <option <?= $contractInfor->current_address->district == $district->code ? "selected" : "" ?> value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Wards')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="form-control" id="selectize_ward_current_address">
                <option value=""><?= $this->lang->line('Wards1')?></option>
                <?php 
                if(!empty($wardData)){
                    foreach($wardData as $key => $ward){
                ?>
                    <option <?= $contractInfor->current_address->ward == $ward->code ? "selected" : "" ?> value="<?= !empty($ward->code) ? $ward->code : "";?>"><?= !empty($ward->name) ? $ward->name : "";?></option>
                <?php }}?>
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('address_is_in')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="current_stay_current_address" value="<?= $contractInfor->current_address->current_stay ? $contractInfor->current_address->current_stay : "" ?>" required class="form-control">
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
            <?= $this->lang->line('Residence_form')?>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="form_residence_current_address">
              <option  <?= $contractInfor->current_address->form_residence == 'Tạm trú' ? "selected" : "" ?>  value="Tạm trú"> Tạm trú</option>
              <option <?= $contractInfor->current_address->form_residence == 'Thường trú' ? "selected" : "" ?>  value="Thường trú"> Thường trú</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Time_live')?> 
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="time_life_current_address" value="<?= $contractInfor->current_address->time_life ? $contractInfor->current_address->time_life : "" ?>" required class="form-control">
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
          <select class="form-control" id="selectize_province_household">
              <option value=""><?= $this->lang->line('Province_City2')?></option>
              <?php 
              if(!empty($provinceData_)){
                  foreach($provinceData_ as $key => $province){
              ?>
                  <option <?= $contractInfor->houseHold_address->province == $province->code ? "selected" : "" ?> value="<?= !empty($province->code) ? $province->code : "";?>"><?= !empty($province->name) ? $province->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('District')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="selectize_district_household">
              <option value=""><?= $this->lang->line('District1')?> </option>
              <?php 
              if(!empty($districtData_)){
                  foreach($districtData_ as $key => $district){
              ?>
                  <option <?= $contractInfor->houseHold_address->district == $district->code ? "selected" : "" ?> value="<?= !empty($district->code) ? $district->code : "";?>"><?= !empty($district->name) ? $district->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('Wards')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <select class="form-control" id="selectize_ward_household">
              <option value=""><?= $this->lang->line('Wards1')?></option>
              <?php 
              if(!empty($wardData_)){
                  foreach($wardData_ as $key => $ward){
              ?>
                  <option <?= $contractInfor->houseHold_address->ward == $ward->code ? "selected" : "" ?> value="<?= !empty($ward->code) ? $ward->code : "";?>"><?= !empty($ward->name) ? $ward->name : "";?></option>
              <?php }}?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
        <?= $this->lang->line('address_is_in')?><span class="text-danger">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="address_household" value="<?= $contractInfor->houseHold_address->address_household ? $contractInfor->houseHold_address->address_household : "" ?>" required class="form-control">
        </div>
      </div>
    <button class="btn btn-primary nextBtnCreate pull-right" data-step="1"  type="button">Tiếp tục</button>
  </div>
</div>
<!-- Modal -->
<div id="checkContract" class="modal fade" role="dialog">
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
     Không có thông tin hợp đồng liên quan
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
