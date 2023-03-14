
<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
 $customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
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
					<h3>Danh sách hợp đồng cơ cấu
						<br>
						<small>
							<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#>">Danh sách hợp đồng cơ cấu </a>
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
								<form action="<?php echo base_url('importDatabase/list_import_cc')?>" method="get" style="width: 100%;">
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
							<input type="hidden" name="type" class="form-control" value="<?= !empty($type) ?  $type : ""?>" >
						<div class="col-lg-2">
										<label>Họ và tên</label>
										<input type="text" name="customer_name" class="form-control" placeholder="Tên khách hàng" value="<?php echo $customer_name; ?>">
									</div>

									<div class="col-lg-2">
										<label>Mã hợp đồng</label>
										<input type="text" name="code_contract_disbursement" class="form-control" placeholder="Mã hợp đồng" value="<?php echo $code_contract_disbursement; ?>">
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
							<div ><?php echo $result_count;?></div>
							<div class="table-responsive">
								<table id="datatable-button" class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										<th>Mã hợp đồng</th>
										<th>Mã phiếu ghi</th>
										<th>Ngày cơ cấu</th>
										<th>Số tháng cơ cấu</th>
										<th>Số tiền cơ cấu</th>
										<th>Hình thức vay(cơ cấu)</th>
										<th>Trạng thái</th>
           <th>Chi tiết</th>
									</tr>
									</thead>

									<tbody>
									<?php
									if(!empty($contractData)){
										$time=0;
										foreach($contractData as $key => $contract){
										

											?>

											<tr>
												<td><?php echo $key+1?></td>
											
												
												<td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : "" ?></td>
											 <td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
											 <td><?= !empty($contract->structure->structure_date) ? date('d/m/Y', $contract->structure->structure_date) : "" ?></td> 
												<td><?= !empty($contract->structure->number_day_loan) ? $contract->structure->number_day_loan/30 : ""?></td>
												<td><?= !empty($contract->structure->amount_money) ? $contract->structure->amount_money : ""?></td>
												<td><?= !empty($contract->structure->type_loan->text) ? $contract->structure->type_loan->text : ""?></td>
												<td><?= !empty($contract->status) ? contract_status($contract->status) : ""?></td>
            <td> <a class="btn btn-primary" target="_blank"  href="<?php echo base_url("accountant/view_v2?id=").$contract->_id->{'$oid'}?>" >
							                 Chi tiết 
							              </a> </td>
												
											</tr>
										<?php }} ?>

									</tbody>
								</table>
								<div class="">
									<?php echo $pagination ?>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

