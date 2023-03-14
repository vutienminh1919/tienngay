<!-- page content -->
<div class="right_col" role="main">
		<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	

	?>
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-9">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3>Lịch sử cuộc gọi
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">CSKH</a>
							/ <a href="#">Lịch sử cuộc gọi TLS</a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
		</div>

		<div class="col-xs-12">
          <div class="row">
				  <form action="<?php echo base_url('lead_custom/historyCall_all')?>" method="get" style="width: 100%;">
					  <div class="col-lg-3">
						  <label></label>
						  <div class="input-group">
							  <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
							  <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>" >
						  </div>
					  </div>
					  <div class="col-lg-3">
						  <label></label>
						  <div class="input-group">
							  <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
							  <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>" >

						  </div>
					  </div>

					
					<div class="col-lg-2">
					  <label>Người dùng</label>
					  	<select  class="form-control"  name="cskh" id="cskh">
						 <option value="">Chọn người dùng</option>
								
					 <?php 
                        if(!empty($cskhData)){
                            foreach($cskhData as $key => $cskh1){
                            	foreach ($cskh1 as $key => $val) {  	
                        ?>
                            <option <?=  ($cskh== $val->email) ?    "selected" :  "" ?> value="<?= !empty($val->email) ? $val->email : "";?>"><?= !empty($val) ? $val->email : "";?></option>
                     <?php }}}?>
                     </select>
					  
					</div>
					 <div class="col-lg-2">
						  <label>Số điện thoại</label>
						  <div class="input-group">
							 
					<input type="text" name="sdt"  class="form-control" value="<?= !empty($sdt) ?  $sdt : ""?>" placeholder="Nhập số điện thoại" >

						  </div>
					  </div>
					<div class="col-lg-2 text-right">
						<label></label>
					  <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
					</div>
				  </form>
              </div>

			<div class="table-responsive">
					 
					<?php echo $pagination ?><br>
		  <div ><?php echo $result_count;?></div>
		          
				<table id="" class="table table-striped table-hover">
					<thead>
					<tr>
						<th>#</th>
						<th>Loại cuộc gọi</th>
						<th>Nhân viên</th>
						<th>Hợp đồng</th>
						<th>Tên khách hàng</th>
						<th>Số gọi</th>
						<th>Số nghe</th>
						<th>Trạng thái cuộc gọi</th>
						<th>Chi tiết</th>
						<th>Thời lượng</th>
						<th>File ghi âm</th>

					</tr>
					</thead>
					<tbody name="list_lead" >
					<?php
					$n = 0;
					if (!empty($recordingData)) {
						foreach ($recordingData as $key => $history) {
							?>
							<tr>
								<td><?php echo ++$n ?></td>
								<td><?php if ($history->direction == 'outbound')
										echo '<div class="text-primary"><i class="fa fa-mail-reply" aria-hidden="true"></i><br>Outbound call</div>'; ?>
									<?php if ($history->direction == 'inbound')
										echo '<div class="text-danger"><i class="fa fa-mail-forward" aria-hidden="true"></i><br>Inbound call</div>'; ?>
									<?php if ($history->direction == 'local')
										echo '<div class="text-warning"><i class="fa fa-refresh" aria-hidden="true"></i><br>Internal</div>'; ?>

								</td>

								<td><?= ($history->fromUser) ? $history->fromUser->email : '' ?><br>
									<?= ($history->toUser) ? $history->toUser->email : '' ?>
								</td>
								<td>
									<?php if (!empty($history->code_contract_disbursement)): ?>
										<?php foreach ($history->code_contract_disbursement as $hd): ?>
										<div>
											<?= $hd ?>
										</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</td>
								<td><?= ($history->customer_name) ? $history->customer_name : '' ?></td>
								<td><?= ($history->fromNumber) ? hide_phone($history->fromNumber) : ''; ?><br>
									<?= ($history->fromUser) ? 'Nhánh: ' . $history->fromUser->ext : ''; ?>
								</td>
								<td><?= ($history->toNumber) ? hide_phone($history->toNumber) : ''; ?><br>
									<?= ($history->toUser) ? 'Nhánh: ' . $history->toUser->ext : ''; ?>
								</td>
								<td><?= !empty($history->hangupCause) ? recoding_status($history->hangupCause) : "" ?></td>
								<td>Bắt
									đầu: <?= !empty($history->startTime) ? date('d/m/Y H:i:s', $history->startTime / 1000) : "" ?>
									<br>
									Trả
									lời: <?= (!empty($history->answerTime) && (int)($history->answerTime) > 0) ? date("d/m/Y H:i:s", $history->answerTime / 1000) : "Không có"; ?>
									<br>
									Kết
									thúc: <?= !empty($history->endTime) ? date('d/m/Y H:i:s', $history->endTime / 1000) : "" ?>
									<br>
								</td>
								<td>Tổng time: <?= ($history->duration) ? $history->duration : '' ?><br>
									Tổng time tư vấn: <?= ($history->billDuration) ? $history->billDuration : '' ?><br>
								</td>
								<td class="text-right">
									<?php if ((int)($history->toExt) < 1000 && $history->direction == 'inbound') { ?>
										<a href="javascript:void(0)"
										   onclick="call_for_customer('<?= !empty($history->fromNumber) ? encrypt($history->fromNumber) : "" ?>')"
										   class="btn btn-success call_for_customer"><i class="fa fa-phone  size18"
																						aria-hidden="true"></i> Gọi lại</a>

									<?php } else if ($history->billDuration) { ?>

									<?php } ?>

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
<div id="listentoRecord" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Nghe ghi âm</h4>
			</div>

			<div class="modal-body">
				<audio controls class="w-100" id="player">

					<source src="" type="audio/mp3" id="audio">

				</audio>
			</div>
			<div class="modal-footer">
				<!--     <button type="button" class="btn btn-default" >
                      <i class="fa fa-download"></i> Download
                    </button> -->
				<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>

			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>
<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
   aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
        <button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
        <input id="number" name="phone_number" type="hidden" value=""/>
        <p id="status" style="margin-left: 125px;"></p>
        <h3 class="modal-title title_modal_approve"></h3>
      </div>
    </div>
  </div>
</div>
