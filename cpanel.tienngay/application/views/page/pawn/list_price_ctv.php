<?php
//$vehicles=! empty($_GET[ 'vehicles']) ? $_GET[ 'vehicles'] : "";
//$name_property=! empty($_GET[ 'name_property']) ? $_GET[ 'name_property'] : "";
$key=! empty($_GET['key']) ? $_GET['key'] : "";
$phone=! empty($_GET['phone']) ? $_GET['phone'] : "";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
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
								Lịch sử thanh toán
							</span>
						</div>
					</div>
					<div class="col-xs-4 text-right">
						<div class="btn_list_filter text-right mt-0">

							<div class="button_functions btn-fitler">
								<button class="btn btn-secondary btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-filter"></i>
								</button>
								<div class="dropdown-menu drop_select" aria-labelledby="dropdownMenuButton">
									<div class="card-body">
										<form method="get" action="<?php echo base_url('accountant/search_list_price_ctv') ?>">
											<div class="mb-3">
												<div class="text-large" style="color: #333;font-weight: 600;text-transform: uppercase;">Lọc dữ liệu</div>
												<hr style="margin: 5px 0;">
											</div>
											<div class="form-group mb-3">
												<label class="form-label"><strong>Mã giao dịch</strong>
												</label>
												<div>
													<input type="text" name="key" class="form-control" value="" autocomplete="off" placeholder="Mã giao dịch">
												</div>
											</div>
											<div class="form-group mb-3">
												<label class="form-label"><strong>Số điện thoại</strong>
												</label>
												<div>
													<input type="number" name="phone" class="form-control" value="" autocomplete="off" placeholder="Số điện thoại">
												</div>
											</div>
											<div class="form-group mb-3">
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
											</div>
											<div class="form-group text-right">
												<button type="submit" class="btn btn-success btn_search">
													Tìm kiếm
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="middle table_tabs">
				<div class="table-responsive" style="min-height: 500px; overflow: auto;">
					<table id="" class="table table-striped">
						<thead>
						<tr style="text-align: center">
							<th style="text-align: left;">STT</th>
							<th style="text-align: left;">Tên CTV</th>
							<th style="text-align: center">Số điện thoại</th>
							<th style="text-align: center">Tình trạng xác thực</th>
							<th style="text-align: center">Tên khách hàng</th>
							<th style="text-align: center">Số điện thoại KH</th>
							<th style="text-align: center">Số tiền thanh toán</th>
							<th style="text-align: center">Mã giao dịch</th>
							<th style="text-align: center">Sản phẩm</th>
							<th style="text-align: center">Giá trị sp</th>
							<th style="text-align: center">Tiền hoa hồng</th>
							<th style="text-align: center">Ngày thanh toán</th>
							<th style="text-align: center">Ngân hàng thụ hưởng</th>
							<th style="text-align: center">Số tài khoản</th>
							<th style="text-align: center">Trạng thái</th>
							<th style="text-align: center">Ảnh</th>
							<th style="text-align: center"></th>
						</tr>
						</thead>
						<tbody align="center">
						<?php if (!empty($lead_ctv)): ?>
							<?php foreach ($lead_ctv as $key => $value) : ?>
								<tr id="propertyOto-<?php echo $value->_id->{'$oid'} ?>">
									<td style="text-align: left;"><?= ++$key ?></td>
									<td style="text-align: left;"><?= !empty($value->collaborator->ctv_name) ? $value->collaborator->ctv_name : "" ?></td>
									<td><?= !empty($value->collaborator->ctv_phone) ? $value->collaborator->ctv_phone : "" ?></td>
									<td>
										<?php if ($value->collaborator->status_verified == 1) : ?>
											<span class="label label-danger" style="font-size: 13px;">Chưa xác thực</span>
										<?php elseif ($value->collaborator->status_verified == 2): ?>
											<span class="label label-default" style="font-size: 13px;">Đang chờ xác thực</span>
										<?php elseif ($value->collaborator->status_verified == 3): ?>
											<span class="label label-success" style="font-size: 13px;">Đã xác thực</span>
										<?php elseif ($value->collaborator->status_verified == 4): ?>
											<span class="label label-info" style="font-size: 13px;">Xác thực lại</span>
										<?php endif; ?>
									</td>

									<td><?= !empty($value->fullname) ? $value->fullname : "" ?></td>
									<td><?= !empty($value->phone_number) ? $value->phone_number : "" ?></td>
									<td><?= !empty($value->his_money) ? number_format($value->his_money) : "" ?></td>
									<td><?= !empty($value->his_key) ? $value->his_key : "" ?></td>
									<td><?= !empty($value->type_finance) ? lead_type_finance($value->type_finance)  : "" ?></td>
									<td><?= !empty($value->price) ? number_format($value->price) : 0 ?></td>
									<td><?= !empty($value->tien_hoa_hong) ? number_format($value->tien_hoa_hong) : 0 ?></td>
									<td><?= !empty($value->date_pay) ? date('d/m/Y H:i:s', $value->date_pay) : "" ?></td>
									<td><?= !empty($value->bank_name) ?  $value->bank_name : (!empty($value->account_bank->bank->name) ? $value->account_bank->bank->name  : "") ?></td>
									<td><?= !empty($value->bank_account) ?  $value->bank_account : (!empty($value->account_bank->stk_user) ? $value->account_bank->stk_user  : "") ?></td>
									<td>
										<?php if ($value->payment_status == 1) : ?>
											<span class="label label-success" style="font-size: 13px;">Thanh toán thành công</span>
										<?php elseif ($value->payment_status == 2): ?>
											<span class="label label-default" style="font-size: 13px;">Chờ ngân lượng xử lý</span>
										<?php elseif ($value->payment_status == 3): ?>
											<span class="label label-danger" style="font-size: 13px;">Thanh toán thất bại</span>
										<?php else : ?>
											<span class="label label-info" style="font-size: 13px;">Chưa xử lý</span>
										<?php endif; ?>
									</td>
									<td>
										<?php if (!empty($value->img_approve)): ?>
											<?php
											$key_identify = 0;
											foreach((array)$value->img_approve as $key1 => $item) {
												$key_identify++;
												if(empty($item)) continue;?>
												<div class="block">
													<!--//Image-->
													<?php if(!empty($item->file_type) && ($item->file_type == 'image/png' || $item->file_type == 'image/jpg' || $item->file_type == 'image/jpeg')) {?>
														<a href="<?= $item->path ?>"
														   class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"
														   data-caption="ảnh giao dịch thanh toán <?php echo $key_identify ?>">
															<img style="width: 150px; height: 100px" class="" src="<?= $item->path?>" alt="">
														</a>

													<?php }?>
												</div>
											<?php }?>
										<?php endif; ?>
									</td>
									<td>
										<?php if (!in_array($value->payment_status, [1,2]) ) : ?>
										<button class="btn btn-success btn_edit"  onclick="edit('<?= $value->_id->{'$oid'} ?>')" >
											<i class="fa fa-edit"></i>
										</button>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>
					<div class="">
						<?php echo $pagination ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="addhistory" >
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">
					THANH TOÁN TIỀN</h5>
			</div>
			<div class="modal-body" id="content_edit">
				<form>
					<input id="lead_id" type="hidden" value="">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Ngày thanh toán:</label>
						<input type="date" class="form-control" id="date_pay">
					</div>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Số tiền thanh toán:</label>
						<input type="number" class="form-control" id="his_money">
					</div>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Mã giao dịch:</label>
						<input type="text" class="form-control" id="his_key">
					</div>

					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Ảnh upload:
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">

						<div id="SomeThing" class="simpleUploader">
							<div class="uploads " id="uploads_presenter">
							</div>
							<label for="uploadinput">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput" type="file" name="file"
								   data-contain="uploads_presenter" data-title="Hồ sơ nhân thân" multiple
								   data-type="presenter" class="focus">
						</div>


					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn_cancel" data-dismiss="modal">Huỷ</button>
				<button type="button" class="btn btn-success" id="btn_submit">Thành công</button>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/property/oto.js"></script>
<style type="text/css">
	@media (min-width: 768px)
	{
		.col-sm-1\.5 {
			width: 11.9%;
		}
	}
	.btn_select_radio, .btn_select_list_grade
	{
		display: none;
		clear: both;
	}
	.grade_level label
	{
		margin-top: 10px;
		margin-bottom: 10px;
		text-transform: uppercase;
		color: #000;
	}
	.box_list
	{
		margin-bottom: 10px;
	}
	.box_box
	{
		background: #fff;
		padding: 7px;
		color: #000;
	}
	.box_box .row
	{
		align-items: center;
	}
	.title_box_list
	{
		display: list-item;
		margin-left: 20px;
	}
	.box_box .x_box_list
	{
		width: 50%;
		margin: 0 auto;
	}
	.modal-content {
		overflow: unset;
	}
	.btn-group, .btn-group-vertical
	{
		display: block;
	}
	.multiselect
	{
		width: 100%;
		text-align: left;
		display: block;
		float: unset !important;
	}
	.multiselect-container
	{
		width: 100%;
	}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover
	{
		background: unset;
	}
	.btn-success {
		background: #047734;
		border: 1px solid #047734;
	}
	.modal-title
	{
		color: #333;
	}
	label
	{
		color: #777171;
	}
	.table-responsive
	{
		overflow-x: unset;
		overflow: unset;
	}
	tr td .dropdown-menu
	{
		left: -125px;
	}
	.button_functions .dropdown-menu
	{
		left: -50px;
	}
	.btn-fitler .dropdown-menu
	{
		left: -260px;
		width: 300px;
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
	.caret {
		float: right;
		position: relative;
		top: 8px;
	}


</style>
<script>
	// $('#his_money').keyup(function (event) {
	// 	$(this).val(function (index, value) {
	// 		return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' VNĐ' ;
	// 	});
	// });
	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
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
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);

					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" />';
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

	function edit(id){

		$('#his_money').val("");
		$('#date_pay').val("");
		$('#his_key').val("");
		$('#uploads_presenter').empty();

		$.ajax({
			url: _url.base_url + 'accountant/show_bankPrice_ctv/' + id,
			type: "POST",
			dateType: "JSON",

			success: function (result) {
				console.log(result);

				if (result.code == 200) {

					if (typeof result.data.his_money != "undefined"){
						$('#his_money').val(result.data.his_money);
					}
					if (typeof result.data.date_pay != "undefined"){

						var dateString = moment(result.data.date_pay).format('YYYY-MM-DD');
						$('#date_pay').val(dateString);
					}
					if (typeof result.data.his_key != "undefined"){
						$('#his_key').val(result.data.his_key);
					}

					$('#lead_id').val(id)

					var html = "";
					if (typeof result.data.img_approve != "undefined"){
						let arr_img = Object.values(result.data.img_approve);

						for (let j = 0; j < arr_img.length; j++) {

							if (arr_img[j].file_type == 'image/png' || arr_img[j].file_type == 'image/jpg' || arr_img[j].file_type == 'image/jpeg') {
								html += "<div class='block'>";
								html += "<a href='" + arr_img[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='image' data-title='Thông báo'><img name='img_borrowed' data-key='" + arr_img[j].key + "' data-fileName='" + arr_img[j].file_name + "' data-fileType='" + arr_img[j].file_type + "' data-type='fileReturn' class='w-100' src='" + arr_img[j].path + "'></a>";
								html += "<button type='button' onclick='deleteImage(this)' data-type='identify' data-key='" + arr_img[j].key + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
								html += "</div>"
							}
						}
						$("#uploads_presenter").append(html);
					}


				}
				$('#addhistory').modal('show');
			}
		});

	}

	$('#btn_submit').click(function (){

		let his_money = $('#his_money').val();
		let date_pay = $('#date_pay').val();
		let his_key = $('#his_key').val();

		var count = $("img[name='img_borrowed']").length;

		var img_approve = {};
		if (count > 0) {
			$("img[name='img_borrowed']").each(function () {
				var data = {};
				type = $(this).data('type');
				data['file_type'] = $(this).attr('data-fileType');
				data['file_name'] = $(this).attr('data-fileName');
				data['path'] = $(this).attr('src');
				data['key'] = $(this).attr('data-key');
				var key = $(this).data('key');
				if (type == 'presenter') {
					img_approve[key] = data;
				}

			});
		}

		$.ajax({
			url: _url.base_url + 'accountant/lead_update_bank',
			method: "POST",
			data: {
				id: $('#lead_id').val(),
				his_money: his_money,
				date_pay: date_pay,
				his_key: his_key,
				img_approve: img_approve,
			},

			success: function (data) {
				console.log(data)
				if (data.code == 200){
					$("#successModal").modal("show");
					$(".msg_success").text("Thành công");
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				} else {

					$("#errorModal").modal("show");
					$(".msg_error").text(data.data.message);

				}


			},
			error: function (data) {
				console.log(data);

			}
		});


	})


</script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>-->
