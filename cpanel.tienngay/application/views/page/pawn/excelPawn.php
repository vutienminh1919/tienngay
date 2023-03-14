<div class="right_col" role="main" style="min-height: 1160px;">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Theo dõi hợp đồng NVKD
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">Theo dõi hợp đồng NVKD</a>
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
									<form action="<?php echo base_url('aSPawnDetail/process') ?>" method="get"
										  style="width: 100%;">
										<div class="col-lg-3">
											<div class="">
												<select type="email" name="createBy" class="form-control">
													<option value="">Chọn email nhân viên </option>
													<?php foreach ($users as $user) : ?>
														<?php if (!empty($user->email)) : ?>
															<option><?php echo $user->email ?></option>
														<?php endif; ?>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-lg-2 text-right">
											<button style="background-color: #18d102;" type="submit"
													class="btn btn-primary w-100"><i class="fa fa-file-excel-o"
																					 aria-hidden="true"></i>&nbsp; Xuất
												excel
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
	</div>
</div>
<script>
	$('select[name="createBy"]').selectize({
		create: false,
		valueField: 'code',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
</script>
