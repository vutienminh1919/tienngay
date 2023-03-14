
        <div class="x_panel setup-content" id="step-5">
          <div class="x_content">
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Hình thức<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="type_payout"  onchange="typePayout()">
                    <option value="2">Tài khoản ngân hàng</option>
                    <option value="3">Thẻ atm</option>
                    <!-- <option value="10">Chuyển nhanh 247</option> -->
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Ngân Hàng<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="selectize_bank_vimo">
                    <option value="">Chọn ngân hàng</option>
                    <?php 
                    if(!empty($bankVimoData)){
                        foreach($bankVimoData as $key => $bank){
                    ?>
                        <option  value="<?= !empty($bank->bank_id) ? $bank->bank_id : "";?>" <?php if($contractInfor->receiver_infor->bank_id == $bank->bank_id) echo 'selected';?> ><?= !empty($bank->name) ? $bank->name : "";?> ( <?= !empty($bank->short_name) ? $bank->short_name : "";?> )</option>
                    <?php }}?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Chi nhánh<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" required id="bank_branch" class="form-control " value="<?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Số tài khoản<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" required id="bank_account" class="form-control " value="<?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
              </div>
            </div>
            
         
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Chủ tài khoản<span class="text-danger">*</span>
              </label>
              <div class="col-lg-6 col-sm-12 col-12">
              <input type="text" required id="bank_account_holder" class="form-control "  value="<?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
              </div>
            </div>
           
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Số thẻ atm <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="atm_card_number" type='text' class="form-control" value="<?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'disabled';?>>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Tên chủ thẻ atm<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" required id="atm_card_holder" class="form-control" value="<?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'disabled';?>>
              </div>
            </div>     

            <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Phòng giao dịch<span class="text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" id="stores">
                    <?php 
                        // $userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
                        // $stores = !empty($userInfo['stores']) ?  $userInfo['stores'] : array();
                        foreach($stores as $key =>  $value){
                          if($value->status !='active')
                            continue; 
                    ?>
                             <option <?php if($contractInfor->store->id == $value->_id->{'$oid'}) echo 'selected';?> data-address="<?= !empty($value->address) ? $value->address : ""?>" value="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""?>" selected><?= !empty($value->name) ? $value->name : ""?></option>
                        <?php }?>
                    </select>
                </div>
            </div>                    

            <button class="btn btn-primary nextBtnCreate pull-right"  data-step="5"  type="button">Tiếp tục</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
          </div>
        </div>

