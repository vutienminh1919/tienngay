<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $this->lang->line('create_new_user')?>
					<br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('user')?>"><?php echo $this->lang->line('user_list')?></a> / <a href="#"><?php echo $this->lang->line('create_new_user')?></a> 
					</small>
				</h3>
            </div>
            <div class="title_right text-right">

                <a href="<?php echo base_url('user')?>" class="btn btn-info">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>

                </a>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_content form-horizontal form-label-left">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Email <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="email" class="form-control email_create" placeholder="<?php echo $this->lang->line('typing_email')?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Username <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" class="form-control username_create" placeholder="Nhập tên đăng nhập" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('full_name')?> <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" class="form-control full_name_create" placeholder="<?php echo $this->lang->line('typing_full_name')?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('phone_number')?> <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="number" class="form-control phone_create" placeholder="<?php echo $this->lang->line('typing_phone')?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('password')?> <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="password" pattern=".{6,}" class="form-control input-password" placeholder=""  required>
						<span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php echo $this->lang->line('indentify_user')?> <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="number" class="form-control indentify_create" placeholder="<?php echo $this->lang->line('typing_indentify')?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Nhóm quyền <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<select class="form-control" id="role_user" required>
							<?php
							foreach($groupRoles as $key =>  $g){
								?>
								<option value="<?= !empty($g->group_role_id) ? $g->group_role_id : ""?>" selected><?= !empty($g->name) ? $g->name : ""?></option>
							<?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						<button class="btn btn-success btn-create-user">
							<i class="fa fa-save"></i>
							<?php echo $this->lang->line('save')?>
						</button>
						<a href="<?php echo base_url('user')?>" class="btn btn-info ">
							<i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>
						</a>
					</div>
				</div>
            </div>
        </div>
    </div>
    </div>
  </div>
    <!-- /page content -->
<script src="<?php echo base_url();?>assets/js/user/index.js"></script>
