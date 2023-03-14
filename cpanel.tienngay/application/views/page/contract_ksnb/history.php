<div class="right_col" role="main">
	<div class="row top_tiles">
		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>LỊCH SỬ DANH SÁCH PHIẾU THU HỢP ĐỒNG</h3>
				</div>
			</div>
		</div>

		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">

				</div>

				<div class="x_content">
					<ul class="list-unstyled timeline workflow widget">
						<?php if (!empty($content)): ?>
						<?php foreach ($content as $key => $value): ?>
						<li>
							<img class="theavatar"
								 src="<?php echo base_url("assets/imgs/avatar_none.png") ?>"
								 alt="">
							<div class="block">
								<div class="block_content">
									<h2 class="title">
										<a><?= !empty($value->action) ? $value->action : ""; ?></a>
									</h2>
									<div class="byline">
										<p>
											<strong><?php echo !empty($value->created_at) ? date('d/m/Y H:i:s',$value->created_at) : "" ?></strong>
										</p>
										<p>By:
											<a><?php echo !empty($value->created_by) ? ($value->created_by) : '' ?></a>
										</p>

									</div>
									<div class="excerpt">
										<?php
										$old_status = check_status($value->old->status);
										$new_status = check_status($value->new->status);
										$old_status = is_array($old_status) ? '' : $old_status;
										if ($new_status != ""){
											$new_status = is_array($new_status) ? '' : ' => ' . $new_status;

										}
										$status_detail = $old_status . $new_status;
										?>
										<p>
											<?= $status_detail ?>
										</p>

									</div>
								</div>
							</div>
						</li>
						<?php endforeach; ?>
						<?php endif; ?>

					</ul>
				</div>

			</div>
		</div>

	</div>
</div>


<?php
function check_status($item){
	$result = "";
	if ($item == 1){
		$result = "Đã duyệt";
	} elseif ($item == 2){
		$result = "Chờ xác nhận";
	} elseif ($item == 3){
		$result = "Hủy";
	} elseif ($item == 4){
		$result = "Chưa gửi duyệt";
	} elseif ($item == 5){
		$result = "Chờ chuyển tiền về công ty";
	} elseif ($item == 11){
		$result = "Trả về";
	}
	return $result;

}
?>

