
<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span >Đang Xử Lý...</span>
	</div>
	<div class="row">


		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3><?php echo $this->lang->line('create_reason')?>
						<br/><br/>
						<small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('seo/seo_list')?>">Danh sách pages SEO</a> / <a href="#"><?php echo $this->lang->line('create_reason')?></a></small>
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
					<form class="form-horizontal form-label-left" id="form_faq" enctype="multipart/form-data" action="<?php echo base_url("reason/do_add_reason")?>" method="post">
						<div class="group-tabs">
							<!-- Nav tabs -->

							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="vi">
									<br/>
<!--									Start SEO-->
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Tên pages SEO <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="page_name_seo" class="form-control" placeholder="Example: Giới thiệu or gioi-thieu" select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('title_page_seo')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="page_title_seo" class="form-control" placeholder="Nhập tiêu đề SEO" select>
										</div>
									</div>

									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('description_tag_seo')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea cols="100" rows="3" wrap="soft" class="form-control" id="description_seo"  name="description_tag_seo" placeholder="Nhập nội dung mô tả SEO"></textarea>

										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('keyword_tag_seo')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="keyword_tag_seo" class="form-control " placeholder="Nhập từ khóa SEO" select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('url_seo')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="url_seo" class="form-control " placeholder="Example: http://tienngay.vn/gioi-thieu" select>
										</div>
									</div>
									<!--						END SEO-->

									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('status')?>
										</label>
										<div class="col-lg-6 col-sm-12 col-xs-12 ">
											<div class="radio-inline text-primary">
												<label>
													<input type="radio"
														   name="status" value="active" checked="checked"> <?php echo $this->lang->line('active')?>
												</label>
											</div>
											<div class="radio-inline text-danger">
												<label>
													<input type="radio"
														   name="status" value="deactive"> <?php echo $this->lang->line('deactive')?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<button class="btn btn-success  create_seo">
												<i class="fa fa-save"></i>
												<?php echo $this->lang->line('save')?>
											</button>
											<a href="<?php echo base_url("seo/seo_list") ?>" class="btn btn-info ">
												<i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/seo/index.js"></script>

