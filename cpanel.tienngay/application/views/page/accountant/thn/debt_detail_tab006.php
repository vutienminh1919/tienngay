
<div class="row form-horizontal form-label-left input_mask">
  <div class="col-xs-12 ">
    <h4>Thông tin</h4>
  </div>
  <div class="col-xs-12 col-lg-6">
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mã hợp đồng</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <!-- <input type="text" class="form-control " name="code_contract" value="<?= !empty($contractDB->code_contract) ?  $contractDB->code_contract : ""?>" readonly> -->
          <input type="text" class="form-control " name="code_contract" value="<?= !empty($contractDB->code_contract_disbursement) ?  $contractDB->code_contract_disbursement : ""?>" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Khách hàng</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" name="customer_name" class="form-control" value="<?= !empty($contractDB->customer_infor->customer_name) ?  $contractDB->customer_infor->customer_name : ""?>" readonly>
        </div>
      </div>


      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">SDT người thanh toán</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" name="customer_phone_number" class="form-control" value="<?= !empty($contractDB->customer_infor->customer_phone_number) ?  $contractDB->customer_infor->customer_phone_number : ""?>" readonly>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Số tiền vay</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" name="amount_money" class="form-control" value="<?= !empty($contractDB->loan_infor->amount_money) ?  number_format($contractDB->loan_infor->amount_money) : ""?>" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phí tư vấn gia hạn</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" name="fee_extend" class="form-control" value="<?= !empty($contractDB->fee->extend) ?  number_format($contractDB->fee->extend) : ""?>"  readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tiền trả còn lại</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
        <?php 
          $tien_phi_phat_tra_cham = !empty($debtData) ? $debtData->tien_phi_phat_tra_cham : 0;
          $lai_ky = !empty($debtData) ? $debtData->lai_ky : 0;
          $phi_tu_van = !empty($debtData) ? $debtData->phi_tu_van : 0;
          $phi_tham_dinh  = !empty($debtData) ? $debtData->phi_tham_dinh : 0;
          $tong_phi_no =  $tien_phi_phat_tra_cham + $lai_ky + $phi_tu_van + $phi_tham_dinh;
        ?>
          <input readonly type="text" name="tong_phi_no" class="form-control" value="<?= !empty($tong_phi_no) ? number_format($tong_phi_no) : 0 ?>" >
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tổng tiền thanh toán</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
        <?php 
          $fee_extend = !empty($contractDB->fee->extend) ?  $contractDB->fee->extend : 0;
          $tong_thanh_toan = (int)$tong_phi_no + (int)$fee_extend;
        ?>
          <input type="text" name="tong_thanh_toan" class="form-control" value="<?= !empty($tong_thanh_toan) ?  number_format($tong_thanh_toan) : ""?>"  readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Số tiền thanh toán</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" name="so_tien_thanh_toan" class="form-control" value=""  >
        </div>
      </div>
  </div>
  <div class="col-xs-12 col-lg-6">
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ngày giải ngân</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="<?= !empty($contractDB->disbursement_date) ? date('d/m/Y', intval($contractDB->disbursement_date) + 7*3600) : ""?>" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Gia hạn lần thứ</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control " name="renewal_number" value="<?= !empty($contractDB->count_extension) ? $contractDB->count_extension : "1"?>" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('store')?>
        </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="stores_finish">
            <?php
            $userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
            $stores = !empty($userInfo['stores']) ?  $userInfo['stores'] : array();
            foreach($stores as $key =>  $value){
              ?>
              <option value="<?= !empty($value->store_id) ? $value->store_id : ""?>" selected><?= !empty($value->store_name) ? $value->store_name : ""?></option>
            <?php }?>
          </select>
        </div>
	  </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phương thức</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <div class="form-check" style="padding-top:8px;">
            <input class="form-check-input" type="radio" name="payment_method6" value="1" checked>
            <label class="form-check-label" for="moneyoption_cast">
              Tiền mặt
            </label>
            &ensp;
            <input class="form-check-input" type="radio" name="payment_method6" value="2">
            <label class="form-check-label" for="moneyoption_banktransfer">
              Chuyển khoản
            </label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lý do</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <textarea class="form-control " name="reason" rows="3" cols="80"></textarea>
        </div>
      </div>
  </div>


  <div class="col-xs-12">
    <div class="ln_solid"></div>
    <div class="form-group text-right">
      <button type="button" class="btn btn-primary" style="min-width: 125px">Hủy</button>
      <button type="button" class="btn btn-success  style="min-width: 125px" data-toggle="modal" data-target="#renewal">Tiếp tục</button>
      <input type="hidden" class="form-control " name="id_contract" value="<?= !empty($contractDB->_id->{'$oid'}) ? $contractDB->_id->{'$oid'} : ""?>" readonly>
    </div>
  </div>

  <div class="col-xs-12">
    <br>
    <table class="table table-striped table-bordered thedatatable " style="width:100%">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Ngày gia hạn</th>
          <th scope="col">Lần gia hạn</th>
          <th scope="col">Lý do gia hạn</th>
          <th scope="col">Nhân viên gia hạn</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        if(!empty($contractExtensionData)){
          foreach($contractExtensionData as $key => $value){
         ?>
          <tr>
            <th scope="row"><?php echo $key ?></th>
            <td><?= !empty($value->created_at) ? date('d/m/Y', intval($value->created_at)) : ""?></td>
            <td><?= !empty($value->count_extension) ? $value->count_extension: ""?></td>
            <td><?= !empty($value->reason1) ? $value->reason1: ""?></td>
            <td><?= !empty($value->approve_extension_by) ? $value->approve_extension_by: ""?></td>
          </tr>
        <?php } }?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="renewal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve">Xác nhận gia hạn</h5>
        <hr>


        <div class="form-group">
    <!-- <label>Ghi chú:</label>
    <textarea class="form-control approve_note" rows="5" ></textarea>
    <input type="hidden"   class="form-control status_approve">
    <input type="hidden"   class="form-control contract_id"> -->
  </div>
        </table>
        <p class="text-right">
          <button  id="renewal_continues"   class="btn btn-danger">Xác nhận</button>
        </p>
      </div>

    </div>
  </div>
</div>
