<script src="https://cdnjs.cloudflare.com/ajax/libs/stacktable.js/1.0.2/stacktable.min.js"></script>
<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/asset/validate.js"></script>
<?php
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : '';
$so_khung = !empty($_GET['so_khung']) ? $_GET['so_khung'] : "";
$so_may = !empty($_GET['so_may']) ? $_GET['so_may'] : "";
$asset_code = !empty($_GET['asset_code']) ? $_GET['asset_code'] : "";
$type = !empty($_GET['asset']) ? $_GET['asset'] : [];
$text = !empty($_GET['text_search']) ? $_GET['text_search'] : '';
$page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="page-title">
		<div class="title_left">
			<a href="<?php echo base_url() ?>asset_manager/asset"><h3 class="d-inline-block">Quản lý tài sản</h3></a>
		</div>
		<div class="title_right text-right">
			<div class="dropdown" style="display:inline-block">
				<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
					<i class="fa fa-plus"></i>
					Thêm mới
					<span class="caret"></span></button>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#" data-toggle="modal" data-target="#addnew_xemay_Modal" id="clickAddMoto"> Xe
							Máy</a></li>
					<li><a href="#" data-toggle="modal" data-target="#addnew_oto_Modal" id="clickAddOto">Ô Tô</a></li>
					<li><a href="#" data-toggle="modal" data-target="#addnew_sodo_Modal" id="clickAddNhaDat"> Sổ Đỏ</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<?php
	$type_asset = [
			'XM' => 'Xe Máy',
			'OTO' => "Ô tô",
			'NĐ' => "Nhà đất"
	]
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Danh sách tài sản (<span
								class="text-danger"><?php echo $total_rows > 0 ? $total_rows : 0; ?></span>)</h2>
					<form method="get" action="<?php echo base_url('asset_manager/asset') ?>">
						<ul class="nav navbar-right panel_toolbox">
							<li>
								<div class="form-group" style="display:inline-block">
									<input type="text" class="form-control" placeholder="Tìm kiếm" name="text_search"
										   onchange="this.form.submit()" value="<?php echo $text ?? '' ?>">
								</div>
								&nbsp;
							</li>
							<li>
								<button class="btn btn-info" type="button">
									<a href="<?= base_url() ?>asset_manager/excel_asset?customer_name=<?= $customer_name . '&asset_code=' . $asset_code . '&so_khung=' . $so_khung . '&so_may=' . $so_may . '&text_search=' . $text . '&' . http_build_query($type_asset, 'asset[]') ?>"
									   target="_blank">
										<i class="fa fa-file-excel-o" aria-hidden="true"></i>
										<span style="color: white">Xuất file XLS</span>
									</a>
								</button>
							</li>

							<li>
								<div class="dropdown" style="display:inline-block">
									<button type="button" class="btn btn-success dropdown-toggle"
											onclick="$('#lockdulieu').toggleClass('show');">
										<span class="fa fa-filter"></span>
										Lọc dữ liệu
									</button>
									<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:15px;min-width:250px;">
										<li class="form-group">
											<div class="form-group">
												<label>Thông tin tài sản:</label>
												<select id="loaitaisan" class="form-control" multiple name="asset[]">
													<option value=""></option>
													<?php foreach ($type_asset as $key => $value) : ?>
														<option value="<?php echo $key ?>"
																<?php
																if (is_array($type)) {
																	echo in_array($key, $type) ? 'selected' : '';
																} ?>>
															<?php echo $value ?>
														</option>
													<?php endforeach; ?>
												</select>
											</div>
											<script>
												$('#loaitaisan').selectize({
													sortField: 'text'
												});
											</script>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>
													Chủ tài sản:</label>
												<input type="text" class="form-control" placeholder="Chủ tài sản"
													   name="customer_name" value="<?php echo $customer_name ?? '' ?>">
											</div>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>Mã tài sản:</label>
												<input type="text" class="form-control" placeholder="Mã tài sản"
													   name="asset_code" value="<?php echo $asset_code ?? '' ?>">
											</div>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>Số khung:</label>
												<input type="text" class="form-control" placeholder="Số khung"
													   name="so_khung" value="<?php echo $so_khung ?? '' ?>">
											</div>
										</li>

										<li class="form-group">
											<div class="form-group">
												<label>Số máy:</label>
												<input type="text" class="form-control" placeholder="Số máy"
													   name="so_may" value="<?php echo $so_may ?? '' ?>">
											</div>
										</li>

										<li class="text-right">
											<!--											<button class="btn btn-secondary"-->
											<!--													onclick="$('#lockdulieu').toggleClass('show');">-->
											<!--												Hủy-->
											<!--											</button>-->
											<button class="btn btn-info">
												<i class="fa fa-search" aria-hidden="true"></i>
												Tìm Kiếm
											</button>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</form>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">


					<!-- start project list -->
					<table class="table stacktable table-quanlytaisan table-bordered">
						<thead>
						<tr style="background: #0a90eb; color: white">
							<th style="text-align: center">#</th>
							<th style="text-align: center">Mã tài sản</th>
							<th style="text-align: center">Loại tài sản</th>
							<th style="text-align: center">Tên tài sản</th>
							<th style="text-align: center">Ngày đăng ký</th>
							<th style="text-align: center">Tên chủ tài sản</th>
							<!--							<th>Số HD liên quan</th>-->
							<th style="text-align: center">Chức năng</th>
						</tr>
						</thead>
						<tbody>
						<tr>

						</tr>
						<?php foreach ($assets as $key => $asset) { ?>
							<tr style="text-align: center">
								<td>
									<?php echo ++$key + $page ?>
								</td>
								<td>
									<?php echo $asset->asset_code ?? '' ?>
								</td>
								<td>
									<?php if ($asset->type == "XM"): ?>
										<i class="fa fa-motorcycle" style="font-size:20px;color: #0e90d2"></i>
									<?php elseif ($asset->type == 'OTO') : ?>
										<i class="fa fa-car" style="font-size:20px;color: #20b426"></i>
									<?php else: ?>
										<i class="fa fa-credit-card" style="font-size:20px;color: red"></i>
									<?php endif; ?>
								</td>
								<td>
									<?php echo $asset->product ?? '' ?>
								</td>
								<td>
									<?php if ($asset->type == "NĐ") { ?>
										<?php echo date('d/m/Y', $asset->ngay_cap) ?>
									<?php } else if ($asset->type == "XM"): ?>
										<?php if (!empty($asset->ngay_cap)) : ?>
											<?php if (!filter_var($asset->ngay_cap, FILTER_VALIDATE_INT)) : ?>
												<?php echo date('d/m/Y', strtotime($asset->ngay_cap)) ?>
											<?php else: ?>
												<?php echo date('d/m/Y', $asset->ngay_cap) ?>
											<?php endif; ?>
										<?php else: ?>
											<?php echo '' ?>
										<?php endif; ?>
									<?php elseif ($asset->type == "OTO"): ?>
										<?php if (!empty($asset->ngay_cap)) : ?>
											<?php if (!filter_var($asset->ngay_cap, FILTER_VALIDATE_INT)) : ?>
												<?php echo $asset->ngay_cap ?>
											<?php else: ?>
												<?php echo date('d/m/Y', $asset->ngay_cap) ?>
											<?php endif; ?>
										<?php else: ?>
											<?php echo '' ?>
										<?php endif; ?>
									<?php else: ?>
										<?php echo !empty($asset->ngay_cap) ? $asset->ngay_cap : '' ?>
									<?php endif; ?>
								</td>
								<td>
									<?php echo $asset->customer_name ?? '' ?>
								</td>
								<!--								<td>-->
								<!--									--><?php //echo $asset->so_hd_lien_quan ?? 0 ?>
								<!--								</td>-->
								<td style="text-align: center">
									<button class="btn btn-info btn-sm" title="Xem Nhanh"
											onclick="$('.quanlytaisan_detail_<?php echo $asset->_id->{'$oid'} ?>').toggleClass('d-none');">
										<i class="fa fa-eye"></i>
									</button>
									<div class="dropdown" style="display:inline-block">
										<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
												title="Chức Năng"
												data-toggle="dropdown">
											<i class="fa fa-cogs"></i>
											<span class="caret"></span></button>
										<ul class="dropdown-menu dropdown-menu-right">
											<!--											<li><a href="#"><i class="fa fa-pencil-square-o"></i> Sửa thông tin</a></li>-->
											<li><a target="_blank"
												   href="<?php echo base_url("asset_manager/viewImageAsset?id=") . $asset->_id->{'$oid'} ?>"><i
															class="fa fa-list"></i> Hồ sơ tài sản</a></li>
										</ul>
									</div>
								</td>
							</tr>
							<tr id="quanlytaisan_detail_<?php echo $asset->_id->{'$oid'} ?>"
								class="d-none quanlytaisan_detail quanlytaisan_detail_<?php echo $asset->_id->{'$oid'} ?>">
								<td colspan="7">
									<?php $this->load->view('page/asset/quanlytaisan_detail', ['asset' => $asset ?? '']); ?>
								</td>
							</tr>

						<?php } ?>
						</tbody>
					</table>
					<!-- end project list -->
					<div class="">
						<?php echo $pagination; ?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<form role="form" id="main_1" class="form-horizontal form-label-left" action="" method="post" novalidate>

	<?php $this->load->view('page/asset/addnew_xemay_Modal'); ?>
	<?php $this->load->view('page/asset/addnew_oto_Modal'); ?>
	<?php $this->load->view('page/asset/addnew_sodo_Modal'); ?>
</form>
<script type="text/javascript">
	$(document).ready(function () {
		$('.stacktable').stacktable();
	});

</script>
<style>
	.help-block {
		display: inline-block !important;
		margin: 0px !important;
	}

	.has-error {
		border-color: #9f041b !important;
	}

	.has-success {
		border-color: #35DB00 !important;
	}
</style>
<script src="<?php echo base_url() ?>assets/js/asset/addmoto.js"></script>
<script src="<?php echo base_url() ?>assets/js/asset/addoto.js"></script>
<script src="<?php echo base_url() ?>assets/js/asset/addNhaDat.js"></script>
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
<script>
	$(document).ready(function () {
		$('#clickAddMoto').click(function () {
			$("#main_1").trigger("reset")
			$('.block').remove()
		})
		$('#clickAddOto').click(function () {
			$("#main_1").trigger("reset")
			$('.block').remove()
		})
		$('#clickAddNhaDat').click(function () {
			$("#main_1").trigger("reset")
			$('.block').remove()
		})
	})
</script>
