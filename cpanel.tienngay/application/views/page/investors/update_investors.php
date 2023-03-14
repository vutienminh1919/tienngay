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
                <h3><?php echo $this->lang->line('update_investors')?>
                    <br/><br/>
                    <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('investors/listInvestors')?>"><?php echo $this->lang->line('investors_list')?></a> / <a href="#"><?php echo $this->lang->line('update_investors')?></a></small>
                </h3>
            </div>
            <div class="title_right text-right">
                <span class="btn btn-info " id="update_en_btn">
                <i class="fa fa-edit"></i> Sửa
                </span>
                <a href="<?php echo base_url('investors/listInvestors')?>" class="btn btn-info ">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>
                </a>
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
                <form class="form-horizontal form-label-left" id="form_investors" action="<?php echo base_url("investors/doUpdateInvestors")?>" method="post">
                    <input type="hidden" name="id_investors" class="form-control " value="<?= !empty($investors->_id->{'$oid'}) ? $investors->_id->{'$oid'} : ""?>">
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('code')?><span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="code" name="code" value="<?php !empty($investors->code) ? print $investors->code : print "" ?>" required="" class="form-control">
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
                            <input type="text" id="merchant_id" name="merchant_id" required="" class="form-control" value="<?= !empty($investors->merchant_id) ?  $investors->merchant_id :  "" ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Merchant password ngân lượng<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="merchant_password" name="merchant_password" required="" class="form-control" value="<?= !empty($investors->merchant_password) ?  $investors->merchant_password :  "" ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Receiver email ngân lượng<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="receiver_email" name="receiver_email" required="" class="form-control" value="<?= !empty($investors->receiver_email) ?  $investors->receiver_email :  "" ?>">
                        </div>
                    </div>


                  
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('name')?><span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" name="name" value="<?php !empty($investors->name) ? print $investors->name : print "" ?>" required="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('dentity_card')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="dentity_card" value="<?php !empty($investors->dentity_card) ? print $investors->dentity_card : print "" ?>" name="dentity_card" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('date_of_birth')?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" required="" id="date_of_birth" value="<?php !empty($investors->date_of_birth) ? print $investors->date_of_birth : print "" ?>" name="date_of_birth" class="form-control phone-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('phone')?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="phone" name="phone" value="<?php !empty($investors->phone) ? print $investors->phone : print "" ?>" class="form-control phone-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('email')?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" required="" id="email" name="email" value="<?php !empty($investors->email) ? print $investors->email : print "" ?>" class="form-control email-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('address')?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="address" required="" id="address"  name="address" value="<?php !empty($investors->address) ? print $investors->address : print "" ?>" class="form-control email-autocomplete ui-autocomplete-input" autocomplete="off">
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
                            <input type="number" required="" id="tax_code" name="tax_code" value="<?php !empty($investors->tax_code) ? print $investors->tax_code : print "" ?>" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('balance')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" required="" id="balance" name="balance" value="<?php !empty($investors->balance) ? print $investors->balance : print "" ?>" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('percent_interest_investor')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" required="" id="percent_interest_investor" name="percent_interest_investor" value="<?php !empty($investors->percent_interest_investor) ? print $investors->percent_interest_investor : print "" ?>" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Kỳ hạn
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12 input-group m-input-group">
                            <input type="number" required="" id="period" name="period" class="form-control identify-autocomplete ui-autocomplete-input" value="<?php !empty($investors->period) ? print $investors->period : print "" ?>" autocomplete="off"> 
                            <span class="input-group-addon">
                                            <i class="text-black">Tháng</i>
                                        </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('form_of_receipt')?>
                      
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control district_shop"  placeholder="<?php echo $this->lang->line('level_pla')?>" name="form_of_receipt" id="form_of_receipt" required>
                                <option <?php (!empty($investors->form_of_receipt) && $investors->form_of_receipt=='1' ) ? print "selected" : print "" ?> value="1">Tiền mặt</option>
                                <option <?php (!empty($investors->form_of_receipt) && $investors->form_of_receipt=='2' ) ? print "selected" : print "" ?> value="2">Chuyển khoản</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('account_number')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="account_number" name="account_number"  value="<?php !empty($investors->account_number) ? print $investors->account_number : print "" ?>" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
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
                                <option <?php (!empty($investors->bank) && $investors->bank==$bank->_id->{'$oid'} ) ? print "selected" : print "" ?> value="<?= !empty($bank->_id->{'$oid'}) ? $bank->_id->{'$oid'} : "" ?>"><?= !empty($bank->name) ? $bank->name : "";?></option>
                                <?php }}?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('bank_branch')?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required="" id="bank_branch" name="bank_branch" value="<?php !empty($investors->bank_branch) ? print $investors->bank_branch : print "" ?>" class="form-control identify-autocomplete ui-autocomplete-input" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        <?php echo $this->lang->line('status')?>
                        </label>
                        <div class="col-lg-6 col-sm-12 col-xs-12 ">
                            <div class="radio-inline text-primary">
                                <label>
                                <input type="radio" name="status" value="active" <?php (!empty($investors->status) && $investors->status=='active' ) ? print "checked" : print "" ?> > <?php echo $this->lang->line('active')?>
                                </label>
                            </div>
                            <div class="radio-inline text-danger">
                                <label>
                                <input type="radio"   name="status" value="deactive"  <?php (!empty($investors->status) && $investors->status=='deactive' ) ? print "checked" : print "" ?> > <?php echo $this->lang->line('deactive')?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-success  update_investors">
                            <i class="fa fa-save"></i>
                            <?php echo $this->lang->line('save')?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/investors/index.js"></script>
<script type="text/javascript">
    $("input").prop('disabled', true);
    
    $(".update_investors").prop('disabled', true);
    
</script>
<style type="text/css">
    textarea {
    white-space: pre;
    overflow-wrap: normal;
    overflow-x: scroll;
    }
</style>