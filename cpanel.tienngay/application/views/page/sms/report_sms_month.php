<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="col-xs-12">
        <div class="page-title">
			<?php
			$fdate_export = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";

			?>
            <div class="title_left">
                <h3>TỔNG HỢP SỐ LƯỢNG SMS TRONG THÁNG
                <br>
                <small>
                    <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">TỔNG HỢP SỐ LƯỢNG SMS TRONG THÁNG</a>
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
                                    <form action="<?php echo base_url('sms/report_sms_month')?>" method="get" style="width: 100%;">
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
											<a style="background-color: #18d102;" href="<?= base_url() ?>excel/excel_report_sms_month?fdate_export=<?= $fdate_export ?>" class="btn btn-primary w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</a>
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
											<th style="text-align: center" >STT</th>
											<th style="text-align: center" >Tên khách hàng</th>
											<th style="text-align: center" >Số hợp đồng</th>

											<th style="text-align: center">Phòng giao dịch</th>
											<th style="text-align: center" >Tổng số lượng SMS trong tháng</th>

											

										</tr>
										

										</thead>
										<tbody>

										<?php if (empty($contracts)): ?>
											<tr><td>No data</td></tr>
										<?php else: ?>
											<?php foreach ($contracts as $key => $item): ?>
												<tr>
													<td style="text-align: center"><?= ++$key ?></td>
													<td style="text-align: center"><?= !empty($item->customer_name) ? $item->customer_name : "" ?></td>
													<td style="text-align: center"><?= !empty($item->total_contract_month) ? $item->total_contract_month : "" ?></td>
													<td style="text-align: center"><?= !empty($item->store_name) ? $item->store_name : "" ?></td>
													<td style="text-align: center"><?= !empty($item->total_sms_month) ? $item->total_sms_month : "" ?></td>
													
													
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
