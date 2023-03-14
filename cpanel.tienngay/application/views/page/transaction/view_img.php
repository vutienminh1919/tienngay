<!-- page content -->
<link href="<?php echo base_url();?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<?php 
    $transaction_id = !empty($_GET['id']) ? $_GET['id'] : "" ;
?>
<div class="right_col" role="main">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3><?= $this->lang->line('view_img_authentication')?>
                <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('transaction')?>">Danh sách phiếu thu</a> / <a href="#"><?php echo $this->lang->line('view_img_authentication')?></a>
                    </small>
                </h3>
            </div>
            <div class="title_right text-right">
				<?php 
				if (in_array($result->type,[3,4])) {
				?>
                <a href="<?php echo base_url('transaction')?>" class="btn btn-info ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back')?>
                </a>
				<?php } elseif (in_array($result->type,[7])) {?>
				<a href="<?php echo base_url('heyU?tab=transaction')?>" class="btn btn-info ">
					<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back')?>
				</a>
				<?php } elseif (in_array($result->type,[8])) {?>
					<a href="<?php echo base_url('mic_tnds?tab=transaction')?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back')?>
					</a>
				<?php }?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <!--Start expertise-->
            <div class="x_content">
                <form class="form-horizontal form-label-left" >
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Chứng từ <span class="red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="SomeThing" class="simpleUploader line">
                                <div class="uploads" id="uploads_expertise">
                                    <?php 
                                        if(!empty($result->image_banking->image_expertise)) {
											$key_expertise = 0;
                                            foreach((array)$result->image_banking->image_expertise as $key=>$value) {
												$key_expertise++;
                                                if(empty($value)) continue;
                                            ?>
                                            <div class="block">
                                                <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
													<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
                                                    <a class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" href="<?= $value->path ?>" data-toggle="lightbox"  data-gallery="uploads_expertise" data-max-width="992" data-type="image" data-title="Chứng từ <?php echo $key_expertise ?>">
                                                        <img src="<?= $value->path?>" alt="">
                                                    </a>
                                                <?php }?>
                                                <!--Audio-->
                                                <?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
													<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
                                                    <a class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
                                                    </a>
    <!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
                                                <?php }?>
                                                <!--Video-->
                                                <?php if($value->file_type == 'video/mp4') {?>
													<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
                                                    <a class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
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
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png">
													</a>
												<?php }?>
                                                <div class="description"><textarea rows="6" data-key="<?= $key?>" name="description_img" ><?= $value->description?></textarea></div>
                                            </div>
                                    <?php }}?>
                                </div>
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
            <!--End-->
        </div>
    </div>
</div>
<!-- /page content -->
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
