<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
          Thông báo
          <br>
          <small>
            <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Trang chủ</a> / <a href="<?php echo base_url('account/all')?>">Thông báo</a>
          </small>
        </h3>
      </div>
    </div>
  </div>
	<div>
		<nav class="text-right">
			<a class="btn btn-success" 
			   onclick="read_all_notification(this)" data-tab="1">
				<i class="fa icon-ok"></i>
				Đọc tất cả
			</a>
		</nav>
	</div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
        <div class="table-responsive">
          <table  class="table table-striped">
<!--			  id="datatable-buttons"-->
            <thead>
              <tr>
                <th>Thời gian</th>
                <th>Thông báo</th>
                <th>Chi tiết</th>
                <th>Link</th>
              </tr>
            </thead>
            <tbody>

			<?php
			if(!empty($notifications)){
			foreach($notifications as $key => $no){
			?>
				<tr class="<?php echo $no->status == 1 ? 'unread' : ''?>">
					<td><?= $no->date?></td>
					<td>
						<strong>
							<?= $no->title?>
						</strong>
					</td>
					<td> <?= $no->note?></td>
					<td>

						<?php if(!empty($no->data_hs)): ?>
							<?php
							$customer_name_hs = $no->data_hs[count($no->data_hs)-1]->user->email;
							$check_customer_hs = $no->data_hs[count($no->data_hs)-1]->check;
							?>
						<?php endif; ?>

						<?php if ($no->status == 1 && $groupRoles[0] != "5def671dd6612b75532960c5" && $groupRoles[0] != "5ec74bd2d6612b3cc464e64a" ) { ?>
							<a onclick="updateNotification('<?php echo $no->id?>')" href="<?php echo base_url().$no->detail?>"><i class="fa fa-eye"></i> Xem</a>
						<?php } ?>

						<?php if (($customer_name_hs == "") && ($no->status == 1 && $groupRoles[0] == "5def671dd6612b75532960c5")) { ?>
								<input id="id_update" style="display: none" value="<?php echo $no->id?>">
							<a href="javascript:void(0)"  data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"  data-id="<?php echo $no->action_id?>" onclick="hoi_so_bat_dau_duyet1(this)"> <i class="fa fa-eye"></i> Xem</a>

						<?php }  elseif (($customer_name_hs == $userSession['email']) && ($no->status == 1 && $groupRoles[0] == "5def671dd6612b75532960c5")){ ?>
							<input id="id_update" style="display: none" value="<?php echo $no->id?>">
							<a href="javascript:void(0)"  data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"  data-id="<?php echo $no->action_id?>" onclick="hoi_so_bat_dau_duyet1(this)"> <i class="fa fa-eye"></i> Xem</a>

						<?php } elseif (($check_customer_hs == 2) && ($no->status == 1 && $groupRoles[0] == "5def671dd6612b75532960c5")){ ?>
							<input id="id_update" style="display: none" value="<?php echo $no->id?>">
							<a href="javascript:void(0)"  data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"  data-id="<?php echo $no->action_id?>" onclick="hoi_so_bat_dau_duyet1(this)"> <i class="fa fa-eye"></i> Xem</a>


						<?php } elseif (($check_customer_hs == "") && ($no->status == 1 && $groupRoles[0] == "5ec74bd2d6612b3cc464e64a")){ ?>
							<input id="id_update" style="display: none" value="<?php echo $no->id?>">
							<a href="javascript:void(0)"  data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"  data-id="<?php echo $no->action_id?>" onclick="hoi_so_bat_dau_duyet1(this)"> <i class="fa fa-eye"></i> Xem</a>
						<?php } elseif (($customer_name_hs == $userSession['email']) && ($no->status == 1 && $groupRoles[0] == "5ec74bd2d6612b3cc464e64a")){ ?>
							<input id="id_update" style="display: none" value="<?php echo $no->id?>">
							<a href="javascript:void(0)"  data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"  data-id="<?php echo $no->action_id?>" onclick="hoi_so_bat_dau_duyet1(this)"> <i class="fa fa-eye"></i> Xem</a>
						<?php } elseif (($check_customer_hs == 2) && ($no->status == 1 && $groupRoles[0] == "5ec74bd2d6612b3cc464e64a")){ ?>
							<input id="id_update" style="display: none" value="<?php echo $no->id?>">
							<a href="javascript:void(0)"  data-value="<?= !empty($customer_name_hs) ? $customer_name_hs : "" ?>"  data-id="<?php echo $no->action_id?>" onclick="hoi_so_bat_dau_duyet1(this)"> <i class="fa fa-eye"></i> Xem</a>


						<?php } elseif($no->status != 1) { ?>

							<a href="<?php echo base_url().$no->detail?>"><i class="fa fa-eye"></i> Xem</a>
						<?php } ?>
					</td>
				</tr>
			<?php
				}
			}?>
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
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>
<script type="text/javascript">
	function read_all_notification(t) {
		if (confirm('Bạn có chắc chắn không?')) {
			$.ajax({
				url: _url.base_url + "account/updateAllStatusNoti",
				type: "POST",
				dataType: 'json',
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					console.log(data)
					if (data.status == 200) {
						$("#successModal").modal("show");
						$(".msg_success").text("Thành công");
						setTimeout(function () {
							window.location.href = _url.base_url + "account/all";
						}, 2000);
					} else {
						//$("#approve_transaction").modal("hide");
						$("#errorModal").modal("show");
						$(".msg_error").text(data.message);
					}
				},
				error: function (data) {
					console.log('data')
				}
			});
		}
	}
	
</script>
