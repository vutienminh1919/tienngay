<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>CONVERT UID TO PHONE FACEBOOK</h3>
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
							<div class="dashboarditem_line2 orange">
								<div class="thetitle">
									<i class="fa fa-upload"></i> Import File UID
								</div>
								<div class="panel panel-default">
									<form class="form-inline" id="form_transaction" action="<?php echo base_url('MKTImportLead/importUidFacebook') ?>"
										  enctype="multipart/form-data" method="post">
										<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
										<div class="form-group">
											<input type="file" name="upload_file" class="form-control"
												   placeholder="sothing">
										</div>
										<button type="submit" class="btn btn-primary" id="on_loading"
												style="margin:0"><?= $this->lang->line('Upload') ?></button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<br><br>
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Tên File</th>
								<th style="text-align: center">Người import</th>
								<th style="text-align: center">Thời gian</th>
							</tr>
							</thead>
							<tbody>
							<?php if(!empty($export_uid)): ?>
							<?php foreach ($export_uid as $key => $value): ?>
								<tr>
									<td style="text-align: center"><?= ++$key ?></td>
									<td style="text-align: center; cursor: pointer;"><img style="width: 20px; height: auto" src="https://findicons.com/files/icons/2795/office_2013_hd/256/excel.png">  <a target="_blank" href="<?= base_url() ?>excel/export_excel_uid?id_file_name=<?= $value->file_name ?>"><?= !empty($value->file_name) ? $value->file_name : "" ?></a></td>
									<td style="text-align: center"><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
									<td style="text-align: center"><?= !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : "" ?></td>
								</tr>
							<?php endforeach; ?>
							<?php endif; ?>
							</tbody>
						</table>
						<div class="">
							<?php echo $pagination ?>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>

<script>
	$("#on_loading").click(function (event) {
		$(".theloading").show()
	});
</script>









