<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử Lý...</span>
	</div>
	<div class="row">


		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Tạo mới danh mục
						<br/><br/>
						<small><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('PostCategories/listCategory') ?>">Danh sách danh mục</a> / <a href="#">Tạo mới danh mục</a></small>
					</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">

				<div class="x_content">
					<div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<span class='div_error'></span>
					</div>
					<form class="form-horizontal form-label-left" id="form_news" enctype="multipart/form-data"
						  action="<?php echo base_url("PostCategories/doAddCategory") ?>" method="post">



						<div class="group-tabs">
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="vi">
									<br/>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Loại danh mục
										</label>
										<div class="col-lg-6 col-sm-12 col-xs-12 ">
											<div class="radio-inline text-primary">
												<label>
													<input type="radio" name="type_category" value="1" checked="checked">
													Banner
												</label>
											</div>
											<div class="radio-inline text-primary">
												<label>
													<input type="radio" name="type_category" value="2">
													Bài viết
												</label>
											</div>
										</div>
									</div>
									<div class="form-group div_banner row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Tên danh mục Banner <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="category_name_banner" class="form-control "
												   placeholder="Nhập tên danh mục banner" select>
										</div>
									</div>

									<div class="form-group div_post_website row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Tên danh mục Bài viết <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="category_name_post" class="form-control "
												   placeholder="Nhập tên danh mục bài viết" select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br/>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('status') ?>
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<div class="radio-inline text-primary">
									<label>
										<input type="radio" name="status" value="active"
											   checked="checked"> <?php echo $this->lang->line('active') ?>
									</label>
								</div>
								<div class="radio-inline text-danger">
									<label>
										<input type="radio" name="status"
											   value="deactive"> <?php echo $this->lang->line('deactive') ?>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button class="btn btn-success" id="create_category">
									<i class="fa fa-save"></i>
									<?php echo $this->lang->line('save') ?>
								</button>
								<a href="<?php echo base_url('PostCategories/listCategory') ?>"
								   class="btn btn-info ">
									<i class="fa fa-arrow-left"
									   aria-hidden="true"></i> <?php echo $this->lang->line('back') ?>
								</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/post_category/index.js"></script>
<script>
	$(document).ready(function () {

		var type_banner = $("input[name='type_category'][value='1']");
		var type_post = $("input[name='type_category'][value='2']");
		$('.div_post_website').hide();
		type_banner.on('click change', function (e) {
			$('.div_banner').show();
			$('.div_post_website').hide();
		});
		type_post.on('click change', function (e) {
			$('.div_banner').hide();
			$('.div_post_website').show();
		});
	});
</script>
