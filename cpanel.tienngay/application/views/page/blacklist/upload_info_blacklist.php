
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span ><?= $this->lang->line('Loading')?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Upload black list
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Upload black list</a></small>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<?php if ($this->session->flashdata('error')) { ?>
					<div class="alert alert-danger alert-result">
						<?= $this->session->flashdata('error') ?>
					</div>
				<?php } ?>

				<?php if (!empty($this->session->flashdata('notify'))) { $notify =  $this->session->flashdata('notify');?>
					<?php foreach ($notify as $key => $value){ ?>
						<div class="alert alert-danger alert-result"><?= $value ?></div>
					<?php } ?>
				<?php } ?>
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2">
							<div class="panel panel-default">
								<form action="<?php echo base_url('BlackList/upload') ?>" enctype="multipart/form-data" method="post">
<!--									<div class="form-group">-->
<!--										<label for="imageBlackList">Ảnh</label>-->
<!--										<input type="file" class="form-control" id="imageBlackList">-->
<!--									</div>-->
											<input type='file' name="image" id="imageBlackList">
											<img id="imgBlackList" style="width: 200px" src="<?php echo base_url(); ?>assets/imgs/default_image.png" alt="your image" />
<!--										<div class="form-group">-->
<!--											<textarea style="width: 350px;margin: 22px" class="form-control" id="noteBlackList" name="note_blacklist" rows="3"></textarea>-->
<!--										</div>-->
											<div class="form-group">
												<label for="nameBlacklist">Tên</label>
												<input type="text" class="form-control" name="name" id="nameBlacklist">
											</div>
											<div class="form-group">
												<label for="phoneBlackList">Số điện thoại</label>
												<input type="text" class="form-control" name="phone" id="phoneBlackList">
											</div>
											<div class="form-group">
												<label for="identifyBlackList">Số CMTND</label>
												<input type="text" class="form-control" name="identify" id="identifyBlackList">
											</div>
											<div class="form-group">
												<label for="noteBlackList">Ghi chú</label>
												<textarea class="form-control" id="noteBlackList" name="note" rows="3"></textarea>
											</div>
									<input type="text" name="url_image" id="urlImgBlackList" hidden>
									<button type="submit" class="btn btn-primary" style="margin-top:30px"><?= $this->lang->line('Upload') ?></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url();?>assets/js/pawn/index.js"></script>
<!--<script>-->
<!--	function readURL(input) {-->
<!--		if (input.files && input.files[0]) {-->
<!--			var reader = new FileReader();-->
<!---->
<!--			reader.onload = function (e) {-->
<!--				$('#blah')-->
<!--					.attr('src', e.target.result)-->
<!--					.height(300);-->
<!--			};-->
<!---->
<!--			reader.readAsDataURL(input.files[0]);-->
<!--		}-->
<!--	}-->
<!--</script>-->
