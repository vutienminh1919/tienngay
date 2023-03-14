<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	$tab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
	$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
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
				<div class="row">
					<div class="col-xs-12">
						<h3>Hợp đồng gia hạn cơ cấu
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#>">Hợp đồng gia hạn cơ cấu</a>
							</small>
						</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<form action="<?php echo base_url('temporary_plan/list_cc_gh') ?>"
									  method="get" style="width: 100%">
									<div class="col-xs-12">
										<div class="row">
											<input type="hidden" name="tab" value="<?= $tab ?>">

											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Từ</label>
													<input type="date" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Đến</label>
													<input type="date" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Tên khách hàng</label>
													<input type="text" name="full_name" class="form-control"
														   value="<?= $full_name ?>" placeholder="Nhập tên khách hàng">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Mã hợp đồng</label>
													<input type="text" name="code_contract_disbursement"
														   class="form-control"
														   value="<?= $code_contract_disbursement ?>"
														   placeholder="Nhập mã hợp đồng">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Mã phiếu ghi</label>
													<input type="text" name="code_contract" class="form-control"
														   value="<?= $code_contract ?>"
														   placeholder="Nhập mã phiếu ghi">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label for="">Phòng giao dịch</label>
												<select id="province" class="form-control" name="store">
													<option value=""><?= $this->lang->line('All') ?></option>
													<?php foreach ($storeData as $p) { ?>
														<option <?php echo $store == $p->id ? 'selected' : '' ?>
																value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2 text-right">
												<label for="">&nbsp;</label>
												<button class="btn btn-primary w-100"><i class="fa fa-search"
																						 aria-hidden="true"></i> <?php echo $this->lang->line('search') ?>
												</button>
											</div>
								
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-xs-12">
							<br>
						
						
							<div class="group-tabs" style="width: 100%;">
								<ul class="nav nav-tabs">
						   	<li class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'rerun_gh') ? 'active' : '' ?>">
										<a href="<?php echo base_url(); ?>/temporary_plan/list_cc_gh?tab=rerun_gh">DS hợp đồng gia hạn</a>
									</li>
										<li class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'rerun_cc') ? 'active' : '' ?>">
										<a href="<?php echo base_url(); ?>/temporary_plan/list_cc_gh?tab=rerun_cc">DS hợp đồng cơ cấu</a>
									</li>

								</ul>
								<div class="tab-content">
									
									<div role="tabpanel"
									 class="tab-pane <?= (isset($_GET['tab']) && $_GET['tab'] == 'rerun_cc') ? 'active' : '' ?>"
									 id="en">
									<br/>
									<?php if (isset($_GET['tab']) && $_GET['tab'] == 'rerun_cc') { ?>
										<div class="table-responsive">
											<div><?php echo $result_count; ?></div>
											<table id="datatable-button5" class="table table-striped datatablebutton">
												<thead>
												<tr>
													<th>#</th>
												

													<th>Mã HĐ</th>
													<th>Mã Phiếu ghi</th>
													<th>Tên khách hàng</th>
													<th>Số tiền phải thanh toán</th>
													<th>Hạn thanh toán</th>
													<th>Phòng giao dịch</th>
													<th>Trạng thái</th>

													<th>Chi tiết</th>
												</tr>
												</thead>

												<tbody>
												<?php
												if (!empty($temporary_planData)) {
													foreach ($temporary_planData as $key => $tran) {

														?>
														<tr>
															<td><?php echo $key + 1 ?></td>
														

															<td id='<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'>
																<?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?>


															</td>
															<td><?= !empty($tran->code_contract) ? $tran->code_contract : "" ?></td>

															<td><?= !empty($tran->customer_infor->customer_name) ? $tran->customer_infor->customer_name : "" ?></td>
															<td><?= !empty($tran->detail->total_paid) ? number_format($tran->detail->total_paid, 0, ',', ',') : "" ?></td>

															<td><?= !empty($tran->detail->ngay_ky_tra) ? date('d/m/Y', intval($tran->detail->ngay_ky_tra)) : "" ?></td>
															<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>

															<td><?= !empty($tran->status) ? contract_status($tran->status) : ""; ?></td>

															<input type='hidden'
																   value='<?= !empty($tran->note) ? $tran->note : "" ?>'
																   id='note-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
															</td>
															<td><a class="btn btn-primary ds_hop_dong_cc"  data-id="<?= !empty($tran->id_contract) ? $tran->id_contract : '' ?>"
																   href="#">
																	Cơ cấu liên quan
																</a> <br/>
															
															</td>

														</tr>
													<?php }
												} ?>
												</tbody>
											</table>
											<div class="pagination pagination-sm">
												<?php echo $pagination ?>
											</div>
										</div>
									<?php } ?>
								</div>
									<div role="tabpanel"
									 class="tab-pane <?= (isset($_GET['tab']) && $_GET['tab'] == 'rerun_gh') ? 'active' : '' ?>"
									 id="en">
									<br/>
									<?php if (isset($_GET['tab']) && $_GET['tab'] == 'rerun_gh') { ?>
										<div class="table-responsive">
											<div><?php echo $result_count; ?></div>
											<table id="datatable-button5" class="table table-striped datatablebutton">
												<thead>
												<tr>
													<th>#</th>
												

													<th>Mã HĐ</th>
													<th>Mã Phiếu ghi</th>
													<th>Tên khách hàng</th>
													<th>Số tiền phải thanh toán</th>
													<th>Hạn thanh toán</th>
													<th>Phòng giao dịch</th>
													<th>Trạng thái</th>

													<th>Chi tiết</th>
												</tr>
												</thead>

												<tbody>
												<?php
												if (!empty($temporary_planData)) {
													foreach ($temporary_planData as $key => $tran) {

														?>
														<tr>
															<td><?php echo $key + 1 ?></td>
															

															<td id='<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'>
																<?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?>

															</td>
															<td><?= !empty($tran->code_contract) ? $tran->code_contract : "" ?></td>

															<td><?= !empty($tran->customer_infor->customer_name) ? $tran->customer_infor->customer_name : "" ?></td>
															<td><?= !empty($tran->detail->total_paid) ? number_format($tran->detail->total_paid, 0, ',', ',') : "" ?></td>

															<td><?= !empty($tran->detail->ngay_ky_tra) ? date('d/m/Y', intval($tran->detail->ngay_ky_tra)) : "" ?></td>
															<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>

															<td><?= !empty($tran->status) ? contract_status($tran->status) : ""; ?></td>

															<input type='hidden'
																   value='<?= !empty($tran->note) ? $tran->note : "" ?>'
																   id='note-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
															</td>
															<td><a class="btn btn-primary ds_hop_dong_gh" data-id="<?= !empty($tran->id_contract) ? $tran->id_contract : '' ?>" 
																   href="#">
																Gia hạn liên quan
																</a> <br/>
														
															</td>

														</tr>
													<?php }
												} ?>
												</tbody>
											</table>
											<div class="pagination pagination-sm">
												<?php echo $pagination ?>
											</div>
										</div>
									<?php } ?>
								</div>
						
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="modal fade" id="list_giahan_cc" tabindex="-1" role="dialog" aria-labelledby="ContractHistoryModal"
   aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title " id="title_list_cc_gh">DANH SÁCH HỢP ĐỒNG GIA HẠN</h5>
        <hr>
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped" style="width: 100%">
            <thead>
            <tr>
              <th>#</th>
              <th>Mã hợp đồng</th>
              <th>Mã phiếu ghi</th>
              <th>Loại</th>
               <th>Ngày</th>
              <th>Trạng thái</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody id='list_contract_gh_cc'>
        
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
	<script src="<?php echo base_url(); ?>assets/js/temporary_plan/index.js"></script>
	<script type="text/javascript">
		$(function () {
			$('.selectall').click(function () {
				if (this.checked) {
					$(".checkbox_tran_kt").prop("checked", true);
				} else {
					$(".checkbox_tran_kt").prop("checked", false);
				}
			});

			$(".checkboxes").click(function () {
				var numberOfCheckboxes = $(".checkboxes").length;
				var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
				if (numberOfCheckboxes == numberOfCheckboxesChecked) {
					$(".selectall").prop("checked", true);
				} else {
					$(".selectall").prop("checked", false);
				}
			});
		});
		$(document).ready(function () {


			// Show Input element
			$('.edit').click(function () {
				var status = $(this).data('status');
				console.log(status);

				$('.txtedit').hide();
				$(this).next('.txtedit').show().focus();
				$(this).hide();

			});

			// Save data
			$(".txtedit").on('focusout', function () {

				// Get edit id, field name and value
				var id = this.id;
				var split_id = id.split("-");
				var field_name = split_id[0];
				var edit_id = split_id[1];
				var value = $(this).val();

				// Hide Input element
				$(this).hide();

				// Hide and Change Text of the container with input elmeent
				$(this).prev('.edit').show();
				$(this).prev('.edit').text(value);

				// Sending AJAX request
				$.ajax({
					url: _url.base_url + 'temporary_plan/update',
					type: 'post',
					data: {field: field_name, value: value, id: edit_id},
					success: function (response) {
						console.log('Save successfully');
					}
				});

			});

		});
	</script>
	<style type="text/css">
		.container {
			margin: 0 auto;
		}


		.edit {
			width: 100%;
			height: 25px;
		}

		.editMode {
			/*border: 1px solid black;*/

		}

		.txtedit {
			display: none;
			width: 99%;
			height: 30px;
		}


		table tr:nth-child(1) th {
			color: white;

		}


	</style>
