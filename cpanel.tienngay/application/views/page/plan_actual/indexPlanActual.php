<?php
$month = !empty($_GET['month']) ? $_GET['month'] : "";
?>
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
					<div class="row">
						<ul class="nav nav-tabs" style="margin-bottom: 20px">
							<li role="presentation" class="active"><a href="<?php echo base_url() ?>plan_actual/indexPlanActual">CF</a></li>
							<li role="presentation"><a href="<?php echo base_url() ?>plan_actual/indexBankBalance">Số dư
									các TK NH</a></li>
							<li role="presentation"><a href="<?php echo base_url() ?>plan_actual/indexFollowVPS">Theo
									dõi VPS</a></li>
							<li role="presentation"><a href="<?php echo base_url() ?>plan_actual/indexFollowDebt">Quản lý hợp đồng vay</a></li>
							<li role="presentation"><a href="<?php echo base_url() ?>plan_actual/indexInvestor">Nhà đầu tư</a></li>
							<li role="presentation"><a href="<?php echo base_url() ?>plan_actual/indexDisbursement">Giải ngân Actual</a></li>
							<li role="presentation"><a href="<?php echo base_url() ?>plan_actual/indexCpWork">CP hoạt động</a></li>
							<li role="presentation"><a href="<?php echo base_url() ?>plan_actual/indexHistorical">Historical Data CP</a></li>
						</ul>
					</div>

					<style>
						@media screen and (max-width: 1440px) {
							.flex-search {
								display: flex;
								gap: 1%;
								padding-left: 10px;
							}
						}
					</style>

					<form action="<?php echo base_url('plan_actual/indexPlanActual') ?>" method="get" style="width: 100%;">
						<div class="row flex-search">
							<div class="col-lg-3 col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Tháng</span>
									<input type="month" name="month" class="form-control" value="<?= isset($_GET['month']) ? $_GET['month'] : date('Y-m') ?>">
								</div>
							</div>

							<div class="col-lg-2 col-md-2" >
								<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																					   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
								</button>
							</div>
							<div class="col-lg-2 col-ms-2" >
								<button type="button" class="btn btn-primary w-100" data-toggle="modal"
										data-target="#addnewModal_budget"><i class="fa fa-search"
																					   aria-hidden="true"></i> Set tỉ lệ NĐT nạp tiền
								</button>
							</div>
							<div class="col-lg-2 col-md-2" >
								<a style="background-color: #18d102;" target="_blank"
								   href="<?= base_url() ?>excel/excel_plan_actual?month=<?= $month ?>"
								   class="btn btn-primary w-100"><i class="fa fa-file-excel-o"
																	aria-hidden="true"></i>&nbsp; Xuất Excel</a>
							</div>
							<div class="col-lg-2 col-md-2" >
								<a style="background-color: #18d102;" id="update_plan_actual"
								   class="btn btn-primary w-100"><i class="fa fa-spinner" aria-hidden="true"></i>&nbsp;Cập nhật</a>
							</div>
						</div>
					</form>


				</div>
				<style>
					.outer {
						overflow-y: auto;
						height: 80vh;
						padding: 0px !important;
					}

					.outer {
						width: 100%;
						-layout: fixed;
					}

					.outer thead {
						text-align: left;
						top: 0;
						position: sticky;
						z-index: 2;
					}

					.icx {
						position: sticky;
						left: 0px;
						z-index: 1;
						background-color: #ffffff;
					}

					.iic {
						left: 58.2px;
						position: sticky;
						z-index: 1;
						background-color: #ffffff;
					}

					@media screen and (max-width:1440px) {
						.iic {
							left: 57px;
							position: sticky;
							z-index: 1000;
							background-color: #ffffff;
						}
					}
				</style>
				<div class="table-responsive-md col-xs-12 col-md-12 outer" style="overflow-x: scroll">
					<table class="table table-bordered m-table table-hover table-calendar table-report ">

						<thead style="position: sticky; position: -webkit-sticky; top: 0">
							<tr style="color: white">
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Nội dung</th>
								<?php if (!empty($getDayOfMonth)) : ?>
									<?php foreach ($getDayOfMonth as $value) : ?>
										<th style="text-align: center"><?= $value ?></th>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<tr style="background-color: #037734; color: white">
								<td style="text-align: center">Phần 1</td>
								<td colspan="32">BUDGET</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">A/</td>
								<td class="iic">DÒNG TIỀN L1 - BUDGET:</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">I/</td>
								<td class="iic">Tổng số dư các TK:</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Tổng tiền tại các TK NH</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_tien_tai_khoan_ngan_hang) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Tổng tiền gốc VPS</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_tien_goc_vps) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.1</td>
								<td class="iic">Tổng tiền gốc và lãi VPS đến hạn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->goc_lai_vps_den_han) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.2</td>
								<td class="iic">Tổng tiền gốc VPS chưa đến hạn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->goc_lai_vps_chua_den_han) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.3</td>
								<td class="iic">Tổng tiền gốc VPS chưa đến hạn dự kiến đáo</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->tong_tien_vps_chua_den_han_du_kien_dao) ? $value->tong_tien_vps_chua_den_han_du_kien_dao : 0 ?>"> <?= !empty($value->tong_tien_vps_chua_den_han_du_kien_dao) ? number_format($value->tong_tien_vps_chua_den_han_du_kien_dao) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->tong_tien_vps_chua_den_han_du_kien_dao) ? $value->tong_tien_vps_chua_den_han_du_kien_dao : 0 ?>' id='tong_tien_vps_chua_den_han_du_kien_dao-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->tong_tien_vps_chua_den_han_du_kien_dao) ? $value->tong_tien_vps_chua_den_han_du_kien_dao : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.4</td>
								<td class="iic">Tổng tiền gốc VPS có thể sử dụng</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->tong_goc_VPS_co_the_su_dung) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Tổng tiền có thể sử dụng L1</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_tien_co_the_su_dung) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">II/</td>
								<td class="iic">Dòng tiền vào</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Hợp đồng vay Nhóm 1</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->total_plan) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Gốc</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->goc) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Lãi</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->lai) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Phí tư vấn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->phi_tu_van) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Phí thẩm định</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->phi_tham_dinh) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Thu L2</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->thu_l2) ? $value->thu_l2 : 0 ?>"> <?= !empty($value->thu_l2) ? number_format($value->thu_l2) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->thu_l2) ? $value->thu_l2 : 0 ?>' id='thu_l2-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->thu_l2) ? $value->thu_l2 : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Thu khác</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->thu_khac) ? $value->thu_khac : 0 ?>"> <?= !empty($value->thu_khac) ? number_format($value->thu_khac) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->thu_khac) ? $value->thu_khac : 0 ?>' id='thu_khac-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->thu_khac) ? $value->thu_khac : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng dòng tiền vào L1</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->total_dong_tien_l1) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">III/</td>
								<td class="iic">Dòng tiền ra</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">CP hoạt động</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->cp_hoat_dong) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Thanh toán theo các đợt</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->thanh_toan_theo_cac_dot) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Thanh toán ngoại lệ</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->thanh_toan_ngoai_le) ? $value->thanh_toan_ngoai_le : 0 ?>"> <?= !empty($value->thanh_toan_ngoai_le) ? number_format($value->thanh_toan_ngoai_le) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->thanh_toan_ngoai_le) ? $value->thanh_toan_ngoai_le : 0 ?>' id='thanh_toan_ngoai_le-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->thanh_toan_ngoai_le) ? $value->thanh_toan_ngoai_le : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Thanh toán về L2</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->thanh_toan_ve_l2) ? $value->thanh_toan_ve_l2 : 0 ?>"> <?= !empty($value->thanh_toan_ve_l2) ? number_format($value->thanh_toan_ve_l2) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->thanh_toan_ve_l2) ? $value->thanh_toan_ve_l2 : 0 ?>' id='thanh_toan_ve_l2-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->thanh_toan_ve_l2) ? $value->thanh_toan_ve_l2 : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Các khoản chi khác</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->cac_khoan_chi_khac) ? $value->cac_khoan_chi_khac : 0 ?>"> <?= !empty($value->cac_khoan_chi_khac) ? number_format($value->cac_khoan_chi_khac) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->cac_khoan_chi_khac) ? $value->cac_khoan_chi_khac : 0 ?>' id='cac_khoan_chi_khac-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->cac_khoan_chi_khac) ? $value->cac_khoan_chi_khac : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng dòng tiền ra</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_dong_tien_ra) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">IV/</td>
								<td class="iic">Net CF Budget - L1</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->net_cf_budget_l1) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">V/</td>
								<td class="iic">DƯ TIỀN CẦN TẠI TK NH L1</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->du_tien_can_tai_tk_nh_l1) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">B/</td>
								<td class="iic">DÒNG TIỀN L2:</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">I/</td>
								<td class="iic">Số dư các TK L2:</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Ví NL TMQ</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_nl_tmq) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Ví Vimo VFC</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_vimo_vfc) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Ví Vimo Vay Mượn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_vimo_vaymuon) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">4</td>
								<td class="iic">Ví VNDT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_vndt) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">5</td>
								<td class="iic">TK Tech TMQ</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_tech_tmq) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6</td>
								<td class="iic">TK VPS</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->tong_tien_goc_vps) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6.1</td>
								<td class="iic">Tổng tiền VPS đến hạn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->goc_lai_vps_den_han) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6.2</td>
								<td class="iic">Tổng tiền VPS chưa đến hạn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->goc_lai_vps_chua_den_han) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6.3</td>
								<td class="iic">Tổng tiền VPS chưa đến hạn dự kiến đáo</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->tong_tien_vps_chua_den_han_du_kien_dao_1) ? $value->tong_tien_vps_chua_den_han_du_kien_dao_1 : 0 ?>"> <?= !empty($value->tong_tien_vps_chua_den_han_du_kien_dao_1) ? number_format($value->tong_tien_vps_chua_den_han_du_kien_dao_1) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->tong_tien_vps_chua_den_han_du_kien_dao_1) ? $value->tong_tien_vps_chua_den_han_du_kien_dao_1 : 0 ?>' id='tong_tien_vps_chua_den_han_du_kien_dao_1-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->tong_tien_vps_chua_den_han_du_kien_dao_1) ? $value->tong_tien_vps_chua_den_han_du_kien_dao_1 : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6.4</td>
								<td class="iic">Tổng tiền VPS có thể sử dụng</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->tong_tien_vps_co_the_su_dung) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>

							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng tiền có thể sử dụng L2:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_tien_co_the_su_dung_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">II/</td>
								<td class="iic">DÒNG TIỀN VÀO:</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Nhà đầu tư nạp tiền:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->nha_dau_tu_nap_tien) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1.1</td>
								<td class="iic">NĐT hợp tác</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->budget_nap_ndt_hop_tac) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>

							</tr>
							<tr>
								<td class="icx" style="text-align: center">1.2</td>
								<td class="iic">NĐT App ví NL</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->budget_nap_app_vi_nl) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1.3</td>
								<td class="iic">NĐT App ví Vimo</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->budget_nap_app_vi_vimo) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>

							</tr>
							<tr>
								<td class="icx" style="text-align: center">1.4</td>
								<td class="iic">NĐT App ví Vimo Vay Mượn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1.5</td>
								<td class="iic">VNDT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Nhận tiền L1</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->thanh_toan_ve_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Nhận khác:</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->nhan_khac) ? $value->nhan_khac : 0 ?>"> <?= !empty($value->nhan_khac) ? number_format($value->nhan_khac) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->nhan_khac) ? $value->nhan_khac : 0 ?>' id='nhan_khac-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->nhan_khac) ? $value->nhan_khac : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng dòng tiền vào L2:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_dong_tien_vao_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>

							</tr>
							<tr>
								<td class="icx" style="text-align: center">III/</td>
								<td class="iic">Dòng tiền ra</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Giải ngân</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->giai_ngan) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1.1</td>
								<td class="iic">KH PGD</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->price_disbursement) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1.2</td>
								<td class="iic">KH (Priority + Nhà đất)</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->priority_nd) ? $value->priority_nd : 0 ?>"> <?= !empty($value->priority_nd) ? number_format($value->priority_nd) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->priority_nd) ? $value->priority_nd : 0 ?>' id='priority_nd-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->priority_nd) ? $value->priority_nd : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Thanh toán NĐT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->thanh_toan_ndt) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.1</td>
								<td class="iic">NĐT hợp tác</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->ndt_hop_tac) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.2</td>
								<td class="iic">App NĐT NL</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->app_vi_nl) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.3</td>
								<td class="iic">App NĐT Vimo</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->app_vi_vimo) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.4</td>
								<td class="iic">Vay mượn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.5</td>
								<td class="iic">VNDT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng dòng tiền ra L2:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_dong_tien_ra_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">IV/</td>
								<td class="iic">Net CF Budget L2</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->net_cf_budget_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">V/</td>
								<td class="iic">Dự trữ thanh khoản</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($totalBalance[0]->du_tru_thanh_khoan) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>

							<tr>
								<td class="icx" style="text-align: center">VI/</td>
								<td class="iic">Tổng tiền cần để đảm bảo thanh khoản cao nhất</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_tien_can_de_dam_bao_thanh_khoan_cao_nhat) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>

							<tr>
								<td class="icx" style="text-align: center">VII/</td>
								<td class="iic">Số dư TK tối thiểu</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Ví NL</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->VI_vi_nl) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Ví Vimo VFC</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->VI_vi_vimo_vfc) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Ví Vimo Vay Mượn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">4</td>
								<td class="iic">Ví VNDT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>

							<tr style="background-color: red; color: white">
								<td style="text-align: center">Phần 2</td>
								<td colspan="32">ACTUAL</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">A/</td>
								<td class="iic">DÒNG TIỀN L1:</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">I/</td>
								<td class="iic">Tổng số dư các tài khoản</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Tổng tiền tại các TK NH:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_tong_tien_tai_khoan_ngan_hang) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Tổng tiền VPS </td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->tong_tien_goc_vps) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.1</td>
								<td class="iic">Tổng tiền VPS đến hạn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->actual_goc_lai_vps_den_han) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.2</td>
								<td class="iic">Tổng tiền VPS chưa đến hạn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->actual_tong_tien_vps_chua_den_han) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.3</td>
								<td class="iic">Tổng tiền VPS chưa đến hạn dự kiến đáo</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao) ? $value->actual_tong_tien_vps_chua_den_han_du_kien_dao : 0 ?>"> <?= !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao) ? number_format($value->actual_tong_tien_vps_chua_den_han_du_kien_dao) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao) ? $value->actual_tong_tien_vps_chua_den_han_du_kien_dao : 0 ?>' id='actual_tong_tien_vps_chua_den_han_du_kien_dao-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao) ? $value->actual_tong_tien_vps_chua_den_han_du_kien_dao : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.4</td>
								<td class="iic">Tổng tiền VPS có thể sử dụng</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->actual_tong_tien_vps_co_the_su_dung_1) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Tổng tiền có thể sử dụng:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_tong_tien_co_the_su_dung) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">II/</td>
								<td class="iic">Dòng tiền vào</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Thực thu KH</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->actual_thuc_thu_khach) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Thu L2</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_thu_l2) ? $value->actual_thu_l2 : 0 ?>"> <?= !empty($value->actual_thu_l2) ? number_format($value->actual_thu_l2) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_thu_l2) ? $value->actual_thu_l2 : 0 ?>' id='actual_thu_l2-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_thu_l2) ? $value->actual_thu_l2 : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>

							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Thu khác</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_thu_khac) ? $value->actual_thu_khac : 0 ?>"> <?= !empty($value->actual_thu_khac) ? number_format($value->actual_thu_khac) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_thu_khac) ? $value->actual_thu_khac : 0 ?>' id='actual_thu_khac-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_thu_khac) ? $value->actual_thu_khac : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng dòng tiền thực vào L1</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_tong_dong_tien_thuc_vao_l1) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">III/</td>
								<td class="iic">Dòng tiền ra</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">CP hoạt động</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_cp_hoat_dong) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Thanh toán theo các đợt</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black"><?= number_format($value->actual_thanh_toan_theo_cac_dot) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Thanh toán ngoại lệ</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_thanh_toan_ngoai_le) ? $value->actual_thanh_toan_ngoai_le : 0 ?>"> <?= !empty($value->actual_thanh_toan_ngoai_le) ? number_format($value->actual_thanh_toan_ngoai_le) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_thanh_toan_ngoai_le) ? $value->actual_thanh_toan_ngoai_le : 0 ?>' id='actual_thanh_toan_ngoai_le-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_thanh_toan_ngoai_le) ? $value->actual_thanh_toan_ngoai_le : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Thanh toán về L2</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_thanh_toan_ve_l2) ? $value->actual_thanh_toan_ve_l2 : 0 ?>"> <?= !empty($value->actual_thanh_toan_ve_l2) ? number_format($value->actual_thanh_toan_ve_l2) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_thanh_toan_ve_l2) ? $value->actual_thanh_toan_ve_l2 : 0 ?>' id='actual_thanh_toan_ve_l2-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_thanh_toan_ve_l2) ? $value->actual_thanh_toan_ve_l2 : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Các khoản chi khác</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_cac_khoan_chi_khac) ? $value->actual_cac_khoan_chi_khac : 0 ?>"> <?= !empty($value->actual_cac_khoan_chi_khac) ? number_format($value->actual_cac_khoan_chi_khac) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_cac_khoan_chi_khac) ? $value->actual_cac_khoan_chi_khac : 0 ?>' id='actual_cac_khoan_chi_khac-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_cac_khoan_chi_khac) ? $value->actual_cac_khoan_chi_khac : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng dòng tiền ra</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_tong_dong_tien_ra) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">IV/</td>
								<td class="iic">DƯ TIỀN CẦN TẠI TK NH L1</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_du_tien_can_tai_tk_nh_l1) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">B/</td>
								<td class="iic">DÒNG TIỀN L2:</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">I/</td>
								<td class="iic">Số dư các TK L2</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Ví NL TMQ</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_nl_tmq) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Ví Vimo VFC</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_vimo_vfc) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Ví Vimo Vay Mượn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_vimo_vaymuon) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">4</td>
								<td class="iic">Ví VNDT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_vndt) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">5</td>
								<td class="iic">TK Tech TMQ</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->vi_tech_tmq) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6</td>
								<td class="iic">TK VPS</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->tong_tien_goc_vps) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6.1</td>
								<td class="iic">Tổng tiền VPS đến hạn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->actual_goc_lai_vps_den_han) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6.2</td>
								<td class="iic">Tổng tiền VPS chưa đến hạn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->goc_lai_vps_chua_den_han) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6.3</td>
								<td class="iic">Tổng tiền VPS chưa đến hạn dự kiến đáo</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1) ? $value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1 : 0 ?>"> <?= !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1) ? number_format($value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1) ? $value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1 : 0 ?>' id='actual_tong_tien_vps_chua_den_han_du_kien_dao_1-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1) ? $value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1 : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">6.4</td>
								<td class="iic">Tổng tiền VPS có thể sử dụng</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->actual_tong_tien_vps_co_the_su_dung) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>

							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng tiền có thể sử dụng L2:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_tong_tien_co_the_su_dung_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">II/</td>
								<td class="iic">DÒNG TIỀN VÀO:</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Nhà đầu tư nạp tiền:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_nha_dau_tu_nap_tien) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>

							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">NĐT hợp tác</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_ndt_hop_tac) ? $value->actual_ndt_hop_tac : 0 ?>"> <?= !empty($value->actual_ndt_hop_tac) ? number_format($value->actual_ndt_hop_tac) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_ndt_hop_tac) ? $value->actual_ndt_hop_tac : 0 ?>' id='actual_ndt_hop_tac-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_ndt_hop_tac) ? $value->actual_ndt_hop_tac : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>

							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">NĐT App ví NL</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->nap_app_vi_nl) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">NĐT App ví Vimo</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->nap_app_vi_vimo) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">NĐT App ví Vimo Vay Mượn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">VNDT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Nhận tiền L1</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_thanh_toan_ve_l2) ? $value->actual_thanh_toan_ve_l2 : 0 ?>"> <?= !empty($value->actual_thanh_toan_ve_l2) ? number_format($value->actual_thanh_toan_ve_l2) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_thanh_toan_ve_l2) ? $value->actual_thanh_toan_ve_l2 : 0 ?>' id='actual_thanh_toan_ve_l2-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_thanh_toan_ve_l2) ? $value->actual_thanh_toan_ve_l2 : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Nhận khác:</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_nhan_khac) ? $value->actual_nhan_khac : 0 ?>"> <?= !empty($value->actual_nhan_khac) ? number_format($value->actual_nhan_khac) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_nhan_khac) ? $value->actual_nhan_khac : 0 ?>' id='actual_nhan_khac-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_nhan_khac) ? $value->actual_nhan_khac : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng dòng tiền vào L2:</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_tong_dong_tien_vao_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>

							</tr>
							<tr>
								<td class="icx" style="text-align: center">III/</td>
								<td class="iic">Dòng tiền ra</td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Giải ngân</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_giai_ngan) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">KH PGD</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->actual_kh_pgd) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">KH (Priority + nhà đất)</td>
								<?php if (!empty($manually_enter)) : ?>
									<?php foreach ($manually_enter as $value) : ?>
										<td style="text-align: center; background-color: #f0e68c; color: black">
											<div class='edit' data-status="<?= !empty($value->actual_priority) ? $value->actual_priority : 0 ?>"> <?= !empty($value->actual_priority) ? number_format($value->actual_priority) : 0 ?></div>
											<input hidden type='number' class='txtedit' value='<?= !empty($value->actual_priority) ? $value->actual_priority : 0 ?>' id='actual_priority-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->actual_priority) ? $value->actual_priority : 0 ?>' />
										</td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Thanh toán NĐT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_thanh_toan_ndt) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.1</td>
								<td class="iic">NĐT hợp tác</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->actual_ndt_hop_tac_1) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.2</td>
								<td class="iic">App NĐT NL</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->actual_app_vi_nl) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.3</td>
								<td class="iic">App NĐT Vimo</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->actual_app_vi_vimo) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.4</td>
								<td class="iic">Vay mượn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2.5</td>
								<td class="iic">VNDT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center"></td>
								<td class="iic">Tổng dòng tiền ra L2</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_tong_dong_tien_ra_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">IV/</td>
								<td class="iic">Net CF adjust</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_net_cf_budget_l2) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>

							</tr>
							<tr>
								<td class="icx" style="text-align: center">V/</td>
								<td class="iic">Safety cash balance</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($totalBalance[0]->safety_cash_balance) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">VI/</td>
								<td class="iic">Tổng tiền cần để đảm bảo thanh khoản cao nhất</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black; font-weight: bold"><?= number_format($value->actual_tong_tien_can_de_dam_bao_thanh_khoan_cao_nhat) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">VII/</td>
								<td class="iic">Số dư TK tối thiếu </td>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">1</td>
								<td class="iic">Ví NL</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->actual_VI_vi_nl) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">2</td>
								<td class="iic">Ví Vimo VFC</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= number_format($value->actual_VI_vi_vimo_vfc) ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">3</td>
								<td class="iic">Ví Vimo Vay Mượn</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<td class="icx" style="text-align: center">4</td>
								<td class="iic">Ví VNDT</td>
								<?php if (!empty($totalBalance)) : ?>
									<?php foreach ($totalBalance as $value) : ?>
										<td style="text-align: center; background-color: #ffffff; color: black;"><?= "-" ?></td>
									<?php endforeach; ?>
								<?php endif; ?>
							</tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="addnewModal_budget" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="z-index: 4;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title" style="text-align: center">THÊM TỈ LỆ NẠP TIỀN</h3>
			</div>

			<div class="modal-body">
				<?php if (!empty($ratio[0])) : ?>
					<?php foreach ($ratio[0] as $key => $ra) : ?>
						<?php if ($key == "_id") : ?>
							<input style="display: none" type="text" class="form-control" value="<?= !empty($ra->{'$oid'}) ? $ra->{'$oid'} : '0' ?>" id="<?= !empty($key) ? $key : '' ?>">
							<?php continue ?>
						<?php endif; ?>
						<?php if (in_array($key, ['ndt_hop_tac', 'ndt_app_vi_nl', 'ndt_app_vi_vimo', 'ndt_app_vi_vay_muon', 'vndt'])) : ?>
							<div class="form-group row">
								<label class="control-label col-md-3 col-xs-12"><?= !empty($key) ? name_ratio($key) : '' ?> (%)</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" class="form-control" value="<?= !empty($ra) ? $ra : '0' ?>" data-key="<?= !empty($key) ? $key : '' ?>" id="<?= !empty($key) ? $key : '' ?>">
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit">Xác nhận</button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<!--Modal-->
<style>
	.page-title {
		min-height: 0px;
		padding: 0px 0;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		// Show Input element
		$('.edit').click(function() {
			var status = $(this).data('status');

			$('.txtedit').hide();
			$(this).next('.txtedit').show().focus();
			$(this).hide();

		});

		// Save data
		$(".txtedit").on('focusout', function() {

			// Get edit id, field name and value
			var id = this.id;
			var split_id = id.split("-");
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var value = $(this).val();

			// Hide Input element
			$(this).hide();

			// Hide and Change Text of the container with input elmeent
			$(this).prev('.edit').show();
			$(this).prev('.edit').text(numeral(value).format('0,0'));
			// Sending AJAX request
			$.ajax({
				url: _url.base_url + 'plan_actual/update_manually_enter',
				type: 'post',
				data: {
					field: field_name,
					value: value,
					id: edit_id
				},
				success: function(response) {
					console.log('Save successfully');
				}
			});
		});
	});
</script>
<script>
	$('ul.tabs li').click(function() {
		var tab_id = $(this).attr('data-tab');
		$('ul.tabs li').removeClass('active');
		$('.tab-panel').removeClass('active');
		$(this).addClass('active');
		$("#" + tab_id).addClass('active');
	})
</script>
<script>
	$("#submit").click(function(event) {
		event.preventDefault();

		let ndt_hop_tac = $('#ndt_hop_tac').val();
		let ndt_app_vi_nl = $('#ndt_app_vi_nl').val();
		let ndt_app_vi_vimo = $('#ndt_app_vi_vimo').val();
		let ndt_app_vi_vay_muon = $('#ndt_app_vi_vay_muon').val();
		let vndt = $('#vndt').val();
		let id = $('#_id').val();
		$.ajax({
			url: _url.base_url + '/plan_actual/update_ratio',
			method: "POST",
			data: {
				ndt_hop_tac: ndt_hop_tac,
				ndt_app_vi_nl: ndt_app_vi_nl,
				ndt_app_vi_vimo: ndt_app_vi_vimo,
				ndt_app_vi_vay_muon: ndt_app_vi_vay_muon,
				vndt: vndt,
				id: id,
			},

			beforeSend: function() {
				$(".theloading").show();
			},
			success: function(data) {
				$(".theloading").hide();
				if (data.data.status == 200) {
					console.log("xxxx");
					$("#successModal").modal("show");
					$(".msg_success").text('Update thành công');
					window.location.href = _url.base_url + '/plan_actual/indexPlanActual';
				}
			},
			error: function(data) {
				console.log("xxx");
				$(".theloading").hide();
			}
		});
	});

	$("#update_plan_actual").click(function (event) {
		event.preventDefault();

		$.ajax({
			url: _url.base_url + '/plan_actual/update_plan_actual',
			method: "POST",

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.data.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Update thành công');
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				}
			},
			error: function (data) {
				console.log("xxx");
				$(".theloading").hide();
			}
		});
	});

	$("#update_plan_actual").click(function (event) {
		event.preventDefault();

		$.ajax({
			url: _url.base_url + '/plan_actual/update_plan_actual',
			method: "POST",

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.data.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Update thành công');
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				}
			},
			error: function (data) {
				console.log("xxx");
				$(".theloading").hide();
			}
		});
	});
</script>
