<!-- page content -->

<?php
$id = !empty($_GET['id']) ? $_GET['id'] : "" ;
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
						<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('gic_easy/list_gic_easy')?>">Gic Easy</a>/ <a href="#">Chứng từ</a>
					</small>
				</h3>
			</div>
			<div class="title_right text-right">
				<a href="<?php echo base_url('gic_easy/list_gic_easy')?>" class="btn btn-info ">
					<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back')?>
				</a>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<input type="hidden" id="asset_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>">
			<!--Start driver_license-->
			<div class="x_content">
				<form class="form-horizontal form-label-left">
					<div class="form-group ">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Chứng từ BH MIC-TNDS <?php //$this->lang->line('Driver_license_vehicle_registration')?><span class="red">*</span></label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="uploads_driver_license">
									<?php
									if(!empty($images->image)) {
										$key_image = 0;
										foreach((array)$images->image as $key=>$value) {
											$key_image++;
											if(empty($value)) continue;
											?>
											<div class="block">
													<a href="<?= $value ?>"
													   class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery">
														<img class="w-100" src="<?= $value?>" alt="">
													</a>
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
<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />


<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>
