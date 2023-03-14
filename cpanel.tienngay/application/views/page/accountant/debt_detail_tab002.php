<div class="row flex">
  <div class="col-xs-12 col-md-6">
    <h4>Thông tin khách hàng</h4>
    <div class="row">
      <div class="col-xs-4">
        Họ và tên
      </div>
      <div class="col-xs-8 text-right">
        <strong><?php echo $contractDB->customer_infor->customer_name?></strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Giới tính
      </div>
      <div class="col-xs-8 text-right">
        <strong><?php echo $contractDB->customer_infor->customer_gender == 1 ? 'Nam' : 'Nữ'?></strong>
      </div>
    </div>
    <div class="row">
	  <div class="col-xs-4">
		  Ngày sinh
	  </div>
	  <div class="col-xs-8 text-right">
		  <strong><?php echo $contractDB->customer_infor->customer_BOD?></strong>
	  </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Số CMND/CCCD
      </div>
      <div class="col-xs-8 text-right">
		  <strong><?php echo $contractDB->customer_infor->customer_identify?></strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Email
      </div>
      <div class="col-xs-8 text-right">
		  <strong><?php echo $contractDB->customer_infor->customer_email?></strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Số điện thoại
      </div>
      <div class="col-xs-8 text-right">
        <a href="tel:<?php echo $contractDB->customer_infor->customer_phone_number?>">
          <strong><i class="fa fa-lg fa-phone" style="color:#04B204"></i> <?php echo $contractDB->customer_infor->customer_phone_number?></strong>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Địa chỉ đang ở
      </div>
      <div class="col-xs-8 text-right">
        <strong><?php echo $address?></strong>
      </div>
    </div>
       <div class="row">
    <div class="col-xs-4">
      Địa chỉ SHK
    </div>
    <div class="col-xs-8 text-right">
      <strong><?php echo $addressSHK?></strong>
    </div>
    </div>
  </div>

  <div class="col-xs-12 col-md-6">
    <h4>Thông tin người tham chiếu</h4>
    <div class="row">
      <div class="col-xs-4">
        Tên người tham chiếu 1
      </div>
      <div class="col-xs-8 text-right">
        <strong><?php echo $contractDB->relative_infor->fullname_relative_1?></strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Mối quan hệ
      </div>
      <div class="col-xs-8 text-right">
        <strong><?php echo $contractDB->relative_infor->type_relative_1?></strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Số điện thoại
      </div>
      <div class="col-xs-8 text-right">
        <a href="tel:<?php echo $contractDB->relative_infor->phone_number_relative_1?>">
          <strong><i class="fa fa-lg fa-phone" style="color:#04B204"></i> <span id="phone_1"><?php echo $contractDB->relative_infor->phone_number_relative_1?></span></strong>
        </a>
		  <span style="padding-left: 20px"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_edit_phone" title="Sửa"></i></span>
      </div>
    </div>
     <div class="row">
      <div class="col-xs-4">
        Địa chỉ
      </div>
      <div class="col-xs-8 text-right">
        <strong><span id="address_1"><?php echo $contractDB->relative_infor->hoursehold_relative_1?></span></strong>
         <span style="padding-left: 20px"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_edit_phone" title="Sửa"></i></span>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Tên người tham chiếu 2
      </div>
      <div class="col-xs-8 text-right">
        <strong><?php echo $contractDB->relative_infor->fullname_relative_2?></strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Mối quan hệ
      </div>
      <div class="col-xs-8 text-right">
        <strong><?php echo $contractDB->relative_infor->type_relative_2?></strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        Số điện thoại
      </div>
      <div class="col-xs-8 text-right">
        <a href="tel:<?php echo $contractDB->relative_infor->phone_number_relative_2?>">
          <strong><i class="fa fa-lg fa-phone" style="color:#04B204"></i> <span id="phone_2"><?php echo $contractDB->relative_infor->phone_number_relative_2?></span></strong>
        </a>
		  <span style="padding-left: 20px"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_edit_phone" title="Sửa"></i></span>
      </div>
    </div>
      <div class="row">
      <div class="col-xs-4">
        Địa chỉ
      </div>
      <div class="col-xs-8 text-right">
        <strong><span id="address_2"><?php echo $contractDB->relative_infor->hoursehold_relative_2?></span></strong>
         <span style="padding-left: 20px"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_edit_phone" title="Sửa"></i></span>
      </div>
    </div>
 
  </div>
</div>
<hr>
<h4>Lịch sử hoạt động</h4>
<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Kỳ</th>
        <th>Ngày</th>
        <th>Người thực hiện</th>
        <th>Nội dung</th>
       
      </tr>
    </thead>

    <tbody>
    

        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
         
        </tr>


    </tbody>
</table>
</div>
<hr>
<h4>Lịch sử cuộc gọi</h4>
<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Người liên hệ</th>
        <th>Số điện thoại</th>
        <th>Kết quả</th>
        <th>Bắt đầu</th>
        <th>Kết thúc</th>
        <th>Ghi chú</th>
      </tr>
    </thead>

	  <tbody>
	  <?php
	  if(!empty($callData)){
		  foreach($callData as $key => $call){
			  ?>

			  <tr>
				  <td><?php echo $key+1?></td>
				  <td><?= !empty($call->contact_name) ? $call->contact_name : ""?></td>
				  <td><?= !empty($call->contact_phone) ? $call->contact_phone : ""?></td>
				  <td><?= !empty($call->result) ? $call->result : ""?></td>
				  <td><?= !empty($call->begin) ? date('d/m/Y H:i:s', intval($call->begin) + 7*3600) : ""?></td>
				  <td><?= !empty($call->end) ? date('d/m/Y H:i:s', intval($call->end)+ + 7*3600) : ""?></td>
				  <td><?= !empty($call->note) ? $call->note : ""?></td>
			  </tr>
		  <?php }} ?>

	  </tbody>
</table>
</div>
<div class="modal fade" id="modal_edit_phone" tabindex="-1" role="dialog" aria-labelledby="ContractUpdateModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Thông tin người tham chiếu</h4>
				<hr>
				<input type="hidden" name="contract_id_update" value="<?php echo $contract_id?>">
				<div class="row">
					<div class="col-xs-12">
						<div class="col-xs-6">
							<div class="row">
								<div class="col-xs-4">
									Tên người tham chiếu 1
								</div>
								<div class="col-xs-8 text-right">
									<strong><?php echo $contractDB->relative_infor->fullname_relative_1?></strong>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									Mối quan hệ
								</div>
								<div class="col-xs-8 text-right">
									<strong><?php echo $contractDB->relative_infor->type_relative_1?></strong>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									SĐT:
								</div>
								<div class="col-xs-8 text-right">
									<input class="form-group" name="phone_1" type="number" value="<?php echo $contractDB->relative_infor->phone_number_relative_1?>">
								</div>
							</div>
              <div class="row">
                <div class="col-xs-4">
                  Địa chỉ:
                </div>
                <div class="col-xs-8 text-right">
                  <input class="form-group" name="address_1" type="text" value="<?php echo $contractDB->relative_infor->hoursehold_relative_1?>">
                </div>
              </div>
						</div>
						<div class="col-xs-6">
							<div class="row">
								<div class="col-xs-4">
									Tên người tham chiếu 2
								</div>
								<div class="col-xs-8 text-right">
									<strong><?php echo $contractDB->relative_infor->fullname_relative_2?></strong>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									Mối quan hệ
								</div>
								<div class="col-xs-8 text-right">
									<strong><?php echo $contractDB->relative_infor->type_relative_2?></strong>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									SĐT:
								</div>
								<div class="col-xs-8 text-right">
									<input class="form-group" name="phone_2" type="number" value="<?php echo $contractDB->relative_infor->phone_number_relative_2?>">
								</div>
							</div>
                <div class="row">
                <div class="col-xs-4">
                  Địa chỉ:
                </div>
                <div class="col-xs-8 text-right">
                  <input class="form-group" name="address_2" type="text" value="<?php echo $contractDB->relative_infor->hoursehold_relative_2?>">
                </div>
              </div>
						</div>
					</div>
				</div>
				<p class="text-right">
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
					<button type="button" id="update_info" class="btn btn-primary" name="btn-update">Cập nhật</button>
				</p>
			</div>

		</div>
	</div>
</div>

