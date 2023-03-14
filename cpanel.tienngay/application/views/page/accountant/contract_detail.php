
<!-- page content -->
<div class="right_col" role="main">
  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>Chi tiết kỳ trả lãi
					<br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('accountant')?>">Quản lý hợp đồng đang vay</a> / <a href="#">Chi tiết kỳ trả lãi</a> 
					</small>
				</h3>
      </div>
      <div class="title_right text-right">
        <a href="<?php echo base_url('accountant')?>" class="btn btn-info ">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
			<?php echo $this->lang->line('back')?>
        </a>
      </div>
    </div>
  </div>
	<div class="col-xs-12">
		<div class="row">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
			<?php } ?>

		</div>
	</div>
  <div class="row top_tiles">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
			<div class="x_title col-xs-12">
				<div class="row flex" style="justify-content: center;">
					<div class="col-xs-12  col-md-6">
						<div class="row">
							<div class="col-xs-6">
								Mã hợp đồng
							</div>
							<div class="col-xs-6 text-right">
								<strong><?php echo $contractDB->code_contract?></strong>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								Khách hàng
							</div>
							<div class="col-xs-6 text-right">
								<strong><?php echo $contractDB->customer_infor->customer_name?></strong>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								Số CMND / CCCD
							</div>
							<div class="col-xs-6 text-right">
								<strong><?php echo $contractDB->customer_infor->customer_identify?></strong>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								Số điện thoại
							</div>
							<div class="col-xs-6 text-right">
								<strong><?php echo $contractDB->customer_infor->customer_phone_number?></strong>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								Ngày giải ngân
							</div>
							<div class="col-xs-6 text-right">
								<strong><?= !empty($contractDB->disbursement_date) ? date('d/m/Y', intval($contractDB->disbursement_date)) : ""?></strong>
							</div>
						</div>
					</div>

					<div class="col-xs-12  col-md-6">
						<div class="row">
							<div class="col-xs-6">
								Số tiền vay
							</div>
							<div class="col-xs-6 text-right">
								<strong><?php echo number_format($contractDB->loan_infor->amount_money)?></strong>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								Nhà đầu tư
							</div>
							<div class="col-xs-6 text-right">
								<strong><?php echo $contractDB->investor_name?></strong>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								Tổng tiền phải trả đến hạn
							</div>
							<div class="col-xs-6 text-right">
								<strong><?php echo !empty($contractDB->total_money_paid) ? number_format($contractDB->total_money_paid) : ''?></strong>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								Gốc còn lại
							</div>
							<div class="col-xs-6 text-right">
								<strong><?php echo !empty($contractDB->total_money_remaining) ? number_format($contractDB->total_money_remaining) : ''?></strong>
							</div>
						</div>
					</div>
				</div>
			</div>
          <div class="row">
            <div class="col-xs-12">
              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?= $this->lang->line('Pay_date')?></th>
                      <th>Số tiền phải trả</th>
					  <th><?= $this->lang->line('Principal_payment')?></th>
                      <th><?= $this->lang->line('Interest_payable')?></th>
					  <th><?= $this->lang->line('Principal_remaining')?></th>
                      <th><?= $this->lang->line('days_to_pay_interest')?></th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if(!empty($contractData)){
                       foreach($contractData as $key => $contract){
                    ?>

                      <tr>
                        <td><?php echo $key+1?></td>
                        <td><?= !empty($contract->ngay_ky_tra) ? date('d/m/Y', intval($contract->ngay_ky_tra)) : ""?></td>
                        <td><?= number_format(((int)$contract->tien_goc_1ky + (int)$contract->lai_ky) ,0 ,'.' ,'.')?></td>
                        <td><?= !empty($contract->tien_goc_1ky) ? number_format($contract->tien_goc_1ky ,0 ,'.' ,'.') : ""?></td>
                        <td><?= !empty($contract->lai_ky) ? number_format($contract->lai_ky ,0 ,'.' ,'.') : ""?></td>
                        <td><?= !empty($contract->tien_goc_con) ? number_format($contract->tien_goc_con ,0 ,'.' ,'.') : ""?></td>
						  <td>
							  <?php
							  if ($contract->status == 1) {
								  $current_day = strtotime(date('m/d/Y'));
								  $datetime = !empty($contract->ngay_ky_tra) ? intval($contract->ngay_ky_tra): $current_day;
								  $time = intval(($current_day - $datetime) / (24*60*60));
								  if ($time < -5) {
									  echo 'Chưa đến kỳ';
								  }else if ($time >= -5 && $time <= 3) {
									  echo 'tiêu chuẩn';
								  } else if ($time > 3 && $time < 34) {
								  	echo 'Quá hạn '.$time.' '.$this->lang->line('days');
								  } else if ($time > 34 && $time < 64) {
								  	echo 'xấu cấp 1';
								  } else if ($time > 65 && $time < 94) {
									  echo 'xấu cấp 2';
								  } else {
									  echo 'xấu cấp 3';
								  }
							  } else if ($contract->status == 2) {
							  	echo $this->lang->line('paid');
							  } else {
								  echo 'Đã quá hạn';
							  }
							  ?>
						  </td>
                      </tr>
                    <?php }} ?>

                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
