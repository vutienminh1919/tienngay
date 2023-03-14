<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3><?php echo $this->lang->line('list_seo') ?>
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="#">Danh sách pages SEO</a>
						</small>
					</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url("seo/create_seo") ?>" class="btn btn-info "><i class="fa fa-plus"
																									  aria-hidden="true"></i> Thêm mới
					</a>
				</div>
			</div>
		</div>
		

		<?php if ($this->session->flashdata('error')) { ?>
			<div class="alert alert-danger alert-result">
				<?= $this->session->flashdata('error') ?>
			</div>
		<?php } ?>
		<?php if ($this->session->flashdata('success')) { ?>
			<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
		<?php } ?>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">

							<div class="table-responsive">
								<table id="datatable-buttons" class="table table-striped">
									<thead>
									<tr>
										<th>STT</th>
										<th>Tên trang SEO</th>
										<th>Tiêu đề SEO</th>
										<th>Ngày sửa</th>
										<th>Bật/Tắt trạng thái</th>
										<th>Chức năng</th>
									</tr>
									</thead>

									<tbody>
									<?php
									if (!empty($seoData)) {
										$stt = 0;
										foreach ($seoData as $key => $seo) {
											if ($seo->status != 'block') {
												$stt++;
												?>
												<tr class='faq_<?= !empty($seo->_id->{'$oid'}) ? $seo->_id->{'$oid'} : "" ?>'>
													<td><?php echo $stt ?></td>
													<td><?= !empty($seo->page_name_seo) ? $seo->page_name_seo : "" ?></td>
													<td><?= !empty($seo->page_title_seo) ? $seo->page_title_seo : "" ?></td>
													<td><?= !empty($seo->updated_at) ? date('d/m/Y H:i:s', $seo->updated_at) : "" ?></td>
													<td>
														<center><input class='aiz_switchery' type="checkbox"
																	   data-set='status'
																	   data-id=<?php echo $seo->_id->{'$oid'} ?>
																	   <?php $status = !empty($seo->status) ? $seo->status : "";
																	   echo ($status == 'active') ? 'checked' : ''; ?>
															/></center>

													</td>
													<td>
														<a class="btn btn-primary"
														   href="<?php echo base_url("seo/update?id=") . $seo->_id->{'$oid'} ?>">
															<i class="fa fa-edit"></i> Sửa
														</a>

													</td>
													<!-- Modal HTML -->
													<div id="detele_<?php echo $seo->_id->{'$oid'} ?>"
														 class="modal fade">
														<div class="modal-dialog modal-confirm">
															<div class="modal-content">
																<div class="modal-header">
																	<div class="icon-box danger">
																		<!-- <i class="fa fa-times"></i> -->
																		<i class="fa fa-exclamation"
																		   aria-hidden="true"></i>
																	</div>

																	<h4 class="modal-title"><?php echo $this->lang->line('title_delete') ?>
																		?</h4>
																	<button type="button" class="close"
																			data-dismiss="modal" aria-hidden="true">
																		&times;
																	</button>
																</div>
																<div class="modal-body">
																	<p><?php echo $this->lang->line('body_modal_delete') ?></p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-info"
																			data-dismiss="modal"><?php echo $this->lang->line('cancel') ?></button>
																	<!-- <button type="button" class="btn btn-danger">Danger</button> -->
																	<!--     <button type="button" data-id="<?= !empty($seo->_id->{'$oid'}) ? $seo->_id->{'$oid'} : "" ?>" class="btn btn-success delete_faq" data-dismiss="modal"><?php echo $this->lang->line('ok') ?></button> -->
																</div>
															</div>
														</div>
													</div>

												</tr>
											<?php }
										}
									} ?>
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
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/seo/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/activeit.min.js"></script>

<style type="text/css">
	.w-25 {
		width: 8% !important;
	}
</style>
<script>
	$(document).ready(function () {
		set_switchery();

		function set_switchery() {
			$(".aiz_switchery").each(function () {
				new Switchery($(this).get(0), {
					color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'
				});
				var changeCheckbox = $(this).get(0);
				var id = $(this).data('id');

				changeCheckbox.onchange = function () {
					$.ajax({
						url: _url.base_url + 'seo/do_update_status_seo?id=' + id + '&status=' + changeCheckbox.checked,
						success: function (result) {
							console.log(result);
							if (changeCheckbox.checked == true) {
								$.activeitNoty({
									type: 'success',
									icon: 'fa fa-check',
									message: result.message,
									container: 'floating',
									timer: 3000
								});

							} else {
								$.activeitNoty({
									type: 'danger',
									icon: 'fa fa-check',
									message: result.message,
									container: 'floating',
									timer: 3000
								});

							}
						}
					});
				};
			});
		}
	});
</script>
