<div class="right_col" role="main">
	<?php
	$code_property = !empty($_GET['hang_xe']) ? $_GET['hang_xe'] : '';
	$type_property = !empty($_GET['type']) ? $_GET['type'] : '';
	; ?>
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
		<?php if ($this->session->flashdata('error')) { ?>
			<div class="alert alert-danger alert-result">
				<?= $this->session->flashdata('error') ?>
			</div>
		<?php } ?>
		<?php if ($this->session->flashdata('success')) { ?>
			<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
		<?php } ?>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="row">
					<div class="col-xs-8">
						<div class="title">
							<span class="tilte_top_tabs">
								Check thật/giả đăng ký/cavet xe
							</span>

						</div>
					</div>
					<div class="col-xs-4 text-right">
					</div>
				</div>
			</div>
			<div class="middle table_tabs">
				<div class="clicked nav_tabs_vertical nav tabs">

				</div>

				<div class="tab-contents">
					<!-- tab valuation-->
					<div role="tabpanel" class="tab-pane fade in"
						 id="dinh-gia-tai-san"
						 aria-labelledby="khau-hao-tab">
						<div class="row">
							<div class="col-md-6 col-sx-12 text-left btn_list_filter">

							</div>
							<div class="col-md-6 col-sx-12 btn_list_filter text-right">
								<div class="button_functions btn-filter">
									<a <?= !in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'style="display:none"'?> class="btn btn-success" href="<?= base_url('property/requestBlacklistCreate') ?>">Tạo yêu cầu</a>
									<div class="button_functions btn-fitler">
										<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
											Tìm kiếm <i class="fa fa-filter"></i>
										</button>
										<div class="dropdown-menu drop_select">
											<select id="sellect-Range property_blacklist" class="limit_on_page" name="property_blacklist" onchange="get_property_infor(this)">
												<option value="">Chọn loại xe</option>
												<?php foreach ($mainPropertyData as $property_data) :
													if (in_array($property_data->code, ['TC','NĐ'])) continue;
													?>
													<option <?php echo $type_property == $property_data->code ? 'selected' : ''; ?>
															value="<?= !empty($property_data->code) ? $property_data->code : '' ?>">
														<?= !empty($property_data->name) ? $property_data->name : '' ?>
													</option>
												<?php endforeach; ?>
											</select>
											<select id="selectize_property_by_main" class="choose_branch"
												   	name="hang_xe_blacklist"
													placeholder="Hãng xe">
												<option value="">Chọn hãng xe</option>
												<?php foreach ($branch_property as $branch) : ?>
													<option <?php echo $code_property === $branch->id ? 'selected' : ''; ?>
															value="<?= !empty($branch->id) ? $branch->id : '' ?>"><?php echo !empty($branch->name) ? $branch->name : '' ?>
													</option>
												<?php endforeach; ?>
											</select>
											<select id="sellect-Range status_property_blacklist" class="limit_on_page" name="status_property_blacklist">
												<option value="" selected="">Trạng thái</option>
												<option value="1">Chờ kiểm tra</option>
												<option value="2">Yêu cầu cập nhật</option>
												<option value="3">Trả về</option>
												<option value="4">Xác nhận tài sản thật</option>
												<option value="200">Hủy</option>
											</select>
											<a class=" btn btn-outline-danger" id="reset" href="<?= base_url('property/requestBlacklist') ?>">Reset bộ lọc</a>
											<button type="button" class="btn btn-outline-success"
													id="search_blacklist">
												Tìm kiếm
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<div>
								<h3>Danh sách yêu cầu </h3>
								<h4 class="text-success">Hiển thị (<span
											class="text-danger"><?php echo !empty($total_rows) ? $total_rows : 0 ?></span>)
									kết quả</h4>
							</div>
							<hr>
							<table id="" class="table table-striped">
								<thead>
								<tr style="text-align: center">
									<th style="text-align: center">STT</th>
									<th style="text-align: center">Loại xe</th>
									<th style="text-align: center">Hãng xe</th>
									<th style="text-align: center">Người yêu cầu</th>
									<th style="text-align: center">Ngày tạo</th>
									<th style="text-align: center">Trạng thái</th>
									<th style="text-align: center">Chức năng</th>
								</tr>
								</thead>
								<tbody align="center">
								<?php if (!empty($property)) : ?>
									<?php foreach ($property as $key => $value) : ?>
										<tr>
											<td><?php echo ++$key ?></td>
											<td><?php echo $value->code == 'XM' ? '<i class="fa fa-motorcycle "></i>' : '<i class="fa fa-car"></i>' ?></td>
											<td><?php echo !empty($value->brand_name) ? $value->brand_name : '' ?></td>
											<td><?php echo !empty($value->created_by) ? $value->created_by : '' ?></td>
											<td><?php echo !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : '' ?></td>
											<?php if ($value->status == 1) : ?>
												<td>
													<span style="font-size: 14px" class="label label-success">Chờ kiểm tra</span>
												</td>
											<?php elseif ($value->status == 2) : ?>
												<td>
													<span style="font-size: 14px" class="label label-warning">Yêu cầu cập nhật</span>
												</td>
											<?php elseif ($value->status == 3) : ?>
												<td>
													<span style="font-size: 14px" class="label label-primary">Trả về</span>
												</td>
											<?php elseif ($value->status == 4) : ?>
												<td>
													<span style="font-size: 14px" class="label label-info">Xác nhận tài sản thật</span>
												</td>
											<?php else : ?>
												<td><span style="font-size: 14px" class="label label-danger">Hủy</span></td>
											<?php endif; ?>
											<td>
												<div class="dropdown">
													<button class="btn btn-primary dropdown-toggle" type="button"
															id="dropdownMenuButton" data-toggle="dropdown"
															aria-haspopup="true" aria-expanded="false">
														Chức năng <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" style="z-index: 99999">
														<li>
															<a class="dropdown-item"
															   href="<?= base_url('property/requestBlacklistDetail?id=' . $value->_id->{'$oid'}) ?>"
															   type="button"
															   data-id="<?= $value->_id->{'$oid'} ?>">
																Chi tiết
															</a>
														</li>
														<li>
															<a <?= (in_array($value->status, [2,3]) && !in_array('bo-phan-dinh-gia', $groupRoles)) ? '' : 'style="display:none"'?>
															   class="dropdown-item"
															   href="<?= base_url('property/requestBlacklistEdit?id=' . $value->_id->{'$oid'}) ?>"
															   type="button"
															   data-id="<?= $value->_id->{'$oid'} ?>">Cập nhật</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
										<tr>
											<td colspan="9" class="text-center">Không có dữ liệu</td>
										</tr>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
						<div>
							<nav class="text-right">
								<?php echo $pagination; ?>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	/*.btn-filter .dropdown-menu {*/
	/*	left: -230px;*/
	/*	width: auto;*/
	/*	padding: 10px;*/
	/*}*/

	.limit_on_page {
		width: 300px !important;
		min-height: 35px;
		margin-left: 8px; !important;
	}

	#reset {
		background: transparent;
		border: 1px solid #ff0b00;
		color: #d9534f;
		float: left;
		margin-top: 10px;
	}

	@media (max-width: 768px) {
		.btn_list_filter {
			display: block;
		}
		.btn-filter .dropdown-menu {
			left: 0px;
			width: auto;
			padding: 10px;
		}
	}

	.choose_branch {
		width: 300px !important;
		margin-left: 8px; !important;
		z-index: unset;
		min-height: 35px;
		padding-bottom: 5px;
	}
</style>

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/property/new/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/property/index.js"></script>
<script>
	$(document).ready(function () {
		$('.btn-filter button.btn-success').on('click', function () {
			$('.drop_select').toggle();
		});

		$('#search_blacklist').click(function () {
			let type = $("select[name='property_blacklist']").val()
			let hang_xe_blacklist = $("select[name='hang_xe_blacklist']").val()
			let status_blacklist = $("select[name='status_property_blacklist']").val()

			window.location.href = _url.base_url + "property/requestBlacklist?type=" + type + "&hang_xe=" + hang_xe_blacklist + "&status=" + status_blacklist
		})

		$('.delete_property').click(function (event){
			event.preventDefault();
			let id = $(this).attr("data-id-delete")
			console.log(id)
			let formData = new FormData();
			formData.append('id', id);
			if (confirm('Bạn chắc chắn muốn xóa tài sản này ?')) {
				$.ajax({
					url: _url.base_url + 'property/requestBlacklistDelete',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						if (data.code == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.msg);
							setTimeout(function () {
								window.location.href = _url.base_url + 'property/requestBlacklist';
							}, 2000);
						} else {
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
						}
					},
					error: function () {
						$(".theloading").hide();
						console.log('error')
						alert('error')
					}
				});
			}
		});

		$('#selectize_property_by_main').selectize({
			create: false,
			valueField: 'code',
			labelField: 'name',
			searchField: 'name',
			maxItems: 1,
			sortField: {
				field: 'name',
				direction: 'asc'
			}
		});

	});
</script>

