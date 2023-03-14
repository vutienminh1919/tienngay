<!-- page content -->

<?php
$id_exemption_contract = !empty($_GET['id']) ? $_GET['id'] : "" ;
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<link href="<?php echo base_url();?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Chứng từ
					<br>
					<small>
						<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('exemptions/index')?>">Danh sách hợp đồng miễn giảm</a> / <a href="#">Chứng từ</a>
					</small>
				</h3>
			</div>
			<div class="title_right text-right">
				<a href="<?php echo base_url('exemptions/index')?>" class="btn btn-info ">
					<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back')?>
				</a>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<input type="hidden" id="id_exemption_contract" value="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>">
			<!--Start identify-->
			<div class="x_content">
				<form class="form-horizontal form-label-left">
					<div class="form-group ">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Ảnh hồ sơ miễn giảm <?php //$this->lang->line('cmnd')?><span class="red">*</span></label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads " id="uploads_identify">
									<?php
									$key_identify = 0;
									foreach((array)$result->image_exemption_profile as $key=>$value) {
										$key_identify++;
										if(empty($value)) continue;?>
										<div class="block">
											<!--//Image-->
											<?php if(!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {?>
												<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
												<a href="<?= $value->path ?>"
												   class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"
												   data-caption="Hồ sơ nhân thân <?php echo $key_identify ?>">
													<img class="w-100" src="<?= $value->path?>" alt="">
												</a>

											<?php }?>
											<!--Audio-->
											<?php if(!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) {?>
												<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
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
												<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
												<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
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
													<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">
												</a>
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
		</div>
	</div>
</div>
<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />


<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>
