<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "tai-san";
$property = !empty($_GET['property']) ? $_GET['property'] : "XM";
$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
$hang_xe_khau_hao = !empty($_GET['hang_xe_khau_hao']) ? $_GET['hang_xe_khau_hao'] : '';
$phan_khuc_khau_hao = !empty($_GET['phan_khuc_khau_hao']) ? $_GET['phan_khuc_khau_hao'] : '';
$phan_khuc_tai_san = !empty($_GET['phan_khuc_tai_san']) ? $_GET['phan_khuc_tai_san'] : '';
$loai_xe_tai_san = !empty($_GET['loai_xe_tai_san']) ? $_GET['loai_xe_tai_san'] : '';
$nam_san_xuat_tai_san = !empty($_GET['nam_san_xuat_tai_san']) ? $_GET['nam_san_xuat_tai_san'] : '';
$hang_xe_tai_san = !empty($_GET['hang_xe_tai_san']) ? $_GET['hang_xe_tai_san'] : '';
$model_tai_san = !empty($_GET['model_tai_san']) ? $_GET['model_tai_san'] : '';
?>
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
								Định giá tài sản
							</span>
						</div>
					</div>
					<div class="col-xs-4 text-right">
						<select id="select_asset" class="sellect options" name="property">
							<option value="XM" <?php echo ($property == 'XM') ? 'selected' : '' ?>>Xe máy</option>
							<option value="OTO" <?php echo ($property == 'OTO') ? 'selected' : '' ?>>Ô tô</option>
						</select>
						<input type="hidden" value="<?php echo $tab ?>" name="tab">
					</div>
				</div>
			</div>
			<div class="middle table_tabs">
				<div class="clicked nav_tabs_vertical nav tabs ">
					<ul id="myTab1" class="nav nav-tabs bar_tabs left mobiles" role="tablist">
						<li role="presentation" class="<?= ($tab == 'khau-hao') ? 'active text-active' : '' ?> ">
							<a href="<?php echo base_url() ?>property?tab=khau-hao&property=<?= $property ?>"
							   id="khau-hao-tabb"
							   aria-expanded="true">Khấu hao tài
								sản</a>
						</li>
						<li role="presentation" class="<?= ($tab == 'tai-san') ? 'active text-active' : '' ?> "><a
									href="<?php echo base_url() ?>property?tab=tai-san&property=<?= $property ?>"
									id="tai-san-tabb"
									aria-expanded="false"> Danh sách tài sản </a>
						</li>
						<li role="presentation" class="
						<?= ($tab == 'lich-su') ? 'active text-active' : '' ?> "><a
									href="<?php echo base_url() ?>property?tab=lich-su&property=<?= $property ?>"
									id="lich-su-tabb"
									aria-expanded="false"> Lịch sử cập nhật</a>
						</li>
						<li role="presentation"
							class="<?= ($tab == 'phe-duyet-khau-hao') ? 'active text-active' : '' ?> " <?= (in_array('bo-phan-dinh-gia', $groupRoles) || in_array('truong-bo-phan-phe-duyet', $groupRoles)) ? '' : 'style="display:none"' ?> >
							<a
									href="<?php echo base_url() ?>property?tab=phe-duyet-khau-hao&property=<?= $property ?>"
									id="phe-duyet-khau-hao-tabb"
									aria-expanded="false"> Danh sách đang chờ phê duyệt khấu hao<span> (</span><span
										class="text-danger"><?= $total_pending_khau_hao ?></span><span>)</span></a>
						</li>
						<li role="presentation"
							class="<?= ($tab == 'phe-duyet-tai-san') ? 'active text-active' : '' ?> " <?= (in_array('bo-phan-dinh-gia', $groupRoles) || in_array('truong-bo-phan-phe-duyet', $groupRoles)) ? '' : 'style="display:none"' ?>>
							<a
									href="<?php echo base_url() ?>property?tab=phe-duyet-tai-san&property=<?= $property ?>"
									id="phe-duyet-tai-san-tabb"
									aria-expanded="false"> Danh sách đang chờ phê duyệt tài sản <span> (</span><span
										class="text-danger"><?= $total_pending_property ?></span><span>)</span></a>
						</li>
					</ul>
				</div>
				<div class="tab-contents">
					<!-- tabs1 -->
					<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'khau-hao') ? 'active' : '' ?>"
						 id="khau-hao"
						 aria-labelledby="khau-hao-tab">
						<?php if ($tab == 'khau-hao') { ?>
							<div class="row">
								<div class="col-md-6 col-sx-12 text-left btn_list_filter">
									<div class="float-left" id="btn-confirm-khau-hao" style="display: none">
										<button type="button" class="btn btn-no-border btn-danger"
												id="remove-khau-hao">
											<i class="fa fa-remove" style="font-size: 21px"></i> &nbsp;
											Xóa
										</button>
										<button type="button" class="btn btn-no-border btn-light"
												id="cancel-remove-khau-hao">
											<i class="fa fa-ban" style="font-size: 21px"></i> &nbsp;
											Hủy
										</button>
									</div>
								</div>
								<div class="col-md-6 col-sx-12 btn_list_filter text-right">
									<div class="button_functions">
										<div class="dropdown">
											<button class="btn btn-secondary btn-success dropdown-toggle btn-func"
													type="button"
													data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Chức năng &nbsp<i class="fa fa-caret-down "></i>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a id="btn_add_dep" class="dropdown-item" href="#">Thêm khấu hao</a>
											</div>
										</div>
									</div>
									<div class="button_functions btn-fitler">
										<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
											<i class="fa fa-filter"></i>
										</button>
										<div class="dropdown-menu drop_select">
											<select id="sellect-car_company" class="limit_on_page"
													name="hang_xe_khau_hao">
												<option value="">Chọn hãng xe</option>
												<?php foreach ($main_depreciation as $depreciation) : ?>
													<option value="<?php echo $depreciation ?>"><?php echo strtoupper($depreciation) ?></option>
												<?php endforeach; ?>
											</select>
											<select id="sellect-segment" class="limit_on_page"
													name="phan_khuc_khau_hao">
												<option value="" selected="">Chọn phân khúc</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="C">C</option>
												<option value="D">D</option>
												<option value="XT">XT</option>
												<option value="XK">XK</option>
											</select>
											<button type="button" class="btn btn-outline-success"
													id="search_tab_khau_hao">
												Tìm kiếm
											</button>
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
								<table id="" class="table table-striped">
									<thead>
									<tr style="text-align: center">
										<th style="text-align: center">
											<input type="checkbox" name="" value=""
												   style="filter: invert(1%) hue-rotate(290deg) brightness(1);"
												   class=""
												   id="selectAll_khau_hao">
										</th>
										<th style="text-align: center">STT</th>
										<th style="text-align: center">Hình thức</th>
										<?php if ($property == 'XM'): ?>
											<th style="text-align: center">Loại xe</th>
										<?php endif; ?>
										<th style="text-align: center">Hãng xe</th>
										<th style="text-align: center">Số năm sử dụng</th>
										<th style="text-align: center">Phân khúc</th>
										<th style="text-align: center">Giảm trừ tiêu chuẩn</th>
										<?php if (!empty($propertys[0]) && count($propertys[0]->khau_hao) > 0) : ?>
											<?php foreach ($propertys[0]->khau_hao as $v) : ?>
												<th style="text-align: center"><?php echo $v->name ?></th>
											<?php endforeach; ?>
										<?php endif; ?>
										<th style="text-align: center">Tổng giảm trừ</th>
									</tr>
									</thead>
									<tbody align="center">
									<?php foreach ($propertys as $key => $value) : ?>
										<tr>
											<td><input class="form-check-input khauHaoCheckBox checkbox"
													   type="checkbox"
													   name="khau_hao[]"
													   value="<?= $value->_id->{'$oid'} ?>"></td>
											<td><?php echo ++$key + $per_page ?></td>
											<td><?php echo $property == 'XM' ? '<i class="fa fa-motorcycle "></i>' : '<i class="fa fa-car"></i>' ?></td>
											<?php if ($property == 'XM'): ?>
												<td><?php echo type_property($value->type_property) ?></td>
											<?php endif; ?>
											<td><?php echo $value->name_property ?></td>
											<td><?php echo $value->year ?></td>
											<td><?php echo $value->phan_khuc ?></td>
											<td><?php echo $value->giam_tru_tieu_chuan . ' %' ?></td>
											<?php if (!empty($propertys[0]) && count($value->khau_hao) > 0) : ?>
												<?php $tong_giam_tru = 0 ?>
												<?php foreach ($value->khau_hao as $item) : ?>
													<?php $tong_giam_tru += $item->price ?>
													<td style="text-align: center"><?php echo $item->price . ' %' ?></td>
												<?php endforeach; ?>
												<td><?php echo ($value->giam_tru_tieu_chuan + $tong_giam_tru) . ' %' ?></td>
											<?php endif; ?>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<div>
								<nav class="text-right">
									<?php echo $pagination ?>
								</nav>
							</div>
						<?php } ?>
					</div>
					<!-- tabs2 -->
					<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'tai-san') ? 'active' : '' ?>"
						 id="tai-san"
						 aria-labelledby="tai-san-tab">
						<?php if ($tab == 'tai-san') : ?>
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
												   href="<?= base_url() ?>property/excel_property?property=<?= $property . '&tab=' . $tab . '&phan_khuc_tai_san=' . $phan_khuc_tai_san . '&loai_xe_tai_san=' . $loai_xe_tai_san . '&nam_san_xuat_tai_san=' . $nam_san_xuat_tai_san
												   . '&hang_xe_tai_san=' . $hang_xe_tai_san . '&model_tai_san=' . $model_tai_san ?>">Xuất
													Excel</a>
												<button class="btn btn-secondary btn-success dropdown-toggle btn-func"
														type="button"
														data-toggle="dropdown" aria-haspopup="true"
														aria-expanded="false">
													Chức năng &nbsp<i class="fa fa-caret-down "></i>
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" href="#" data-toggle="modal"
													   data-target="#add_property">Upload tài sản</a>
												</div>
											</div>
										</div>
										<div class="button_functions btn-fitler_tab2">
											<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
												Tìm kiếm <i class="fa fa-filter"></i>
											</button>
											<div class="dropdown-menu drop_select_tab2">
												<select id="sellect-segment_tabs2" class="limit_on_page"
														name="phan_khuc_tai_san">
													<option value="" selected="">Chọn phân khúc</option>
													<option value="A">A</option>
													<option value="B">B</option>
													<option value="C">C</option>
													<option value="D">D</option>
													<option value="XT">XT</option>
													<option value="XK">XK</option>
												</select>
												<select id="sellect-Range" class="limit_on_page" name="loai_xe_tai_san">
													<option value="" selected="">Loại xe</option>
													<?php if ($property == 'XM'): ?>
														<?php foreach (type_property() as $n => $g) : ?>
															<option value="<?php echo $n ?>"><?php echo $g ?></option>
														<?php endforeach; ?>
													<?php else : ?>
														<option value="AT">AT</option>
														<option value="MT">MT</option>
													<?php endif; ?>
												</select>
												<input id="sellect-Year" class="limit_on_page"
													   name="nam_san_xuat_tai_san" type="number"
													   placeholder="năm sản xuất">
												<select id="sellect-type" class="limit_on_page hang_xe_tai_san"
														name="hang_xe_tai_san">
													<option value="" selected="">Hãng xe</option>
													<?php foreach ($main_property as $mp) : ?>
														<option value="<?php echo $mp->_id->{'$oid'} ?>"><?php echo $mp->name ?></option>
													<?php endforeach; ?>
												</select>
												<select id="sellect-Model" class="limit_on_page model_tai_san"
														name="model_tai_san">
													<option value="" selected="">Model</option>
												</select>

												<button type="button" class="btn btn-outline-success"
														id="search_tab_tai_san">
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
											<th style="text-align: center">
												<input type="checkbox" name="" value=""
													   style="filter: invert(1%) hue-rotate(290deg) brightness(1);"
													   class=""
													   id="selectAll">
											</th>
											<th style="text-align: center">STT</th>
											<th style="text-align: center">Hình thức</th>
											<th style="text-align: center">Năm sản xuất</th>
											<th style="text-align: center">Loại xe</th>
											<th style="text-align: center">Phân khúc</th>
											<th style="text-align: center">Hãng</th>
											<th style="text-align: center">Model</th>
											<?php if ($property == 'OTO'): ?>
												<th style="text-align: center">Xuất xứ</th>
												<th style="text-align: center">Bản Xăng/Dầu</th>
											<?php endif; ?>
											<th style="text-align: center">Giá đề xuất</th>
											<th style="text-align: right"></th>
										</tr>
										</thead>
										<tbody align="center">
										<?php foreach ($propertys as $key => $value) : ?>
											<tr>
												<td><input class="form-check-input taiSanCheckBox checkbox"
														   type="checkbox"
														   name="tai_san[]"
														   value="<?= $value->_id->{'$oid'} ?>"></td>
												<td><?php echo ++$key + $per_page ?></td>
												<td><?php echo $property == 'XM' ? '<i class="fa fa-motorcycle "></i>' : '<i class="fa fa-car"></i>' ?></td>
												<td><?php echo $value->year_property ?></td>
												<td>
													<?php if ($property == 'XM'): ?>
														<?php echo type_property($value->type_property) ?>
													<?php else: ?>
														<?php echo $value->type_property ?>
													<?php endif; ?>
												</td>
												<td><?php echo $value->phan_khuc ?></td>
												<td><?php echo $value->main_data ?></td>
												<td><?php echo $value->name ?></td>
												<?php if ($property == 'OTO'): ?>
													<td><?php echo $value->xuat_xu ?></td>
													<td><?php echo $value->ban_xang_dau ?></td>
												<?php endif; ?>
												<td><?php echo number_format($value->price) ?></td>
												<td>
													<div class="dropdown" style="display:inline-block">
														<button class="btn btn-success btn-sm dropdown-toggle"
																type="button"
																title="Chức Năng"
																data-toggle="dropdown">
															<i class="fa fa-cogs"></i>
															<span class="caret"></span></button>
														<ul class="dropdown-menu dropdown-menu-right">
															<!--											<li><a href="#"><i class="fa fa-pencil-square-o"></i> Sửa thông tin</a></li>-->
															<li><a id="details-show-info__id__"
																   data-id="<?php echo $value->_id->{'$oid'} ?>"
																   data-type="<?php echo $property ?>"
																   class="dropdown-item show_info_btn_chose"
																   href="javascript:(0)">Xem
																	thông
																	tin</a></li>
														</ul>
													</div>
												</td>
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
					<!-- tabs3 -->
					<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'lich-su') ? 'active' : '' ?>"
						 id="lich-su"
						 aria-labelledby="lich-su-tab">
						<?php if ($tab == 'lich-su') { ?>
							<div class="btn_list_filter text-right">
								<div class="button_functions btn-fitler_tab3">
									<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
										<i class="fa fa-filter">Tìm kiếm</i>
									</button>
									<div class="dropdown-menu drop_select_tab3">
										<input type="text" name="hang_xe_lich_su" class="limit_on_page" id="hang_xe_lich_su" placeholder="Hãng xe">
										<input type="number" name="nam_lich_su" class="limit_on_page" id="nam_lich_su" placeholder="Năm sản xuất">
										<input type="text" name="name_lich_su" class="limit_on_page" id="name_lich_su" placeholder="Tên tài sản">
										<select id="phan_khuc_lich_su" name="phan_khuc_lich_su" class="limit_on_page">
											<option value="" selected="">Phân khúc</option>
											<option value="A">A</option>
											<option value="B">B</option>
											<option value="C">C</option>
											<option value="D">D</option>
											<option value="XT">XT</option>
											<option value="XK">XK</option>
										</select>
										<select id="loai_xe_lich_su" name="loai_xe_lich_su" class="limit_on_page">
											<option value="" selected="">Loại xe</option>
											<?php if ($property == 'XM') : ?>
												<?php foreach (type_property() as $n => $g) : ?>
													<option value="<?php echo $n ?>"><?php echo $g ?></option>
												<?php endforeach; ?>
											<?php else : ?>
											<option value="AT">AT</option>
											<option value="MT">MT</option>
											<?php endif; ?>
										</select>
										<button type="button" class="btn btn-outline-success" id="search_tab_lich_su">Tìm kiếm</button>
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<table id="" class="table table-striped">
									<thead>
									<tr style="text-align: center">
										<th style="text-align: center">Thời gian</th>
										<th style="text-align: center">Tên tài sản</th>
										<th style="text-align: center">Người gửi yêu cầu</th>
										<th style="text-align: center">Người thực hiện</th>
										<th style="text-align: center;">Trạng thái</th>
										<th style="text-align: right"></th>
									</tr>
									</thead>
									<tbody align="center">
									<?php foreach ($log as $key => $value) : ?>
										<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
											<td><?= date('d-m-y H:i:s', $value->created_at) ?></td>
											<td><?= $value->data->str_name ?></td>
											<td><?= $value->requested_by ?></td>
											<td><?= $value->created_by ?></td>
											<td><?= status_history_property($value->type) ?></td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<div>
								<nav class="text-right">
									<?php echo $pagination ?>
								</nav>
							</div>
						<?php } ?>
					</div>
					<!-- tabs4 ( phê duyệt khấu hao ) -->
					<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'phe-duyet-khau-hao') ? 'active' : '' ?>"
						 id="phe-duyet-khau-hao"
						 aria-labelledby="khau-hao-tab">
						<?php if ($tab == 'phe-duyet-khau-hao') { ?>
							<div class="row">
								<div class="col-md-6 col-sx-12 text-left btn_list_filter">
									<div class="float-left" id="btn-confirm-phe-duyet-khau-hao" style="display: none">
										<button type="button" class="btn btn-no-border btn-success"
												id="confirm-phe-duyet-khau-hao">
											<i class="fa fa-check" style="font-size: 21px"></i> &nbsp;
											Phê duyệt
										</button>
										<button type="button" class="btn btn-no-border btn-danger"
												id="remove-phe-duyet-khau-hao">
											<i class="fa fa-remove" style="font-size: 21px"></i> &nbsp;
											Từ chối duyệt
										</button>
										<button type="button" class="btn btn-no-border btn-light"
												id="cancel-remove-phe-duyet-khau-hao">
											<i class="fa fa-ban" style="font-size: 21px"></i> &nbsp;
											Hủy
										</button>
									</div>
								</div>
								<div class="col-md-6 col-sx-12 btn_list_filter text-right">
									<div class="button_functions">
										<div class="dropdown">
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a id="btn_add_dep" class="dropdown-item" href="#">Thêm khấu hao</a>
											</div>
										</div>
									</div>
									<div class="button_functions btn-fitler_tab4">
										<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
											<i class="fa fa-filter"></i>
										</button>
										<div class="dropdown-menu drop_select_tab4">
											<select id="sellect-car_company" class="limit_on_page"
													name="hang_xe_phe_duyet_khau_hao">
												<option value="">Chọn hãng xe</option>
												<?php foreach ($main_depreciation as $depreciation) : ?>
													<option value="<?php echo $depreciation ?>"><?php echo strtoupper($depreciation) ?></option>
												<?php endforeach; ?>
											</select>
											<select id="sellect-segment_tabs4" class="limit_on_page"
													name="phan_khuc_phe_duyet_khau_hao">
												<option value="" selected="">Chọn phân khúc</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="C">C</option>
												<option value="D">D</option>
												<option value="XT">XT</option>
												<option value="XK">XK</option>
											</select>
											<button type="button" class="btn btn-outline-success"
													id="search_tab_phe_duyet_khau_hao">
												Tìm kiếm
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<div>
									<h4 class="text-success">Hiển thị (<span
												class="text-danger"><?php echo !empty($total_rows_approve) ? $total_rows_approve : 0 ?></span>)
										kết quả</h4>
								</div>
								<hr>
								<table id="" class="table table-striped">
									<thead>
									<tr style="text-align: center">
										<th style="text-align: center" rowspan="2">
											<input type="checkbox" name="" value=""
												   style="filter: invert(1%) hue-rotate(290deg) brightness(1);"
												   class=""
												   id="selectAll_phe_duyet_khau_hao" <?= in_array('truong-bo-phan-phe-duyet', $groupRoles) ? "" : "hidden" ?>>
										</th>
										<th style="text-align: center" rowspan="2">STT</th>
										<th style="text-align: center" rowspan="2">Hình thức</th>
										<?php if ($property == 'XM'): ?>
											<th style="text-align: center" rowspan="2">Loại xe</th>
										<?php endif; ?>
										<th style="text-align: center" rowspan="2">Hãng xe</th>
										<th style="text-align: center" rowspan="2">Số năm sử dụng</th>
										<th style="text-align: center" rowspan="2">Phân khúc</th>
										<th style="text-align: center" colspan="2">Giảm trừ tiêu chuẩn</th>
										<?php if ($property == "OTO"): ?>
											<th style="text-align: center" colspan="3">Giảm trừ cũ</th>
											<th style="text-align: center" colspan="3">Giảm trừ mới</th>
										<?php endif; ?>
										<?php if ($property == "XM") : ?>
											<th style="text-align: center" colspan="3">Giảm trừ cũ</th>
											<th style="text-align: center" colspan="3">Giảm trừ mới</th>
										<?php endif; ?>
										<th style="text-align: center" colspan="2">Tổng giảm trừ</th>
										<th style="text-align: center" rowspan="2">Trạng thái</th>
										<th style="text-align: center" rowspan="2">Yêu cầu</th>
									</tr>
									<tr>
										<?php if ($property == "XM") : ?>
<!--											<th style="text-align: center" class="text-danger">Cũ</th>-->
<!--											<th style="text-align: center">Mới</th>-->
<!--											<th style="text-align: center" class="text-danger">Cũ</th>-->
<!--											<th style="text-align: center">Mới</th>-->
<!--											<th style="text-align: center" class="text-danger">Cũ</th>-->
<!--											<th style="text-align: center">Mới</th>-->
											<th style="text-align: center" class="text-danger">Cũ</th>
											<th style="text-align: center">Mới</th>
											<th style="text-align: center">Biển Tỉnh</th>
											<th style="text-align: center">Dịch vụ</th>
											<th style="text-align: center">Công ty</th>
											<th style="text-align: center">Biển Tỉnh</th>
											<th style="text-align: center">Dịch vụ</th>
											<th style="text-align: center">Công ty</th>
											<th style="text-align: center" class="text-danger">Cũ</th>
											<th style="text-align: center">Mới</th>
											<th style="	text-align: center">Thời gian</th>
											<th style="	text-align: center">Người tạo</th>
										<?php elseif ($property === "OTO") : ?>
											<th style="text-align: center" class="text-danger">Cũ</th>
											<th style="text-align: center">Mới</th>
											<th style="text-align: center">Biển Tỉnh</th>
											<th style="text-align: center">Vận tải</th>
											<th style="text-align: center">Công ty</th>
											<th style="text-align: center">Biển Tỉnh</th>
											<th style="text-align: center">Vận tải</th>
											<th style="text-align: center">Công ty</th>
											<th style="text-align: center" class="text-danger">Cũ</th>
											<th style="text-align: center">Mới</th>
											<th style="	text-align: center">Thời gian</th>
											<th style="	text-align: center">Người tạo</th>
										<?php endif; ?>
									</tr>
									</thead>
									<tbody align="center">
									<?php foreach ($propertys_approve as $key => $value) : ?>
										<tr>
											<?php if ($value->status == 1): ?>
												<td><input class="form-check-input khauHaoPheDuyetCheckBox checkbox"
														   type="checkbox"
														   name="khau_hao[]"
														   value="<?= $value->_id->{'$oid'} ?>" <?= in_array('truong-bo-phan-phe-duyet', $groupRoles) ? "" : 'style="display:none"' ?>>
												</td>
											<?php else : ?>
												<td>
													<input class="form-check-input done_khauHaoPheDuyetCheckBox checkbox"
														   disabled
														   type="checkbox"
														   name="khau_hao[]"
														   value="<?= $value->_id->{'$oid'} ?>" <?= in_array('truong-bo-phan-phe-duyet', $groupRoles) ? "" : 'style="display:none"' ?>>
												</td>
											<?php endif; ?>

											<td><?php echo ++$key + $per_page ?></td>
											<td><?php echo $property == 'XM' ? '<i class="fa fa-motorcycle "></i>' : '<i class="fa fa-car"></i>' ?></td>
											<?php if ($property == 'XM'): ?>
												<td><?php echo type_property($value->type_property) ?></td>
											<?php endif; ?>
											<td><?php echo $value->name_property ?></td>
											<td><?php echo $value->year ?></td>
											<td><?php echo $value->phan_khuc ?></td>
											<td class="text-danger"><?php echo !empty($value->old) ? $value->old->giam_tru_tieu_chuan . ' %' : '' ?></td>
											<td><?php echo !empty($value->giam_tru_tieu_chuan) ? $value->giam_tru_tieu_chuan . ' %' : 0 ?></td>
											<?php if ($property == 'XM'): ?>
												<td class="text-danger"><?= !empty($value->old) && !empty($value->old->khau_hao[0]) ? $value->old->khau_hao[0]->price . ' %' : '' ?></td>
												<td class="text-danger"><?= !empty($value->old) && !empty($value->old->khau_hao[1]) ? $value->old->khau_hao[1]->price . ' %' : '' ?></td>
												<td class="text-danger"><?= !empty($value->old) && !empty($value->old->khau_hao[2]) ? $value->old->khau_hao[2]->price . ' %' : '' ?></td>
												<td><?= !empty($value->giam_tru_bien_tinh) ? $value->giam_tru_bien_tinh . ' %' : "" ?></td>
												<td><?= !empty($value->giam_tru_dich_vu) ? $value->giam_tru_dich_vu . ' %' : "" ?></td>
												<td><?= !empty($value->giam_tru_cong_ty) ? $value->giam_tru_cong_ty . ' %' : "" ?></td>
												<td class="text-danger"><?= !empty($value->old) ? ($value->old->giam_tru_tieu_chuan + $value->old->khau_hao[0]->price + $value->old->khau_hao[1]->price + $value->old->khau_hao[2]->price) . ' %' : '' ?></td>
												<td><?= ($value->giam_tru_tieu_chuan + $value->giam_tru_bien_tinh + $value->giam_tru_dich_vu + $value->giam_tru_cong_ty) . ' %' ?></td>
											<?php else : ?>
												<td class="text-danger"><?= !empty($value->old) ? $value->old->khau_hao[0]->price . ' %' : '' ?></td>
												<td class="text-danger"><?= !empty($value->old) ? $value->old->khau_hao[1]->price . ' %' : '' ?></td>
												<td class="text-danger"><?= !empty($value->old) ? $value->old->khau_hao[2]->price . ' %' : '' ?></td>
												<td><?= !empty($value->giam_tru_bien_tinh) ? $value->giam_tru_bien_tinh . ' %' : "" ?></td>
												<td><?= !empty($value->giam_tru_xe_van_tai) ? $value->giam_tru_xe_van_tai . ' %' : "" ?></td>
												<td><?= !empty($value->giam_tru_xe_cong_ty) ? $value->giam_tru_xe_cong_ty . ' %' : "" ?></td>
												<td class="text-danger"><?= !empty($value->old) ? ($value->old->giam_tru_tieu_chuan + $value->old->khau_hao[0]->price + $value->old->khau_hao[1]->price + $value->old->khau_hao[2]->price) . ' %' : '' ?></td>
												<td><?= ($value->giam_tru_tieu_chuan + $value->giam_tru_bien_tinh + $value->giam_tru_xe_van_tai + $value->giam_tru_xe_cong_ty) . ' %' ?></td>
											<?php endif; ?>
											<?php if ($value->status == 1): ?>
												<td>
													<span class="label label-warning"><?= status_property($value->status) ?></span>
												</td>
											<?php elseif ($value->status == 2): ?>
												<td>
													<span class="label label-success"><?= status_property($value->status) ?></span>
												</td>
											<?php else: ?>
												<td>
													<span class="label label-danger"><?= status_property($value->status) ?></span>
												</td>
											<?php endif; ?>
											<td>
												<?php if ($value->type == "create") : ?>
													<span class="label label-success">Thêm mới</span>
												<?php else: ?>
													<span class="label label-primary">Cập nhật</span>
												<?php endif; ?>
											</td>
											<td><?= date('d/m/Y, H:i:s',$value->created_at) ?></td>
											<td><?= $value->created_by ?? "" ?></td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<div>
								<nav class="text-right">
									<?php echo $pagination ?>
								</nav>
							</div>
						<?php } ?>
					</div>

					<!--tabs5 ( phê duyệt tài sản )-->
					<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'phe-duyet-tai-san') ? 'active' : '' ?>"
						 id="phe-duyet-tai-san"
						 aria-labelledby="tai-san-tab">
						<?php if ($tab == 'phe-duyet-tai-san') : ?>
							<div class="row">
								<div class="col-md-6 col-sx-12 text-left btn_list_filter">
									<div class="float-left" id="btn-confirm-phe-duyet-tai-san" style="display: none">
										<button type="button" class="btn btn-no-border btn-success"
												id="confirm-phe-duyet-tai-san">
											<i class="fa fa-check" style="font-size: 21px"></i> &nbsp;
											Phê duyệt
										</button>
										<button type="button" class="btn btn-no-border btn-danger"
												id="remove-phe-duyet-tai-san">
											<i class="fa fa-remove" style="font-size: 21px"></i> &nbsp;
											Từ chối duyệt
										</button>
										<button type="button" class="btn btn-no-border btn-light"
												id="cancel-remove-phe-duyet-tai-san">
											<i class="fa fa-ban" style="font-size: 21px"></i> &nbsp;
											Hủy
										</button>
									</div>
								</div>
								<div class="col-md-6 col-sx-12 text-right">
									<div class="btn_list_filter">
										<div class="button_functions">
										</div>
										<div class="button_functions btn-fitler_tab5">
											<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
												Tìm kiếm
												<i class="fa fa-filter"></i>
											</button>
											<div class="dropdown-menu drop_select_tab5">
												<select id="sellect-segment_tabs5" class="limit_on_page"
														name="phan_khuc_phe_duyet_tai_san">
													<option value="" selected="">Chọn phân khúc</option>
													<option value="A">A</option>
													<option value="B">B</option>
													<option value="C">C</option>
													<option value="D">D</option>
													<option value="XT">XT</option>
													<option value="XK">XK</option>
												</select>
												<select id="sellect-Range" class="limit_on_page"
														name="loai_xe_phe_duyet_tai_san">
													<option value="" selected="">Loại xe</option>
													<?php if ($property == 'XM'): ?>
														<?php foreach (type_property() as $n => $g) : ?>
															<option value="<?php echo $n ?>"><?php echo $g ?></option>
														<?php endforeach; ?>
													<?php else : ?>
														<option value="AT">AT</option>
														<option value="MT">MT</option>
													<?php endif; ?>
												</select>
												<input id="sellect-Year" class="limit_on_page"
													   name="nam_san_xuat_phe_duyet_tai_san" type="number"
													   placeholder="năm sản xuất">
												<input id="sellect-type_phe_duyet" style="text-transform: capitalize;"
													   class="limit_on_page hang_xe_phe_duyet_tai_san"
													   name="hang_xe_phe_duyet_tai_san" placeholder="hãng xe tài sản">
												<input id="sellect-Model_phe_duyet"
													   class="limit_on_page model_phe_duyet_tai_san"
													   name="model_phe_duyet_tai_san" placeholder="model tài sản">
												<button type="button" class="btn btn-outline-success"
														id="search_tab_phe_duyet_tai_san">
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
												class="text-danger"><?php echo !empty($total_rows_approve) ? $total_rows_approve : 0 ?></span>)
										kết quả</h4>
								</div>
								<hr>
								<div>
									<table id="" class="table table-striped">
										<thead>
										<tr style="text-align: center">
											<th style="text-align: center">
												<input type="checkbox" name="" value=""
													   style="filter: invert(1%) hue-rotate(290deg) brightness(1);"
													   class=""
													   id="selectAll_phe_duyet_tai_san" <?= in_array('truong-bo-phan-phe-duyet', $groupRoles)? "" : 'hidden'?>>
											</th>
											<th style="text-align: center">STT</th>
											<th style="text-align: center">Hình thức</th>
											<th style="text-align: center">Năm sản xuất</th>
											<th style="text-align: center">Loại xe</th>
											<th style="text-align: center">Phân khúc</th>
											<th style="text-align: center">Hãng</th>
											<th style="text-align: center">Model</th>
											<?php if ($property == 'OTO'): ?>
												<th style="text-align: center">Xuất xứ</th>
												<th style="text-align: center">Bản Xăng/Dầu</th>
											<?php endif; ?>
											<th style="text-align: center">Giá đề xuất cũ</th>
											<th style="text-align: center">Giá đề xuất mới</th>
											<th style="text-align: center">Trạng thái</th>
											<th style="	text-align: center">Loại yêu cầu</th>
											<th style="	text-align: center">Thời gian</th>
											<th style="	text-align: center">Người tạo</th>
										</tr>
										</thead>
										<tbody align="center">
										<?php foreach ($propertys_approve as $key => $value) : ?>
											<tr>
												<?php if ($value->status == 1): ?>
													<td><input class="form-check-input pheDuyetTaiSanCheckBox checkbox"
															   type="checkbox"
															   name="tai_san[]"
															   value="<?= $value->_id->{'$oid'} ?>"
															   data-type="<?= $property ?>"
															   data-id="<?= $value->_id->{'$oid'} ?>"
															   data-year="<?= $value->year_property ?>"
															   data-price="<?= $value->price ?>"
															   data-phan-khuc="<?= $value->phan_khuc ?>"
															   data-main="<?= $value->main_data ?>"
															   data-type-property="<?= $value->type_property ?>"
															   data-model="<?= $value->name ?>"
																<?= in_array('truong-bo-phan-phe-duyet', $groupRoles) ? '' : 'style="display:none"' ?>
														>
													</td>
												<?php else: ?>
													<td>
														<input class="form-check-input done_pheDuyetTaiSanCheckBox checkbox"
															   disabled
															   type="checkbox"
															   name="tai_san[]"
															   value="<?= $value->_id->{'$oid'} ?>"
																<?= in_array('truong-bo-phan-phe-duyet', $groupRoles) ? '' : 'style="display:none"' ?>>
													</td>
												<?php endif ?>
												<td><?php echo ++$key + $per_page ?></td>
												<td><?php echo $property == 'XM' ? '<i class="fa fa-motorcycle "></i>' : '<i class="fa fa-car"></i>' ?></td>
												<td><?php echo $value->year_property ?></td>
												<td>
													<?php if ($property == 'XM'): ?>
														<?php echo type_property($value->type_property) ?>
													<?php else: ?>
														<?php echo $value->type_property ?>
													<?php endif; ?>
												</td>
												<td><?php echo $value->phan_khuc ?></td>
												<td><?php echo $value->car_company ?></td>
												<td><?php echo $value->name ?></td>
												<?php if ($property == 'OTO'): ?>
													<td><?php echo $value->xuat_xu ?></td>
													<td><?php echo $value->ban_xang_dau ?></td>
												<?php endif; ?>
												<td class="text-danger"><?php echo !empty($value->old) ? number_format((int)$value->old->price) : '' ?></td>
												<td><?= !empty(($value->price)) ? number_format($value->price) : "" ?></td>
												<?php if ($value->status == 1): ?>
													<td>
														<span class="label label-warning"><?= status_property($value->status) ?></span>
													</td>
												<?php elseif ($value->status == 2): ?>
													<td>
														<span class="label label-success"><?= status_property($value->status) ?></span>
													</td>
												<?php else: ?>
													<td>
														<span class="label label-danger"><?= status_property($value->status) ?></span>
													</td>
												<?php endif; ?>
												<td>
													<?php if ($value->type == "create") : ?>
														<span class="label label-success">Thêm mới</span>
													<?php else: ?>
														<span class="label label-primary">Cập nhật</span>
													<?php endif; ?>
												</td>
												<td><?= date('d/m/Y, H:i:s',$value->created_at) ?></td>
												<td><?= $value->created_by  ?? "" ?></td>
											</tr>
										<?php endforeach; ?>

										</tbody>
									</table>
								</div>

							</div>
							<div>
								<nav class="text-right">
									<?= $pagination ?>
								</nav>
							</div>
						<?php endif; ?>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>
<div class="modal fade" id="add_depreciation" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Thêm khấu hao <?php echo $property == 'XM' ? 'Xe máy' : 'Ôtô' ?>
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body ">
				<div class="form-group_popup">
					<div class="form_input">
						<label>Upload excel</label>
						<div class="form-group">
							<input type="file" name="import_khau_hao" class="form-control"
								   placeholder="sothing">
						</div>
					</div>
					<div class="company_send text-right">
						<a href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
						<?php if ($property == 'XM') : ?>
							<a href="javascript:void(0)" title="Xác nhận"
							   class="company_xn btn btn-success" id="import_khau_hao_xm">Xác nhận</a>
						<?php else: ?>
							<a href="javascript:void(0)" title="Xác nhận"
							   class="company_xn btn btn-success" id="import_khau_hao_oto">Xác nhận</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="minus_depreciation" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Thêm giảm trừ
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body ">
				<div class="form-group_popup">
					<div class="form_input">
						<label>Nhập tên<span style="color: red;">*</span></label>
						<input type="text" name="name" id="name_minus_dep" placeholder="Nhập tên"
							   class="form_input_fields">
					</div>
					<div class="form_input">
						<label>Upload excel</label>
						<input style="display: none;" type="file" name="file" id="file_nodal_tab2"
							   placeholder="Nhập file" class="form_input">
						<div class="sellect_files">
							<button onclick="document.getElementById('file_nodal_tab2').click()">Chọn tệp</button>
							<input type="text" name="file" id="file_tabs2"
								   onclick="document.getElementById('file_nodal_tab2').click()"
								   class="form_input_fields">
						</div>
					</div>
					<div class="company_send text-right">
						<a href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
						<a href="javascript:void(0)" title="Xác nhận" id="btn_xn_id-"
						   class="company_xn btn btn-success">Xác nhận</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_depreciation" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Thêm giảm trừ
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body ">
				<div class="form-group_popup">
					<div class="form_input">
						<div class="row">
							<div class="col-sm-6 text-left">
								Giảm trừ xe dịch vụ biển tỉnh
							</div>
							<div class="col-sm-6 text-right">
								<input class='aiz_switchery' type="checkbox" checked="checked" data-set='status'
									   data-id=""/>
							</div>
						</div>
					</div>
					<div class="company_send text-right">
						<a href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
						<a href="javascript:void(0)" title="Xác nhận" id="btn_xn_id-"
						   class="company_xn btn btn-success">Xác nhận</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="alert_delete_pro_choo" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="delete_property">
		<div class="content">
			<div class="popup_content">
				<h2>Xóa tài sản</h2>
				<p>Nếu xoá tài sản này, mọi lịch sử thay đổi của tài sản cũng sẽ bị xoá đi. Bạn chắc chắn xoá?</p>
			</div>
			<div class="popup_button">
				<div class="row">
					<div class="col-sm-6 text-left">
						<a href="javascript:(0)" title="hủy" class="company_close btn btn-secondary">Hủy</a>
					</div>
					<div class="col-sm-6 text-right">
						<a href="javascript:(0)" title="Xóa" id="" data-value="" data-id=""
						   class="btn btn-danger click_delete_pro">Xóa</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="show_info_item" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true"><!--modal chi tiết và yêu cầu chỉnh sửa tài sản -->
	<div class="modal-dialog">
		<div class="modal-content modal_info">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_tai_san" style="text-align: left">
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body_info">
				<div class="modal_body_top">
					<div class="listed">
						<h4>Thông tin xe</h4>
						<div class="row">
							<div class="col-sm-6">
								<p>Thông số tài sản: <strong class="dong_xe"></strong></p>
							</div>
							<div class="col-sm-6">
								<p>Năm sản xuất: <strong class="nam_san_xuat"></strong></p>
							</div>
							<input type="text" name="id_update" class=" id_update form_input" hidden/>
						</div>
					</div>
				</div>
				<div class="modal_body_middle">
					<div class="title">
						<h4>Cập nhật giá xe</h4>
						<p>
							Giá trị xe:
							<strong class="show_fe active gia_xe text-danger"></strong><br>
							<input type="text" name="price" class="price_edit display_none form_input" id="edit_id_"
								   value="" data-id=""/>
						</p>
						<p>
							Khấu hao tiêu chuẩn:
							<strong class="active khau_hao_tieu_chuan text-danger"></strong>
						</p>
						<i class="body_click_details fa fa-pencil-square-o"></i>
					</div>
					<div class="tabble_modal_body">
						<table class="table table-striped">
							<thead>
							<tr align="center">
								<td>#</td>
								<td>Giảm trừ</td>
								<td>Phần trăm giảm trừ</td>
							</tr>
							</thead>
							<tbody align="center" id="depreciations">
							</tbody>
						</table>
						<hr style="border-top: 1px solid #4a1717">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item active">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
								   aria-controls="home" aria-selected="true">Lịch sử tài sản</a>
							</li>
<!--							<li class="nav-item">-->
<!--								<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"-->
<!--								   aria-controls="profile" aria-selected="false">Lịch sử khấu hao</a>-->
<!--							</li>-->
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade active in" id="home" role="tabpanel" aria-labelledby="home-tab">
								<div id="table-wrapper">
									<div id="table-scroll">
										<table class="table table-striped">
											<thead>
											<tr align="center">
												<td>#</td>
												<td>Loại</td>
												<td>Giá tiền</td>
												<td>Thời gian</td>
											</tr>
											</thead>
											<tbody align="center" id="history_tai_san">
											</tbody>
										</table>
									</div>
								</div>
							</div>
<!--							<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">-->
<!--								<div id="table-wrapper">-->
<!--									<div id="table-scroll">-->
<!--										<table class="table table-striped">-->
<!--											<thead>-->
<!--											<tr align="center">-->
<!--												<td>#</td>-->
<!--												<td>Loại</td>-->
<!--												<td>Khấu hao tiêu chuẩn</td>-->
<!--												<td>Khấu trừ biển tỉnh</td>-->
<!--											</tr>-->
<!--											</thead>-->
<!--											<tbody align="center" id="history_khau_hao_tai_san">-->
<!--											</tbody>-->
<!--										</table>-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
						</div>
					</div>
				</div>
				<div class="modal_body_bottom">
					<div class="company_send text-right">
						<a style="margin-bottom: 10px;" href="javascript:void(0)" title="đóng"
						   class="company_close btn btn-secondary">Đóng</a>
						<a style="margin-bottom: 10px;" href="javascript:void(0)" title="đóng"
						   class="display_none Update_required btn btn-success">Yêu cầu cập nhập</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="show_history_info_item" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal_info">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_oto" style="text-align: left">
						Lịch sử thay đổi - Xe máy honda Airblade 125
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="list-source_data">
				<div class="scroll-data-top trigger sticky">
					<div class="list_load">
						<div class="list_items">
							<div class="items">
								<div class="dot_stick active">
									<span></span>
								</div>
								<div class="layout-items theme-icon-second items-type-defaults">
									<div class="text-right datecreate item__time_create">
										<span>15/07/2021 15:08:00</span>
									</div>
									<div class="layout_per__change taxonomy__items_show">
										<div class="items__performer">
											<div class="row">
												<div class="col-sm-6">
													<div class="items__inf__old">
														<div class="items__contents">
															<p>Người yêu cầu</p>
															<strong>nguyennv@tienngay.vn</strong>
														</div>
														<div class="items__contents">
															<p>Giá cũ</p>
															<strong>51.000.000đ</strong>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="items__inf__old">
														<div class="items__contents">
															<p>Người thực hiện</p>
															<strong>hongtx@tienngay.vn</strong>
														</div>
														<div class="items__contents">
															<p>Giá cũ</p>
															<strong>45.000.000đ</strong>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="items__table__inyear">
											<table class="table">
												<thead>
												<tr align="center">
													<td>
														STT
													</td>
													<td>
														Số năm
													</td>
													<td>
														Khấu hao cũ
													</td>
													<td>
														Khấu hao mới
													</td>
												</tr>
												</thead>
												<tbody>
												<tr align="center">
													<td>
														1
													</td>
													<td>
														1 năm
													</td>
													<td>

														15%
													</td>
													<td>

														20%
													</td>
												</tr>
												<tr align="center">
													<td>
														2
													</td>
													<td>
														2 năm
													</td>
													<td>

														20%
													</td>
													<td>

														25%
													</td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="both"></div>
							</div>
							<div class="items">
								<div class="dot_stick">
									<span></span>
								</div>
								<div class="layout-items theme-icon-second items-type-defaults">
									<div class="text-right datecreate item__time_create">
										<span>15/07/2021 15:08:00</span>
									</div>
									<div class="layout_per__change taxonomy__items_show">
										<div class="items__performer">
											<div class="row">
												<div class="col-sm-6">
													<div class="items__inf__old">
														<div class="items__contents">
															<p>Người yêu cầu</p>
															<strong>nguyennv@tienngay.vn</strong>
														</div>
														<div class="items__contents">
															<p>Giá cũ</p>
															<strong>51.000.000đ</strong>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="items__inf__old">
														<div class="items__contents">
															<p>Người thực hiện</p>
															<strong>hongtx@tienngay.vn</strong>
														</div>
														<div class="items__contents">
															<p>Giá cũ</p>
															<strong>45.000.000đ</strong>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="items__table__inyear">
											<table class="table">
												<thead>
												<tr align="center">
													<td>
														STT
													</td>
													<td>
														Số năm
													</td>
													<td>
														Khấu hao cũ
													</td>
													<td>
														Khấu hao mới
													</td>
												</tr>
												</thead>
												<tbody>
												<tr align="center">
													<td>
														1
													</td>
													<td>
														1 năm
													</td>
													<td>

														15%
													</td>
													<td>

														20%
													</td>
												</tr>
												<tr align="center">
													<td>
														2
													</td>
													<td>
														2 năm
													</td>
													<td>

														20%
													</td>
													<td>

														25%
													</td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="both"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-header">
				<div class="company_send text-right">
					<a href="javascript:void(0)" title="đóng" class="company_close btn btn-secondary">Đóng</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add_property" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h3 class="text-primary" style="text-align: left">
						Thêm tài sản <?php echo $property == 'XM' ? 'Xe máy' : 'Ôtô' ?>
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body ">
				<div class="form-group_popup">
					<div class="form_input">
						<label>Upload excel</label>
						<div class="form-group">
							<input type="file" name="import_tai_san" class="form-control"
								   placeholder="sothing">
						</div>
					</div>
					<div class="company_send text-right">
						<button type="button" class="company_close btn btn-secondary" data-dismiss="modal">Đóng</button>
						<?php if ($property == 'XM') : ?>
							<button type="button" class="btn btn-success" id="import_tai_san_xe_may">Xác nhận
							</button>
						<?php else: ?>
							<button type="button" class="btn btn-success" id="import_tai_san_o_to">Xác nhận
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--modal chi tiết phê duyệt tài sản -->
<div class="modal fade" id="show_info_item_phe_duyet" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal_info">
			<div class="modal-header">
				<div>
					<h3 class="text-primary ten_tai_san_phe_duyet" style="text-align: left">
					</h3>
				</div>
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body_info">
				<div class="modal_body_top">
					<div class="listed">
						<h4>Thông tin xe</h4>
						<div class="row">
							<div class="col-sm-6">
								<p>Thông số tài sản: <strong class="dong_xe_phe_duyet"></strong></p>
							</div>
							<div class="col-sm-6">
								<p>Năm sản xuất: <strong class="nam_san_xuat_phe_duyet"></strong></p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal_body_middle">
					<div class="title">
						<h4>Cập nhật giá xe</h4>
						<p>
							Giá trị xe:
							<strong class="show_fe active gia_xe_phe_duyet text-danger"></strong>
							<input type="text" name="price" class="price_phe_duyet_edit display_none form_input"
								   id="edit_phe_duyet_id_" value="" data-id=""/>
						</p>
						<p>
							Khấu hao tiêu chuẩn:
							<strong class="active khau_hao_tieu_chuan_phe_duyet text-danger"></strong>
						</p>
						<!--												<i class="body_click_details fa fa-pencil-square-o"></i>-->
					</div>
					<div class="tabble_modal_body">
						<table class="table table-striped">
							<thead>
							<tr align="center">
								<td>#</td>
								<td>Giảm trừ</td>
								<td>Phần trăm giảm trừ</td>
							</tr>
							</thead>
							<tbody align="center" id="depreciations_phe_duyet">
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal_body_bottom">
					<div class="company_send text-right">
						<a style="margin-bottom: 10px;" href="javascript:void(0)" title="đóng"
						   class="company_close btn btn-secondary">Đóng</a>
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
@media only screen and ( max-width :46.1875em) {
 .mobiles{
	 display:block;
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
<script src="<?php echo base_url(); ?>assets/js/property/new/index.js"></script>
<link href="<?php echo base_url('assets/') ?>/js/switchery/switchery.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>/js/switchery/switchery.min.js"></script>
<style>
	#btn-confirm-tai-san {
		display: none;
	}
	@media (max-width: 768px){
		.btn_list_filter {
     display: block;
}
	}
</style>
