
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
                <h3><?php echo $this->lang->line('create_email_template')?>
                  <br/><br/>
                  <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('email_template/listEmail_template')?>"><?php echo $this->lang->line('email_template_list')?></a> / <a href="#"><?php echo $this->lang->line('create_email_template')?></a></small>
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
            		<form class="form-horizontal form-label-left" id="form_email_template" enctype="multipart/form-data" action="<?php echo base_url("email_template/doAddEmail_template")?>" method="post">
				
						<div class="form-group row">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										Code *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="code" class="form-control " placeholder="" select>
									</div>
						</div>
					
								<div class="form-group row">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										Message <span class="text-danger">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea rows="20" cols="100" class="form-control" style="white-space: initial;" id="message"  name="message" placeholder="message"></textarea>
									</div>
								</div>
                          	<div class="form-group row">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										Code name *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="code_name" class="form-control " placeholder="" select>
									</div>
						</div>
							<div class="form-group row">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										From *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="from" class="form-control " placeholder="" select>
									</div>
						</div>
							<div class="form-group row">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										From_name *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="from_name" class="form-control " placeholder="" select>
									</div>
						</div>
							<div class="form-group row">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										Subject *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="subject" class="form-control " placeholder="" select>
									</div>
						</div>
							
					
			
								<div class="form-group row">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										<?php echo $this->lang->line('status')?>
									</label>
									<div class="col-lg-6 col-sm-12 col-xs-12 ">
										<div class="radio-inline text-primary">
											<label>
												<input type="radio" name="status" value="active" checked="checked"> <?php echo $this->lang->line('active')?>
											</label>
										</div>
										<div class="radio-inline text-danger">
											<label>
												<input type="radio"   name="status" value="deactive"> <?php echo $this->lang->line('deactive')?>
											</label>
										</div>
									</div>
								</div>
					<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button class="btn btn-success  create_email_template">
											<i class="fa fa-save"></i>
											<?php echo $this->lang->line('save')?>
										</button>
										<a href="#" class="btn btn-info ">
											<i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>

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
    <script src="<?php echo base_url();?>assets/js/email_template/index.js"></script>
 
    <style type="text/css">
    	textarea {

  white-space: pre;

  overflow-wrap: normal;

  overflow-x: scroll;

}
    </style>
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