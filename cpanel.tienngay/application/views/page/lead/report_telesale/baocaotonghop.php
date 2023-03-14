<div class="right_col" role="main">

	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	?>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>BÁO CÁO TỔNG HỢP</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2></h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">

							<button style="background-color: #5A738E" class="btn btn-info show-hide-total-top-ten"
									data-toggle="modal"
									data-target="#addnewModal_KPI" id="kpi">
								KPI giải ngân trong tháng
							</button>


							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('report_telesale/search_baocaotonghop') ?>" method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Từ:</label>
													<input type="datetime-local" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Đến:</label>
													<input type="datetime-local" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">
												</div>
											</div>
										</div>
									</li>

									<li class="text-right">
										<button class="btn btn-info" type="submit">
											<i class="fa fa-search" aria-hidden="true"></i>
											Tìm Kiếm
										</button>
									</li>

								</ul>
							</form>

						</div>

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center" colspan="3">BÁO CÁO PHÒNG CSKH</th>
							</tr>
							</thead>
							<tbody>
							<tr style="background-color: rgb(235 235 235)">
								<th style="text-align: center">1</th>
								<th style="text-align: center" colspan="2">LEAD VỀ</th>
								<th style="text-align: center"><?= !empty($lead_ve) ? number_format($lead_ve) : 0 ?></th>
							</tr>
							<tr style="background-color: rgb(235 235 235)">
								<th style="text-align: center">2</th>
								<th style="text-align: center" colspan="2">TLS XL</th>
								<th style="text-align: center"><?= !empty($tls_xl) ? number_format($tls_xl) : 0 ?></th>
							</tr>
							<tr style="background-color: #ffbbbb; color: red">
								<th style="text-align: center">3</th>
								<th style="text-align: center" colspan="2">TLS XL / LEAD VỀ</th>
								<th style="text-align: center">
									<?php
									if (!empty($tls_xl) && !empty($lead_ve) && $lead_ve != 0) {
										echo number_format((($tls_xl / $lead_ve) * 100), 2) . "%";
									} else {
										echo 0 . "%";
									}
									?>
								</th>
							</tr>
							<?php $count = 0;
							$count_LEAD_QLF = 0;
							foreach ($result as $value) {
								$count_LEAD_QLF += $value;
							}
							?>
							<tr style="background-color: rgb(235 235 235)">
								<th style="text-align: center">4</th>
								<th style=" text-align: center" colspan="2">LEAD QLF</th>
								<th style=" text-align: center"><?= number_format($count_LEAD_QLF) ?></th>
							</tr>

							<?php if (!empty($result)): ?>
								<?php foreach ($result as $key => $value): ?>

									<tr>
										<td style="text-align: center">4.1.<?= ++$count ?></td>
										<td style=" text-align: center" colspan="2"><?php echo $key ?></td>
										<td style=" text-align: center"><?= !empty($value) ? number_format($value) : 0 ?></td>
									</tr>

								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #ffbbbb; color: red">
								<th style="text-align: center">4.2</th>
								<th style="text-align: center" colspan="2">LEAD QLF / LEAD VỀ</th>
								<th style="text-align: center">
									<?php
									if (!empty($count_LEAD_QLF) && !empty($lead_ve) && $lead_ve != 0) {
										echo number_format((($count_LEAD_QLF / $lead_ve) * 100), 2) . "%";
									} else {
										echo 0 . "%";
									}
									?>
								</th>
							</tr>

							<?php $count1 = 0;
							$count_LEAD_GN = 0;
							if (!empty($data_gn)){
								foreach ($data_gn as $value1) {
									$count_LEAD_GN += $value1;
								}
							}

							?>

							<tr style="background-color: rgb(235 235 235)">
								<th style="text-align: center">5</th>
								<th style=" text-align: center" colspan="2">LOAN</th>
								<th style=" text-align: center"><?= number_format($count_LEAD_GN) ?></th>
							</tr>
							<?php if (!empty($data_gn)): ?>
								<?php foreach ($data_gn as $key1 => $value1): ?>

									<tr>
										<td style="text-align: center">5.<?= ++$count1 ?></td>
										<td style=" text-align: center" colspan="2"><?php echo $key1 ?></td>
										<td style=" text-align: center"><?= !empty($value1) ? number_format($value1) : 0 ?></td>
									</tr>

								<?php endforeach; ?>
							<?php endif; ?>


							<tr style="background-color: #ffbbbb; color: red">
								<th style="text-align: center">5.<?= ++$count1 ?></th>
								<th style="text-align: center" colspan="2">LOAN / LEAD QLF</th>
								<th style="text-align: center">
									<?php
									if (!empty($count_LEAD_GN) && !empty($count_LEAD_QLF) && $count_LEAD_QLF != 0) {
										echo number_format((($count_LEAD_GN / $count_LEAD_QLF) * 100), 2) . "%";
									} else {
										echo 0 . "%";
									}
									?>
								</th>
							</tr>

							<?php
							$arr_data_gn = [];
							$arr_result = [];
							if (!empty($data_gn)){
								foreach ($data_gn as $value) {
									array_push($arr_data_gn, $value);
								}
							}
							if (!empty($result)){
								foreach ($result as $value) {
									array_push($arr_result, $value);
								}
							}
							$count4 = 0;
							?>

							<?php if (!empty($title)): ?>
							<?php foreach ($title as $key3 => $item): ?>
								<tr>
									<td style="text-align: center">5.<?= $count1 ?>.<?= ++$key3 ?></td>
									<td style=" text-align: center" colspan="2"><?= $item ?></td>
									<td style=" text-align: center">
										<?php
										if (!empty($arr_data_gn[$count4]) && !empty($arr_result[$count4]) && $arr_result[$count4] != 0) {
											echo number_format((($arr_data_gn[$count4] / $arr_result[$count4]) * 100), 2) . "%";
										} else {
											echo 0 . "%";
										}
										?>
									</td>
								</tr>
								<?php
								$count4++;
							endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #ffbbbb; color: red">
								<th style="text-align: center">6</th>
								<th style="text-align: center" colspan="2">LOAN / LEAD VỀ</th>
								<th style="text-align: center">
									<?php
									if (!empty($count_LEAD_GN) && !empty($lead_ve) && $lead_ve != 0) {
										echo number_format((($count_LEAD_GN / $lead_ve) * 100), 2) . "%";
									} else {
										echo 0 . "%";
									}
									?>
								</th>
							</tr>


							<?php
							$total = 0;
							if (!empty($data_amount)){
								foreach ($data_amount as $value) {
									$total += $value;
								}
							}
							?>
							<tr style="background-color: rgb(235 235 235)">
								<th style="text-align: center">7</th>
								<th style=" text-align: center" colspan="2">VOLUME</th>
								<th style=" text-align: center"><?= number_format($total) ?></th>
							</tr>
							<?php if (!empty($data_amount)): ?>
								<?php $count3 = 0; ?>
								<?php foreach ($data_amount as $key3 => $value3): ?>

									<tr>
										<td style="text-align: center">7.<?= ++$count3 ?></td>
										<td style=" text-align: center" colspan="2"><?php echo $key3 ?></td>
										<td style=" text-align: center"><?= !empty($value3) ? number_format($value3) : 0 ?></td>
									</tr>

								<?php endforeach; ?>
							<?php endif; ?>

							<!--							KPI-->
							<?php
							$total_kpi = 0;
							if (!empty($kpis)){
								foreach ($kpis as $item){
									$total_kpi += $item;
								}
							}
							?>
							<tr style="background-color: #ffbbbb; color: red">
								<th style="text-align: center">8</th>
								<th style="text-align: center" >KPI</th>
								<th style="text-align: center" ><?= number_format($total_kpi) ?></th>
								<th style="text-align: center">
									<?php
									if (!empty($total) && !empty($total_kpi) && $total_kpi != 0) {
										echo number_format((($total / $total_kpi) * 100), 2) . "%";
									} else {
										echo 0 . "%";
									}
									?>
								</th>
							</tr>

							<?php
							$arr_data_amount = [];
							if (!empty($data_amount)){
								foreach ($data_amount as $amount){
									array_push($arr_data_amount, $amount);
								}
							}

							$count5 = 0;
							?>
							<?php if (!empty($title)): ?>
							<?php foreach ($title as $key4 => $item): ?>
								<tr>
									<td style="text-align: center">8.<?= ++$key4 ?></td>
									<td style=" text-align: center"><?= $item ?></td>
									<td style=" text-align: center"><?= number_format($kpis[$count5]) ?></td>
									<td style=" text-align: center">
										<?php
										if (!empty($arr_data_amount[$count5]) && !empty($kpis[$count5]) && $kpis[$count5] != 0) {
											echo number_format((($arr_data_amount[$count5] / $kpis[$count5]) * 100), 2) . "%";
										} else {
											echo 0 . "%";
										}
										?>
									</td>
								</tr>
								<?php
								$count5++;
							endforeach; ?>
							<?php endif; ?>
							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<!--Modal-->
<div id="addnewModal_KPI" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title" style="text-align: center">THÊM KPI</h3>
			</div>

			<div class="modal-body">

				<?php if (!empty($title)): ?>
					<?php foreach ($title as $key10 => $titt): ?>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12"><?= $titt ?> :</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" class="form-control" value="0" data-key="<?= $key10 ?>" id="<?= $key10 ?>">
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" value="<?php echo count($title) ?>" id="format">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<script>

	let count = $("#format").val();
	for (let i = 0; i < count; i++) {
		$("#" + i).on('input', function (e) {
			$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
		}).on('keypress', function (e) {
			if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
		}).on('paste', function (e) {
			var cb = e.originalEvent.clipboardData || window.clipboardData;
			if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
		});
	}


	function formatCurrency(number) {
		var n = number.split('').reverse().join("");
		var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
		return n2.split('').reverse().join('');
	}


	$("#submit").click(function (event) {
		event.preventDefault();

		var count = $("#format").val();

		var amount_money = {};

		if (count > 0) {
			for (let i= 0; i < count; i++){
				amount_money[i] = $('#'+i).val();
			}
		}
		$.ajax({
			url: _url.base_url + '/report_telesale/create_kpis',
			method: "POST",
			data: {
				amount_money: amount_money,

			},

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.data.status == 200) {
					console.log("xxx");
					$("#successModal").modal("show");
					$(".msg_success").text('Thêm mới thành công');
					sessionStorage.clear()
					setTimeout(function () {
						window.location.href = _url.base_url + '/report_telesale/baocaotonghop';
					}, 3000);
				}
			},
			error: function (data) {
				console.log("xxx");
				$(".theloading").hide();
			}
		});
	});

	$('#kpi').click(function (){
		$.ajax({
			url: _url.base_url + '/report_telesale/list_kpi',
			method: "POST",

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data)
				$(".theloading").hide();

				let count = $("#format").val();
				if (data.data != null){
					for (let i =0;i< count; i++){
						$("#" + i).val(numeral(data.data[i]).format('0,0'));
					}
				}


			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});

	})

</script>

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>









