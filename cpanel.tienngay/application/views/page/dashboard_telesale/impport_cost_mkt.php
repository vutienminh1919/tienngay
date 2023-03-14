<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	?>
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Import Chi Phí Quảng Cáo Marketing</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12">
							<?php if ($this->session->flashdata('error')) { ?>
								<div class="alert alert-danger alert-result">
									<?= $this->session->flashdata('error') ?>
								</div>
							<?php } ?>
							<?php if ($this->session->flashdata('success')) { ?>
								<div
									class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="dashboarditem_line2 blue">
								<div class="thetitle">
									<i class="fa fa-upload"></i> Import Cost Facebook / (example: xxx.xlsx)
								</div>
								<div class="panel panel-default">
									<form class="form-inline" id=""
										  action="<?php echo base_url('dashboard/importCostFacebook') ?>"
										  enctype="multipart/form-data" method="post">
										<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
										<div class="form-group">
											<input type="file" name="upload_file" class="form-control"
												   placeholder="sothing">
										</div>
										<button type="submit" class="btn btn-primary" id="on_loading_facebook"
												style="margin:0"><?= $this->lang->line('Upload') ?></button>
									</form>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="dashboarditem_line2 red">
								<div class="thetitle">
									<i class="fa fa-upload"></i> Import Cost Google / (example: xxx.xlsx)
								</div>
								<div class="panel panel-default">
									<form class="form-inline" id=""
										  action="<?php echo base_url('dashboard/importCostGoogle') ?>"
										  enctype="multipart/form-data" method="post">
										<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
										<div class="form-group">
											<input type="file" name="upload_file" class="form-control"
												   placeholder="sothing">
										</div>
										<button type="submit" class="btn btn-primary" id="on_loading_google"
												style="margin:0"><?= $this->lang->line('Upload') ?></button>
									</form>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="dashboarditem_line2 black">
								<div class="thetitle">
									<i class="fa fa-upload"></i> Import Cost Tiktok / (example: xxx.xlsx)
								</div>
								<div class="panel panel-default">
									<form class="form-inline" id=""
										  action="<?php echo base_url('dashboard/importCostTiktok') ?>"
										  enctype="multipart/form-data" method="post">
										<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
										<div class="form-group">
											<input type="file" name="upload_file" class="form-control"
												   placeholder="sothing">
										</div>
										<button type="submit" class="btn btn-primary" id="on_loading_tiktok"
												style="margin:0"><?= $this->lang->line('Upload') ?></button>
									</form>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="dashboarditem_line2 orange">
								<div class="thetitle">
									<i class="fa fa-upload"></i> Import Chi Phí Khác / <a href="https://docs.google.com/spreadsheets/d/1l5pnd9oftniB1HeDlx296ISJ50NLA8MB/edit?usp=sharing&ouid=102311822211991550698&rtpof=true&sd=true">Click Download File Mẫu</a>
								</div>
								<div class="panel panel-default">
									<form class="form-inline" id=""
										  action="<?php echo base_url('dashboard/importOther') ?>"
										  enctype="multipart/form-data" method="post">
										<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
										<div class="form-group">
											<input type="file" name="upload_file" class="form-control"
												   placeholder="sothing">
										</div>
										<button type="submit" class="btn btn-primary" id="on_loading_google"
												style="margin:0"><?= $this->lang->line('Upload') ?></button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>

	</div>
</div>



<style>
	.dashboarditem_line2.blue .thetitle {
		background: #1b74e4;
	}

	.dashboarditem_line2.red .thetitle {
		background: #ea4335;
	}

	.dashboarditem_line2.black .thetitle {
		background: #000000;
	}

	.page-title {
		min-height: 0px !important;
	}
</style>

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>

<script>
	$("#on_loading").click(function (event) {
		$(".theloading").show()
	});
</script>








