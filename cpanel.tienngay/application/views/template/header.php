<!-- top navigation -->
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<!--        <li class="">-->
				<!--          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">-->
				<!--            <img width="14" src="--><?php //echo base_url();?><!--assets/imgs/icon/lang_EN.png" alt=""> EN-->
				<!--            <span class="fa fa-angle-down"></span>-->
				<!--          </a>-->
				<!--          <ul class="dropdown-menu dropdown-langmenu pull-right">-->
				<!--            <li><a href="#"> <img width="14" src="--><?php //echo base_url();?><!--assets/imgs/icon/lang_VI.png" alt=""> VN</a></li>-->
				<!--          </ul>-->
				<!--        </li>-->

				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="https://s3-us-west-2.amazonaws.com/lightstalking-assets/wp-content/uploads/2010/02/15233618/square.jpg" alt="">John Doe
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
						<li><a href="javascript:;"> Profile</a></li>
						<li>
							<a href="javascript:;">
								<span class="badge bg-red pull-right">50%</span>
								<span>Settings</span>
							</a>
						</li>
						<li><a href="javascript:;">Help</a></li>
						<li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" class="info-number" onclick="$('#theCall').toggleClass('d-none')">
						<i class="fa fa-phone"></i>
						<span class="badge bg-red">1</span>
					</a>
				</li>
				<li role="presentation">
					<a href="javascript:;" class="info-number" onclick="$('#notifiHeader').toggleClass('d-none')">
						<i class="fa fa-bell-o"></i>
						<span class="badge bg-red">6</span>
					</a>
				</li>

			</ul>
		</nav>

		<div class="block-content d-none" id="notifiHeader" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="contract-noti-header" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
						THÔNG BÁO HỢP ĐỒNG <span>3</span>
					</a>
				</li>
				<li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">
						THÔNG BÁO HỢP ĐỒNG
					</a>
				</li>
			</ul>
			<div id="contract-noti-content" class="tab-content table-responsive">
				<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
					<table class="table noti-table__mobile">
						<tbody>
						<tr>
							<td class="dot"><i class="fa fa-circle"></i></td>
							<td class="box-noti">
								<strong class="title">PGD 901 Giải Phóng - GDV yêu cầu giải ngân hợp đồng.</strong>
								<p class="customer">Khách hàng: Phan Thị Hoài</p>
								<p>
									<i><i class="customer">Từ</i>: hoaipt@tienngay.vn</i>
									<i><span>2021/05/06</span></i>
								</p>
							</td>
						</tr>
						<tr>
							<td class="dot"><i class="fa fa-circle"></i></td>
							<td class="box-noti">
								<strong class="title">PGD 901 Giải Phóng - GDV yêu cầu giải ngân hợp đồng.</strong>
								<p class="customer">Khách hàng: Phan Thị Hoài</p>
								<p>
									<i><i class="customer">Từ</i>: hoaipt@tienngay.vn</i>
									<i><span>2021/05/06</span></i>
								</p>
							</td>
						</tr>
						<tr>
							<td class="dot"><i class="fa fa-circle"></i></td>
							<td class="box-noti">
								<strong class="title">PGD 901 Giải Phóng - GDV yêu cầu giải ngân hợp đồng.</strong>
								<p class="customer">Khách hàng: Phan Thị Hoài</p>
								<p>
									<i><i class="customer">Từ</i>: hoaipt@tienngay.vn</i>
									<i><span>2021/05/06</span></i>
								</p>
							</td>
						</tr>
						</tbody>
					</table>
					<p class="text-center see-all"><a href="#">Xem tất cả thông báo ></a><p>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
					<h4 class="text-center">Bạn không có thông báo nào.</h4>
				</div>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="marquee"><div style="width: 100000px; transform: translateX(1651px); animation: 60.3424s linear 0s 1 normal none running marqueeAnimation-3881481;" class="js-marquee-wrapper"><div class="js-marquee" style="margin-right: 1920px; float: left;">


					</div>
					<div class="js-marquee" style="margin-right: 1920px; float: left;">


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /top navigation -->
<!-- Top modals -->
<!-- Edit Profile  -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" >Thay đổi thông tin cá nhân</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-label-left" >
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Họ & tên <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="text"  class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Số điện thoại <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="text"  class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="email"  class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tỉnh / thành phố <span class="text-danger">*</span>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Quận / huyện <span class="text-danger">*</span>
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
							<button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Lưu lại</button>
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" >Thay đổi mật khẩu</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-label-left" >
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mật khẩu hiện tại <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="password"  class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mật khẩu mới <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="password"  class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nhập lại mật khẩu <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<input type="password"  class="form-control">
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Lưu lại</button>
							<button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Hủy</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

