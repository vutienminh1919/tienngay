<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Quản lý khu vực nhân viên THN
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('debt_manager_app/get_list_radio') ?>">Quản lý tỉ lệ hoàn
							thành
							THN</a>
					</small>
				</h3>
			</div>
		</div>
		<div class="table-responsive">
			<div class="title_right text-right">
				<button class="btn btn-info modal_area" data-toggle="modal" data-target="#addNewRadioEmploy"><i
							class="fa fa-plus" aria-hidden="true"></i> Thêm mới
				</button>
			</div>
			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th>#</th>
					<th>Tháng/Năm</th>
					<th>B1</th>
					<th>B2</th>
					<th>B3</th>
					<th>B4</th>
					<th>B5</th>
					<th>B6</th>
					<th>B7</th>
					<th>B8</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php if (!empty($radio)) : ?>
					<?php foreach ($radio as $key => $r) : ?>
						<tr id="radio-user-<?php echo $r->_id->{'$oid'} ?>">
							<td><?php echo ++$key ?></td>
							<td><?php echo $r->month . '/' . $r->year ?></td>
							<td><?php echo $r->B1 ?></td>
							<td><?php echo $r->B2 ?></td>
							<td><?php echo $r->B3 ?></td>
							<td><?php echo $r->B4 ?></td>
							<td><?php echo $r->B5 ?></td>
							<td><?php echo $r->B6 ?></td>
							<td><?php echo $r->B7 ?></td>
							<td><?php echo $r->B8 ?></td>
							<td>
								<button class="btn btn-success radioUpdate"
										data-id="<?php echo $r->_id->{'$oid'} ?>" data-toggle="modal"
										data-target="#updateRadioEmploy"
										onclick="showAndUpdate('<?php echo $r->_id->{'$oid'} ?>')">
									<span class="glyphicon glyphicon-edit"></span>
								</button>
								<button class="btn btn-danger radioBlock"
										data-id="<?php echo $r->_id->{'$oid'} ?>">
									<span class="glyphicon glyphicon-trash"></span>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
			<div class="">
				<?php ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addNewRadioEmploy" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm mới </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name=""/>
						<div class="form-group pb-5">
							<label class="control-label col-md-3">Chọn Tháng:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<select class="form-control" name="month_radio" id="month_radio">
									<option class="text-center" value="">--Chọn Tháng--</option>
									<option class="text-center" value="1">Tháng 1</option>
									<option class="text-center" value="2">Tháng 2</option>
									<option class="text-center" value="3">Tháng 3</option>
									<option class="text-center" value="4">Tháng 4</option>
									<option class="text-center" value="5">Tháng 5</option>
									<option class="text-center" value="6">Tháng 6</option>
									<option class="text-center" value="7">Tháng 7</option>
									<option class="text-center" value="8">Tháng 8</option>
									<option class="text-center" value="9">Tháng 9</option>
									<option class="text-center" value="10">Tháng 10</option>
									<option class="text-center" value="11">Tháng 11</option>
									<option class="text-center" value="12">Tháng 12</option>
								</select>
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn Năm:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="year_radio" id="year_radio"
									   placeholder="--Chọn Năm--">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B1:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b1_radio" id="b1" placeholder="nhập tỉ lệ B1">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B2:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b2_radio" id="b2" placeholder="nhập tỉ lệ B2">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B3:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b3_radio" id="b3" placeholder="nhập tỉ lệ B3">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B4:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b4_radio" id="b4" placeholder="nhập tỉ lệ B4">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B5:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b5_radio" id="b5" placeholder="nhập tỉ lệ B5">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B6:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b6_radio" id="b6" placeholder="nhập tỉ lệ B6">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B7:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b7_radio" id="b7" placeholder="nhập tỉ lệ B7">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B8:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b8_radio" id="b8" placeholder="nhập tỉ lệ B8">
							</div>
						</div>
						<br>
						<br>
						<div style="text-align: center" id="group-button">
							<!--							<button type="button" id="company_btnSave" class="btn btn-info">Lưu</button>-->
							<input type="button" id="radio_btnSave" class="btn btn-info" value="Lưu">
							<button type="button" class="btn btn-primary company_close" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="updateRadioEmploy" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title title_radio_update text-primary" style="text-align: center">Cập nhật </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="id_radio_update"/>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B1:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b1_radio_update" id="b1_radio_update"
									   placeholder="nhập tỉ lệ B1">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B2:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b2_radio_update" id="b2_radio_update"
									   placeholder="nhập tỉ lệ B2">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B3:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b3_radio_update" id="b3_radio_update"
									   placeholder="nhập tỉ lệ B3">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B4:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b4_radio_update" id="b4_radio_update"
									   placeholder="nhập tỉ lệ B4">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B5:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b5_radio_update" id="b5_radio_update"
									   placeholder="nhập tỉ lệ B5">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B6:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b6_radio_update" id="b6_radio_update"
									   placeholder="nhập tỉ lệ B6">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B7:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b7_radio_update" id="b7_radio_update"
									   placeholder="nhập tỉ lệ B7">
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn tỉ lệ B8:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<input class="form-control" name="b8_radio_update" id="b8_radio_update"
									   placeholder="nhập tỉ lệ B8">
							</div>
						</div>
						<br>
						<br>
						<div style="text-align: center" id="group-button">
							<!--							<button type="button" id="company_btnSave" class="btn btn-info">Lưu</button>-->
							<input type="button" id="update_radio_btnSave" class="btn btn-info" value="Lưu">
							<button type="button" class="btn btn-primary company_close" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/debt/radio.js"></script>



