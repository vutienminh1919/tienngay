
        <div class="x_panel setup-content" id="step-4">
          <div class="x_content">
          <!--Thông tin khoản vay-->                      
          <div class="x_title">
              <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Loan_information')?></strong>
              <div class="clearfix"></div>
            </div>
          <?php if(empty($dataInit['type_finance']) && empty($dataInit['main'])) {?>
              <?php 
                  $data['configuration_formality'] = $configuration_formality;
                  $data['mainPropertyData'] = $mainPropertyData;
                  $this->load->view("page/property/template/loan_infor_no_init", $data)
              ?>
          <?php }?>
          
          <!--Init from định giá tài sản-->
          <?php if(!empty($dataInit['type_finance']) && !empty($dataInit['main'])) {?>
              <?php
                  $data['configuration_formality'] = $configuration_formality;
                  $data['mainPropertyData'] = $mainPropertyData;
                  $data['dataInit']= $dataInit;
                  $this->load->view("page/property/template/loan_infor_have_init.php", $data);
              ?>
          <?php }?>


            <div class="form-group row">
              <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
              Số tiền vay<span class="text-danger">*</span>
              </label>
              <!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="money" required class="form-control number" value="0">
              </div>
            </div>
            <div class="form-group row">
              <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('formality2')?>  <span class="text-danger">*</span>
              </label>
              <!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="type_interest">
                    <option value=""></option>
                    <option value="1"><?= $this->lang->line('Outstanding_descending')?></option>
                    <option value="2"><?= $this->lang->line('Monthly_interest_principal_maturity')?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Number_loan_days')?><span class="text-danger">*</span>
              </label>
              <!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12" id="cc">
                <select class="form-control number_day_loan"  >
                    <option value="1" >1 tháng</option>
                </select>
              </div>
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12" id="dkx"  style='display:none'>
                <select class="form-control " id="number_day_loan">
                    <option value="1" >1 tháng</option>
                    <option value="3" >3 tháng</option>
                    <option value="6" >6 tháng</option>
                    <option value="9" >9 tháng</option>
                    <option value="12" >12 tháng</option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Interest_payment_period')?> (ngày)<span class="text-danger">*</span>
              </label>
              <!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="period_pay_interest"  class="form-control" value="30" disabled>
              </div>
            </div>
            
         
            <div class="form-group row" >
             
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
              Bảo hiểm <span class="text-danger">*</span>
              </label>
             <input type="hidden" id="tilekhoanvay" name="tilekhoanvay" value="<?=$tilekhoanvay?>">
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                <div class="radio-inline text-primary">
                <label><input name='insurrance' value="0"  id="insurrance"  type="checkbox"></label>
                </div>
             
              </div>
            </div>
             <div class="form-group row">
              <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                Phí bảo hiểm (VAT)
              </label>
              <!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="fee_gic"  class="form-control number"  value="0" disabled>
            
              </div>
            </div>
            
            <div class="form-group row">
              <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
              Mục đích vay <span class="text-danger">*</span>
              </label>
              <!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="loan_purpose" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('note')?> 
              </label>
              <!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
              <textarea type="text" id="note" required class="form-control"></textarea>
              </div>
            </div>   
             <!--Thông tin tài sản-->                      
            <div class="x_title">
              <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Property_information')?></strong>
              <div class="clearfix"></div>
            </div>
            <div class="properties">
            </div>
            <button class="btn btn-primary nextBtnCreate pull-right" data-step="4"  type="button">Tiếp tục</button>
            <button class="btn btn-primary  pull-right save_contract"  type="button" data-toggle="modal"  data-step="4" data-target="#saveContract">Lưu lại</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
          </div>
        </div>
