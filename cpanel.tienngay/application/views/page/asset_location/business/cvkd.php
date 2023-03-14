<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="container container-xt">
		<div class="container-top">
			<nav aria-label="breadcrumb">
				<a href="<?php echo base_url() ?>assetLocation/business"><h3 class="d-inline-block">Quản lý hợp đồng gắn
						thiết bị định vị</h3></a>
			</nav>
		</div>
		<div class="container-cart">
			<div class="content">
				<div class="content-cart">
					<p>Tổng thiết bị </p>
					<h5><?php echo $total_rows ?? 0 ?></h5>
				</div>
				<div class="content-cart">
					<p>Thiết bị đang hoạt động</p>
					<h5><?php echo $total_active ?? 0 ?></h5>
				</div>
				<div class="content-cart">
					<p>Thiết bị chưa thu hồi </p>
					<h5><?php echo $total_deactive ?? 0 ?></h5>
				</div>
			</div>
			<div class="content">
				<a href="<?php echo base_url('assetLocation/business') . '?alarm=1' ?>">
					<div class="content-cart-notify">
						<img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/power.svg") ?>" alt="">
						<p>Báo động cắt điện</p>
						<h5><?php echo $REMOVE ?? 0 ?></h5>
					</div>
				</a>
				<a href="<?php echo base_url('assetLocation/business') . '?alarm=5' ?>">
					<div class="content-cart-notify">
						<img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/radio.svg") ?>" alt="">
						<p>Báo động ngoài hàng rào</p>
						<h5><?php echo $FENCEOUT ?? 0 ?></h5>
					</div>
				</a>
				<a href="<?php echo base_url('assetLocation/business') . '?alarm=21' ?>">
					<div class="content-cart-notify">
						<img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/prohibit.svg") ?>" alt="">
						<p>Báo động va chạm</p>
						<h5><?php echo $CRASH ?? 0 ?></h5>
					</div>
				</a>
				<a href="<?php echo base_url('assetLocation/business') . '?alarm=2' ?>">
					<div class="content-cart-notify">
						<img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/battery.svg") ?>" alt="">
						<p>Báo động pin yếu</p>
						<h5><?php echo $LOWVOT ?? 0 ?></h5>
					</div>
				</a>
				<a href="<?php echo base_url('assetLocation/business') . '?alarm=17' ?>">
					<div class="content-cart-notify">
						<img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/rss.svg") ?>" alt="">
						<p>Báo động ngoại tuyến</p>
						<h5><?php echo $REMOVECONTINUOUSLY ?? 0 ?></h5>
					</div>
				</a>
			</div>
		</div>
		<div class="panel">
			<div class="form-content">
				<div class="form-text">
					<h5>Danh sách thiết bị</h5>
				</div>
				<div class="form-button">
					<button type="button" class="btn btn-outline-success" data-toggle="modal"
							data-target="#exampleModal">
						Tìm kiếm
						<img class="the-icon" src="<?php echo base_url("assets/imgs/ql_xnt/search.svg") ?>" alt="">
					</button>
					<!--					<button type="button" class="btn btn-outline-success">-->
					<!--						Xuất excel-->
					<!--						<img class="the-icon" src="-->
					<?php //echo base_url("assets/imgs/ql_xnt/excel.svg") ?><!--" alt="">-->
					<!--					</button>-->
					<!-- Modal -->
					<form method="get" action="<?php echo base_url('assetLocation/business') ?>">
						<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
							 aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="modal-item">
											<p>Thời gian </p>
											<div class="modal-content11">
												<input placeholder="Từ ngày" class="textbox-n" type="date" name="start"
													   value="<?php echo $_GET['start'] ?? '' ?>">
												<input placeholder="Đến ngày" class="textbox-n" type="date" name="end"
													   value="<?php echo $_GET['end'] ?? '' ?>">
											</div>
										</div>
										<div class="modal-item">
											<p>Mã seri </p>
											<input type="text" placeholder="Nhập seri" name="seri"
												   value="<?php echo $_GET['seri'] ?? '' ?>">
										</div>
										<div class="modal-item">
											<p>Số hợp đồng</p>
											<input type="text" placeholder="Nhập số hợp đồng"
												   name="code_contract_disbursement"
												   value="<?php echo $_GET['code_contract_disbursement'] ?? '' ?>">
										</div>
										<div class="modal-item">
											<p>Biển số xe </p>
											<input type="text" placeholder="Nhập biển số xe" name="license"
												   value="<?php echo $_GET['license'] ?? '' ?>">
										</div>
										<!--										<div class="modal-item">-->
										<!--											<p>Trạng thái </p>-->
										<!--											<select required>-->
										<!--												<option value="" disabled selected hidden>Chọn trạng thái</option>-->
										<!--												<option value="0">Open when powered (most valves do this)</option>-->
										<!--												<option value="1">Closed when powered, auto-opens when power is cut-->
										<!--												</option>-->
										<!--											</select>-->
										<!--										</div>-->
										<div class="modal-item">
											<p>Tên khách hàng </p>
											<input type="text" placeholder="Nhập tên khách hàng" name="customer_name"
												   value="<?php echo $_GET['customer_name'] ?? '' ?>">
										</div>
										<div class="modal-item">
											<input type="hidden" name="location"
												   value="<?php echo $_GET['location'] ?? '' ?>">
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
										</button>
										<button type="submit" class="btn btn-primary">Tìm kiếm
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="form-table table-responsive">
				<table class="table">
					<thead class="thead-light">
					<tr>
						<th scope="col" style="text-align: center">STT</th>
						<th scope="col" style="text-align: center">Ngày tháng</th>
						<th scope="col" style="text-align: center">Mã Seri</th>
						<th scope="col" style="text-align: center">Số HĐ đang SD</th>
						<th scope="col" style="text-align: center">Biển số xe</th>
						<th scope="col" style="text-align: center">Tên khách hàng</th>
						<th scope="col" style="text-align: center">Địa chỉ</th>
						<th scope="col" style="text-align: center">Ghi chú cuối</th>
						<th scope="col" style="text-align: center">Tình trạng</th>
						<th scope="col" style="text-align: center">Ảnh đính kèm</th>
						<th scope="col" style="text-align: center">Vị trí</th>
						<th scope="col" style="text-align: center"></th>
					</tr>
					</thead>
					<tbody class="tbody-line">
					<?php foreach ($contracts as $key => $contract) : ?>
						<tr style="text-align: center">
							<td><?php echo ++$key ?></td>
							<td><?php echo date('d/m/Y', $contract->disbursement_date) ?></td>
							<td>
								<a href="<?php echo base_url("assetLocation/detail?seri=") . $contract->loan_infor->device_asset_location->code ?>"
								   target="_blank"><?php echo $contract->loan_infor->device_asset_location->code ?? "" ?></a>
								<?php if ($contract->expire_date < time()) : ?>
									<br>
									<button class="btn btn-sm btn-danger recall-asset"
											data-code="<?php echo $contract->code_contract ?>">Thu hồi
									</button>
								<?php else: ?>
									<?php if ($contract->status == 19) : ?>
										<br>
										<button class="btn btn-sm btn-danger recall-asset"
												data-code="<?php echo $contract->code_contract ?>">Thu hồi
										</button>
									<?php endif; ?>
								<?php endif; ?>
							</td>
							<td><a href="<?php echo base_url("pawn/detail?id=") . $contract->_id ?>"
								   target="_blank"><?php echo $contract->code_contract_disbursement ?></a>
								<br>
								<button class="btn btn-sm btn-danger modal_update_address_contract" data-toggle="modal"
										data-target="#update_address_contract"
										data-code="<?php echo $contract->code_contract ?>"
										data-disbursement="<?php echo $contract->code_contract_disbursement ?>"
										data-name="<?php echo $contract->customer_infor->customer_name ?>">
									Cập nhật địa chỉ
								</button>
							</td>
							<td><?php echo $contract->property_infor[2]->value ?? "" ?></td>
							<td><?php echo $contract->customer_infor->customer_name ?? "" ?></td>
							<td>
								<?php echo $contract->address->current_stay . '<br>' .
										$contract->address->ward_name . '<br>' .
										$contract->address->district_name . '<br>' .
										$contract->address->province_name
								?>
							</td>
							<td>
								<?php echo !empty($contract->note) ? wordwrap($contract->note, 20, "<br>\n") : ''?>
							</td>
							<td>Đang hoạt động</td>
							<td><a data-fancybox="gallery"
								   href="<?php echo $contract->loan_infor->device_asset_location->imgInpDevice_show ?? "" ?>"
								   data-caption="First image">
									Xem ảnh
								</a> <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/eys.svg") ?>"
										  alt=""></td>
							<td>
								<button class="btn btn-success show-location" data-toggle="modal"
										data-target="#show-location"
										data-imei="<?php echo $contract->loan_infor->device_asset_location->code ?>"
										data-code="<?php echo $contract->code_contract_disbursement ?>"
								>Xem vị trí
								</button>
							</td>
							<td>
								<button class="btn btn-info note-contract" data-toggle="modal"
										data-target="#note-contract"
										data-code="<?php echo $contract->code_contract ?>"
										data-disbursement="<?php echo $contract->code_contract_disbursement ?>"
										data-name="<?php echo $contract->customer_infor->customer_name ?>"
								>Ghi chú
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<div class="paginate" style="padding-left: 10px;">
					<?php echo $pagination; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="show-location" tabindex="-1" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title title_location">Vị trí</h5>
			</div>
			<div class="modal-body body_location">

			</div>
		</div>
	</div>
</div>
<?php $this->load->view('page/asset_location/business/modal_update_address'); ?>
<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.breadcrumb {
		margin: 0px;
		padding: 0px;
	}

	.container-xt {
		width: 100%;
		display: flex;
		flex-direction: column;
		gap: 24px;

	}

	.container-top h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.container-cart {
		width: 100%;
		display: flex;
		flex-direction: column;
		gap: 24px
	}

	.content {
		display: flex;
		gap: 16px;
	}

	.content p {
		font-style: normal;
		font-weight: 600;
		font-size: 16px;
		line-height: 20px;
		color: #676767;
	}

	.content h5 {
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #1D9752;

	}

	.content-cart {
		width: 307.4px;
		height: 80px;
		padding-top: 16px;
		padding-left: 16px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.container-cart h6 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.content-cart-notify {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 16px 24px;
		gap: 8px;
		width: 307.4px;
		height: 64px;
		background: linear-gradient(0deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), #F4CDCD;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 4px;
	}

	.content-cart-notify p {
		margin: 0;
	}

	.content-cart-notify h5 {
		color: #3B3B3B;
	}

	.thead-light {
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
	}

	.tbody-line {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: rgba(103, 103, 103, 1);
	}

	/* ------------------- */
	.container-form {
		width: 100%;
		height: 592px;
		background: #FFFFFF;
		border: 1px solid #EBEBEB;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.form-content {
		width: 100%;
		display: flex;
		justify-content: space-between;
		padding: 20px 16px;
	}

	.form-text h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.thead-light {
		background-color: #E8F4ED;
	}

	/* ------modal-------- */
	.modal-body {
		display: flex;
		flex-direction: column;
		gap: 20px;
	}

	.modal-header h4 {
		text-align: center;
	}

	.modal-item input {
		padding: 16px;
		gap: 8px;
		width: 100%;
		height: 30px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.modal-item select {
		gap: 8px;
		width: 100%;
		height: 35px;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.modal-content11 {
		display: flex;
		gap: 24px;
	}

	@media only screen and (max-width: 1440px) {
		.content p {
			font-size: 12px;
		}
	}
</style>
<script>
	$(document).ready(function () {
		$('.show-location').click(function () {
			let imei = $(this).attr('data-imei');
			let code = $(this).attr('data-code');
			$.ajax({
				url: _url.base_url + 'assetLocation/location?imei=' + imei,
				type: "GET",
				dataType: 'json',
				success: function (data) {
					if (data.status == 200) {
						$('.title_location').text('')
						$('.body_location').text('')
						$('.title_location').html('Vị trí thiết bị ' + '<span class="text-danger">' + imei + ' - ' + code + '</span>')
						$('.body_location').html('<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDU6vwuTA_eC2NKb0IuDJpa2XmrypkTSvA&q=' + data.data.lat + ',' + data.data.lng + '" width="570" height="500" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>')
					} else {
						alert('Không lấy được thông tin')
					}
				},
				error: function (data) {
					alert('Không lấy được thông tin')
				}
			});
		})

		$('.recall-asset').click(function () {
			let code = $(this).attr('data-code')
			if (confirm('Ban có chắc chắn thu hồi thiết bị định vị cho hợp đồng ' + code)) {
				$.ajax({
					url: _url.base_url + 'assetLocation/recall?code_contract=' + code,
					type: "GET",
					dataType: 'json',
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						if (data.status == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.message);
							setTimeout(function () {
								window.location.reload();
							}, 1000);
						} else {
							$('#errorModal').modal('show');
							$('.msg_error').text(data.message);
						}
					},
					error: function (data) {
						$(".theloading").hide();
						$('#errorModal').modal('show');
						$('.').text(data.message);
					}
				});
			}
		})

		$('.modal_update_address_contract').click(function () {
			let code = $(this).attr('data-code');
			let disbursement = $(this).attr('data-disbursement');
			let name = $(this).attr('data-name');
			$("input[name='customer_name']").val('')
			$("input[name='code_contract_disbursement']").val('')
			$("input[name='code_contract']").val('')
			$("input[name='customer_name']").val(name)
			$("input[name='code_contract_disbursement']").val(disbursement)
			$("input[name='code_contract']").val(code)
		})

		$('.note-contract').click(function () {
			let code = $(this).attr('data-code');
			let disbursement = $(this).attr('data-disbursement');
			let name = $(this).attr('data-name');
			$("input[name='customer_name']").val('')
			$("input[name='code_contract_disbursement']").val('')
			$("input[name='code_contract']").val('')
			$("input[name='customer_name']").val(name)
			$("input[name='code_contract_disbursement']").val(disbursement)
			$("input[name='code_contract']").val(code)
		})
	})
</script>
