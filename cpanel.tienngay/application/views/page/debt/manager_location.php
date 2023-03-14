<?php
$getId = !empty($_GET['location']) ? $_GET['location'] : "";
?>
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Quản lý nhân viên QLHDV
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('debt_manager_app/view_manager_location') ?>">Quản lý vị trí
							nhân viên
							THN</a>
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
									<form action="<?php echo base_url('debt_manager_app/get_location_user') ?>"
										  method="get"
										  style="width: 100%;">
										<div class="col-lg-3">
											<div class="">
												<select type="email" name="location" class="form-control"
														id="idUserDebt">
													<option value="">Chọn nhân viên</option>
													<?php foreach ($debtEmploy as $value) { ?>
														<option <?php echo $getId === $value->id ? 'selected' : '' ?>
																value="<?php echo $value->id; ?>"><?php echo $value->email; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-2 text-right">
											<button style="background-color: #18d102;" type="submit"
													class="btn btn-primary w-100"><i
														aria-hidden="true"></i>&nbsp; Xem vị trí gần nhất
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<?php if (!empty($location)): ?>
			<div class="col-12 col-md-8 mb-3">
				<div class="item">
					<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDU6vwuTA_eC2NKb0IuDJpa2XmrypkTSvA&q=<?php echo $location[0]->latitude; ?>,<?php echo $location[0]->longitude; ?>"
							width="1000" height="500" frameborder="0" style="border:0;" allowfullscreen=""
							aria-hidden="false" tabindex="0"></iframe>
				</div>
			</div>
		<?php else : ?>
			<div>
				<table>
					<tr>
						<td>Không có dữ liệu</td>
					</tr>
				</table>
			</div>
		<?php endif; ?>
	</div>
</div>

