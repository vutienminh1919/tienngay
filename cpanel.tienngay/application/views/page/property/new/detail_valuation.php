<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Thêm mới tài sản
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?= base_url('property/valuation_property') ?>">Danh sách định giá tài sản</a>
					</small>
				</h3>
			</div>
		</div>
	</div>

	<div class="">
		<div class="x_panel">
			<div class="row col-12">
				<h2>Chi tiết định giá tài sản</h2>
				<div class="clearfix"></div>
			</div>
			<div class="">
				<form class="form-horizontal form-label-left"
					  enctype="multipart/form-data">
					<div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Trạng thái tài
									sản</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="detail_status_property" class="form-control" disabled
										   value="<?= status_valuation_property($detail_property_valuation->status_valuation) ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tên tài sản
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_name_property' id="detail_name_property"
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_valuation->str_name) ? $detail_property_valuation->str_name : '' ?>">
									<input type="text" value="<?= $detail_property_valuation->_id->{'$oid'} ?>"
										   name="detail_id_property" hidden>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Loại tài sản
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control " id="detail_type_xm_oto" name="detail_type_xm_oto"
											disabled>
										<?php if ($detail_property_valuation->type == 'XM') : ?>
											<option value="XM">Xe máy</option>
										<?php elseif ($detail_property_valuation->type == 'OTO') : ?>
											<option value="OTO">Ô tô</option>
										<?php endif; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Năm sản xuất
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_year_property' id="detail_year_property"
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_valuation->year_property) ? $detail_property_valuation->year_property : '' ?>">
								</div>
							</div>

							<div class="form-group"
								 phan_khuc_oto_box <?= $detail_property_valuation->type == "OTO" ? " " : 'style="display:none"' ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phân khúc tài
									sản(ô tô)
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control" name="detail_phan_khuc_oto" id="detail_phan_khuc_oto">
										<option selected
												value="<?= $detail_property_valuation->phan_khuc_oto ?>"><?= $detail_property_valuation->phan_khuc_oto ?></option>
										<option value="A">A</option>
										<option value="B">B</option>
										<option value="C">C</option>
										<option value="D">D</option>
									</select>
								</div>
							</div>

							<div class="form-group"
								 phan_khuc_xm_box <?= $detail_property_valuation->type == "XM" ? " " : 'style="display:none"' ?>>
								<div <?= in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'style="display:none"' ?> >
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phân khúc
										tài
										sản(xe máy)
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<select class="form-control" name="detail_phan_khuc_xm"
												id="detail_phan_khuc_xm">
											<?php if (!empty($detail_property_valuation->phan_khuc_xm)) : ?>
												<option selected
														value="<?= $detail_property_valuation->phan_khuc_xm ?>"><?= $detail_property_valuation->phan_khuc_xm ?></option>
											<?php else : ?>
												<option selected value="">--Chọn phân khúc--</option>
											<?php endif; ?>
											<option value="A">A</option>
											<option value="B">B</option>
											<option value="C">C</option>
											<option value="D">D</option>
										</select>
									</div>
								</div>

							</div>

							<div class="form-group type_xm_box" <?= $detail_property_valuation->type == "XM" ? " " : 'style="display:none"' ?> >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Loại xe</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="detail_type_property_xm" id="detail_type_property_xm"
											class="form-control">
										<option value="<?= $detail_property_valuation->type_property_xm ?>"
												selected><?= type_property($detail_property_valuation->type_property_xm) ?></option>
										<option value="1">Xe ga</option>
										<option value="2">Xe số</option>
										<option value="3">Xe côn</option>
										<option value="4">Lithium</option>
										<option value="5">Ắc quy</option>
									</select>
								</div>
							</div>

							<div class="form-group type_oto_box" <?= $detail_property_valuation->type == "OTO" ? " " : 'style="display:none"' ?> >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Loại xe</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="detail_type_property_oto" id="detail_type_property_oto"
											class="form-control">
										<option value="<?= $detail_property_valuation->type_property_oto ?>"
												selected><?= $detail_property_valuation->type_property_oto ?></option>
										<option value="AT">AT</option>
										<option value="MT">MT</option>
									</select>
								</div>
							</div>
							<div class="form-group made_by_oto_box" <?= $detail_property_valuation->type == "OTO" ? " " : 'style="display:none"' ?> >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Xuất xứ </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_made_in' id="detail_made_in"
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_valuation->xuat_xu) ? $detail_property_valuation->xuat_xu : '' ?>">
								</div>
							</div>

							<div class="form-group gas_or_oil_oto_box" <?= $detail_property_valuation->type == "OTO" ? " " : 'style="display:none"' ?>>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Bản Xăng/Dầu </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select id="detail_gas_or_oil" name="detail_gas_or_oil" class="form-control">
										<option value="<?= $detail_property_valuation->ban_xang_dau ?>"
												selected><?= $detail_property_valuation->ban_xang_dau ?></option>
										<option value="Xăng">Xăng</option>
										<option value="Dầu">Dầu</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Hãng xe </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_brand_property' id="detail_brand_property"
										   value="<?= !empty($detail_property_valuation->hang_xe) ? $detail_property_valuation->hang_xe : '' ?>"
										   class="form-control col-md-7 col-xs-12">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Model</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_model_property'
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_valuation->name) ? $detail_property_valuation->name : '' ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Giá để xuất</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name='detail_price_suggest_property'
										   class="form-control col-md-7 col-xs-12"
										   value="<?= !empty($detail_property_valuation->price_suggest) ? number_format($detail_property_valuation->price_suggest) : '' ?>" <?= in_array('bo-phan-dinh-gia', $groupRoles) ? 'disabled' : '' ?>>
								</div>

							</div>


							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Mô tả</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea
										name='detail_description_property' <?= in_array('bo-phan-dinh-gia', $groupRoles) ? 'disabled' : '' ?>
										  class="form-control col-md-6 col-xs-12"><?= !empty($detail_property_valuation->description) ? $detail_property_valuation->description : '' ?></textarea>
								</div>
							</div>


							<br>

							<div class="form-group" <?= !empty($detail_property_valuation->note) ? '' : 'style="display:none"' ?> >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Ghi chú</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea name="detail_note_property"
										  class="form-control " <?= $detail_property_valuation->status_valuation == 'note' ? 'disabled' : " " ?>><?= !empty($detail_property_valuation->note) ? $detail_property_valuation->note : '' ?></textarea>
								</div>
							</div>
							<br>

							<div class="form-group" <?= in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'disabled' ?> >
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Giá tài sản </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php if (!empty($price)) : ?>
										<input type="text"
											   class="form-control col-md-7 col-xs-12"
											   value="<?= !empty($price) ? $price : '' ?>" disabled>
									<?php else : ?>
										<input type="text" name="valuation_price_property"
											   id="valuation_price_property"
											   class="form-control col-md-7 col-xs-12">
									<?php endif; ?>
								</div>
							</div>

							<div class="form-group" <?= in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'style="display:none"' ?>>
								<div <?= in_array($detail_property_valuation->status_valuation, [5, 6, 3, 4]) ? 'style="display:none"' : '' ?>
										style="display:flex;justify-content: center ; ">
									<a class="btn btn-primary"
									   id="submit_add_price_property" <?= in_array($detail_property_valuation->status_valuation, [2, 4]) ? 'style="display:none"' : 'style="display:flex;align-items: center"' ?> >Yêu
										cầu duyệt</a>
									<a class="btn btn-warning" id="feedback_valuation_property"

									   data-toggle="modal" <?= in_array($detail_property_valuation->status_valuation, [4, 2]) ? 'style="display:none"' : ' style="display:flex;align-items: center"' ?>
									   data-target="#exampleModal">Trả về </a><br><br>
									<a class="btn btn-info"
									   id="update_property" <?= in_array($detail_property_valuation->status_valuation, [2]) ? 'style="display:none"' : ' style="display:flex;align-items: center"' ?>>Cập
										nhật</a>
									<a class="btn btn-danger"
									   id="cancel_valuation_property" <?= in_array($detail_property_valuation->status_valuation, [1]) ? 'style="display:flex;align-items: center"' : 'style="display:none"' ?> >Hủy</a><br>
								</div>

							</div>

							<div class="form-group" <?= !in_array('bo-phan-dinh-gia', $groupRoles) ? '' : 'style="display:none"' ?>>
								<div style="display:flex;justify-content: center;">
									<a class="btn btn-danger"
									   id="update_after_feedback_property" <?= in_array($detail_property_valuation->status_valuation, [4]) ? '' : 'style="display:none"' ?> >Cập
										nhật yêu cầu</a>
								</div>
							</div>
						</div>
					</div>
					<div>
						<div class="col-sm-6">
							<div>
								<label class="control-label">Ảnh tài sản (Tối đa 6 ảnh) </label>
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
															class="cancelButton "><i class="fa fa-times-circle" <?= (!in_array('bo-phan-dinh-gia', $groupRoles)) && (in_array($detail_property_valuation->status_valuation, [4])) ? '' : 'style="display:none"' ?>></i>
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
														class="cancelButton" <?= (!in_array('bo-phan-dinh-gia', $groupRoles)) && (in_array($detail_property_valuation->status_valuation, [4])) ? '' : 'style="display:none"' ?>><i class="fa fa-times-circle"></i>
												</button>
											</div>
										<?php endforeach; ?>
									</div>
									<label for="uploadinput1">
										<div class="block uploader" <?= (!in_array('bo-phan-dinh-gia', $groupRoles)) && (in_array($detail_property_valuation->status_valuation, [4])) ? '' : 'style="display:none"' ?>>
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput1" type="file" name="file"
										   data-contain="uploads_fileReturn1" data-title="Ảnh chi tiết " multiple
										   data-type="fileReturn"
										   class="focus" <?= (in_array('bo-phan-dinh-gia', $groupRoles)) ? 'disabled' : '' ?>>
								</div>
							</div>
							<div>
								<div>
									<label class="control-label">Ảnh đăng ký (2 ảnh) </label>

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
															class="cancelButton" <?= (!in_array('bo-phan-dinh-gia', $groupRoles)) && (in_array($detail_property_valuation->status_valuation, [4])) ? '' : 'style="display:none"' ?>><i class="fa fa-times-circle"></i>
													</button>
												</div>
											<?php endforeach; ?>
										</div>
										<label for="uploadinput2">
											<div class="block uploader" <?= (!in_array('bo-phan-dinh-gia', $groupRoles)) && (in_array($detail_property_valuation->status_valuation, [4])) ? '' : 'style="display:none"' ?>>
												<span>+</span>
											</div>
										</label>
										<input id="uploadinput2" type="file" name="file"
											   data-contain="uploads_fileReturn2" data-title="Ảnh đăng ký" multiple
											   data-type="fileReturn"
											   class="focus" <?= (in_array('bo-phan-dinh-gia', $groupRoles))  && (!in_array($detail_property_valuation->status_valuation, [4])) ? 'disabled' : '' ?> >
									</div>
								</div>
								<div class="img_detail_dang_kiem_box" <?= ($detail_property_valuation->type == 'OTO') ? '' : 'hidden' ?>>
									<label class="control-label">Ảnh đăng kiểm (2 ảnh)</label>
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
															class="cancelButton" <?= (!in_array('bo-phan-dinh-gia', $groupRoles))  && (in_array($detail_property_valuation->status_valuation, [4])) ? '' : 'style="display:none"' ?>><i class="fa fa-times-circle"></i>
													</button>
												</div>
											<?php endforeach; ?>
										</div>
										<label for="uploadinput3">
											<div class="block uploader" <?= (!in_array('bo-phan-dinh-gia', $groupRoles))  && (in_array($detail_property_valuation->status_valuation, [4])) ? '' : 'style="display:none"' ?>>
												<span>+</span>
											</div>
										</label>
										<input id="uploadinput3" type="file" name="file"
											   data-contain="uploads_fileReturn3" data-title="Ảnh đăng kiểm"
											   multiple
											   data-type="fileReturn"
											   class="focus" <?= (in_array('bo-phan-dinh-gia', $groupRoles)) && (!in_array($detail_property_valuation->status_valuation, [4])) ? 'disabled' : '' ?>>
									</div>
								</div>
								<div>
								</div>
							</div>
						</div>
					</div>

				</form>
				<div class="col-xs-12">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#tab_content1" role="tab" id="tab001" data-toggle="tab" aria-expanded="false">Hoạt động</a></li>
							<div <?= in_array('bo-phan-dinh-gia', $groupRoles) ? 'style="text-align: right"' : 'style="display:none"' ?>>
								<li><a  data-toggle="modal" data-target="#modalComment" type="button" name="comment" id="comment" class="btn btn-success">Comment</a></li>
							</div>
						</ul>
						<div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab001">
								<?php $this->load->view('page/property/tab_detail/tab_hoat_dong'); ?>
							</div>
						</div>
					</div>
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
				<h5 class="modal-title" id="exampleModalLabel">Ghi chú trả về tài sản</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea class="form-control" name="note_valuation_property" id="note_valuation_property"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
				<a type="button" class="btn btn-primary note_property">Lưu lại</a>
			</div>
		</div>
	</div>
</div>

<!-- Modal Comment -->
<div class="modal fade-sm" id="modalComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Phản hồi định giá tài sản</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea class="form-control" name="comment_modal" id="comment_modal"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
				<a type="button" class="btn btn-primary" id="comment_property">Lưu lại</a>
			</div>
		</div>
	</div>
</div>

<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/property/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
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

		$('#cancel_valuation_property').click(function (event) {
			event.preventDefault();
			let id = $("input[name='detail_id_property']").val();
			let formData = new FormData();
			formData.append('id', id);
			if (confirm('Bạn chắc chắn muốn hủy định giá tài sản này ?')) {
				$.ajax({
					url: _url.base_url + 'property/cancel_valuation_property',
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
								window.location.href = _url.base_url + 'property/valuation_property';
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


		$('#submit_add_price_property').click(function (event) {
			event.preventDefault();
			let price = $("input[name='valuation_price_property']").val()
			let phan_khuc_xm = $("select[name='detail_phan_khuc_xm']").val();
			let id = $("input[name='detail_id_property']").val();
			let type_xm_oto = $("select[name='detail_type_xm_oto']").val();
			let formData = new FormData();
			formData.append('price', price);
			formData.append('id', id);
			formData.append('phan_khuc_xm', phan_khuc_xm);
			formData.append('type_xm_oto', type_xm_oto);
			if ($("input[name='valuation_price_property']").val() == "") {
				$("#errorModal").modal("show");
				$(".msg_error").text('Giá tài sản không được để trống');
			}else if(type_xm_oto == 'XM' && phan_khuc_xm == ''){
				$("#errorModal").modal("show");
				$(".msg_error").text('Phân khúc xe máy không được để trống');
			}
			else {
				if (confirm('Bạn chắc chắn muốn định giá tài sản này ?')) {
					$.ajax({
						url: _url.base_url + 'property/update_price_valuation_property',
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
									window.location.href = _url.base_url + 'property/valuation_property';
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
			}

		});

		$('.note_property').click(function (event) {
			event.preventDefault();
			let note = $('#note_valuation_property').val()
			let id = $("input[name='detail_id_property']").val();
			console.log(note, id);
			let formData = new FormData();
			formData.append('note', note);
			formData.append('id', id);
			if ($("#note_valuation_property").val() == "") {
				$("#errorModal").modal("show");
				$(".msg_error").text('Ghi chú trả về không được để trống');
			} else {
				if (confirm('Bạn chắc chắn muốn trả về ghi chú tài sản này ?')) {
					$.ajax({
						url: _url.base_url + 'property/note_valuation_property',
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
								$('.msg_success').text(data.msg);
								setTimeout(function () {
									window.location.href = _url.base_url + 'property/valuation_property';
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

		$('#comment_property').click(function (event) {
			event.preventDefault();
			let  comment = $('#comment_modal').val()
			console.log(comment);
			let id = $("input[name='detail_id_property']").val();
			let formData = new FormData();
			formData.append('comment', comment);
			formData.append('id', id);
			if ($("#comment_modal").val() == "") {
				$("#errorModal").modal("show");
				$(".msg_error").text('Phản hổi không được để trống');
			} else {
				$.ajax({
					url: _url.base_url + 'property/comment_valuation',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$('#modalComment').modal('hide');
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
			let name = $("input[name='detail_name_property']").val();
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
			formData.append('name', name)
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

