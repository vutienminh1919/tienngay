<div class="col-md-12 col-xs-12">
	<div class="x_panel">
		<div class="x_content">
			<div role="tabpanel" class="tab-pane col-md-12 col-xs-12 nopadding" id="tab_content3"
				 aria-labelledby="tab_content3">
				<div class="col-md-12 col-xs-12">
					<h4 class="box__title">LỊCH SỬ</h4>
				</div>
				<div class="col-md-12 col-xs-12 tab-content3">
					<ul class="list-unstyled timeline">
						<?php if (!empty($log_followContract)): ?>
						<?php foreach ($log_followContract as $item): ?>
								<li>
									<div class="block">
										<hr>
										<div class="tags">
											<a href="" class="tag">
												<span><?= !empty($item->created_at) ? date("d/m/y", $item->created_at) : "" ?></span>
											</a>
										</div>
										<div class="block_content col-md-12 col-xs-12">
											<div class="col-md-1 col-xs-12">
												<img
													src="<?php echo base_url(); ?>assets/imgs/icon/user-border.svg"
													alt="user approve">
											</div>
											<div class="col-md-10 col-xs-12">
												<p>
													<i
														style="color: #828282">Change Followers - <?= !empty($item->created_at) ? date("H:i:s", $item->created_at) : "" ?></i>
												</p>
												<p>
													<i><span
															style="color: #828282">by: <strong><?= !empty($item->created_by) ? $item->created_by : "" ?></strong></span>
													</i>
												</p>

												<p>
													<?php if (!empty($item->action)) {
														$old = $item->old;
														$new = 	$item->new->follow_contract;
														$old_status = is_array($old) ? '' : $old;
														$new_status = is_array($new) ? '' : ' => ' . $new;
														$status_detail = $old_status . $new_status;
													}
													?>
													<span class="work__status" style="background-color: #5a738e; padding: 6px; color: white">
																<?= ($status_detail != "") ? $status_detail : "Mới" ?>
																</span>
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
<style>
	hr{
		border: unset;
	}
	.block_content {
		margin-top: 30px;
	}
</style>
