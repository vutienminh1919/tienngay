<!-- page content -->
<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<?php
$contract_id = !empty($_GET['id']) ? $_GET['id'] : "";
?>
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="row">
				<div class="col-md-6">
					<div class="title_left">
						<h3>XEM CHỨNG TỪ
							<br>
						</h3>
					</div>
				</div>
				<div class="col-md-6">
					<div class="title_right text-right">
						<a href="<?php echo base_url('accountant/index_list_contractMkt')?>" class="btn btn-info ">
							<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back')?>
						</a>
					</div>
				</div>


			</div>

		</div>

	</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<input type="hidden" id="contract_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>">

			<!--Start expertise-->
			<?php if (!empty($result)) { ?>

				<div class="x_content">

					<form class="form-horizontal form-label-left">
						<div class="form-group ">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ảnh chứng minh
								thư </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_expertise">
										<?php

										foreach ((array)$result->customer_infor->img_file_presenter_cmt as $key => $value) {
											if (empty($value)) continue;
											?>
											<div class="block">
												<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
													<a href="<?= $value->path ?>" class="magnifyitem"
													   data-magnify="gallery" data-src="" data-group="thegallery"
													   data-toggle="lightbox" data-gallery="uploads_expertise"
													   data-max-width="992" data-type="image">
														<img name="img_contract_ksnb" data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' src="<?= $value->path ?>" alt="">
													</a>
												<?php } ?>
												<!--Audio-->
												<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
													<a href="<?= $value->path ?>" target="_blank"><span
															style="z-index: 9"><?= $value->file_name ?></span>
														<img
															style="width: 50%;transform: translateX(50%)translateY(-50%);"
															src="https://image.flaticon.com/icons/png/512/81/81281.png"
															alt="">
														<img style="display:none" name="img_contract_ksnb"
															 data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' class="w-100"
															 src="<?= $value->path ?>" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path ?>" type="audio/mpeg">
                                                        <?= $value->file_name ?>
                                                    </audio>-->
												<?php } ?>
												<!--Video-->
												<?php if ($value->file_type == 'video/mp4') { ?>
													<a href="<?= $value->path ?>" target="_blank"><span
															style="z-index: 9"><?= $value->file_name ?></span>
														<img
															style="width: 50%;transform: translateX(50%)translateY(-50%);"
															src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
															alt="">
														<img style="display:none" name="img_contract_ksnb"
															 data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' class="w-100"
															 src="<?= $value->path ?>" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path ?>" type="video/mp4">
                                                        <?= $value->file_name ?>
                                                    </video>-->
												<?php } ?>

											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>


					</form>

				</div>

				<div class="x_content">

					<form class="form-horizontal form-label-left">
						<div class="form-group ">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ảnh chứng từ thanh toán </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_expertise">
										<?php

										foreach ((array)$result->customer_infor->img_approve as $key => $value) {
											if (empty($value)) continue;
											?>
											<div class="block">
												<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
													<a href="<?= $value->path ?>" class="magnifyitem"
													   data-magnify="gallery" data-src="" data-group="thegallery"
													   data-toggle="lightbox" data-gallery="uploads_expertise"
													   data-max-width="992" data-type="image">
														<img name="img_contract_ksnb" data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' src="<?= $value->path ?>" alt="">
													</a>
												<?php } ?>
												<!--Audio-->
												<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
													<a href="<?= $value->path ?>" target="_blank"><span
																style="z-index: 9"><?= $value->file_name ?></span>
														<img
																style="width: 50%;transform: translateX(50%)translateY(-50%);"
																src="https://image.flaticon.com/icons/png/512/81/81281.png"
																alt="">
														<img style="display:none" name="img_contract_ksnb"
															 data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' class="w-100"
															 src="<?= $value->path ?>" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path ?>" type="audio/mpeg">
                                                        <?= $value->file_name ?>
                                                    </audio>-->
												<?php } ?>
												<!--Video-->
												<?php if ($value->file_type == 'video/mp4') { ?>
													<a href="<?= $value->path ?>" target="_blank"><span
																style="z-index: 9"><?= $value->file_name ?></span>
														<img
																style="width: 50%;transform: translateX(50%)translateY(-50%);"
																src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																alt="">
														<img style="display:none" name="img_contract_ksnb"
															 data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' class="w-100"
															 src="<?= $value->path ?>" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path ?>" type="video/mp4">
                                                        <?= $value->file_name ?>
                                                    </video>-->
												<?php } ?>

											</div>
										<?php } ?>
									</div>
								</div>
							</div>

						</div>

					</form>

				</div>
			<?php } ?>

			<!--End-->
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<script>
	$(document).on('click', '[data-toggle="lightbox"]', function (event) {
		event.preventDefault();
		$(this).ekkoLightbox({
			alwaysShowClose: true,
		});
	});
</script>
<style>

	.ekko-lightbox .modal-header {
		padding-top: 5px;
		padding-bottom: 5px;
	}

	.ekko-lightbox .modal-body {
		padding: 5px;
	}
</style>
<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>

