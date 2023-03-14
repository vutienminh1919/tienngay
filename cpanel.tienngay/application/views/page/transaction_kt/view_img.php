<!-- page content -->
<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<?php
$transaction_id = !empty($_GET['id']) ? $_GET['id'] : "";
?>
<div class="right_col" role="main">
	<!--	Tính năng duyệt phiếu thu-->
	<?php
	if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $this->lang->line('view_img_authentication') ?>
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a
								href="<?php echo base_url('transaction') ?>">Danh sách phiếu thu</a> / <a
								href="#"><?php echo $this->lang->line('view_img_authentication') ?></a>
					</small>
				</h3>
			</div>
			<div class="title_right text-right">
				<?php if (in_array($result->type, [7, 8, 10, 11, 12])) {
					?>
					<a href="<?php echo base_url('transaction/approveTransactionHeyU?tab=all') ?>"
					   class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } else if (in_array($result->type, [3, 4])) { ?>
					<a href="<?php echo base_url('transaction/list_kt?tab=all') ?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } ?>
				<?php if ($result->status == 2 && in_array($result->type, [3, 4])) { ?>
					<a href="javascript:void(0)" onclick="duyet_viewImg(this)"
					   data-id="<?= !empty($result->_id->{'$oid'}) ? $result->_id->{'$oid'} : '' ?>"
					   data-code_transaction_bank="<?= !empty($result->code_transaction_bank) ? $result->code_transaction_bank : '' ?>"
					   data-bank="<?= !empty($result->bank) ? $result->bank : '' ?>"
					   data-note="<?php $content_billing = '';
					   $notes = !empty($result->note) ? $result->note : "";
					   if (is_array($notes)) {
						   foreach ($notes as $note) {
							   $content_billing .= billing_content($note);
						   }
						   echo $content_billing;
					   } ?>"
					   class="btn btn-info gui_cht_duyet">
						Duyệt giao dịch
					</a>
					<a href="javascript:void(0)"
					   onclick="kttrave(this)"
					   data-id="<?= !empty($result->_id->{'$oid'}) ? $result->_id->{'$oid'} : '' ?>"
					   class="dropdown-item travepgd btn btn-info">
						Trả lại PGD
					</a>
					<a href="javascript:void(0)" onclick="huy_viewImg(this)"
					   data-id="<?= !empty($result->_id->{'$oid'}) ? $result->_id->{'$oid'} : '' ?>"
					   data-code_transaction_bank="<?= !empty($result->code_transaction_bank) ? $result->code_transaction_bank : '' ?>"
					   data-bank="<?= !empty($result->bank) ? $result->bank : '' ?>"
					   data-note="<?php $content_billing = '';
					   $notes = !empty($result->note) ? $result->note : "";
					   if (is_array($notes)) {
						   foreach ($notes as $note) {
							   $content_billing .= billing_content($note);
						   }
						   echo $content_billing;
					   } ?>"
					   class="btn btn-info gui_cht_duyet">
						Hủy giao dịch
					</a>
				<?php } elseif ($result->status == 2 && in_array($result->type, [7, 8, 10, 11, 12])) { ?>
					<a href="javascript:void(0)"
					   onclick="ktduyetgiaodichheyu(this)"
					   data-id="<?= !empty($result->_id->{'$oid'}) ? $result->_id->{'$oid'} : '' ?>"
					   class="dropdown-item duyet btn btn-info">
						Duyệt giao dịch
					</a>
					<a href="javascript:void(0)"
					   onclick="kttraveheyu(this)"
					   data-id="<?= !empty($result->_id->{'$oid'}) ? $result->_id->{'$oid'} : '' ?>"
					   class="dropdown-item ketoantrave btn btn-info">
						Trả lại PGD </a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<!--	Chi tiết phiếu thu hợp đồng-->

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="checkbox-inline ">
							<label style="color: red">
								<input name='check_code_contract' value="1" type="checkbox">
								&nbsp;Check phiếu thu liên quan
							</label>
						</div>
					</div>
				</div>
				<br>
				<?php if (!empty($result) && in_array($result->type, [3, 4, 5])) { ?>
					<div class="row flex" style="justify-content: center;">
						<div class="col-xs-12  col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tbody>
									<tr>
										<th>Mã phiếu thu</th>
										<td class="text-right"><?= !empty($result->code) ? $result->code : '' ?></td>
										<input type="hidden" id="code_transaction_check"
											   value="<?= !empty($result->code) ? $result->code : '' ?>">
									</tr>
									<tr>
										<th>Mã hợp đồng</th>
										<td class="text-right"><?= !empty($result->code_contract_disbursement) ? $result->code_contract_disbursement : '' ?></td>
									</tr>
									<tr>
										<th>Mã phiếu ghi</th>
										<td class="text-right"><?= !empty($result->code_contract) ? $result->code_contract : '' ?></td>
										<input type="hidden" id="code_contract_check"
											   value="<?= !empty($result->code_contract) ? $result->code_contract : '' ?>">
									</tr>
									<tr>
										<th>Tên khách hàng</th>
										<td class="text-right"><?= !empty($result->customer_name) ? $result->customer_name : '' ?></td>
									</tr>
									<tr>
										<th>Số tiền phải thanh toán</th>
										<td class="text-right "><?= !empty($result->detail->total_paid) ? number_format($result->detail->total_paid, 0, ',', ',') : "" ?></td>
									</tr>
									<tr>
										<th>Số tiền gửi duyệt</th>
										<td class="text-right text-danger"><?= (!empty($result->total) && $result->total > 0) ? number_format((int)$result->total, 0, '.', ',') : "" ?></td>
									</tr>
									<tr>
										<th>Trạng thái</th>
										<td class="text-right"><?php if ($result->status == "new") : ?>
												<span class="label label-info">Mới</span>
											<?php elseif ($result->status == 2): ?>
												<span class="label label-default">Chờ xác nhận</span>
											<?php elseif ($result->status == 1): ?>
												<span class="label label-success">Thành công</span>
											<?php elseif ($result->status == 4): ?>
												<span class="label label-warning">Chưa gửi duyệt</span>
											<?php elseif ($result->status == 3): ?>
												<span class="label label-danger">Đã hủy</span>
											<?php elseif ($result->status == 11): ?>
												<span class="label label-primary">Kế toán trả về PGD</span>
											<?php endif; ?>
										</td>
									</tr>
									<tr>
										<th>Hạn thanh toán</th>
										<td class="text-right"><?= !empty($result->detail->ngay_ky_tra) ? date('d/m/Y', intval($result->detail->ngay_ky_tra)) : "" ?></td>
									</tr>
									<tr>
										<th>Ngày thanh toán</th>
										<td class="text-right"><?= !empty($result->date_pay) ? date('d/m/Y H:i:s', intval($result->date_pay)) : date('d/m/Y H:i:s', intval($result->created_at)) ?></td>
									</tr>
									<tr>
										<th>Phương thức thanh toán</th>
										<td class="text-right"><?php
											$method = '';
											if (intval($result->payment_method) == 0) {
												$method = $result->payment_method;
											} else {
												if (intval($result->payment_method) == 1) {
													$method = $this->lang->line('Cash');
												} else if (intval($result->payment_method) == 2) {
													$method = 'Chuyển khoản';
												}
											}
											echo $method;
											?>
										</td>
									</tr>
									<tr>
										<th>Ngày tạo phiếu thu</th>
										<td class="text-right"><?= !empty($result->created_at) ? date('d/m/Y H:i:s', $result->created_at) : '' ?></td>
									</tr>
									<tr>
										<th>Người tạo phiếu thu</th>
										<td class="text-right"><?= !empty($result->created_by) ? $result->created_by : '' ?></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xs-12  col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tbody>
									<tr>
										<th>Nội dung thanh toán</th>
										<td class="text-right"><?php
											$content_billing = '';
											$notes = !empty($result->note) ? $result->note : "";
											if (is_array($notes)) {
												foreach ($notes as $note) {
													$content_billing .= billing_content($note);
												}
												echo $content_billing;
											} else {
												echo $result->note;
											}
											?></td>
									</tr>
									<tr>
										<th>Ngân hàng</th>
										<td class="text-right"><?= !empty($result->bank) ? $result->bank : '' ?></td>
									</tr>
									<tr>
										<th>Mã GD ngân hàng</th>
										<td class="text-right"><?= !empty($result->code_transaction_bank) ? $result->code_transaction_bank : '' ?></td>
									</tr>
									<tr>
										<th>Ngày bank nhận</th>
										<td class="text-right"><?= !empty($result->date_bank) ? date('Y-m-d', $result->date_bank) : "" ?></td>
									</tr>
									<tr>
										<th>Ghi chú kế toán</th>
										<td class="text-right"><?= !empty($result->approve_note) ? $result->approve_note : '' ?></td>
									</tr>

									<tr>
										<th>Số tiền thực nhận</th>
										<td class="text-right"><?= !empty($result->amount_actually_received) ? $result->amount_actually_received : "" ?></td>
									</tr>

									<tr>
										<th>Phí ngân hàng</th>
										<td class="text-right"><?= !empty($result->reduced_fee) ? $result->reduced_fee : "" ?></td>
									</tr>
									<tr>
										<th>Phí giảm trừ</th>
										<td class="text-right"><?= !empty($result->discounted_fee) ? $result->discounted_fee : "" ?></td>
									</tr>
									<tr>
										<th>Phí khác</th>
										<td class="text-right"><?= !empty($result->other_fee) ? $result->other_fee : "" ?></td>
									</tr>
									<tr>
										<th>Người duyệt phiếu thu</th>
										<td class="text-right"><?= !empty($result->approved_by) ? $result->approved_by : "" ?></td>
									</tr>
									<tr>
										<th>Ngày duyệt phiếu thu</th>
										<td class="text-right">
											<?php if (!empty($result->approved_at) && $result->status == 1)
												echo date('d/m/Y H:i:s', $result->approved_at);
											?>
										</td>
									</tr>
									<tr>
										<th>Ngày trả về</th>
										<td class="text-right"><?php if ($result->status == 11) {
												echo date('d/m/Y H:i:s', $result->approved_at);
											}
											?>
										</td>
									</tr>
									<tr>
										<th>Phòng giao dịch</th>
										<td class="text-right"><?= !empty($result->store->name) ? $result->store->name : '';
											?>
										</td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<div class="row flex" style="justify-content: center;">
						<div class="col-xs-12  col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tbody>
									<tr>
										<th>Mã phiếu thu</th>
										<td class="text-right">
											<strong><?= !empty($result->code) ? $result->code : "" ?></strong></td>
									</tr>
									<tr>
										<th>Loại phiếu thu</th>
										<td class="text-right"><?= !empty($result->type) ? type_transaction($result->type) : "" ?></td>
									</tr>
									<tr>
										<th>Thời gian tạo phiếu thu</th>
										<td class="text-right"><?= !empty($result->created_at) ? date('d/m/Y H:i:s', $result->created_at) : "" ?></td>
									</tr>
									<tr>
										<th>Số tiền gửi duyệt</th>
										<td class="text-right text-danger"><?= !empty($result->total) ? number_format((int)$result->total, 0, ',', ',') . ' VNĐ' : "" ?></td>
									</tr>
									<tr>
										<th>Trạng thái</th>
										<td class="text-right"><?php if ($result->status == "new") : ?>
												<span class="label label-info">Mới</span>
											<?php elseif ($result->status == 2): ?>
												<span class="label label-default">Chờ xác nhận</span>
											<?php elseif ($result->status == 1): ?>
												<span class="label label-success">Thành công</span>
											<?php elseif ($result->status == 4): ?>
												<span class="label label-warning">Chưa gửi duyệt</span>
											<?php elseif ($result->status == 3): ?>
												<span class="label label-danger">Đã hủy</span>
											<?php elseif ($result->status == 11): ?>
												<span class="label label-primary">Kế toán trả về PGD</span>
											<?php endif; ?>
										</td>
									</tr>

									<tr>
										<th>Phòng giao dịch</th>
										<td class="text-right"><?= !empty($result->store) ? $result->store->name : "" ?></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="col-xs-12  col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tbody>
									<tr>
										<th>Phương thức thanh toán</th>
										<td class="text-right"><?php
											$method = '';
											if (intval($result->payment_method) == 0) {
												$method = $result->payment_method;
											} else {
												if (intval($result->payment_method) == 1) {
													$method = $this->lang->line('Cash');
												} else if (intval($result->payment_method) == 2) {
													$method = 'Chuyển khoản';
												}
											}
											echo $method;
											?>
										</td>
									</tr>
									<tr>
										<th>Ngân hàng</th>
										<td class="text-right "><?= !empty($result->bank) ? $result->bank : "" ?></td>
									</tr>
									<tr>
										<th>Mã giao dịch ngân hàng</th>
										<td class="text-right "><?= !empty($result->code_transaction_bank) ? $result->code_transaction_bank : "" ?></td>
									</tr>
									<tr>
										<th>Ghi chú kế toán</th>
										<td class="text-right"><?= !empty($result->approve_note) ? $result->approve_note : "" ?></td>
									</tr>
									<tr>
										<th>Ngày duyệt</th>
										<td class="text-right"><?php if (!empty($result->approved_at) && $result->status == 1)
												echo date('d/m/Y H:i:s', $result->approved_at);
											?>
										</td>
									</tr>

									<tr>
										<th>Người duyệt</th>
										<td class="text-right"><?= !empty($result->approved_by) ? $result->approved_by : "" ?></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<!--Start expertise-->
			<div class="x_content">
				<form class="form-horizontal form-label-left">
					<div class="form-group ">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Chứng từ <span
									class="red">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div id="SomeThing" class="simpleUploader line">
								<div class="uploads" id="uploads_expertise">
									<?php
									if (!empty($result->image_banking->image_expertise)) {
										$key_expertise = 0;
										foreach ((array)$result->image_banking->image_expertise as $key => $value) {
											$key_expertise++;
											if (empty($value)) continue;
											?>
											<div class="block">
												<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
													<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													<a href="<?= $value->path ?>" class="magnifyitem"
													   data-magnify="gallery" data-src="" data-group="thegallery"
													   data-caption="Chứng từ <?php echo $key_expertise ?>">
														<img src="<?= $value->path ?>" alt="">
													</a>
												<?php } ?>
												<!--Audio-->
												<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
													<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													<a href="<?= $value->path ?>" target="_blank"><span
																style="z-index: 9"><?= $value->file_name ?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);"
															 src="https://image.flaticon.com/icons/png/512/81/81281.png"
															 alt="">
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
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);"
															 src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
															 alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path ?>" type="video/mp4">
                                                        <?= $value->file_name ?>
                                                    </video>-->
												<?php } ?>
												<!--PDF-->
												<?php if(!empty($value->file_type) && ($value->file_type == 'application/pdf')) {?>
													<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
													<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
														<img name="img_transaction" data-type="expertise" data-key='<?= $key?>' data-filetype="<?= $value->file_type?>" data-filename="<?= $value->file_name?>" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?= $value->path ?>" alt="">
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">
													</a>
												<?php }?>

												<div class="description"><textarea rows="6" data-key="<?= $key ?>"
																				   name="description_img"><?= $value->description ?></textarea>
												</div>
											</div>
										<?php }
									} ?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!--End-->
		</div>
	</div>
	

	<div class="col-md-12 col-sm-12 col-xs-12">
<div class="table-responsive">
      <h4><b> Lịch sử cập nhật</b></h4>
<table id="datatable-buttos" class="table table-striped table-bordered" style="width: 100%">
    <thead>
      <tr>
        <th>#</th>
		  <th>Ngày cập nhật</th>
         <th>Người cập nhật</th>
         <th>Mã phiếu ghi</th>
        <th>Ngày về bank</th>
        <th>Mã giao dịch ngân hàng</th>
         <th>Ngân hàng</th>
         <th>Số tiền thực nhận</th>
         <th>Loại thanh toán</th>
         <th>Ghi chú</th>
          <th>Trạng thái</th>
      
      </tr>
    </thead>

      <tbody>
      <?php
   

      if(!empty($result->logs)){
          foreach($result->logs as $key => $history){
           
              ?>

              <tr>
                  <td><?php echo $key+1?></td>
				 
                  <td><?= !empty($history->created_at) ? date('d/m/Y H:i:s', intval($history->created_at) ) : ""?></td>

                   <td><?= !empty($history->email) ? $history->email : ""?></td>
                   <td><?= !empty($history->data_post->code_contract) ? $history->data_post->code_contract : ""?></td>
                     <td><?= !empty($history->data_post->date_bank) ? date('d/m/Y H:i:s', intval($history->data_post->date_bank) ) : ""?></td>
                 
                   <td><?= !empty($history->data_post->code_transaction_bank) ? $history->data_post->code_transaction_bank : ""?></td>
                    <td><?= !empty($history->data_post->bank) ? $history->data_post->bank : ""?></td>
                    <td><?= !empty($history->data_post->amount_actually_received) ? number_format($history->data_post->amount_actually_received) : ""?></td>
                   
                  <td> <?= !empty($history->data_post->type_t) ?  type_transaction($history->data_post->type_t) : ""?></td>
                  <td><?= !empty($history->data_post->approve_note) ? $history->data_post->approve_note : ""?></td>
                  
                  <td>
                      <?php
                      $status = '';
                      if ($history->data_post->status == 1) {
                          $status = 'Thành công';
                      } elseif ($history->data_post->status == 2) {
                          $status = 'Chờ xác nhận';
                      } elseif ($history->data_post->status == 3) {
                          $status = 'Đã hủy';
                      } elseif ($history->data_post->status == 4) {
            			  $status = 'Chưa gửi duyệt';
					  } elseif ($history->data_post->status == 11) {
						  $status = 'Kế toán trả về';
					  } else {
						  $status = !empty($history->data_post->status) ? $history->data_post->status : '';
					  }
                      echo $status;
                      ?>
                  </td>
                
				  
              </tr>
          <?php }} ?>
     
      </tbody>
</table>
</div>
</div>
</div>
<div class="modal fade" id="duyet_viewImg">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<input type="hidden" name="contract_id" class="transaction_id" value="">
				<h5 class="modal-title title_modal_contract_v2">Duyệt phiếu thu</h5>
				<hr>
				<div class="form-group">
					<label>Ngân hàng:</label>

					<input type="text" class="form-control bank">
				</div>
				<div class="form-group">
					<label>Mã giao dịch ngân hàng:</label>

					<input type="text" class="form-control code_transaction_bank">
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control note" rows="5"></textarea>

				</div>
				<p class="text-right">
					<button class="btn btn-danger btn_duyet_viewImg">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>
<div class="modal fade" id="huy_viewImg">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<input type="hidden" name="contract_id" class="transaction_id" value="">
				<h5 class="modal-title title_modal_contract_v2">Duyệt phiếu thu</h5>
				<hr>
				<div class="form-group">
					<label>Ngân hàng:</label>

					<input type="text" class="form-control bank">
				</div>
				<div class="form-group">
					<label>Mã giao dịch ngân hàng:</label>

					<input type="text" class="form-control code_transaction_bank">
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control note" rows="5"></textarea>

				</div>
				<p class="text-right">
					<button class="btn btn-danger btn_huy_viewImg">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>
<!-- /page content -->
<div class="modal fade" id="approve_transaction_heyu" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title modal-title-approve-heyu">Duyệt giao dịch</h5>
				<hr>
				<div class="form-group">
					<label>Mã GD Ngân hàng:</label>
					<input type="text" class="form-control" name="code_transaction_bank" rows="5"/>
				</div>
				<div class="form-group">
					<label>Ngân hàng:</label>
					<input type="text" class="form-control" name="bank" rows="5"/>
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note_heyu" rows="5"></textarea>
					<input type="hidden" class="form-control status_approve_heyu" value="1">
					<input type="hidden" class="form-control transaction_id_approve_heyu">
				</div>
				<p class="text-right">
					<button class="btn btn-danger heyu_approve_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>
<!--Kế toán trả về với phiếu thu hợp đồng-->
<div class="modal fade" id="return_transaction" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title modal-title-approve">Trả về phòng giao dịch</h5>
				<hr>

				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control return_note" rows="5"></textarea>
					<input type="hidden" class="form-control status_return" value="11">
					<input type="hidden" class="form-control transaction_id_return">
				</div>
				<p class="text-right">
					<button class="btn btn-danger return_transaction_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<!--Kế toánt rả về với phiếu thu khác-->
<div class="modal fade" id="return_transaction_heyu" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title modal-title-approve-heyu">Trả về giao dịch</h5>
				<hr>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control return_note_heyu" rows="5"></textarea>
					<input type="hidden" class="form-control status_return_heyu" value="11">
					<input type="hidden" class="form-control transaction_id_return_heyu">
				</div>
				<p class="text-right">
					<button class="btn btn-danger heyu_return_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<!--Danh sách phiếu thu trùng-->

<div id="checkTransaction" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 90%">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Danh sách phiếu thu liên quan</h4>
			</div>
			<div class="modal-body">
				<div class="x_panel">
					<div class="x_content">
						<div class="table-responsive">
							<table class="table table-striped ">
								<thead>
								<tr>
									<th>#</th>
									<th>Ngày tạo PT</th>
									<th>Mã phiếu thu</th>
									<th>Tên Khách hàng</th>
									<th>Số tiền gửi duyệt</th>
									<th>Phòng giao dịch</th>
									<th>Trạng Thái</th>
									<th>Nội dung thanh toán</th>
								</tr>
								</thead>
								<tbody id='list_transaction_check'>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="checkTransactionFalse" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Danh sách phiếu thu liên quan</h4>
			</div>
			<div class="modal-body">
				Không có thông tin liên quan
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/transaction/upload.js"></script>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>


<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>
<script type="text/javascript">
	const cancelReason = `<div class="form-group reason-list">
					<label>Lý do:</label>
					<?php foreach ($reasons_cancel as $key => $value): ?>
						<div class="form-check">
	  					  <input class="form-check-input" type="checkbox" name="reason" value="<?=$key?>" id="reason<?=$key?>">
						  <label class="form-check-label" for="reason<?=$key?>">
						    <?=$value?>
						  </label>
						</div>
					<?php endforeach ?>
				</div>`;

const returnReason = `<div class="form-group reason-list">
					<label>Lý do:</label>
					<?php foreach ($reasons_return as $key => $value): ?>
						<div class="form-check">
	  					  <input class="form-check-input" type="checkbox" name="reason" value="<?=$key?>" id="reason<?=$key?>">
						  <label class="form-check-label" for="reason<?=$key?>">
						    <?=$value?>
						  </label>
						</div>
					<?php endforeach ?>
				</div>`;

</script>

<style>

	.ekko-lightbox .modal-header {
		padding-top: 5px;
		padding-bottom: 5px;
	}

	.ekko-lightbox .modal-body {
		padding: 5px;
	}
</style>
