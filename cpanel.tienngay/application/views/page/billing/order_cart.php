<?php
  $total = $this->cart->total_items();
  if($total > 0){
?>
<div class="right_col" role="main">

  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3><?= $this->lang->line('Order')?></h3>

      </div>
    </div>
    <div class="col-xs-12">
      <div class="x_panel" >
        <div class="x_content">
          <table class="table table-striped table-interest" >
            <thead  class="bg-primary">
              <tr>
                <th class="text-center"><?= $this->lang->line('STT')?></th>
                <th><?= $this->lang->line('Service')?></th>
                <th><?= $this->lang->line('Publisher')?></th>
                <th class=""><?= $this->lang->line('SĐT_MaKH')?></th>
                <th class="text-right"><?= $this->lang->line('Denomination_Amount')?></th>
                <th class="text-right"><?= $this->lang->line('Amount')?></th>
                <th class="text-right"><?= $this->lang->line('into_money')?></th>
                <th class="text-center"><?= $this->lang->line('Manipulation')?></th>
              </tr>
            </thead>
            <tbody>
              <?php
                    if(!empty($listCart)){
                        $stt = 0;
                        foreach($listCart as $key => $cart){
                            $stt ++;
               ?>
                <tr class='billing_<?= !empty($cart['id']) ? $cart['id'] : ""?>'>
                  <td class="text-center"><?php echo $stt ?></td>
                  <td><?= !empty($cart['name']) ? $cart['name'] : "" ?></td>
                  <td ><?= !empty($cart['publisher_name']) ? $cart['publisher_name'] : "" ?></td>
                  <td class="">
                    <?= !empty($cart['customer_code']) ? $cart['customer_code'] : "" ?> 
                  </td>
                  <td class="text-right"><?= !empty($cart['price']) ? number_format($cart['price']) : "" ?></td>
                  <td class="text-center">
                    <?php 
                      $service_code = !empty($cart['service_code']) ? $cart['service_code'] : "";
                      if($service_code == 'PINCODE_TELCO' || $service_code == 'PINCODE_GAME'){
                    ?>
                      <button style="width:24px">+</button>
                      <input type="text" class=" text-right" disabled value="<?= !empty($cart['qty']) ? $cart['qty'] : "" ?>" style="width: 50px;display: inline-block;margin-right:3px">
                      <button style="width:24px">-</button>
                    <?php }?>
                  </td>
                 
                  <td class="text-right"><?= !empty($cart['subtotal']) ? number_format($cart['subtotal']) : "" ?></td>
                  <td class="text-center">
                    <button class="btn btn-danger deleteCart" data-id="<?= !empty($cart['id']) ? $cart['id'] : ""?>" data-rowid="<?= !empty($cart['rowid']) ? $cart['rowid'] : ""?>"  >
                      <i class="fa fa-trash"></i> <?= $this->lang->line('detele')?>
                    </button>
                  </td>
                </tr>
              <?php } }?>

            </tbody>
            <tfoot>
              <tr class="bg-primary">
                <td colspan="8" class="text-center">
                  <h4 style="margin:0">
                    <?= $this->lang->line('TOTAL_PAYMENT')?> : <span class='total_cart'><?php echo number_format($this->cart->total()); ?> VNĐ</span>
                  </h4>
                </td>
              </tr>
            </tfoot>
          </table>

          <p class="text-center">
			  <?php
			  if ($total < 1  ) { ?>
            <a  class="btn btn-secondary" href='<?php echo base_url('VimoBilling')?>' style="width:110px;background: #e2e2e2;"><?= $this->lang->line('Add_service')?></a>
			  <?php } ?>
            <button class="btn btn-danger deleteAllCart" style="width:110px" ><?= $this->lang->line('Cancel_order')?></button>
            <a href="<?php echo base_url("VimoBilling/paymentMethod")?>" class="btn btn-success" style="width:110px" ><?= $this->lang->line('payment')?></a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script src="<?php echo base_url();?>assets/js/billing/querybill.js"></script>
 <?php }else{?>
  <div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3><?= $this->lang->line('Order')?></h3>

      </div>
    </div>
    <div class="col-xs-12">
      <div class="x_panel" >
        <div class="x_content">
<table class="table table-striped table-interest" >
            <tbody>
              <tr>
                <td colspan="8"  style="font-size:18px;text-align:center;padding: 64px 0;">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-shopping-cart fa-stack-1x"></i>
                    <i class="fa fa-ban fa-stack-2x text-danger"></i>
                  </span>
                  <?= $this->lang->line('No_products')?>

                </td>
              </tr>
              
            </tbody>
          </table>
          <p class="text-center">
            <a  class="btn btn-secondary" href='<?php echo base_url('VimoBilling')?>' style="width:110px;background: #e2e2e2;"><?= $this->lang->line('Add_service')?></a>
          </p>
          </div>
          </div>
          </div>
          </div>
          </div>
 <?php }?>
