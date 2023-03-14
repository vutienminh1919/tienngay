<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<div class="x_panel">
	<div class="x_content block__image plr-0">
		<div class="col-md-12 col-sm-12 col-xs-12 plr-0 block__image-box">
			<!--Start identify-->

			<div class="form-group ">
				<p class="text-uppercase text-bold text-nowrap"> Hồ sơ nhân thân</p>
				<div class="col-md-1"></div>
				<div class="col-md-10 col-sm-6 col-xs-12 plr-0">
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads " id="uploads_fileReturn">

						</div>
						<label for="uploadinput">
							<div class="block uploader">
								<img src="<?php echo base_url(); ?>assets/imgs/icon/add.svg" alt="" style="max-width: 42px; max-height: 42px">
							</div>
						</label>
						<input id="uploadinput" type="file" name="file"
							   data-contain="uploads_fileReturn" data-title="Hồ sơ nhân thân" multiple
							   data-type="fileReturn" class="focus">
					</div>
				</div>
			</div>
			<!--End-->
			<!--Start household-->
			<div class="form-group ">
				<p class="text-uppercase text-bold text-nowrap"> Hồ sơ chứng minh thu nhập</p>
				<div class="col-md-1"></div>
				<div class="col-md-10 col-sm-6 col-xs-12 plr-0">
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads" id="uploads_household">

						</div>
						<label for="upload_household">
							<div class="block uploader">
								<img src="<?php echo base_url(); ?>assets/imgs/icon/add.svg" alt="" style="max-width: 42px; max-height: 42px">
							</div>
						</label>
						<input id="upload_household" type="file" name="file" data-contain="uploads_household" data-title="Hồ sơ chứng minh thu nhập" multiple data-type="household" class="focus">
					</div>
				</div>
			</div>
			<!--End-->
			<!--Start driver_license-->
			<div class="form-group ">
				<p class="text-uppercase text-bold text-nowrap"> hồ sơ tài sản</p>
				<div class="col-md-1"></div>
				<div class="col-md-10 col-sm-6 col-xs-12 plr-0">
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads" id="uploads_driver_license">

						</div>
						<label for="upload_driver_license">
							<div class="block uploader">
								<img src="<?php echo base_url(); ?>assets/imgs/icon/add.svg" alt="" style="max-width: 42px; max-height: 42px">
							</div>
						</label>
						<input id="upload_driver_license" type="file" name="file" data-contain="uploads_driver_license" data-title="Hồ sơ tài sản" multiple data-type="driver_license" class="focus">
					</div>
				</div>
			</div>
			<!--End-->
			<!--Start vehicle-->
			<div class="form-group ">
				<p class="text-uppercase text-bold text-nowrap"> Hồ sơ thẩm định thực địa</p>
				<div class="col-md-1"></div>
				<div class="col-md-10 col-sm-6 col-xs-12 plr-0">
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads" id="uploads_vehicle">

						</div>
						<label for="upload_vehicle">
							<div class="block uploader">
								<img src="<?php echo base_url(); ?>assets/imgs/icon/add.svg" alt="" style="max-width: 42px; max-height: 42px">
							</div>
						</label>
						<input id="upload_vehicle" type="file" name="file" data-contain="uploads_vehicle" data-title="Hồ sơ thẩm định thực địa" multiple data-type="vehicle" class="focus">
					</div>
				</div>
			</div>
			<!--End-->
			<!--Start vehicle-->
			<div class="form-group ">
				<p class="text-uppercase text-bold text-nowrap"> Thỏa thuận</p>
				<div class="col-md-1"></div>
				<div class="col-md-10 col-sm-6 col-xs-12 plr-0">
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads" id="uploads_agree">

						</div>
						<label for="upload_agree">
							<div class="block uploader">
								<img src="<?php echo base_url(); ?>assets/imgs/icon/add.svg" alt="" style="max-width: 42px; max-height: 42px">
							</div>
						</label>
						<input id="upload_agree" type="file" name="file" data-contain="uploads_agree" data-title="Thỏa thuận" multiple data-type="agree" class="focus">
					</div>
				</div>
			</div>
			<!--End-->
		</div>
		<div class="col-xs-12 col-md-12 pt-0 pb-0">
			<button class="btn btn-success pull-right" type="button" data-target="#createContract_1" data-toggle="modal" style="position: absolute;right: 15px;top: 28px; background-color: #5A738E">
				Lưu
			</button>

		</div>

	</div>

</div>


<!-- Modal create contract -->
<div id="createContract_1" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title">Xác nhận tạo hợp đồng mới</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-footer" style="display: flex;
    flex-direction: row;
    justify-content: center;">
				<button type="button" class="btn btn-info"
						data-dismiss="modal">Hủy</button>
				<button type="button"
						class="btn btn-success" style="margin-bottom: 0">Xác nhận</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal create success -->
<div id="successModal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p class='msg_success'></p>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/pawn/upload_img.js"></script>
<script src="<?php echo base_url();?>assets/js/simpleUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />

