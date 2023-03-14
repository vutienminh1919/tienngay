<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Danh sách cẩm nang
						<br>
						<small>
							<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh sách cẩm nang, bảo hiểm</a>
						</small>
					</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url("FinancialHandbook/createHandbook")?>" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line('create_news')?></a>
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
										<th>#</th>
										<th><?php echo $this->lang->line('image_news')?></th>
										<th><?php echo $this->lang->line('title')?></th>
										<th><?php echo $this->lang->line('level')?></th>
										<th><?php echo $this->lang->line('updated_date')?></th>
										<th><?php echo $this->lang->line('status')?></th>
										<th><?php echo $this->lang->line('type')?></th>
										<th><?php echo $this->lang->line('Function')?></th>
									</tr>
									</thead>

									<tbody>
									<?php
									if(!empty($handbookData)) {
										$stt = 0;
										foreach($handbookData as $key => $handbook){
											if($handbook->status != 'block'){
												$stt++;

												?>
												<tr class='news_<?= !empty($handbook->_id->{'$oid'}) ? $handbook->_id->{'$oid'} : "" ?>'>
													<td><?php echo $stt ?></td>
													<td class="w-25">
														<img src="<?= !empty($handbook->image) ?  $handbook->image :  base_url()."assets/imgs/default_image.png";?>" class="img-fluid img-thumbnail"  alt="NULL">
													</td>

													<td><?= !empty($handbook->title_vi) ?  $handbook->title_vi : ""?></td>
													<td><?= !empty($handbook->level) ?  $handbook->level : ""?></td>
													<td><?= !empty($handbook->updated_at) ?   date('d/m/Y H:i:s',$handbook->updated_at): ""?></td>
													<td>
														<center><input class='aiz_switchery' type="checkbox"
																	   data-set='status'
																	   data-id=<?php echo $handbook->_id->{'$oid'} ?>
																	   <?php    $status =  !empty($handbook->status) ?  $handbook->status : "";
																	   echo ($status=='active') ? 'checked' : '';  ?>
															/></center>
													</td>
													<td>
														<?php
														$type_name = "";
														if ($handbook->type_new == 3) {
															$type_name = "Cẩm nang tài chính";
														} else if ($handbook->type_new == 4) {
															$type_name = "Bảo hiểm";
														} else if ($handbook->type_new == 10) {
															$type_name = "Cẩm nang CTV";
														}

														echo $type_name;
														?>
													</td>
													<td>
														<a class="btn btn-primary"  href="<?php echo base_url("FinancialHandbook/update?id=").$handbook->_id->{'$oid'}?>">
															<i class="fa fa-edit"></i> Sửa
														</a>
													</td>
													<!-- Modal HTML -->
													<div id="detele_<?php echo $handbook->_id->{'$oid'}?>" class="modal fade">
														<div class="modal-dialog modal-confirm">
															<div class="modal-content">
																<div class="modal-header">
																	<div class="icon-box danger">
																		<!-- <i class="fa fa-times"></i> -->
																		<i class="fa fa-exclamation" aria-hidden="true"></i>
																	</div>

																	<h4 class="modal-title"><?php echo $this->lang->line('title_delete')?>?</h4>
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																</div>
																<div class="modal-body">
																	<p><?php echo $this->lang->line('body_modal_delete')?></p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $this->lang->line('cancel')?></button>
																	<!-- <button type="button" class="btn btn-danger">Danger</button> -->
																	<!--     <button type="button" data-id="<?= !empty($handbook->_id->{'$oid'}) ? $handbook->_id->{'$oid'} : ""?>" class="btn btn-success delete_news" data-dismiss="modal"><?php echo $this->lang->line('ok')?></button> -->
																</div>
															</div>
														</div>
													</div>

												</tr>
											<?php } }}?>

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
<script src="<?php echo base_url();?>assets/js/financial_handbook/index.js"></script>
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>

<style type="text/css">
	.w-25 {
		width: 8%!important;
	}
</style>
<script>
	$(document).ready(function () {
		set_switchery();
		function set_switchery() {
			$(".aiz_switchery").each(function () {
				new Switchery($(this).get(0), {
					color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'});
				var changeCheckbox = $(this).get(0);
				var id = $(this).data('id');
				changeCheckbox.onchange = function () {
					$.ajax({
						url: _url.base_url +'FinancialHandbook/doUpdateStatusHandbook?id='+id+'&status='+ changeCheckbox.checked,
						method: "GET",
						dataType: 'json',
						success: function (result) {
							console.log(result);
							if (changeCheckbox.checked == true) {
								$.activeitNoty({
									type: 'success',
									icon: 'fa fa-check',
									message: result.message ,
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
