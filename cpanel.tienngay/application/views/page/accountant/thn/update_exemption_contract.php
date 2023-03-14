<div>&nbsp;</div>


<div class="theloading" style="display:none">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
	<span>Đang Xử Lý...</span>
</div>
<div class="col-xs-12 form-horizontal form-label-left input_mask">
	<div class="row">
		<input type="hidden"
			   class="form-control input-sm"
			   name="code_contract"
			   value="<?= !empty($exemption_contract->code_contract) ? $exemption_contract->code_contract : '' ?>">
		<input type="hidden"
			   class="form-control contract_id"
			   name="id_contract"
			   value="<?= !empty($exemption_contract->id_contract) ? $exemption_contract->id_contract : ''; ?>">
		<input type="hidden"
			   class="form-control status_update"
			   name="status_update"
			   value="1">
		<input type="hidden"
			   class="form-control input-sm"
			   name="id_exemption"
			   value="<?= !empty($exemption_contract->_id->{'$oid'}) ? $exemption_contract->_id->{'$oid'} : '' ?>">


	</div>
	<br>
	<div class="row">
		<span style="padding-bottom: 10px"><b style="color: black">THÔNG TIN MIỄN GIẢM</b></span>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
			Hợp đồng đề nghị &nbsp;&nbsp;
		</label>
		<div class="col-md-5 col-xs-12 error_messages" style="padding-top: 8px">
			<span style="color: black"><?php
			$type_payment_exem=!empty($exemption_contract->type_payment_exem) ? $exemption_contract->type_payment_exem : 1; 
			$confirm_email=!empty($exemption_contract->confirm_email) ? $exemption_contract->confirm_email : 1;
			$is_exemption_paper=!empty($exemption_contract->is_exemption_paper) ? $exemption_contract->is_exemption_paper : 1;
			 echo $contractDB->code_contract_disbursement ?></span>
		</div>
	</div>
	<br/>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Loại miễn giảm &nbsp;&nbsp;
			</label>
			<div class="col-md-2 col-xs-12 " >
				  <input class="form-check-input" type="radio" name="type_payment_exem" value="1" <?php ($type_payment_exem==1) ? print "checked" : print "" ?>>
				  <label class="form-check-label" >Thanh toán</label>
            </div>
            
           <div class="col-md-2 col-xs-12 " >
            <input class="form-check-input" type="radio" name="type_payment_exem" value="2" <?php ($type_payment_exem==2) ? print "checked" : print "" ?>>
            <label class="form-check-label" >Tất toán</label>
			</div>
		</div>
		<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
			Xác nhận của CEO qua email &nbsp;&nbsp;
		</label>
		<div class="col-md-2 col-xs-12 " >
			<input class="form-check-input" type="radio" name="confirm_email" value="1" <?php ($confirm_email==1) ? print "checked" : print "" ?>>
			<label class="form-check-label" >Có</label>
		</div>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
			Đơn miễn giảm (bản giấy) &nbsp;&nbsp;
		</label>
		<div class="col-md-2 col-xs-12 " >
			<input class="form-check-input" type="radio" name="is_exemption_paper" value="1" <?php ($is_exemption_paper == 1) ? print "checked" : print "" ?>>
			<label class="form-check-label" >Có</label>
		</div>

		<div class="col-md-2 col-xs-12 " >
			<input class="form-check-input" type="radio" name="is_exemption_paper" value="2" <?php ($is_exemption_paper == 2) ? print "checked" : print "" ?>>
			<label class="form-check-label text-danger" >Không có</label>
		</div>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
			Số tiền KH đề nghị miễn giảm<span class="text-danger"> * </span>
		</label>
		<div class="col-md-3 col-xs-12 error_messages">
			<input type="text"
				   name="amount_customer_suggest"
				   required class="form-control amount_customer_suggest"
				   value="<?= $exemption_contract->amount_customer_suggest ? number_format($exemption_contract->amount_customer_suggest) : 0 ?>"
				   placeholder="Nhập số tiền miễn giảm">
			<p class="messages"></p>
		</div>
		<div class="col-md-1 col-xs-12">
			<label for="" class="control-label">&nbsp;</label>
			<span class="text-danger">VNĐ</span>
		</div>
		<div class="col-md-2 col-xs-12"></div>
		<label class="control-label col-md-1 col-xs-12 text-left" style="font-weight: lighter; color: black">
			Ngày đề nghị<span class="text-danger"> * </span>
		</label>
		<div class="col-md-3 col-xs-12 error_messages">
			<input type="date" id="date_suggest"
				   class="form-control date_suggest"
				   name="date_suggest"
				   value="<?= $exemption_contract->date_suggest ? date('Y-m-d', $exemption_contract->date_suggest) : ""; ?>">
			<!--				<p class="messages">Y-m-d</p>-->
		</div>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
			Số ngày quá hạn<span class="text-danger"> * </span>
		</label>
		<div class="col-md-3 col-xs-12 error_messages">
			<input type="number"
				   name="number_date_late"
				   id="number_date_late"
				   required class="form-control number"
				   value="<?= !empty($exemption_contract->number_date_late) ? $exemption_contract->number_date_late : 0 ?>" placeholder="Nhập số ngày quá hạn">
			<p class="messages"></p>
		</div>
		<div class="col-md-1 col-xs-12">
			<label for="" class="control-label">&nbsp;</label>
			<span class="text-danger">Ngày</span>
		</div>
		<div class="col-md-1 col-xs-12"></div>
		<label class="control-label col-md-2 col-xs-12 text-left" style="font-weight: lighter; color: black">
			Ngày khách hàng ký đơn miễn giảm<span class="text-danger"> * </span>
		</label>
		<div class="col-md-3 col-xs-12 error_messages">
			<input type="date"
				   class="form-control"
				   name="date_customer_sign"
				   id="date_customer_sign"
				   value="<?= $exemption_contract->start_date_effect ? date('Y-m-d', $exemption_contract->start_date_effect) : ""; ?>"
			>
			<p class="messages"></p>
		</div>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" for=""
			   style="color: black; font-weight: unset">
			Upload hình ảnh<span class="text-danger"> * </span>
		</label>
		<div class="col-md-10 col-xs-12 error_messages">
			<div id="SomeThing" class="simpleUploader error_messages">
				<div class="uploads" id="image_update">
					<?php
					$key_exemption_profile = 0;
					foreach ((array)$exemption_contract->image_exemption_profile as $key => $value) {
						$key_exemption_profile++;
						if (empty($value)) continue; ?>
						<div class="block">
							<!--//Image-->
							<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
								<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
								<a href="<?= $value->path ?>" class="magnifyitem" data-magnify="gallery" data-src=""
								   data-group="thegallery" data-toggle="lightbox" data-gallery="image_update"
								   data-max-width="992" data-type="image" data-title="Hồ sơ nhân thân">
									<img name="img_contract" data-key="<?= $key ?>"
										 data-fileName="<?= $value->file_name ?>"
										 data-fileType="<?= $value->file_type ?>" data-type='exemption_profile' class="w-100"
										 src="<?= $value->path ?>" alt="">
								</a>
							<?php } ?>
							<!--Audio-->
							<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
								<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
								<a href="<?= $value->path ?>" target="_blank"><span
											style="z-index: 9"><?= $value->file_name ?></span>
									<img name="img_contract"
										 style="width: 50%;transform: translateX(50%)translateY(-50%);"
										 src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
									<img name="img_contract" data-key="<?= $key ?>"
										 data-fileName="<?= $value->file_name ?>"
										 data-fileType="<?= $value->file_type ?>" data-type='exemption_profile' class="w-100"
										 src="<?= $value->path ?>" alt="">
								</a>
								<!--                                                <audio controls>
                                                    <source src="<?= $value->path ?>" type="audio/mpeg">
                                                    <?= $value->file_name ?>
                                                </audio>-->
							<?php } ?>
							<!--Video-->
							<?php if ($value->file_type == 'video/mp4') { ?>
								<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
								<a href="<?= $value->path ?>" target="_blank"><span
											style="z-index: 9"><?= $value->file_name ?></span>
									<img name="img_contract"
										 style="width: 50%;transform: translateX(50%)translateY(-50%);"
										 src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
									<img name="img_contract" data-key="<?= $key ?>"
										 data-fileName="<?= $value->file_name ?>"
										 data-fileType="<?= $value->file_type ?>" data-type='exemption_profile' class="w-100"
										 src="<?= $value->path ?>" alt="">
								</a>
								<!--                                                <video width="320" height="240" controls>
                                                    <source src="<?= $value->path ?>" type="video/mp4">
                                                    <?= $value->file_name ?>
                                                </video>-->
							<?php } ?>
							<?php
							if ($userSession['is_superadmin'] == 1 || !in_array($exemption_contract->status, array(5, 7))) {
								?>
								<button type="button" onclick="deleteImage(this)"
										data-id="<?= !empty($exemption_contract->_id->{'$oid'}) ? $exemption_contract->_id->{'$oid'} : '' ?>" data-type="exemption_profile"
										data-key='<?= $key ?>' class="cancelButton "><i
											class="fa fa-times-circle"></i></button>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
				<label for="upload_update_img">
					<div class="uploader btn btn-primary">
						<span>+</span>
					</div>
				</label>
				<input id="upload_update_img"
					   type="file"
					   name="file"
					   data-contain="image_update"
					   data-title="Ảnh hồ sơ miễn giảm"
					   data-extensions="upload_profile_exemption"
					   multiple
					   data-type="exemption_profile"
					   class="focus">
			</div>

		</div>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left"
			   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
			Ghi chú/Note của Lead QLHĐV &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<div class="col-md-10 col-xs-12 error_messages">
				<textarea class="form-control" rows="1" disabled
						  placeholder=""><?= $exemption_contract->note_lead ? $exemption_contract->note_lead : ""; ?></textarea>
			<input type="hidden" class="form-control">
			<p class="messages"></p>
		</div>
	</div>
	<br>
	<?php if (isset($exemption_contract->note_tp_thn)) { ?>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left"
				   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
				Ghi chú/Note của TP QLHĐV &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<div class="col-md-10 col-xs-12 error_messages">
				<textarea class="form-control" rows="1" disabled
						  placeholder=""><?= $exemption_contract->note_tp_thn ? $exemption_contract->note_tp_thn : ""; ?></textarea>
				<input type="hidden" class="form-control">
				<p class="messages"></p>
			</div>
		</div>
	<?php } ?>
	<br>
	<?php if (isset($exemption_contract->note_qlcc)) { ?>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left"
				   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
				Ghi chú/Note của QLCC &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<div class="col-md-10 col-xs-12 error_messages">
				<textarea class="form-control" rows="1" disabled
						  placeholder=""><?= $exemption_contract->note_qlcc ? $exemption_contract->note_qlcc : ""; ?></textarea>
				<input type="hidden" class="form-control">
				<p class="messages"></p>
			</div>
		</div>
	<?php } ?>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left"
			   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
			Ghi chú/Note &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<div class="col-md-10 col-xs-12 error_messages">
				<textarea id="note_suggest_exemptions" class="form-control" rows="3"
						  placeholder="Nhập lưu ý"><?= $exemption_contract->note ? $exemption_contract->note : ""; ?></textarea>
			<input type="hidden" class="form-control">
			<p class="messages"></p>
		</div>
	</div>
	<br>


	<div id="append_html"></div>
	<?php if (!in_array("tbp-thu-hoi-no", $groupRoles) || !in_array("tbp-thu-hoi-no", $groupRoles)) { ?>
	<?php if (in_array($exemption_contract->status,[3,8,9])) { ?>
		<div class="row" id="restore_exemption_contract_btn">
			<div class="col-md-12 col-xs-12 text-right">
				<button id="cancel_update" class="btn btn-secondary">Hủy</button>
				<button id="update_exemptions" class="btn btn-info">Gửi lại yêu cầu</button>
			</div>
		</div>
	<?php } else { ?>
		<div class="alert warning-cpanel" id="hide_alert_cancel" role="alert">
			<h4 style="color: #fff;"> Đơn miễn giảm đang ở trạng thái <span class="cancel-status-ex">HỦY!</span> Click vào <span class="text-info" id="restore_exemption_contract">ĐÂY</span> để khôi phục. </h4>
		</div>
	<?php } ?>
	<?php } ?>
</div>

<style type="text/css">
	#restore_exemption_contract {
		cursor: pointer;
		font-weight: bold;
		color: #efff00;

	}

	#restore_exemption_contract:hover {
		background-color: hotpink;
	}

	.warning-cpanel {
		background-color: #04aa6d;
		text-align: center;
		vertical-align: middle;
		font-size: 18px;
	}

	.cancel-status-ex {
		font-weight: bold;
		color: #01ffff;
	}
</style>






