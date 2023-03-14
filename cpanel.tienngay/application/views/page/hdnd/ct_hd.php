<!-- page content -->

<?php
$id = !empty($_GET['id']) ? $_GET['id'] : "";
?>
<div class="load"></div>
<div id="loading" class="theloading" style="display: none;">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<div id="successModal" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content" style="border-top: 2px solid #2FB344;">
      <div class="modal-header">
                <div class="icon-box success">
          <i class="fa fa-check"></i>
        </div>
        <h4 class="modal-title">Thành Công</h4>
        <p>Đã hoàn thành</p>
        <a style="min-height: auto;" href="javascript:(0)" class="btn btn-success company_close" data-dismiss="modal">Đóng</a>
        </div>
      <div class="modal-body">
        <p class='msg_success'></p>
      </div>
    </div>
  </div>
</div>
<div id="errorModal" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">
        <div class="icon-box danger">
          <i class="fa fa-times"></i>
        </div>
        <h4 class="modal-title">Thất bại</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class='msg_error'></p>
      </div>
    </div>
  </div>
</div>
<div class="right_col" role="main">

	<div class="contract-detail">
		<h3>Chi tiết hợp đồng thuê mặt bằng</h3>
		<div class="btn-top">
			<small>
				<a href="<?php echo base_url("tenancy/listTenancy"); ?>"><i class="fa fa-home"></i> Danh sách hợp đồng thuê</a>
			</small>
			<div>
				<?php if ($resutl->status == 'active' || $resutl->status == 'hop_dong_thanh_ly') { ?>
					<button type="button" id="updateHD" data-id="<?= $resutl->_id ?>"
							class="btn btn-success">Sửa hợp đồng <img
								src="<?php echo base_url(); ?>assets/imgs/icon/ic_edit.svg" alt=""></button>
				<?php } else { ?>
					<button type="button" id="updateHD" data-id="<?= $resutl->_id ?>"
							class="btn btn-success" style="display: none">Sửa hợp đồng <img
								src="<?php echo base_url(); ?>assets/imgs/icon/ic_edit.svg" alt=""></button>
				<?php } ?>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal5">
					Upload scan <img src="<?php echo base_url(); ?>assets/imgs/icon/ic_scan.svg" alt=""></button>
				<?php if ($resutl->status == 'active') { ?>
				<button type="button" class="btn btn-success phuLucHD" id="phuLucHD"
						data-id="<?php echo $resutl->_id ?>" data-toggle="modal" data-target="#modal7">Upload PLHD <img
							src="<?php echo base_url(); ?>assets/imgs/icon/ic_upload.svg" alt=""></button>
				<?php } else { ?>
					<button type="button" class="btn btn-success phuLucHD" id="phuLucHD"
							data-id="<?php echo $resutl->_id ?>" data-toggle="modal" data-target="#modal7" style="display: none">Upload PLHD
						<img
								src="<?php echo base_url(); ?>assets/imgs/icon/ic_upload.svg" alt=""></button>
				<?php } ?>
				<button type="button" data-toggle="modal" data-target="#modal12" id="tien_coc_chu_nha_tt" data-id="<?= $resutl->_id ?>"
						class="btn btn-success">Cập nhật số tiền chủ nhà thanh toán cọc <img
							src="<?php echo base_url(); ?>assets/imgs/icon/ic_upload.svg" alt=""></button>

				<button type="button" id="btnThanhLyHD" data-id="<?= $resutl->_id ?>"
						class="btn btn-danger">Thanh lý hợp đồng(không chọn ngày) <img
							src="<?php echo base_url(); ?>assets/imgs/icon/ic_clone.svg" alt=""></button>
				<button type="button" id="btnTLHD" data-toggle="modal" data-target="#modalTLHD" data-id="<?= $resutl->_id ?>"
						class="btn btn-danger">Thanh lý hợp đồng(có chọn ngày) <img
							src="<?php echo base_url(); ?>assets/imgs/icon/ic_clone.svg" alt=""></button>
			</div>

		</div>
	</div>
	<div class="contractInformation">
		<form action="" method="">
			<div class="realEstate-form">
				<div style="display: flex; justify-content: space-between;align-items: center;">
					<h3>Thông tin hợp đồng
						<span for=""
							  style="font-style: normal;font-weight: 600;font-size: 14px;line-height: 16px;color: #1D9752;">
							  <?php if ($resutl->status == 'active') { ?>
								  <?php echo 'Đang thuê' ?>
							  <?php } elseif ($resutl->status == 'hop_dong_thanh_ly') { ?>
								  <?php echo 'Hợp đồng đã thanh lý' ?>
							  <?php } ?>
						</span>
						<span style="font-size: 15px">
							<?php if (!empty($resutl->ngay_thanh_ly)){ ?>
								<?php echo 'Ngày thanh lý: ' . date('d/m/y',$resutl->ngay_thanh_ly)?>
							<?php }else{ ?>
								<?php echo date('d/m/Y',time()) ?>
							<?php } ?>
						</span>
					</h3>
					<div style="display: flex; gap: 5%;" class="form-label-text">
						<label for="" data-toggle="modal" data-target="#modal6">Bản scan hợp đồng thuê</label>
						<!-- ------ -->
						<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<span style="margin-left: 35%;color: #0a5a2c;font-size: 25px">Scan hợp đồng</span>
									<input type="text" value="<?= $id ?>" id="img_upload_id" hidden>
									<div>
										<label class="control-label"> </label>
										<div id="SomeThing" class="simpleUploader">
											<div class="uploads" id="uploads_fileReturn1">
												<?php if (!empty($img_tenancy)){ ?>
												<?php foreach ((array)$img_tenancy as $key => $value) : ?>
													<div class="block">
														<!--//Image-->
														<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>
															<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
															<a href="<?= $value->path ?>"
															   class="magnifyitem" data-magnify="gallery"
															   data-src=""
															   data-group="thegallery"
															   data-caption="Ảnh chi tiết hợp đồng">
																<img data-type="fileReturn"
																	 data-fileType="<?= $value->file_type ?>"
																	 data-fileName="<?= $value->file_name ?>"
																	 name="img_fileReturn3"
																	 data-key="<?= $value->key ?>"
																	 src="<?= $value->path ?>">
															</a>
														<?php }elseif(!empty($value->file_type) && $value->file_type == 'application/pdf'){ ?>
															<a href="<?= $value->path ?>" target="_blank"><img src="https://upload.tienvui.vn/uploads/avatar/1668653339-0f6bf376687183afe8dad0e3202d7a29.png" alt="">
																<img data-type="fileReturn"
																	 data-fileType="<?= $value->file_type ?>"
																	 data-fileName="<?= $value->file_name ?>"
																	 name="img_fileReturn3"
																	 data-key="<?= $value->key ?>" onerror="this.style.display='none'"
																	 src="<?= $value->path ?>">
															</a>
														<?php }?>
														<button type="button" onclick="deleteImage(this)"
																data-id="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>"
																data-type="identify" data-key='<?= $value->key ?>'
																class="cancelButton">
															<i class="fa fa-times-circle"></i>

														</button>
													</div>
												<?php endforeach; ?>
												<?php }else{ ?>
													<?php echo '<span style="color: red;margin-left: 35%">Chưa có bản scan hợp đồng nào</span>' ?>
												<?php } ?>
											</div>
											<input id="uploadinput1" type="file" name="file"
												   data-contain="uploads_fileReturn1" data-title="Ảnh chi tiết "
												   multiple
												   data-type="fileReturn"
												   class="focus">
										</div>
									</div>
									<div>
										<label class="control-label"> </label>
										<div id="SomeThing" class="simpleUploader">
											<div class="uploads" id="uploads_fileReturn1"></div>
											<label for="uploadinput1">
												<div class="block uploader">
													<span>+</span>
												</div>
											</label>
											<input id="uploadinput1" type="file" name="file"
												   data-contain="uploads_fileReturn1" data-title="Ảnh chi tiết "
												   multiple
												   data-type="fileReturn" class="focus">
										</div>
									</div>
									<div>
										<button type="button" id="upload_image" data-dismiss="modal" style="color:whitesmoke;font-size: 15px ;background-color: #037734;border: 1px solid white;width: 100px;border-radius: 5px;height: 30px">
											Lưu
										</button>
									</div>
								</div>
							</div>
						</div>
						<label for="" data-toggle="modal" data-target="#modal8">Phụ lục hợp đồng</label>
						<!-- -----modal------ -->
						<div class="modal fade" id="modal8" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
							<div class="modal-dialog " role="document" id="iic">
								<div class="modal-content table-responsive">
									<p style="text-align: center;font-size: 20px;color: #0a5a2c;font-weight: 500">TỔNG HỢP PHỤ LỤC HỢP ĐỒNG</p>
									<table class="table table-hover bg-light">
										<thead>
										<tr>
											<th scope="col" style="color: #0a5a2c">STT</th>
											<th scope="col" style="color: #0a5a2c">Thời gian bắt đầu</th>
											<th scope="col" style="color: #0a5a2c">Thời gian kết thúc</th>
											<th scope="col" style="color: #0a5a2c">Kỳ trả</th>
											<th scope="col" style="color: #0a5a2c">Thời gian thuê</th>
											<th scope="col" style="color: #0a5a2c">Hợp đồng(phụ lục số)</th>
											<th scope="col" style="color: #0a5a2c">Tiền thanh toán/tháng</th>
											<th scope="col" style="color: #0a5a2c">Ngày khởi tạo phụ lục</th>
										</tr>
										</thead>
										<tbody>
										<?php foreach ($result_appendix as $ke => $i) : ?>
											<tr>
												<td style="text-align: center"><?php echo ++$ke ?></td>
												<td style="text-align: center"><?php echo $i->start_date_contract ?></td>
												<td style="text-align: center"><?php echo $i->end_date_contract ?></td>
												<td style="text-align: center"><?php echo $i->ky_tra ?></td>
												<td style="text-align: center"><?php echo $i->contract_expiry_date ?></td>
												<td style="text-align: center"><?php echo $i->hop_dong_so ?></td>
												<td style="text-align: center"><?php echo number_format($i->one_month_rent) ?></td>
												<td style="text-align: center"><?php echo date("d/m/Y", $i->created_at) ?></td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<label for="" data-toggle="modal" data-target="#modal10">Lịch sử thanh toán cấn cọc</label>
						<!-- -----modal-pedosit------ -->
						<div class="modal fade" id="modal10" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
							<div class="modal-dialog " role="document" id="iic">
								<div class="modal-content table-responsive">
									<p style="text-align: center;font-size: 20px;color: #0a5a2c;font-weight: 500">Lịch
										sử thanh toán tiền cọc</p>
									<table class="table table-hover bg-light">
										<thead>
										<tr>
											<th scope="col" style="color: #0a5a2c;text-align: center">STT</th>
											<th scope="col" style="color: #0a5a2c;text-align: center">Tiền cọc gốc</th>
											<th scope="col" style="color: #0a5a2c;text-align: center">Cấn trừ tiền cọc
												vào tiền thuê nhà
											</th>
											<th scope="col" style="color: #0a5a2c;text-align: center">Ngày cập nhật
											</th>
											<th scope="col" style="color: #0a5a2c;text-align: center">Người thanh toán
											</th>
										</tr>
										</thead>
										<tbody>
										<?php if ($deposit): ?>
											<?php foreach ($deposit as $key => $val) : ?>
												<tr>
													<td style="text-align: center"><?php echo ++$key ?></td>
													<td style="text-align: center"><?php echo number_format($val->tien_coc_goc) ?></td>
													<td style="text-align: center"><?php echo number_format($val->coc_can_thua) ?></td>
													<td style="text-align: center"><?php echo date('d/m/Y', $val->ngay_thanh_toan) ?></td>
													<td style="text-align: center"><?php echo $val->nguoi_thanh_toan ?></td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
										</tbody>
									</table>
									<!--		danh sách tiền cọc chủ nhà thanh toán-->
									<hr>
									<p style="text-align: center;font-size: 20px;color: #0a5a2c;font-weight: 500">Lịch
										sử chủ nhà thanh toán tiền cọc</p>
									<table class="table table-hover bg-light">
										<thead>
										<tr>
											<th scope="col" style="color: #0a5a2c;text-align: center">STT</th>
											<th scope="col" style="color: #0a5a2c;text-align: center">Tiền cọc gốc</th>
											<th scope="col" style="color: #0a5a2c;text-align: center">Chủ nhà hoàn lại
												tiền cọc
											</th>
											<th scope="col" style="color: #0a5a2c;text-align: center">Ngày cập nhật
											</th>
											<th scope="col" style="color: #0a5a2c;text-align: center">Người cập nhật
												thanh toán
											</th>
										</tr>
										</thead>
										<tbody>
										<?php if ($depositHome): ?>
											<?php foreach ($depositHome as $key => $va) : ?>
												<tr>
													<td style="text-align: center"><?php echo ++$key ?></td>
													<td style="text-align: center"><?php echo number_format($va->tien_coc_ban_dau) ?></td>
													<td style="text-align: center"><?php echo number_format($va->coc_bctt) ?></td>
													<td style="text-align: center"><?php echo date('d/m/Y', $va->ngay_thanh_toan_coc) ?></td>
													<td style="text-align: center"><?php echo $va->nguoi_cap_nhat_tt ?></td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
										</tbody>
									</table>
									<p style="color: red">Số tiền cọc còn lại</p>
									<div class="form-input">
										<input style="bottom: 10px;color: red" type="text"
											   value="<?= number_format($resutl->tien_coc_thua) ?>">
									</div>
								</div>
							</div>
						</div>




						<div class="modal fade" id="modal6" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
								<div class="modal-header">
								<span style="text-align: center;font-size: 18px; color: #0a5a2c;font-weight: 600;">Tổng hợp các bản scan hợp đồng</span>
									<div class="uploads row" id="uploads_fileReturn1">
										<?php if ($img_tenancy){ ?>
										<?php foreach ((array)$img_tenancy as $key => $value) : ?>
											<div class="block col-md-4" style="margin-bottom: 40px">
												<!--//Image-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>
<!--													<span class="timestamp">--><?php //echo date('d/m/Y H:i:s', basename($value->path)); ?><!--</span>-->
													<a href="<?= $value->path ?>"
													   class="magnifyitem" data-magnify="gallery"
													   data-src=""
													   data-group="thegallery"
													   data-caption="Ảnh chi tiết hợp đồng">
														<img data-type="fileReturn"
															 data-fileType="<?= $value->file_type ?>"
															 data-fileName="<?= $value->file_name ?>"
															 name="img_fileReturn1"
															 data-key="<?= $value->key ?>"
															 src="<?= $value->path ?>"
															  style="max-height:150px;max-width: 150px">

													</a><br>

												<?php } elseif (!empty($value->file_type) && $value->file_type == 'application/pdf') { ?>
													<a href="<?= $value->path ?>" target="_blank"><img
																src="https://upload.tienvui.vn/uploads/avatar/1668653339-0f6bf376687183afe8dad0e3202d7a29.png"
																alt=""></i></a>
													<br>
												<?php } ?>
												<button type="button" style="color: black;" onclick="deleteImage(this)"
														data-id="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>"
														data-type="identify" data-key='<?= $value->key ?>'
														class="cancelButton btn-xtsa" >xóa
												</button>
											</div>
										<?php endforeach; ?>
										<?php } else { ?>
											<?php echo '<span style="color: red;margin-left: 35%">Chưa có bản scan hợp đồng nào</span>' ?>
										<?php } ?>
									</div>
								</div>
								</div>
							</div>
						</div>


						<div class="modal fade" id="modal7" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
							<div class="modal-dialog" role="document">
								<div class="modal-content">

									<div class="modal-content">
										<div class="modal-header">
											<h3>Thêm mới phụ lục </h3>
											<div class="form-group">
												<input type='text' placeholder="Nhập"
													   name="id_ky_han"
													   id="id_ky_han"
													   value="<?= $id ?>" hidden
												/>
											</div>
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Ngày bắt đầu:<span style="color: red">*</span></label>
												<input type='text' placeholder=" Nhập ngày"
													   name="start_date_contract"
													   id="start_date_contract"
													   onfocus="(this.type='date')"
													   class="textbox-n"
													   style="padding-left: 10px;"
												/>
											</div>
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Ngày kết thúc:<span style="color: red">*</span></label>
												<input placeholder=" Nhập ngày" class="textbox-n" type="text"
													   onfocus="(this.type='date')"
													   id="end_date_contract"
													   style="padding-left: 10px;" name="end_date_contract">
											</div>
											<div class="form-input">
												<p>Kỳ hạn: <span>*</span></p>
												<select name="ky_tra" id="ky_tra_moi">
													<option value="">Chọn kỳ thanh toán</option>
													<option value="1">1 tháng</option>
													<option value="2">2 tháng</option>
													<option value="3">3 tháng</option>
													<option value="6">6 tháng</option>
													<option value="12">12 tháng</option>
												</select>
											</div>
											<div class="form-group">
												<p>Thời hạn thuê: <span style="color: red">*</span></p>
												<select name="contract_expiry_date" id="contract_expiry_date" class="form-control">
													<option value="">Chọn thời hạn thuê</option>
													<option value="1">1 năm</option>
													<option value="2">2 năm</option>
													<option value="3">3 năm</option>
													<option value="4">4 năm</option>
													<option value="5">5 năm</option>
												</select>
											</div>
											<div class="form-group">
												<p>Giá thuê/tháng: <span style="color: red">*</span></p>
												<input type='text' placeholder=" Nhập giá thuê" style="padding-left: 10px;"
													   name="one_month_rent"
													   id="one_month_rent"
													   value="<?= set_value('one_month_rent'); ?>"/>
											</div>
											<input type="hidden" name="id_tong"
												   value="<?php echo $_GET['id'] ?>">
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary"
														data-dismiss="modal">Hủy
												</button>
												<button type="button" id="btnSaveInsertKyHan"
														class="btn btn-primary" >Cập
													nhật
												</button>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div class="realEstate-label"><span><b>1</b> Thông tin hợp đồng thuê</span></div>
					<div class="row">
						<div class="form-input">
							<input type='text' placeholder="Nhập" value="<?= $resutl->_id ?>" hidden/>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Số hợp đồng thuê<span>*</span></p>
								<input type='text' placeholder="Nhập" value="<?= $resutl->code_contract ?>" disabled/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Ngày bắt đầu tính tiền<span>*</span></p>
								<input type='text' onfocus="(this.type='date')" placeholder="Ngày"
									   value="<?= $resutl->start_date_contract ?>" disabled/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Ngày kết thúc hợp đồng<span>*</span></p>
								<input type='text' onfocus="(this.type='date')" placeholder="Ngày"
									   value="<?= $resutl->end_date_contract ?>" disabled/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Ngày ký hợp đồng <span>*</span></p>
								<input type='text' onfocus="(this.type='date')" placeholder="Ngày"
									   value="<?= date("d/m/Y",$resutl->date_contract) ?>" disabled/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Thời hạn thuê(năm)<span>*</span></p>
								<input type='text' placeholder="Thời hạn" value="<?= $resutl->contract_expiry_date ?>"
									   disabled/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p style="color: red">Nhân viên phụ trách<span>*</span></p>
								<input type='text' placeholder="Nhập nhân viên" name="staff_ptmb" value="<?= $resutl->staff_ptmb ?>" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Phòng giao dịch<span>*</span></p>
								<input type='text' placeholder="Nhập" value="<?= $resutl->store->store_name ?>"
									   disabled/>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Khu vực<span>*</span></p>
							<select name="address" id="address1"  disabled style="color: black;font-weight: 600">
								<?php foreach ($result_district as $e): ?>
									<option style="color: black" value="<?= ($e->code) ?>" <?php echo $e->code == $resutl->address ? 'selected' : "" ?>><?php echo $e->name ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Công ty<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= $resutl->name_cty ?>" disabled/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Diện tích mặt bằng<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= $resutl->dien_tich ?>" disabled/>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="realEstate-label"><span><b>2</b> Thông tin chủ nhà</span></div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-input">
							<p>Họ tên chủ nhà<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= $resutl->customer_infor->ten_chu_nha ?>"
								   disabled/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Số điện thoại<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= $resutl->customer_infor->sdt_chu_nha ?>"
								   disabled/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">

						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Chủ tài khoản <span>*</span></p>
							<input type='text' placeholder="Nhập"
								   value="<?= $resutl->customer_infor->ten_tk_chu_nha ?? "" ?>" disabled/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Số tài khoản<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= $resutl->customer_infor->so_tk_chu_nha ?>"
								   disabled/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Ngân hàng <span>*</span></p>
								<select  name="bank_name" id="bank_name1" disabled  style="color: black;font-weight: 600">
									<?php  foreach ($result_bank_name as $i): ?>
										<option  value="<?= $i->bank_code ?>" <?php $i->bank_code == $resutl->customer_infor->bank_name ? 'selected' : "" ?>><?php echo $i->name ?></option>
									<?php endforeach; ?>
								</select>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="realEstate-label"><span><b>3</b> Thông tin đặt cọc</span></div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-input">
							<p>Số tiền đặt cọc<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= number_format($resutl->tien_coc) ?>"
								   disabled/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Ngày đặt cọc<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= date("d/m/Y",$resutl->ngay_dat_coc) ?>" disabled/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Đặt cọc còn lại<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= number_format($resutl->tien_coc_thua) ?>"
								   disabled/>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="realEstate-label"><span><b>4</b> Thông tin thanh toán</span></div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-input">
							<p>Giá thuê/tháng<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= number_format($resutl->one_month_rent) ?>"
								   disabled/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Kỳ hạn thanh toán(tháng)<span>*</span></p>
							<input type='text' placeholder="Nhập" value="<?= $resutl->ky_tra ?>" disabled/>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="realEstate-label"><span><b>5</b> Thông tin thuế</span></div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-input">
							<p style="color: red">Mã số thuế<span>*</span></p>
							<input type='text' placeholder=" Nhập mã số thuế" name="ma_so_thue" value="<?= $resutl->ma_so_thue ?>"/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-input">
							<p style="color: red">Trách nhiệm kê khai<span>*</span></p>
							<select name="nguoi_nop_thue" id="">
								<option value="1" <?php echo $resutl->nguoi_nop_thue == '1' ? 'selected' : "" ?> >Công Ty</option>
								<option value="2" <?php echo $resutl->nguoi_nop_thue == '2' ? 'selected' : "" ?> >Chủ Nhà</option>
							</select>
						</div>
					</div>
				</div>
			</div>
	</div>
	</form>
	<form>
		<div class="form-table">
			<h3>Lịch thanh toán</h3>
			<div class="card-body">
				<div class="outer">
					<table class="table table-hover bg-light">
						<thead>
						<tr>
							<th scope="col">STT</th>
							<th scope="col" hidden>id</th>
							<th scope="col">Chức năng</th>
							<th scope="col">Kỳ trả</th>
							<th scope="col">Ngày trả</th>
							<th scope="col">Giá thuê/Tháng</th>
							<th scope="col">Kì hạn thanh toán</th>
							<th scope="col">Tổng tiền trả</th>
							<th scope="col">Trạng thái thanh toán</th>
							<th scope="col">Ngày thanh toán</th>
							<th scope="col">Ngày đến hạn nộp thuế</th>
							<th scope="col">Thuế GTGT +thuế TNCN</th>
							<th scope="col">Ngày nộp thuế</th>
							<th scope="col">Trạng thái nộp thuế</th>
						</tr>
						</thead>
						<tbody>
						<?php $c = array(1, 2, 3, 4, 5, 6, 7, 8, 9) ?>
						<?php foreach ($code as $key => $item) : ?>
							<tr>
								<td><?php echo ++$key ?></td>
								<td hidden><?php echo $item->_id ?></td>
								<td>
									<div class="container">
										<div class="dropdown">
											<button class="btn btn-default dropdown-toggle" type="button"
													id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
													aria-expanded="true" style="border:none; color: #1D9752;">Chức năng
												<img src="<?php echo base_url(); ?>assets/imgs/icon/ic_menu.svg" alt="">
											</button>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
												<?php if ($item->status == "chua_thanh_toan") { ?>
													<li><a class="paymentTenacy" href="#"
														   data-id="<?php echo $item->_id ?>" data-toggle="modal"
														   data-target="#modal1">Thanh toán tiền thuê</a></li>

												<?php } elseif ($item->status == "da_thanh_toan") { ?>
													<li style="display: none"><a class="paymentTenacy" href="#"
																				 data-id="<?php echo $item->_id ?>"
																				 data-toggle="modal"
																				 data-target="#modal1">Thanh toán tiền
															thuê</a></li>
												<?php } ?>
												<?php if ($item->status_thue == "chua_thanh_toan") { ?>
													<li><a class="paymentTax" href="#" data-toggle="modal"
														   data-id="<?php echo $item->_id ?>" data-target="#modal2">Thanh
															toán thuế</a></li>
												<?php } elseif ($item->status_thue == "da_thanh_toan") { ?>
													<li style="display: none"><a class="paymentTax" href="#"
																				 data-toggle="modal"
																				 data-id="<?php echo $item->_id ?>"
																				 data-target="#modal2">Thanh toán
															thuế</a></li>
												<?php } ?>
												<li><a class="note" href="" data-id="<?php echo $item->_id ?>"
													   data-toggle="modal" data-target="#modal4">Ghi chú</a></li>
												<li><a class="pax" href="" data-id="<?php echo $item->_id ?>"
													   data-toggle="modal" data-target="#modal9">Xem ct thuế</a></li>
												<?php if ($item->status == "chua_thanh_toan") { ?>
													<li><a class="paymentKyHan" href="" data-id="<?php echo $item->_id ?>"
													   data-toggle="modal" data-target="#modal11" >Cập nhật kỳ thanh toán</a></li>
												<?php } elseif ($item->status == "da_thanh_toan") { ?>
													<li style="display: none"><a class="paymentKyHan" href="" data-id="<?php echo $item->_id ?>"
													   data-toggle="modal" data-target="#modal11" >Cập nhật kỳ thanh toán</a></li>
												<?php } ?>
											</ul>
										</div>
										<!--Modal code -->
									</div>
								</td>
								<td><?php echo date("d/m/Y",$item->ngay_bat_dau_ky) .' đến ' . date("d/m/Y",$item->ngay_ket_thuc_ky) ?></td>
								<td><?php echo date("d/m/Y",$item->ngay_thanh_toan_unix) ?></td>
								<td><?php echo number_format($item->one_month_rent / $item->ky_tra) ?></td>
								<td><?php echo $item->ky_tra ?></td>
								<td><?php echo number_format($item->one_month_rent) ?></td>
								<td><?php if ($item->status == "da_thanh_toan") {
										echo "<span class='label label-success'> đã thanh toán</span>";
									} elseif ($item->status == "chua_thanh_toan") {
										echo "<span class='label label-danger'>chưa thanh toán</span>";
									} else {
										echo "<span class='label label-warning'>hợp đồng thanh lý</span>";
									}
									?>
								</td>
								<td><?php echo $item->ngay_thanh_toan_tt ?></td>
								<td><?php echo !empty($item->ngay_den_han_tt_thue) ? date("d/m/Y",$item->ngay_den_han_tt_thue) : "" ?></td>
								<td><?php echo number_format($item->tien_thue) ?></td>
								<td><?php echo !empty($item->ngay_thanh_toan_thue) ? date("d/m/Y",$item->ngay_thanh_toan_thue) : "" ?></td>
								<td><?php if ($item->status_thue == "da_thanh_toan") {
										if(!empty($item->ngay_thanh_toan_thue) && ($item->ngay_thanh_toan_thue > $item->ngay_den_han_tt_thue)){
											echo "<span class='label label-info'>thanh toán thuế quá hạn</span>";
										}elseif(!empty($item->ngay_thanh_toan_thue) && ($item->ngay_thanh_toan_thue <= $item->ngay_den_han_tt_thue)){
											echo "<span class='label label-success'>thanh toán thuế đúng hạn</span>";
										}
									} elseif ($item->status_thue == "chua_thanh_toan") {
										echo "<span class='label label-danger'>chưa thanh toán</span>";
									}else{
										echo "<span class='label label-warning'>hợp đồng thanh lý</span>";
									}
									?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="table-footer">
				<div class="row">
					<div class="col-md-2">
						<p>Tổng tiền phải trả</p>
						<h4><?php echo number_format($tong_tien_phai_tra)?></h4>
					</div>
					<div class="col-md-2">
						<p>Tổng tiền đã trả</p>
						<h4><?php echo number_format($tien_tra_thuc_te)?></h4>
					</div>
					<div class="col-md-2">
						<p>Còn lại phải trả</p>
						<?php if ($resutl->status == "active"){?>
						<h4 style="color: red;"><?php echo number_format($tong_tien_phai_tra - $tien_tra_thuc_te)?></h4>
						<?php }else{?>
							<?php echo '<span style="color: red;">0</span>'?>
						<?php }?>
					</div>
					<div class="col-md-2">
						<p>Tổng thuế phải trả</p>
						<h4><?php echo number_format($tong_tien_thue_phai_tra)?></h4>
					</div>
					<div class="col-md-2">
						<p>Tổng thuế đã trả</p>
						<h4><?php echo number_format($tien_thue_tra_thuc_te)?></h4>
					</div>
					<div class="col-md-2">
						<p>Tổng thuế còn lại </p>
						<?php if ($resutl->status == "active"){?>
						<h4 style="color: red;"><?php echo number_format($tong_tien_thue_phai_tra - $tien_thue_tra_thuc_te)?></h4>
						<?php }else{?>
							<?php echo '<span style="color: red;">0</span>'?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</form>
	<form>
		<div class="x_content">
			<h3>Lịch cập nhật </h3>
			<ul class="list-unstyled timeline workflow widget">
				<li>
					<div class="block">
						<div class="block_content">
							<?php if (!empty($logs)) : ?>
								<?php foreach ($logs as $key => $v) : ?>
									<h2 class="title">
										<a style="font-size: 14px"><?php echo $v->action ?></a>
									</h2>
									<div class="excerpt">
										<span><?php echo date("d/m/Y H:i:s",$v->created_at) ?></span>
										<span><?php echo $v->created_by ?></span><br>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</form>
</div>
</div>
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<p><span style="font-size: 20px;padding-left:27%;color: #0a5a2c">Thanh toán tiền thuê mặt bằng</span></p>
			<div class="form-group">
				<input type='text' placeholder="Nhập"
					   name="id_payment"
					   id="id_payment" hidden
				/>
			</div>
			<div class="form-group">
				<p style="color: red;padding-left: 10px;">Số hợp đồng: <span style="color: red">*</span></p>
				<input type='text' placeholder="Nhập"
					   name="code_contract"
					   id="code_contract" disabled
				/>
			</div>
			<div class="form-group">
				<p style="color: red;padding-left: 10px;">Tiền thanh toán: <span>*</span></p>
				<input type='text' placeholder=" Nhập số tiền"
					   name="one_month_rent1"
					   id="one_month_rent1"
					   class="one_month_rent1"
					   value="<?= set_value('one_month_rent'); ?>"/>
			</div>
			<div class="form-group">
				<p style="color: red;padding-left: 10px;">Tiền cấn cọc: <span>*</span></p>
				<input type='text' placeholder=" Nhập số tiền"
					   name="tien_coc"
					   id="tien_coc"
					   class="tien_coc"
					   value="<?= set_value('tien_coc'); ?>"/>
			</div>
			<div class="form-group">
				<p style="color: red;padding-left: 10px;">Ngày thanh toán thực tế: <span>*</span></p>
				<input type='date' placeholder=" Nhập số tiền"
					   name="ngay_thanh_toan_tt"
					   id="ngay_thanh_toan_tt"
					   class="ngay_thanh_toan_tt"
					   value="<?= set_value('ngay_thanh_toan_tt'); ?>"/>
			</div>
			<input type="hidden" name="id_tong_tenancy" value="<?php echo $_GET['id'] ?>">
			<div class="modal-header">
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"
							data-dismiss="modal">Hủy
					</button>
					<button type="button" id="btnSavePaymentTenancy" class="btn btn-primary"
							data-dismiss="modal">Lưu
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Thanh toán thuế</h3>
				<div class="form-group">
					<input type='text' placeholder="Nhập"
						   name="id_payment_tax"
						   id="id_payment_tax" hidden
					/>
				</div>
				<div class="form-group">
					<lable>Số hợp đồng</lable>
					<input type='text' placeholder="Nhập"
						   name="code_contract"
						   id="code_contract_tex" disabled
					/>
				</div>
				<div class="form-group">
					<label for="exampleFormControlTextarea1">Ngày thanh toán Thuế</label>
					<input placeholder="Ngày" class="textbox-n" type="text" onfocus="(this.type='date')"
						   id="ngay_thanh_toan_thue"
						   style="padding-left: 10px;" name="ngay_thanh_toan_thue">
				</div>
				<div>
					<label class="control-label"> </label>
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads" id="uploads_fileReturn2"></div>
						<label for="uploadinput2">
							<div class="block uploader">
								<span>+</span>
							</div>
						</label>
						<input id="uploadinput2" type="file" name="file"
							   data-contain="uploads_fileReturn2" data-title="Ảnh chi tiết "
							   multiple
							   data-type="fileReturn" class="focus">
					</div>
				</div>
				<div class="form-group">
					<p>Tiền thuế: <span>*</span></p>
					<input type='text' placeholder=" Nhập"
						   name="tien_thue"
						   id="tien_thue"
						   value="<?= set_value('tien_thue'); ?>" disabled />
				</div>
				<input type="hidden" name="id_tong" value="<?php echo $_GET['id'] ?>">
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
					<button type="button" id="btnSavePaymentTaxTenancy" class="btn btn-primary btnSavePaymentTaxTenancy" data-dismiss="modal" style="display: none">Cập
						nhật
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal4" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<p style="color: #0a5a2c;font-size: 30px;padding-left: 35%;margin-top:15px"><span>Form ghi chú</span></p>
			<div class="modal-header">
				<div class="form-group">
					<input type='text' placeholder="Nhập"
						   name="id_note"
						   id="id_note" hidden
					/>
				</div>
				<div class="form-group">
					<p>Tiêu đề<span>*</span></p>
					<input type='text' placeholder=" Nhập tiêu đề"
						   name="note"
						   id="note"
						   value="<?= set_value('note'); ?>"/>
				</div>
				<div class="form-group">
					<label for="exampleFormControlTextarea1">Thêm ghi
						chú</label>
					<textarea class="form-control"
							  placeholder=" Nhập nội dung"
							  id="note_description"
							  name="note_description"
							  rows="3"></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"
							data-dismiss="modal">Hủy
					</button>
					<button type="button" id="btnSaveTenancy" class="btn btn-primary"
							data-dismiss="modal">Thêm
					</button>
				</div>
				<div class="note_title"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal9" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="form-group">
					<input type='text' placeholder=" Nhập"
						   name="id_pax"
						   id="id_pax" hidden
					/>
				</div>
				<div class="uploads uploads_fileReturn1" id="uploads_fileReturn1">
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"
							data-dismiss="modal">Hủy
					</button>
				</div>

			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal11" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div style="display: flex;justify-content: space-between;align-items: center;">
		<p style="color: #0a5a2c;font-size: 30px;padding-left: 30%;margin-top:15px"><span>Cập nhập kỳ hạn</span></p>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true" style="margin-right: 10px;vertical-align: center	">&times;</span>
			</button>
		</div>
			<div class="modal-header">
				<div class="form-group">
					<input type='text' placeholder="Nhập"
						   name="id_payment_ky_han"
						   id="id_payment_ky_han" hidden
					/>
				</div>
				<div class="form-group">
					<p>Ngày thanh toán<span>*</span></p>
					<input type='date' placeholder=" Nhập ngày thanh toán"
						   name="ngay_thanh_toan"
						   id="ngay_thanh_toan_payment"
						  />
				</div>
				<div class="form-group">
					<p>Tổng tiền thanh toán<span>*</span></p>
					<input type='text' placeholder=" Nhập tổng số tiền"
						   name="one_month_rent_payment"
						   id="one_month_rent_payment"
						   class="one_month_rent_payment"
						   />
				</div>

				<div  class="form-input">
<!--					<p>Kỳ trả<span>*</span></p>-->
					<select name="ky_tra_update" id="ky_tra_update" hidden>
						<option value="">chọn kỳ thanh toán</option>
						<option value="1">1 tháng</option>
						<option value="2">2 tháng</option>
						<option value="3">3 tháng</option>
						<option value="6">6 tháng</option>
						<option value="12">12 tháng</option>
					</select>
				</div>
				<input type="hidden" name="id_tong_tenancy" value="<?php echo $_GET['id'] ?>">
				<div class="modal-footer">
					<button type="button" id="btnSavePaymentKyHan" class="btn btn-primary"
							data-dismiss="modal">Thêm
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal12" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<p style="color: #0a5a2c;font-size: 30px;padding-left: 8%;margin-top:15px"><span>Cập nhật tiền cọc chủ nhà thanh toán</span></p>
			<div class="modal-header">
				<div class="form-group">
					<input type='text' placeholder="Nhập"
						   name="id_coc_chu_nha"
						   id="id_coc_chu_nha"
						   value="<?= $id ?>" hidden
					/>
				</div>
				<div class="form-group" >
					<p>Số hợp đồng<span style="color: red">*</span></p>
					<input type='text' placeholder=" Nhập tiêu đề" style="margin-bottom: 10px"
						   name="code_contract_coc"
						   id="code_contract_coc"
						   value="<?= $resutl->code_contract ?>"/>
				</div>
				<div class="form-group">
					<p>Ngày thanh toán<span style="color: red">*</span></p>
					<input type='date' placeholder=" Nhập ngày thanh toán"
						   name="ngay_thanh_toan_coc"
						   id="ngay_thanh_toan_coc"/>
				</div>
				<div class="form-group" >
					<p style="margin-top:10px ">Số tiền thanh toán<span style="color: red">*</span></p>
					<input type='text' placeholder=" Nhập số tiền"
						   name="coc_bctt"
						   id="coc_bctt"/>
				</div>
				<div class="modal-footer btnChuNha">
					<button type="button" class="btn btn-secondary" style="width: 63px;height: 35px"
							data-dismiss="modal">Hủy
					</button>
					<button type="button" id="btnSaveCocChuNha" class="btn btn-primary" data-id="<?= $resutl->_id?>"
							data-dismiss="modal">Thêm
					</button>

					<style>
						.btnChuNha button{
						margin: 0px 5px!important;
						}
					</style>

				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalTLHD" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<p style="color: #0a5a2c;font-size: 30px;padding-left: 8%;margin-top:15px"><span>Thêm ngày thanh lý hợp đồng</span></p>
			<div class="modal-header">
				<div class="form-group">
					<input type='text' placeholder="Nhập"
						   name="id_tlhd"
						   id="id_tlhd"
						   value="<?= $id ?>" hidden
					/>
				</div>
				<div class="form-group">
					<p>Ngày thanh lý<span style="color: red">*</span></p>
					<input type='date' placeholder=" Nhập ngày thanh toán"
						   name="ngay_thanh_ly"
						   id="ngay_thanh_ly"/>
				</div>
				<div class="modal-footer btnChuNha">
					<button type="button" class="btn btn-secondary" style="width: 63px;height: 35px"
							data-dismiss="modal">Hủy
					</button>
					<button type="button" id="btnTLHD1" class="btn btn-primary" data-id="<?= $resutl->_id?>"
							data-dismiss="modal">Thêm
					</button>
					<style>
						.btnChuNha button{
						margin: 0px 5px!important;
						}
					</style>

				</div>
			</div>
		</div>
	</div>
</div>
<style>

	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.contractInformation {
		display: flex;
		flex-direction: column;
		gap: 25px;
	}

	.block {
		padding-left: 10px !important;
	}

	ul.timeline.workflow h2.title:before {
		left: -19px !important;
		top: 0px;
	}

	.excerpt {
		display: flex;
		flex-direction: column;
		gap: 10px;
	}

	.x_content {
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
		padding: 0% 1%;
	}

	.x_content h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
	}

	.btn-top a {
		font-style: normal;
		font-weight: 400;
		font-size: 12px;
		line-height: 14px;
	}

	.block_content h2 {
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
		color: #1D9752;
	}

	.excerpt span strong {
		font-style: normal;
		font-weight: 400;
		font-size: 12px;
		line-height: 14px;
		color: #B8B8B8;
	}

	.excerpt span {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: #676767;
	}

	.nav-small {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 5px 0px 35px 0px;
	}

	.btn-top {
		display: flex;
		justify-content: space-between;
		padding-bottom: 20px;
	}


	.realEstate h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.realEstate-form {
		padding: 16px;
		gap: 10px;
		width: 100%;
		background: #FFFFFF;
		border-radius: 8px;
		display: flex;
		flex-direction: column;
	}


	.realEstate-form h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.realEstate-form .btn-xtsa {
		padding: 8px 16px;
		gap: 8px;
		width: 141px;
		height: 40px;
		color: white;
	}

	.realEstate-label {
		display: flex;
		flex-direction: row;
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
		display: flex;
		align-items: center;
		color: #676767;
	}

	.realEstate-label b {
		color: #1D9752;

	}

	.realEstate-label::after {
		content: "";
		flex: 1 1;
		border-bottom: 1px solid #D9D9D9;
		margin: auto;
		margin-left: 10px;
	}

	.form-input p {
		padding-top: 14px;
	}

	.form-input p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		display: flex;
		align-items: center;
		color: #676767;
	}

	.form-input span {
		font-style: normal;
		font-weight: 400;
		font-size: 13px;
		line-height: 16px;
		display: flex;
		align-items: center;
		color: #C70404;
	}

	.form-input input {
		padding: 16px;
		width: 100%;
		height: 40px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.form-input select {
		width: 100%;
		height: 40px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
		padding-left: 10px;
	}

	.form-input select option {
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		height: 35px;
		width: 100%;
	}

	.form-input {
		margin-bottom: 8px;
	}

	/* _________table________ */
	.form-table {
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;

	}

	.form-table h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		padding-left: 1%;

	}

	.table-footer {
		padding: 1%;
	}

	.outer {
		overflow-y: auto;
		height: 500px;
	}

	.outer {
		width: 100%;
		-layout: fixed;
	}

	.outer th {
		text-align: center;
		top: 0;
		position: sticky;
		background-color: white;
		z-index: 100;
		background: #E8F4ED;
	}

	.outer td {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		text-align: center;
	}

	.table-footer p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: #676767;
	}

	.table-footer h4 {
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
		color: #676767;
	}

	/* ---------------- */

	.drop-btn {
		border: none;
		background-color: transparent;
		margin: 0px;
		color: #1D9752;
	}

	.dropdown-xt {
		position: relative;
		display: inline-block;
	}

	.dropdown-content {
		display: none;
		position: absolute;
		background-color: while;
		/* min-width: 160px; */
		padding: 9px 10px;
		box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
		z-index: 1;
		top: 100%;
	}

	.dropdown-content a {
		color: black;
		padding: 8px 16px;
		text-decoration: none;
		display: block;
		text-align: left;
	}

	.dropdown-content a:hover {
		/* background-color: #DCCAE9; */
		color: green;
	}

	.dropdown-xt:hover .dropdown-content {
		display: block;
		background-color: white;
	}

	/* ----------------- */
	.modal-header {
		display: flex;
		flex-direction: column;
		gap: 16px;

	}

	.modal-header h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 16px;
		line-height: 20px;
		text-align: center;

	}

	.form-group label {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		/* identical to box height, or 114% */

		display: flex;
		align-items: center;

		/* Text/Body */

		color: #676767;


	}

	.form-group input {
		width: 100%;
		height: 40px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.modal-text {
		display: flex;
		flex-direction: column;
		gap: 2px;
	}

	.modal-text p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: #676767;
	}

	.modal-text span {
		font-style: normal;
		font-weight: 400;
		font-size: 10px;
		line-height: 12px;
		color: #B8B8B8;
	}

	.modal-text label {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: #676767;
	}

	.form-label-text label {
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
		color: #1D9752;
		white-space: normal;
		width: 180px;
	}

	@media (min-width: 768px) {
		#iic {
			width: 989px;
			margin: 10px auto;
		}
	}

	.theloading {
		position: fixed;
		z-index: 999;
		display: block;
		width: 100vw;
		height: 100vh;
		background-color: rgba(0, 0, 0, .7);
		top: 0;
		right: 0;
		color: #fff;
		display: flex;
		justify-content: center;
		align-items: center
	}

	input[type="text"][disabled] {
		background-color: #eee;
	}

	select[id="address1"][disabled] {
		background-color: hwb(20deg 88% 10%);
	}

	select[id="bank_name1"][disabled] {
		background-color: hwb(20deg 88% 10%);
	}

	.invalid {
		border: 1px solid red !important;
	}
</style>
<script>
	$(document).ready(function () {
		$('.note').click(function (event) {
			event.preventDefault();
			let id = $(this).attr('data-id');
			let formData = new FormData();
			formData.append('id', id);
			$.ajax({
				url: _url.base_url + 'tenancy/findOnePaymentPeriod',
				type: 'POST',
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
					$(".note_title").html("")
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						console.log(data.data)
						$('#id_note').val(data.data._id)
						$.each(data.data.noteOneTenancy, function (key, value) {
							$(".note_title").append(
									' <li style="list-style:none"><p class="text-danger">' + 'Ngày tạo: ' + new Date(value.created_at * 1000).format('d-m-Y') + '</p></li>' +
									' <li style="list-style:none"><p class="text-danger">' + 'Người tạo: ' + value.created_by + '</p></li>' +
									'<li style="list-style:none"><p class="text-danger">' + 'Tiêu đề: ' + value.note + '</p></li>' +
									' <li style="list-style:none"><p class="text-danger">' + 'Nội dung: ' + value.note_description + '</p></li><br>'
							);
						});
					}
				}
			})
		})

		$("#btnSaveTenancy").click(function (event) {
			event.preventDefault();
			var id = $("input[name='id_note']").val();
			var note = $("input[name='note']").val();
			var note_description = $("textarea[name='note_description']").val();
			var formData = new FormData();
			formData.append('id', id)
			formData.append('note', note)
			formData.append('note_description', note_description)
			console.log(id, note, note_description);
			$.ajax({
				url: _url.base_url + 'tenancy/note_tenancy',
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
					$(".modal_missed_call").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					} else {
						console.log(data)
						if (data.msg) {
							$(".msg_error").html("");
							  $.each(data.msg, function(key, value) {
								  console.log(value)
							  $(".msg_error").append('<li style="list-style:none"><p class="text-danger">' + value + '</p></li>');
							  $("#errorModal").modal('show');
							});
						}
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			})
		})

		$('.paymentTenacy').click(function (event) {
			event.preventDefault();
			let id = $(this).attr('data-id');
			let formData = new FormData();
			formData.append('id', id);
			$.ajax({
				url: _url.base_url + 'tenancy/findOnePaymentPeriod',
				type: 'POST',
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						console.log(data.data)
						$('#id_payment').val(data.data._id)
						$('#code_contract').val(data.data.code_contract)
					}
				}
			})
		})

		$("#btnSavePaymentTenancy").click(function (event) {
			event.preventDefault();
			var id = $("input[name='id_payment']").val();
			var code_contract = $("input[name='code_contract']").val();
			var one_month_rent = $("input[name='one_month_rent1']").val();
			var tien_coc = $("input[name='tien_coc']").val();
			var id_tong_tenancy = $("input[name='id_tong_tenancy']").val();
			var ngay_thanh_toan_tt = $("input[name='ngay_thanh_toan_tt']").val();
			var formData = new FormData();
			formData.append('id', id)
			formData.append('one_month_rent', one_month_rent)
			formData.append('tien_coc', tien_coc)
			formData.append('code_contract', code_contract)
			formData.append('id_tong_tenancy', id_tong_tenancy)
			formData.append('ngay_thanh_toan_tt', ngay_thanh_toan_tt)
			console.log(id, one_month_rent, tien_coc, code_contract);
			$.ajax({
				url: _url.base_url + 'tenancy/payment_Tenancy',
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
					$(".modal_missed_call").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					} else {
						$('#errorModal').modal('show');
						$('.msg_error').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			})
		})

		$('.paymentTax').click(function (event) {
			event.preventDefault();
			let id = $(this).attr('data-id');
			let formData = new FormData();
			formData.append('id', id);
			$.ajax({
				url: _url.base_url + 'tenancy/findOnePaymentPeriod',
				type: 'POST',
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						console.log(data.data)
						$('#id_payment_tax').val(data.data._id)
						$('#code_contract_tex').val(data.data.code_contract)
						$('#tien_thue').val(addCommas(data.data.tien_thue.toString()))
					}
				}
			})
		})

		$("#btnSavePaymentTaxTenancy").click(function (event) {
			event.preventDefault();
			var count2 = $("img[name='img_fileReturn2']").length;
			var fileReturn_img2 = {};
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
			var id = $("input[name='id_payment_tax']").val();
			var code_contract = $("input[id='code_contract_tex']").val();
			var tien_thue = $("input[name='tien_thue']").val();
			var ngay_thanh_toan_thue = $("input[name='ngay_thanh_toan_thue']").val();
			var id_tong = $("input[name='id_tong']").val();
			let image_thue = JSON.stringify(fileReturn_img2)
			var formData = new FormData();
			formData.append('id', id)
			formData.append('tien_thue', tien_thue)
			formData.append('ngay_thanh_toan_thue', ngay_thanh_toan_thue)
			formData.append('code_contract', code_contract)
			formData.append('id_tong', id_tong)
			formData.append('image_thue', image_thue)
			console.log(id, tien_thue, ngay_thanh_toan_thue, code_contract, image_thue);
			$.ajax({
				url: _url.base_url + 'tenancy/thanh_toan_thue',
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
					$(".modal_missed_call").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					} else {
						if (data.msg) {
							console.log(data)
							$(".msg_error").html("");
							  $.each(data.msg_text, function(key, value) {
								  console.log(value)
							  $(".msg_error").append('<li style="list-style:none"><p class="text-danger">' + value + '</p></li>');
							  $("#errorModal").modal('show');
							});
						}
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			})
		})

		$("#btnThanhLyHD").click(function (event) {
			let id = $(this).attr('data-id');
			let formData = new FormData();
			formData.append('id', id);
			if (confirm("Bạn chắc chắn muốn thay thanh lý hợp đồng?")) {
				$.ajax({
					url: _url.base_url + 'tenancy/Thanh_ly_hop_dong',
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
						$(".modal_missed_call").hide();
						if (data.status == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						} else {
							$('#errorModal').modal('show');
							$('.msg_error').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						}
					},
					error: function (data) {
						console.log(data);
						$(".theloading").hide();
					}
				})
			}
		})

		$("#updateHD").click(function (event) {
			let id = $(this).attr('data-id');
			let nguoi_nop_thue = $("select[name='nguoi_nop_thue']").val();
			let ma_so_thue = $("input[name='ma_so_thue']").val();
			let staff_ptmb = $("input[name='staff_ptmb']").val();
			let formData = new FormData();
			formData.append('id', id);
			formData.append('nguoi_nop_thue', nguoi_nop_thue);
			formData.append('ma_so_thue', ma_so_thue);
			formData.append('staff_ptmb', staff_ptmb);
			console.log(ma_so_thue, nguoi_nop_thue, staff_ptmb)
			if (confirm("Bạn chắc chắn muốn cập nhật hợp đồng?")) {
				$.ajax({
					url: _url.base_url + 'tenancy/updateTenancy',
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
						$(".modal_missed_call").hide();
						if (data.status == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						} else {
							$('#errorModal').modal('show');
							$('.msg_error').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						}
					},
					error: function (data) {
						console.log(data);
						$(".theloading").hide();
					}
				})
			}
		})

		$('input[type=file]').change(function () {
			var contain = $(this).data("contain");
			var title = $(this).data("title");
			var type = $(this).data("type");
			var contractId = $("#contract_id").val();

			$('#uploadinput1').simpleUpload(_url.base_url + "tenancy/upload_img", {
				// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
				allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4","pdf"],
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
						//Image
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img src="https://upload.tienvui.vn/uploads/avatar/1668653339-0f6bf376687183afe8dad0e3202d7a29.png">'
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn3"  data-key="' + data.key + '" src="' + data.path +  '" onerror="this.style.display=\'none\'" />'
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div class="block1" ></div>').html(content);
						this.block.append(data);
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
			$('#uploadinput2').simpleUpload(_url.base_url + "tenancy/upload_img", {
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
						//Image
						$(".btnSavePaymentTaxTenancy").show();
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn2"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div class="block1" ></div>').html(content);
						this.block.append(data);
						alert("Upload ảnh thành công");
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

		$("#upload_image").click(function (event) {
			var count1 = $("img[name='img_fileReturn3']").length;
			var fileReturn_img1 = {};
			if (count1 > 0) {
				$("img[name='img_fileReturn3']").each(function () {
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
			let img_tenancy = JSON.stringify(fileReturn_img1)
			console.log(img_tenancy);
			var id = $("#img_upload_id").val()
			var formData = new FormData();
			formData.append('image_tenancy', img_tenancy);
			formData.append('id', id);
			$.ajax({
				dataType: 'json',
				enctype: 'multipart/form-data',
				url: _url.base_url + 'tenancy/uploadImage',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					console.log(data)
					$(".theloading").hide();
					if (data.status == 200) {
						$(".theloading").hide();
						$('#successModal').modal('show');
						$('.msg_success').text(data.msg);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					} else {
						$(".theloading").hide();
						$('#errorModal').modal('show');
						$('.msg_error').text(data.msg);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					}
				},
				error: function (data) {
					console.log('error')
					$(".theloading").hide();
				}
			});
		})

		$("#btnSaveInsertKyHan").click(function (event) {
			event.preventDefault();
			$('.invalid-message').remove();
			$('.invalid').removeClass('invalid');
			var id = $("#modal7 input[name='id_ky_han']").val();
			var start_date_contract = $("#modal7 input[name='start_date_contract']").val();
			var end_date_contract = $("#modal7 input[name='end_date_contract']").val();
			var ky_tra = $("#modal7 select[name='ky_tra']").val();
			var contract_expiry_date = $("#modal7 select[name='contract_expiry_date']").val();
			var one_month_rent = $("#modal7 input[name='one_month_rent']").val();
			var formData = new FormData();
			formData.append('id', id)
			formData.append('start_date_contract', start_date_contract)
			formData.append('end_date_contract', end_date_contract)
			formData.append('ky_tra', ky_tra)
			formData.append('contract_expiry_date', contract_expiry_date)
			formData.append('one_month_rent', one_month_rent)
			console.log(start_date_contract, end_date_contract, ky_tra, contract_expiry_date, one_month_rent);
			$.ajax({
				url: _url.base_url + 'tenancy/newInsertKyHan',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
					$("#btnSaveInsertKyHan").attr('disabled', true)
				},
				success: function (data) {
					$(".theloading").hide();
					$(".modal_missed_call").hide();
					$("#btnSaveInsertKyHan").attr('disabled',false)
					if (data.status == 200) {
					$('#modal7').modal('hide');
						toastr.success('thêm phụ lục mới thành công');
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					} else {
						console.log(data);
						if (data.msg) {
							if (Object.keys(data.msg).length > 0){
								$(".msg_error").html("");
							 $.each(data.msg, function(i) {
							 console.log(data.msg[i]);
							 console.log(data.msg[i][0]);
							 	$('#modal7 [name=' + i + ']').after("<span class='invalid-message' style='margin-top: 5px;color: red'>" + data.msg[i][0] + "</span>");
							 	$('#modal7 [name=' + i + ']').addClass("invalid");
							 });
							 window.scrollTo(0, 0);
							}else {
								toastr.error('Hợp đồng đã thanh lý không thể thao tác này được');
							}

						}
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			})
		})



		$('.pax').click(function (event) {
			event.preventDefault();
			$(".uploads_fileReturn1").html("");
			let id = $(this).attr('data-id');
			$.ajax({
				url: _url.base_url + 'tenancy/findImageThue?id=' + id,
				type: 'GET',
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (data) {
					$(".theloading").hide();
					let html = '';
					if (data.status == 200) {
						$.each(data.data, function (key, value) {
							console.log(value)
							if(value.file_type == 'image/png' || value.file_type == 'image/jpg' || value.file_type == 'image/jpeg'){
								html += '<div class="block"><a href="'+value.path+'"  class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" data-caption="Ảnh chi tiết hợp đồng">' +
									'<img data-type="fileReturn" data-fileType="' + value.file_type + '" data-fileName="' + value.file_name + '" name="img_fileReturn1" data-key="' + value.key + '" src="' + value.path + '">' +
									'</a> </div>'
							}
						});
						$(".uploads_fileReturn1").html(html);
					}
				}
			})
		})

		function addCommas(str) {
			return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}

		$('#one_month_rent1').on('keyup', function (event) {
			var one_month_rent = $("input[name='one_month_rent1']").val()
			$('#one_month_rent1').val(addCommas(one_month_rent))
		})

		$('#tien_coc').on('keyup', function (event) {
			var tien_coc = $("input[name='tien_coc']").val()
			$('#tien_coc').val(addCommas(tien_coc))
		})

		$('#one_month_rent_payment').on('keyup', function (event) {
			var one_month_rent_payment = $("input[name='one_month_rent_payment']").val()
			$('#one_month_rent_payment').val(addCommas(one_month_rent_payment))
		})

		$('#coc_bctt').on('keyup', function (event) {
			var coc_bctt = $("input[name='coc_bctt']").val()
			$('#coc_bctt').val(addCommas(coc_bctt))
		})

		$('#one_month_rent2').on('keyup', function (event) {
			var one_month_rent2 = $("input[name='one_month_rent2']").val()
			$('#one_month_rent2').val(addCommas(one_month_rent2))
		})

		$('.paymentKyHan').click(function (event) {
			event.preventDefault();
			let id = $(this).attr('data-id');
			console.log(id)
			let formData = new FormData();
			formData.append('id', id);
			$.ajax({
				url: _url.base_url + 'tenancy/findOnePayment',
				type: 'POST',
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						console.log(data.data)
						$('#id_payment_ky_han').val(data.data._id)
						$('#ngay_thanh_toan_payment').val(data.data.ngay_thanh_toan)
						$('#one_month_rent_payment').val(addCommas(data.data.one_month_rent.toString()))
						$('#ky_tra_update').val(data.data.ky_tra)
					}
				}
			})
		})

		$("#btnSavePaymentKyHan").click(function (event) {
			let id = $("input[name='id_payment_ky_han']").val();
			let ngay_thanh_toan = $('input[name="ngay_thanh_toan"]').val();
			let one_month_rent = $('input[name="one_month_rent_payment"]').val();
			let id_tong_tenancy = $("input[name='id_tong_tenancy']").val();
			let ky_tra = $("select[name='ky_tra_update']").val();
			let formData = new FormData();
			formData.append('id', id);
			formData.append('ngay_thanh_toan', ngay_thanh_toan);
			formData.append('one_month_rent', one_month_rent);
			formData.append('id_tong_tenancy', id_tong_tenancy);
			formData.append('ky_tra', ky_tra);
			console.log(one_month_rent, ngay_thanh_toan,id_tong_tenancy,ky_tra)
			if (confirm("Bạn chắc chắn muốn cập nhật kỳ hạn?")) {
				$.ajax({
					url: _url.base_url + 'tenancy/updatePaymentKyHan',
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
						$(".modal_missed_call").hide();
						if (data.status == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						} else {
							$('#errorModal').modal('show');
							$('.msg_error').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						}
					},
					error: function (data) {
						console.log(data);
						$(".theloading").hide();
					}
				})
			}
		})


		$("#btnSaveCocChuNha").click(function (event) {
			let id = $(this).attr('data-id');
			let coc_bctt = $("input[name='coc_bctt']").val();
			let ngay_thanh_toan_coc = $("input[name='ngay_thanh_toan_coc']").val();
			let formData = new FormData();
			formData.append('id', id);
			formData.append('coc_bctt', coc_bctt);
			formData.append('ngay_thanh_toan_coc', ngay_thanh_toan_coc);
			console.log(coc_bctt, id,ngay_thanh_toan_coc)
			if (confirm("Bạn chắc chắn muốn cập nhật hợp đông?")) {
				$.ajax({
					url: _url.base_url + 'tenancy/thanh_toan_coc_chu_nha',
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
						$(".modal_missed_call").hide();
						console.log(data)
						if (data.status == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						} else {
							$('#errorModal').modal('show');
							$('.msg_error').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						}
					},
					error: function (data) {
						console.log(data);
						$(".theloading").hide();
					}
				})
			}
		})



		$('#one_month_rent').on('keyup', function (event) {
			var one_month_rent = $("#modal7 input[name='one_month_rent']").val()
			$('#one_month_rent').val(addCommas(one_month_rent))
		})

		$("#btnTLHD1").click(function (event) {
			event.preventDefault();
			var id = $("#modalTLHD input[name='id_tlhd']").val();
			var ngay_thanh_ly = $("#modalTLHD input[name='ngay_thanh_ly']").val()
			var formData = new FormData();
			formData.append('id', id)
			formData.append('ngay_thanh_ly', ngay_thanh_ly)
			console.log(ngay_thanh_ly,id)
			$.ajax({
				url: _url.base_url + 'tenancy/thanh_ly_hop_dong_tenancy',
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
					$(".modal_missed_call").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					} else {
						$('#errorModal').modal('show');
						$('.msg_error').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			})
		})

	})

		function deleteImage(thiz) {
			var thiz_ = $(thiz);
			var key = $(thiz).data("key");
			var type = $(thiz).data("type");
			var id = $(thiz).data("id");
			var count2 = $("img[name='img_fileReturn2']").length;
			console.log(count2)
			if (count2 <= 1) {
				$(".btnSavePaymentTaxTenancy").hide();
			}
			// var res = confirm("Bạn có chắc chắn muốn xóa");
			if (confirm("Bạn có chắc chắn muốn xóa ?")) {
				$(thiz_).closest("div .block").remove();
			}
		}




</script>
<script type="text/javascript">
	$(document).ajaxStart(function () {
		$("#loading").show();
		var loadingHeight = window.screen.height;
		$("#loading, .right-col iframe").css('height', loadingHeight);
	}).ajaxStop(function () {
		$("#loading").hide();
	});

</script>

