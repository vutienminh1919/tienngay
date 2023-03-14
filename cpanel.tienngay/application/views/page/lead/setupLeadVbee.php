
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span ><?= $this->lang->line('Loading')?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Setup Vbee Lọc Lead
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="<?php echo base_url('lead/setupVbeeLead') ?>">Vbee lead</a></small>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="y_content">
				<?php if ($this->session->flashdata('error')) { ?>
					<div class="alert alert-danger alert-result">
						<?= $this->session->flashdata('error') ?>
					</div>
				<?php } ?>

				<?php if ($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="dashboarditem_line2 orange">
							<div class="panel panel-body">
								<form class="form-inline" id="form_transaction" action="<?php echo base_url('lead/saveVbeeSetting') ?>" enctype="multipart/form-data" method="post">
									<div class="form-group">
                                        <div class="row">
                                            <div class="col-12 panel-heading">
                                                <strong>Nguồn Lead</strong>
                                            </div>
                                        </div>
										<hr>
                                        <div class="row">
                                            <div class="col-12 panel-body">
                                                <?php foreach(lead_nguon() as $key => $item) :?> 
                                                    <div class="col-md-2 col-xs-12">
                                                        <input type="checkbox" name="source[]" <?= (in_array($key, $source) ? "checked" : "") ?>
                                                        class="form-control" value="<?php echo $key ?>" > <?php echo $key. ' - ' . $item; ?>
                                                        <br>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
									</div>
									<hr>
                                    <div class="row">
                                        <div class="col-12 panel-footer">
                                            <button type="submit" class="form-control btn btn-success">Cài đặt</button>
                                        </div>
                                    </div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
        $(function() {
            var timeout = 2500; // in miliseconds (3*1000)
            $('.y_content').delay(timeout).fadeOut(300);
	    });
	});
</script>
