<?php
$type = !empty($_GET['type']) ? $_GET['type'] : "";
$id = !empty($_GET['id']) ? $_GET['id'] : "";
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "1";
$display_image = $this->config->item("display_img");
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" id="loading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="row">
				<div class="col-xs-12">
					<h3>
						Chi tiết kỳ trả lãi <br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url('accountant/contract_v2') ?>">Quản lý hợp đồng đang
								vay</a> / <a href="#">Chi tiết kỳ trả lãi</a>
						</small>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<?php $this->load->view('page/accountant/top_view_detail'); ?>

				<br>

				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-pills" role="tablist">
						<li role="presentation" class="active"><a href="#tab_content1" id="tab001" role="tab"
																  data-toggle="tab" aria-expanded="true">Thông tin thanh
								toán</a>
						</li>
						<!--  61371d125324a775e80c5483 => Quyền xem view_v2 của Thu hồi  -->
						<?php if (in_array("61371d125324a775e80c5483", $userRoles->role_access_rights)) { ?>
						<li role="presentation" class=""><a href="#tab_content8" role="tab" id="tab008"
															data-toggle="tab" aria-expanded="false">Thông tin TC</a>
						</li>
						<!--    <li role="presentation" class=""><a href="#tab_content4" role="tab" id="tab004" data-toggle="tab" aria-expanded="false">Lịch thanh toán</a>
						   </li> -->
						<li><a target="_blank" href="<?php echo base_url() ?>pawn/viewImageAccuracy?id=<?= $id ?>"
							   id="tab007">Chứng từ</a>
						</li>

					<?php if ($display_image) : ?>
						<li role="presentation" class=""><a href="#tab_content10" role="tab" id="tab0010"
															data-toggle="tab" aria-expanded="false">Lịch sử TH</a>
						</li>
					<?php endif;?>

						<li role="presentation" class=""><a href="#tab_content9" role="tab" id="tab009"
															data-toggle="tab" aria-expanded="false">Lịch sử XD</a>
						</li>
						<?php } ?>
					  <?php  if($contractDB->status != 33 && $contractDB->status != 34 && $contractDB->status != 19 && $contractDB->status != 40){ 
                ?>
						<li role="presentation" class=""><a href="#tab_content3" role="tab" id="tab003"
															data-toggle="tab" aria-expanded="false">Thanh toán</a>
						</li>
						<li role="presentation" class=""><a href="#tab_content5" role="tab" id="tab005"
															data-toggle="tab" aria-expanded="false">Tất toán</a>
						</li>
                         <?php }  ?>
						<?php  if($contractDB->status == 40){ ?>
							<li role="presentation" class=""><a href="#tab_content14" role="tab" id="tab014"
																data-toggle="tab" aria-expanded="false">Tất toán (tài sản đảm bảo đã thanh lý)</a>
							</li>
						<?php }  ?>
<!--						View upload đơn miễn giảm-->
						<?php if (isset($exemption_contract) && !in_array($exemption_contract->status,[2,3,8,9]) || $contractDB->status == 19) { ?>
						<li role="presentation" class="d-none"><a href="#tab_content_create_exemption_contract"
																  role="tab"
																  id="tab_create_exemption_contract"
																  data-toggle="tab" aria-expanded="false">Upload đơn miễn giảm</a>
						</li>
						<?php } else if (in_array($exemption_contract->status,[2,3,8,9])) { ?>
						<li role="presentation" class=""><a href="#tab_content_update_exemption_contract"
															role="tab"
															id="tab_update_exemption_contract"
															data-toggle="tab"
															aria-expanded="false">Cập nhập đơn miễn giảm</a>
						</li>
						<?php } else { ?>
						<li role="presentation" class=""><a href="#tab_content_create_exemption_contract"
															role="tab"
															id="tab_create_exemption_contract"
															data-toggle="tab"
															aria-expanded="false">Upload đơn miễn giảm</a>
						</li>
						<?php } ?>
				<?php if ($display_image) : ;?>
						<?php if (!empty($exemption_contract_all)) { ?>
						<li role="presentation" class=""><a href="#tab_content_history_exemption_contract"
															role="tab"
															id="tab_history_exemption_contract"
															data-toggle="tab" aria-expanded="false">Thông tin miễn giảm</a>
						</li>
						<?php } ?>
				<?php else: ;?>
						<?php if (!$isTransactionExemptionsApproved) : ;?>
							<?php if (!empty($exemption_contract_all)) { ?>
								<li role="presentation" class=""><a href="#tab_content_history_exemption_contract"
																	role="tab"
																	id="tab_history_exemption_contract"
																	data-toggle="tab" aria-expanded="false">Thông tin miễn giảm</a>
								</li>
							<?php } ?>
						<?php endif;?>
				<?php endif ;?>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab001">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab001'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab002">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab002'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="tab003">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab003'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="tab004">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab004'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="tab005">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab005'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="tab006">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab006'); ?>
						</div>

						<div role="tabpanel" class="tab-pane fade" id="tab_content8" aria-labelledby="tab008">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab008'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content9" aria-labelledby="tab009">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab009'); ?>
						</div>
						<?php if ($display_image) : ?>
							<div role="tabpanel" class="tab-pane fade" id="tab_content10" aria-labelledby="tab0010">
								<?php $this->load->view('page/accountant/thn/debt_detail_tab0010'); ?>
							</div>
						<?php endif;?>
						<div role="tabpanel" class="tab-pane fade" id="tab_content11" aria-labelledby="tab011">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab011'); ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content14" aria-labelledby="tab014">
							<?php $this->load->view('page/accountant/thn/debt_detail_tab014'); ?>
						</div>
						
						
						
							<?php if (isset($exemption_contract) && !in_array($exemption_contract->status,[2,3,8,9]) || $contractDB->status == 19) { ?>
						<div role="tabpanel" class="tab-pane fade d-none" id="tab_content_create_exemption_contract" aria-labelledby="tab_create_exemption_contract">
							<?php $this->load->view('page/accountant/thn/create_exemption_contract'); ?>
						</div>
					
						<?php } else if (in_array($exemption_contract->status,[2,3,8,9])) { ?>
						<div role="tabpanel" class="tab-pane fade" id="tab_content_update_exemption_contract" aria-labelledby="tab_update_exemption_contract">
							<?php $this->load->view('page/accountant/thn/update_exemption_contract'); ?>
						</div>
						<?php } else { ?>
						<div role="tabpanel" class="tab-pane fade" id="tab_content_create_exemption_contract" aria-labelledby="tab_create_exemption_contract">
							<?php $this->load->view('page/accountant/thn/create_exemption_contract'); ?>
						</div>
						</li>
						<?php } ?>
					<?php if ($display_image) : ;?>
						<?php if (!empty($exemption_contract_all)) { ?>
						<div role="tabpanel" class="tab-pane fade" id="tab_content_history_exemption_contract" aria-labelledby="tab_history_exemption_contract">
							<?php $this->load->view('page/accountant/thn/histories_exemption_contract.php'); ?>
						</div>
						<?php } ?>
					<?php else: ;?>
						<?php if (!$isTransactionExemptionsApproved) : ;?>
							<?php if (!empty($exemption_contract_all)) { ?>
								<div role="tabpanel" class="tab-pane fade" id="tab_content_history_exemption_contract" aria-labelledby="tab_history_exemption_contract">
									<?php $this->load->view('page/accountant/thn/histories_exemption_contract.php'); ?>
								</div>
							<?php } ?>
						<?php endif;?>
					<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<input type="hidden" id="id_contract" class="form-control" value="<?= isset($_GET['id']) ? $_GET['id'] : ''; ?>">

<!-- /page content -->
<div class="modal fade" id="tab002_phoneresultModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">GỌI CHO SỐ: 0347110955</h5>
				<hr>
				<div class="row">
					<div class="col-xs-12 col-lg-6">
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Họ và tên</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" class="form-control" value="NGUYEN VAN AN" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Số điện thoại</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" class="form-control" value="0347110955" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Mối quan hệ</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" class="form-control" value="Khách hàng" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Số điện thoại mới</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" class="form-control" value="">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Kết quả</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" class="form-control" value="">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-lg-6">
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Số tiền hẹn thanh toán</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" class="form-control" value="">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Ngày hẹn thanh toán</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" class="form-control" value="">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Ghi chú</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<textarea class="form-control" rows="3" cols="80"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-xs-12">
								<h4>00:15:15</h4>
							</div>
						</div>
					</div>
				</div>
				<p class="text-center">
					<button class="btn btn-danger">Lưu và kết thúc</button>
				</p>

			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
				<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
				<input id="number" name="phone_number" type="hidden" value=""/>
				<p id="status" style="margin-left: 125px;"></p>
				<h3 class="modal-title title_modal_approve"></h3>
				<hr>
				<div class="form-group">
					<label>Kết quả nhắc hợp đồng vay:</label>
					<select class="form-control " style="width: 70%" id="result_reminder">
						<?php foreach (note_renewal() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Ngày hẹn thanh toán:</label>
					<input type="date" name="payment_date" class="form-control " id="payment_date">
				</div>
				<div class="form-group">
					<label>Số tiền hẹn thanh toán:</label>
					<input type="text" class="form-control " id="amount_payment_appointment">
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control " id="contract_v2_note" rows="5"></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				</table>
				<p class="text-right">
					<button class="btn btn-danger " id="approve_call_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal_edit_phone" tabindex="-1" role="dialog" aria-labelledby="ContractUpdateModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 55%;  ">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Cập nhật thông tin</h4>
				<hr>
				<input type="hidden" name="contract_id_update" value="<?php echo $contract_id ?>">
				<div class="form-group">
					<label> Số điện thoại khách hàng:</label>
					<input class="form-control" name="customer_phone" type="text"
						   value="<?= $log_contract_thn->customer_phone_number ? $log_contract_thn->customer_phone_number : $contractInfor->customer_infor->customer_phone_number ?>">
				</div>
				<div class="form-group">
					<label>Địa chỉ khách hàng:</label>
					<input class="form-control" name="address"
						   value="<?= (!empty($address_log) ? $address_log : $address) ?>">
					</input>
					<hr>
				</div>
				<div class="form-group">
					<label> Tên người tham chiếu 1: </label>
					<strong><?php echo $contractDB->relative_infor->fullname_relative_1 ?></strong>
				</div>
				<div class="form-group">
					<label> Mối quan hệ: </label>
					<strong><?php echo $contractDB->relative_infor->type_relative_1 ?></strong>
				</div>
				<div class="form-group">
					<label> SĐT:</label>
					<input class="form-control" name="phone_1" type="text"
						   value="<?= $log_contract_thn->phone_number_relative_1 ? $log_contract_thn->phone_number_relative_1 : $contractInfor->relative_infor->phone_number_relative_1 ?>">
				</div>
				<div class="form-group">
					<label>Địa chỉ:</label>
					<input class="form-control" name="address_1" type="text"
						   value="<?= $log_contract_thn->hoursehold_relative_1 ? $log_contract_thn->hoursehold_relative_1 : $contractInfor->relative_infor->hoursehold_relative_1 ?>">
				</div>
				<hr>
				<div class="form-group">
					<label> Tên người tham chiếu 2: </label>
					<strong><?php echo $contractDB->relative_infor->fullname_relative_2 ?></strong>
				</div>
				<div class="form-group">
					<label> Mối quan hệ: </label>
					<strong><?php echo $contractDB->relative_infor->type_relative_2 ?></strong>
				</div>
				<div class="form-group">
					<label> SĐT:</label>
					<input class="form-control" name="phone_2" type="text"
						   value="<?= $log_contract_thn->phone_number_relative_2 ? $log_contract_thn->phone_number_relative_2 : $contractInfor->relative_infor->phone_number_relative_2 ?>">
				</div>
				<div class="form-group">
					<label> Địa chỉ:</label>
					<input class="form-control" name="address_2" type="text"
						   value="<?= $log_contract_thn->hoursehold_relative_2 ? $log_contract_thn->hoursehold_relative_2 : $contractInfor->relative_infor->hoursehold_relative_2 ?>">

				</div>


				<p class="text-right">
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
					<button type="button" id="update_info" class="btn btn-primary" name="btn-update">Cập nhật</button>
				</p>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/accountant/renewal.js"></script>
<script src="<?php echo base_url(); ?>assets/js/accountant/detail.js"></script>
<script src="<?php echo base_url(); ?>assets/js/accountant/payment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/examptions/index.js"></script>

<div id="listentoRecord" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Nghe ghi âm</h4>
			</div>

			<div class="modal-body">
				<audio controls class="w-100" id="player">

					<source src="" type="audio/mp3" id="audio">

				</audio>
			</div>
			<div class="modal-footer">
				<!--     <button type="button" class="btn btn-default" >
							  <i class="fa fa-download"></i> Download
							</button> -->
				<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>

			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="editFee" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve">Xem phí thực tính</h5>
				<hr>
				<div class="form-group row">
					<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
						Coupon <span class="text-danger">*</span>
					</label>
					<div class="col-lg-6 col-sm-12 col-12">
						<input type="text" class="form-control code_coupon" value="" disabled>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control contract_id_fee">
					<input type="hidden" class="form-control" id="number_day_loan">
					<div class="row">
						<div class="col-lg-6">
							<label>Lãi suất phải thu của người vay:</label>
							<input type="text" class="form-control percent_interest_customer" value="" disabled>

							<label>Phí tư vấn quản lý:</label>
							<input type="text" class="form-control percent_advisory" value="" disabled>

							<label>Phí thẩm định và lưu trữ tài sản đảm bảo:</label>
							<input type="text" class="form-control percent_expertise" value="" disabled>

							<label>Phần trăm phí quản lý số tiền vay chậm trả:</label>
							<input type="text" class="form-control penalty_percent" value="" disabled>
							<label>Số tiền quản lý số tiền vay chậm trả:</label>
							<input type="text" class="form-control penalty_amount" value="" disabled>
						</div>
						<div class="col-lg-6">
							<label>Phí tư vấn gia hạn:</label>
							<input type="text" class="form-control extend" value="" disabled>

							<label>Phí tất toán(trước 1/3):</label>
							<input type="text" class="form-control percent_prepay_phase_1" value="" disabled>

							<label>Phí tất toán(trước 2/3):</label>
							<input type="text" class="form-control percent_prepay_phase_2" value="" disabled>

							<label>Phí tất toán(sau 2/3):</label>
							<input type="text" class="form-control percent_prepay_phase_3" value="" disabled>
							<label>% phí tư vấn gia hạn từ 6 tháng trở lên:</label>
							<input type="text" class="form-control extend_new_five" value="" disabled>
							<label>% phí tư vấn gia hạn 6 tháng trở xuống:</label>
							<input type="text" class="form-control extend_new_three" value="" disabled>
						</div>
					</div>
					<!-- <label>Ghi chú:</label>
					<textarea class="form-control fee_note" rows="5" ></textarea>
				   -->
				</div>
				</table>
				<p class="text-right">
					<!--   <button class="btn btn-danger submit_edit_fee">Xác nhận</button> -->
				</p>
			</div>

		</div>
	</div>
</div>

