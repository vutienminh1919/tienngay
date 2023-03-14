
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
					<h3><?php print $this->lang->line('update_reason')?>
						<br/><br/>
						<small><a href="<?php print base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php print base_url('reason/reason_list')?>"><?php print $this->lang->line('list_reason')?></a> / <a href="#"><?php print $this->lang->line('update_reason')?></a></small>
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
					<form class="form-horizontal form-label-left" id="form_faq" enctype="multipart/form-data" action="<?php print base_url("reason/doUpdateReason")?>" method="post">

						<input type="hidden" name="id_reason" class="form-control " value="<?= !empty($reason->_id->{'$oid'}) ? $reason->_id->{'$oid'} : ""?>">
						<div class="group-tabs">
							<!-- Nav tabs -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="vi">
									<br/>
									
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('reason_name')?> <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="reason_name" class="form-control " placeholder="<?php echo $this->lang->line('reason_name_placeholder')?>" value="<?php !empty($reason->reason_name) ? print $reason->reason_name : print "" ?>" select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('status')?>
										</label>
										<div class="col-lg-6 col-sm-12 col-xs-12 ">
											<div class="radio-inline text-primary">
												<label>
													<input type="radio" name="status" value="active" <?php ($reason->status == "active") ? print "checked" : print "" ?>> <?php echo $this->lang->line('active')?> 
												</label>
											</div>
											<div class="radio-inline text-danger">
												<label>
													<input type="radio"   name="status" value="deactive" <?php ($reason->status == "deactive") ? print "checked" : print "" ?> ><?php echo $this->lang->line('deactive')?> 
												</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<button class="btn btn-success  update_reason">
												<i class="fa fa-save"></i>
												<?php echo $this->lang->line('save')?>
											</button>
											<a href="<?php echo base_url("reason/reason_list") ?>" class="btn btn-info ">
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
<script src="<?php print base_url();?>assets/js/reason/index.js"></script>

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
