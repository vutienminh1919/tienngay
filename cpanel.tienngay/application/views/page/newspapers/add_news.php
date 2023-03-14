
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
                <h3><?php echo $this->lang->line('create_news_papers')?>
                  <br/><br/>
                  <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('newspapers/listNews')?>"><?php echo $this->lang->line('news_list_papers')?></a> / <a href="#"><?php echo $this->lang->line('create_news_papers')?></a></small>
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
            		<form class="form-horizontal form-label-left" id="form_news" enctype="multipart/form-data" action="<?php echo base_url("newspapers/doAddNews")?>" method="post">

					<div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">

                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   
                  <label>
                  <?php echo $this->lang->line('size_image')?> <span class="text-danger" id="size_image">
                  	350 × 150 pixel 
                  </span>
                  </label>
                  </div>
                </div>			
                  <div class="form-group row">
                  	<label class="control-label col-md-3 col-sm-3 col-xs-12">
                      </label>
                  	<div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('image_news')?>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
                        <img class="img-responsive img-border blah"  src="<?php echo base_url(); ?>assets/imgs/default_image.png"  >
                          </div>
              
                      <div class="col-md-8 col-sm-6 col-xs-12">
                           <input class="form-control imgInp" type="file" name="image"/>
                           
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
										<?php echo $this->lang->line('title')?> <span class="text-danger">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="title_vi" class="form-control " placeholder="<?php echo $this->lang->line('title_pla')?>" select>
									</div>
						</div>
							
  					</div>
						<div role="tabpanel" class="tab-pane" id="en">
							<br/>
                         <div class="form-group row">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										<?php echo $this->lang->line('title')?>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="title_en" class="form-control " placeholder="<?php echo $this->lang->line('title_pla')?>" select>
									</div>
						</div>
					
								

						</div>

					</div>
				
				</div>
				<br/>
					
                 	<div class="form-group row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							<?php echo $this->lang->line('link')?> <span class="text-danger">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="link" class="form-control " placeholder="<?php echo $this->lang->line('link_pla')?>" select>
						</div>
						</div>
						<div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									<?php echo $this->lang->line('source')?> <span class="text-danger">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="source" class="form-control " placeholder="<?php echo $this->lang->line('source_pla')?>" select>
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
										<button class="btn btn-success  create_news">
											<i class="fa fa-save"></i>
											<?php echo $this->lang->line('save')?>
										</button>
										<a href="<?php echo base_url('newspapers/listNews')?>" class="btn btn-info ">
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
    <script src="<?php echo base_url();?>assets/js/newspapers/index.js"></script>
   
    <style type="text/css">
    	textarea {

  white-space: pre;

  overflow-wrap: normal;

  overflow-x: scroll;

}
    </style>
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