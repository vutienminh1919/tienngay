
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span ><?= $this->lang->line('Loading')?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Import database
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Import database</a></small>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<?php if ($this->session->flashdata('error')) { ?>
					<div class="alert alert-danger alert-result">
						<?= $this->session->flashdata('error') ?>
					</div>
				<?php } ?>

				<?php if ($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
				<?php } ?>

				<?php if (!empty($this->session->flashdata('notify'))) { $notify =  $this->session->flashdata('notify');?>
					<?php foreach ($notify as $key => $value){ ?>
						<div class="alert alert-danger alert-result"><?= $value ?></div>
					<?php } ?>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 orange">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import Lead
							</div>
							<div class="panel panel-default">
								<form class="form-inline" id="form_transaction" action="<?php echo base_url('MKTImportLead/importLead') ?>" enctype="multipart/form-data" method="post">
									<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
									<div class="form-group">
										<input type="file" name="upload_file" class="form-control" placeholder="sothing" >
										<!--										<input type="hidden" id="current" name="current" value="0">-->
										<!--										<input type="hidden" id="current" name="current" value="0">-->
									</div>
									<button type="submit" class="btn btn-primary" id="import_baddebt" style="margin:0"><?= $this->lang->line('Upload') ?></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

<!--			<div class="x_content">-->
<!--				<div class="row">-->
<!--					<div class="col-xs-12 col-md-6">-->
<!--						<div class="dashboarditem_line2 blue">-->
<!--							<div class="thetitle">-->
<!--								<i class="fa fa-upload"></i> Import Lead Trandata-->
<!--							</div>-->
<!--							<div class="panel panel-default">-->
<!--								<form class="form-inline" id="form_transaction" action="--><?php //echo base_url('MKTImportLead/importLead_trandata') ?><!--" enctype="multipart/form-data" method="post">-->
<!--									<div class="form-group">-->
<!--										<input type="file" name="upload_file" class="form-control" placeholder="sothing" >-->
<!--									</div>-->
<!--									<button type="submit" class="btn btn-primary" id="import_baddebt" style="margin:0">Upload</button>-->
<!--								</form>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->

		</div>
	</div>
</div>
