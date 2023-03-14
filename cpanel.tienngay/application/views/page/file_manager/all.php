<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>
					Thông báo
					<br>
					<small>
						<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Trang chủ</a> / <a href="<?php echo base_url('file_manager/all')?>">Thông báo</a>
					</small>
				</h3>
			</div>
		</div>
	</div>
	<div>
		<nav class="text-right">
			<a class="btn btn-success"
			   onclick="read_all_notification(this)" data-tab="1">
				<i class="fa icon-ok"></i>
				Đọc tất cả
			</a>
		</nav>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<div class="table-responsive">
					<table  class="table table-striped">
						<thead>
						<tr>
							<th>Thời gian</th>
							<th>Thông báo</th>
							<th>Người tạo</th>
							<th>Link</th>
						</tr>
						</thead>
						<tbody>

						<?php
						if(!empty($notifications)){
							foreach($notifications as $key => $no){
								?>

								<tr class="<?php echo $no->status == 1 ? 'unread' : ''?>">
									<td><?= !empty($no->created_at) ? date("d/m/y H:i:s", $no->created_at) : "" ?></td>
									<td>
										<strong>
											<?= !empty($no->note) ? $no->note : "" ?>
										</strong>
									</td>
									<td> <?= $no->created_by?></td>
									<td>

										<?php if($no->status != 1 && !empty($no->fileReturn_status)) { ?>
											<a href="<?php echo base_url("file_manager/detail?id=". $no->action_id) ?>"><i class="fa fa-eye"></i> Xem</a>
										<?php } elseif(!empty($no->fileReturn_status) && $no->status == 1) { ?>
											<a onclick="updateNotification_fileReturn('<?php echo $no->_id->{'$oid'} ?>')" href="<?php echo base_url("file_manager/detail?id=". $no->action_id) ?>"><i class="fa fa-eye"></i> Xem</a>
										<?php } ?>

										<?php if($no->status != 1 && !empty($no->borrowed_status)) { ?>
											<a href="<?php echo base_url("file_manager/detail_borrowed?id=". $no->action_id) ?>"><i class="fa fa-eye"></i> Xem</a>
										<?php } elseif(!empty($no->borrowed_status) && $no->status == 1) { ?>
											<a onclick="updateNotification_borrowed('<?php echo $no->_id->{'$oid'} ?>')" href="<?php echo base_url("file_manager/detail_borrowed?id=". $no->action_id) ?>"><i class="fa fa-eye"></i> Xem</a>
										<?php } ?>
									</td>
								</tr>
								<?php
							}
						}?>
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
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>
<script type="text/javascript">
	function read_all_notification(t) {
		if (confirm('Bạn có chắc chắn không?')) {
			$.ajax({
				url: _url.base_url + "file_manager/updateAllStatusNoti",
				type: "POST",
				dataType: 'json',
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					console.log(data)
					if (data.status == 200) {
						$("#successModal").modal("show");
						$(".msg_success").text("Thành công");
						setTimeout(function () {
							window.location.href = _url.base_url + "file_manager/all";
						}, 2000);
					} else {
						//$("#approve_transaction").modal("hide");
						$("#errorModal").modal("show");
						$(".msg_error").text(data.message);
					}
				},
				error: function (data) {
					console.log('data')
				}
			});
		}
	}

</script>
