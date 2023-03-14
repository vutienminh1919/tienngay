<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="col-xs-12">
        <div class="page-title">
			<?php
			$fdate_export = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";

			?>
            <div class="title_left">
                <h3>Theo dõi khoản vay T hiện tại
                <br>
                <small>
                    <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Theo dõi khoản vay T hiện tại</a>
                </small>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <!--Xuất excel-->
                        <div class="row">
                            <div class="col-xs-12">
                                <?php if ($this->session->flashdata('error')) { ?>
                                <div class="alert alert-danger alert-result">
                                    <?= $this->session->flashdata('error') ?>
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                                <?php } ?>
                                <div class="row">
                                    <form action="<?php echo base_url('aSCurrentMonth/report_month_kt')?>" method="get" style="width: 100%;">
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">Tháng</span>
                                                <input type="month" name="fdate_export" id="fdate_export" class="form-control" value="<?= !empty($fdate_export) ? $fdate_export : ""?>" >
                                            </div>
                                        </div>
										<div class="col-xs-12 col-lg-2">
											<button type="submit" class="btn btn-primary w-100"><i
														class="fa fa-search"
														aria-hidden="true"></i> <?= $this->lang->line('search') ?>
											</button>
										</div>
										<div class="col-lg-2 text-right">
											<a style="background-color: #18d102;" href="<?= base_url() ?>ASCurrentMonth/process?fdate_export=<?= $fdate_export ?>" class="btn btn-primary w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</a>
										</div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

					<div class="x_content">
						<div class="row">
							<div class="col-xs-12">

								<div class="table-responsive">
									<table id="datatable-button" class="table table-striped">
										<thead>
										<tr>
											<th style="text-align: center" colspan="14">Thông tin hợp đồng vay</th>
											<th style="text-align: center" colspan="8">Tháng T</th>

											<th style="text-align: center" rowspan="2">Lãi lũy kế đến tháng Tn</th>
											<th style="text-align: center" rowspan="2">Phí lũy kế đến tháng Tn</th>

											<th style="text-align: center" colspan="9">Đến thời điểm đáo hạn</th>

											<th style="text-align: center" rowspan="2">Lãi dự thu tháng Tn</th>
											<th style="text-align: center" rowspan="2">Phí dự thu tháng Tn</th>
											<th style="text-align: center" rowspan="2">Gốc tháng trước</th>
											<th style="text-align: center" rowspan="2">Lãi tháng trước</th>
											<th style="text-align: center" rowspan="2">Phí tháng trước</th>

											<th style="text-align: center" colspan="12">Thu hồi</th>

										</tr>
										<tr>
											<th style="text-align: center; background-color: white; color: black" >STT</th>
											<th style="text-align: center; background-color: white; color: black" >Mã giao dịch</th>
											<th style="text-align: center; background-color: white; color: black" >Mã hợp đồng vay</th>
<!--											<th style="text-align: center; background-color: white; color: black" >Mã phụ lục hợp đồng vay</th>-->
											<th style="text-align: center; background-color: white; color: black" >Thời hạn vay (ngày)</th>
											<th style="text-align: center; background-color: white; color: black" >Ngày giải ngân</th>
											<th style="text-align: center; background-color: white; color: black" >Ngày đáo hạn</th>
											<th style="text-align: center; background-color: white; color: black" >Tên người vay</th>
											<th style="text-align: center; background-color: white; color: black" >Mã người vay (trùng CMT)</th>
											<th style="text-align: center; background-color: white; color: black" >Tên nhà đầu tư</th>
											<th style="text-align: center; background-color: white; color: black" >Mã NĐT</th>
											<th style="text-align: center; background-color: white; color: black" >Phòng giao dịch giải ngân</th>
											<th style="text-align: center; background-color: white; color: black" >Hình thưc cầm cố</th>
											<th style="text-align: center; background-color: white; color: black" >Số tiền vay</th>
											<th style="text-align: center; background-color: white; color: black" >Hình thức tính lãi</th>

											<th style="text-align: center; background-color: white; color: black" >Gốc vay phải thu</th>
											<th style="text-align: center; background-color: white; color: black" >Lãi vay phải trả NĐT</th>
											<th style="text-align: center; background-color: white; color: black" >Phí tư vấn</th>
											<th style="text-align: center; background-color: white; color: black" >Phí thẩm định</th>
											<th style="text-align: center; background-color: white; color: black" >Phi trả chậm</th>
											<th style="text-align: center; background-color: white; color: black" >Phí trả trước</th>
											<th style="text-align: center; background-color: white; color: black" >Phí gia hạn khoản vay</th>
											<th style="text-align: center; background-color: white; color: black" >Tổng phí</th>


											<th style="text-align: center; background-color: white; color: black" >Gốc vay phải thu</th>
											<th style="text-align: center; background-color: white; color: black" >Lãi vay phải trả NĐT</th>
											<th style="text-align: center; background-color: white; color: black" >Phí tư vấn</th>
											<th style="text-align: center; background-color: white; color: black" >Phí thẩm định</th>
											<th style="text-align: center; background-color: white; color: black" >Phí gia hạn</th>
											<th style="text-align: center; background-color: white; color: black" >Phí trả chậm</th>
											<th style="text-align: center; background-color: white; color: black" >Phí trả trước</th>
											<th style="text-align: center; background-color: white; color: black" >Phí quá hạn</th>
											<th style="text-align: center; background-color: white; color: black" >Tổng phí</th>


											<th style="text-align: center; background-color: white; color: black" >Số tiền gốc đã thu hồi</th>
											<th style="text-align: center; background-color: white; color: black" >Số tiền lãi đã thu hồi</th>
											<th style="text-align: center; background-color: white; color: black" >Số tiền phí đã thu hồi</th>
											<th style="text-align: center; background-color: white; color: black" >Số tiền phí chậm trả đã thu hồi</th>
											<th style="text-align: center; background-color: white; color: black" >Số tiền phí trước hạn đã thu hồi</th>
											<th style="text-align: center; background-color: white; color: black" >Tổng thu hồi tháng T</th>
											<th style="text-align: center; background-color: white; color: black" >Tổng thu hồi lũy kế tháng trước</th>
											<th style="text-align: center; background-color: white; color: black" >Tổng thu hồi lũy kế tháng T</th>
											<th style="text-align: center; background-color: white; color: black" >Số tiền gốc còn lại</th>
											<th style="text-align: center; background-color: white; color: black" >Số tiền lãi còn lại</th>
											<th style="text-align: center; background-color: white; color: black" >Số tiền phí còn lại</th>
											<th style="text-align: center; background-color: white; color: black" >Trạng thái</th>


										</tr>

										</thead>
										<tbody>

										<?php if (empty($contracts)): ?>
											<tr><td>No data</td></tr>
										<?php else: ?>
											<?php foreach ($contracts as $key => $item): ?>
												<tr>
													<td style="text-align: center"><?= ++$key ?></td>
													<td style="text-align: center"><?= !empty($item['codeTransaction']) ? $item['codeTransaction'] : "" ?></td>
													<td style="text-align: center"><?= !empty($item['getMaHopDongVay']) ? $item['getMaHopDongVay'] : "" ?></td>
<!--													<td style="text-align: center">--><?//= !empty($item['getMaPhuLuc']) ? $item['getMaPhuLuc'] : "" ?><!--</td>-->
													<td style="text-align: center"><?= !empty($item['thoi_han_vay']) ? $item['thoi_han_vay'] : "" ?></td>
													<td style="text-align: center"><?= !empty($item['disbursement_date']) ? date("d/m/y",strtotime($item['disbursement_date'])) : "" ?></td>
													<td style="text-align: center"><?= !empty($item['expire_date']) ? date("d/m/y", strtotime($item['expire_date'])) : "" ?></td>
													<td style="text-align: center"><?= !empty($item['customer_name']) ? $item['customer_name'] : "" ?></td>
													<td style="text-align: center"><?= !empty($item['customer_identify']) ? $item['customer_identify'] : "" ?></td>
													<td style="text-align: center"><?= !empty($item['investor_infor_name']) ? $item['investor_infor_name'] : "" ?></td>
													<td style="text-align: center"><?= !empty($item['investor_infor_code']) ? $item['investor_infor_code'] : "" ?></td>
													<td style="text-align: center"><?= !empty($item['store_name']) ? $item['store_name'] : "" ?></td>
													<td style="text-align: center"><?= !empty($item['type_loan_code']) ? $item['type_loan_code'] : "" ?></td>
													<td style="text-align: center"><?= !empty($item['amount']) ? $item['amount'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['typePay']) ? $item['typePay'] : "" ?></td>

													<td style="text-align: center"><?= !empty($item['goc_vay_phai_thu']) ? $item['goc_vay_phai_thu'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['interestPayInvestor']) ? $item['interestPayInvestor'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['feeAdvisory']) ? $item['feeAdvisory'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['feeExpertise']) ? $item['feeExpertise'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['feePayDelay']) ? $item['feePayDelay'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['feeFinishContract']) ? $item['feeFinishContract'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['feeExtend']) ? $item['feeExtend'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['totalFee_1']) ? $item['totalFee_1'] : 0 ?></td>

													<td style="text-align: center"><?= !empty($item['lai_luy_ke_den_thang_Tn']) ? $item['lai_luy_ke_den_thang_Tn'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['phi_luy_ke_den_thang_Tn']) ? $item['phi_luy_ke_den_thang_Tn'] : 0 ?></td>

													<td style="text-align: center"><?= !empty($item['goc_vay_phai_thu_den_thoi_diem_dao_han']) ? $item['goc_vay_phai_thu_den_thoi_diem_dao_han'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['lai_vay_phai_tra_NDT_den_thoi_diem_dao_han']) ? $item['lai_vay_phai_tra_NDT_den_thoi_diem_dao_han'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['phi_tu_van_den_thoi_diem_dao_han']) ? $item['phi_tu_van_den_thoi_diem_dao_han'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['phi_tham_dinh_den_thoi_diem_dao_han']) ? $item['phi_tham_dinh_den_thoi_diem_dao_han'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['phi_gia_han_den_thoi_diem_dao_han']) ? $item['phi_gia_han_den_thoi_diem_dao_han'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['phi_tra_cham_den_thoi_diem_dao_han']) ? $item['phi_tra_cham_den_thoi_diem_dao_han'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['phi_tra_truoc_den_thoi_diem_dao_han']) ? $item['phi_tra_truoc_den_thoi_diem_dao_han'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['phi_phat_sinh_den_thoi_diem_dao_han']) ? $item['phi_phat_sinh_den_thoi_diem_dao_han'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['totalFee']) ? $item['totalFee'] : 0 ?></td>

													<td style="text-align: center"><?= !empty($item['lai_du_thu_thang_Tn']) ? $item['lai_du_thu_thang_Tn'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['phi_du_thu_thang_Tn']) ? $item['phi_du_thu_thang_Tn'] : 0 ?></td>

													<td style="text-align: center"><?= !empty($item['du_no_goc_thang_truoc']) ? $item['du_no_goc_thang_truoc'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['du_no_lai_thang_truoc']) ? $item['du_no_lai_thang_truoc'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['du_no_phi_thang_truoc']) ? $item['du_no_phi_thang_truoc'] : 0 ?></td>

													<td style="text-align: center"><?= !empty($item['so_tien_goc_da_thu_hoi']) ? $item['so_tien_goc_da_thu_hoi'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['so_tien_lai_da_thu_hoi']) ? $item['so_tien_lai_da_thu_hoi'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['so_tien_phi_da_thu_hoi']) ? $item['so_tien_phi_da_thu_hoi'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai']) ? $item['so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai']) ? $item['so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['tong_thu_hoi_thang_T']) ? $item['tong_thu_hoi_thang_T'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['tong_thu_hoi_luy_ke_thang_truoc']) ? $item['tong_thu_hoi_luy_ke_thang_truoc'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['tong_thu_hoi_luy_ke_thang_Tn']) ? $item['tong_thu_hoi_luy_ke_thang_Tn'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['so_tien_goc_con_lai']) ? $item['so_tien_goc_con_lai'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['so_tien_lai_con_lai']) ? $item['so_tien_lai_con_lai'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['so_tien_phi_con_lai']) ? $item['so_tien_phi_con_lai'] : 0 ?></td>
													<td style="text-align: center"><?= !empty($item['status_last']) ? $item['status_last'] : "" ?></td>

												</tr>
											<?php endforeach; ?>
										<?php endif; ?>

										</tbody>
									</table>
								</div>
								<div class="">
									<?php echo $pagination ?>
								</div>
							</div>

						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
