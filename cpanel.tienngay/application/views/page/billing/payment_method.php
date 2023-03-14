<div class="right_col" role="main">
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3><?= $this->lang->line('Billing_Information')?></h3>

      </div>
    </div>
    <div class="col-xs-12 col-lg-8">
      <div class="x_panel">
        <div class="x_title">
          <h2> <strong><?= $this->lang->line('TOTAL_PAYMENT')?>:</strong></h2>

          <h2 style="float:right"><strong><?php echo number_format($this->cart->total())." vnđ"; ?></strong></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
          <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">


            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('phone_number')?>
              </label>
              <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">

                <div class="input-group" style="display:flex">
                  <span class="input-group-btn" style="width: 100px">
                    <select class="form-control" name="">
                      <option value="" selected>+84</option>
                    </select>
                  </span>
                  <input type="text" name='customer_bill_phone' class="form-control">
                </div>

              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Full_name')?>
              </label>
              <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                <input type="text" name='customer_bill_name' class="form-control col-md-7 col-xs-12">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('store')?>
              </label>
              <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                <select class="form-control" id="stores">
                <?php 
                     $userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
                     $stores = !empty($userInfo['stores']) ?  $userInfo['stores'] : array();
                     if(in_array('van-hanh', $groupRoles))
                     {
                       $stores =$storeData;
                     }
                     foreach($stores as $key =>  $value){
                      $store_name=(!empty($value->store_name)) ? $value->store_name : $value->name;
                       $store_id=(!empty($value->store_id)) ? $value->store_id : $value->_id->{'$oid'};
                ?>
                      <option value="<?= $store_id  ?>" selected><?= $store_name ?></option>
                     <?php }?>
                    </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Payments')?>
              </label>
              <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">

                <div class="radio">
                  <label>
                    <input type="radio" name="paymentmethod" checked> <?= $this->lang->line('Cash')?> - <small>( <?= $this->lang->line('Pay_at_the_store')?> )</small>
                  </label>

                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="paymentmethod"  disabled>  <?= $this->lang->line('ATM_card_Internet_Banking')?>- <small>( <?= $this->lang->line('Online_payment')?> )</small>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="paymentmethod"  disabled> <?= $this->lang->line('ATM_Online')?> - <small>( <?= $this->lang->line('Online_payment')?> )</small>
                  </label>
                </div>

              </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-xs-12 text-center ">
                <a href='<?php echo base_url('VimoBilling/listCart')?>' class="btn btn-secondary" style="width:110px;background: #dedede;"><?= $this->lang->line('Come_back')?></a>
                <a href='<?php echo base_url('VimoBilling')?>' class="btn btn-danger deleteAllCart" style="width:110px" ><?= $this->lang->line('Cancel')?></a>
                <button type="button" class="btn btn-success " data-toggle="modal" data-target="#billingConfirm" ><?= $this->lang->line('payment_confirm')?></button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php $this->load->view('page/modal/payment_confirm');?>
<script src="<?php echo base_url();?>assets/js/billing/payment.js"></script>