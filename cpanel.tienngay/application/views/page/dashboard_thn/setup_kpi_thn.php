<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">

				<div class="row">
					<div class="col-xs-12 col-lg-1">
						<h2 style="font-weight: bold">Cài Đặt Kpi </h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<form class="form-inline" action="<?php echo base_url('dashboard_thn/setup_kpi_thn') ?>"
								  method="get" style="width: 100%">
								<div class="col-xs-12">
									<div class="row">
										<div class="col-lg-5">
											<label style="display: block;">Tìm kiếm KPI</label>
											<div class="input-group">
												<span class="input-group-addon">Tháng</span>
												<input type="month" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : date('Y-m') ?>">
											</div>
											<button type="submit" class="btn btn-primary" style="margin-bottom: 9px;"><i
													class="fa fa-search"
													aria-hidden="true"></i> <?php echo $this->lang->line('search') ?>
											</button>
										</div>
										<div class="col-lg-7 text-right">
											<div class="text-left" style="float: right">
												<label style="display: block;">Tạo KPI</label>
												<div class="input-group">
													<span class="input-group-addon">Tháng</span>
													<input type="month" name="fdate_export" class="form-control"
														   value="">
												</div>
												<button type="button" class="btn btn-primary" id="add_one_month_thn"
														style="margin-bottom: 9px;"><i class="fa fa-plus"
																					   aria-hidden="true"></i> Tạo Kpi
												</button>
											</div>

										</div>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="title_right  row">

						</div>
						<br>
						<div class="table-responsive">

							<ul class="nav tabs">
								<li data-tab="waitting_manager" class="aos-init aos-animate active" data-aos-delay="1500"
									data-offset="1500" data-aos-duration="1500" data-aos="fade-right">
									<a>
										<h3 class="qt_title" style="font-weight: bold">Trưởng phòng</h3>
									</a>
								</li>
								<li data-tab="waitting_leader_call" class="aos-init aos-animate in" data-aos-delay="1500"
									data-offset="1500" data-aos-duration="1500" data-aos="fade-right">
									<a>
										<h3 class="qt_title" style="font-weight: bold">Trưởng nhóm Call</h3>
									</a>
								</li>
								<li data-tab="waitting_leader_field" class="aos-init aos-animate in" data-aos-delay="1500"
									data-offset="1500" data-aos-duration="1500" data-aos="fade-right">
									<a>
										<h3 class="qt_title" style="font-weight: bold">Trưởng nhóm Field</h3>
									</a>
								</li>
								<li data-tab="return" class="aos-init aos-animate in" data-aos-delay="1500"
									data-offset="1500" data-aos-duration="1700" data-aos="fade-right">
									<a>
										<h3 class="qt_title" style="font-weight: bold">Nhóm Call</h3>
									</a>
								</li>
								<li data-tab="waitting" class="aos-init aos-animate in" data-aos-delay="1500"
									data-offset="1500" data-aos-duration="1500" data-aos="fade-right">
									<a>
										<h3 class="qt_title" style="font-weight: bold">Nhóm Field(B1-B3)</h3>
									</a>
								</li>
								<li data-tab="waitting_b4" class="aos-init aos-animate in" data-aos-delay="1500"
									data-offset="1500" data-aos-duration="1500" data-aos="fade-right">
									<a>
										<h3 class="qt_title" style="font-weight: bold">Nhóm Field(B4+)</h3>
									</a>
								</li>


							</ul>

							<div class="tab-contents">
								<div id="return" class="tab-panel ">
									<table id="datatable-button" class="table table-striped datatablebutton">
										<thead>
										<tr>
											<th rowspan="2" class="center">STT</th>
											<th rowspan="2" class="center">Tháng</th>
											<th rowspan="2" class="center">Nhân viên</th>
											<th colspan="4" class="center">Tiêu chí đánh giá KPI</th>
										</tr>
										<tr role="row">
											<th class="center">Bucket</th>
											<th class="center">POS(vnđ)</th>
											<th class="center">KPIs giao(%)</th>
											<th class="center">Trọng số theo Bucket(%)</th>
										</tr>
										</thead>

										<tbody>
										<?php if (!empty($data_call_thn)): ?>
											<?php foreach ($data_call_thn as $key => $value): ?>
												<tr>
												<th style="line-height: 124px;" rowspan="5"><?= ++$key ?></th>
												<th style="line-height: 124px;"
													rowspan="5"><?= !empty($value->month) ? $value->month . '/' . $value->year : '' ?></th>
												<th style="line-height: 124px;"
													rowspan="5"><?= !empty($value->email_thn) ? $value->email_thn : '' ?></th>
												<?php foreach ($value->kpi as $key_1 => $item): ?>
													<tr role="row">
														<th style="color: red; font-weight: bold"><?= !empty($key_1) ? $key_1 : '' ?></th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->pos) ? $item->pos : 0 ?>"> <?= !empty($item->pos) ? number_format($item->pos) : 0 ?></div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->pos) ? $item->pos : 0 ?>'
																   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>
														</th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->kpis) ? $item->kpis : '' ?>"> <?= !empty($item->kpis) ? $item->kpis : '' ?>
																%
															</div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->kpis) ? $item->kpis : '' ?>'
																   id='kpis-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>

														</th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>"> <?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>
																%
															</div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>'
																   id='ts_bucket-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>

														</th>
													</tr>
												<?php endforeach; ?>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>


										</tbody>
									</table>
								</div>
								<div id="waitting" class="tab-panel  aos-init aos-animate" data-aos-delay="1500"
									 data-offset="1500" data-aos-duration="1600" data-aos="fade-up-down">
									<table id="datatable-button" class="table table-striped datatablebutton">
										<thead>
										<tr>
											<th rowspan="2" class="center">STT</th>
											<th rowspan="2" class="center">Tháng</th>
											<th rowspan="2" class="center">Nhân viên</th>
											<th colspan="4" class="center">Tiêu chí đánh giá KPI</th>
										</tr>
										<tr role="row">
											<th class="center">Bucket</th>
											<th class="center">POS(vnđ)</th>
											<th class="center">KPIs giao(%)</th>
											<th class="center">Trọng số theo Bucket(%)</th>
										</tr>
										</thead>
										<tbody>
										<?php if (!empty($data_field_thn)): ?>
											<?php foreach ($data_field_thn as $key => $value): ?>
												<tr>
												<th style="line-height: 124px;" rowspan="4"><?= ++$key ?></th>
												<th style="line-height: 124px;"
													rowspan="4"><?= !empty($value->month) ? $value->month . '/' . $value->year : '' ?></th>
												<th style="line-height: 124px;"
													rowspan="4"><?= !empty($value->email_thn) ? $value->email_thn : '' ?></th>
												<?php foreach ($value->kpi as $key_1 => $item): ?>
													<tr role="row">
														<th style="color: red; font-weight: bold"><?= !empty($key_1) ? $key_1 : '' ?></th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->pos) ? $item->pos : 0 ?>"> <?= !empty($item->pos) ? number_format($item->pos) : 0 ?></div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->pos) ? $item->pos : 0 ?>'
																   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>
														</th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->kpis) ? $item->kpis : '' ?>"> <?= !empty($item->kpis) ? $item->kpis : '' ?>
																%
															</div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->kpis) ? $item->kpis : '' ?>'
																   id='kpis-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>

														</th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>"> <?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>
																%
															</div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>'
																   id='ts_bucket-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>

														</th>
													</tr>
												<?php endforeach; ?>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>


										</tbody>
									</table>
								</div>
								<div id="waitting_b4" class="tab-panel  aos-init aos-animate" data-aos-delay="1500"
									 data-offset="1500" data-aos-duration="1600" data-aos="fade-up-down">
									<table id="datatable-button" class="table table-striped datatablebutton">
										<thead>
										<tr>
											<th rowspan="2" class="center">STT</th>
											<th rowspan="2" class="center">Tháng</th>
											<th rowspan="2" class="center">Nhân viên</th>
											<th colspan="4" class="center">Tiêu chí đánh giá KPI</th>
										</tr>
										<tr role="row">
											<th class="center">Bucket</th>
											<th class="center">POS(vnđ)</th>
											<th class="center">KPIs giao(%)</th>
											<th class="center">Trọng số theo Bucket(%)</th>
										</tr>
										</thead>
										<tbody>
										<?php if (!empty($data_field_b4)): ?>
											<?php foreach ($data_field_b4 as $key => $value): ?>
												<tr>
												<th style="line-height: 124px;" rowspan="6"><?= ++$key ?></th>
												<th style="line-height: 124px;"
													rowspan="6"><?= !empty($value->month) ? $value->month . '/' . $value->year : '' ?></th>
												<th style="line-height: 124px;"
													rowspan="6"><?= !empty($value->email_thn) ? $value->email_thn : '' ?></th>
												<?php foreach ($value->kpi as $key_1 => $item): ?>
													<tr role="row">
														<th style="color: red; font-weight: bold"><?= !empty($key_1) ? $key_1 : '' ?></th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->pos) ? $item->pos : 0 ?>"> <?= !empty($item->pos) ? number_format($item->pos) : 0 ?></div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->pos) ? $item->pos : 0 ?>'
																   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>
														</th>
														<?php if ($key_1 == 'B4'): ?>
															<th style="line-height: 124px;" rowspan="6">
																<div class='edit'
																	 data-status="<?= !empty($item->kpis) ? $item->kpis : '' ?>"> <?= !empty($item->kpis) ? $item->kpis : '' ?>
																	%
																</div>
																<input hidden type='number' class='txtedit'
																	   value='<?= !empty($item->kpis) ? $item->kpis : '' ?>'
																	   id='kpis-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>

															</th>
															<th style="line-height: 124px;" rowspan="6">
																<div class='edit'
																	 data-status="<?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>"> <?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>
																	%
																</div>
																<input hidden type='number' class='txtedit'
																	   value='<?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>'
																	   id='ts_bucket-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>

															</th>
														<?php endif; ?>
													</tr>

												<?php endforeach; ?>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>


										</tbody>
									</table>
								</div>
								<div id="waitting_manager" class="tab-panel  aos-init aos-animate active" data-aos-delay="1500"
									 data-offset="1500" data-aos-duration="1600" data-aos="fade-up-down">
									<table id="datatable-button" class="table table-striped datatablebutton">
										<thead>
										<tr>
											<th rowspan="2" class="center">STT</th>
											<th rowspan="2" class="center">Tháng</th>
											<th rowspan="2" class="center">Nhân viên</th>
											<th colspan="4" class="center">Tiêu chí đánh giá KPI</th>
										</tr>
										<tr role="row">
											<th class="center">Bucket</th>
											<th class="center">POS(vnđ)</th>
											<th class="center">KPIs giao(%)</th>
											<th class="center">Trọng số theo Bucket(%)</th>
										</tr>
										</thead>

										<tbody>
										<?php if (!empty($tbp_thn)): ?>
											<tr>
												<th rowspan="10"><div class="flex">1</div></th>
												<th rowspan="10"><div class="flex"><?= !empty($tbp_thn[0]->month) ? $tbp_thn[0]->month . '/' . $tbp_thn[0]->year : '' ?></div></th>
												<th rowspan="10"><div class="flex"><?= !empty($tbp_thn[0]->email_thn) ? $tbp_thn[0]->email_thn : '' ?></div></th>
											<tr role="row">
												<th style="color: red; font-weight: bold">B0</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B0->pos) ? $tbp_thn[0]->kpi->B0->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B0->pos) ? number_format($tbp_thn[0]->kpi->B0->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B0->pos) ? $tbp_thn[0]->kpi->B0->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B0'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B0->kpis) ? $tbp_thn[0]->kpi->B0->kpis : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B0->kpis) ? ($tbp_thn[0]->kpi->B0->kpis) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B0->kpis) ? $tbp_thn[0]->kpi->B0->kpis : 0 ?>'
														   id='kpis-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B0'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B0->ts_bucket) ? $tbp_thn[0]->kpi->B0->ts_bucket : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B0->ts_bucket) ? ($tbp_thn[0]->kpi->B0->ts_bucket) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B0->ts_bucket) ? $tbp_thn[0]->kpi->B0->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B0'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B1</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B1->pos) ? $tbp_thn[0]->kpi->B1->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B1->pos) ? number_format($tbp_thn[0]->kpi->B1->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B1->pos) ? $tbp_thn[0]->kpi->B1->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B1'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B1->kpis) ? $tbp_thn[0]->kpi->B1->kpis : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B1->kpis) ? ($tbp_thn[0]->kpi->B1->kpis) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B1->kpis) ? $tbp_thn[0]->kpi->B1->kpis : 0 ?>'
														   id='kpis-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B1'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B1->ts_bucket) ? $tbp_thn[0]->kpi->B1->ts_bucket : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B1->ts_bucket) ? ($tbp_thn[0]->kpi->B1->ts_bucket) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B1->ts_bucket) ? $tbp_thn[0]->kpi->B1->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B1'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B2</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B2->pos) ? $tbp_thn[0]->kpi->B2->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B2->pos) ? number_format($tbp_thn[0]->kpi->B2->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B2->pos) ? $tbp_thn[0]->kpi->B2->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B2'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B2->kpis) ? $tbp_thn[0]->kpi->B2->kpis : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B2->kpis) ? ($tbp_thn[0]->kpi->B2->kpis) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B2->kpis) ? $tbp_thn[0]->kpi->B2->kpis : 0 ?>'
														   id='kpis-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B2'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B2->ts_bucket) ? $tbp_thn[0]->kpi->B2->ts_bucket : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B2->ts_bucket) ? ($tbp_thn[0]->kpi->B2->ts_bucket) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B2->ts_bucket) ? $tbp_thn[0]->kpi->B2->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B2'/>
												</th>
											</tr>

											<tr role="row">
												<th style="color: red; font-weight: bold">B3</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B3->pos) ? $tbp_thn[0]->kpi->B3->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B3->pos) ? number_format($tbp_thn[0]->kpi->B3->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B3->pos) ? $tbp_thn[0]->kpi->B3->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B3'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B3->kpis) ? $tbp_thn[0]->kpi->B3->kpis : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B3->kpis) ? ($tbp_thn[0]->kpi->B3->kpis) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B3->kpis) ? $tbp_thn[0]->kpi->B3->kpis : 0 ?>'
														   id='kpis-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B3'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B3->ts_bucket) ? $tbp_thn[0]->kpi->B3->ts_bucket : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B3->ts_bucket) ? ($tbp_thn[0]->kpi->B3->ts_bucket) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B3->ts_bucket) ? $tbp_thn[0]->kpi->B3->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B3'/>
												</th>
											</tr>

											<tr role="row">
												<th style="color: red; font-weight: bold">B4</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B4->pos) ? $tbp_thn[0]->kpi->B4->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B4->pos) ? number_format($tbp_thn[0]->kpi->B4->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B4->pos) ? $tbp_thn[0]->kpi->B4->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B4'/>
												</th>
												<th style="line-height: 124px;" rowspan="6">
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B4->kpis) ? $tbp_thn[0]->kpi->B4->kpis : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B4->kpis) ? $tbp_thn[0]->kpi->B4->kpis : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B4->kpis) ? $tbp_thn[0]->kpi->B4->kpis : 0 ?>'
														   id='kpis-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B4'/>

												</th>
												<th style="line-height: 124px;" rowspan="6">

													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B4->ts_bucket) ? $tbp_thn[0]->kpi->B4->ts_bucket : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B4->ts_bucket) ? $tbp_thn[0]->kpi->B4->ts_bucket : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B4->ts_bucket) ? $tbp_thn[0]->kpi->B4->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B4'/>

												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B5</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B5->pos) ? $tbp_thn[0]->kpi->B5->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B5->pos) ? number_format($tbp_thn[0]->kpi->B5->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B5->pos) ? $tbp_thn[0]->kpi->B5->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B5'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B6</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B6->pos) ? $tbp_thn[0]->kpi->B6->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B6->pos) ? number_format($tbp_thn[0]->kpi->B6->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B6->pos) ? $tbp_thn[0]->kpi->B6->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B6'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B7</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B7->pos) ? $tbp_thn[0]->kpi->B7->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B7->pos) ? number_format($tbp_thn[0]->kpi->B7->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B7->pos) ? $tbp_thn[0]->kpi->B7->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B7'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B8</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($tbp_thn[0]->kpi->B8->pos) ? $tbp_thn[0]->kpi->B8->pos : 0 ?>"> <?= !empty($tbp_thn[0]->kpi->B8->pos) ? number_format($tbp_thn[0]->kpi->B8->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($tbp_thn[0]->kpi->B8->pos) ? $tbp_thn[0]->kpi->B8->pos : 0 ?>'
														   id='pos-<?= !empty($tbp_thn[0]->_id->{'$oid'}) ? $tbp_thn[0]->_id->{'$oid'} : '' ?>-B7'/>
												</th>
											</tr>


										<?php endif; ?>
										</tbody>
									</table>


								</div>

								<div id="waitting_leader_call" class="tab-panel  aos-init aos-animate" data-aos-delay="1500"
									 data-offset="1500" data-aos-duration="1600" data-aos="fade-up-down">
									<table id="datatable-button" class="table table-striped datatablebutton">
										<thead>
										<tr>
											<th rowspan="2" class="center">STT</th>
											<th rowspan="2" class="center">Tháng</th>
											<th rowspan="2" class="center">Nhân viên</th>
											<th colspan="4" class="center">Tiêu chí đánh giá KPI</th>
										</tr>
										<tr role="row">
											<th class="center">Bucket</th>
											<th class="center">POS(vnđ)</th>
											<th class="center">KPIs giao(%)</th>
											<th class="center">Trọng số theo Bucket(%)</th>
										</tr>
										</thead>
										<tbody>
										<?php if (!empty($leader_call)): ?>
											<?php foreach ($leader_call as $key => $value): ?>
												<tr>
												<th style="line-height: 124px;" rowspan="5"><?= ++$key ?></th>
												<th style="line-height: 124px;"
													rowspan="5"><?= !empty($value->month) ? $value->month . '/' . $value->year : '' ?></th>
												<th style="line-height: 124px;"
													rowspan="5"><?= !empty($value->email_thn) ? $value->email_thn : '' ?></th>
												<?php foreach ($value->kpi as $key_1 => $item): ?>
													<tr role="row">
														<th style="color: red; font-weight: bold"><?= !empty($key_1) ? $key_1 : '' ?></th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->pos) ? $item->pos : 0 ?>"> <?= !empty($item->pos) ? number_format($item->pos) : 0 ?></div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->pos) ? $item->pos : 0 ?>'
																   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>
														</th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->kpis) ? $item->kpis : '' ?>"> <?= !empty($item->kpis) ? $item->kpis : '' ?>
																%
															</div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->kpis) ? $item->kpis : '' ?>'
																   id='kpis-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>

														</th>
														<th>
															<div class='edit'
																 data-status="<?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>"> <?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>
																%
															</div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($item->ts_bucket) ? $item->ts_bucket : '' ?>'
																   id='ts_bucket-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= $key_1 ?>'/>

														</th>
													</tr>
												<?php endforeach; ?>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>


										</tbody>
									</table>
								</div>

								<div id="waitting_leader_field" class="tab-panel  aos-init aos-animate " data-aos-delay="1500"
									 data-offset="1500" data-aos-duration="1600" data-aos="fade-up-down">
									<table id="datatable-button" class="table table-striped datatablebutton">
										<thead>
										<tr>
											<th rowspan="2" class="center">STT</th>
											<th rowspan="2" class="center">Tháng</th>
											<th rowspan="2" class="center">Nhân viên</th>
											<th colspan="4" class="center">Tiêu chí đánh giá KPI</th>
										</tr>
										<tr role="row">
											<th class="center">Bucket</th>
											<th class="center">POS(vnđ)</th>
											<th class="center">KPIs giao(%)</th>
											<th class="center">Trọng số theo Bucket(%)</th>
										</tr>
										</thead>

										<tbody>
										<?php if (!empty($leader_field)): ?>
										<?php foreach ($leader_field as $key => $value): ?>
											<tr>
												<th rowspan="9"><div class="flex"><?= ++$key ?></div></th>
												<th rowspan="9"><div class="flex"><?= !empty($value->month) ? $value->month . '/' . $value->year : '' ?></div></th>
												<th rowspan="9"><div class="flex"><?= !empty($value->email_thn) ? $value->email_thn : '' ?></div></th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B1</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($leader_field[0]->kpi->B1->pos) ? $leader_field[0]->kpi->B1->pos : 0 ?>"> <?= !empty($leader_field[0]->kpi->B1->pos) ? number_format($leader_field[0]->kpi->B1->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($leader_field[0]->kpi->B1->pos) ? $leader_field[0]->kpi->B1->pos : 0 ?>'
														   id='pos-<?= !empty($leader_field[0]->_id->{'$oid'}) ? $leader_field[0]->_id->{'$oid'} : '' ?>-B1'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($leader_field[0]->kpi->B1->kpis) ? $leader_field[0]->kpi->B1->kpis : 0 ?>"> <?= !empty($leader_field[0]->kpi->B1->kpis) ? ($leader_field[0]->kpi->B1->kpis) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($leader_field[0]->kpi->B1->kpis) ? $leader_field[0]->kpi->B1->kpis : 0 ?>'
														   id='kpis-<?= !empty($leader_field[0]->_id->{'$oid'}) ? $leader_field[0]->_id->{'$oid'} : '' ?>-B1'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($leader_field[0]->kpi->B1->ts_bucket) ? $leader_field[0]->kpi->B1->ts_bucket : 0 ?>"> <?= !empty($leader_field[0]->kpi->B1->ts_bucket) ? ($leader_field[0]->kpi->B1->ts_bucket) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($leader_field[0]->kpi->B1->ts_bucket) ? $leader_field[0]->kpi->B1->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($leader_field[0]->_id->{'$oid'}) ? $leader_field[0]->_id->{'$oid'} : '' ?>-B1'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B2</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B2->pos) ? $value->kpi->B2->pos : 0 ?>"> <?= !empty($value->kpi->B2->pos) ? number_format($value->kpi->B2->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B2->pos) ? $value->kpi->B2->pos : 0 ?>'
														   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B2'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B2->kpis) ? $value->kpi->B2->kpis : 0 ?>"> <?= !empty($value->kpi->B2->kpis) ? ($value->kpi->B2->kpis) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B2->kpis) ? $value->kpi->B2->kpis : 0 ?>'
														   id='kpis-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B2'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B2->ts_bucket) ? $value->kpi->B2->ts_bucket : 0 ?>"> <?= !empty($value->kpi->B2->ts_bucket) ? ($value->kpi->B2->ts_bucket) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B2->ts_bucket) ? $value->kpi->B2->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B2'/>
												</th>
											</tr>

											<tr role="row">
												<th style="color: red; font-weight: bold">B3</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B3->pos) ? $value->kpi->B3->pos : 0 ?>"> <?= !empty($value->kpi->B3->pos) ? number_format($value->kpi->B3->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B3->pos) ? $value->kpi->B3->pos : 0 ?>'
														   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B3'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B3->kpis) ? $value->kpi->B3->kpis : 0 ?>"> <?= !empty($value->kpi->B3->kpis) ? ($value->kpi->B3->kpis) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B3->kpis) ? $value->kpi->B3->kpis : 0 ?>'
														   id='kpis-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B3'/>
												</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B3->ts_bucket) ? $value->kpi->B3->ts_bucket : 0 ?>"> <?= !empty($value->kpi->B3->ts_bucket) ? ($value->kpi->B3->ts_bucket) : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B3->ts_bucket) ? $value->kpi->B3->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B3'/>
												</th>
											</tr>

											<tr role="row">
												<th style="color: red; font-weight: bold">B4</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B4->pos) ? $value->kpi->B4->pos : 0 ?>"> <?= !empty($value->kpi->B4->pos) ? number_format($value->kpi->B4->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B4->pos) ? $value->kpi->B4->pos : 0 ?>'
														   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B4'/>
												</th>
												<th style="line-height: 124px;" rowspan="6">
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B4->kpis) ? $value->kpi->B4->kpis : 0 ?>"> <?= !empty($value->kpi->B4->kpis) ? $value->kpi->B4->kpis : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B4->kpis) ? $value->kpi->B4->kpis : 0 ?>'
														   id='kpis-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B4'/>

												</th>
												<th style="line-height: 124px;" rowspan="6">

													<div class='edit'
														 data-status="<?= !empty($value->kpi->B4->ts_bucket) ? $value->kpi->B4->ts_bucket : 0 ?>"> <?= !empty($value->kpi->B4->ts_bucket) ? $value->kpi->B4->ts_bucket : 0 ?>%</div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B4->ts_bucket) ? $value->kpi->B4->ts_bucket : 0 ?>'
														   id='ts_bucket-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B4'/>

												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B5</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B5->pos) ? $value->kpi->B5->pos : 0 ?>"> <?= !empty($value->kpi->B5->pos) ? number_format($value->kpi->B5->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B5->pos) ? $value->kpi->B5->pos : 0 ?>'
														   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B5'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B6</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B6->pos) ? $value->kpi->B6->pos : 0 ?>"> <?= !empty($value->kpi->B6->pos) ? number_format($value->kpi->B6->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B6->pos) ? $value->kpi->B6->pos : 0 ?>'
														   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B6'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B7</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B7->pos) ? $value->kpi->B7->pos : 0 ?>"> <?= !empty($value->kpi->B7->pos) ? number_format($value->kpi->B7->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B7->pos) ? $value->kpi->B7->pos : 0 ?>'
														   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B7'/>
												</th>
											</tr>
											<tr role="row">
												<th style="color: red; font-weight: bold">B8</th>
												<th>
													<div class='edit'
														 data-status="<?= !empty($value->kpi->B8->pos) ? $value->kpi->B8->pos : 0 ?>"> <?= !empty($value->kpi->B8->pos) ? number_format($value->kpi->B8->pos) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value->kpi->B8->pos) ? $value->kpi->B8->pos : 0 ?>'
														   id='pos-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-B7'/>
												</th>
											</tr>

										<?php endforeach; ?>
										<?php endif; ?>
										</tbody>
									</table>


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

<!--<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"-->
<!--	 aria-hidden="true">-->
<!--	<div class="modal-dialog modal-dialog-centered" role="document">-->
<!--		<div class="trongso">-->
<!--				<h2 class="text-success" style="font-weight: bold">Cài đặt trọng số</h2>-->
<!--			<div class="Nhomno">-->
<!--				<div class="box_b">-->
<!--					<label>Nhóm </label>-->
<!--					<label>Trọng số</label>-->
<!--				</div>-->
<!--				<div class="box_b">-->
<!--					<label>Nhóm  B0</label>-->
<!--					<div class="input_field_b">-->
<!--						<input type="text" name="input_b0" class="form-control" />-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="box_b">-->
<!--					<label>Nhóm  B1</label>-->
<!--					<div class="input_field_b">-->
<!--						<input type="text" name="input_b1" class="form-control" />-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="box_b">-->
<!--					<label>Nhóm  B2</label>-->
<!--					<div class="input_field_b">-->
<!--						<input type="text" name="input_b2" class="form-control" />-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="box_b">-->
<!--					<label>Nhóm  B3</label>-->
<!--					<div class="input_field_b">-->
<!--						<input type="text" name="input_b3" class="form-control" />-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="box_b">-->
<!--					<label>Nhóm  B4</label>-->
<!--					<div class="input_field_b">-->
<!--						<input type="text" name="input_b4" class="form-control" />-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="box_b">-->
<!--					<label>Nhóm  B5</label>-->
<!--					<div class="input_field_b">-->
<!--						<input type="text" name="input_b5" class="form-control" />-->
<!--					</div>-->
<!--				</div>-->
<!--				<button type="button" class="btn btn-primary" style="margin: 10px 0; width: 100%">Lưu lại</button>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<script>

</script>
<script src="<?php echo base_url(); ?>assets/js/dashboard_thn/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		// Show Input element
		$('.edit').click(function () {
			var status = $(this).data('status');
			console.log(status);

			$('.txtedit').hide();
			$(this).next('.txtedit').show().focus();
			$(this).hide();

		});

		// Save data
		$(".txtedit").on('focusout', function () {

			// Get edit id, field name and value
			var id = this.id;
			var split_id = id.split("-");
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var bucket = split_id[2];
			var value = $(this).val();

			// Hide Input element
			$(this).hide();

			// Hide and Change Text of the container with input elmeent
			$(this).prev('.edit').show();
			$(this).prev('.edit').text(numeral(value).format('0,0'));

			// Sending AJAX request
			$.ajax({
				// url: _url.base_url + 'kpi/update_gdv',
				url: _url.base_url + 'dashboard_thn/update_thn',
				type: 'post',
				data: {field: field_name, value: value, id: edit_id, bucket: bucket},
				success: function (response) {
					console.log('Save successfully');
				}
			});

		});


	});

</script>
<style type="text/css">
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
		border-bottom: 1px solid #ddd;
	}

	tbody tr th {
		text-align: center;
		font-weight: 300 !important;
	}

	.table {
		margin-bottom: 0;
	}

	ul.nav.tabs {
		display: flex;
		align-items: center;
		justify-content: left;
		border: none;
		border-bottom: 1px solid #e5e5e5;
		padding: 0;
		width: calc(100% - 265px);
	}

	ul.nav.tabs li a {
		display: block;
		text-decoration: unset;
		text-align: center;
		margin: 0;
		padding: 10px 5px 0;
		margin-bottom: 15px;
		margin-right: 15px;
		cursor: pointer;
	}

	ul.nav.tabs li.active a {
		border-bottom: 1px solid #0e9549;
	}

	ul.nav.tabs li a h3 {
		font-size: 15px;
		color: #8c8c8c;
	}

	ul.nav.tabs li.active a h3 {
		color: #0e9549;
	}

	.tab-panel {
		display: none;
	}

	.tab-panel.active {
		display: block;
	}

	.trongso {
		background: #fff;
		padding: 10px;
		border-radius: 10px;
	}

	.box_b {
		display: flex;
		justify-content: space-between;
		margin: 8px 0;
		align-items: center;
	}

	.box_b input {
		text-align: center;
	}
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
		position: relative;
	}

	.flex{
		display: flex;
		align-items: center;
		height: 100%;
		position: absolute;
		justify-content: center;
		width: 100%;
	}

	@media (min-width: 768px) {
		.modal-dialog {
			width: 400px;
		}
	}
</style>
<script type="text/javascript">
	$('ul.tabs li').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('ul.tabs li').removeClass('active');
		$('.tab-panel').removeClass('active');
		$(this).addClass('active');
		$("#" + tab_id).addClass('active');
	})
</script>
