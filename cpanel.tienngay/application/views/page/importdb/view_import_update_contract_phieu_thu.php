
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
					<h3>Danh sách phiếu thu đã import cập nhật hợp đồng
						<br>
						<small>
							<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#>">Danh sách phiếu thu đã import cập nhật hợp đồng </a>
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
								<form action="<?php echo base_url('importDatabase/list_update_contract_phieu_thu')?>" method="get" style="width: 100%;">
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
										<th>Mã phiếu thu</th>
										<th>Ngày import</th>
										<th>NV import</th>
										
           
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
											
												
												<td><?= !empty($contract->data_post->code_contract_disbursement) ? $contract->data_post->code_contract_disbursement : "" ?></td>
											 <td><?= !empty($contract->data_post->code_contract) ? $contract->data_post->code_contract : "" ?></td>
											  <td><?= !empty($contract->data_post->code) ? $contract->data_post->code : "" ?></td>
											   <td><?= !empty($contract->created_at) ? date('d/m/Y',$contract->created_at) : "" ?></td>
											   <td><?= !empty($contract->email) ? $contract->email : "" ?></td>
			
												
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

