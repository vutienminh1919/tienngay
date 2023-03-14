<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Thu hồi khoản vay
                </h3>
            </div>
        </div>

		<?php
//		$date_start = !empty($_GET['fdate_export_start']) ? $_GET['fdate_export_start'] : "";
//		$date_end = !empty($_GET['fdate_export_end']) ? $_GET['fdate_export_end'] : "";
		$date = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";


		?>

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
                                    <form action="<?php echo base_url('aSRevokeLoan/report_kt')?>" method="get" style="width: 100%;">
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">Tháng</span>
                                                <input type="month" id="fdate_export" name="fdate_export" class="form-control"  value="<?= !empty($date) ? $date : ""?>" >
                                            </div>
                                        </div>

<!--										<div class="col-lg-2">-->
<!---->
<!--											<div class="input-group">-->
<!--												<span class="input-group-addon">--><?php //echo $this->lang->line('from') ?><!--</span>-->
<!--												<input type="date" id="fdate_export_start" name="fdate_export_start" class="form-control"-->
<!--													   value="--><?//= !empty($date_start) ? $date_start : "" ?><!--"-->
<!--												>-->
<!--											</div>-->
<!--										</div>-->
<!---->
<!--										<div class="col-lg-2">-->
<!---->
<!--											<div class="input-group">-->
<!--												<span class="input-group-addon">--><?php //echo $this->lang->line('to') ?><!--</span>-->
<!--												<input type="date" id="fdate_export_end" name="fdate_export_end" class="form-control"-->
<!--													   value="--><?//= !empty($date_end) ? $date_end : "" ?><!--"-->
<!--												>-->
<!--											</div>-->
<!--										</div>-->
										<div class="col-xs-12 col-lg-2">

											<button type="submit" class="btn btn-primary w-100"><i
														class="fa fa-search"
														aria-hidden="true"></i> <?= $this->lang->line('search') ?>
											</button>
										</div>

                                        <div class="col-lg-2 text-right">
                                            <a style="background-color: #18d102;" href="<?= base_url() ?>ASRevokeLoan/process?fdate_export=<?= $date  ?>" class="btn btn-primary w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</a>
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
											<th style="text-align: center">STT</th>
											<th style="text-align: center">Mã phiếu ghi</th>
											<th style="text-align: center">Mã hợp đồng</th>
											<th style="text-align: center">Mã phiếu thu</th>
											<th style="text-align: center">Tên khách hàng</th>
											<th style="text-align: center">Số tiền phải trả</th>
											<th style="text-align: center">Phòng giao dịch </th>
											
											<th style="text-align: center">Mã GD ngân hàng</th>
											<th style="text-align: center">Ngày tạo phiếu</th>
											<th style="text-align: center">Phương thức thanh toán</th>
											<th style="text-align: center">Ngân hàng</th>
											<th style="text-align: center">Trạng thái</th>
											<th style="text-align: center">Số tiền thực nhận</th>
											<th style="text-align: center">Loại thanh toán</th>
											<th style="text-align: center">Ngày khách thanh toán</th>
											<th style="text-align: center">Tổng tiền thanh toán</th>
											<th style="text-align: center">Tổng tiền đã trả</th>
											<th style="text-align: center">Ngày bank nhận </th>
											<th style="text-align: center">Ghi chú</th>
											
										</tr>

										</thead>
										<tbody>
										<?php if (empty($trans)): ?>
										<tr><td>No data</td></tr>
										<?php else: ?>
										<?php foreach ($trans as $key => $item): ?>
											<tr>
												<td style="text-align: center"><?= ++$key ?></td>

												<td style="text-align: center"><?= !empty($item['code_contract']) ? $item['code_contract'] : "" ?></td>
												<td style="text-align: center"><?= !empty($item['code_contract_disbursement']) ? $item['code_contract_disbursement'] : "" ?></td>
												<td style="text-align: center"><?= !empty($item['code']) ? $item['code'] : "" ?></td>
												<td style="text-align: center"><?= !empty($item['customer_name']) ? $item['customer_name'] : "" ?></td>
												<td style="text-align: center"><?= !empty($item['valid_amount']) ? number_format($item['valid_amount']) : 0 ?></td>

												<td style="text-align: center"><?= !empty($item['store']) ? $item['store'] : "" ?></td>
												<td style="text-align: center"><?= !empty($item['code_transaction_bank']) ? $item['code_transaction_bank'] : "" ?></td>
												<td style="text-align: center"><?= !empty($item['created_at']) ? $item['created_at'] : "" ?></td>
												<td style="text-align: center"><?= !empty($item['payment_method']) ? $item['payment_method'] : "" ?></td>
                                                <td style="text-align: center"><?= !empty($item['bank']) ? $item['bank'] : "" ?></td>
                                                <td style="text-align: center">Thành công</td>
                                                <td style="text-align: center"><?= !empty($item['amount_actually_received']) ? $item['amount_actually_received'] : 0 ?></td>

                                                <td style="text-align: center"><?= !empty($item['type']) ? $item['type'] : "" ?></td>
                                                <td style="text-align: center"><?= !empty($item['date_pay']) ? $item['date_pay'] : "" ?></td>
												<td style="text-align: center"><?= !empty($item['total']) ? number_format($item['total']) : 0 ?></td>
												<td style="text-align: center"><?= !empty($item['tong_chia']) ? number_format($item['tong_chia']) : 0 ?></td>
                                                 <td style="text-align: center"><?= !empty($item['date_bank']) ? $item['date_bank'] : "" ?></td>
                                                  <td style="text-align: center"><?= !empty($item['note']) ? $item['note'] : "" ?></td>
                                                  
											</tr>
											 <?php 
                                                $total_valid_amount_7+=$item['valid_amount']; 
                                                 $total_amount_actually_received_14+=$item['amount_actually_received']; 
                                                  $total_total_17+=$item['total']; 
                                                 $total_tong_chia_18+=$item['tong_chia']; 
                                                ?>
										<?php endforeach; ?>
										<?php endif; ?>

										<tr>
											<td style="text-align: center">Tổng: </td>
											<td style="text-align: center"></td>
											<td style="text-align: center"></td>
											<td style="text-align: center"></td>
											<td style="text-align: center"></td>
											<td style="text-align: center"><?= number_format($total_valid_amount_7)?></td>
											<td style="text-align: center"></td>
											
											<td style="text-align: center"></td>
											<td style="text-align: center"></td>
											<td style="text-align: center"></td>
											<td style="text-align: center"></td>
											<td style="text-align: center"></td>
											<td style="text-align: center"><?= number_format($total_amount_actually_received_14)?></td>
											<td style="text-align: center"></td>
											
											<td style="text-align: center"></td>
										
											<td style="text-align: center"><?= number_format($total_total_17)?></td>
											<td style="text-align: center"><?= number_format($total_tong_chia_18)?></td>
												<td style="text-align: center"></td>
											<td style="text-align: center"></td>
										


										</tr>
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
