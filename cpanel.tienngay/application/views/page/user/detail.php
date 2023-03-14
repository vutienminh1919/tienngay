<!-- page content -->
<div class="right_col" role="main">

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $this->lang->line('detail_user')?>
					<br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('user')?>"><?php echo $this->lang->line('user_list')?></a> / <a href="#"><?php echo $this->lang->line('detail_user')?></a> 
					</small>
				</h3>
      </div>
      <div class="title_right text-right">
        <a href="<?php echo base_url('user')?>" class="btn btn-info ">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
			<?php echo $this->lang->line('back')?>
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
  	<div class="col-md-6 ">
      <div class="x_panel">
        <div class="x_title">
		  <h2><?php echo $this->lang->line('update_infor')?></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content form-horizontal form-label-left">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">
					Email
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" required class="form-control col-md-7 col-xs-12 email" value="<?php echo $userData->email?>" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">
					Username
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" required class="form-control col-md-7 col-xs-12 username" value="<?php echo $userData->username?>" readonly/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="full_name">
					<?php echo $this->lang->line('user_name')?>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" required class="form-control col-md-7 col-xs-12 full_name_update" value="<?php echo !empty($userData->full_name) ? $userData->full_name : ''?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="indentify">
					<?php echo $this->lang->line('indentify_user')?>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="number" required class="form-control col-md-7 col-xs-12 indentify_update" value="<?php echo !empty($userData->identify) ? $userData->identify : ''?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_update">
					<?php echo $this->lang->line('phone_number')?>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="number" required class="form-control col-md-7 col-xs-12 phone_update" value="<?php echo !empty($userData->phone_number) ? $userData->phone_number : ''?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="status_update">
					<?php echo $this->lang->line('status')?><span class="red">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<select id="status_update" class="form-control" name="status_update">
						<option value="new" <?php echo $userData->status == 'new' ? 'selected' : ''?>>New</option>
						<option value="active" <?php echo $userData->status == 'active' ? 'selected' : ''?>>Active</option>
						<option value="block" <?php echo $userData->status == 'block' ? 'selected' : ''?>>Block</option>
					</select>
				</div>
			</div>
			
			<input class="id_user_update" name="id_user_update" value="<?php echo $id?>" type="hidden"/>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<a href="<?php echo base_url('user')?>" class="btn btn-primary" type="button"><?php echo $this->lang->line('cancel')?></a>
					<button class="btn btn-success btn-update-user"><?php echo $this->lang->line('update')?></button>
				</div>
			</div>
	    </div>
      </div>
  </div>
  <div class="col-md-6 ">
  	<div class="x_panel">
        <div class="x_title">
		  <h2>Thông tin role</h2>
          <div class="clearfix"></div>
        </div>
  		<div class="control-group row">
			<label class="control-label col-md-3 col-sm-3 ">Nhóm quyền</label>
			<div class="col-md-9 col-sm-9 ">
				<?php if(!empty($groupRoleOfUser) ){ 
					$group_r="";
					foreach ($groupRoleOfUser as $key => $value) {
						$group_r.= $value.', ';
					}
                // var_dump($groupRoleOfUser); 
				 ?>
				<input id="tags_1" type="text" class="tags form-control" value="<?=$group_r ?>"  disabled />
				  <?php } ?>
				<div id="suggestions-container" style="position: relative; float: left; width: 300px; margin: 10px;"></div>
			</div>
		</div>
		<div class="control-group row">
			<label class="control-label col-md-3 col-sm-3 ">Quyền</label>
			<div class="col-md-9 col-sm-9 ">
				<?php
				 if(!empty($roleOfUser) ){ 
					$role="";
					foreach ($roleOfUser as $key => $value) {
						$role.= $value.', ';
					}
                 				 ?>
				<input id="tags_2" type="text" class="tags form-control" value="<?=$role ?>" disabled />
				 <?php } ?>
				<div id="suggestions-container1" style="position: relative; float: left; width: 300px; margin: 10px;"></div>
			</div>
		</div>
		<div class="control-group row">
			<label class="control-label col-md-3 col-sm-3 ">Phòng giao dịch</label>
			<div class="col-md-9 col-sm-9 ">
					<?php
				 if(!empty($storeOfUser) ){ 
					$store="";
					foreach ($storeOfUser as $key => $value) {
						$store.= $value->store_name.', ';
					}
                 				 ?>
				<input id="tags_3" type="text" class="tags form-control" value="<?=$store ?>" disabled />
				 <?php } ?>
				<div id="suggestions-container2" style="position: relative; float: left; width: 300px; margin: 10px; height: 500px;"></div>
			</div>
		</div>
	</div>

  </div>
</div>
</div>
  <!-- /page content -->
<script src="<?php echo base_url();?>assets/js/user/index.js"></script>
