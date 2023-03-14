<!-- top navigation -->
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>

			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="javascript:;" class="info-number" id="a_call" title="Điện thoại chưa sẵn sàng"
					   onclick="$('#theCall').toggleClass('d-none')">
						<i class="fa fa-phone" id="icon_call"></i>
						<span class="badge bg-red" id="span_call">0</span>
					</a>
				</li>
				<li class="">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<?php if ($this->session->language === 'english') { ?>
							<img width="14" src="<?php echo base_url(); ?>assets/imgs/icon/lang_EN.png" alt=""> EN
						<?php } else { ?>
							<img width="14" src="<?php echo base_url(); ?>assets/imgs/icon/lang_VI.png" alt=""> VN
						<?php } ?>
						<span class="fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-langmenu pull-right">
						<li><a onclick="updateLanguage('VN', '<?php echo $this->session->language ?>')"> <img width="14"
																											  src="<?php echo base_url(); ?>assets/imgs/icon/lang_VI.png"
																											  alt=""> VN</a>
						</li>
						<li><a onclick="updateLanguage('EN', '<?php echo $this->session->language ?>')"> <img width="14"
																											  src="<?php echo base_url(); ?>assets/imgs/icon/lang_EN.png"
																											  alt=""> EN</a>
						</li>
					</ul>
				</li>

				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
					   aria-expanded="false">
						<!-- <img src="https://s3-us-west-2.amazonaws.com/lightstalking-assets/wp-content/uploads/2010/02/15233618/square.jpg" alt=""> -->
						<img src="<?php echo !empty($avatar) ? $avatar : base_url() . 'assets/imgs/avatar_none.png' ?>"
							 alt="..." class="">
						<?= !empty($userSession['full_name']) ? " " . $userSession['full_name'] : "" ?>
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
						<li><a href="<?php echo base_url('account/profile') ?>"> Profile</a></li>
						<!-- <li>
						  <a href="javascript:;">
							<span class="badge bg-red pull-right">50%</span>
							<span>Settings</span>
						  </a>
						</li>
						<li><a href="javascript:;">Help</a></li> -->
						<li><a href="<?php echo base_url("auth/logout") ?>"><i
										class="fa fa-sign-out pull-right"></i> <?= $this->lang->line('log_out') ?></a>
						</li>
					</ul>
				</li>

				<li role="presentation" class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle info-number" data-toggle="dropdown"
					   aria-expanded="false">
						<i class="fa fa-bell-o"></i>
						<span class="badge bg-red count_notify_user"><?= $count_notify ? $count_notify : 0 ?></span>
						<input type="hidden" class="" name="count_notify"
							   value="<?= $count_notify ? $count_notify : 0 ?>"/>
					</a>
					<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
						<?php
						if (!empty($user_notifications)) {
							foreach ($user_notifications as $key => $no) {
								?>

								<?php if (!empty($no->data_hs)): ?>
									<?php
									$customer_name_hs = $no->data_hs[count($no->data_hs) - 1]->user->email;
									$check_customer_hs = $no->data_hs[count($no->data_hs) - 1]->check;
									?>
								<?php endif; ?>


								<?php if (isset($groupRoles) && is_array($groupRoles)) {
									if (($customer_name_hs == "") && ($groupRoles[0] == "5def671dd6612b75532960c5" || $groupRoles[0] == "hoi-so")) { ?>

										<input id="id_update" style="display: none" value="<?php echo $no->id ?>">
										<li data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"
											data-id="<?php echo $no->action_id ?>" onclick="hoi_so_bat_dau_duyet1(this)"
											class="<?php echo $no->status == 1 ? 'unread' : '' ?>">
											<a>
												<strong>
													<?= $no->title ?>
												</strong>
												<span class="message">
                <?= $no->note ?>
              </span>
												<span class=""><?= $no->date ?></span>
											</a>
										</li>
									<?php } elseif (($customer_name_hs == $userSession['email']) && ($groupRoles[0] == "5def671dd6612b75532960c5" || $groupRoles[0] == "hoi-so")) { ?>

										<input id="id_update" style="display: none" value="<?php echo $no->id ?>">
										<li data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"
											data-id="<?php echo $no->action_id ?>" onclick="hoi_so_bat_dau_duyet1(this)"
											class="<?php echo $no->status == 1 ? 'unread' : '' ?>">
											<a>
												<strong>
													<?= $no->title ?>
												</strong>
												<span class="message">
                <?= $no->note ?>
              </span>
												<span class=""><?= $no->date ?></span>
											</a>
										</li>
									<?php } elseif (($check_customer_hs == 2) && ($groupRoles[0] == "5def671dd6612b75532960c5" || $groupRoles[0] == "hoi-so")) { ?>

										<input id="id_update" style="display: none" value="<?php echo $no->id ?>">
										<li data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"
											data-id="<?php echo $no->action_id ?>" onclick="hoi_so_bat_dau_duyet1(this)"
											class="<?php echo $no->status == 1 ? 'unread' : '' ?>">
											<a>
												<strong>
													<?= $no->title ?>
												</strong>
												<span class="message">
                <?= $no->note ?>
              </span>
												<span class=""><?= $no->date ?></span>
											</a>
										</li>

									<?php } elseif (($customer_name_hs == "") && ($groupRoles[0] == "5def671dd6612b75532960c5" || $groupRoles[0] == "hoi-so")) { ?>

										<input id="id_update" style="display: none" value="<?php echo $no->id ?>">
										<li data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"
											data-id="<?php echo $no->action_id ?>" onclick="hoi_so_bat_dau_duyet1(this)"
											class="<?php echo $no->status == 1 ? 'unread' : '' ?>">
											<a>
												<strong>
													<?= $no->title ?>
												</strong>
												<span class="message">
                <?= $no->note ?>
              </span>
												<span class=""><?= $no->date ?></span>
											</a>
										</li>

									<?php } elseif (($customer_name_hs == $userSession['email']) && ($groupRoles[0] == "5def671dd6612b75532960c5" || $groupRoles[0] == "hoi-so")) { ?>

										<input id="id_update" style="display: none" value="<?php echo $no->id ?>">
										<li data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"
											data-id="<?php echo $no->action_id ?>" onclick="hoi_so_bat_dau_duyet1(this)"
											class="<?php echo $no->status == 1 ? 'unread' : '' ?>">
											<a>
												<strong>
													<?= $no->title ?>
												</strong>
												<span class="message">
                <?= $no->note ?>
              </span>
												<span class=""><?= $no->date ?></span>
											</a>
										</li>
									<?php } elseif (($check_customer_hs == 2) && ($groupRoles[0] == "5def671dd6612b75532960c5" || $groupRoles[0] == "hoi-so")) { ?>

										<input id="id_update" style="display: none" value="<?php echo $no->id ?>">
										<li data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"
											data-id="<?php echo $no->action_id ?>" onclick="hoi_so_bat_dau_duyet1(this)"
											class="<?php echo $no->status == 1 ? 'unread' : '' ?>">
											<a>
												<strong>
													<?= $no->title ?>
												</strong>
												<span class="message">
                <?= $no->note ?>
              </span>
												<span class=""><?= $no->date ?></span>
											</a>
										</li>

									<?php } else { ?>

										<li onclick="updateNotification('<?php echo $no->id ?>')"
											class="<?php echo $no->status == 1 ? 'unread' : '' ?>">
											<a href="<?php echo !empty($no->detail) ? base_url($no->detail) : '' ?>">
												<strong>
													<?= $no->title ?>
												</strong>
												<span class="message">
                <?= $no->note ?>
              </span>
												<span class=""><?= $no->date ?></span>
											</a>
										</li>

									<?php }
								} ?>

								<?php
							} ?>
							<li>
								<div class="text-center">
									<a href="<?php echo base_url('account/all') ?>">
										<strong>Xem toàn bộ thông báo</strong>
										<i class="fa fa-angle-right"></i>
									</a>
								</div>
							</li>
						<?php } else { ?>
							<li class="no_notify">
								<div class="text-center">
									<a href="javascript:void(0)">
										<strong>Bạn không có thông báo nào</strong>
										<i class="fa fa-angle-right"></i>
									</a>
								</div>
							</li>
						<?php } ?>
					</ul>
				</li>

				<li class="">
					<a href="<?php echo base_url('VimoBilling/listCart') ?>">
						<i class=" fa fa-shopping-cart "></i>
						<!-- &nbsp;  -->
						<span class='total_items'><?php echo $this->cart->total_items(); ?></span>
						<?= $this->lang->line('cart') ?>
					</a>
				</li>
				<!--				--><?php
				//				// check accessright của vận hành theo trạng thái
				//				if (in_array('giao-dich-vien', $groupRoles_s) || in_array('cua-hang-truong', $groupRoles_s) || in_array('quan-ly-khu-vuc', $groupRoles_s) || in_array('quan-ly-ho-so', $groupRoles_s)) {
				//				?>


				<li role="presentation" class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle info-number" data-toggle="dropdown"
					   aria-expanded="false">
						<i class="fa fa-paper-plane-o"></i>
						<span class="badge bg-red count_notify_user"><?= $count_notify_borrowed ? $count_notify_borrowed : 0 ?></span>
						<input type="hidden" class="" name="count_notify"
							   value="<?= $count_notify_borrowed ? $count_notify_borrowed : 0 ?>"/>
					</a>
					<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
						<?php
						if (!empty($user_notifications_borrowed)) {
							foreach ($user_notifications_borrowed as $key => $no) {
								?>

								<?php if (!empty($no->borrowed_status) && $no->status == 1) { ?>
									<li onclick="updateNotification_borrowed('<?php echo $no->id ?>')"
										class="<?php echo $no->status == 1 ? 'unread' : '' ?>" style="cursor:pointer;">
										<a href="<?php echo !empty($no->action_id) ? base_url("file_manager/detail_borrowed?id=". $no->action_id) : '' ?>">
										<span>
											Người gửi: <?= $no->created_by ?>
										</span>
										<br>
										<span class="message">
               						 <?= $no->note ?>
              						</span>
										<span class=""><?= date("d/m/y H:i:s", $no->created_at) ?></span>
										</a>
									</li>
								<?php } ?>
								<?php if (!empty($no->fileReturn_status) && $no->status == 1) { ?>
									<li onclick="updateNotification_fileReturn('<?php echo $no->id ?>')"
										class="<?php echo $no->status == 1 ? 'unread' : '' ?>" style="cursor:pointer;">
										<a href="<?php echo !empty($no->action_id) ? base_url("file_manager/detail?id=". $no->action_id) : '' ?>">
										<span>
											Người gửi: <?= $no->created_by ?>
										</span>
										<br>
										<span class="message">
               						 <?= $no->note ?>
              						</span>
										<span class=""><?= date("d/m/y H:i:s", $no->created_at) ?></span>
										</a>
									</li>
								<?php } ?>
								<?php if(!empty($no->borrowed_status) && $no->status == 2) { ?>
									<li onclick="updateNotification_borrowed('<?php echo $no->id ?>')"
										class="<?php echo $no->status == 1 ? 'unread' : '' ?>" style="cursor:pointer;">
										<a href="<?php echo !empty($no->action_id) ? base_url("file_manager/detail_borrowed?id=". $no->action_id) : '' ?>">
										<span>
											Người gửi: <?= $no->created_by ?>
										</span>
											<br>
											<span class="message">
               						 <?= $no->note ?>
              						</span>
											<span class=""><?= date("d/m/y H:i:s", $no->created_at) ?></span>
										</a>
									</li>
								<?php } ?>
								<?php if (!empty($no->fileReturn_status) && $no->status == 2){ ?>
									<li onclick="updateNotification_fileReturn('<?php echo $no->id ?>')"
								class="<?php echo $no->status == 1 ? 'unread' : '' ?>" style="cursor:pointer;">
								<a href="<?php echo !empty($no->action_id) ? base_url("file_manager/detail?id=". $no->action_id) : '' ?>">
										<span>
											Người gửi: <?= $no->created_by ?>
										</span>
									<br>
									<span class="message">
               						 <?= $no->note ?>
              						</span>
									<span class=""><?= date("d/m/y H:i:s", $no->created_at) ?></span>
								</a>
								</li>
							<?php } ?>

						<?php } ?>
							<li>
								<div class="text-center">
									<a href="<?php echo base_url('file_manager/all') ?>">
										<strong>Xem toàn bộ thông báo</strong>
										<i class="fa fa-angle-right"></i>
									</a>
								</div>
							</li>
						<?php } ?>
					</ul>
				</li>
				<!--				--><?php //} ?>


			</ul>
		</nav>

		<?php
		$arr = [];
		$arr_role = [];
		$count = [];
		$count_gallery_header = 0;

		foreach ($groupRoles_header as $item) {
			if (!empty($item->users) && $item->status == "active") {
				foreach ($item->users as $key => $value) {
					foreach ($value as $k => $a) {
						if ($a->email == $userSession['email']) {
							$check_view_header = $item->name;
						}
					}
				}
			}
		}
		$header_ressult = [];
		$count_header = 0;
		if (!empty($header)) {
			foreach ($header as $key => $value) {
				if ((!in_array($check_view_header, $value->selectize_role_value[0])) && (!in_array("all", $value->selectize_role_value[0]))) {
					continue;
				}
				if (!empty($value->selectize_area_value[0])) {
					if (($check_view_header == "Giao dịch viên" && !in_array($return_header[0], $value->selectize_area_value[0]))) {
						continue;
					}
				}

				$count_header++;
				array_push($header_ressult, $value);
				if ($count_header == 20) {
					break;
				}
			}
		}

		?>
		<div class="col-xs-12">
			<div class="marquee">

				<?php if (!empty($header_ressult)): ?>
					<?php foreach ($header_ressult as $key => $item): ?>
						<div class="item">
							<a href="#" data-toggle="modal"
							   data-target="#thongbaoModal_<?php echo $key ?>">
								<?php echo $item->title ?>
							</a>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

			</div>
		</div>

	</div>
</div>
<script src="//cdn.jsdelivr.net/npm/jquery.marquee@1.6.0/jquery.marquee.min.js" type="text/javascript"></script>
<script>

	$('.marquee').marquee({
		//duration in milliseconds of the marquee
		duration: 30000,
		//gap in pixels between the tickers
		gap: 1920,
		//time in milliseconds before the marquee will start animating
		delayBeforeStart: 0,
		//'left' or 'right'
		direction: 'left',
		//true or false - should the marquee be duplicated to show an effect of continues flow
		duplicated: true,
		pauseOnHover: true

	});
</script>
<?php if (!empty($header_ressult)): ?>
	<?php foreach ($header_ressult as $key => $value): ?>


		<div id="thongbaoModal_<?php echo $key ?>" class="modal" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" id="close_load" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><a style="font-weight: bold">THÔNG BÁO:</a> <?php echo $value->title ?>
						</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<p>
									<a style="font-weight: bold">Người ban hành:</a> <?php echo $value->created_by ?>
								</p>
							</div>
							<!--							<div class="col-xs-12">-->
							<!--								<p>-->
							<!--									<a style="font-weight: bold">Ngày bắt đầu:</a> --><?php //echo date("d/m/Y", $value->start_date) ?>
							<!--								</p>-->
							<!--							</div>-->
							<!--							--><?php //if (!empty($value->end_date)){ ?>
							<!--							<div class="col-xs-12 col-md-6">-->
							<!--								<p>-->
							<!--									<a style="font-weight: bold">Ngày kết thúc:</a> --><?php //echo date("d/m/Y", $value->end_date) ?>
							<!--								</p>-->
							<!--							</div>-->
							<!--							--><?php //} ?>
							<div class="col-xs-12">
								<p>
									<a style="font-weight: bold">Nội dung:</a> <br>
									<?php echo $value->content ?>
								</p>
							</div>
							<?php if (!empty($value->image_accurecy->identify)) { ?>
								<div class="col-xs-12">
									<br>
									<div class="row">
										<div id="" class="simpleUploader">
											<div class="uploads " id="">
												<?php
												foreach ((array)$value->image_accurecy->identify as $key1 => $image) { ?>

													<div class="block">
														<!--//Image-->
														<?php if ($image->file_type == 'image/png' || $image->file_type == 'image/jpg' || $image->file_type == 'image/jpeg') { ?>
															<a href="<?= $image->path ?>"
															   class="magnifyitem"
															   data-magnify="gallery<?php echo $count_gallery_header ?>"
															   data-src=""
															   data-group="thegallery<?php echo $count_gallery_header ?>"
															   data-toggle="lightbox"
															   data-gallery="uploads_identify<?php echo $count_gallery_header ?>"
															   data-max-width="992"
															   data-type="image"
															   data-title="Thông báo">
																<img name=""
																	 data-key="<?= $key1 ?>"
																	 data-fileName="<?= $image->file_name ?>"
																	 data-fileType="<?= $image->file_type ?>"
																	 data-type='identify'
																	 class="w-100"
																	 src="<?= $image->path ?>"
																	 alt="">
															</a>
														<?php } ?>
														<!--Audio-->
														<?php if ($image->file_type == 'audio/mp3' || $image->file_type == 'audio/mpeg') { ?>
															<a href="<?= $image->path ?>"
															   target="_blank"><span
																		style="z-index: 9"><?= $image->file_name ?></span>
																<img name=""
																	 style="width: 50%;transform: translateX(50%)translateY(-50%);"
																	 src="https://image.flaticon.com/icons/png/512/81/81281.png"
																	 alt="">
																<img name=""
																	 data-key="<?= $key1 ?>"
																	 data-fileName="<?= $image->file_name ?>"
																	 data-fileType="<?= $image->file_type ?>"
																	 data-type='identify'
																	 class="w-100"
																	 src="<?= $image->path ?>"
																	 alt="">
															</a>
														<?php } ?>
														<!--Video-->
														<?php if ($image->file_type == 'video/mp4') { ?>
															<a href="<?= $image->path ?>"
															   target="_blank"><span
																		style="z-index: 9"><?= $image->file_name ?></span>
																<img name=""
																	 style="width: 50%;transform: translateX(50%)translateY(-50%);"
																	 src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																	 alt="">
																<img name=""
																	 data-key="<?= $key1 ?>"
																	 data-fileName="<?= $image->file_name ?>"
																	 data-fileType="<?= $image->file_type ?>"
																	 data-type='identify'
																	 class="w-100"
																	 src="<?= $image->path ?>"
																	 alt="">
															</a>
														<?php } ?>

													</div>
												<?php } ?>
												<?php $count_gallery_header++ ?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>

					</div>
					<div class="modal-footer">
						<?php if ($key > 0): ?>

							<button type="button" class="btn btn-default"
									data-dismiss="modal"
									data-toggle="modal" data-target="#thongbaoModal_<?php echo $key - 1 ?>"
									style="float:left">Trước
							</button>

						<?php endif; ?>
						&nbsp;
						<?php if ($key < count($header_ressult) - 1): ?>
							<button type="button" class="btn btn-default"
									data-dismiss="modal"
									data-toggle="modal" data-target="#thongbaoModal_<?php echo $key + 1 ?>"
							>Sau
							</button>
						<?php endif; ?>
					</div>
				</div>

			</div>
		</div>

	<?php endforeach; ?>
<?php endif; ?>


<!-- /top navigation -->
<!-- Top modals -->
<!-- Edit Profile  -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Thay đổi thông tin cá nhân</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Họ & tên <span
									class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Số điện thoại <span
									class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email <span
									class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="email" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tỉnh / thành phố <span
									class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<select class="form-control">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Quận / huyện <span
									class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<select class="form-control">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu lại</button>
							<button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Hủy</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Change Passwords -->
<div class="modal fade" id="editPasswordsModal" tabindex="-1" role="dialog" aria-labelledby="editPasswordsModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Thay đổi mật khẩu</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mật khẩu hiện tại
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="password" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mật khẩu mới <span
									class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="password" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nhập lại mật khẩu
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="password" class="form-control">
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu lại</button>
							<button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Hủy</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="checkmodal1" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Bạn có chắc chắn xử lý hợp đồng này?</h3>
			</div>
			<div class="modal-body ">
				<input type="hidden" value="" name="_id"/>
				<div class="row">
					<div class="col-xs-12">
						<input id="check_app_hs1" style="display: none">
						<div style="text-align: center">
							<div class="form-group">
								<label class="control-label col-md-3">Người xử lý:</label>
								<div class="col-md-9">
									<input id="check_contract_name1" class="form-control"
										   type="text" disabled>
									<span class="help-block"></span>
								</div>
							</div>
							<button type="button" id="customer_hs1" class="btn btn-info">Đồng ý</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<!-- Small modal -->

<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<script src="<?php echo base_url("assets/js"); ?>/socket.io-client/dist/socket.io.js"></script>

<!--<link href="--><?php //echo base_url(); ?><!--assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">-->
<!--<script src="--><?php //echo base_url(); ?><!--assets/teacupplugin/magnify/js/jquery.magnify.js"></script>-->

<script type="text/javascript">

	var socket = io('<?php echo $this->config->item('IP_SOCKET_SERVER')?>', {transports: ['websocket']});
	var user_id = '<?php echo $this->session->user['id']?>';
	console.log('user_id', user_id);
	let count_notify = $('input[name="count_notify"]').val();
	if (!count_notify || count_notify == undefined) {
		count_notify = 0;
	} else {
		count_notify = parseInt(count_notify);
	}
	socket.on('notify_approve', function (data) {
		console.log(data.res);
		if (data.res) {
			let users = data.res['users'];
			if (users.indexOf(user_id) !== -1) {
				count_notify = count_notify + 1;
				$('.count_notify_user').html(count_notify);
				$('input[name="count_notify"]').val(count_notify);
				let html = '<li class="unread">\n' +
						'              <a href="/' + data.res.detail + '">\n' +
						'                <span>\n' +
						'                  <span>' + data.res.title + '</span>\n' +
						'                  <span class="time">1 phút trước</span>\n' +
						'                </span>\n' +
						'                <span class="message">\n' + data.res.note +
						'                </span>\n' +
						'              </a>\n' +
						'            </li>';
				$('#menu1').prepend(html);
			}
		}
	});
	socket.on('notify_status', function (data) {
		console.log(data.res);
		if (data.res) {
			let users_status = data.res['users'];
			if (users_status.indexOf(user_id) !== -1) {
				count_notify = count_notify + 1;
				$('.count_notify_user').html(count_notify);
				$('input[name="count_notify"]').val(count_notify);
				let html = '<li class="unread">\n' +
						'              <a href="/' + data.res.detail + '">\n' +
						'                <span>\n' +
						'                  <span>' + data.res.title + '</span>\n' +
						'                  <span class="time">1 phút trước</span>\n' +
						'                </span>\n' +
						'                <span class="message">\n' + data.res.note +
						'                </span>\n' +
						'              </a>\n' +
						'            </li>';
				$('#menu1').prepend(html);
			}
		}
	});

	function updateNotification(id) {
		var formData = {
			noti_id: id,
		};
		$.ajax({
			url: _url.base_url + "account/updateStatusNoti",
			type: "POST",
			data: formData,
			dataType: 'html',
			success: function (data) {
			},
			error: function (data) {
				console.log('data', data);
			}
		});
	}

	function updateNotification_borrowed(id) {
		var formData = {
			noti_id: id,
		};
		$.ajax({
			url: _url.base_url + "borrowed/updateStatusNoti",
			type: "POST",
			data: formData,
			dataType: 'html',
			success: function (data) {
				// window.location.href = _url.base_url + 'borrowed/index_borrowed';
			},
			error: function (data) {
				console.log('data', data);
			}
		});
	}

	function updateNotification_fileReturn(id) {
		var formData = {
			noti_id: id,
		};
		$.ajax({
			url: _url.base_url + "borrowed/updateStatusNoti",
			type: "POST",
			data: formData,
			dataType: 'html',
			success: function (data) {
				console.log(data)
				// window.location.href = _url.base_url + 'file_manager/detail?id=' + data.data.action_id;
			},
			error: function (data) {
				console.log('data', data);
			}
		});
	}

	function updateNotification_sendFile(id){
		var formData = {
			noti_id: id,
		};
		$.ajax({
			url: _url.base_url + "borrowed/updateStatusNoti",
			type: "POST",
			data: formData,
			dataType: 'html',
			success: function (data) {
				// window.location.href = _url.base_url + 'borrowed/index_sendFile';
			},
			error: function (data) {
				console.log('data', data);
			}
		});

	}


	function hoi_so_bat_dau_duyet1(thiz) {
		let contract_id = $(thiz).data("id");
		let customes_app = $(thiz).data("value");
		console.log(customes_app)
		console.log(contract_id)
		$("#check_app_hs1").val(contract_id);
		$("#check_contract_name1").val(customes_app);
		$("#checkmodal1").modal("show");
	}

	$(document).ready(function () {
		$("#customer_hs1").click(function () {

			var id_oid = $('#check_app_hs1').val();
			var id_update = $('#id_update').val();
			console.log(id_update);
			var formData = new FormData();
			formData.append('id_oid', id_oid);

			$("#checkmodal1").modal("hide");

			function updateNotification(id) {
				var formData = {
					noti_id: id,
				};
				console.log(18);
				$.ajax({
					url: _url.base_url + "account/updateStatusNoti",
					type: "POST",
					data: formData,
					dataType: 'html',
					success: function (data) {
					},
					error: function (data) {
						console.log('data', data);
					}
				});
			}

			updateNotification(id_update);
			$.ajax({
				url: _url.base_url + 'lead_custom/insert_customer_hs_create_at',
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

					window.location.href = _url.base_url + 'pawn/detail?id=' + data.data.id_oid;
				},
				error: function (data) {
					console.log(data)
					$(".theloading").hide();
				}
			});
		});

		window.setInterval(function () {
			$.ajax({
				url: _url.base_url + 'lead_custom/getNotificationLead',
				method: "POST",
				dataType: "JSON",
				success: function (data) {
					if (data.data !== undefined) {
						var notify = data.data;
						$.each(notify, function (key, value) {

							if (value.action == "lead" && value.status == 1) {
								let notifi_store_name = value.store_name;
								let notifi_lead_name = value.lead_name;
								let notifi_lead_phone_number = value.lead_phone_number;
								let notifi_user_id = value.user_id;
								let notifi_date = value.created_at;
								let notifi_position = value.position;

								if ((user_id === notifi_user_id) && notifi_position !== "asm" && notifi_position == "cvkd") {
									$(function () {
										toastr.error(notifi_lead_name + ", SĐT: " + hide_phone_js(notifi_lead_phone_number), "Đã quá " + timeSince(notifi_date) + " PGD " + notifi_store_name + " chưa tiếp nhận xử lý lead inhouse", {
											timeOut: 10000,
											extendedTimeOut: 10000,
											progressBar: true,
											positionClass: "toast-bottom-right"
										});
									});
								}
							}
						});
					}
				},
				error: function (error) {
					console.log(error);
				}
			});
		}, 18000000);
	});



	function hide_phone_js(number, character = "*") {
		if (number !== undefined) {
			number = number.replace(/[^0-9]+/g, ''); /*ensureOnlyNumbers*/
			var length = number.length;
			return number.substring(0, 4) + character.repeat(length - 8) + number.substring(length - 4, length);
		}
	}

	function timeSince(date) {
		if (date !== undefined) {
			var seconds = Math.floor(((new Date().getTime() / 1000) - date)),
					interval = Math.floor(seconds / 31536000);

			if (interval > 1) return interval + " năm";

			interval = Math.floor(seconds / 2592000);
			if (interval > 1) return interval + " tháng";

			interval = Math.floor(seconds / 86400);
			if (interval >= 1) return interval + " ngày";

			interval = Math.floor(seconds / 3600);
			if (interval >= 1) return interval + " giờ";

			interval = Math.floor(seconds / 60);
			if (interval > 1) return interval + " phút";

			return Math.floor(seconds) + " giây";
		}
	}
</script>

<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css"
	  rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>

