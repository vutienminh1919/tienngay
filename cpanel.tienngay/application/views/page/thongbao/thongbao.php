<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<?php
$contract_id = !empty($_GET['id']) ? $_GET['id'] : "";
?>

<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

$notification_type = !empty($_GET['notification_type']) ? $_GET['notification_type'] : "";
$title = !empty($_GET['title']) ? $_GET['title'] : "";
$priority_level = !empty($_GET['priority_level']) ? $_GET['priority_level'] : "";
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row">

		<input type="hidden" id="contract_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>">

		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Danh sách thông báo</h2>
						<ul class="nav navbar-right panel_toolbox">

							<li>
								<div class="dropdown" style="display:inline-block">
									<button class="btn btn-success dropdown-toggle"
											onclick="$('#lockdulieu').toggleClass('show');">
										<span class="fa fa-filter"></span>
										Lọc dữ liệu
									</button>
									<form action="<?php echo base_url('notification/search') ?>" method="get">

										<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
											style="padding:15px;min-width:400px;">
											<li class="form-group">

												<div class="row">
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Từ:</label>
															<input type="date" name="fdate" class="form-control"
																   value="<?= !empty($fdate) ? $fdate : "" ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Đến:</label>
															<input type="date" name="tdate" class="form-control"
																   value="<?= !empty($tdate) ? $tdate : "" ?>">
														</div>
													</div>
												</div>
											</li>

											<li class="form-group">
												<select class="form-control" name="notification_type">
													<option value="">Tất cả loại thông báo</option>
													<option value="Thông báo" <?= (!empty($notification_type) && $notification_type == "Thông báo") ? "selected" : "" ?>>
														Thông báo
													</option>
													<option value="Quyết định" <?= (!empty($notification_type) && $notification_type == "Quyết định") ? "selected" : "" ?>>
														Quyết định
													</option>
													<option value="Quy định" <?= (!empty($notification_type) && $notification_type == "Quy định") ? "selected" : "" ?>>
														Quy định
													</option>
												</select>
											</li>

											<li class="form-group">
												<input type="text" name="title" class="form-control"
													   placeholder="Tiêu đề"
													   value="<?= !empty($title) ? $title : "" ?>">
											</li>

											<li class="form-group">
												<select class="form-control" name="priority_level">
													<option value="">Tất cả mức ưu tiên</option>
													<option value="Cao" <?= (!empty($priority_level) && $priority_level == "Cao") ? "selected" : "" ?>>
														Cao
													</option>
													<option value="Thấp" <?= (!empty($priority_level) && $priority_level == "Thấp") ? "selected" : "" ?>>
														Thấp
													</option>
												</select>
											</li>


											<li class="text-right">
												<button class="btn btn-info" type="submit">
													<i class="fa fa-search" aria-hidden="true"></i>
													Tìm Kiếm
												</button>
											</li>

										</ul>
									</form>
								</div>
							</li>

							<li>
								<?php
								if ($userSession['is_superadmin'] == 1 || $userSession['email'] == "hongtx@tienngay.vn" || $userSession['email'] == "linhnk@tienngay.vn" || $userSession['email'] == "manhld@tienngay.vn") { ?>
									<button class="btn btn-info" data-toggle="modal" data-target="#addnewModal">
										<i class="fa fa-plus" aria-hidden="true"></i>
										Thêm mới
									</button>
								<?php } ?>

							</li>

						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">

							<div class="col-xs-12">
								<!-- start project list -->
								<table class="table table-bordered m-table table-hover table-calendar table-report stacktable table-quanlytaisan">
									<thead style="background:#3f86c3; color: #ffffff;">
									<tr>
										<th style="width: 1%; text-align: center">#</th>
										<th style="text-align: center">Loại thông báo</th>
										<th style="text-align: center">Tiêu đề</th>
										<th style="text-align: center">Thời gian</th>
										<th style="text-align: center">Mức độ ưu tiên</th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									<tr>

									</tr>

									<?php
									$arr = [];
									$arr_role = [];
									$arr_notification = [];
									$count = 0;
									$count_gallery = 0;
									foreach ($groupRoles as $item) {
										if (!empty($item->users) && $item->status == "active") {
											foreach ($item->users as $key => $value) {
												foreach ($value as $k => $a) {
													if ($a->email == $userSession['email']) {
														$check_view = $item->name;
													}
												}
											}
										}
									}
									if (!empty($notifications)) {
										foreach ($notifications as $key => $notification) {
											if ($userSession['email'] != $notification->created_by) {
												if ((!in_array($check_view, $notification->selectize_role_value[0])) && (!in_array("all", $notification->selectize_role_value[0]))) {
													continue;
												}
												if (!empty($value->selectize_area_value[0])) {
													if (($check_view_header == "Giao dịch viên" && !in_array($return[0], $value->selectize_area_value[0]))) {
														continue;
													}
												}


											}
											array_push($arr_notification, $notification);
										}
									}
									?>

									<?php if (empty($arr_notification)): ?>
										<div class="item">
										</div>
									<?php else: ?>
										<?php foreach ($arr_notification as $key => $notification): ?>

											<tr>
												<td>
													<?php echo ++$count ?>
												</td>
												<td>
													<a onclick="$('.quanlytaisan_detail_<?php echo $notification->_id->{'$oid'} ?>').toggleClass('d-none');"
													   style="cursor:pointer;">
														<?= !empty($notification->notification_type) ? $notification->notification_type : '' ?>
													</a>
												</td>
												<td>
													<a onclick="$('.quanlytaisan_detail_<?php echo $notification->_id->{'$oid'} ?>').toggleClass('d-none');"
													   style="cursor:pointer;">
														<?= !empty($notification->title) ? $notification->title : '' ?>

													</a>
												</td>
												<td>
													<?= !empty($notification->start_date) ? date("d/m/Y", $notification->start_date) : '' ?>
													<?= !empty($notification->end_date) ? "- " . date("d/m/Y", $notification->end_date) : '' ?>
												</td>
												<td>
													<?= (!empty($notification->priority_level) && $notification->priority_level == "Cao") ? "<span class='label label-success'>" . $notification->priority_level . "</span>" : '' ?>
													<?= (!empty($notification->priority_level) && $notification->priority_level == "Thấp") ? "<span class='label label-info'>" . $notification->priority_level . "</span>" : '' ?>
												</td>
												<td class="text-right">

													<div class="dropdown" style="display:inline-block">
														<button class="btn btn-primary btn-sm dropdown-toggle"
																type="button"
																data-toggle="dropdown">
															<i class="fa fa-cogs"></i>

															<span class="caret"></span></button>
														<?php
														if ($userSession['is_superadmin'] == 1 || $userSession['email'] == "hongtx@tienngay.vn" || $userSession['email'] == "linhnk@tienngay.vn" || $userSession['email'] == "manhld@tienngay.vn") { ?>
															<ul class="dropdown-menu dropdown-menu-right">
																<li><a href="javascript:void(0)" data-toggle="modal"
																	   onclick="editModal('<?= $notification->_id->{'$oid'} ?>')"><i
																				class="fa fa-edit"></i> Sửa thông báo
																	</a>
																</li>
															</ul>
														<?php } ?>
													</div>
												</td>
											</tr>
											<tr id="quanlytaisan_detail_<?php echo $notification->_id->{'$oid'} ?>"
												class="d-none quanlytaisan_detail quanlytaisan_detail_<?php echo $notification->_id->{'$oid'} ?>">
												<td colspan="6">
													<table class="table table-borderless table-fixed">
														<thead>
														<tr>
															<th colspan="4">
																<strong>THÔNG BÁO CHI TIẾT</strong>
															</th>

														</tr>
														</thead>
														<tbody>

														<tr>
															<th>Nội dung</th>
															<td colspan="3"
																style="white-space: initial; text-emphasis: justify;">
																<?= !empty($notification->content) ? $notification->content : '' ?>

															</td>
														</tr>

														<tr>
															<th>Bộ phận áp dụng</th>
															<td style="white-space: initial;">
																<?php if (!empty($notification->selectize_role_value[0])): ?>
																	<?php foreach ($notification->selectize_role_value[0] as $key => $role_value): ?>
																		<?php if ($key >= 1): ?>
																			<a><?php echo ", " . $role_value ?></a>
																		<?php else: ?>
																			<a><?php echo $role_value ?></a>
																		<?php endif; ?>
																	<?php endforeach; ?>
																<?php endif; ?>

															</td>
															<?php if (!empty($notification->selectize_area_value[0])) { ?>
																<th>Vùng miền</th>
																<td style="white-space: initial;">
																	<?php if (!empty($notification->selectize_area_value[0])): ?>
																		<?php foreach ($notification->selectize_area_value[0] as $key => $area_value): ?>
																			<?php if ($key >= 1): ?>
																				<a><?php echo ", " . $area_value ?></a>
																			<?php else: ?>
																				<a><?php echo $area_value ?></a>
																			<?php endif; ?>
																		<?php endforeach; ?>
																	<?php endif; ?>

																</td>
															<?php } ?>
														</tr>

														<?php if (!empty($notification->image_accurecy->identify)) { ?>
															<tr>
																<th>Hình ảnh, video:</th>
																<td colspan="3">
																	<br><br>
																	<div class="row">
																		<div id="" class="simpleUploader ">
																			<div class="uploads " id="">

																				<?php
																				foreach ((array)$notification->image_accurecy->identify as $key => $value) { ?>

																					<div class="block">
																						<!--//Image-->
																						<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																							<a href="<?= $value->path ?>"
																							   class="magnifyitem"
																							   data-magnify="gallery<?php echo $count_gallery ?>"
																							   data-src=""
																							   data-group="thegallery<?php echo $count_gallery ?>"
																							   data-toggle="lightbox"
																							   data-gallery="uploads_identify<?php echo $count_gallery ?>"
																							   data-max-width="992"
																							   data-type="image"
																							   data-title="Thông báo">
																								<img name="img_contract"
																									 data-key="<?= $key ?>"
																									 data-fileName="<?= $value->file_name ?>"
																									 data-fileType="<?= $value->file_type ?>"
																									 data-type='identify'
																									 class="w-100"
																									 src="<?= $value->path ?>"
																									 alt="">
																							</a>
																						<?php } ?>
																						<!--Audio-->
																						<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
																							<a href="<?= $value->path ?>"
																							   target="_blank"><span
																										style="z-index: 9"><?= $value->file_name ?></span>
																								<img name="img_contract"
																									 style="width: 50%;transform: translateX(50%)translateY(-50%);"
																									 src="https://image.flaticon.com/icons/png/512/81/81281.png"
																									 alt="">
																								<img name="img_contract"
																									 data-key="<?= $key ?>"
																									 data-fileName="<?= $value->file_name ?>"
																									 data-fileType="<?= $value->file_type ?>"
																									 data-type='identify'
																									 class="w-100"
																									 src="<?= $value->path ?>"
																									 alt="">
																							</a>
																						<?php } ?>
																						<!--Video-->
																						<?php if ($value->file_type == 'video/mp4') { ?>
																							<a href="<?= $value->path ?>"
																							   target="_blank"><span
																										style="z-index: 9"><?= $value->file_name ?></span>
																								<img name="img_contract"
																									 style="width: 50%;transform: translateX(50%)translateY(-50%);"
																									 src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																									 alt="">
																								<img name="img_contract"
																									 data-key="<?= $key ?>"
																									 data-fileName="<?= $value->file_name ?>"
																									 data-fileType="<?= $value->file_type ?>"
																									 data-type='identify'
																									 class="w-100"
																									 src="<?= $value->path ?>"
																									 alt="">
																							</a>

																						<?php } ?>


																					</div>
																				<?php } ?>
																				<?php $count_gallery++ ?>

																			</div>
																		</div>
																	</div>
																</td>
															</tr>
														<?php } ?>

														</tbody>
													</table>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php endif; ?>
									</tbody>
								</table>
								<!-- end project list -->
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

</div>
<!-- /page content -->


<!-- Modal -->
<div id="addnewModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_tb" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Thêm mới thông báo</h4>
				<div class="theloading" style="display:none;">
					<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
					<span><?= $this->lang->line('Loading') ?>...</span>
				</div>
			</div>
			<div class="modal-body table-responsive">
				<table class="table table-borderless ">
					<thead>
					<tr>
						<th colspan="4">
							<strong>THÔNG BÁO CHI TIẾT</strong>
						</th>
						<div class="alert alert-danger alert-dismissible text-center" style="display:none"
							 id="div_errorCreate">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<span class='div_errorCreate'></span>
						</div>
					</tr>
					</thead>

					<tbody>
					<tr>
						<th>Loại thông báo <span class="text-danger">*</span></th>
						<td><select class="form-control" id="notification_type">
								<option value="Thông báo">Thông báo</option>
								<option value="Quyết định">Quyết định</option>
								<option value="Quy định">Quy định</option>
							</select></td>

						<th>Mức độ ưu tiên <span class="text-danger">*</span></th>
						<td><select class="form-control" id="priority_level">
								<option value="Cao">Cao</option>
								<option value="Thấp">Thấp</option>
							</select></td>
					</tr>

					<tr>
						<th>Tiêu đề <span class="text-danger">*</span></th>
						<td>
							<input class="form-control" type="text" id="title" maxlength="50">
						</td>
					</tr>

					<tr>
						<th>Nội dung <span class="text-danger">*</span></th>
						<td colspan="3"><textarea class="form-control" rows="8" id="content" name="content"
												  cols="80" maxlength="1000"></textarea></td>
					</tr>

					<tr>
						<th>Thời gian bắt đầu <span class="text-danger">*</span></th>
						<td>
							<input class="form-control" type="" id="start_date" placeholder="dd-mm-YYYY">
						</td>
						<th>Thời gian kết thúc</th>
						<td>
							<input class="form-control" type="" id="end_date" placeholder="dd-mm-YYYY">
						</td>
					</tr>

					<tr>
						<th>Bộ phận áp dụng <span class="text-danger">*</span></th>
						<td>
							<select class="form-control" id="selectize_role" name="selectize_role[]"
									multiple="multiple"
									data-placeholder="Chọn bộ phận">
								<option value="all">All</option>
								<?php
								if (!empty($groupRoles)) {
									foreach ($groupRoles as $key => $role) {
										if ($role->status == "deactive") {
											continue;
										}
										?>
										<option value="<?= !empty($role->name) ? $role->name : ""; ?>"><?= !empty($role->name) ? $role->name : ""; ?></option>
									<?php }
								} ?>
							</select>
							<input id="selectize_role_value" style="display: none">
						</td>
						<th style="display: none" class="gdv_vm">Vùng miền <span class="text-danger">*</span></th>
						<td style="display: none" class="gdv_vm">
							<select class="form-control" id="selectize_area" name="selectize_area[]"
									multiple="multiple" style="max-width: 450px">
								<option value="">Chọn vùng miền</option>
								<?php
								if (!empty($areaData)) {
									foreach ($areaData as $key => $area) {
										?>
										<option value="<?= !empty($area->code) ? $area->code : ""; ?>"><?= !empty($area->title) ? $area->title : ""; ?></option>
									<?php }
								} ?>
							</select>
							<input id="selectize_area_value" style="display: none">
						</td>

					</tr>

					<tr>
						<th>Hình ảnh, video:</th>
						<td colspan="3">
							<div id="SomeThing" class="simpleUploader ">
								<div class="uploads " id="uploads_identify">

								</div>
								<label for="uploadinput">
									<div class="block uploader">
										<span>+</span>
									</div>
								</label>
								<input id="uploadinput" type="file" name="file"
									   data-contain="uploads_identify" data-title="Hồ sơ nhân thân" multiple
									   data-type="identify" class="focus">
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default close_tb" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary submit_notification">Đăng thông báo</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<?php $this->load->view('page/thongbao/editModal'); ?>
		<!-- Modal content-->

	</div>
</div>


<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script src="<?php echo base_url("assets") ?>/js/thongbao/thongbao.js"></script>

<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<script>
	var delta = 0;
	$(document).on('click', '*[data-toggle="lightbox"]', function (event) {
		//$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		return $(this).ekkoLightbox({
			onShow: function (elem) {
				var html = '<button type="button" class="rotate btn btn-link" ><i class="fa fa-repeat"></i></button>';
				console.log(html);
				$(elem.currentTarget).find('.modal-header').prepend(html);
				var delta = 0;
			},
			onNavigate: function (direction, itemIndex) {
				var delta = 0;
				if (window.console) {
					return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
				}
			}
		});
	});
	$('body').on('click', 'button.rotate', function () {
		delta = delta + 90;
		$('.ekko-lightbox-item img').css({
			'-webkit-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'-moz-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)'
		});

	});
</script>
<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>

<script src="<?php echo base_url(); ?>assets/js/financial_handbook/index.js"></script>
<script>
	CKEDITOR.replace('content', {height: ['200px'], language: 'vi'});
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('body', {height: 200});
</script>
<script>
	CKEDITOR.replace('content', {height: ['200px']});
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('body', {height: 200});
</script>
<style type="text/css">
	textarea {

		white-space: pre;

		overflow-wrap: normal;

		overflow-x: scroll;

	}
</style>
<script>
	$(document).ready(function () {

		$("select#level").change(function () {

			var level = $(this).children("option:selected").val();

			console.log(level);
			var size = "Chưa gắn vị trí";
			if (level != '0') {
				switch (level) {
					case '1':
						size = "370 × 203 pixel ";
						break;
					case '2':
						size = "370 × 203 pixel ";
						break;
					case '3':
						size = "370 × 203 pixels";
						break;
					case '4':
						size = "370 × 203 pixel ";
						break;


				}
			}
			document.getElementById("size_image").innerHTML = size;
		});

	});
</script>
<script>
	function readURL_all(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			var parent = $(input).closest('.form-group');
			//console.log(parent);
			reader.onload = function (e) {
				parent.find('.wrap').hide('fast');
				parent.find('.blah').attr('src', e.target.result);
				parent.find('.wrap').show('fast');
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$(".x_content").on('change', '.imgInp', function () {

		readURL_all(this);
	});
</script>

