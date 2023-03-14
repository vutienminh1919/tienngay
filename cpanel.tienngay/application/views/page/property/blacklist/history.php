<div class="col-xs-12 p-0">
			<div class="x_panel">
				<div class="x_title">

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<ul class="list-unstyled timeline workflow widget">
						<?php if (!empty($logs)) {
							foreach ($logs as $key => $wl) {

								?>
								<li>
									<img class="theavatar"
										 src="<?php echo base_url("assets/imgs/avatar_none.png") ?>"
										 alt="">
									<div class="block">
										<div class="block_content">
											<h2 class="title">
												<a><?= !empty($wl->type) ? history_blacklist_property($wl->type) : ""; ?></a>
											</h2>
											<div class="byline">
												<p>
													<strong><?php echo !empty($wl->created_at) ? date('d/m/Y H:i:s', $wl->created_at) : "" ?></strong>
												</p>
												<p>By:
													<a><?php echo !empty($wl->created_by) ? $wl->created_by : '' ?></a>
												</p>
											</div>
											<div class="excerpt">

												<p><?php echo (!empty($wl->data->note) && $wl->type == 'note') ?  $wl->data->note : '' ?></p>
												<p><?php echo (!empty($wl->data->description) && $wl->type == 'check_fake_property') ?  $wl->data->description : '' ?></p>
												<p><?php echo (!empty($wl->data->update_description) && $wl->type == 'request_update') ?  $wl->data->update_description : '' ?></p>
												<p><?php echo (!empty($wl->comment) && $wl->type == 'comment') ? $wl->comment : '' ?></p>
											</div>
										</div>
									</div>
								</li>
								<?php
							}
						} ?>
					</ul>
				</div>
			</div>
		</div>

