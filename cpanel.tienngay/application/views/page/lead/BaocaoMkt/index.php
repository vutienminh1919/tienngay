<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="row">
					<div class="col-xs-7">
						<div class="title">
                            <h1 class="tilte_top_tabs" style="font-size: 28px">
								Báo cáo tổng hợp đối tác Marketing
							</h1>
						</div>
					</div>
					<?php
					$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
					$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
					?>
					<div class="col-xs-5 text-right">
						<form action="<?php echo base_url('report_telesale/search_reportMkt') ?>"  method="get">
						<div class="row">
							<div class="col-md-5">
								<input type="datetime-local" name="fdate" class="form-control" value="<?= !empty($fdate) ? $fdate : "" ?>" >
							</div>
							<div class="col-md-5">
								<input type="datetime-local" name="tdate" class="form-control" value="<?= !empty($tdate) ? $tdate : "" ?>">
							</div>
							<div class="col-lg-2 text-right">
								<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i>Tìm kiếm</button>
							</div>
						</div>
						</form>

					</div>
				</div>
			</div>
			<br><br>
			<div class="middle table_tabs">
				<div class="row">
					<div class="col-md-6">
						<div class="component_obj">
							<div class="box_state">
								<div class="title">
									<h3 style="font-weight: bold">
										<a href="<?php echo base_url('report_telesale/index_accesstrade') ?>">Accesstrade</a>
									</h3>
								</div>
								<div class="box_number-vertical">
									<div class="row">
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Lead Qualified
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->accesstrade->leadQLF)) ? number_format($result->accesstrade->leadQLF) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->accesstrade->so_hop_dong_giai_ngan)) ? number_format($result->accesstrade->so_hop_dong_giai_ngan) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Tiền Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->accesstrade->tong_so_tien_giai_ngan_hd)) ? number_format($result->accesstrade->tong_so_tien_giai_ngan_hd) : 0 ?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="component_obj">
							<div class="box_state">
								<div class="title">
									<h3 style="font-weight: bold">
										<a href="<?php echo base_url('report_telesale/index_accesstrade') ?>">Masoffer</a>
									</h3>
								</div>
								<div class="box_number-vertical">
									<div class="row">
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Lead Qualified
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->masoffer->leadQLF)) ? number_format($result->masoffer->leadQLF) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->masoffer->so_hop_dong_giai_ngan)) ? number_format($result->masoffer->so_hop_dong_giai_ngan) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Tiền Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->masoffer->tong_so_tien_giai_ngan_hd)) ? number_format($result->masoffer->tong_so_tien_giai_ngan_hd) : 0 ?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="component_obj">
							<div class="box_state">
								<div class="title">
									<h3 style="font-weight: bold">
										<a href="<?php echo base_url('report_telesale/index_accesstrade') ?>">Jeff</a>
									</h3>
								</div>
								<div class="box_number-vertical">
									<div class="row">
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Lead Qualified
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->jeff->leadQLF)) ? number_format($result->jeff->leadQLF) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->jeff->so_hop_dong_giai_ngan)) ? number_format($result->jeff->so_hop_dong_giai_ngan) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Tiền Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->jeff->tong_so_tien_giai_ngan_hd)) ? number_format($result->jeff->tong_so_tien_giai_ngan_hd) : 0 ?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="component_obj">
							<div class="box_state">
								<div class="title">
									<h3 style="font-weight: bold">
										<a href="<?php echo base_url('report_telesale/index_accesstrade') ?>">Toss</a>
									</h3>
								</div>
								<div class="box_number-vertical">
									<div class="row">
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Lead Qualified
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->toss->leadQLF)) ? number_format($result->toss->leadQLF) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->toss->so_hop_dong_giai_ngan)) ? number_format($result->toss->so_hop_dong_giai_ngan) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Tiền Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->toss->tong_so_tien_giai_ngan_hd)) ? number_format($result->toss->tong_so_tien_giai_ngan_hd) : 0 ?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="component_obj">
							<div class="box_state">
								<div class="title">
									<h3 style="font-weight: bold">
										<a href="<?php echo base_url('report_telesale/index_accesstrade') ?>">Dinos</a>
									</h3>
								</div>
								<div class="box_number-vertical">
									<div class="row">
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Lead Qualified
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->dinos->leadQLF)) ? number_format($result->dinos->leadQLF) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->dinos->so_hop_dong_giai_ngan)) ? number_format($result->dinos->so_hop_dong_giai_ngan) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Tiền Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->dinos->tong_so_tien_giai_ngan_hd)) ? number_format($result->dinos->tong_so_tien_giai_ngan_hd) : 0 ?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="component_obj">
							<div class="box_state">
								<div class="title">
									<h3 style="font-weight: bold">
										<a href="<?php echo base_url('report_telesale/index_accesstrade') ?>">Crezu</a>
									</h3>
								</div>
								<div class="box_number-vertical">
									<div class="row">
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Lead Qualified
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->crezu->leadQLF)) ? number_format($result->crezu->leadQLF) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->crezu->so_hop_dong_giai_ngan)) ? number_format($result->crezu->so_hop_dong_giai_ngan) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Tiền Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->crezu->tong_so_tien_giai_ngan_hd)) ? number_format($result->crezu->tong_so_tien_giai_ngan_hd) : 0 ?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="component_obj">
							<div class="box_state">
								<div class="title">
									<h3 style="font-weight: bold">
										<a href="<?php echo base_url('report_telesale/index_accesstrade') ?>">Phan_Nguyen</a>
									</h3>
								</div>
								<div class="box_number-vertical">
									<div class="row">
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Lead Qualified
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->phan_nguyen->leadQLF)) ? number_format($result->phan_nguyen->leadQLF) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->phan_nguyen->so_hop_dong_giai_ngan)) ? number_format($result->phan_nguyen->so_hop_dong_giai_ngan) : 0 ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 set_border_color">
											<div class="box_contract">
												<div class="contract_name">
													<h4>
														Số Tiền Hợp Đồng Giải Ngân
													</h4>
												</div>
												<div class="box_number">
													<span class="number">
														<?= (!empty($result->phan_nguyen->tong_so_tien_giai_ngan_hd)) ? number_format($result->phan_nguyen->tong_so_tien_giai_ngan_hd) : 0 ?>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.component_obj {
		background: #fff;
		border-radius: 10px;
		padding: 10px;
		margin-bottom: 20px;
		box-shadow: 1px 1px 2px 2px #ddd;
	}
	.component_obj .title h3
	{
		color: #0CA678;
		font-size: 22px;
		margin-top: 0;
	}
	.box_contract {
		border: 1px solid #0E9549;
		border-radius: 10px;
		padding: 10px;
	}
	.box_contract .contract_name h4
	{
		margin-top: 0;
		color: #595959;
		font-size: 16px;
		font-weight: 600;
	}
	.box_contract .box_number
	{
		font-weight: 600;
		font-size: 32px;
		color: #0E9549;
	}
	.set_border_color:first-child .box_contract
	{
		border-color: #17A2B8;
	}
	.set_border_color:last-child .box_contract
	{
		border-color: #EC1E24;
	}
	.set_border_color:first-child .box_contract .box_number
	{
		color: #17A2B8;
	}
	.set_border_color:last-child .box_contract .box_number
	{
		color: #EC1E24;
	}
</style>
