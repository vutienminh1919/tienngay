<?php
	$name = !empty($_GET['name']) ? $_GET['name'] : "";
	$email= !empty($_GET['email']) ? $_GET['email'] : "";
	$number_phone= !empty($_GET['number_phone']) ? $_GET['number_phone'] : "";
	$type = !empty($_GET['type_user']) ? $_GET['type_user'] : "" ;
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3><?php echo $this->lang->line('user_list')?>
							<br>
							<small>
							<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#"><?php echo $this->lang->line('user_list')?></a>
							</small>
					</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url('user/create')?>" class="btn btn-info ">
						<i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line('add_new')?>
					</a>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		  <div class="x_panel">
			 <div class="x_title">
				 <form action="<?php echo base_url('user')?>" method="get" style="width: 100%;">
					 <div class="col-lg-2">
						 <div class="input-group">
						 <label>Tên</label>
						 <input type="text" name="name" class="form-control" placeholder="Full name" value="<?php if(isset($_GET['name'])) echo $name; ?>">
						 </div>
					 </div>
					 <div class="col-lg-2">
						 <div class="input-group">
						 <label>Email</label>
						 <input type="text" name="email" class="form-control" placeholder="Email" value="<?php if(isset($_GET['email'])) echo $email; ?>">
						 </div>
					 </div>
					 <div class="col-lg-2">
						 <label>Số điện thoại</label>
						 <div class="input-group">
						 <input type="text" name="number_phone" class="form-control" placeholder="Phone number" value="<?php if(!empty($_GET['number_phone'])) echo $number_phone; ?>">
						 </div>
					 </div>
					 <div class="col-lg-2">
						 <label>Chức danh</label>
						 <div class="input-group">
						 	<select class="form-control" name="type_user">
							 	<option value=""> Chọn chức danh</option>
								<option value="1" <?php if (isset($_GET['type_user']) && $_GET['type_user'] == 1) {?> selected="selected" <?php } ?> >Nhân viên</option>
								<option value="2" <?php if (isset($_GET['type_user']) && $_GET['type_user'] == 2) {?> selected="selected" <?php } ?> >Khách hàng</option>
                      		</select>
						 </div>
					 </div>
					 <div class="col-lg-2 text-right">
						 <label></label>
						 <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
					 </div>
				 </form>
			  <div class="clearfix"></div>
			</div>
			<div class="x_content">
			  <div class="row">
				<div class="col-xs-12">
				</div>
			  <br />
				<div class="col-xs-12">

				  <div class="table-responsive">
					<table id="" class="table table-striped">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Email</th>
						  <th>Username</th>
						  <th><?php echo $this->lang->line('user_name')?></th>
						  <th><?php echo $this->lang->line('status')?></th>
						  <th><?php echo $this->lang->line('phone_number')?></th>
						  <th><?php echo $this->lang->line('indentify_number')?></th>
						  <th><?php echo $this->lang->line('role')?></th>
						  <th><?php echo $this->lang->line('created_date')?></th>
						  <th><?php echo $this->lang->line('created_by')?></th>
						  <th></th>
						</tr>
					  </thead>

						<tbody>
						<?php
						if(!empty($userData)){
						foreach($userData as $key => $user){
							?>
								<tr>
								  <td><?php echo $key + 1?></td>
								  <td><?= !empty($user->email) ? $user->email : "" ?></td>
								  <td><?= !empty($user->username) ? $user->username : "" ?></td>
								  <td><?= !empty($user->full_name) ? $user->full_name : "" ?></td>
								  <td><?= !empty($user->status) ? $user->status : "" ?></td>
								  <td><?= !empty($user->phone_number) ? $user->phone_number : "" ?></td>
								  <td><?= !empty($user->identify) ? $user->identify : "" ?></td>
								  <td><?= !empty($user->role) ? $user->role : "" ?></td>
								  <td><?= !empty($user->created_at) ? date('d/m/Y', intval($user->created_at)) : "" ?></td>
								  <td><?= !empty($user->created_by) ? $user->created_by : "" ?></td>
								  <td>
									<a href="<?php echo base_url('user/view?id='.$user->id)?>">
									  <i class="fa fa-edit"><?php echo $this->lang->line('detail')?></i>
									</a>
								  </td>
								</tr>
							<?php }
							} ?>
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
	  </div>
  </div>
</div>
<!-- /page content -->
