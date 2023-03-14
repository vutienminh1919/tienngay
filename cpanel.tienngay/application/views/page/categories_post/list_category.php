<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Danh sách danh mục
						<br>
						<small>
							<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh sách danh mục</a>
						</small>
					</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url("PostCategories/createCategory")?>" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới danh mục</a>
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
										<th>Tên danh mục</th>
										<th>Thể loại</th>
										<th>Trạng thái</th>
										<th>Ngày tạo</th>
										<th>Người tạo</th>
										<th>Ngày sửa</th>
										<th>Người sửa</th>
										<th>Chức năng</th>
									</tr>
									</thead>

									<tbody>
									<?php
									if(!empty($categoriesData)) {
										$stt = 0;
										foreach($categoriesData as $key => $category){
											if($category->status != 'block'){
												$stt++;
												?>
												<tr class='news_<?= !empty($category->_id->{'$oid'}) ? $category->_id->{'$oid'} : "" ?>'>
													<td><?php echo $stt ?></td>
													<td><?= !empty($category->category_name_banner) ?  $category->category_name_banner : (!empty($category->category_name_post) ?  $category->category_name_post : "")?></td>
													<td>
														<?php
														$type_name = "";
														if ($category->type_category == 1) {
															$type_name = "Danh mục banner";
														} else if ($category->type_category == 2) {
															$type_name = "Danh mục bài viết";
														}
														echo $type_name;
														?>
													</td>
													<td>
														<center><input class='aiz_switchery' type="checkbox"
																	   data-set='status'
																	   data-id=<?php echo $category->_id->{'$oid'} ?>
																	   <?php    $status =  !empty($category->status) ?  $category->status : "";
																	   echo ($status == 'active') ? 'checked' : '';  ?>
															/></center>
													</td>
													<td><?= !empty($category->created_at) ?   date('d/m/Y H:i:s',$category->created_at): ""?></td>
													<td><?= !empty($category->created_by) ?   $category->created_by: ""?></td>
													<td><?= !empty($category->updated_at) ?   date('d/m/Y H:i:s',$category->updated_at): ""?></td>
													<td><?= !empty($category->updated_by) ?   $category->updated_by: ""?></td>
													<td>
														<a class="btn btn-primary"  href="<?php echo base_url("PostCategories/update?id=").$category->_id->{'$oid'}?>">
															<i class="fa fa-edit"></i> Sửa
														</a>
													</td>
													<!-- Modal HTML -->
													<div id="detele_<?php echo $category->_id->{'$oid'}?>" class="modal fade">
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
																	<!--     <button type="button" data-id="<?= !empty($category->_id->{'$oid'}) ? $category->_id->{'$oid'} : ""?>" class="btn btn-success delete_news" data-dismiss="modal"><?php echo $this->lang->line('ok')?></button> -->
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
<script src="<?php echo base_url();?>assets/js/post_category/index.js"></script>
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
						url: _url.base_url +'PostCategories/doUpdateStatusCategory?id='+id+'&status='+ changeCheckbox.checked,
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
