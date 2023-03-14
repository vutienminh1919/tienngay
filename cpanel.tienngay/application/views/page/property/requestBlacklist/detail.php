<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Chi tiết
				</h3>
			</div>
			<div class="title_right text-right" style="padding-top: 30px;">
				<a class="btn btn-info" href="<?= base_url('property/requestBlacklist') ?>">Quay
					lại</a>
			</div>
		</div>
	</div>

	<div class="">
		<div class="x_panel">
			<div class="row col-12">
				<h2>Chi tiết yêu cầu kiểm tra</h2>
				<div class="clearfix"></div>
			</div>
			<div class="">
				<form class="form-horizontal form-label-left"
					  enctype="multipart/form-data">
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Trạng thái
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='status_request_blacklist' id="status_request_blacklist" disabled
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->status) ? status_blacklist_property($detail_property_blacklist->status) : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hãng xe
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_name_property' id="detail_name_property"
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->brand_name) ? $detail_property_blacklist->brand_name : '' ?>"
										   disabled>
									<input type="text" value="<?= !empty($detail_property_blacklist->_id->{'$oid'}) ? $detail_property_blacklist->_id->{'$oid'} : ''; ?>"
										   name="detail_id_property" hidden>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Loại tài sản
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control " id="detail_type_xm_oto" name="detail_type_xm_oto"
											disabled>
										<?php if ($detail_property_blacklist->code == 'XM') : ?>
											<option value="XM">Xe máy</option>
										<?php elseif ($detail_property_blacklist->code == 'OTO') : ?>
											<option value="OTO">Ô tô</option>
										<?php endif; ?>
									</select>
								</div>
							</div>
							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [3,4, 200]) && in_array('bo-phan-dinh-gia', $groupRoles)) ? "" : 'style="display:none"' ;?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Tên chủ xe<span <?= in_array('bo-phan-dinh-gia', $groupRoles) ?  '' : 'style="display:none"'?> class="red">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='blacklist_name' placeholder="Tên chủ xe"
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->customer_infor->name) ? $detail_property_blacklist->customer_infor->name : '' ?>"
									>
								</div>
							</div>
							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [3,4, 200]) && in_array('bo-phan-dinh-gia', $groupRoles)) ? "" : 'style="display:none"' ;?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Biển số xe<span <?= in_array('bo-phan-dinh-gia', $groupRoles) ?  '' : 'style="display:none"'?> class="red">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='vehicle_number' id="vehicle_number" placeholder="Định dạng xxxx-xxx.xx"
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->vehicle_number) ? $detail_property_blacklist->vehicle_number : '' ?>">
								</div>
							</div>

							<div class="form-group made_by_oto_box" <?= (!in_array($detail_property_blacklist->status, [3,4,200]) && in_array('bo-phan-dinh-gia', $groupRoles)) ? "" : 'style="display:none"' ;?> >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Số khung<span <?= in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'style="display:none"'?> class="red">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='chassis_number' id="chassis_number" placeholder="Số khung"
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->chassis_number) ? $detail_property_blacklist->chassis_number : '' ?>">
								</div>
							</div>

							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [3,4,200]) && in_array('bo-phan-dinh-gia', $groupRoles)) ? "" : 'style="display:none"' ;?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Số máy<span <?= in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'style="display:none"'?> class="red">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='engine_number' id="engine_number" placeholder="Số máy"
										   value="<?= !empty($detail_property_blacklist->engine_number) ? $detail_property_blacklist->engine_number : '' ?>"
										   class="form-control col-md-7 col-xs-12">
								</div>
							</div>

							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [3,4,200]) && in_array('bo-phan-dinh-gia', $groupRoles)) ? "" : 'style="display:none"' ;?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Đăng ký xe<span <?= in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'style="display:none"'?> class="red">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='so_dang_ky' id="so_dang_ky"
										   class="form-control col-md-7 col-xs-12" placeholder="Số đăng ký" value="<?= !empty($detail_property_blacklist->registration->number) ? $detail_property_blacklist->registration->number : '' ?>"><br>
                                     <div  class="form-control-dang-ky row">
										 <input type="date" name='ngay_cap_dang_ky' id="ngay_cap_dang_ky"
										   class=" col-md-4 col-xs-12" placeholder="Ngày cấp đăng ký" value="<?= !empty($detail_property_blacklist->registration->date_range) ? date('Y-m-d', strtotime($detail_property_blacklist->registration->date_range)) : '' ?>"><br>
										 <input type="text" name='noi_cap_dang_ky' id="noi_cap_dang_ky"
												class=" col-md-4 col-xs-12" placeholder="Nơi cấp đăng ký" value="<?= !empty($detail_property_blacklist->registration->issued_by) ? $detail_property_blacklist->registration->issued_by : '' ?>">
									 </div>

								</div>
							</div>

							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [3,4,200]) && in_array('bo-phan-dinh-gia', $groupRoles) && $detail_property_blacklist->code == "OTO") ? "" : 'style="display:none"' ;?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Đăng kiểm xe<span <?= in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'style="display:none"'?> class="red">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='so_dang_kiem' id="so_dang_kiem"
										   class="form-control col-md-7 col-xs-12" placeholder="Số đăng kiểm" value="<?= !empty($detail_property_blacklist->inspection->number) ? $detail_property_blacklist->inspection->number : '' ?>"><br>
                                     <div  class="form-control-dang-kiem row">
										 <input type="date" name='ngay_cap_dang_kiem' id="ngay_cap_dang_kiem"
										   class=" col-md-4 col-xs-12" placeholder="Ngày cấp đăng kiểm" value="<?= !empty($detail_property_blacklist->inspection->date_range) ? date('Y-m-d', strtotime($detail_property_blacklist->inspection->date_range)) : '' ?>"><br>
										 <input type="text" name='noi_cap_dang_kiem' id="noi_cap_dang_kiem"
												class=" col-md-4 col-xs-12" placeholder="Nơi cấp đăng kiểm" value="<?= !empty($detail_property_blacklist->inspection->issued_by) ? $detail_property_blacklist->inspection->issued_by : '' ?>">
									 </div>

								</div>
							</div>



							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [3, 4, 200]) && in_array('bo-phan-dinh-gia', $groupRoles)) ? "" : 'style="display:none"'; ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Mô tả </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea class="form-control" name="description_blacklist"
											  id="description_blacklist"><?= !empty($detail_property_blacklist->description) ? $detail_property_blacklist->description : '' ?></textarea>
								</div>
							</div>


						</div>
						<div class="col-xs-12 col-sm-6">
							<div>
								<div>
									<label class="control-label">Ảnh đăng ký (đầy đủ 2 mặt) </label>
									<div id="SomeThing" class="simpleUploader">
										<div class="uploads" id="uploads_fileReturn2">
											<?php foreach ((array)$img_dang_ky as $key => $value) : ?>
												<div class="block">
													<!--//Image-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>"
														   class="magnifyitem" data-magnify="gallery"
														   data-src=""
														   data-group="thegallery"
														   data-caption="Ảnh chi tiết tài sản <?php echo $key_identify ?>">
															<img data-type="fileReturn"
																 data-fileType="<?= $value->file_type ?>"
																 data-fileName="<?= $value->file_name ?>"
																 name="img_fileReturn2"
																 data-key="<?= $value->key ?>"
																 src="<?= !empty($value->path) ? $value->path : $value ?>">
														</a>

													<?php } else { ?>
														<a href="<?= !empty($value->path) ? $value->path : $value ?>"
														   class="magnifyitem" data-magnify="gallery"
														   data-src=""
														   data-group="thegallery"
														   data-caption="Ảnh đăng ký xe">
															<img data-type="fileReturn"
																 data-fileType=""
																 data-fileName=""
																 name="check_registrator"
																 data-key=""
																 src="<?= !empty($value->path) ? $value->path : $value ?>">
														</a>
													<?php } ?>
													<!--Audio-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>" target="_blank"><span
																	style="z-index: 9"><?= $value->file_name ?></span><input
																	type="hidden"><img
																	style="width: 50%;transform: translateX(50%)translateY(-50%);"
																	src="https://image.flaticon.com/icons/png/512/81/81281.png"
																	alt=""><img style="display:none"
																				data-type="fileReturn"
																				data-fileType="<?= $value->file_type ?>"
																				data-fileName="<?= $value->file_name ?>"
																				name="img_fileReturn2"
																				data-key="<?= $value->key ?>"
																				src="<?= $value->path ?>"/></a>;
													<?php } ?>
													<!--Video-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>" target="_blank"><span
																	style="z-index: 9"><?= $value->file_name ?></span><img
																	style="width: 50%;transform: translateX(50%)translateY(-50%);"
																	src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																	alt=""><img style="display:none"
																				data-type="fileReturn"
																				data-fileType="<?= $value->file_type ?>"
																				data-fileName="<?= $value->file_name ?>"
																				name="img_fileReturn2"
																				data-key="<?= $value->key ?>"
																				src="<?= $value->path ?>"/></a>

													<?php } ?>
													<button type="button" onclick="deleteImage(this)"
															data-id="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>"
															data-type="identify" data-key='<?= $value->key ?>'
															class="cancelButton">
													</button>
												</div>
											<?php endforeach; ?>
										</div>
										<input id="uploadinput2" type="file" name="file"
											   data-contain="uploads_fileReturn2" data-title="Ảnh đăng ký" multiple
											   data-type="fileReturn"
											   class="focus">
									</div>
								</div>
								<div class="img_detail_dang_kiem_box" <?= ($detail_property_blacklist->code == 'OTO') ? '' : 'hidden' ?>>
									<label class="control-label">Ảnh đăng kiểm (đầy đủ 2 mặt)</label>
									<div id="SomeThing" class="simpleUploader">
										<div class="uploads" id="uploads_fileReturn3">
											<?php foreach ((array)$img_dang_kiem as $key => $value) : ?>
												<div class="block">
													<!--//Image-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>"
														   class="magnifyitem" data-magnify="gallery"
														   data-src=""
														   data-group="thegallery"
														   data-caption="Ảnh chi tiết tài sản <?php echo $key_identify ?>">
															<img data-type="fileReturn"
																 data-fileType="<?= $value->file_type ?>"
																 data-fileName="<?= $value->file_name ?>"
																 name="img_fileReturn3"
																 data-key="<?= $value->key ?>"
																 src="<?= $value->path ?>">
														</a>

													<?php } else { ?>
														<a href="<?= !empty($value->path) ? $value->path : $value ?>"
														   class="magnifyitem" data-magnify="gallery"
														   data-src=""
														   data-group="thegallery"
														   data-caption="Ảnh đăng kiểm xe">
															<img data-type="fileReturn"
																 data-fileType=""
																 data-fileName=""
																 name="check_registrator"
																 data-key=""
																 src="<?= !empty($value->path) ? $value->path : $value ?>">
														</a>
													<?php } ?>
													<!--Audio-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>" target="_blank"><span
																	style="z-index: 9"><?= $value->file_name ?></span><input
																	type="hidden"><img
																	style="width: 50%;transform: translateX(50%)translateY(-50%);"
																	src="https://image.flaticon.com/icons/png/512/81/81281.png"
																	alt=""><img style="display:none"
																				data-type="fileReturn"
																				data-fileType="<?= $value->file_type ?>"
																				data-fileName="<?= $value->file_name ?>"
																				name="img_fileReturn3"
																				data-key="<?= $value->key ?>"
																				src="<?= $value->path ?>"/></a>;
													<?php } ?>
													<!--Video-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>" target="_blank"><span
																	style="z-index: 9"><?= $value->file_name ?></span><img
																	style="width: 50%;transform: translateX(50%)translateY(-50%);"
																	src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																	alt=""><img style="display:none"
																				data-type="fileReturn"
																				data-fileType="<?= $value->file_type ?>"
																				data-fileName="<?= $value->file_name ?>"
																				name="img_fileReturn3"
																				data-key="<?= $value->key ?>"
																				src="<?= $value->path ?>"/></a>
													<?php } ?>
													<button type="button" onclick="deleteImage(this)"
															data-id="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>"
															data-type="identify" data-key='<?= $key ?>'
															class="cancelButton">
													</button>
												</div>
											<?php endforeach; ?>
										</div>
										<input id="uploadinput3" type="file" name="file"
											   data-contain="uploads_fileReturn3" data-title="Ảnh đăng kiểm"
											   multiple
											   data-type="fileReturn"
											   class="focus">
									</div>
								</div>
								<div>
									<label class="control-label">Ảnh khác </label>
									<div id="SomeThing" class="simpleUploader">
										<div class="uploads" id="uploads_fileReturn1">
											<?php foreach ((array)$img_tai_san as $key => $value) : ?>
												<div class="block">
													<!--//Image-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>"
														   class="magnifyitem" data-magnify="gallery"
														   data-src=""
														   data-group="thegallery"
														   data-caption="Ảnh chi tiết tài sản">
															<img data-type="fileReturn"
																 data-fileType="<?= $value->file_type ?>"
																 data-fileName="<?= $value->file_name ?>"
																 name="img_fileReturn1"
																 data-key="<?= $value->key ?>"
																 src="<?= $value->path ?>">
														</a>
														<button type="button" onclick="deleteImage(this)"
																data-type="<?= $value->type ?>"
																data-key="<?= $value->key ?>"
																class="cancelButton ">
														</button >;

													<?php } ?>
													<!--Audio-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>" target="_blank"><span
																	style="z-index: 9"><?= $value->file_name ?></span><input
																	type="hidden"><img
																	style="width: 50%;transform: translateX(50%)translateY(-50%);"
																	src="https://image.flaticon.com/icons/png/512/81/81281.png"
																	alt=""><img style="display:none"
																				data-type="fileReturn"
																				data-fileType="<?= $value->file_type ?>"
																				data-fileName="<?= $value->file_name ?>"
																				name="img_fileReturn1"
																				data-key="<?= $value->key ?>"
																				src="<?= $value->path ?>"/></a>;
													<?php } ?>
													<!--Video-->
													<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>
														<span
																class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
														<a href="<?= $value->path ?>" target="_blank"><span
																	style="z-index: 9"><?= $value->file_name ?></span><img
																	style="width: 50%;transform: translateX(50%)translateY(-50%);"
																	src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																	alt=""><img style="display:none"
																				data-type="fileReturn"
																				data-fileType="<?= $value->file_type ?>"
																				data-fileName="<?= $value->file_name ?>"
																				name="img_fileReturn1"
																				data-key="<?= $value->key ?>"
																				src="<?= $value->path ?>"/></a>
													<?php } ?>
													<button type="button" onclick="deleteImage(this)"
															data-id="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>"
															data-type="identify" data-key='<?= $value->key ?>'
															class="cancelButton">
													</button>
												</div>
											<?php endforeach; ?>
										</div>
										<input id="uploadinput1" type="file" name="file"
											   data-contain="uploads_fileReturn1" data-title="Ảnh chi tiết " multiple
											   data-type="fileReturn"
											   class="focus">
									</div>
								</div>
								<div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6 text-center button_blacklist">
							<?php if ($detail_property_blacklist->status != 'active' && in_array('bo-phan-dinh-gia', $groupRoles)) : ?>
								<a class="xts btn btn-dark add_property_blacklist" <?= !in_array($detail_property_blacklist->status, [200, 4, 3, 2]) ? "" : 'style="display:none"' ?>
								   id="add_property_blacklist">Thêm vào blacklist</a>
								<a class="xts btn btn-primary real_property"
								   id="real_property" <?= !in_array($detail_property_blacklist->status, [200, 4, 3, 2]) ? "" : 'style="display:none"' ?>>Xác
									nhận tài sản thật</a>
								<a data-toggle="modal"
								   data-target="#exampleModal" <?= !in_array($detail_property_blacklist->status, [200, 3, 4, 2]) ? "" : 'style="display:none"' ?>
								   class="xts btn btn-warning feedback_property_blacklist"
								   id="feedback_property_blacklist">Trả
									về yêu cầu</a>
								<a <?= !in_array($detail_property_blacklist->status, [2, 3, 4, 200]) ? "" : 'style="display:none"' ?>
										class="xts btn btn-danger cancel_property_blacklist"
										id="cancel_property_blacklist">Hủy
									yêu cầu</a>
							<?php endif; ?>
						</div>
						<div class="col-xs-12 col-sm-6"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab_content1" role="tab" id="tab001"
														  data-toggle="tab" aria-expanded="false">Hoạt động</a>
				</li>
				<div  <?= in_array('bo-phan-dinh-gia', $groupRoles) ? 'style="text-align: right"' : 'style="display:none"'?>>
					<li>
						<a style="font-size: 16px" class="btn btn-info" data-toggle="modal" data-target="#addComment">Comment</a>
					</li>
				</div>

			</ul>
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab001">
					<?php $this->load->view('page/property/requestBlacklist/history'); ?>
				</div>
			</div>

		</div>

	</div>
</div>

<div class="modal fade-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ghi chú trả về</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea class="form-control" name="note_request_property" id="note_request_property"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
				<a type="button" class="btn btn-primary note_blacklist_property">Xác nhận</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addComment" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
			 aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
									aria-hidden="true">&times;</span></button>
						<h3 class="modal-title" style="text-align: center">Comment</h3>
					</div>
					<div class="modal-body ">
						<div class="row">
							<div class="col-xs-12">
								<input style="display: none" value="" id="comment_id"/>

								<div class="form-group">
									<label class="control-label col-md-3">Ghi chú<span
												class="text-danger"></span></label>
									<div class="col-md-9">
										<textarea id="add_comment" class="form-control"></textarea>
										<span class="help-block"></span>
									</div>
								</div>

								<div style="text-align: center">
									<button type="button" id="add_comment_blacklist" class="btn btn-info">Lưu</button>
									<button type="button" class="btn btn-primary close-Comment" data-dismiss="modal"
											aria-label="Close">
										Thoát
									</button>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
</div>


<div id="successModalProperty" class="modal fade">
	<div class="modal-dialog modal-confirm">
	<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title">Thành công</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<a class="btn btn-primary" style="padding-top: 13px;font-size: 14px"  href="<?= base_url('property/requestBlacklist') ?>">Danh sách yêu cầu</a>
				<a class="btn btn-danger" style="padding-top: 13px;font-size: 14px" href="<?= base_url('property/blacklist') ?>">Blacklist</a>
			</div>
		</div>
	</div>
</div>

<!--Modal tùy chọn cập nhật Blacklist-->
<?php $this->load->view('page/property/modal/navigate_registration_info_modal.php'); ?>


<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/property/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>

<style>
	.magnify-footer {
		bottom : 0%
	}
	@media screen and (max-width :46em){
		.btn_list {
			padding-left: 0px !important;
		}

		.btn_list {
			display: flex;
			flex-wrap: wrap;
		}

		.xts {
			margin-bottom: 15px !important;
		}
	}

	.form-control-dang-ky {
		padding-right: 10px;
		padding-left: 10px;
		margin-top: 21px;
		display: flex;
		justify-content: space-between;
	}

	.form-control-dang-ky input {
		width: 49%;
		height: 34px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
	}

	.form-control-dang-kiem {
		padding-right: 10px;
		padding-left: 10px;
		margin-top: 21px;
		display: flex;
		justify-content: space-between;
	}

	.form-control-dang-kiem input {
		width: 49%;
		height: 34px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
	}

</style>
<script>
	$(document).ready(function () {

		$('#add_comment_blacklist').click(function (event) {
			event.preventDefault();
			let id = $("input[name='detail_id_property']").val();
			let comment = $('#add_comment').val();
			let formData = new FormData();
			formData.append('comment', comment);
			formData.append('id', id);
			$.ajax({
				url: _url.base_url + 'property/addCommentRequestBlacklist',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$('#addComment').modal('hide');
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						setTimeout(function () {
							window.location.reload();
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					alert('error')
				}
			})

		});

		$('#valuation_price_property').keyup(function (event) {
			// skip for arrow keys
			if (event.which >= 37 && event.which <= 40) return;
			// format number
			$(this).val(function (index, value) {
				return value
					.replace(/\D/g, "")
					.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
					;
			});
		});

		$('#status_request_blacklist').change(function (event) {
			if($(this).val() == 4 ){
				$('.button_blacklist').hide();
			}
		})

		$('#cancel_property_blacklist').click(function (event) {
			event.preventDefault();
			let id = $("input[name='detail_id_property']").val();
			let formData = new FormData();
			formData.append('id', id);
			if (confirm('Bạn chắc chắn muốn hủy không ?')) {
				$.ajax({
					url: _url.base_url + 'property/cancelRequest',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						if (data.code == 200) {
							$('#successModal').modal('show');
							setTimeout(function () {
								window.location.href = _url.base_url + 'property/requestBlacklist';
							}, 2000);
						} else {
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
						}
					},
					error: function () {
						$(".theloading").hide();
						console.log('error')
						alert('error')
					}
				})
			}


		});

		$('#real_property').click(function (event) {
			event.preventDefault();
			let id = $("input[name='detail_id_property']").val();
			let formData = new FormData();
			formData.append('id', id);
			if (confirm('Bạn có xác nhận đây là tài sản thật không ?')) {
				$.ajax({
					url: _url.base_url + 'property/realProperty',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						if (data.code == 200) {
							$('#successModal').modal('show');
							setTimeout(function () {
								window.location.href = _url.base_url + 'property/requestBlacklist';
							}, 2000);
						} else {
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
						}
					},
					error: function () {
						$(".theloading").hide();
						console.log('error')
						alert('error')
					}
				})
			}


		});

		// Show modal tùy chọn Lưu thông tin Blacklist DKX/Cavet
		$('#add_property_blacklist').click(function (event) {
			event.preventDefault();
			$('#navigate_registration').modal('show');
		});

		// Điền tự động thông tin ĐKX/Cavet
		$('#fill_auto_info').click(function (event) {
			event.preventDefault();
			let property_id = $("input[name='detail_id_property']").val();
			$.ajax({
				url: _url.base_url + '/Ajax/detect_registration',
				method: "POST",
				data: {property_id: property_id},
				beforeSend: function () {
					$('.theloading').show();
				},
				success: function (response) {
					console.log(response)
					$('.theloading').hide();
					if (response.status == 200) {
						let registration_info = {};
						registration_info = response.data;
						let ten_chu_xe = $("input[name='blacklist_name']").empty();
						let bien_so_xe = $("input[name='vehicle_number']").empty();
						let so_dang_ky = $("input[name='so_dang_ky']").empty();
						let so_khung = $("input[name='chassis_number']").empty();
						let so_may = $("input[name='engine_number']").empty();
						let ngay_cap_dang_ky = $("input[name='ngay_cap_dang_ky']").empty();
						let noi_cap_dang_ky = $("input[name='noi_cap_dang_ky']").empty();
						license_date = registration_info.license_date;
						license_date = moment(license_date,'DD-MM-YYYY').format('YYYY-MM-DD');
						ten_chu_xe.val(registration_info.owner_car_name)
						bien_so_xe.val(registration_info.plate_number)
						so_khung.val(registration_info.chassis_number)
						so_may.val(registration_info.engine_number)
						so_dang_ky.val(registration_info.registration_number)
						ngay_cap_dang_ky.val(license_date)
						noi_cap_dang_ky.val(registration_info.issued_at)
						$('#fill_auto_info').prop('disabled', true);
					} else {
						toastr.error(response.msg);
					}
				},
				error: function (response) {
					$('.theloading').hide();
				}
			});
		});

		// Sửa thông tin ĐKX/Cavet
		$('#edit_registration_info').click(function (event) {
			$('#navigate_registration').modal('hide');
		});

		// Lưu thông tin ĐKX/Cavet vào Blacklist
		$('#confirm_blacklist').click(function (event) {
			let id = $("input[name='detail_id_property']").val();
			let bien_so_xe = $("input[name='vehicle_number']").val()
			let so_khung = $("input[name='chassis_number']").val();
			let so_may = $("input[name='engine_number']").val();
			let ten_chu_xe = $("input[name='blacklist_name']").val();
			let so_dang_ky = $("input[name='so_dang_ky']").val();
			let ngay_cap_dang_ky = $("input[name='ngay_cap_dang_ky']").val();
			let noi_cap_dang_ky = $("input[name='noi_cap_dang_ky']").val();
			let so_dang_kiem = $("input[name='so_dang_kiem']").val();
			let ngay_cap_dang_kiem = $("input[name='ngay_cap_dang_kiem']").val();
			let noi_cap_dang_kiem = $("input[name='noi_cap_dang_kiem']").val();
			let description = $("textarea[name='description_blacklist']").val();

			let loai_xe = $("select[name='detail_type_xm_oto']").val();
			let formData = new FormData();
			formData.append('bien_so_xe', bien_so_xe);
			formData.append('loai_xe', loai_xe);
			formData.append('so_khung', so_khung);
			formData.append('so_may', so_may);
			formData.append('so_dang_ky', so_dang_ky);
			formData.append('ngay_cap_dang_ky', ngay_cap_dang_ky);
			formData.append('noi_cap_dang_ky', noi_cap_dang_ky);
			formData.append('so_dang_kiem', so_dang_kiem);
			formData.append('ngay_cap_dang_kiem', ngay_cap_dang_kiem);
			formData.append('noi_cap_dang_kiem', noi_cap_dang_kiem);
			formData.append('description', description);
			formData.append('ten_chu_xe', ten_chu_xe);
			formData.append('id', id);
			$.ajax({
				url: _url.base_url + 'property/addPropertyBlacklist',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					$('#navigate_registration').modal('hide');
					if (data.code == 200) {
						$('#successModalProperty').modal('show');
					} else {
						toastr.error(data.msg);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					alert('error')
				}
			})
		});

		$('.note_blacklist_property').click(function (event) {
			event.preventDefault();
			let note = $('#note_request_property').val()
			let id = $("input[name='detail_id_property']").val();
			console.log(note, id);
			let formData = new FormData();
			formData.append('note', note);
			formData.append('id', id);
			if ($("#note_request_property").val() == "") {
				$("#errorModal").modal("show");
				$(".msg_error").text('Ghi chú trả về không được để trống');
			} else {
				if (confirm('Bạn chắc chắn muốn trả về không ?')) {
					$.ajax({
						url: _url.base_url + 'property/feedbackRequest',
						type: "POST",
						data: formData,
						dataType: 'json',
						processData: false,
						contentType: false,
						beforeSend: function () {
							$('#exampleModal').modal('hide');
							$(".theloading").show();
						},
						success: function (data) {
							$(".theloading").hide();
							if (data.code == 200) {
								$('#successModal').modal('show');
								setTimeout(function () {
									window.location.href = _url.base_url + 'property/requestBlacklist';
								}, 2000);
							} else {
								$("#errorModal").modal("show");
								$(".msg_error").text(data.msg);
							}
						},
						error: function () {
							$(".theloading").hide();
							console.log('error')
							alert('error')
						}
					});
				}
			}

		})



		$('#update_after_feedback_property').click(function (event) {
			event.preventDefault();
			let id = $("input[name='detail_id_property']").val();
			let year = $("input[name='detail_year_property']").val();
			let phan_khuc_oto = $("select[name='detail_phan_khuc_oto']").val();
			let phan_khuc_xm = $("select[name='detail_phan_khuc_xm']").val();
			let type_property_xm = $("select[name='detail_type_property_xm']").val();
			let type_property_oto = $("select[name='detail_type_property_oto']").val();
			let gas_or_oil = $("select[name='detail_gas_or_oil']").val();
			let brand = $("input[name='detail_brand_property']").val();
			let model = $("input[name='detail_model_property']").val();
			let xuat_xu = $("input[name='detail_made_in']").val();
			let type_xm_oto = $("select[name='detail_type_xm_oto']").val();
			let price_suggest = $("input[name='detail_price_suggest_property']").val();
			let description = $("textarea[name='detail_description_property']").val();
			var count1 = $("img[name='img_fileReturn1']").length;
			var count2 = $("img[name='img_fileReturn2']").length;
			var count3 = $("img[name='img_fileReturn3']").length;
			var fileReturn_img1 = {};
			var fileReturn_img2 = {};
			var fileReturn_img3 = {};
			if (count1 > 0) {
				$("img[name='img_fileReturn1']").each(function () {
					var data = {};
					type = $(this).data('type');
					data['file_type'] = $(this).attr('data-fileType');
					data['file_name'] = $(this).attr('data-fileName');
					data['path'] = $(this).attr('src');
					data['key'] = $(this).attr('data-key');
					var key = $(this).data('key');
					if (type == 'fileReturn') {
						fileReturn_img1[key] = data;
					}
				});
			}
			if (count2 > 0) {
				$("img[name='img_fileReturn2']").each(function () {
					var data = {};
					type = $(this).data('type');
					data['file_type'] = $(this).attr('data-fileType');
					data['file_name'] = $(this).attr('data-fileName');
					data['path'] = $(this).attr('src');
					data['key'] = $(this).attr('data-key');
					var key = $(this).data('key');
					if (type == 'fileReturn') {
						fileReturn_img2[key] = data;
					}
				});
			}
			if (count3 > 0) {
				$("img[name='img_fileReturn3']").each(function () {
					var data = {};
					type = $(this).data('type');
					data['file_type'] = $(this).attr('data-fileType');
					data['file_name'] = $(this).attr('data-fileName');
					data['path'] = $(this).attr('src');
					data['key'] = $(this).attr('data-key');
					var key = $(this).data('key');
					if (type == 'fileReturn') {
						fileReturn_img3[key] = data;
					}
				});
			}
			let img_tai_san = JSON.stringify(fileReturn_img1)
			let img_giay_to = JSON.stringify(fileReturn_img2)
			let img_dang_kiem = JSON.stringify(fileReturn_img3)
			console.log(fileReturn_img1.length, fileReturn_img2.length, fileReturn_img3.length);

			let formData = new FormData();
			formData.append('id', id)
			formData.append('year', year)
			formData.append('phan_khuc_oto', phan_khuc_oto)
			formData.append('phan_khuc_xm', phan_khuc_xm)
			formData.append('type_property_xm', type_property_xm)
			formData.append('type_property_oto', type_property_oto)
			formData.append('gas_or_oil', gas_or_oil)
			formData.append('brand', brand)
			formData.append('model', model)
			formData.append('xuat_xu', xuat_xu)
			formData.append('type', type_xm_oto)
			formData.append('price_suggest', price_suggest)
			formData.append('description', description)
			formData.append('img_tai_san', img_tai_san);
			formData.append('img_giay_to', img_giay_to);
			formData.append('img_dang_kiem', img_dang_kiem);
			console.log(id, year, phan_khuc_oto,type_property_xm ,type_property_oto, gas_or_oil, brand, model, type_xm_oto);
			if (confirm('Bạn chắc chắn muốn chỉnh sửa tài sản này ?')) {
				$.ajax({
					url: _url.base_url + 'property/update_valuation_property',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						if (data.code == 200) {
							$('#successModal').modal('show');
							setTimeout(function () {
								window.location.reload();
							}, 2000);
						} else {
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
						}
					},
					error: function () {
						$(".theloading").hide();
						console.log('error')
						alert('error')
					}
				});
			}
		})

		$('#update_property').click(function (event) {
			event.preventDefault();
			let id = $("input[name='detail_id_property']").val();
			let year = $("input[name='detail_year_property']").val();
			let phan_khuc_oto = $("select[name='detail_phan_khuc_oto']").val();
			let phan_khuc_xm = $("select[name='detail_phan_khuc_xm']").val();
			let type_property_xm = $("select[name='detail_type_property_xm']").val();
			let type_property_oto = $("select[name='detail_type_property_oto']").val();
			let gas_or_oil = $("select[name='detail_gas_or_oil']").val();
			let brand = $("input[name='detail_brand_property']").val();
			let model = $("input[name='detail_model_property']").val();
			let xuat_xu = $("input[name='detail_made_in']").val();
			let type_xm_oto = $("select[name='detail_type_xm_oto']").val();
			let formData = new FormData();
			formData.append('id', id)
			formData.append('year', year)
			formData.append('phan_khuc_oto', phan_khuc_oto)
			formData.append('phan_khuc_xm', phan_khuc_xm)
			formData.append('type_property_xm', type_property_xm)
			formData.append('type_property_oto', type_property_oto)
			formData.append('gas_or_oil', gas_or_oil)
			formData.append('brand', brand)
			formData.append('model', model)
			formData.append('xuat_xu', xuat_xu)
			formData.append('type', type_xm_oto)

			console.log(id, year,phan_khuc_xm, phan_khuc_oto , type_property_oto, gas_or_oil, brand, model, type_xm_oto);
			if (confirm('Bạn chắc chắn muốn chỉnh sửa tài sản này ?')) {
				if (phan_khuc_xm == '' && type_xm_oto == 'XM') {
					$("#errorModal").modal("show");
					$(".msg_error").text('Phân khúc xe máy không được để trống');
				}else {
					$.ajax({
						url: _url.base_url + 'property/update_property',
						type: "POST",
						data: formData,
						dataType: 'json',
						processData: false,
						contentType: false,
						beforeSend: function () {
							$(".theloading").show();
						},
						success: function (data) {
							$(".theloading").hide();
							if (data.code == 200) {
								$('#successModal').modal('show');
								setTimeout(function () {
									window.location.reload();
								}, 2000);
							} else {
								$("#errorModal").modal("show");
								$(".msg_error").text(data.msg);
							}
						},
						error: function () {
							$(".theloading").hide();
							console.log('error')
							alert('error')
						}
					});
				}
			}
		})


	});

	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$('#uploadinput1').simpleUpload(_url.base_url + "property/upload_img_taisan", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 20000000, //10MB,
			multiple: true,
			limit: 10,
			start: function (file) {
				fileType = file.type;
				fileName = file.name;
				//upload started
				this.block = $('<div class="block"></div>');
				this.progressBar = $('<div class="progressBar"></div>');
				this.block.append(this.progressBar);
				$('#' + contain).append(this.block);
			},
			data: {
				'type_img': type,
				'contract_id': contractId
			},
			progress: function (progress) {
				//received progress
				this.progressBar.width(progress + "%");
			},
			success: function (data) {
				//upload successful
				this.progressBar.remove();
				if (data.code == 200) {
					//Video Mp4
					if (fileType == 'video/mp4') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn1"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn1"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn1"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div class="block1" ></div>').html(content);
						this.block.append(data);
					}
				} else {
					//our application returned an error
					var error = data.msg;
					this.block.remove();
					alert(error);
				}
			},
			error: function (error) {

				var msg = error.msg;
				this.block.remove();
				alert("File không đúng định dạng");
			}
		});
		$('#uploadinput2').simpleUpload(_url.base_url + "property/upload_img_taisan", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 20000000, //10MB,
			multiple: true,
			limit: 2,
			start: function (file) {
				fileType = file.type;
				fileName = file.name;
				//upload started
				this.block = $('<div class="block"></div>');
				this.progressBar = $('<div class="progressBar"></div>');
				this.block.append(this.progressBar);
				$('#' + contain).append(this.block);
			},
			data: {
				'type_img': type,
				'contract_id': contractId
			},
			progress: function (progress) {
				//received progress
				this.progressBar.width(progress + "%");
			},
			success: function (data) {
				//upload successful
				this.progressBar.remove();
				if (data.code == 200) {
					//Video Mp4
					if (fileType == 'video/mp4') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn2"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn2"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn2"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(content);
						this.block.append(data);
					}
				} else {
					//our application returned an error
					var error = data.msg;
					this.block.remove();
					alert(error);
				}
			},
			error: function (error) {

				var msg = error.msg;
				this.block.remove();
				alert("File không đúng định dạng");
			}
		});

		$('#uploadinput3').simpleUpload(_url.base_url + "property/upload_img_taisan", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 20000000, //10MB,
			multiple: true,
			limit: 2,
			start: function (file) {
				fileType = file.type;
				fileName = file.name;
				//upload started
				this.block = $('<div class="block"></div>');
				this.progressBar = $('<div class="progressBar"></div>');
				this.block.append(this.progressBar);
				$('#' + contain).append(this.block);
			},
			data: {
				'type_img': type,
				'contract_id': contractId
			},
			progress: function (progress) {
				//received progress
				this.progressBar.width(progress + "%");
			},
			success: function (data) {
				//upload successful
				this.progressBar.remove();
				if (data.code == 200) {
					//Video Mp4
					if (fileType == 'video/mp4') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn3"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn3"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn3"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div class="block1" ></div>').html(content);
						this.block.append(data);
					}
				} else {
					//our application returned an error
					var error = data.msg;
					this.block.remove();
					alert(error);
				}
			},
			error: function (error) {

				var msg = error.msg;
				this.block.remove();
				alert("File không đúng định dạng");
			}
		});

	});


	function deleteImage(thiz) {
		var thiz_ = $(thiz);
		var key = $(thiz).data("key");
		var type = $(thiz).data("type");
		var id = $(thiz).data("id");
		// var res = confirm("Bạn có chắc chắn muốn xóa");
		if (confirm("Bạn có chắc chắn muốn xóa ?")) {
			$(thiz_).closest("div .block").remove();
		}
	}
</script>


