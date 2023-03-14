<!-- page content -->
<style>
	.simpleUploader{
		min-height: 250px !important;
	}
	.form-control-cccd{
		margin-top: 0px !important;
	}
</style>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Chỉnh sửa
				</h3>
			</div>
		</div>
	</div>

	<div class="">
		<div class="x_panel">
			<div class="row col-12">
				<h2>Chỉnh sửa yêu cầu</h2>
				<div class="clearfix"></div>
			</div>
			<div class="">
				<form class="form-horizontal form-label-left"
					  enctype="multipart/form-data">
					<div class="row">
						<div class="col-xs-12 col-md-12" style="padding-top: 40px">
							<div class="form-group" disabled>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Trạng thái</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" disabled
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_blacklist->status) ? status_blacklist_property($detail_property_blacklist->status) : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Loại tài sản
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control " id="property_blacklist" onchange="get_property_infor(this);"
											name="property_blacklist" <?= (!in_array($detail_property_blacklist->status, [2])) ? "" : 'disabled' ?>>
										<?php foreach ($mainPropertyData as $property) :
											if (in_array($property->code, ['TC','NĐ'])) continue;
											?>
											<option <?php echo $detail_property_blacklist->code == $property->code ? 'selected' : ''; ?>
													value="<?= !empty($property->code) ? $property->code : '' ?>"
													data-code="<?= !empty($property->_id->{'$oid'}) ? $property->_id->{'$oid'} : '' ?>">
												<?= !empty($property->name) ? $property->name : '' ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hãng xe</label>
								<input type="text" value="<?= $detail_property_blacklist->_id->{'$oid'} ?>"
									   name="id_blacklist" hidden>
								<div class="col-md-6 col-sm-6 col-xs-12" style="color: black; font-weight: bold;">
									<select class="form-control" id="selectize_property_by_main"  <?= (!in_array($detail_property_blacklist->status, [2])) ? "" : 'disabled' ?>>
										<?php foreach ($property_branch as $branch) : ?>
											<option <?php if($detail_property_blacklist->property_id === $branch->_id->{'$oid'} ) { echo 'selected';} ?>
													value="<?= !empty($branch->_id->{'$oid'}) ? $branch->_id->{'$oid'} : '' ?>"><?php echo !empty($branch->name) ? $branch->name : '' ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group" <?= (in_array($detail_property_blacklist->status, [2])) ? "" : 'style="display:none"' ?> >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Mô tả yêu cầu cập nhật</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea name='description_update_blacklist' disabled
											  class="form-control"><?= !empty($detail_property_blacklist->update_description) ? $detail_property_blacklist->update_description : '' ?></textarea>
								</div>
							</div>
							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [3])) ? "" : 'style="display:none"' ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Tên chủ xe(không chính chủ)</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name='name' class="form-control" placeholder="Tên chủ xe">
								</div>
							</div>
							<?php if (!in_array($detail_property_blacklist->status, [3])) : ?>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<select name="change" id="change"
												class="form-control change col-md-3 col-sm-3 col-xs-12">
											<option value="CCCD" selected>CCCD/CMND <span class="text-danger">*</span></option>
											<option value="HC">Hộ chiếu <span class="text-danger">*</span></option>
										</select>
									</div>
								</div>
								<div class="form-group" id="identify_number">
									<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name='identify_number'
											   placeholder="Số CCCD/CMND"
											   class="form-control ">
									</div>
								</div>
								<div class="form-group" id="passport_number">
									<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name='passport_number'
											   placeholder="Số hộ chiếu"
											   class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-control-cccd row">
											<input type="date" name='ngay_cap' id="ngay_cap" placeholder="Ngày cấp"
												   class=" col-md-4 col-xs-12"><br>
											<input type="text" name='noi_cap' id="noi_cap" placeholder="Nơi cấp">
										</div>
									</div>
								</div>
							<?php endif; ?>
							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [3])) ? "" : 'style="display:none"' ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Số điện thoại <span
											class="text-danger">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='phone'
										   class="form-control col-md-7 col-xs-12" placeholder="Số điện thoại"
										   value="">
								</div>
							</div>
							<div class="form-group" <?= (!in_array($detail_property_blacklist->status, [2])) ? "" : 'style="display:none"' ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Ghi chú trả về</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea class="form-control" disabled name="feedback_blacklist"
											  id="feedback_blacklist"><?= $detail_property_blacklist->note ?></textarea>
								</div>
							</div>
							<br>

						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<label class="control-label">Ảnh đăng ký (đầy đủ 2 mặt)</label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id=""></div>
								<div class="uploads" id="uploads_fileReturn2">
									<?php foreach ((array)$img_dang_ky as $key => $value) :
										if (empty($value)) continue;
										?>
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
										</div>
									<?php endforeach; ?>
								</div>
							</div>

						</div>
						<?php if (!$is_black_list) : ?>
							<div class="col-xs-12 col-md-3">
								<label class="control-label">Cập nhật ảnh đăng ký xe/cavet (Mặt trước)</label>
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_front_append"></div>
									<label for="img_front_input">
										<div class="block uploader img_front_append sigle_image">
											<span>+</span>
										</div>
										<input id="img_front_input"
											   type="file"
											   name="file"
											   data-inputname="check_registrator"
											   data-unique="unique"
											   data-contain="img_front_append"
											   data-title="Ảnh đăng ký xe mặt trước"
											   data-type="front_registry" class="focus" onchange="upload_file_to_service(this)">
									</label>

								</div>
							</div>
							<div class="col-xs-12 col-md-3">
								<label class="control-label">Cập nhật ảnh đăng ký xe/cavet (Mặt sau)</label>
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_back_append"></div>
									<label for="img_back_input">
										<div class="block uploader img_back_append sigle_image">
											<span>+</span>
										</div>
										<input id="img_back_input"
											   type="file"
											   name="file"
											   data-inputname="check_registrator"
											   data-unique="unique"
											   data-contain="img_back_append"
											   data-title="Ảnh đăng ký xe mặt sau"
											   data-type="back_registry" class="focus" onchange="upload_file_to_service(this)">
									</label>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6 img_detail_dang_kiem_box" <?= ($detail_property_blacklist->code == 'OTO') ? '' : 'hidden' ?>>
							<label class="control-label">Ảnh đăng kiểm (đầy đủ 2 mặt)</label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="uploads_fileReturn3">

									<?php foreach ((array)$img_dang_kiem as $key => $value)  :
											if (empty($value)) continue;
										?>
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
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<?php if (!$is_black_list) : ?>
							<div class="col-xs-12 col-md-3 img_detail_dang_kiem_box" hidden>
								<label class="control-label">Cập nhật ảnh đăng kiểm xe (Mặt trước) </label>
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_sub_front_append"></div>
									<div class="block_unique">
										<label for="img_sub_front_input">
											<div class="block uploader img_sub_front_append sigle_image">
												<span>+</span>
											</div>
										</label>
										<input id="img_sub_front_input"
											   type="file"
											   name="file"
											   data-inputname="check_registrator"
											   data-unique="unique"
											   data-contain="img_sub_front_append"
											   data-title="Ảnh đăng kiểm xe mặt trước"
											   data-type="front_regis" class="focus" onchange="upload_file_to_service(this)">
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-3 img_detail_dang_kiem_box" hidden>
								<label class="control-label">Cập nhật ảnh đăng kiểm xe (Mặt sau) </label>
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="img_sub_back_append"></div>
									<div class="block_unique">
										<label for="img_sub_back_input">
											<div class="block uploader img_sub_back_append sigle_image">
												<span>+</span>
											</div>
										</label>
										<input id="img_sub_back_input"
											   type="file"
											   name="file"
											   data-inputname="check_registrator"
											   data-unique="unique"
											   data-contain="img_sub_back_append"
											   data-title="Ảnh đăng kiểm xe mặt sau"
											   data-type="back_regis" class="focus" onchange="upload_file_to_service(this)">
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6">
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
													<img data-type="img_another"
														 data-fileType="<?= $value->file_type ?>"
														 data-fileName="<?= $value->file_name ?>"
														 name="check_registrator"
														 data-key="<?= $value->key ?>"
														 src="<?= $value->path ?>">
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
																		data-type="img_another"
																		data-fileType="<?= $value->file_type ?>"
																		data-fileName="<?= $value->file_name ?>"
																		name="check_registrator"
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
																		data-type="img_another"
																		data-fileType="<?= $value->file_type ?>"
																		data-fileName="<?= $value->file_name ?>"
																		name="check_registrator"
																		data-key="<?= $value->key ?>"
																		src="<?= $value->path ?>"/></a>
											<?php } ?>
											<?php if (!$is_black_list) : ?>
												<button type="button" onclick="deleteImage(this)"
														data-id="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>"
														data-type="identify" data-key='<?= $value->key ?>'
														class="cancelButton">
													<i class="fa fa-times-circle"></i>
												</button>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<?php if (!$is_black_list) : ?>
							<div class="col-xs-12 col-md-6">
							<label class="control-label">Cập nhật ảnh khác</label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="img_anothers"></div>
								<label for="img_another">
									<div class="block uploader">
										<span>+</span>
									</div>
								</label>
								<input id="img_another"
									   type="file"
									   name="file"
									   data-inputname="check_registrator"
									   data-unique="multiple"
									   data-contain="img_anothers"
									   data-title="Ảnh khác" multiple
									   data-type="img_another" class="focus" onchange="upload_file_to_service(this)">
							</div>
						</div>
						<?php endif; ?>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 col-md-6"></div>
						<div class="col-xs-12 col-md-6 text-right">
							<a class="btn btn-danger" href="<?= base_url('property/requestBlacklist') ?>">
								Quay lại
							</a>
							<?php if (!in_array($detail_property_blacklist->status, [2])) : ?>
								<a class="btn btn-success" id="update_blacklist">
									Cập nhật
								</a>
							<?php endif; ?>
							<?php if (in_array($detail_property_blacklist->status, [2])) : ?>
								<a class="btn btn-success" id="update_request_into_blacklist">
									Cập nhật yêu cầu
								</a>
							<?php endif; ?>
						</div>
					</div>
					<br>
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
				<div style="text-align: right">
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


<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/property/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/upload_global/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>

<style>
	.magnify-footer {
		bottom: 0%
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
		let property_code = $('#property_blacklist').val();
		if (property_code == "OTO") {
			$('.img_detail_dang_kiem_box').show();
		} else {
			$('.img_detail_dang_kiem_box').hide();
		}

		$('#passport_number').hide();

		$('#change').change(function (event) {
			event.preventDefault();
			if ($(this).val() == 'CCCD') {
				$('#identify_number').show();
				$('#passport_number').hide();
			} else {
				$('#identify_number').hide();
				$('#passport_number').show();
			}
		});

		$('#add_comment_blacklist').click(function (event) {
			event.preventDefault();
			let id = $("input[name='id_blacklist']").val();
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

		$('#update_request_into_blacklist').click(function (event) {
			event.preventDefault();
			let id = $("input[name='id_blacklist']").val();
			let identify = $("input[name='identify_number']").val();
			let passport = $("input[name='passport_number']").val();
			if ($('#change').val() == 'CCCD') {
				passport = ''
			} else {
				identify = ''
			}
			let noi_cap = $("input[name='noi_cap']").val();
			let ngay_cap = $("input[name='ngay_cap']").val();
			let phone = $("input[name='phone']").val();
			let name = $("input[name='name']").val();
			let loai_xe = $("select[name='property_blacklist']").val();
			let count_img = $("img[name='check_registrator']").length;
			let front_registration_img = "";
			let back_registration_img = "";
			let front_regis_car_img = "";
			let back_regis_car_img = "";
			let another_img = {};
			if (count_img > 0) {
				$("img[name='check_registrator']").each(function () {
					let data_single_img = "";
					let data_multiple_img = {};
					let key = $(this).attr('data-key');
					type = $(this).data('type');
					data_single_img = $(this).attr('src');
					data_multiple_img['file_type'] = $(this).attr('data-filetype');
					data_multiple_img['file_name'] = $(this).attr('data-filename');
					data_multiple_img['path'] = $(this).attr('src');
					data_multiple_img['key'] = key;
					if (type == 'front_registry') {
						front_registration_img = data_single_img;
					}
					if (type == 'back_registry') {
						back_registration_img = data_single_img;
					}
					if (type == 'front_regis') {
						front_regis_car_img = data_single_img;
					}
					if (type == 'back_regis') {
						back_regis_car_img = data_single_img;
					}
					if (type == 'img_another') {
						another_img[key] = data_multiple_img;
					}
				});
			}


			let another_img_file = JSON.stringify(another_img)
			let formData = new FormData();
			formData.append('id', id)
			formData.append('identify', identify)
			formData.append('passport', passport)
			formData.append('noi_cap', noi_cap)
			formData.append('ngay_cap', ngay_cap)
			formData.append('phone', phone)
			formData.append('name', name)
			formData.append('loai_xe', loai_xe)
			formData.append('front_registration_img', front_registration_img);
			formData.append('back_registration_img', back_registration_img);
			formData.append('front_regis_car_img', front_regis_car_img);
			formData.append('back_regis_car_img', back_regis_car_img);
			formData.append('another_img_file', another_img_file);
			if (confirm('Bạn chắc chắn muốn chỉnh sửa ?')) {
				$.ajax({
					url: _url.base_url + 'property/updateRequestBlacklist',
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
				});
			}

		})

		$('#update_blacklist').click(function (event) {
			event.preventDefault();
			let id = $("input[name='id_blacklist']").val();
			let loai_xe = $("select[name='property_blacklist']").val();
			let property_id = $("#selectize_property_by_main").val()
			let name = $("input[name='name_blacklist']").val();
			let count_img = $("img[name='check_registrator']").length;
			let front_registration_img = "";
			let back_registration_img = "";
			let front_regis_car_img = "";
			let back_regis_car_img = "";
			let another_img = {};
			if (count_img > 0) {
				$("img[name='check_registrator']").each(function () {
					let data_single_img = "";
					let data_multiple_img = {};
					let key = $(this).attr('data-key');
					type = $(this).data('type');
					data_single_img = $(this).attr('src');
					data_multiple_img['file_type'] = $(this).attr('data-filetype');
					data_multiple_img['file_name'] = $(this).attr('data-filename');
					data_multiple_img['path'] = $(this).attr('src');
					data_multiple_img['key'] = key;
					if (type == 'front_registry') {
						front_registration_img = data_single_img;
					}
					if (type == 'back_registry') {
						back_registration_img = data_single_img;
					}
					if (type == 'front_regis') {
						front_regis_car_img = data_single_img;
					}
					if (type == 'back_regis') {
						back_regis_car_img = data_single_img;
					}
					if (type == 'img_another') {
						another_img[key] = data_multiple_img;
					}
				});
			}


			let another_img_file = JSON.stringify(another_img)

			let formData = new FormData();
			formData.append('id', id)
			formData.append('property_id', property_id)
			formData.append('loai_xe', loai_xe)
			formData.append('name', name)
			formData.append('front_registration_img', front_registration_img);
			formData.append('back_registration_img', back_registration_img);
			formData.append('front_regis_car_img', front_regis_car_img);
			formData.append('back_regis_car_img', back_regis_car_img);
			formData.append('another_img_file', another_img_file);
			if (confirm('Bạn chắc chắn muốn chỉnh sửa ?')) {
				$.ajax({
					url: _url.base_url + 'property/updateFeedback',
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
				});
			}
		});
	});
</script>


