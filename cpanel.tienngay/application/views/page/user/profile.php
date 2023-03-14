<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>
            Thông tin người dùng
            <br>
            <small>
              <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('account/profile')?>">Cập nhật thông tin</a>
            </small>
          </h3>
        </div>
	    <div class="title_right text-right">
		  <a href="<?php echo base_url("account/editProfile")?>" class="btn btn-info " ><i class="fa fa-edit" aria-hidden="true"></i> <?php echo $this->lang->line('Edit')?></a>
	    </div>

      </div>
    </div>
	  <div class="col-xs-12">
		  <?php if ($this->session->flashdata('error')) { ?>
			  <div class="alert alert-danger alert-result">
				  <?= $this->session->flashdata('error') ?>
			  </div>
		  <?php } ?>
		  <?php if ($this->session->flashdata('success')) { ?>
			  <div class="alert alert-success alert-result">
				  <?= $this->session->flashdata('success') ?></div>
		  <?php } ?>
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
              </ul>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="profile-tab">
                  <form class="form-horizontal form-label-left input_mask">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="text-danger">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" value="<?php echo $user->email?>" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên đầy đủ <span class="text-danger">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="full_name" name="full_name" type="text" class="form-control" placeholder="Nhập tên đầy đủ" value="<?php echo !empty($user->full_name) ? $user->full_name : ''?>" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Số điện thoại <span class="text-danger">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="phone_user" name="phone_user" type="text" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo !empty($user->phone_number) ? $user->phone_number : ''?>" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">CMT / CCCD <span class="text-danger">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
						  <input id="indentify_user" name="indentify_user"  type="number" class="form-control" placeholder="Nhập số chứng minh thư / căn cước công dân" value="<?php echo !empty($user->identify) ? $user->identify : ''?>" readonly>
                      </div>
                    </div>
                    <div class="ln_solid"></div>

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
