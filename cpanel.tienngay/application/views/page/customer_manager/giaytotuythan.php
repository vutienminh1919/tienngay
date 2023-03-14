<style>
	.font-16 {
		font-style: normal;
		font-weight: 540;
		font-size: 18px;
		line-height: 20px;

	}

	.font-14 {
		font-size: 16px;
		padding-bottom: 5px;
	}

	.text-blue {
		color: #5A738E;
	}

	.text-gray {
		color: #828282;
	}

	.font-weight-600 {
		font-weight: 600;
	}

	.mb-30 {
		margin-bottom: 30px;
	}

	.mb-3 {
		margin-bottom: 10px;
		width: 378px;
		height: 50px;
		top: 402px;
		left: 271px;
		border-radius: 5px;
		background-color: #D5EBF8;
		border: none;

		font-weight: 550;
		color: #5a738e;

	}
</style>
<div class="right_col" role="main">

	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>
					<a href="<?= base_url("customer_manager/index_customer_manager") ?>" >Quản lý khách hàng</a> / <?= !empty($customer_code) ? $customer_code : "" ?>
					<br>
				</h3>
			</div>


			<div class="title_right text-right">
				<div class="btn-group">
					<button type="button" class="btn btn-info">Chức năng</button>
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
							aria-expanded="false">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">

						<li>
							<a href="<?php echo base_url("customer_manager/detail_edit?id=") . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>"
							   class="dropdown-item">
								Cập nhật CCCD
							</a>
						</li>
						<li>
							<a onclick="call_for_customer('<?= !empty($contract->customer_infor->customer_phone_number) ? encrypt($contract->customer_infor->customer_phone_number) : "" ?>' , '<?= !empty($contract->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>', 'customer')"
							   class="call_for_customer">Gọi điện</a>
						</li>

					</ul>
				</div>
			</div>

		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">

			<div class="x_content">
				<div class="row">
					<div class="col-md-3">
						<div class="text-center" style="margin-bottom: 45px;">
							<img
								src="https://service.egate.global/uploads/avatar/1624962474-aa91be45af455f8eb58eb995f3a1d8e4.png"
								class="img-circle">
						</div>
						<a class="btn btn-default btn-lg w-100 text-uppercase " type="button"
						   style="border: none; background-color: #F2F2F2; margin-bottom: 10px;"
						   href="<?= base_url('customer_manager/detail?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>">Thông
							tin chính
						</a>
						<a class="btn btn-default btn-lg w-100 text-uppercase " type="button"
						   style="border: none; background-color: #F2F2F2; margin-bottom: 10px;"
						   href="<?= base_url('customer_manager/detail_tthd?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>">Thông
							tin hợp đồng
						</a>
						<a class="btn btn-default btn-lg w-100 text-uppercase mb-3" type="submit"
						   href="<?= base_url('customer_manager/detail_giaytotuythan?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>"
						>Giấy tờ tùy thân
						</a>
					</div>
					<div class="col-md-9">

						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600"><a target="_blank" href="<?php echo base_url("pawn/viewImageAccuracy?id=") . $contract->_id->{'$oid'} ?>">Giấy tờ tùy thân</a></div>
						<hr class="mt-1">
						<div class="row">

							<div id="SomeThing" class="simpleUploader">
								<div class="uploads " id="uploads_identify">
									<?php if (!empty($contract->customer_infor->img_id_front)): ?>
										<div class="block">
											<!--//Image-->
											<span
												class="timestamp"><?php echo date('d/m/Y H:i:s', basename($contract->created_at)) ?></span>
											<a href="<?= $contract->customer_infor->img_id_front ?>"
											   class="magnifyitem" data-magnify="gallery" data-src=""
											   data-group="thegallery"
											   data-caption="Hồ sơ nhân thân">
												<img class="w-100" src="<?= $contract->customer_infor->img_id_front ?>"
													 alt="">
											</a>
										</div>
									<?php endif; ?>

									<?php if (!empty($contract->customer_infor->img_id_back)): ?>

										<div class="block">
											<!--//Image-->
											<span
												class="timestamp"><?php echo date('d/m/Y H:i:s', basename($contract->created_at)) ?></span>
											<a href="<?= $contract->customer_infor->img_id_back ?>"
											   class="magnifyitem" data-magnify="gallery" data-src=""
											   data-group="thegallery"
											   data-caption="Hồ sơ nhân thân">
												<img class="w-100" src="<?= $contract->customer_infor->img_id_back ?>"
													 alt="">
											</a>
										</div>

									<?php endif; ?>

									<?php if (!empty($image)): ?>
										<?php foreach ($image as $value): ?>

											<div class="block">
												<!--//Image-->
												<span
													class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->new->updated_at)) ?></span>
												<a href="<?= $value->new->img_id_front ?>"
												   class="magnifyitem" data-magnify="gallery" data-src=""
												   data-group="thegallery"
												   data-caption="Hồ sơ nhân thân">
													<img class="w-100" src="<?= $value->new->img_id_front ?>"
														 alt="">
												</a>
											</div>
											<div class="block">
												<!--//Image-->
												<span
													class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->new->updated_at)) ?></span>
												<a href="<?= $value->new->img_id_back ?>"
												   class="magnifyitem" data-magnify="gallery" data-src=""
												   data-group="thegallery"
												   data-caption="Hồ sơ nhân thân">
													<img class="w-100" src="<?= $value->new->img_id_back ?>"
														 alt="">
												</a>
											</div>

										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>

						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<?php
function hide_phone_customer($phone, $role = "")
{
	$result = str_replace(substr($phone, 4, 4), stars($phone), $phone);
	if ($role != "") {
		return $phone;
	} else {
		return $result;
	}

}

?>
<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title title_modal_approve text-center"></h3>
				<hr>
				<div style="text-align: center; font-size: 18px">
					<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
					<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
					<input id="number" name="phone_number" type="hidden" value=""/>
					<p id="status" style="margin-left: 125px;"></p>
				</div>

				<div class="form-group">
					<input type="text" value="<?php echo $this->input->get('id') ?>" class="hidden"
						   class="form-control " id="contract_id">
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	function call_for_customer(phone_number, contract_id, type) {
		console.log(phone_number);
		if (phone_number == undefined || phone_number == '') {
			alert("Không có số");
		} else {
			if (type == "customer") {
				$(".title_modal_approve").text("Gọi cho khách hàng");
			}
			if (type == "rel1") {
				$(".title_modal_approve").text("Gọi cho tham chiếu 1");
			}
			if (type == "rel2") {
				$(".title_modal_approve").text("Gọi cho tham chiếu 2");
			}
			$("#number").val(phone_number);
			$(".contract_id").val(contract_id);
			$("#approve_call").modal("show");
		}
	}
</script>
