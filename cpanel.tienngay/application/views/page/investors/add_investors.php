<!-- page content -->
<div class="right_col" role="main">
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử Lý...</span>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $this->lang->line('create_investors')?>
                    <br/><br/>
                    <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('investors/listInvestors')?>"><?php echo $this->lang->line('investors_list')?></a> / <a href="#"><?php echo $this->lang->line('create_investors')?></a></small>
                </h3>
            </div>
        </div>
    </div>
    <div class="x_content">
        <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span class='div_error'></span>
        </div>
        <div class="x_panel setup-content" id="step-1" style="display: inline-block;">
            <div class="x_content">
                <div class="x_title">
                    <strong><i class="fa fa-user" aria-hidden="true"></i> <?php echo $this->lang->line('Info_investors')?></strong>
                    <div class="clearfix"></div>
                </div>
                <form class="form-horizontal form-label-left" id="form_investors" action="<?php echo base_url("investors/doAddInvestors")?>" method="post">
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('code')?><span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="code" name="code" required="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Loại nhà đầu tư
                        <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control district_shop"  name="type_investors" id="type_investors" required>
                                <option value="1">Ngân lượng</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Merchant id ngân lượng<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="merchant_id" name="merchant_id" required="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Merchant password ngân lượng<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="merchant_password" name="merchant_password" required="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Receiver email ngân lượng<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="receiver_email" name="receiver_email" required="" class="form-control">
                        </div>
                    </div>

                   
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('name')?><span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" name="name" required="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('dentity_card')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="dentity_card" name="dentity_card" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('date_of_birth')?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" required="" id="date_of_birth" name="date_of_birth" class="form-control phone-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('phone')?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="phone" name="phone" class="form-control phone-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('email')?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" required="" id="email" name="email" class="form-control email-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('address')?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="address" required="" id="address" name="address" class="form-control email-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <!--địa chỉ hộ khẩu-->
                    <div class="x_title">
                        <strong><i class="fa fa-user" aria-hidden="true"></i> Cài đặt nhà đầu tư</strong>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('tax_code')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="tax_code" name="tax_code" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('balance')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="balance" name="balance" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('percent_interest_investor')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="percent_interest_investor" name="percent_interest_investor" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('form_of_receipt')?>
                    
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control district_shop"  placeholder="<?php echo $this->lang->line('level_pla')?>" name="form_of_receipt" id="form_of_receipt" required>
                                <option value="1">Tiền mặt</option>
                                <option value="2">Chuyển khoản</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('account_number')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="account_number" name="account_number" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                       <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Kỳ hạn
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12 input-group m-input-group">
                            <input type="number" required="" id="period" name="period" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                             <span class="input-group-addon">
                                            <i class="text-black">Tháng</i>
                                        </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('bank')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control"  id="bank" name="bank"  id="selectize_province">
                                <option value="">Chọn ngân hàng</option>
                                <?php 
                                    if(!empty($bankData)){
                                      foreach($bankData as $key => $bank){
                                    ?>
                                <option  value="<?= !empty($bank->_id->{'$oid'}) ? $bank->_id->{'$oid'} : "" ?>"><?= !empty($bank->name) ? $bank->name : "";?></option>
                                <?php }}?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('bank_branch')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="bank_branch" name="bank_branch" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('status')?>
                        </label>
                        <div class="col-lg-6 col-sm-12 col-xs-12 ">
                            <div class="radio-inline text-primary">
                                <label>
                                <input type="radio" name="status" value="active" checked="checked"> <?php echo $this->lang->line('active')?>
                                </label>
                            </div>
                            <div class="radio-inline text-danger">
                                <label>
                                <input type="radio"   name="status" value="deactive"> <?php echo $this->lang->line('deactive')?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-success  create_investors">
                            <i class="fa fa-save"></i>
                            <?php echo $this->lang->line('save')?>
                            </button>
                            <a href="<?php echo base_url('investors/listInvestors')?>" class="btn btn-info ">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/investors/index.js"></script>
<style type="text/css">
    textarea {
    white-space: pre;
    overflow-wrap: normal;
    overflow-x: scroll;
    }
</style>