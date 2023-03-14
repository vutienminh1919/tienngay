<!-- page content -->

<?php 
    $contract_id = !empty($_GET['id']) ? $_GET['id'] : "" ;
?>
<link href="<?php echo base_url();?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
 <button style="float: right;" type="button" class="btn btn-info submit_contract_img">Save</button>
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <input type="hidden" id="contract_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>">
            <!--Start identify-->
      
            <div class="x_content">
                <form class="form-horizontal form-label-left">
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Hồ sơ nhân thân <?php //$this->lang->line('cmnd')?><span class="red">*</span></label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <div id="SomeThing" class="simpleUploader">
                                <div class="uploads " id="uploads_identify">
                                    <?php
									$key_identify = 0;
									foreach((array)$result->identify as $key=>$value) {
										$key_identify++;
										if(empty($value)) continue;?>
                                        <div class="block">
                                            <!--//Image-->
                                            <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
												<a href="<?= $value->path ?>" data-magnify="gallery"  data-group="thegallery" class="magnifyitem" data-type="image" data-title="Hồ sơ nhân thân">
                                                    <img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='identify' class="w-100" src="<?= $value->path?>" alt="">
                                                </a>
                                            <?php }?>
                                            <!--Audio-->
                                            <?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
                                                <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                    <img name="img_contract" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
													<img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='identify' class="w-100" src="<?= $value->path?>" alt="">
                                                </a>
<!--                                                <audio controls>
                                                    <source src="<?= $value->path?>" type="audio/mpeg">
                                                    <?= $value->file_name?>
                                                </audio>-->
                                            <?php }?>
                                            <!--Video-->
                                            <?php if($value->file_type == 'video/mp4') {?>
                                                <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                    <img name="img_contract" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
													<img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='identify' class="w-100" src="<?= $value->path?>" alt="">
                                                </a>
<!--                                                <video width="320" height="240" controls>
                                                    <source src="<?= $value->path?>" type="video/mp4">
                                                    <?= $value->file_name?>
                                                </video>-->
                                            <?php }?>
                                          
                                        </div>
                                    <?php }?>
                                </div>
                                <label for="uploadinput">
                                    <div class="block uploader">
                                        <span>+</span>
                                    </div>
                                </label>
                                <input id="uploadinput" type="file" name="file" data-contain="uploads_identify" data-title="Hồ sơ nhân thân" multiple data-type="identify" class="focus">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--End-->
            <!--Start household-->
            <div class="x_content">
                <form class="form-horizontal form-label-left">
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Hồ sơ chứng minh thu nhập<?php //$this->lang->line('household')?> <span class="red">*</span></label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <div id="SomeThing" class="simpleUploader">
                                <div class="uploads" id="uploads_household">
                                    <?php 
                                        if(!empty($result->household)) {
											$key_household = 0;
											foreach((array)$result->household as $key=>$value) {
												$key_household++;
                                                if(empty($value)) continue;
                                            ?>
                                            <div class="block">
                                                <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
                                                    <a href="<?= $value->path ?>" data-magnify="gallery"  data-gallery="uploads_household" class="magnifyitem" data-type="image" data-title="Hồ sơ chứng minh thu nhập">
                                                        <img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='household' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
                                                <?php }?>
                                                <!--Audio-->
                                                <?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
                                                    <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img name="img_contract" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
														<img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='household' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
    <!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
                                                <?php }?>
                                                <!--Video-->
                                                <?php if($value->file_type == 'video/mp4') {?>
                                                    <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img name="img_contract" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
														<img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='household' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
    <!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
                                                <?php }?>
                                               
                                            </div>
                                    <?php }}?>
                                </div>
                                <label for="upload_household">
                                    <div class="block uploader">
                                        <span>+</span>
                                    </div>
                                </label>
                                <input id="upload_household" type="file" name="file" data-contain="uploads_household" data-title="Hồ sơ chứng minh thu nhập" multiple data-type="household" class="focus">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--End-->
            <!--Start driver_license-->
            <div class="x_content">
                <form class="form-horizontal form-label-left">
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Hồ sơ tài sản <?php //$this->lang->line('Driver_license_vehicle_registration')?><span class="red">*</span></label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <div id="SomeThing" class="simpleUploader">
                                <div class="uploads" id="uploads_driver_license">
                                    <?php 
                                        if(!empty($result->driver_license)) {
											$key_driver_license = 0;
											foreach((array)$result->driver_license as $key=>$value) {
												$key_driver_license++;
                                                    if(empty($value)) continue;
                                            ?>
                                            <div class="block">
                                                <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
                                                    <a href="<?= $value->path ?>" data-magnify="gallery"  data-gallery="uploads_driver_license" class="magnifyitem" data-type="image" data-title="Hồ sơ tài sản">
                                                        <img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='driver_license' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
                                                <?php }?>
                                                <!--Audio-->
                                                <?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
                                                    <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
														<img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='driver_license' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
    <!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
                                                <?php }?>
                                                <!--Video-->
                                                <?php if($value->file_type == 'video/mp4') {?>
                                                    <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img name="img_contract" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
														<img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='driver_license' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
    <!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
                                                <?php }?>
                                              
                                            </div>
                                    <?php }}?>
                                </div>
                                <label for="upload_driver_license">
                                    <div class="block uploader">
                                        <span>+</span>
                                    </div>
                                </label>
                                <input id="upload_driver_license" type="file" name="file" data-contain="uploads_driver_license" data-title="Hồ sơ tài sản" multiple data-type="driver_license" class="focus">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--End-->
            <!--Start vehicle-->
            <div class="x_content">
                <form class="form-horizontal form-label-left">
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Hồ sơ thẩm định thực địa<?php //$this->lang->line('Vehicle')?> <span class="red">*</span></label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <div id="SomeThing" class="simpleUploader">
                                <div class="uploads" id="uploads_vehicle">
                                    <?php 
                                        if(!empty($result->vehicle)) {
											$key_vehicle = 0;
											foreach((array)$result->vehicle as $key=>$value) {
												$key_vehicle++;
                                                if(empty($value)) continue;
                                            ?>
                                            <div class="block">
                                                <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
                                                    <a href="<?= $value->path ?>" data-magnify="gallery"  data-gallery="uploads_vehicle" class="magnifyitem" data-type="image" data-title="Hồ sơ thẩm định thực địa">
                                                        <img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='vehicle' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
                                                <?php }?>
                                                <!--Audio-->
                                                <?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
                                                    <a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
                                                        <img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
                                                        <img style="visibility:hidden" name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='vehicle' class="w-100" src="<?= $value->path?>" alt="">
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
                                                        <img style="visibility:hidden" name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='vehicle' class="w-100" src="<?= $value->path?>" alt="">
                                                    </a>
    <!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
                                                <?php }?>
                                          
                                            </div>
                                    <?php }}?>
                                </div>
                                <label for="upload_vehicle">
                                    <div class="block uploader">
                                        <span>+</span>
                                    </div>
                                </label>
                                <input id="upload_vehicle" type="file" name="file" data-contain="uploads_vehicle" data-title="Hồ sơ thẩm định thực địa" multiple data-type="vehicle" class="focus">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--End-->
			<!--Start vehicle-->
			<div class="x_content">
				<form class="form-horizontal form-label-left">
					<div class="form-group ">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Thỏa thuận<?php //$this->lang->line('Vehicle')?> <span class="red">*</span></label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="uploads_agree">
									<?php
									if(!empty($result->agree)) {
										$key_agree = 0;
										foreach((array)$result->agree as $key=>$value) {
											$key_agree++;
											if(empty($value)) continue;
											?>
											<div class="block">
												<?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
													<a href="<?= $value->path ?>" data-magnify="gallery"  data-gallery="uploads_agree" class="magnifyitem" data-type="image"  data-title="Thỏa thuận">
                                                         <img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='agree' class="w-100" src="<?= $value->path?>" alt="">
													</a>
												<?php }?>
												<!--Audio-->
												<?php if($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img name="img_contract" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
														<img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='agree' class="w-100" src="<?= $value->path?>" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
												<?php }?>
												<!--Video-->
												<?php if($value->file_type == 'video/mp4') {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img name="img_contract" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
														<img name="img_contract" data-key="<?= $key?>" data-fileName="<?= $value->file_name?>" data-fileType="<?= $value->file_type?>" data-type='agree' class="w-100" src="<?= $value->path?>" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
												<?php }?>
												
											
											</div>
										<?php }}?>
								</div>
								<label for="upload_agree">
									<div class="block uploader">
										<span>+</span>
									</div>
								</label>
								<input id="upload_agree" type="file" name="file" data-contain="uploads_agree" data-title="Thỏa thuận" multiple data-type="agree" class="focus">
							</div>
						</div>
					</div>
				</form>
			</div>
            
			<!--End-->
            <button style="float: right;" type="button" class="btn btn-info submit_contract_img">Save</button>
           
        </div>
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/simpleUpload.js"></script>

<script>
  $(".magnifyitem").magnify({
   initMaximized: true
  });
</script>
