
<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span >Đang Xử lý...</span>
	</div>
	<div class="row">


		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3><?php print $this->lang->line('update_seo')?>
						<br/><br/>
						<small><a href="<?php print base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php print base_url('seo/seo_list')?>">Danh sách SEO Pages</a> / <a href="#">Cập nhập Seo pages</a></small>
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
					<form class="form-horizontal form-label-left" id="form_faq" enctype="multipart/form-data" action="<?php print base_url("seo/doUpdateseo")?>" method="post">

						<input type="hidden" name="id_seo" class="form-control " value="<?= !empty($seo->_id->{'$oid'}) ? $seo->_id->{'$oid'} : ""?>">
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
											<input type="text" name="page_name_seo" class="form-control" placeholder="Nhập tên trang SEO" value="<?= !empty($seo->page_name_seo) ? $seo->page_name_seo : "";?>" select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('title_page_seo')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="page_title_seo" class="form-control" placeholder="Nhập tiêu đề SEO" value="<?= !empty($seo->page_title_seo) ? $seo->page_title_seo : "";?>" select>
										</div>
									</div>

									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('description_tag_seo')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea cols="100" rows="3" wrap="soft" class="form-control" id="description_seo"  name="description_tag_seo" placeholder="Nhập nội dung mô tả SEO"><?= !empty($seo->description_tag_seo) ? $seo->description_tag_seo : "";?></textarea>

										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('keyword_tag_seo')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="keyword_tag_seo" class="form-control " placeholder="Nhập từ khóa SEO" value="<?= !empty($seo->keyword_tag_seo) ? $seo->keyword_tag_seo : "";?>" select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('url_seo')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="url_seo" class="form-control " placeholder="Nhập url SEO" value="<?= !empty($seo->url_seo) ? $seo->url_seo : "";?>" select>
										</div>
									</div>
									<!--						END SEO-->
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('status')?>
										</label>
										<div class="col-lg-6 col-sm-12 col-xs-12 ">
											<div class="radio-inline text-primary">
												<label>
													<input type="radio" name="status" value="active" <?php ($seo->status=="active") ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
												</label>
											</div>
											<div class="radio-inline text-danger">
												<label>
													<input type="radio" name="status" value="deactive" <?php ($seo->status=="deactive") ? print "checked" : print "" ?> > <?php print $this->lang->line('deactive')?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<button class="btn btn-success  update_seo">
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
<script src="<?php print base_url();?>assets/js/seo/index.js"></script>

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
