<!-- page content -->
<div class="right_col" role="main" id="update_profile">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>
			  Cập nhật thông tin người dùng
            <br>
            <small>
              <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('account/profile')?>">Cập nhật thông tin</a>
            </small>
          </h3>
        </div>

      </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
            <div class="profile_img">
              <div id="crop-avatar">
                <!-- Current avatar -->
                <img id="image_avatar" class="img-responsive avatar-view" src="<?php echo !empty($user->avatar) ? $user->avatar : base_url().'assets/imgs/avatar_none.png'?>" alt="Avatar" title="Change the avatar">
              </div>
            </div>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">

            <div class="" role="tabpanel" data-example-id="togglable-tabs">
              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

                <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Thông tin cá nhân</a>
                </li>
				  <li role="presentation" class=""><a href="#tab_password" role="tab" id="profile-password" data-toggle="tab" aria-expanded="false">Mật khẩu</a>
				  </li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="profile-tab">
                  <form class="form-horizontal form-label-left input_mask" method="post" action="<?php echo base_url('account/updateProfile')?>" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="text-danger">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" value="<?php echo $user->email?>" readonly>
                      </div>
                    </div>
				  	<div class="form-group">
						  <label class="control-label col-md-3 col-sm-3 col-xs-12">Username <span class="text-danger">*</span></label>
						  <div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" class="form-control" value="<?php echo $user->username?>" readonly>
						  </div>
					  </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên đầy đủ <span class="text-danger">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="full_name" name="full_name" type="text" class="form-control" placeholder="Nhập tên đầy đủ" value="<?php echo !empty($user->full_name) ? $user->full_name : ''?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Số điện thoại <span class="text-danger">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="phone_user" name="phone_user" type="text" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo !empty($user->phone_number) ? $user->phone_number : ''?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">CMT / CCCD <span class="text-danger">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
						  <input id="indentify_user" name="indentify_user"  type="number" class="form-control" placeholder="Nhập số chứng minh thư / căn cước công dân" value="<?php echo !empty($user->identify) ? $user->identify : ''?>" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Avatar</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="change_avatar" name="change_avatar" type="file" class="form-control" >
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <a href="<?php echo base_url('account/profile')?>" type="button" class="btn btn-primary"><i class="fa fa-close"></i> Trở lại</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu lại</button>
                      </div>
                    </div>

                  </form>
                </div>
				  <div role="tabpanel" class="tab-pane fade in" id="tab_password" aria-labelledby="profile-password">
					  <form class="form-horizontal form-label-left input_mask" method="post" action="<?php echo base_url('account/changePassword')?>">
						  <div class="form-group">
							  <label class="control-label col-md-3 col-sm-3 col-xs-12">Mật khẩu hiện tại <span class="text-danger">*</span></label>
							  <div class="col-md-9 col-sm-9 col-xs-12 change-password">
								  <input type="password" id="current_password" name="current_password" class="form-control">
								  <button type="button" class="btn btn-link passwordtoggler">
									  <i class="fa fa-eye"></i>
								  </button>
							  </div>
						  </div>
						  <div class="form-group">
							  <label class="control-label col-md-3 col-sm-3 col-xs-12">Mật khẩu mới <span class="text-danger">*</span></label>
							  <div class="col-md-9 col-sm-9 col-xs-12 change-password">
								  <input id="password" name="password" type="password" class="form-control">
								  <button type="button" class="btn btn-link passwordnew">
									  <i class="fa fa-eye"></i>
								  </button>
							  </div>
						  </div>
						  <div class="form-group">
							  <label class="control-label col-md-3 col-sm-3 col-xs-12">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
							  <div class="col-md-9 col-sm-9 col-xs-12 change-password">
								  <input id="re_password" name="re_password" type="password" class="form-control">
							  </div>
						  </div>
						  <div class="ln_solid"></div>
						  <div class="form-group">
							  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
								  <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Xác nhận</button>
							  </div>
						  </div>
					  </form>
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
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#image_avatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#change_avatar").change(function() {
        readURL(this);
    });

    $('.passwordtoggler').click(function(event) {
        var x = document.getElementById("current_password");
        // event.preventDefault();
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        $(this).children().toggleClass('fa-eye').toggleClass('fa-eye-slash');
    });
    $('.passwordnew').click(function(event) {
        var y = document.getElementById("password");
        // event.preventDefault();
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }
        $(this).children().toggleClass('fa-eye').toggleClass('fa-eye-slash');
    });
</script>
