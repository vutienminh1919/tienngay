<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>CF PLAN ACTUAL
						</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
<!--					<div class="row">-->
<!--						<ul class="nav nav-tabs" style="margin-bottom: 20px">-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexPlanActual">CF</a>-->
<!--							</li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexBankBalance">Số dư-->
<!--									các TK NH</a></li>-->
<!--							<li role="presentation" class="active"><a-->
<!--									href="--><?php //echo base_url() ?><!--plan_actual/indexFollowVPS">Theo dõi VPS</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexFollowDebt">Quản lý hợp đồng vay</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexInvestor">Nhà đầu tư</a></li>-->
<!--							<li role="presentation" ><a href="--><?php //echo base_url() ?><!--plan_actual/indexDisbursement">Giải ngân Actual</a></li>-->
<!--							<li role="presentation" ><a href="--><?php //echo base_url() ?><!--plan_actual/indexCpWork">CP hoạt động</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexHistorical">Historical Data CP</a></li>-->
<!--						</ul>-->
<!--					</div>-->
				</div>

				<?php if ($this->session->flashdata('error')) { ?>
					<div class="alert alert-danger alert-result">
						<?= $this->session->flashdata('error') ?>
					</div>
				<?php } ?>

				<?php if ($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
				<?php } ?>

				<?php if (!empty($this->session->flashdata('notify'))) {
					$notify = $this->session->flashdata('notify'); ?>
					<?php foreach ($notify as $key => $value) { ?>
						<div class="alert alert-danger alert-result"><?= $value ?></div>
					<?php } ?>
				<?php } ?>
				<div class="clearfix"></div>

				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import Follow VPS / <a target="_blank" href="https://docs.google.com/spreadsheets/d/1vj2zpNaG_3rSQAojeCIssKuIVVo3cNyw/edit?usp=sharing&ouid=102311822211991550698&rtpof=true&sd=true" download>Dowload File Mẫu </a>
							</div>
							<div class="panel panel-default">
								<form class="form-inline" id=""
									  action="<?php echo base_url('plan_actual/importFollowVPS') ?>"
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
					<div class="col-xs-12 col-md-6">
					</div>


					<div class="table-responsive col-xs-12 col-md-12" style="overflow-y: auto; padding-top: 20px">
						<table
							class="table table-bordered m-table table-hover table-calendar table-report">

							<thead style="color: white;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Đối tượng gửi</th>
								<th style="text-align: center">Số HĐ</th>
								<th style="text-align: center">Số tiền gửi gốc (VNĐ)</th>
								<th style="text-align: center">Lãi suất (%/năm)</th>
								<th style="text-align: center">Kỳ hạn ban đầu (ngày)</th>
								<th style="text-align: center">Kỳ hạn gia hạn (ngày)</th>
								<th style="text-align: center">Ngày gửi/Ngày tái tục</th>
								<th style="text-align: center">Ngày đáo hạn/Ngày tất toán dự kiến</th>
								<th style="text-align: center">Lãi đáo hạn dự kiến</th>
								<th style="text-align: center">Ngày đáo hạn thực tế</th>
								<th style="text-align: center">Trạng thái</th>
								<th style="text-align: center">Lãi thực tế</th>
								<th style="text-align: center">Tổng tiền đáo hạn</th>
								<th style="text-align: center">Ghi chú</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($getFollowVps)): ?>
								<tr>
									<th style="text-align: center">Tổng</th>
									<th style="text-align: center"></th>
									<th style="text-align: center"></th>
									<th style="text-align: center"><?= number_format($total_tien_gui_goc) ?></th>
									<th style="text-align: center"></th>
									<th style="text-align: center"></th>
									<th style="text-align: center"></th>
									<th style="text-align: center"></th>
									<th style="text-align: center"></th>
									<th style="text-align: center"><?= number_format($total_lai_dao_han_du_kien) ?></th>
									<th style="text-align: center"></th>
									<th style="text-align: center"></th>
									<th style="text-align: center"><?= number_format($total_lai_thuc_te) ?></th>
									<th style="text-align: center"><?= number_format($total_tong_tien_dao_han) ?></th>
									<th style="text-align: center"></th>
								</tr>
								<?php foreach ($getFollowVps as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td style="text-align: center"><?= !empty($value->doi_tuong_gui) ? $value->doi_tuong_gui : '' ?></td>
										<td><?= !empty($value->so_hd) ? $value->so_hd : '' ?></td>
										<td style="text-align: center"><?= !empty($value->so_tien_gui_goc) ? number_format($value->so_tien_gui_goc) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->lai_suat) ? ($value->lai_suat) : '' ?></td>
										<td style="text-align: center"><?= !empty($value->ky_han_ban_dau) ? $value->ky_han_ban_dau : '' ?></td>
										<td style="text-align: center"><?= !empty($value->ky_han_gia_han) ? $value->ky_han_gia_han : '' ?></td>
										<td style="text-align: center"><?= !empty($value->ngay_gui) ? date('d/m/Y', $value->ngay_gui) : '' ?></td>
										<td style="text-align: center"><?= !empty($value->ngay_dao_han_du_kien) ? date('d/m/Y', $value->ngay_dao_han_du_kien) : '' ?></td>
										<td style="text-align: center"><?= !empty($value->lai_dao_han_du_kien) ? number_format($value->lai_dao_han_du_kien) : '' ?></td>
										<td style="text-align: center"><?= !empty($value->ngay_dao_han_thuc_te) ? date('d/m/Y', $value->ngay_dao_han_thuc_te) : '' ?></td>
										<td><?= !empty($value->trang_thai) ? $value->trang_thai : '' ?></td>
										<td style="text-align: center"><?= !empty($value->lai_thuc_te) ? number_format($value->lai_thuc_te) : '' ?></td>
										<td style="text-align: center"><?= !empty($value->tong_tien_dao_han) ? number_format($value->tong_tien_dao_han) : '' ?></td>
										<td style="text-align: center"><?= !empty($value->ghichu) ? $value->ghichu : '' ?></td>
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

<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>

<style>
	.page-title {
		min-height: 0px;
		padding: 0px 0;
	}
</style>
<script>
	$("#on_loading").click(function (event) {
		$(".theloading").show()
	});
</script>
