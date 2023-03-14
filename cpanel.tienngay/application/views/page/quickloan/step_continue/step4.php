
        <div class="x_panel setup-content" id="step-4">
          <div class="x_content">
          <!--Thông tin khoản vay-->                      
          <div class="x_title">
              <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Loan_information')?></strong>
              <div class="clearfix"></div>
            </div>
            <?php $amount_GIC=(isset($contractInfor->loan_infor->amount_GIC)) ? $contractInfor->loan_infor->amount_GIC : 0;
             if(empty($dataInit['type_finance'])) {?>
                <?php 
                    $data['configuration_formality'] = $configuration_formality;
                    $data['mainPropertyData'] = $mainPropertyData;
                    $this->load->view("page/property/template/loan_infor_no_init", $data)
                ?>
            <?php }?>
          
           <!--Init from định giá tài sản-->
           <?php if(!empty($dataInit['type_finance'])) {?>
                <?php
                    $data['configuration_formality'] = $configuration_formality;
                    $data['mainPropertyData'] = $mainPropertyData;
                    $data['dataInit']= $dataInit;
                    $this->load->view("page/property/template/loan_infor_have_init.php", $data);
                ?>
            <?php }?>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Số tiền vay<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <?php 
                $amount_money = !empty($contractInfor->loan_infor->amount_money) ? $contractInfor->loan_infor->amount_money : 0;
                if(empty($amount_money) || $amount_money == 'NaN'){
                  $amount_money = 0;
                }
              ?>
              <input type="text" id="money" required class="form-control number"  value="<?= !empty($amount_money) ? number_format($amount_money) : "" ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('formality2')?>  <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="type_interest">
                    <option value="1" <?= $contractInfor->loan_infor->type_interest == 1 ? "selected='selected'" : "" ?>><?= $this->lang->line('Outstanding_descending')?></option>
                    <option value="2" <?= $contractInfor->loan_infor->type_interest == 2 ? "selected='selected'" : "" ?>><?= $this->lang->line('Monthly_interest_principal_maturity')?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Number_loan_days')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="text" id="number_day_loan" value="<?= $contractInfor->loan_infor->number_day_loan ? $contractInfor->loan_infor->number_day_loan : "" ?>" required class="form-control"> -->
              <select class="form-control" id="number_day_loan">
                    <option value="1" <?= $contractInfor->loan_infor->number_day_loan/30 == "1" ? "selected='selected'" : "" ?>>1 tháng</option>
                    <option value="3" <?= $contractInfor->loan_infor->number_day_loan/30 == "3" ? "selected='selected'" : "" ?>>3 tháng</option>
                    <option value="6" <?= $contractInfor->loan_infor->number_day_loan/30 == "6" ? "selected='selected'" : "" ?>>6 tháng</option>
                    <option value="9" <?= $contractInfor->loan_infor->number_day_loan/30 == "9" ? "selected='selected'" : "" ?>>9 tháng</option>
                    <option value="12" <?= $contractInfor->loan_infor->number_day_loan/30 == "12" ? "selected='selected'" : "" ?>>12 tháng</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Interest_payment_period')?> (Ngày)<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="period_pay_interest"  value="30" disabled required class="form-control">
              </div>
            </div>
            
         
              <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Bảo hiểm <span class="text-danger">*</span>
              </label>
              <div class="col-lg-6 col-sm-12 col-12">
                <div class="radio-inline text-primary">
                <label><input name='insurrance' <?= ($contractInfor->loan_infor->insurrance_contract==1) ? "checked" : "" ?>   id="insurrance"  type="checkbox"></label>
                </div>
              </div>
            </div>

              
             <div class="form-group row">
         
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                Phí bảo hiểm (VAT)
              </label>
             
              <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="fee_gic"  class="form-control number"  value="<?= (isset($contractInfor->loan_infor->amount_GIC)) ? number_format($contractInfor->loan_infor->amount_GIC) : 0 ?>" disabled>
            
              </div>
            </div>


           <input type="hidden" id="tilekhoanvay" name="tilekhoanvay" value="<?=$tilekhoanvay?>">
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Mục đích vay <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="loan_purpose" required class="form-control" value="<?= !empty($contractInfor->loan_infor->loan_purpose) ? $contractInfor->loan_infor->loan_purpose : "" ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('note')?> 
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea type="text" id="note" required value="<?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?>" class="form-control"><?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?></textarea>
              </div>
            </div>   
             <!--Thông tin tài sản-->                      
            <div class="x_title">
              <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Property_information')?></strong>
              <div class="clearfix"></div>
            </div>
            <div class="properties">
            <?php if(!empty($contractInfor->property_infor)) { foreach($contractInfor->property_infor as $item) {  ?>
              <div class="form-group row ">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $item->name?>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="property_infor" required value="<?= $item->value?>" class="form-control property-infor" data-slug="<?= $item->slug?>" data-name="<?= $item->name?>" placeholder="<?= $item->name?>">
              </div>   </div> 
              <?php }}?>
            </div>   

            <!-- <div class="form-group row properties">
            </div> -->
            <button class="btn btn-primary nextBtnCreate pull-right" data-step="4"  type="button">Tiếp tục</button>
            <?php 
                $step = !empty($contractInfor->step) ? $contractInfor->step : "1";
                if($step < 4){
                  $step = "4";
                };
            ?>
            <button class="btn btn-primary  pull-right save_contract"  type="button" data-toggle="modal"  data-step="<?php echo $step?>" data-target="#saveContract">Lưu lại</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
          </div>
        </div>
