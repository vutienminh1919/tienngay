
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
					<h3><?php print $this->lang->line('update_news')?>
						<br/><br/>
						<small><a href="<?php print base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php print base_url('news/listNews')?>"><?php print $this->lang->line('news_list')?></a> / <a href="#"><?php print $this->lang->line('update_news')?></a></small>
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
					<form class="form-horizontal form-label-left" id="form_news" enctype="multipart/form-data" action="<?php print base_url("news/doUpdateNews")?>" method="post">

						<input type="hidden" name="id_news" class="form-control " value="<?= !empty($handbook->_id->{'$oid'}) ? $handbook->_id->{'$oid'} : ""?>">
						<br/>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php print $this->lang->line('level')?>
								<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control district_shop"  placeholder="<?php print $this->lang->line('level_pla')?>" name="level" id="level" required>
									<option <?php ($handbook->level=="1") ? print "selected" : print "" ?> value="1">Level 1</option>
									<option <?php ($handbook->level=="2") ? print "selected" : print "" ?> value="2">Level 2</option>
									<option <?php ($handbook->level=="3") ? print "selected" : print "" ?> value="3">Level 3</option>
									<option <?php ($handbook->level=="4") ? print "selected" : print "" ?> value="4">Level 4</option>
								</select>
								<br/>
								<label>
									<?php echo $this->lang->line('size_image')?> <span class="text-danger" id="size_image"></span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									<?php print $this->lang->line('image_news')?>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<img class="img-responsive img-border blah"  src="<?php !empty($handbook->image) ? print $handbook->image :  print base_url()."assets/imgs/default_image.png"; ?>" >
								</div>

								<div class="col-md-8 col-sm-6 col-xs-12">
									<input class="form-control imgInp" type="file" value="<?php !empty($handbook->image) ? print $handbook->image : print "" ?>" name="image"/>

								</div>

							</div>
						</div>


						<div class="group-tabs">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#vi" aria-controls="home" role="tab" data-toggle="tab">Vietnamese</a></li>
								<li role="presentation"><a href="#en" aria-controls="profile" role="tab" data-toggle="tab">English</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="vi">
									<br/>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Loại
										</label>
										<div class="col-lg-6 col-sm-12 col-xs-12 ">
											<div class="radio-inline text-primary">
												<label>
													<input type="radio" name="type_new" value="3" <?php ($handbook->type_new == "3") ? print "checked" : print "" ?>> Cẩm nang tài chính
												</label>
											</div>
											<div class="radio-inline text-primary">
												<label>
													<input type="radio" name="type_new" value="4" <?php ($handbook->type_new == "4") ? print "checked" : print "" ?>> Bảo hiểm
												</label>
											</div>
											<div class="radio-inline text-primary">
												<label>
													<input type="radio" name="type_new" value="10" <?php ($handbook->type_new == "10") ? print "checked" : print "" ?>> Cẩm nang CTV
												</label>
											</div>

										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('title')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="title_vi" class="form-control " value="<?php !empty($handbook->title_vi) ? print $handbook->title_vi : print "" ?>" placeholder="<?php print $this->lang->line('title_pla')?>" select>
										</div>
									</div>
									<?php if ($handbook->type_new == 4) { ?>
									<div class="form-group row insurance-div">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Quyền lợi bảo hiểm
											<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea cols="100" rows="2" wrap="soft" class="form-control" id="benefit_vi"  name="benefit_vi" placeholder="Nhập nội dung quyền lợi Bảo hiểm"><?php !empty($handbook->benefit_vi) ? print $handbook->benefit_vi : print  "" ?></textarea>
										</div>
									</div>
									<div class="form-group row insurance-div">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Phí bảo hiểm
											<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea cols="100" rows="2" wrap="soft" class="form-control" id="fee_insurance_vi"  name="fee_insurance_vi" placeholder="Nhập nội dung phí bảo hiểm"><?php !empty($handbook->fee_insurance_vi) ? print $handbook->fee_insurance_vi : print  "" ?></textarea>

										</div>
									</div>
									<div class="form-group row insurance-div">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Loại bảo hiểm <span
													class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" id="type_finance_vi" name="type_finance_vi">
												<option value="">-- Chọn sản phẩm bảo hiểm --</option>
												<?php foreach (lead_type_finance() as $key => $type_finance) {
													if (in_array($key, [1,2,3,4,5,6,7,8,9])) continue; ?>
													<option value="<?= $key ?>" <?php if($key == $handbook->type_finance_vi) echo "selected"?>><?php echo $type_finance;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php } ?>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('summary')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea cols="100" rows="3" wrap="soft" class="form-control" id="summary_vi"  name="summary_vi" placeholder="<?php print $this->lang->line('summary_pla')?>"><?php !empty($handbook->summary_vi) ? print $handbook->summary_vi : print  "" ?></textarea>

										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('content')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea rows="5" cols="100" class="form-control" id="content_vi"  name="content_vi" placeholder="<?php print $this->lang->line('content_pla')?>" ><?php !empty($handbook->content_vi) ? print $handbook->content_vi : print  "" ?></textarea>
										</div>
									</div>

								</div>
								<div role="tabpanel" class="tab-pane" id="en">
									<br/>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('title')?>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="title_en" class="form-control " placeholder="<?php print $this->lang->line('title_pla')?>"  value="<?php !empty($handbook->title_en) ? print $handbook->title_en : print  "" ?>" select>
										</div>
									</div>
									<?php if ($handbook->type_new == 4) { ?>
									<div class="form-group row insurance-div">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Quyền lợi bảo hiểm
											<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea cols="100" rows="2" wrap="soft" class="form-control" id="benefit_en"  name="benefit_en" placeholder="Nhập nội dung quyền lợi Bảo hiểm"><?php !empty($handbook->benefit_en) ? print $handbook->benefit_en : print  "" ?></textarea>

										</div>
									</div>
									<div class="form-group row insurance-div">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Phí bảo hiểm
											<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea cols="100" rows="2" wrap="soft" class="form-control" id="fee_insurance_en"  name="fee_insurance_en" placeholder="Nhập nội dung phí bảo hiểm"><?php !empty($handbook->fee_insurance_en) ? print $handbook->fee_insurance_en : print  "" ?></textarea>
										</div>
									</div>
									<div class="form-group row insurance-div">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Loại bảo hiểm <span
													class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" id="type_finance_en" name="type_finance_en">
												<option value="">-- Chọn sản phẩm bảo hiểm --</option>
												<?php foreach (lead_type_finance() as $key => $type_finance) {
													if (in_array($key, [1,2,3,4,5,6,7,8,9])) continue; ?>
													<option value="<?= $key ?>" <?php if($key == $handbook->type_finance_en) echo "selected"?>><?php echo $type_finance;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php } ?>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('summary')?>
											<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea rows="3" cols="100" class="form-control" id="summary_en"  name="summary_en" placeholder="<?php print $this->lang->line('summary_pla')?>" ><?php !empty($handbook->summary_en) ? print $handbook->summary_en : print "" ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php print $this->lang->line('content')?>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea rows="5" cols="100" class="form-control" id="content_en"  name="content_en" placeholder="<?php print $this->lang->line('content_pla')?>" ><?php !empty($handbook->content_en) ? print $handbook->content_en : print "" ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--						START SEO-->
						<br/>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('title_page_seo')?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="page_title_seo" class="form-control" placeholder="Nhập tiêu đề SEO" value="<?= !empty($handbook->page_title_seo) ? $handbook->page_title_seo : "";?>" select>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('description_tag_seo')?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea cols="100" rows="3" wrap="soft" class="form-control" id="description_tag_seo"  name="description_tag_seo" placeholder="Nhập nội dung mô tả SEO"><?= !empty($handbook->description_tag_seo) ? $handbook->description_tag_seo : "";?></textarea>

							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('keyword_tag_seo')?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="keyword_tag_seo" class="form-control " placeholder="Nhập từ khóa SEO" value="<?= !empty($handbook->keyword_tag_seo) ? $handbook->keyword_tag_seo : "";?>" select>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('url_seo')?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="url_seo" class="form-control " placeholder="Nhập url SEO" value="<?= !empty($handbook->url_seo) ? $handbook->url_seo : "";?>" select>
							</div>
						</div>
						<!--						END SEO-->
						<br/>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Thời hạn
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input  type="date" name="period" class="form-control" placeholder="" value="<?= !empty($handbook->period) ? date('Y-m-d',$handbook->period) : ""?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Số lượng
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input  type="number" value="<?= !empty($handbook->limit) ? (int)$handbook->limit : ""?>" name="limit" class="form-control" placeholder="" >
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php echo $this->lang->line('province')?> <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control" name="province" id="selectize_province">
									<option value="">Chọn tỉnh / thành phố</option>
									<?php
									if(!empty($provinceData)){
										foreach($provinceData as $key => $province){
											?>
											<option  value="<?= !empty($province->code) ? $province->code : "";?>" <?php if($province->code == $handbook->province) echo "selected"?>><?= !empty($province->name) ? $province->name : "";?></option>
										<?php }}?>
								</select>

							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php print $this->lang->line('status')?>
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<div class="radio-inline text-primary">
									<label>
										<input type="radio" name="status" value="active" <?php ($handbook->status=="active") ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
									</label>
								</div>
								<div class="radio-inline text-danger">
									<label>
										<input type="radio"   name="status" value="deactive" <?php ($handbook->status=="deactive") ? print "checked" : print "" ?> > <?php print $this->lang->line('deactive')?>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button class="btn btn-success  update_handbook">
									<i class="fa fa-save"></i>
									Cập nhật
								</button>
								<a href="<?php print base_url('FinancialHandbook/listHandbook')?>" class="btn btn-info ">
									<i class="fa fa-arrow-left" aria-hidden="true"></i> <?php print $this->lang->line('back')?>

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
<script src="<?php print base_url();?>assets/js/financial_handbook/index.js"></script>
<script>
	CKEDITOR.replace( 'content_vi', {height:['200px'] } );
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('body', {height: 200});
</script>
<script>
	CKEDITOR.replace( 'content_en',  {height:['200px'] } );
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
	$(document).ready(function(){

		$("select#level").change(function(){

			var level = $(this).children("option:selected").val();

			console.log(level);
			var size="Chưa gắn vị trí";
			if(level != '0' )
			{
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
			document.getElementById("size_image").innerHTML=size;
		});

	});
</script>
<script type="text/javascript">
  $('.imgInp').bind('change', function() {
    if(this.files[0].size > 1000000)
    {
      alert("Ảnh phải up dưới 1Mb để tránh ảnh hưởng đến SEO");
      $('.imgInp').val("");
      $('.blah').attr("src","<?php echo base_url(); ?>assets/imgs/default_image.png");
    }
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
