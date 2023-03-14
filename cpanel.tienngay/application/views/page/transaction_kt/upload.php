<!-- page content -->

<?php 
    $transaction_id = !empty($_GET['id']) ? $_GET['id'] : "" ;
?>
<div class="right_col" role="main">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3><?= $this->lang->line('update_img_authentication')?>
                <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('transaction')?>">Danh sách phiếu thu</a> / <a href="#"><?php echo $this->lang->line('update_img_authentication')?></a>
                    </small>
                </h3>
            </div>
            <div class="title_right text-right">
                <?php if(isset($_GET['view'])){ ?>
                <a href="<?php echo base_url('accountant')?>" class="btn btn-info ">
                    <?php } ?>
                     <?php if(!isset($_GET['view'])) {?>
                <a href="<?php echo base_url('transaction')?>" class="btn btn-info ">
                     <?php } ?>

                    <i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back')?>
                </a>
				<button style="float: right;" type="button" class="btn btn-info submit_transaction_img">Save</button>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <input type="hidden" id="transaction_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>">
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
                                                   
                                                        <img name="img_transaction"  class="w-100" src="<?= $value->path?>" alt="" data-type="expertise" data-key='<?= $key?>' data-filetype="<?= $value->file_type?>" data-filename="<?= $value->file_name?>">
                                                   
                                                <?php }?>
                                                <!--Audio-->
                                                <?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
                                                    <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
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
                                                    </a>
    <!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
                                                <?php }?>
                                                <button type="button" onclick="deleteImage(this)" data-id="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>" data-type="expertise" data-key='<?= $key?>' class="cancelButton "><i class="fa fa-times-circle"></i></button>
                                                <div class="description"><textarea rows="6" data-key="<?= $key?>" name="description_img" ><?= $value->description?></textarea></div>
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
            <!--End-->
			<button style="float: right;" type="button" class="btn btn-info submit_transaction_img">Save</button>
        </div>
    </div>
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/transaction/upload.js"></script>
<script src="<?php echo base_url();?>assets/js/simpleUpload.js"></script>

