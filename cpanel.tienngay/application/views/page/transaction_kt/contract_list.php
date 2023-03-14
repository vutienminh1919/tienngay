
<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <div class="row">
            <div class="col-xs-12 col-lg-1">
              <h2><?php echo $this->lang->line('order_list')?></h2>
            </div>
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
                      <th>Mã hợp đồng</th>
                      <th><?php echo $this->lang->line('Amount_money')?></th>
                      <th><?php echo $this->lang->line('note')?></th>
                    </tr>
                  </thead>

					<tbody>
					<?php
					if(!empty($transaction)){
						?>
							<tr>
							  <td><?php echo 1?></td>
							  <td><?= !empty($transaction->code) ? $transaction->code : "" ?></td>
							  <td>Thanh toán hợp đồng</td>
							  <td><?= !empty($transaction->created_at) ? date('d/m/Y H:i:s', intval($transaction->created_at) ) : "" ?></td>
							  <td>Tienngay.vn</td>
							  <td><?php
								  $status = '';
								  if ($transaction->status == 1) {
									  $status = 'Thành công';
								  } else if ($transaction->status == 2) {
									  $status = 'Đang chờ';
								  } else if ($transaction->status == 3) {
									  $status = 'Đã hủy';
								  } else {
									  $status = 'Thất bại';
								  }
								  echo $status;
								  ?>
							  </td>
							  <!-- <td><?= !empty($transaction->code_contract) ? $transaction->code_contract : "" ?></td> -->
								<td><?= !empty($transaction->code_contract_disbursement) ? $transaction->code_contract_disbursement : "" ?></td>
							  <td class="text-right"><?= !empty($transaction->total) ? number_format($transaction->total ,0 ,',' ,',') : ""?></td>
							  <td><?= !empty($transaction->note) ? $transaction->note : "" ?></td>
							</tr>
						<?php
						} ?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="5"></td>
						<td colspan="2">
							<?php
							if (!empty($transaction->status) && $transaction->status == 1) {
								?>
								<a href="<?php echo base_url('transaction/detail_contract/'.$transaction->id)?>">
									<i class="fa fa-edit">&nbsp;<?php echo $this->lang->line('print_order')?></i>
								</a>
							<?php
							}
							?>
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
