<!-- page content -->
<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<div class="right_col" role="main">

	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Quản lý hoa hồng
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Quản lý
								phí</a>
						</small>
					</h3>
				</div>

			</div>
		</div>
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-12">
					<div class="x_panel">
						<div class="x_content">
							<table id="datatable-button" class="table table-striped" >
								<thead >
								<tr >
									<th style="text-align: center">#</th>
									<th style="text-align: center">Tên gói hoa hồng</th>
									<th style="text-align: center">Từ ngày</th>
									<th style="text-align: center">Đến ngày</th>
									<th style="text-align: center">Ngày cập nhật</th>
									<th style="text-align: center">Người cập nhật</th>
									<th style="text-align: center" class="text-right">Trạng thái</th>
									<th style="text-align: center" class="text-right">Chi tiết</th>
								</tr>
								</thead>
								<tbody align="center">
								<tr>
									<td>1</td>
									<td>Biểu phí chuẩn</td>
									<td>06/02/2020</td>
									<td></td>
									<td>18/12/2020</td>
									<td>superadmin@tienngay.vn</td>
									<td>
										<center><input disabled class='aiz_switchery' type="checkbox" data-set='status'
													   data-id="<?php echo $item->_id->{'$oid'} ?>"
													   data-main="<?= (!empty($item->main)) ? $item->main : ''; ?>"
													<?php $status = !empty($item->status) ? $item->status : "";
													echo ($status == 'active') ? 'checked' : ''; ?>
											/></center>
									</td>
									<td class="sorting_1">

										<button class="btn btn-primary text-right"
												data-toggle="modal"
												data-target="#modal_update_5e3a3232d6612b35311f06e8">
											Xem chi tiết
										</button>
										<div id="modal_update_5e3a3232d6612b35311f06e8" class="modal fade"
											 role="dialog">
											<div class="modal-dialog modal-lg">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">×
														</button>
														<h4 class="modal-title">Chi tiết hoa hồng</h4>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-xs-3">
																<div class="form-group">
																	<div class="input-group">
																		<div class="input-group-addon">From :</div>
																		<input type="date" id="from"
																			   class="form-control" value="2020-02-06">
																	</div>
																</div>
															</div>
															<div class="col-xs-3">
																<div class="form-group">
																	<div class="input-group">
																		<div class="input-group-addon">To :</div>
																		<input type="date" id="to" class="form-control"
																			   value="1970-01-01">
																	</div>
																</div>
															</div>
															<div class="col-xs-12">
																<div role="tabpanel" name="div_type_30"
																	 class="tab-pane fade active in"
																	 id="day_30_5e3a3232d6612b35311f06e8"
																	 aria-labelledby="home-tab">

																	<div class="row">
																		<div name="div_detail" data-type="CC"
																			 class="col-xs-12 col-md-12"
																			 style="border-right: 1px solid #ccc;">
																			<h4>Bảo hiểm : </h4>
																		</div>
																		<div name="div_detail" data-type="CC"
																			 class="col-xs-12 col-md-6"
																			 style="border-right: 1px solid #ccc;">
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Lãi suất phải thu của
																						người vay :
																					</div>
																					<input type="text"
																						   disabled=""
																						   value="1.5"
																						   name="percent_interest_customer"
																						   data-name="percent_interest_customer"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Phí tư vấn quản lý :
																					</div>
																					<input type="text"
																						   value="1.5"
																						   name="percent_advisory"
																						   data-name="percent_advisory"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Phí thẩm định và lưu trữ
																						tài sản đảm bảo :
																					</div>
																					<input type="text"
																						   value="1.5"
																						   name="percent_expertise"
																						   data-name="percent_expertise"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						% Phí quản lý số tiền
																						vay chậm trả :
																					</div>
																					<input type="text" value="2"
																						   name="penalty_percent"
																						   data-name="penalty_percent"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Số tiền quản lý số tiền
																						vay chậm trả :
																					</div>
																					<input type="text"
																						   value="200000"
																						   name="penalty_amount"
																						   data-name="penalty_amount"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Phí tư vấn gia hạn số
																						tiền vay :
																					</div>
																					<input type="text"
																						   value="300000"
																						   name="extend"
																						   data-name="extend"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						KH trả trước 1/3 thời
																						hạn vay :
																					</div>
																					<input type="text" value="3"
																						   name="percent_prepay_phase_1"
																						   data-name="percent_prepay_phase_1"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						KH trả trước 2/3 thời
																						hạn vay :
																					</div>
																					<input type="text" value="2"
																						   name="percent_prepay_phase_2"
																						   data-name="percent_prepay_phase_2"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Khách hàng trả trước
																						trong các trường hợp còn
																						lại :
																					</div>
																					<input type="text" value="1"
																						   name="percent_prepay_phase_3"
																						   data-name="percent_prepay_phase_3"
																						   class="form-control number">
																				</div>
																			</div>
																		</div>
																		<div name="div_detail" data-type="CC"
																			 class="col-xs-12 col-md-6"
																			 style="border-right: 1px solid #ccc;">
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Lãi suất phải thu của
																						người vay :
																					</div>
																					<input type="text"
																						   disabled=""
																						   value="1.5"
																						   name="percent_interest_customer"
																						   data-name="percent_interest_customer"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Phí tư vấn quản lý :
																					</div>
																					<input type="text"
																						   value="1.5"
																						   name="percent_advisory"
																						   data-name="percent_advisory"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Phí thẩm định và lưu trữ
																						tài sản đảm bảo :
																					</div>
																					<input type="text"
																						   value="1.5"
																						   name="percent_expertise"
																						   data-name="percent_expertise"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						% Phí quản lý số tiền
																						vay chậm trả :
																					</div>
																					<input type="text" value="2"
																						   name="penalty_percent"
																						   data-name="penalty_percent"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Số tiền quản lý số tiền
																						vay chậm trả :
																					</div>
																					<input type="text"
																						   value="200000"
																						   name="penalty_amount"
																						   data-name="penalty_amount"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Phí tư vấn gia hạn số
																						tiền vay :
																					</div>
																					<input type="text"
																						   value="300000"
																						   name="extend"
																						   data-name="extend"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						KH trả trước 1/3 thời
																						hạn vay :
																					</div>
																					<input type="text" value="3"
																						   name="percent_prepay_phase_1"
																						   data-name="percent_prepay_phase_1"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						KH trả trước 2/3 thời
																						hạn vay :
																					</div>
																					<input type="text" value="2"
																						   name="percent_prepay_phase_2"
																						   data-name="percent_prepay_phase_2"
																						   class="form-control number">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-addon">
																						Khách hàng trả trước
																						trong các trường hợp còn
																						lại :
																					</div>
																					<input type="text" value="1"
																						   name="percent_prepay_phase_3"
																						   data-name="percent_prepay_phase_3"
																						   class="form-control number">
																				</div>
																			</div>
																		</div>

																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default"
																data-dismiss="modal">Đóng
														</button>
													</div>
												</div>
											</div>
										</div>
									</td>

								</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<?php
$dataCreate['columnFeeLoansCreate'] = $columnFeeLoans;
//    $this->load->view("web/feeloan_new/popup_create.php", $dataCreate);
//$this->load->view("web/feeloan_new/popup_update.php", $data);
?>
<script src="<?= base_url("assets") ?>/js/feeloan_new/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/activeit.min.js"></script>

<style type="text/css">
	.w-25 {
		width: 8% !important;
	}
</style>
<script>
	$(document).ready(function () {
		set_switchery();

		function set_switchery() {
			$(".aiz_switchery").each(function () {
				new Switchery($(this).get(0), {
					color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'
				});
				var changeCheckbox = $(this).get(0);
				var id = $(this).data('id');
				var main = $(this).data('main');

				changeCheckbox.onchange = function () {
					$.ajax({
						url: _url.base_url + 'feeLoanNew/doUpdateStatus?id=' + id + '&status=' + changeCheckbox.checked + '&main=' + main,
						success: function (result) {
							console.log(result.res);
							if (result.res) {
								if (changeCheckbox.checked == true) {
									$.activeitNoty({
										type: 'success',
										icon: 'fa fa-check',
										message: result.message,
										container: 'floating',
										timer: 3000
									});

								} else {
									$.activeitNoty({
										type: 'danger',
										icon: 'fa fa-check',
										message: result.message,
										container: 'floating',
										timer: 3000
									});

								}
							} else {
								alert(result.message);
								window.location.reload();
							}
						}
					});
				};
			});
		}
	});
</script>
