
<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$investor_code = !empty($_GET['investor']) ? $_GET['investor'] : "";
	?>
  <div class="row top_tiles">
	  <div class="col-xs-12">
		  <?php if ($this->session->flashdata('error')) { ?>
			  <div class="alert alert-danger alert-result">
				  <?= $this->session->flashdata('error') ?>
			  </div>
		  <?php } ?>
		  <?php if ($this->session->flashdata('success')) { ?>
			  <div class="alert alert-success alert-result">
				  <?= $this->session->flashdata('success') ?>
			  </div>
		  <?php } ?>
	  </div>
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>Quản lý hợp đồng đang vay
          <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#>">Quản lý hợp đồng đang vay</a>
					</small>
          </h3>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <div class="row">
            <div class="col-xs-12 col-lg-12">
              <div class="row">
				  <form action="<?php echo base_url('accountant/search')?>" method="get" style="width: 100%;">
					  <div class="col-lg-3">
						  <label></label>
						  <div class="input-group">
							  <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
							  <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>" >
						  </div>
					  </div>
					  <div class="col-lg-3">
						  <label></label>
						  <div class="input-group">
							  <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
							  <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>" >

						  </div>
					  </div>

					<div class="col-lg-2">
					  <label><?= $this->lang->line('Investors')?></label>
					  <select id="investor" class="form-control" name="investor">
						<option value=""><?= $this->lang->line('All')?></option>
						  <?php foreach ($investorData as $in) {?>
							  <option <?php echo $investor_code == $in->code ? 'selected' : ''?> value="<?php echo $in->code; ?>"><?php echo $in->name; ?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="col-lg-2">
					  <label>Phòng giao dịch</label>
					  <select id="province" class="form-control" name="store">
						<option value=""><?= $this->lang->line('All')?></option>
						  <?php foreach ($storeData as $p) {?>
							  <option <?php echo $store == $p->id ? 'selected' : ''?> value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="col-lg-2 text-right">
						<label></label>
					  <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
					</div>
				  </form>
              </div>

            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">

              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?= $this->lang->line('Contract_code')?></th>
                    <th><?= $this->lang->line('Investors')?></th> 
                      <th><?= $this->lang->line('Customer')?></th>
                      <th><?= $this->lang->line('CMT')?></th>
                      <th>Thời hạn vay</th>
                      <th><?= $this->lang->line('Disbursement_date')?></th>
						<th><?= $this->lang->line('Money_disbursed')?></th>
                  <th><?= $this->lang->line('Due_date_period')?></th> 
                   <th><?= $this->lang->line('Interest_payable_period')?></th> 
						<th>Tình trạng</th>
					 <th>Số ngày quá hạn</th> 
                      <th><?= $this->lang->line('See_details')?></th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if(!empty($contractData)){
                       foreach($contractData as $key => $contract){
                    ?>

                      <tr>
                        <td><?php echo $key+1?></td>
                       <!-- <td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td> -->
												<td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : $contract->code_contract ?></td>
                      <td><?= !empty($contract->investor_name) ? $contract->investor_name : ""?></td> 
                        <td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : ""?></td>
                        <td><?= !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : ""?></td>
                        <td><?= !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan : ""?></td>
                        <td><?= !empty($contract->disbursement_date) ? date('m/d/Y', intval($contract->disbursement_date)) : ""?></td>
					    <td><?= !empty($contract->loan_infor->amount_money) ? number_format($contract->loan_infor->amount_money ,0 ,'.' ,'.') : ""?></td>
                        <td><?= !empty($contract->detail->ngay_ky_tra) ? date('d/m/Y', intval($contract->detail->ngay_ky_tra)) : ""?></td>
                     <td><?= !empty($contract->detail->total_paid) ? number_format($contract->detail->total_paid ,0 ,'.' ,'.') : ""?></td>
						  <td>
							  <?php
							  if ($contract->status == 19) {
								  echo 'Đã tất toán';
							  } elseif ($contract->status == 17) {
								  if (!empty($contract->detail) && $contract->detail->status == 1) {
									  $current_day = strtotime(date('m/d/Y'));
									  $datetime = !empty($contract->detail->ngay_ky_tra) ? intval($contract->detail->ngay_ky_tra): $current_day;
									  $time = intval(($current_day - $datetime) / (24*60*60));
									  if ($time < -5) {
										  echo 'Chưa đến kỳ';
									  }else if ($time >= -5 && $time <= 3) {
										  echo ' tiêu chuẩn';
									  } else if ($time > 3 && $time < 34) {
										  echo 'Quá hạn '.$time.' '.$this->lang->line('days');
									  } else if ($time > 34 && $time < 64) {
										  echo ' xấu cấp 1';
									  } else if ($time > 65 && $time < 94) {
										  echo ' xấu cấp 2';
									  } else {
										  echo ' xấu cấp 3';
									  }
								  } else if (!empty($contract->detail) && $contract->status == 2) {
									  echo $this->lang->line('paid');
								  } else {
									  echo 'Đã quá hạn';
								  }
							  } elseif(in_array($contract->status, ["21","22","24"])) {
								  echo 'Chờ duyệt gia hạn';
							    } elseif(in_array($contract->status, ["19","23"])) {
								  echo 'Đã tất toán';
							  } else {
								  echo 'Chưa xác định';
							  }
							  ?>
						  </td>
						  <td>
							  <?php
							  if (!empty($contract->detail) && $contract->detail->status == 1) {
								  $current_day = strtotime(date('m/d/Y'));
								  $datetime = !empty($contract->detail->ngay_ky_tra) ? intval($contract->detail->ngay_ky_tra): $current_day;
								  $time = intval(($current_day - $datetime) / (24*60*60));
								  echo $time;
							  }
							  ?>
						  </td> 
                       <td style="text-align: -webkit-center;">
                        <a target="_blank" href="<?php echo base_url("accountant/view?id=").$contract->_id->{'$oid'}?>">
                          <i class="fa fa-lg fa-edit" style='margin-right: 10px;'></i>
                        </a>
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
<script src="<?php echo base_url();?>assets/js/accountant/index.js"></script>
