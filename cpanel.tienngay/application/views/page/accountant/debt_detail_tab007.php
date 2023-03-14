<!-- page content -->

<?php
$contract_id = !empty($_GET['id']) ? $_GET['id'] : "" ;
?>
<link href="<?php echo base_url();?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
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
											<?php if(!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {?>
												<a href="<?= $value->path ?>" 
													class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  
														 data-caption="Hồ sơ nhân thân <?php echo $key_identify ?>">
													<img class="w-100" src="<?= $value->path?>" alt="">
												</a>
											<?php }?>
											<!--Audio-->
											<?php if(!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) {?>
												<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
													<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
												</a>
												<!--                                                <audio controls>
                                                    <source src="<?= $value->path?>" type="audio/mpeg">
                                                    <?= $value->file_name?>
                                                </audio>-->
											<?php }?>
											<!--Video-->
											<?php if(!empty($value->file_type) && ($value->file_type == 'video/mp4')) {?>
												<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
													<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
												</a>
												<!--                                                <video width="320" height="240" controls>
                                                    <source src="<?= $value->path?>" type="video/mp4">
                                                    <?= $value->file_name?>
                                                </video>-->
											<?php }?>
										</div>
									<?php }?>
								</div>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hồ sơ chứng minh thu nhập<?php //$this->lang->line('household')?> <span class="red">*</span></label>
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
												<?php if(!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {?>
													<a href="<?= $value->path ?>" 
														class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  
														 data-caption="Hồ sơ chứng minh thu nhập <?php echo $key_household ?>">
														<img class="w-100" src="<?= $value->path?>" alt="">
													</a>
												<?php }?>
												<!--Audio-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
												<?php }?>
												<!--Video-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'video/mp4')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
												<?php }?>
											</div>
										<?php }}?>
								</div>
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
												<?php if(!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {?>
													<a href="<?= $value->path ?>" 
														class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  
														 data-caption="Hồ sơ tài sản <?php echo $key_driver_license ?>">
														<img class="w-100" src="<?= $value->path?>" alt="">
													</a>
												<?php }?>
												<!--Audio-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
												<?php }?>
												<!--Video-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'video/mp4')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
												<?php }?>
											</div>
										<?php }}?>
								</div>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hồ sơ thẩm định thực địa<?php //$this->lang->line('Vehicle')?> <span class="red">*</span></label>
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
												<?php if(!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {?>
													<a href="<?= $value->path ?>"
													class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  
														 data-caption="Hồ sơ thẩm định thực địa <?php echo $key_vehicle ?>">
														<img class="w-100" src="<?= $value->path?>" alt="">
													</a>
												<?php }?>
												<!--Audio-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
												<?php }?>
												<!--Video-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'video/mp4')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
												<?php }?>
											</div>
										<?php }}?>
								</div>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Thỏa thuận<?php //$this->lang->line('Vehicle')?> <span class="red">*</span></label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="uploads_agree">
									<?php
									$key_agree = 0;
									if(!empty($result->agree)) {
										$key_agree++;
										foreach((array)$result->agree as $key=>$value) {
											if(empty($value)) continue;
											?>
											<div class="block">
												<?php if(!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {?>
													<a href="<?= $value->path ?>" 
														class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  
														 data-caption="Thỏa thuận <?php echo $key_agree ?>">
														<img class="w-100" src="<?= $value->path?>" alt="">
													</a>
												<?php }?>
												<!--Audio-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
												<?php }?>
												<!--Video-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'video/mp4')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
												<?php }?>
											</div>
										<?php }}?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!--End-->
			
				<!--Start extension-->
				<div class="x_content">
				<form class="form-horizontal form-label-left">
					<div class="form-group ">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hồ sơ gia hạn <span class="red">*</span></label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<div id="SomeThing" class="simpleUploader line">
								<div class="uploads" id="uploads_extension">
									<?php
									if(!empty($result->extension)) {
										$key_extension = 0;
										foreach((array)$result->extension as $key=>$value) {
											$key_extension++;
											if(empty($value)) continue;
											?>
											<div class="block">
												<?php if(!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {?>
													<a href="<?= $value->path ?>"
													class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  
														 data-caption="Hồ sơ gia hạn <?php echo $key_extension ?>">
														<img class="w-100" src="<?= $value->path?>" alt="">
													</a>
												<?php }?>
												<!--Audio-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path?>" type="audio/mpeg">
                                                        <?= $value->file_name?>
                                                    </audio>-->
												<?php }?>
												<!--Video-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'video/mp4')) {?>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path?>" type="video/mp4">
                                                        <?= $value->file_name?>
                                                    </video>-->
												<?php }?>
												<div class="description" style="width:590px !important"><textarea disabled cols="500" rows="6" data-key="<?= $key?>" name="description_img" ><?= !empty($value->description) ? $value->description : "" ?></textarea></div>
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

<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>



<script>
  $(".magnifyitem").magnify({
   initMaximized: true
  });
</script>
