<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử lý...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3><?php print $this->lang->line('update_news') ?>
						<br/><br/>
						<small><a href="<?php print base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php print base_url('news/listNews') ?>"><?php print $this->lang->line('news_list') ?></a>
							/ <a href="#"><?php print $this->lang->line('update_news') ?></a></small>
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
						  action="<?php print base_url("news/doUpdateNews") ?>" method="post">

						<input type="hidden" name="id_news" class="form-control "
							   value="<?= !empty($news->_id->{'$oid'}) ? $news->_id->{'$oid'} : "" ?>">
						<br/>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php print $this->lang->line('level') ?>
								<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control district_shop"
										placeholder="<?php print $this->lang->line('level_pla') ?>" name="level"
										id="level" required>
									<option <?php ($news->level == "1") ? print "selected" : print "" ?> value="1">Level
										1
									</option>
									<option <?php ($news->level == "2") ? print "selected" : print "" ?> value="2">Level
										2
									</option>
									<option <?php ($news->level == "3") ? print "selected" : print "" ?> value="3">Level
										3
									</option>
									<option <?php ($news->level == "4") ? print "selected" : print "" ?> value="4">Level
										4
									</option>
								</select>
								<br/>
								<label>
									<?php echo $this->lang->line('size_image') ?> <span class="text-danger"
																						id="size_image"></span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									<?php print $this->lang->line('image_news') ?>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<img class="img-responsive img-border blah"
										 src="<?php !empty($news->image) ? print $news->image : print base_url() . "assets/imgs/default_image.png"; ?>">
								</div>

								<div class="col-md-8 col-sm-6 col-xs-12">
									<input class="form-control imgInp" type="file"
										   value="<?php !empty($news->image) ? print $news->image : print "" ?>"
										   name="image"/>
								</div>
							</div>
						</div>
						<div class="group-tabs">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#vi" aria-controls="home" role="tab"
																		  data-toggle="tab">Vietnamese</a></li>
								<li role="presentation"><a href="#en" aria-controls="profile" role="tab"
														   data-toggle="tab">English</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="vi">
									<br/>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('title') ?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="title_vi" class="form-control "
												   value="<?php !empty($news->title_vi) ? print $news->title_vi : print "" ?>"
												   placeholder="<?php print $this->lang->line('title_pla') ?>" select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('summary') ?> <span
													class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea cols="100" rows="3" wrap="soft" class="form-control"
													  id="summary_vi" name="summary_vi"
													  placeholder="<?php print $this->lang->line('summary_pla') ?>"><?php !empty($news->summary_vi) ? print $news->summary_vi : print  "" ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('content') ?> <span
													class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea rows="5" cols="100" class="form-control" id="content_vi"
													  name="content_vi"
													  placeholder="<?php print $this->lang->line('content_pla') ?>"><?php !empty($news->content_vi) ? print $news->content_vi : print  "" ?></textarea>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="en">
									<br/>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('title') ?>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="title_en" class="form-control "
												   placeholder="<?php print $this->lang->line('title_pla') ?>"
												   value="<?php !empty($news->title_en) ? print $news->title_en : print  "" ?>"
												   select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('summary') ?>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea rows="3" cols="100" class="form-control" id="summary_en"
													  name="summary_en"
													  placeholder="<?php print $this->lang->line('summary_pla') ?>"><?php !empty($news->summary_en) ? print $news->summary_en : print "" ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('content') ?>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea rows="5" cols="100" class="form-control" id="content_en"
													  name="content_en"
													  placeholder="<?php print $this->lang->line('content_pla') ?>"><?php !empty($news->content_en) ? print $news->content_en : print "" ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--						START SEO-->
						<br/>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('title_page_seo') ?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="page_title_seo" class="form-control"
									   placeholder="Nhập tiêu đề SEO"
									   value="<?= !empty($news->page_title_seo) ? $news->page_title_seo : ""; ?>"
									   select>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('description_tag_seo') ?> <span
										class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea cols="100" rows="3" wrap="soft" class="form-control" id="description_tag_seo"
										  name="description_tag_seo"
										  placeholder="Nhập nội dung mô tả SEO"><?= !empty($news->description_tag_seo) ? $news->description_tag_seo : ""; ?></textarea>

							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('keyword_tag_seo') ?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="keyword_tag_seo" class="form-control "
									   placeholder="Nhập từ khóa SEO"
									   value="<?= !empty($news->keyword_tag_seo) ? $news->keyword_tag_seo : ""; ?>"
									   select>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('url_seo') ?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="url_seo" class="form-control " placeholder="Nhập url SEO"
									   value="<?= !empty($news->url_seo) ? $news->url_seo : ""; ?>" select>
							</div>
						</div>
						<!--						END SEO-->
						<br/>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Thời hạn
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="date" name="period" class="form-control" placeholder=""
									   value="<?= !empty($news->period) ? date('Y-m-d', $news->period) : "" ?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Số lượng
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="number" value="<?= !empty($news->limit) ? (int)$news->limit : "" ?>"
									   name="limit" class="form-control" placeholder="">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('province') ?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control" name="province" id="selectize_province">
									<option value="">Chọn tỉnh / thành phố</option>
									<?php
									if (!empty($provinceData)) {
										foreach ($provinceData as $key => $province) {
											?>
											<option value="<?= !empty($province->code) ? $province->code : ""; ?>" <?php if ($province->code == $news->province) echo "selected" ?>><?= !empty($province->name) ? $province->name : ""; ?></option>
										<?php }
									} ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Thể loại
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<input type="hidden" name="category_name_post" class="form-control"
									   value="">
								<select class="form-control" name="type_new" required>
									<option value="" selected>-- Chọn thể loại bài viết --</option>
									<option <?php ($news->type_new == "1") ? print "selected" : print "" ?> value="1">Tin tức</option>
									<option <?php ($news->type_new == "2") ? print "selected" : print "" ?> value="2">Tuyển dụng</option>
									<?php
									if (!empty($categories)) {
										foreach ($categories as $category) { ?>
											<option <?php ($news->type_new == $category->type_new) ? print "selected" : print "" ?> value="<?= ($category->type_new) ? $category->type_new : ''; ?>"><?= ($category->category_name_post) ? $category->category_name_post : ''; ?></option>
										<?php }
									} ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php print $this->lang->line('status') ?>
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<div class="radio-inline text-primary">
									<label>
										<input type="radio" name="status"
											   value="active" <?php ($news->status == "active") ? print "checked" : print "" ?>> <?php print $this->lang->line('active') ?>
									</label>
								</div>
								<div class="radio-inline text-danger">
									<label>
										<input type="radio" name="status"
											   value="deactive" <?php ($news->status == "deactive") ? print "checked" : print "" ?> > <?php print $this->lang->line('deactive') ?>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button class="btn btn-success  update_news">
									<i class="fa fa-save"></i>
									<?php print $this->lang->line('save') ?>
								</button>
								<a href="<?php print base_url('news/listNews') ?>" class="btn btn-info ">
									<i class="fa fa-arrow-left"
									   aria-hidden="true"></i> <?php print $this->lang->line('back') ?>
								</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.imgInp').bind('change', function () {
		if (this.files[0].size > 1000000) {
			alert("Ảnh phải up dưới 1Mb để tránh ảnh hưởng đến SEO");
			$('.imgInp').val("");
			$('.blah').attr("src", "<?php echo base_url(); ?>assets/imgs/default_image.png");
		}
	});
</script>
<!-- /page content -->
<script src="<?php print base_url(); ?>assets/js/news/index.js"></script>
<script>
	CKEDITOR.replace('content_vi', {height: ['200px']});
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('body', {height: 200});
</script>
<script>
	CKEDITOR.replace('content_en', {height: ['200px']});
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('body', {height: 200});
</script>
<style type="text/css">
	textarea {
		white-space: pre;
		overflow-wrap: normal;
		overflow-x: scroll;
	}
</style>
<script>
	$(document).ready(function () {
		$("select#level").change(function () {
			var level = $(this).children("option:selected").val();
			console.log(level);
			var size = "Chưa gắn vị trí";
			if (level != '0') {
				switch (level) {
					case '1':
						size = "370 × 203 pixel ";
						break;
					case '2':
						size = "370 × 203 pixel ";
						break;
					case '3':
						size = "370 × 203 pixels";
						break;
					case '4':
						size = "370 × 203 pixel ";
						break;
				}
			}
			document.getElementById("size_image").innerHTML = size;
		});
	});
</script>
<script>
	function readURL_all(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			var parent = $(input).closest('.form-group');
			//console.log(parent);
			reader.onload = function (e) {
				parent.find('.wrap').hide('fast');
				parent.find('.blah').attr('src', e.target.result);
				parent.find('.wrap').show('fast');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$(".x_content").on('change', '.imgInp', function () {
		readURL_all(this);
	});
</script>
