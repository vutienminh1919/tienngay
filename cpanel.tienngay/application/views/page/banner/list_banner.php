<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3><?php echo $this->lang->line('banner_list') ?>
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="#"><?php echo $this->lang->line('banner_list') ?></a>
						</small>
					</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url("banner/createbanner") ?>" class="btn btn-info "><i class="fa fa-plus"
																									 aria-hidden="true"></i> <?php echo $this->lang->line('create_banner') ?>
					</a>
				</div>
			</div>
		</div>

		<?php function get_page($id_page)
		{
			switch ($id_page) {
				case '1':
					return "Giới thiệu";
					break;
				case '2':
					return "Hướng dẫn";
					break;
				case '3':
					return "Thanh toán";
					break;
				case '4':
					return "Phòng giao dịch";
					break;
				case '5':
					return "Tin tức";
					break;
				case '6':
					return "Hỏi đáp";
					break;
				case '7':
					return "Trang chủ";
				case '8':
					return "Trang đăng ký";
					break;
				case '9':
					return "Popup";
					break;
			}
		}

		if ($this->session->flashdata('error')) { ?>
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
										<th>#</th>
										<th><?php echo $this->lang->line('image_banner') ?></th>
										<th><?php echo $this->lang->line('title') ?></th>
										<th><?php echo $this->lang->line('page') ?></th>
										<th><?php echo $this->lang->line('level') ?></th>
										<th><?php echo $this->lang->line('updated_date') ?></th>
										<th><?php echo $this->lang->line('status') ?></th>
										<th><?php echo $this->lang->line('Function') ?></th>
									</tr>
									</thead>
									<tbody>
									<?php
									if (!empty($bannerData)) {
										$stt = 0;
										foreach ($bannerData as $key => $banner) {
											if ($banner->status != 'block') {
												$stt++;

												?>
												<tr class='banner_<?= !empty($banner->_id->{'$oid'}) ? $banner->_id->{'$oid'} : "" ?>'>
													<td><?php echo $stt ?></td>
													<td class="w-25">
														<img src="<?= !empty($banner->image) ? $banner->image : base_url() . "assets/imgs/default_image.png"; ?>"
															 class="img-fluid img-thumbnail" alt="NULL">
													</td>
													<td><?= !empty($banner->title_vi) ? $banner->title_vi : "" ?></td>
													<td>
														<?php
														if ($banner->page == 7) {
															echo "Trang chủ";
														} elseif ($banner->page == 9) {
															echo "Popup";
														} elseif (isset($banner->category_name_banner)) {
															echo $banner->category_name_banner;
														}
														?>
													</td>
													<td><?= !empty($banner->level) ? $banner->level : "" ?></td>
													<td><?= !empty($banner->updated_at) ? date('m/d/Y H:i:s', $banner->updated_at) : "" ?></td>
													<td>
														<center><input class='aiz_switchery' type="checkbox"
																	   data-set='status'
																	   data-id=<?php echo $banner->_id->{'$oid'} ?>
																	   <?php $status = !empty($banner->status) ? $banner->status : "";
																	   echo ($status == 'active') ? 'checked' : ''; ?>
															/></center>


													</td>
													<td>
														<a class="btn btn-primary"
														   href="<?php echo base_url("banner/update?id=") . $banner->_id->{'$oid'} ?>">
															<i class="fa fa-edit"></i> Sửa
														</a>
														<!-- 	  <a class="btn btn-danger mr-0 btn-delete" href="javascript:void(0);"  data-toggle="modal" data-target="#detele_<?php echo $banner->_id->{'$oid'} ?>">
							  <i class="fa fa-close"></i> Xóa
						  </a> -->
													</td>
													<!-- Modal HTML -->
													<div id="detele_<?php echo $banner->_id->{'$oid'} ?>"
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
																	<!--     <button type="button" data-id="<?= !empty($banner->_id->{'$oid'}) ? $banner->_id->{'$oid'} : "" ?>" class="btn btn-success delete_banner" data-dismiss="modal"><?php echo $this->lang->line('ok') ?></button> -->
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
<script src="<?php echo base_url(); ?>assets/js/banner/index.js"></script>
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
						url: _url.base_url + 'banner/doUpdateStatusBanner?id=' + id + '&status=' + changeCheckbox.checked,
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
