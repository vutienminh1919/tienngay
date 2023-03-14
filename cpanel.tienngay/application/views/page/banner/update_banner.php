
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
                <h3><?php print $this->lang->line('update_banner')?>
                  <br/><br/>
                  <small><a href="<?php print base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php print base_url('banner/listBanner')?>"><?php print $this->lang->line('banner_list')?></a> / <a href="#"><?php print $this->lang->line('update_banner')?></a></small>
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
                <form class="form-horizontal form-label-left" id="form_banner" enctype="multipart/form-data" action="<?php print base_url("banner/doUpdateBanner")?>" method="post">

                 <input type="hidden" name="id_banner" class="form-control " value="<?= !empty($banner->_id->{'$oid'}) ? $banner->_id->{'$oid'} : ""?>">
                  <div class="form-group row">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            <?php echo $this->lang->line('page')?>
          
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="hidden" name="category_name_banner" class="form-control"
					 value="">
            <select class="form-control district_shop"  placeholder="<?php echo $this->lang->line('page_pla')?>" name="page" id="page" required>
              <option <?php ($banner->page=="7") ? print "selected" : print "" ?> value="7">Trang chủ</option>
           <!--    <option <?php ($banner->page=="1") ? print "selected" : print "" ?> value="1">Giới thiệu</option>
              <option <?php ($banner->page=="2") ? print "selected" : print "" ?> value="2">Hướng dẫn</option>
              <option <?php ($banner->page=="3") ? print "selected" : print "" ?> value="3">Thanh toán</option>
              <option <?php ($banner->page=="4") ? print "selected" : print "" ?> value="4">Phòng giao dịch</option> 
              <option <?php ($banner->page=="5") ? print "selected" : print "" ?> value="5">Tin tức</option>
              <option <?php ($banner->page=="6") ? print "selected" : print "" ?> value="6">Hỏi đáp</option>

              -->
              <option <?php ($banner->page=="8") ? print "selected" : print "" ?> value="8">Đăng ký vay</option>
              <option <?php ($banner->page=="9") ? print "selected" : print "" ?> value="9">Popup</option>
				<?php
				if (!empty($categories)) {
					foreach ($categories as $category) { ?>
						<option <?php ($banner->page == $category->page) ? print "selected" : print "" ?> value="<?= ($category->page) ? $category->page : '';?>"><?= ($category->category_name_banner) ? $category->category_name_banner : '';?></option>
					<?php } } ?>
            </select>
          </div>
        </div>  
              <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('level')?>
              
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control district_shop"  placeholder="<?php print $this->lang->line('level_pla')?>" name="level" id="level" required>
                      <option <?php ($banner->level=="1") ? print "selected" : print "" ?> value="1">Level 1</option>
                      <option <?php ($banner->level=="2") ? print "selected" : print "" ?> value="2">Level 2</option>
                      <option <?php ($banner->level=="3") ? print "selected" : print "" ?> value="3">Level 3</option>
                      <option <?php ($banner->level=="4") ? print "selected" : print "" ?> value="4">Level 4</option>
                    </select>
                      <br/>
                  <label>
                  <?php echo $this->lang->line('size_image')?> <span class="text-danger" id="size_image"></span>
                  </label>
                  </div>
                </div>
                 <h3>PC</h3>
                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
            
                     </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('image_banner')?>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                        <img class="img-responsive img-border blah" id="banner_pc" src="<?php !empty($banner->image) ? print $banner->image :  print base_url()."assets/imgs/default_image.png"; ?>" >
                             </div>
              
                      <div class="col-md-8 col-sm-6 col-xs-12">
                           <input class="form-control imgInp" type="file" value="<?php !empty($banner->image) ? print $banner->image : print "" ?>" name="image"/>
                           
                           </div>
                       </div>
                   </div>
                   <hr/>
                   <h3>MOBILE</h3>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
            
                     </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('image_banner')?>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                        <img class="img-responsive img-border blah" id="banner_mb" src="<?php !empty($banner->image_mb) ? print $banner->image_mb :  print base_url()."assets/imgs/default_image.png"; ?>" >
                             </div>
              
                      <div class="col-md-8 col-sm-6 col-xs-12">
                           <input class="form-control imgInp1" type="file" value="<?php !empty($banner->image_mb) ? print $banner->image_mb : print "" ?>" name="image_mb"/>
                           
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
                    <?php print $this->lang->line('title')?> <span class="text-danger">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="title_vi" class="form-control " value="<?php !empty($banner->title_vi) ? print $banner->title_vi : print "" ?>" placeholder="<?php print $this->lang->line('title_pla')?>" select>
                  </div>
            </div>
          
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('summary')?> 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea cols="100" rows="3" wrap="soft" class="form-control" id="summary_vi"  name="summary_vi" placeholder="<?php print $this->lang->line('summary_pla')?>"><?php !empty($banner->summary_vi) ? print $banner->summary_vi : print  "" ?></textarea>
            
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
                    <input type="text" name="title_en" class="form-control " placeholder="<?php print $this->lang->line('title_pla')?>"  value="<?php !empty($banner->title_en) ? print $banner->title_en : print  "" ?>" select>
                  </div>
            </div>
          
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('summary')?> 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea rows="3" cols="100" class="form-control" id="summary_en"  name="summary_en" placeholder="<?php print $this->lang->line('summary_pla')?>" ><?php !empty($banner->summary_en) ? print $banner->summary_en : print "" ?></textarea>
            
                  </div>
                </div>   

            </div>

          </div>
        
        </div>
        <br/>
        <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?php echo $this->lang->line('link')?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="link" class="form-control " value="<?php !empty($banner->link) ? print $banner->link : print "" ?>" placeholder="<?php echo $this->lang->line('link_pla')?>" select>
            </div>
            </div>
       
                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('status')?>
                  </label>
                  <div class="col-lg-6 col-sm-12 col-xs-12 ">
                    <div class="radio-inline text-primary">
                      <label>
                        <input type="radio" name="status" value="active" <?php ($banner->status=="active") ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio"   name="status" value="deactive" <?php ($banner->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
                      </label>
                    </div>
                  </div>
                </div>
          <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success  update_banner">
                      <i class="fa fa-save"></i>
                      <?php print $this->lang->line('save')?>
                    </button>
                    <a href="<?php print base_url('banner/listBanner')?>" class="btn btn-info ">
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
    <script src="<?php echo base_url();?>assets/js/banner/index.js"></script>
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
      $('#form_banner #banner_pc').attr("src","<?php echo base_url(); ?>assets/imgs/default_image.png");
    }
  });
  $('.imgInp1').bind('change', function() {
    if(this.files[0].size > 1000000)
    {
      alert("Ảnh phải up dưới 1Mb để tránh ảnh hưởng đến SEO");
      $('.imgInp1').val("");
      $('#form_banner #banner_mb').attr("src","<?php echo base_url(); ?>assets/imgs/default_image.png");
    }
  });
</script>
<script>

$(document).ready(function(){
$("select#page").change(function(){
 document.getElementById("size_image").innerHTML="Chọn vị trí để hiển thị kích cỡ";
  });
    $("select#level").change(function(){

        var level = $(this).children("option:selected").val();
        var page = $("select#page option").filter(":selected").val();
        console.log(page+level);
        var size="Chưa gắn vị trí";
        if(level != '0' && page !='0' )
        {
           switch (page+level) {
         case '71':
            size = "1920x600 PC - 414x300 MOBILE - Vị trí: banner top";
            break;
          case '81':
             size = " 585 × 662 pixel - Vị trí: form đăng ký ";
            break;
		  case '91':
			 size = " 695 × 515 pixel - Vị trí: Popup ";
			 break;
		  case '101':
			 size = "1920x600 PC - 414x300 MOBILE - Vị trí: banner top";
			 break;
          
      }
        }
        document.getElementById("size_image").innerHTML=size;
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

    $(".x_content").on('change', '.imgInp1', function () {

        readURL_all(this);
    });
</script>
