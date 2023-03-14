<!-- page content -->
<link href="<?php echo base_url();?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<?php 
    $contract_id = !empty($_GET['id']) ? $_GET['id'] : "" ;
?>
<div class="right_col" role="main">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3><?= $this->lang->line('update_img_authentication')?>
                <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('pawn/contract')?>"><?php echo $this->lang->line('Contract_management')?></a> / <a href="#"><?php echo $this->lang->line('update_img_authentication')?></a>
                    </small>
                </h3>
            </div>
            <div class="title_right text-right">
                <a href="<?php echo base_url('pawn/contract')?>" class="btn btn-info ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back')?>
                </a>
                <button style="float: right;" type="button" class="btn btn-info submit_description_img">Save</button>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <input type="hidden" id="contract_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>">
     
          
            <!--Start expertise-->
            <div class="x_content">
                <form class="form-horizontal form-label-left" >
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hồ sơ giải ngân <span class="red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="SomeThing" class="simpleUploader line">
                                <div class="uploads" id="uploads_expertise">
                                    <?php 
                                        if(!empty($result->expertise)) {
                                            foreach((array)$result->expertise as $key=>$value) {
                                                if(empty($value)) continue;
                                            ?>
                                            <div class="block">
                                                <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
                                                    <a href="<?= $value->path ?>"  class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" data-toggle="lightbox"  data-gallery="uploads_expertise" data-max-width="992" data-type="image" >
                                                        <img name="img_file" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='expertise' src="<?= $value->path?>" alt="">
                                                    </a>
                                                <?php }?>
                                                <!--Audio-->
                                                <?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
                                                    <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
                                                        <img style="display:none" name="img_file" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='expertise' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
    <!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
                                                <?php }?>
                                                <!--Video-->
                                                <?php if($value->file_type == 'video/mp4') {?>
                                                    <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
                                                        <img style="display:none" name="img_file" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='expertise' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
    <!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
                                                <?php }?>

												<!--PDF-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'application/pdf')) {?>
													<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img name="img_file" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='expertise' style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">
													</a>
												<?php }?>

                                                <button type="button" onclick="deleteImage(this)" data-id="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>" data-type="expertise" data-key='<?= $key?>' class="cancelButton "><i class="fa fa-times-circle"></i></button>
                                                <div class="description"><textarea rows="6" data-key="<?= $key?>" name="description_img" ><?= !empty($value->description) ? $value->description : "" ?></textarea></div>
                                            </div>
                                    <?php }}?>
                                </div>
                                <label for="upload_expertise">
                                    <div class="block uploader">
                                        <span>+</span>
                                    </div>
                                </label>
                                <input id="upload_expertise" type="file" name="file" data-contain="uploads_expertise" multiple data-type="expertise" class="focus">
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
            <button style="float: right;" type="button" class="btn btn-info submit_description_img">Save</button>
            <!--End-->
        </div>
    </div>
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/pawn/contract.js"></script>
<script src="<?php echo base_url();?>assets/js/simpleUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
<script>
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox({
      alwaysShowClose: true,
    });
});
</script>
<style>

.ekko-lightbox .modal-header  {
  padding-top: 5px;
  padding-bottom: 5px;
}
  .ekko-lightbox .modal-body{
    padding: 5px;
  }
</style>
<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>
