<!-- page content -->
<div class="right_col" role="main">
	<div class="loading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử Lý...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>
					Lead
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('lead') ?>">Quản lý lead</a>
					</small>
				</h3>
			</div>
			<?php if (in_array('tbp-cskh', $groupRoles) || in_array('supper-admin', $groupRoles)) {
				?>
				<div class="">
					<button style="margin-left: 700px" class="btn btn-info " data-toggle="modal"
							data-target="#addCSKHModal"><i
								class="fa fa-plus" aria-hidden="true"></i> Chọn CSKH
					</button>
				</div>
			<?php } ?>
			<?php if (in_array('tbp-cskh', $groupRoles) || in_array('supper-admin', $groupRoles)) {
				?>
				<div class="">
					<button class="btn btn-info modal_cskh" data-toggle="modal" data-target="#addNewKHModal"><i
								class="fa fa-plus" aria-hidden="true"></i> Thêm mới
					</button>
				</div>
			<?php } ?>
			<?php if (in_array('tbp-cskh', $groupRoles) || in_array('supper-admin', $groupRoles)) {
				?>
				<div class="">
					<button class="btn btn-info " data-toggle="modal" data-target="#delCSKHModal"><i
								class="fa fa-plus" aria-hidden="true"></i> Xóa CSKH
					</button>
				</div>
			<?php } ?>
			<?php if (in_array('tbp-cskh', $groupRoles) || in_array('supper-admin', $groupRoles)) {
				?>
				<div class="">
					<button class="btn btn-default " data-toggle="modal" data-target="#backDelete"> Back delete
					</button>
				</div>
			<?php } ?>

		</div>
	</div>
	<div class="col-xs-12">
		<form action="<?php echo base_url('lead_custom') ?>" method="get" style="width: 100%;">
			<div class="row">
				<div class="col-lg-2">
					<div class="input-group">
						<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
						<input type="datetime-local" name="fdate" class="form-control"
							   value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : "" ?>">
					</div>
				</div>
				<div class="col-lg-2">
					<div class="input-group">
						<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
						<input type="datetime-local" name="tdate" class="form-control"
							   value="<?= isset($_GET['tdate']) ? $_GET['tdate'] : "" ?>">
					</div>
				</div>
				<div class="col-lg-2">

						<input type="text" name="sdt" class="form-control"
							   value="<?= isset($_GET['sdt']) ? $_GET['sdt'] : "" ?>" placeholder="Nhập số điện thoại">

				</div>
				<div class="col-lg-2">

						<input type="text" name="fullname" class="form-control"
							   value="<?= isset($_GET['fullname']) ? $_GET['fullname'] : "" ?>"
							   placeholder="Nhập họ và tên">

				</div>
				<div class="col-lg-2">
					<select class="form-control" name="cskh" id="cskh">
						<option value="">Chọn CSKH</option>
						<?php
						if (!empty($cskhData)) {
							$cskh = isset($_GET['cskh']) ? $_GET['cskh'] : "";
							foreach ($cskhData as $key => $cskh1) {
								foreach ($cskh1 as $key => $val) {
									?>
									<option <?= ($cskh == $val->email) ? "selected" : "" ?>
											value="<?= !empty($val->email) ? $val->email : ""; ?>"><?= !empty($val) ? $val->email : ""; ?></option>
								<?php }
							}
						} ?>
					</select>

				</div>
				<div class="col-lg-2">
					<select class="form-control" name="status_sale_1" id="status_sale_1">
						<option value="">Chọn trạng thái</option>
						<?php
						$status_sale = !empty($_GET['status_sale_1']) ? $_GET['status_sale_1'] : "";
							foreach (lead_status() as $key => $value) { ?>
									<option <?= ($status_sale == $key) ? "selected" : "" ?>
										value="<?= !empty($key) ? $key : ""; ?>"><?= !empty($value) ? $value : ""; ?></option>
								<?php
							}
						 ?>
					</select>
				</div>


				<input type="hidden" name="tab" class="form-control"
					   value="<?= isset($_GET['tab']) ? $_GET['tab'] : "" ?>">
				<?php if($_GET['tab'] == '15') { ?>
						<div class="col-lg-2">
							<select class="form-control priority" name="priority">
								<option value="">Chọn độ ưu tiên</option>
								<?php 
								$priority = isset($_GET['priority']) ? $_GET['priority'] : ""; ?>
								<option value="2" <?= ($priority == '2') ? 'selected' : ''  ?>>Trung bình</option>
								<option value="3" <?= ($priority == '3') ? 'selected' : ''  ?>>Thấp</option>
							</select>
						</div> <?php 
						} 	else { ?>
							<div class="col-lg-2">
							<select class="form-control priority" name="priority">
								<option value="">Chọn độ ưu tiên</option>
								<?php
								$priority = isset($_GET['priority']) ? $_GET['priority'] : "";
								foreach (lead_priority(null, false) as $key => $item) { ?>
									<option value="<?= $key ?>" <?= ($priority == $key) ? 'selected' : '' ?>><?= $item ?></option>
								<?php } ?>
							</select>
							</div> <?php 
						} 
				?>

				<input type="hidden" name="tab" class="form-control"
					   value="<?= isset($_GET['tab']) ? $_GET['tab'] : "" ?>">
				<?php if($_GET['tab'] == '15') { ?>
						<div class="col-lg-2">
							<select class="form-control source" name="source_s">
								<option value="">Chọn Nguồn</option>
								<?php 
								$nguon = isset($_GET['source_s']) ? $_GET['source_s'] : "";
								if (isset($source_active)) { ?>
									<?php	foreach ($source_active as $key => $item) { ?>
										<option value="<?= $item ?>" <?= ($nguon == $item) ? 'selected' : '' ?> > <?= lead_nguon($item) ?></option>
									<?php } 
								}?>
							</select>
						</div> <?php 
						} 	else { ?>
							<div class="col-lg-2">
							<select class="form-control source" name="source_s">
								<option value="">Chọn Nguồn</option>
								<?php
								$nguon = isset($_GET['source_s']) ? $_GET['source_s'] : "";
								foreach (lead_nguon(null, false) as $key => $item) { ?>
									<option value="<?= $key ?>" <?= ($nguon == $key) ? 'selected' : '' ?>><?= $item ?></option>
								<?php } ?>
							</select>
							</div> <?php 
						} 
				?>

				<div class="col-lg-2 text-right">
					<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																		   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
					</button>
				</div>
			</div>
		</form>
		<div class="x_panel">
			<div class="x_content">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
						<?php if (in_array('tbp-cskh', $groupRoles) || in_array('supper-admin', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('marketing', $groupRoles)) {
							?>
							<li role="presentation"
								class="<?= (isset($_GET['tab']) && $_GET['tab'] == 1) ? 'active' : "" ?>"><a
										href="<?php echo base_url() ?>lead_custom?tab=1" id="tab001">Tất cả</a>
							</li>
							<li role="presentation"
								class="<?= (isset($_GET['tab']) && $_GET['tab'] == 2) ? 'active' : "" ?>"><a
										href="<?php echo base_url() ?>lead_custom?tab=2" id="tab002">Chưa phân
									công</a>
							</li>
						<?php } ?>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 6) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=6" id="tab006">Cần chăm sóc tiếp</a>
						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 3) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=3" id="tab003">Đã phân công</a>
						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 4) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=4" id="tab004">Chưa xử lý</a>
						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 5) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=5" id="tab005">Hẹn đến PGD</a>
						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 10) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=10" id="tab0010">PGD trả về</a>
						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 11) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=11" id="tab0011">PGD hủy</a>
						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 12) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=12" id="tab0012">Search Lead</a>
						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 13) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=13" id="tab0013">Tái vay</a>
						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 14) ? 'active' : "" ?>">

							<a href="<?php echo base_url() ?>lead_custom?tab=14" id="tab0014"
								<?= in_array('cskh',$groupRoles)? "": 'style="display: none"' ?>
							>Cuộc gọi nhỡ</a>

						</li>
						<li role="presentation"
							class="<?= (isset($_GET['tab']) && $_GET['tab'] == 15) ? 'active' : "" ?>"><a
									href="<?php echo base_url() ?>lead_custom?tab=15" id="tab0015">Nguồn Lead Thô</a>
						</li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<?php if (in_array('tbp-cskh', $groupRoles) || in_array('supper-admin', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('marketing', $groupRoles)) {
							?>
							<?php if (isset($_GET['tab']) && $_GET['tab'] == 1) { ?>
								<div role="tabpanel"
									 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 1) ? 'active in' : "" ?>"
									 id="tab_content1" aria-labelledby="tab001">
									<?php $this->load->view('page/lead/debt_detail_tab001'); ?>
								</div>
							<?php } ?>
							<?php if (isset($_GET['tab']) && $_GET['tab'] == 2) { ?>
								<div role="tabpanel"
									 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 2) ? 'active in' : "" ?>"
									 id="tab_content2" aria-labelledby="tab002">
									<?php $this->load->view('page/lead/debt_detail_tab002'); ?>
								</div>
							<?php } ?>
						<?php } ?>
						<?php if (isset($_GET['tab']) && $_GET['tab'] == 3) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 3) ? 'active in' : "" ?>"
								 id="tab_content3" aria-labelledby="tab003">
								<?php $this->load->view('page/lead/debt_detail_tab003'); ?>
							</div>
						<?php } ?>
						<?php if (isset($_GET['tab']) && $_GET['tab'] == 4) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 4) ? 'active in' : "" ?>"
								 id="tab_content4" aria-labelledby="tab004">
								<?php $this->load->view('page/lead/debt_detail_tab004'); ?>
							</div>
						<?php } ?>
						<?php if (isset($_GET['tab']) && $_GET['tab'] == 5) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 5) ? 'active in' : "" ?>"
								 id="tab_content5 " aria-labelledby="tab005">
								<?php $this->load->view('page/lead/debt_detail_tab005'); ?>
							</div>
						<?php } ?>
						<?php if (isset($_GET['tab']) && $_GET['tab'] == 6) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 6) ? 'active in' : "" ?>"
								 id="tab_content6 " aria-labelledby="tab006">
								<?php $this->load->view('page/lead/debt_detail_tab006'); ?>
							</div>
						<?php } ?>
						<?php if (isset($_GET['tab']) && $_GET['tab'] == 10) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 10) ? 'active in' : "" ?>"
								 id="tab_content10 " aria-labelledby="tab0010">
								<?php $this->load->view('page/lead/debt_detail_tab0010'); ?>
							</div>
						<?php } ?>
						<?php if (isset($_GET['tab']) && $_GET['tab'] == 11) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 11) ? 'active in' : "" ?>"
								 id="tab_content11 " aria-labelledby="tab0011">
								<?php $this->load->view('page/lead/debt_detail_tab0011'); ?>
							</div>
						<?php } ?>
						<?php if (isset($_GET['tab']) && $_GET['tab'] == 12) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 12) ? 'active in' : "" ?>"
								 id="tab_content12 " aria-labelledby="tab0012">
								<?php $this->load->view('page/lead/debt_detail_tab0012'); ?>
							</div>
						<?php } ?>
						<?php if (isset($_GET['tab']) && $_GET['tab'] == 13) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 13) ? 'active in' : "" ?>"
								 id="tab_content13 " aria-labelledby="tab0013">
								<?php $this->load->view('page/lead/debt_detail_tab0013'); ?>
							</div>
						<?php } ?>

						<?php if (isset($_GET['tab']) && $_GET['tab'] == 14) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 14) ? 'active in' : "" ?>"
								 id="tab_content14 " aria-labelledby="tab0014" >
								<?php $this->load->view('page/lead/debt_detail_tab0014'); ?>
							</div>
						<?php } ?>

						<?php if (isset($_GET['tab']) && $_GET['tab'] == 15) { ?>
							<div role="tabpanel"
								 class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 15) ? 'active in' : "" ?>"
								 id="tab_content15 " aria-labelledby="tab0015">
								<?php $this->load->view('page/lead/debt_detail_tab0015'); ?>
							</div>
						<?php } ?>
					</div>
				</div>
				<div>
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

		</div>
	</div>


</div>
<!-- /page content -->

<div class="modal fade" id="tab001_lead_log" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<?php $this->load->view('page/lead/modal_lead_log'); ?>
</div>
<div class="modal fade" id="tab001_noteModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<?php $this->load->view('page/lead/modal_call'); ?>
</div>

<div class="modal fade" id="tab0014_noteModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<?php $this->load->view('page/lead/modal_note'); ?>
</div>

<div class="modal fade" id="tab006_recording" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<?php $this->load->view('page/lead/modal_recording'); ?>
</div>

<div class="modal fade" id="addNewKHModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm mới khách hàng</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="_id"/>
						<div class="form-group">
							<label class="control-label col-md-3">Họ và Tên :</label>
							<div class="col-md-9">
								<input name="customer_fullname" placeholder="Họ và tên khách hàng" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Số điện thoại :</label>
							<div class="col-md-9">
								<input name="customer_phone" placeholder="Số điện thoại" class="form-control"
									   type="number">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Giới tính :</label>

							<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
								<label><input name='customer_gender' value="1" type="radio"
											  checked>&nbsp;<?= $this->lang->line('male') ?></label>
								<label><input name='customer_gender' value="2"
											  type="radio">&nbsp;<?= $this->lang->line('Female') ?></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Nguồn</label>
							<div class="col-md-9">
								<select name="customer_source" class="form-control" id="source">
									<?php
									foreach (lead_nguon() as $key => $obj) { ?>
										<option class="form-control"
												value="<?= $key ?>"><?= $obj ?></option>
									<?php } ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group" id="show_hide_customer_phone_introduce" style="display: none">
							<label class="control-label col-md-3">SĐT người giới thiệu</label>
							<div class="col-md-9">
								<input id="customer_phone_introduce" name="customer_phone_introduce" maxlength="10" placeholder="SĐT người giới thiệu" class="form-control"
									   type="number">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">CSKH</label>
							<div class="col-md-9">
								<select name="cskh_add" class="form-control" id="cskh">
									<?php
									if (!empty($cskhData)) {
										foreach ($cskhData as $key => $cskh) {
											foreach ($cskh as $key => $val) {
												?>
												<option value="<?= !empty($val->email) ? $val->email : ""; ?>"><?= !empty($val) ? $val->email : ""; ?></option>
											<?php }
										}
									} ?>
								</select>
								<span class="help-block"></span>
							</div>
						</div>


						<div style="text-align: center" id="group-button">
							<button type="button" id="customer_btnSave" class="btn btn-info">Lưu</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="addCSKHModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Chọn CSKH</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="_id"/>

						<div class="form-group">
							<label class="control-label col-md-3">CSKH đi làm: </label>
							<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">

										<textarea disabled type="text"
												  class="form-control"><?= !empty($list_view_cskh) ? implode(", ", $list_view_cskh) : ""; ?></textarea>
							</div>
						</div>

						<?php
						$cskh = [];
						if (!empty($cskhData)) {
							foreach ($cskhData as $key => $item) {
								foreach ($item as $key => $val) {
									array_push($cskh, $val->email);
								}
							}
						}

						if (!empty($cskh) && !empty($list_view_cskh)) {
							for ($i = count($cskh); $i >= 0; $i--) {
								for ($j = 0; $j < count($list_view_cskh); $j++) {
									if ($cskh[$i] == $list_view_cskh[$j]) {
										array_splice($cskh, $i, 1);
									}
								}
							}
						}

						?>
						<div class="form-group">
							<br><br>
							<label class="control-label col-md-3">Chọn chăm sóc khách hàng</label>
							<div class="col-md-9">
								<select id="selectize_cskh" class="form-control" name="selectize_cskh[]"
										multiple="multiple" data-placeholder="Chọn chăm sóc khách hàng">
									<?php
									if (!empty($cskh)) {
										foreach ($cskh as $key => $val) {
												?>
												<option value="<?= !empty($val) ? $val : ""; ?>"><?= !empty($val) ? $val : ""; ?></option>
										<?php }
									} ?>
								</select>

							</div>
							<input id="selectize_cskh_value" style="display: none">
						</div>

						<div style="text-align: center" id="group-button">
							<button type="button" id="cskh_btnSave" class="btn btn-info">Lưu</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="delCSKHModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Chọn CSKH nghỉ</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="_id"/>

						<div class="form-group">

							<label class="control-label col-md-3">Chọn chăm sóc khách hàng</label>
							<div class="col-md-9">

								<select id="selectize_cskh_del" class="form-control" name="selectize_cskh_del[]"
										multiple="multiple" data-placeholder="Chọn chăm sóc khách hàng">
									<?php
									if (!empty($list_view_cskh)) {
										foreach ($list_view_cskh as $key => $cskh) {

											?>
											<option value="<?= $cskh; ?>"><?= $cskh; ?></option>
										<?php }
									} ?>

								</select>
							</div>
							<input id="selectize_cskh_value_del" style="display: none">
						</div>

						<div style="text-align: center" id="group-button">
							<button type="button" id="cskh_btnSave_del" class="btn btn-info">Lưu</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="chuyen_pgd" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve">Xác nhận chuyển</h5>
				<hr>
				<div class="form-group">
					<p>Bạn có chắc chắn muốn chuyển đến phòng giao dịch lead này ?</p>
					<input name="id_clead" type="hidden" value=""/>
					<input name="id_PDG_clead" type="hidden" value=""/>
				</div>
				</table>
				<p class="text-right">
					<button class="btn btn-danger change_pgd_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>
<div id="listentoRecord" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Nghe ghi âm</h4>
			</div>
			<div class="modal-body">
				<audio controls class="w-100" id="player">
					<source src="" type="audio/mp3" id="audio">
				</audio>
			</div>
			<div class="modal-footer">
				<!--     <button type="button" class="btn btn-default" >
					  <i class="fa fa-download"></i> Download
					</button> -->
				<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="backDelete" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Trả về trạng thái nhân viên đã xóa trước đó</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="_id"/>

						<div style="text-align: center" id="group-button">
							<button type="button" id="back_delete" class="btn btn-info">Đồng ý</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>



<script>

</script>
<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>
<style type="text/css">
	.pagination-sm > a {
		padding: 5px 10px;
		font-size: 12px;
		line-height: 1.5;
	}
	.input-group
	{
		display: block;
	}
	.input-group .input-group-addon
	{
		position: absolute;
		width: 54px;
		height: 34px;
		line-height: 18px;
		z-index: 9;
	}
	.input-group .form-control
	{
		padding-left: 60px;
	}
</style>
<script>
	$(document).ready(function (){
		$('.callmodal').click(function (){
			$('.tool_property').hide()
		})
		var start = $('input[name=fdate]').val();
		var end = $('input[name=tdate]').val();
		if (start > end && end != "") {
			alert("Ngày bắt đầu không được lớn hơn ngày kết thúc");
		}
	})
</script>
