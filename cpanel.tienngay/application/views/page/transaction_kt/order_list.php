
<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <div class="col-xs-12 col-lg-1">
              <h2><?php echo $this->lang->line('order_list')?></h2>
            </div>
            <div class="title_right text-right">
                <a href="<?php echo base_url('transaction')?>" class="btn btn-info ">
          <i class="fa fa-hand-o-left" aria-hidden="true"></i> Quay lại
        </a>
      </div>
         
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">
              <div class="row">

              </div>
            </div>
            <div class="col-xs-12">

              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo $this->lang->line('transaction_code')?></th>
                      <th><?php echo $this->lang->line('Service')?></th>
                      <th><?php echo $this->lang->line('time')?></th>
                      <th><?php echo $this->lang->line('publisher')?></th>
                      <th><?php echo $this->lang->line('status')?></th>
                      <th><?php echo $this->lang->line('account')?></th>
                      <th><?php echo $this->lang->line('Amount_money')?></th>
                      <th><?php echo $this->lang->line('Amount')?></th>
                      <th><?php echo $this->lang->line('the_payment')?></th>
                      <th><?php echo $this->lang->line('time_payment')?></th>
                      <th><?php echo $this->lang->line('note')?></th>
                    </tr>
                  </thead>

					<tbody>
					<?php
					if(!empty($orderData)){
					foreach($orderData as $key => $order){
						?>
							<tr class="<?php echo isset($order->error) && $order->error == 'true' ? 'warning-transaction' : ''?>">
							  <td><?php echo $key + 1?></td>
							  <td><?= !empty($order->mc_request_id) ? $order->mc_request_id : "" ?></td>
							  <td><?= !empty($order->service_name) ? $order->service_name : "" ?></td>
							  <td><?= !empty($order->created_at) ? date('d/m/Y H:i:s', intval($order->created_at) ) : "" ?></td>
							  <td><?= !empty($order->publisher_name) ? $order->publisher_name : "" ?></td>
							  <td><?= !empty($order->status) ? $order->status : "" ?></td>
							  <td><?= !empty($order->detail->customer_code) ? $order->detail->customer_code : "" ?></td>
							  <td><?= !empty($order->detail->bill_payment->amount) ? number_format($order->detail->bill_payment->amount ,0 ,',' ,',') : number_format($order->amount ,0 ,'.' ,'.')?></td>
							  <td><?= !empty($order->quantity) ? $order->quantity : "" ?></td>
							  <td class="text-right"><?= !empty($order->money) ? number_format($order->money ,0 ,',' ,',') : ""?></td>
							  <td><?= $order->status == 'success' ?  date('d/m/Y H:i:s', intval($order->updated_at) ) : ""?></td>
							  <td>
								  <?php
								  $note = '';
									if (isset($order->error) && $order->error == 'true') {
										$note = !empty($order->response_error) ? $order->response_error->error_message : '';
									}
									echo $note;
								  ?>
							  </td>
							</tr>
						<?php }
						} ?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="5"></td>
						<td colspan="2">
							<a href="<?php echo base_url('transaction/detail/'.$transaction->id)?>" class="btn btn-info">
								<?php echo $this->lang->line('print_order')?>
							</a>
						</td>
						<td>
							<?php echo $this->lang->line('Total_money')?>
						</td>
						<td class="text-right" colspan="2">
							<strong>
								<?php echo number_format($transaction->total ,0 ,',' ,',')?> đ
							</strong>
						</td>
						<td colspan="2"></td>
					</tr>
					</tfoot>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
