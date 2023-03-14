
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Sửa thông báo</h4>
		<div class="theloading" style="display:none;" >
			<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
			<span><?= $this->lang->line('Loading') ?>...</span>
		</div>
	</div>

	<div class="modal-body table-responsive">
		<table class="table table-borderless">
			<thead>
			<tr>
				<th colspan="4">
					<strong>THÔNG BÁO CHI TIẾT</strong>
				</th>
				<div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_errorEdit">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<span class='div_errorEdit'></span>
				</div>
			</tr>
			</thead>
			<tbody>
			<tr>
				<input type="hidden" id="notification_id" value="" name="notification_id">
				<th>Loại thông báo <span class="text-danger">*</span></th>
				<td><select class="form-control" id="notification_type_1" name="notification_type_1">
						<option value="Thông báo">Thông báo</option>
						<option value="Quyết định">Quyết định</option>
						<option value="Quy định">Quy định</option>
					</select></td>

				<th>Mức độ ưu tiên <span class="text-danger">*</span></th>
				<td><select class="form-control" id="priority_level_1" name="priority_level">
						<option value="Cao">Cao</option>
						<option value="Thấp">Thấp</option>
					</select></td>
			</tr>

			<tr>
				<th>Tiêu đề <span class="text-danger">*</span></th>
				<td>
					<input class="form-control" type="text" id="title_1" name="title" maxlength="50">
				</td>
			</tr>

			<tr>
				<th>Nội dung <span class="text-danger">*</span></th>
				<td colspan="3"><textarea class="form-control" id="content_1" name="content_1" rows="8"
										  cols="80" maxlength="1000"></textarea></td>
			</tr>

			<tr>
				<th>Thời gian bắt đầu <span class="text-danger">*</span></th>
				<td>
					<input class="form-control" type="" id="start_date_1" name="start_date" placeholder="dd-mm-YYYY">
				</td>
				<th>Thời gian kết thúc </th>
				<td>
					<input class="form-control" type="" id="end_date_1" name="end_date" placeholder="dd-mm-YYYY">
				</td>
			</tr>

			<tr>
				<th>Bộ phận áp dụng <span class="text-danger">*</span></th>
				<td>
					<select class="form-control" id="selectize_role_1" name="selectize_role_1[]" multiple="multiple"
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
					<input id="selectize_role_value_1" style="display: none">
				</td>
				<th style="display: none" class="gdv_vm">Vùng miền <span class="text-danger">*</span></th>
				<td style="display: none" class="gdv_vm">
					<select class="form-control" id="selectize_area_1" name="selectize_area_1[]"
							multiple="multiple">
						<option value="">Chọn vùng miền</option>
						<?php
						if (!empty($areaData)) {
							foreach ($areaData as $key => $area) {
								?>
								<option value="<?= !empty($area->code) ? $area->code : ""; ?>"><?= !empty($area->title) ? $area->title : ""; ?></option>
							<?php }
						} ?>
					</select>
					<input id="selectize_area_value_1" style="display: none">
				</td>

			</tr>

			<tr>
				<th>Hình ảnh, video:</th>
				<td colspan="3">
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads" id="uploads_identify_1">

						</div>
						<label for="uploadinput_1">
							<div class="block uploader">
								<span>+</span>
							</div>
						</label>
						<input id="uploadinput_1" type="file" name="file"
							   data-contain="uploads_identify_1" data-title="Hồ sơ nhân thân" multiple
							   data-type="identify" class="focus">
					</div>

				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary edit_notification">Sửa thông báo</button>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/financial_handbook/index.js"></script>
<script>
	CKEDITOR.replace( 'content_1', {height:['200px'],language:'vi' } );
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('body', {height: 200});
</script>
<script>
	CKEDITOR.replace( 'content_1',  {height:['200px'] } );
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
