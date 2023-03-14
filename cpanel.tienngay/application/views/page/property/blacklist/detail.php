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
				<a class="btn btn-info" href="<?= base_url('property/blacklist') ?>">Quay
					lại</a>
			</div>
		</div>
	</div>

	<div class="">
		<div class="x_panel">
			<div class="row col-12">
				<h2>Chi tiết blacklist tài sản</h2>
				<div class="clearfix"></div>
			</div>
			<div class="">
				<form class="form-horizontal form-label-left"
					  enctype="multipart/form-data">
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hãng xe
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_name_property' id="detail_name_property"
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->brand_name) ? $detail_property_blacklist->brand_name : '' ?>"
										   disabled>
									<input type="text" value="<?= $detail_property_blacklist->_id->{'$oid'} ?>"
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
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Tên chủ xe</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_model_property'
										   class="form-control col-md-7 col-xs-12" disabled
										   value="<?= !empty($detail_property_blacklist->customer_infor->name) ? $detail_property_blacklist->customer_infor->name : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Biển số xe
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='vehicle_number' id="vehicle_number" disabled
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->vehicle_number) ? $detail_property_blacklist->vehicle_number : '' ?>">
								</div>
							</div>

							<div class="form-group made_by_oto_box" >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Số khung</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='chassis_number' id="chassis_number" disabled
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->chassis_number) ? $detail_property_blacklist->chassis_number : '' ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Số máy</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='engine_number' id="engine_number" disabled
										   value="<?= !empty($detail_property_blacklist->engine_number) ? $detail_property_blacklist->engine_number : '' ?>"
										   class="form-control col-md-7 col-xs-12">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Đăng ký xe</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='so_dang_ky' id="so_dang_ky" disabled
										   value="<?= !empty($detail_property_blacklist->registration->number) ? $detail_property_blacklist->registration->number : '' ?>"
										   class="form-control col-md-7 col-xs-12" ><br>
                                     <div  class="form-control-dang-ky row">
										 <input type="text" name='ngay_cap_dang_ky' id="ngay_cap_dang_ky" disabled
												value="Ngày cấp: <?=!empty($detail_property_blacklist->registration->date_range) ? $detail_property_blacklist->registration->date_range : ''?>"
										   class=" col-md-4 col-xs-12" ><br>
										 <input type="text" name='noi_cap_dang_ky' id="noi_cap_dang_ky" disabled
												value="Nơi cấp: <?=!empty($detail_property_blacklist->registration->issued_by) ? $detail_property_blacklist->registration->issued_by : ''?>"
												class=" col-md-4 col-xs-12" >
									 </div>

								</div>
							</div>

							<div class="form-group" <?= $detail_property_blacklist->code == "OTO" ? '' : 'style="display:none"' ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Đăng kiểm xe</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='so_dang_kiem' id="so_dang_kiem" disabled
										   value="<?= !empty($detail_property_blacklist->inspection->number) ? $detail_property_blacklist->inspection->number : '' ?>"
										   class="form-control col-md-7 col-xs-12" ><br>
                                     <div  class="form-control-dang-kiem row">
										 <input type="text" name='ngay_cap_dang_kiem' id="ngay_cap_dang_kiem" disabled
												value="Ngày cấp: <?= !empty($detail_property_blacklist->inspection->date_range) ? $detail_property_blacklist->inspection->date_range : '' ?>"
										   class=" col-md-4 col-xs-12" ><br>
										 <input type="text" name='noi_cap_dang_kiem' id="noi_cap_dang_kiem" disabled
												value="Nơi cấp: <?= !empty($detail_property_blacklist->inspection->issued_by) ? $detail_property_blacklist->inspection->issued_by : '' ?>"
												class=" col-md-4 col-xs-12" >
									 </div>

								</div>
							</div>

							<div class="form-group" <?= !empty($detail_property_blacklist->customer_infor->car_owner) ? '' : 'style="display:none"' ?> >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Tên chủ xe(không chính chủ)</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_model_property'
										   class="form-control col-md-7 col-xs-12" disabled
										   value="<?= !empty($detail_property_blacklist->customer_infor->car_owner) ? $detail_property_blacklist->customer_infor->car_owner : '' ?>">
								</div>
							</div>

							<div class="form-group" <?= !empty($detail_property_blacklist->customer_infor->phone) ? '' : 'style="display:none"' ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">CCCD/CMND/Hộ chiếu</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_model_property'
										   class="form-control col-md-7 col-xs-12" disabled
										   value="<?= !empty($detail_property_blacklist->customer_infor->identify) ? $detail_property_blacklist->customer_infor->identify : $detail_property_blacklist->customer_infor->passport ?>"><br>
									<div  class="form-control-cccd row">
										 <input type="text" name='ngay_cap' id="ngay_cap" disabled
												value="Ngày cấp: <?= !empty($detail_property_blacklist->customer_infor->date_range) ? $detail_property_blacklist->customer_infor->date_range : '' ?>"
										   class=" col-md-4 col-xs-12" ><br>
										 <input type="text" name='noi_cap' id="noi_cap" disabled
												value="Nơi cấp: <?= !empty($detail_property_blacklist->customer_infor->issued_by) ? $detail_property_blacklist->customer_infor->issued_by: '' ?>"
												class=" col-md-4 col-xs-12" >
									 </div>
								</div>
							</div>
							<div class="form-group" <?= !empty($detail_property_blacklist->customer_infor->phone) ? '' : 'style="display:none"' ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Số điện thoại</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_model_property'
										   class="form-control col-md-7 col-xs-12" disabled
										   value="<?= !empty($detail_property_blacklist->customer_infor->phone) ? $detail_property_blacklist->customer_infor->phone : '' ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Mô tả </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea class="form-control" name="description_blacklist" disabled
											  id="description_blacklist"><?= !empty($detail_property_blacklist->description) ? $detail_property_blacklist->description : '' ?></textarea>
								</div>
							</div>

						</div>
						<div class="col-xs-12 col-sm-6">
							<div>
								<div>
									<label class="control-label">Ảnh đăng ký </label>
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
																 src="<?= $value->path ?>">
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
									<label class="control-label">Ảnh đăng kiểm</label>
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
						<div class="col-xs-12 col-sm-6 text-center">
							<?php if (in_array('bo-phan-dinh-gia', $groupRoles) && $detail_property_blacklist->status == 'active') : ?>
								<a data-toggle="modal"
								   data-target="#exampleModal"
								   class="btn btn-success request_update_blacklist" id="request_update_blacklist">
									Yêu cầu cập nhật dữ liệu
								</a>
							<?php endif; ?>
						</div>
						<div class="col-xs-12 col-sm-6"></div>
					</div >

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

				</ul>
				<div id="myTabContent" class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab001">
						<?php $this->load->view('page/property/blacklist/history'); ?>
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
				<h5 class="modal-title" id="exampleModalLabel">Mô tả yêu cầu cập nhật</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea class="form-control" name="description_request_property" id="description_request_property"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
				<a type="button" class="btn btn-primary description_blacklist_property">Lưu lại</a>
			</div>
		</div>
	</div>
</div>




<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/property/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<style>
	.magnify-footer {
		bottom : 0%
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
	.form-control-cccd {
		padding-right: 10px;
		padding-left: 10px;
		margin-top: 21px;
		display: flex;
		justify-content: space-between;
	}

	.form-control-cccd input {
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


		$('.description_blacklist_property').click(function (event) {
			event.preventDefault();
			let note = $('#description_request_property').val()
			let id = $("input[name='detail_id_property']").val();
			console.log(note, id);
			let formData = new FormData();
			formData.append('updateDescription', note);
			formData.append('id', id);
			if ($("#note_request_property").val() == "") {
				$("#errorModal").modal("show");
				$(".msg_error").text('Mô tả yêu cầu cập nhật không được để trống');
			} else {
				if (confirm('Bạn chắc chắn muốn gửi yêu cầu cập nhật không ?')) {
					$.ajax({
						url: _url.base_url + 'property/createRequestUpdateBlacklist',
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
									window.location.href = _url.base_url + 'property/blacklist';
								}, 2000);
							} else {
								$("#errorModal").modal("show");
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
							$('.msg_success').text(data.msg);
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
								$('.msg_success').text(data.msg);
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



