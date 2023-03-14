<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>Danh sách SMS
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh sách SMS</a>
            </small>
          </h3>
        </div>
 
      </div>
    </div>

    <?php function get_type($id_type)
    {
      switch ($id_type) {
        case '1':
        return "Sản phẩm/ Dịch vụ";
             break;
        case '2':
        return  "Về khoản vay";
           break;
        case '3':
          return "Thanh toán khoản vay";
           break;
    }

    }
    if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">

              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Mã phiếu ghi</th>
                      <th>Mã hợp đồng</th>
                       <th>Họ và tên</th>
                      <th>Số điện thoại</th>
                      <th>Nội dung</th>
                      <th>Ngày tạo</th>
                      <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                         <th>Chi tiết</th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($smsData)) {
                        $stt = 0;
                        foreach($smsData as $key => $sms){
                       $stt++;
                    

                    ?>
                    <tr class='sms_<?= !empty($sms->_id->{'$oid'}) ? $sms->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
  
                      <td><?= !empty($sms->code_contract) ?  $sms->code_contract : ""?><br>
                        </td>
                      <td><?= !empty($sms->code_contract_disbursement) ?  $sms->code_contract_disbursement : ""?><br>
                       Kỳ trả: <?= !empty($sms->ky_tra) ?  $sms->ky_tra : ""?><br>
                       Ngày kỳ trả: <?= !empty($sms->ngay_ky_tra) ?  $sms->ngay_ky_tra : ""?><br>
                      Số ngày chậm trả: <?= !empty($sms->so_ngay_cham_tra) ?  $sms->so_ngay_cham_tra : 0?><br></td>
                       <td><?= !empty($sms->customer_name) ?  $sms->customer_name : ""?></td>
                        <td><?= !empty($sms->phone_number) ?  $sms->phone_number : ""?></td>
                          <td><?= !empty($sms->content) ?  $sms->content : ""?></td>
                      <td><?= !empty($sms->created_at) ? date('d-m-Y H:i:s',(int)$sms->created_at) : ""?></td>
                       <td><?= !empty($sms->send_time) ? date('d-m-Y H:i:s',(int)$sms->send_time) : ""?></td>
                      <td>
                        <?= !empty($sms->status) ?  $sms->status : ""?>
                      </td>
                     <td><a class="btn btn-primary" target="_blank"
                                   href="<?php echo base_url("accountant/view_v2?id=") . $sms->id_contract ?>">
                                  Xem Chi tiết
                                </a>
                                  <br/>
                                <a class="btn btn-warning" target="_blank"
                                   href="<?php echo base_url("transaction/list_kt?tab=all&code_contract=") . $sms->code_contract ?>">
                                  Chi tiết phiếu thu
                                </a>
                              </td>
              
                 

                    </tr>
                  <?php } }?>

                </tbody>
              </table>
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
<script src="<?php echo base_url();?>assets/js/sms/index.js"></script>


<style type="text/css">
  .w-25 {
    width: 8%!important;
}
</style>
