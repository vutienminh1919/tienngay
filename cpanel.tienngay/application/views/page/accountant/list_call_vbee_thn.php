<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "toi_han";
$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
$start_date = !empty($_GET['calledAtVbee_start']) ? $_GET['calledAtVbee_start'] : '';
$end_date = !empty($_GET['calledAtVbee_end']) ? $_GET['calledAtVbee_end'] : '';
$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : '';
$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : '';
$customer_phone_number = !empty($_GET['sdt']) ? $_GET['sdt'] : '';
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : '';
?>
<?php if ( in_array('supper-admin', $groupRoles) || in_array('van-hanh', $groupRoles)) {
	?>
<?php } ?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="row">
					<div class="col-xs-8">
						<div class="title">
							<span class="tilte_top_tabs">
								Danh Sách Gọi Tự Động
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="middle table_tabs">
				<div class="clicked nav_tabs_vertical nav tabs ">
					<ul id="myTab1" class="nav nav-tabs bar_tabs left mobiles" role="tablist">
						<li role="presentation" class="<?= ($tab == 'truoc_han') ? 'active text-active' : '' ?> ">
							<a href="<?php echo base_url() ?>temporary_plan/get_vbee_thn?tab=truoc_han"
							   id="khau-hao-tabb"
							   aria-expanded="true">CHIẾN DỊCH TRƯỚC HẠN</a>
						</li>
						<li role="presentation" class="<?= ($tab == 'toi_han') ? 'active text-active' : '' ?> ">
							<a href="<?php echo base_url() ?>temporary_plan/get_vbee_thn?tab=toi_han"
							   id="khau-hao-tabb"
							   aria-expanded="true">CHIẾN DỊCH TỚI HẠN</a>
						</li>
						<li role="presentation" class="<?= ($tab == 'qua_han') ? 'active text-active' : '' ?> ">
							<a href="<?php echo base_url() ?>temporary_plan/get_vbee_thn?tab=qua_han"
							   id="khau-hao-tabb"
							   aria-expanded="true">CHIẾN DỊCH QUÁ HẠN</a>
						</li>
					</ul>
				</div>
				<div class="tab-contents">
					<!-- tabs1 -->
					<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'toi_han') ? 'active' : '' ?>"
						 id="tab1"
						 aria-labelledby="tab1">
						<?php if ($tab == 'toi_han') : ?>
							<div class="row">
								<div class="col-md-6 col-sx-12 text-left btn_list_filter">
									<div class="float-left" id="btn-confirm-tai-san">
										<button type="button" class="btn btn-no-border btn-danger"
												id="remove-tai-san">
											<i class="fa fa-remove" style="font-size: 21px"></i> &nbsp;
											Xóa
										</button>
										<button type="button" class="btn btn-no-border btn-light"
												id="cancel-remove-tai-san">
											<i class="fa fa-ban" style="font-size: 21px"></i> &nbsp;
											Hủy
										</button>
									</div>
								</div>
								<div class="col-md-6 col-sx-12 text-right">
									<div class="btn_list_filter">
										<div class="button_functions">
											<div class="dropdown">
												<a class="btn btn-secondary btn-success"
												   href="<?= base_url() ?>temporary_plan/excel_thn?start_date=<?= $start_date . '&tab=' . $tab . '&end_date=' . $end_date . '&code_contract_disbursement=' . $code_contract_disbursement
												   ?>">Xuất
													Excel</a>
											</div>
										</div>
										<div class="button_functions btn-fitler_tab2">
											<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
												Tìm kiếm <i class="fa fa-filter"></i>
											</button>
											<div class="dropdown-menu drop_select_tab2">
												<label for="t_date" style="text-align: center">Từ (Ngày Thanh Gọi)<br />
												<input id="t_date" class="limit_on_page"
													   name="t_date" type="datetime-local" value="<?= $start_date ?>"
													   placeholder="ngày bắt đầu">
												<label for="e_date">Đến (Ngày Thanh Gọi)<br />
												<input id="e_date" class="limit_on_page"
													   name="e_date" type="datetime-local" value="<?= $end_date ?>"
													   placeholder="ngày kết thúc">
												<input id="sdt" class="limit_on_page"
													   name="sdt" type="number" value="<?= $customer_phone_number ?>"
													   placeholder="Số Điện Thoại">
												<input id="name" class="limit_on_page"
													   name="name" type="text" value="<?= $customer_name ?>"
													   placeholder="Tên Khách Hàng">
												<input id="customer_identify" class="limit_on_page"
													   name="customer_identify" type="text" value="<?= $customer_identify ?>"
													   placeholder="CMT/CCCD/Hộ chiếu">
												<input id="code_contract_disbursement" class="limit_on_page"
													   name="code_contract_disbursement" type="text" value="<?= $code_contract_disbursement ?>"
													   placeholder="Mã Hợp Đồng">
												<input id="tab" class="limit_on_page"
													   name="tab" type="text"
													   value="<?= $tab ?>" hidden>
												<button type="button" class="btn btn-outline-success"
														id="search_tab_toi_han">
													Tìm kiếm
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<div>
									<h4 class="text-success">Hiển thị (<span
												class="text-danger"><?php echo !empty($total_rows) ? $total_rows : 0 ?></span>)
										kết quả</h4>
								</div>
								<hr>
								<div>
									<table id="" class="table table-striped">
										<thead>
										<tr style="text-align: center">
											<th style="text-align: center">STT</th>
											<th style="text-align: center">Mã Hợp Đồng</th>
											<th style="text-align: center">Bucket</th>
											<th style="text-align: center">Ngày quá hạn</th>
											<th style="text-align: center">PGD/DRS</th>
											<th style="text-align: center">Nhân viên QLHDV phụ trách</th>
											<th style="text-align: center">Tên khách hàng</th>
											<th style="text-align: center">Tiền kỳ</th>
											<th style="text-align: center">Ngày Thanh Toán</th>
											<th style="text-align: center">Số điện thoại</th>
											<th style="text-align: center">CMT/CCCD/Hộ chiếu</th>
											<th style="text-align: center">Thời điểm gọi</th>
											<th style="text-align: center">Thời lượng kết nối TĐV(s)</th>
											<th style="text-align: center">Trạng thái</th>
<!--											<th style="text-align: center">File ghi âm</th>-->
										</tr>
										</thead>
										<tbody align="center">
										<?php foreach ($leadsData as $key => $value) : ?>
											<tr>
												<td><?php echo ++$key + $per_page ?></td>
												<td><?php echo $value->code_contract_disbursement ?></td>
												<td><?php echo get_bucket($value->so_ngay_cham_tra) ?></td>
												<td><?php echo $value->so_ngay_cham_tra ?></td>
												<td><?php echo $value->store_name ?></td>
												<td><?php echo $value->caller ?></td>
												<td><?php echo $value->name ?></td>
												<td><?php echo $value->amount_th ?></td>
												<td><?php echo date("Y-m-d", $value->ngay_ky_tra) ?></td>
												<td><?php echo $value->phone ?><br><button <?= !empty($value->record) ? "" : 'style="display:none"' ?> data-toggle="modal" data-target="#exampleModal3" class="btn btn-info recording_toi_han" data-record="<?= !empty($value->record) ? implode(', ',$value->record) : "" ?>">Recording</button></td>
												<td><?php echo($value->cmt) ?></td>
												<td><?php echo !is_numeric($value->calledAtVbee) ? $value->calledAtVbee : date("Y-m-d H:i:s",$value->calledAtVbee) ?></td>
												<td><?php echo($value->duration) ?></td>
												<td><?php echo($value->status_end_code) ?></td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
							<div>
								<nav class="text-right">
									<?php echo $pagination ?>
								</nav>
							</div>
						<?php endif; ?>
					</div>

					<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
						 aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Danh sách ghi âm</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body-toi-han">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

					<!-- tabs2 -->
					<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'truoc_han') ? 'active' : '' ?>"
						 id="tab2"
						 aria-labelledby="tab2">
						<?php if ($tab == 'truoc_han') : ?>
							<div class="row">
								<div class="col-md-6 col-sx-12 text-left btn_list_filter">
									<div class="float-left" id="btn-confirm-tai-san">
									</div>
								</div>
								<div class="col-md-6 col-sx-12 text-right">
									<div class="btn_list_filter">
										<div class="button_functions">
											<div class="dropdown">
												<a class="btn btn-secondary btn-success"
												   href="<?= base_url() ?>temporary_plan/excel_thn?start_date=<?= $start_date . '&tab=' . $tab . '&end_date=' . $end_date . '&code_contract_disbursement=' . $code_contract_disbursement
												   ?>">Xuất
													Excel</a>
											</div>
										</div>
										<div class="button_functions btn-fitler_tab2">
											<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
												Tìm kiếm <i class="fa fa-filter"></i>
											</button>
											<div class="dropdown-menu drop_select_tab2">
												<label for="t_date" style="text-align: center">Từ (Ngày Thanh Gọi)<br />
												<input id="t_date" class="limit_on_page"
													   name="t_date" type="datetime-local" value="<?= $start_date ?>"
													   placeholder="ngày bắt đầu">
												<label for="e_date">Đến (Ngày Thanh Gọi)<br />
												<input id="e_date" class="limit_on_page"
													   name="e_date" type="datetime-local" value="<?= $end_date ?>"
													   placeholder="ngày kết thúc">
												<input id="sdt" class="limit_on_page"
													   name="sdt" type="number" value="<?= $customer_phone_number ?>"
													   placeholder="Số Điện Thoại">
												<input id="name" class="limit_on_page"
													   name="name" type="text"  value="<?= $customer_name ?>"
													   placeholder="Tên Khách Hàng">
												<input id="customer_identify" class="limit_on_page"
													   name="customer_identify" type="text" value="<?= $customer_identify ?>"
													   placeholder="CMT/CCCD/Hộ chiếu">
												<input id="code_contract_disbursement" class="limit_on_page"
													   name="code_contract_disbursement" type="text" value="<?= $code_contract_disbursement ?>"
													   placeholder="Mã Hợp Đồng">
												<select id="sellect-segment" class="limit_on_page"
														name="priority">
													<option value="" selected="">Chọn Độ Ưu Tiên</option>
													<option value="1">Cao</option>
													<option value="2">Trung Bình</option>
													<option value="3">Thấp</option>
												</select>
												<input id="tab" class="limit_on_page"
													   name="tab" type="text"
													   value="<?= $tab ?>" hidden>
												<button type="button" class="btn btn-outline-success"
														id="search_tab_truoc_han">
													Tìm kiếm
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<div>
									<h4 class="text-success">Hiển thị (<span
												class="text-danger"><?php echo !empty($total_rows) ? $total_rows : 0 ?></span>)
										kết quả</h4>
								</div>
								<hr>
								<div>
									<table id="" class="table table-striped">
										<thead>
										<tr style="text-align: center">
											<th style="text-align: center">STT</th>
											<th style="text-align: center">Mã Hợp Đồng</th>
											<th style="text-align: center">Bucket</th>
											<th style="text-align: center">Ngày quá hạn</th>
											<th style="text-align: center">PGD/DRS</th>
											<th style="text-align: center">Nhân viên QLHDV phụ trách</th>
											<th style="text-align: center">Tên khách hàng</th>
											<th style="text-align: center">Tiền kỳ</th>
											<th style="text-align: center">Ngày Thanh Toán</th>
											<th style="text-align: center">Số điện thoại</th>
											<th style="text-align: center">CMT/CCCD/Hộ chiếu</th>
											<th style="text-align: center">Thời điểm gọi</th>
											<th style="text-align: center">Thời lượng kết nối TĐV(s)</th>
											<th style="text-align: center">Phím Bấm</th>
											<th style="text-align: center">Độ ưu tiên</th>
										</tr>
										</thead>
										<tbody align="center">
										<?php foreach ($leadsDataTruocHan as $key => $value) : ?>
											<tr>
												<td><?php echo ++$key + $per_page ?></td>
												<td><?php echo $value->code_contract_disbursement ?></td>
												<td><?php echo get_bucket($value->so_ngay_cham_tra) ?></td>
												<td><?php echo $value->so_ngay_cham_tra ?></td>
												<td><?php echo $value->store_name ?></td>
												<td><?php echo $value->caller ?></td>
												<td><?php echo $value->name ?></td>
												<td><?php echo ($value->amount_truoc_han) ?></td>
												<td><?php echo date("Y-m-d", $value->ngay_ky_tra) ?></td>
												<td><?php echo $value->phone ?><br><button <?= !empty($value->record) ? "" : 'style="display:none"' ?> data-toggle="modal" data-target="#exampleModal" class="btn btn-info recording_truoc_han" data-record="<?= !empty($value->record) ? implode(', ',$value->record) : "" ?>">Recording</button></td>
												<td><?php echo($value->cmt) ?></td>
												<td><?php echo !is_numeric($value->calledAtVbee) ? $value->calledAtVbee : date("Y-m-d H:i:s",$value->calledAtVbee) ?></td>
												<td><?php echo($value->duration) ?></td>
												<td><?php echo($value->key_press) ?></td>
												<?php if ($value->priority_truoc_han == "3"): ?>
													<td>
														thấp
													</td>
												<?php elseif ($value->priority_truoc_han == "2"): ?>
													<td>
														trung bình
													</td>
												<?php elseif ($value->priority_truoc_han == "1"): ?>
													<td>
														cao
													</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
							<div>
								<nav class="text-right">
									<?php echo $pagination ?>
								</nav>
							</div>
						<?php endif; ?>
					</div>
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
						 aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Danh sách ghi âm</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body-truoc-han">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>


					<!-- tabs3 -->
					<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'qua_han') ? 'active' : '' ?>"
						 id="tab3"
						 aria-labelledby="tab3">
						<?php if ($tab == 'qua_han') : ?>
							<div class="row">
								<div class="col-md-6 col-sx-12 text-left btn_list_filter">
									<div class="float-left" id="btn-confirm-tai-san">

									</div>
								</div>
								<div class="col-md-6 col-sx-12 text-right">
									<div class="btn_list_filter">
										<div class="button_functions">
											<div class="dropdown">
												<a class="btn btn-secondary btn-success"
												   href="<?= base_url() ?>temporary_plan/excel_thn?start_date=<?= $start_date . '&tab=' . $tab . '&end_date=' . $end_date . '&code_contract_disbursement=' . $code_contract_disbursement
												   ?>">Xuất
													Excel</a>
											</div>
										</div>
										<div class="button_functions btn-fitler_tab2">
											<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
												Tìm kiếm <i class="fa fa-filter"></i>
											</button>
											<div class="dropdown-menu drop_select_tab2">
												<label for="t_date" style="text-align: center" >Từ (Ngày Thanh Gọi)<br />
												<input id="t_date" class="limit_on_page"
													   name="t_date" type="datetime-local" value="<?= $start_date ?>"
													   placeholder="ngày bắt đầu">
												<label for="e_date">Đến (Ngày Thanh Gọi)<br />
												<input id="e_date" class="limit_on_page"
													   name="e_date" type="datetime-local" value="<?= $end_date ?>"
													   placeholder="ngày kết thúc">
												<input id="sdt" class="limit_on_page"
													   name="sdt" type="number" value="<?= $customer_phone_number ?>"
													   placeholder="Số Điện Thoại">
												<input id="name" class="limit_on_page"
													   name="name" type="text"  value="<?= $customer_name ?>"
													   placeholder="Tên Khách Hàng">
												<input id="customer_identify" class="limit_on_page"
													   name="customer_identify" type="text" value="<?= $customer_identify ?>"
													   placeholder="CMT/CCCD/Hộ chiếu">
												<input id="code_contract_disbursement" class="limit_on_page"
													   name="code_contract_disbursement" type="text" value="<?= $code_contract_disbursement ?>"
													   placeholder="Mã Hợp Đồng">
												<select id="sellect-segment" class="limit_on_page"
														name="priority">
													<option value="" selected="">Chọn Độ Ưu Tiên</option>
													<option value="1">Cao</option>
													<option value="2">Trung Bình</option>
													<option value="3">Thấp</option>
												</select>
												<input id="tab" class="limit_on_page"
													   name="tab" type="text"
													   value="<?= $tab ?>" hidden>
												<button type="button" class="btn btn-outline-success"
														id="search_tab_qua_han">
													Tìm kiếm
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<div>
									<h4 class="text-success">Hiển thị (<span
												class="text-danger"><?php echo !empty($total_rows) ? $total_rows : 0 ?></span>)
										kết quả</h4>
								</div>
								<hr>
								<div>
									<table id="" class="table table-striped">
										<thead>
										<tr style="text-align: center">
											<th style="text-align: center">STT</th>
											<th style="text-align: center">Mã Hợp Đồng</th>
											<th style="text-align: center">bucket</th>
											<th style="text-align: center">Ngày quá hạn</th>
											<th style="text-align: center">PGD/DRS</th>
											<th style="text-align: center">Nhân viên QLHDV phụ trách</th>
											<th style="text-align: center">Tên khách hàng</th>
											<th style="text-align: center">Tiền kỳ</th>
											<th style="text-align: center">Ngày Thanh Toán</th>
											<th style="text-align: center">Số điện thoại</th>
											<th style="text-align: center">CMT/CCCD/Hộ chiếu</th>
											<th style="text-align: center">Thời điểm gọi</th>
											<th style="text-align: center">Thời lượng kết nối TĐV(s)</th>
											<th style="text-align: center">Phím Bấm</th>
											<th style="text-align: center">Độ ưu tiên</th>
										</tr>
										</thead>
										<tbody align="center">
										<?php foreach ($leadsDataQuaHan as $key => $value) : ?>
											<tr>
												<td><?php echo ++$key + $per_page ?></td>
												<td><?php echo $value->code_contract_disbursement ?></td>
												<td><?php echo get_bucket($value->so_ngay_cham_tra) ?></td>
												<td><?php echo $value->so_ngay_cham_tra ?></td>
												<td><?php echo $value->store_name ?></td>
												<td><?php echo $value->caller ?></td>
												<td><?php echo $value->name ?></td>
												<td><?php echo ($value->amount_qua_han) ?></td>
												<td><?php echo date("Y-m-d", $value->ngay_thanh_toan) ?></td>
												<td><?php echo $value->phone ?><br><button <?= !empty($value->record) ? "" : 'style="display:none"' ?>
															data-toggle="modal" data-target="#exampleModal1"
															class="btn btn-info recording_qua_han"
															data-record="<?= !empty($value->record) ? implode(', ', $value->record) : "" ?>">Recording
													</button></td>
												<td><?php echo($value->cmt) ?></td>
												<td><?php echo !is_numeric($value->calledAtVbee_qh) ? $value->calledAtVbee_qh : date("Y-m-d H:i:s",$value->calledAtVbee_qh) ?></td>
												<td><?php echo($value->duration_qh) ?></td>
												<td><?php echo($value->key_press_qh) ?></td>
												<?php if ($value->priority_qh == "3"): ?>
													<td>
														thấp
													</td>
												<?php elseif ($value->priority_qh == "2"): ?>
													<td>
														trung bình
													</td>
												<?php elseif ($value->priority_qh == "1"): ?>
													<td>
														cao
													</td>
												<?php endif; ?>

											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
							<div>
								<nav class="text-right">
									<?php echo $pagination; ?>
								</nav>
							</div>
						<?php endif; ?>
					</div>
					<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
						 aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Danh sách ghi âm</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body-qua-han">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>

<div class="ovelay"></div>
<script src="<?php echo base_url(); ?>assets/js/property/oto.js"></script>
<style type="text/css">
	#table-wrapper {
		position: relative;
	}
	#fix_to_col .limit_on_page{
		border: 1px solid green !important;
		text-align: center;
		margin: 5px 5px;
	}
	#table-scroll {
		height: 150px;
		overflow: auto;
		margin-top: 20px;
	}

	#table-wrapper table {
		width: 100%;
	}

	#table-wrapper table * {
		color: black;
	}

	.marquee {
		display: none;
	}

	.modal {
		opacity: 1;
	}

	.company_close.btn-secondary {
		background: #EFF0F1;
		color: #000;
		border: 1px solid;
	}

	.checkbox {
		filter: invert(1%) hue-rotate(290deg) brightness(1);
	}

	.btn_bar {
		border-style: none;
		background: unset;
		margin-bottom: 0;
	}

	.hover {
		display: none;
	}

	.btn_bar:hover .not_hover {
		display: none;
	}

	.btn_bar:hover .hover {
		display: block;
		margin-bottom: -4px;
	}

	.propertype {
		position: absolute;
		border-top: unset !important;
		padding: 6px !important;
	}

	.propertype .dropdown-menu {
		left: -105px;
	}

	#alert_delete_pro_choo .delete_property {
		position: fixed;
		width: 378px;
		height: 175px;
		background: #fff;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		margin: auto;
		display: flex;
		align-items: center;
		border-radius: 5px;
		border-top: 2px solid #D63939;
		padding: 0 25px;
		color: #000;
	}

	#alert_delete_pro_choo .delete_property .popup_content h2 {
		color: #000;
	}

	.text-active a {
		color: green !important;
		font-weight: 600;
	}

	.btn-fitler_tab4 .dropdown-menu,
	.btn-fitler_tab5 .dropdown-menu {
		left: -230px;
		width: auto;
		padding: 10px;
	}

	/* mobile :*/
	@media only screen and ( max-width: 46.1875em) {
		.mobiles {
			display: block;
			overflow-x: scroll !important;
			height: 250px !important;

		}

		mobiles li a {
			border: none;
		}
	}
</style>
<script type="text/javascript">
	$(document).ready(function () {
		$('#myTab a').on('click', function (e) {
			e.preventDefault()
			$(this).tab('show')
		})

		$('.btn-fitler button.btn-success').on('click', function () {
			$('.drop_select').toggle();
		});
		$('.btn-fitler_tab2 button.btn-success').on('click', function () {
			$('.drop_select_tab2').toggle();
		});
		$('.btn-fitler_tab3 button.btn-success').on('click', function () {
			$('.drop_select_tab3').toggle();
		});
		$('.btn-fitler_tab4 button.btn-success').on('click', function () {
			$('.drop_select_tab4').toggle();
		});
		$('.btn-fitler_tab5 button.btn-success').on('click', function () {
			$('.drop_select_tab5').toggle();
		});
		$('#btn_add_dep').on('click', function () {
			$('#add_depreciation').show();
			$('.ovelay').show();
		});
		$('#btn_minus_dep').on('click', function () {
			$('#minus_depreciation').show();
			$('.ovelay').show();
		});
		$('#btn_edit_dep').on('click', function () {
			$('#edit_depreciation').show();
			$('.ovelay').show();
		});
		$('.show_info_btn_chose').on('click', function () {
			var id = $(this).attr("data-id");
			$('#show_info_item').show();
			$('.price_edit').hide();
			$('.discount_edit').hide();
			$('.Update_required').hide();
			$('.ovelay').show();
		});

		$('.show_info_btn_chose_phe_duyet').on('click', function () {
			var id = $(this).attr("data-id");
			$('#show_info_item_phe_duyet').show();
			$('.price_phe_duyet_edit').hide();
			$('.discount_edit').hide();
			$('.Update_required').hide();
			$('.ovelay').show();
		});


		$('.click_delete_pro').on('click', function () {
			var id = $(this).attr("data-id");
			$('#successModal').show();
			$('.ovelay').show();
		});
		$('.show_history_info_btn').on('click', function () {
			var id = $(this).attr("data-id");
			$('#show_history_info_item').show();
			$('.ovelay').show();
		});
		// $('.Update_required').on('click', function () {
		// 	$('#successModal').show();
		// 	$('.ovelay').show();
		//
		// });
		$('.body_click_details').on('click', function () {
			var price_str = $('.gia_xe').text();
			var price = price_str.split(',').join('')
			console.log(price)
			$('.price_edit').val(price);
			$('.show_fe').toggle();
			$('.price_edit').toggle();
			$('.price_phe_duyet_edit').toggle();
			$('.discount_edit').toggle();
			$('.Update_required').toggle('inline-block');
		});

		$('.company_close').on('click', function () {
			$('#add_depreciation').hide();
			$('#minus_depreciation').hide();
			$('#edit_depreciation').hide();
			$('#successModal').hide();
			$('#alert_delete_pro_choo').hide();
			$('#show_info_item').hide();
			$('#show_info_item_phe_duyet').hide();
			$('#show_history_info_item').hide();
			$('.ovelay').hide();
		});
		$('ul.tabs li').click(function () {
			var tab_id = $(this).attr('data-tab');
			$('ul.tabs li').removeClass('active');
			$('.tab-panel').removeClass('active');
			$(this).addClass('active');
			$("#" + tab_id).addClass('active');
		})
		$('.list_items .items').click(function () {
			$('.dot_stick').removeClass('active');
			$(this).children().addClass('active');
			$('.list-source_data').animate({
				scrollTop: $(this).offset().top - 10
			}, 1000)
		})
	});
</script>
<script type="text/javascript">
	function selectAll(invoker) {
		var inputElements = document.getElementsByTagName('input');
		for (var i = 0; i < inputElements.length; i++) {
			var myElement = inputElements[i];
			if (myElement.type === "checkbox") {
				myElement.checked = invoker.checked;
			}

		}
		$('.detele-all').toggle();
	}
</script>
<script>
	$(document).ready(function () {
		set_switchery();

		function set_switchery() {
			$(".aiz_switchery").each(function () {
				new Switchery($(this).get(0), {
					color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'
				});
			});
		}
	});
</script>
<script>
	const $menu = $('.dropdown');
	$(document).mouseup(e => {
		if (!$menu.is(e.target)
				&& $menu.has(e.target).length === 0) {
			$menu.removeClass('is-active');
			$('.dropdown-menu').removeClass('show');
		}
	});
	$('.dropdown-toggle').on('click', () => {
		$menu.toggleClass('is-active');
	});

</script>

<script>
	$(document).ready(function () {
		$('#search_tab_truoc_han').click(function () {
			let t_date = $("input[name='t_date']").val()
			let e_date = $("input[name='e_date']").val()
			let sdt = $("input[name='sdt']").val()
			let name = $("input[name='name']").val()
			let priority = $("select[name='priority']").val()
			let code_contract_disbursement = $("input[name='code_contract_disbursement']").val()
			let customer_identify = $("input[name='customer_identify']").val()
			let tab = $("input[name='tab']").val()
			window.location.href = _url.base_url + 'temporary_plan/get_vbee_thn' + '?tab=' + tab + '&calledAtVbee_start=' + t_date + '&calledAtVbee_end='
					+ e_date + '&sdt=' + sdt + '&customer_name=' + name + '&code_contract_disbursement=' + code_contract_disbursement + '&customer_identify=' + customer_identify +
					'&priority_truoc_han=' + priority
			;
		})

		$('#search_tab_toi_han').click(function () {
			let t_date = $("input[name='t_date']").val()
			let e_date = $("input[name='e_date']").val()
			let sdt = $("input[name='sdt']").val()
			let name = $("input[name='name']").val()
			let code_contract_disbursement = $("input[name='code_contract_disbursement']").val()
			let customer_identify = $("input[name='customer_identify']").val()
			let tab = $("input[name='tab']").val()
			window.location.href = _url.base_url + 'temporary_plan/get_vbee_thn' + '?tab=' + tab + '&calledAtVbee_start=' + t_date + '&calledAtVbee_end='
					+ e_date + '&sdt=' + sdt + '&customer_name=' + name + '&code_contract_disbursement=' + code_contract_disbursement + '&customer_identify=' + customer_identify

			;
		})

		$('#search_tab_qua_han').click(function () {
			let t_date = $("input[name='t_date']").val()
			let e_date = $("input[name='e_date']").val()
			let sdt = $("input[name='sdt']").val()
			let name = $("input[name='name']").val()
			let code_contract_disbursement = $("input[name='code_contract_disbursement']").val()
			let customer_identify = $("input[name='customer_identify']").val()
			let priority = $("select[name='priority']").val()
			let tab = $("input[name='tab']").val()
			window.location.href = _url.base_url + 'temporary_plan/get_vbee_thn' + '?tab=' + tab + '&calledAtVbee_start=' + t_date + '&calledAtVbee_end='
					+ e_date + '&sdt=' + sdt + '&customer_name=' + name + '&code_contract_disbursement=' + code_contract_disbursement + '&customer_identify=' + customer_identify +
					'&priority_qh=' + priority;

		})

		$('.recording_truoc_han').click(function (event) {
			event.preventDefault();
			let record = $(this).attr('data-record')
			let array = record.split(', ');
			$('.modal-body-truoc-han').html('');
			$.each(array, function (key, value) {
				$('.modal-body-truoc-han').append('<audio controls><source src="' + value + '" type="audio/wav"></audio>')
			});
		})

		$('.recording_qua_han').click(function (event) {
			event.preventDefault();
			let record = $(this).attr('data-record')
			let array = record.split(', ');
			$('.modal-body-qua-han').html('');
			$.each(array, function (key, value) {
				$('.modal-body-qua-han').append('<audio controls><source src="' + value + '" type="audio/wav"></audio>')
			});
		})

		$('.recording_toi_han').click(function (event) {
			event.preventDefault();
			let record = $(this).attr('data-record')
			let array = record.split(', ');
			$('.modal-body-toi-han').html('');
			$.each(array, function (key, value) {
				$('.modal-body-toi-han').append('<audio controls><source src="' + value + '" type="audio/wav"></audio>')
			});
		})


	});
</script>
<script src="<?php echo base_url(); ?>assets/js/property/new/index.js"></script>
<link href="<?php echo base_url('assets/') ?>/js/switchery/switchery.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>/js/switchery/switchery.min.js"></script>
<style>
	#btn-confirm-tai-san {
		display: none;
	}

	@media (max-width: 768px) {
		.btn_list_filter {
			display: block;
		}
	}
</style>
