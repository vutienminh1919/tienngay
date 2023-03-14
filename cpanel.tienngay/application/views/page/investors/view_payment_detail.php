   
<div class="right_col" role="main">
  <div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử Lý...</span>
  </div>
<?php 
         function get_type_payment($type)
                {
                  switch ($type) {
                    case '1':
                    return "Tiền mặt";
                         break;
                    case '2':
                    return  "Chuyển khoản";
                       break;
                    
                }
                }
                ?>
  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
          Thanh toán nhà đầu tư
          <br>
          <small>
            <a href="#"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('investors/view_payment')?>"><?php echo $this->lang->line('investors_list')?></a> / 
         <a href="#">Thanh toán nhà đầu tư</a> </small>
        </h3>
      </div>
     

    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
  
    <div class="x_panel">

      <div class="x_content">
        <div class="row">
          <div class="col-xs-12">
            <div class="table-responsive">
    <table class="table table-striped">
    <tbody>
         <tr>
             <td> <strong> <?= !empty($contract->code_contract_disbursement) ?  'Mã hợp đồng: '.$contract->code_contract_disbursement :  'Mã phiếu ghi: '.$contract->code_contract  ?></strong> </td>
            <td> Tiền gốc phải trả đến hạn:<strong> <?= !empty($contract->tong_tien_goc_da_tra) ?  number_format( $contract->tong_tien_goc_den_han-$contract->tong_tien_goc_da_tra) :  number_format( $contract->tong_tien_goc_den_han) ?></strong> </td>
            
        </tr>
        <tr>
             
            <td> Nhà đầu tư:<strong> <?= !empty($contract->investors_info) ?   $contract->investors_info->name : ""?></strong> </td>
            <td>Tiền lãi phải trả đến hạn:<strong> <?= !empty($contract->tong_tien_lai_da_tra) ?  number_format( $contract->tong_tien_lai_den_han-$contract->tong_tien_lai_da_tra) : number_format( $contract->tong_tien_lai_den_han) ?></strong> </td>
            
        </tr>
        <tr>
          
            <td> Gốc phải trả NĐT:<strong> <strong> <?= !empty($contract->tong_tien_goc_den_han) ?  number_format( $contract->tong_tien_goc_den_han) : "0"?></strong> </td>
            <td> Gốc đã trả:<strong> <?= !empty($contract->tong_tien_goc_da_tra) ?  number_format( $contract->tong_tien_goc_da_tra) : "0"?></strong> </td>
        </tr>
        <tr>
             
            <td> Số lãi phải trả NĐT: <strong><?= !empty($contract->tong_tien_lai_den_han) ?  number_format( $contract->tong_tien_lai_den_han) : "0"?></strong> </td>
            <td> Số lãi đã trả: <strong><?= !empty($contract->tong_tien_lai_da_tra) ?  number_format( $contract->tong_tien_lai_da_tra) : "0"?></strong> </td>
        </tr>
        <tr>
            <td colspan="2"> Số còn lại phải trả NĐT đến thời điểm đáo hạn: <strong><?= !empty($contract->tong_tien_con_lai_dao_han) ?  number_format( $contract->tong_tien_con_lai_dao_han) : "0"?></strong> </td>
        </tr>
        <tr>
            <td class="p-0" colspan="2">
                <div class="page-title">
                    <div class="title_left">
                        <h5> Chi tiết thanh toán cho NĐT</h5></div>
                    <div class="title_right text-right"><a href="#" data-toggle="modal" data-id="<?= !empty($contract->code_contract) ?   $contract->_id->{'$oid'} : ""?>" data-gocdenhan="<?= !empty($contract->tong_tien_goc_den_han) ?   $contract->tong_tien_goc_den_han : "0"?>" data-laidenhan="<?= !empty($contract->tong_tien_lai_den_han) ?   $contract->tong_tien_lai_den_han : "0"?>"  data-target="#updateModal" class="modal_cttt_ndt btn btn-info "> Thanh toán </a></div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kỳ</th>
                            <th>Kỳ hạn</th>
                            <th>Số tiền phải trả mỗi kỳ</th>
                            <th>Số tiền đã trả</th>
                            <th>Số còn lại phải trả NĐT</th>
                        </tr>
                    </thead>
                    <tbody class="data_cttt">
                      <?php 
                    if(!empty($temData)) {
                        $stt = 0;
                        $lai_ky=0;
                        foreach($temData as $key => $tem){
                        
                            $stt++;
                    $lai_ky=$tem->lai_ky;
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?= !empty($tem->ky_tra) ?  number_format($tem->ky_tra) : ""?></td>
                            <td><?= !empty($tem->ngay_ky_tra) ? date('d/m/Y',  $tem->ngay_ky_tra ) : ""?></td>

                            <td> Tiền gốc: <?= !empty($tem->tien_goc_1ky) ?  number_format($tem->tien_goc_1ky) : "0"?>
                                <br> Tiền lãi: <?= !empty($lai_ky) ?  number_format($lai_ky) : "0"?>
                                <br> Tổng: <?= isset($tem->tien_goc_1ky) ?  number_format($lai_ky+$tem->tien_goc_1ky) : "0"?> </td>
                            <td> Tiền gốc: <?= !empty($tem->lich_su_tra_ndt_thu) ?  number_format($tem->lich_su_tra_ndt_thu->tien_goc_1ky_da_tra) : "0"?>
                                <br> Tiền lãi: <?= !empty($tem->lich_su_tra_ndt_thu) ?  number_format($tem->lich_su_tra_ndt_thu->tien_lai_1ky_da_tra) : "0"?>
                                <br> Tổng: <?= isset($tem->lich_su_tra_ndt_thu) ?  number_format($tem->lich_su_tra_ndt_thu->tien_lai_1ky_da_tra+$tem->lich_su_tra_ndt_thu->tien_goc_1ky_da_tra) : "0"?> </td>
                            <td> Tiền gốc: <?= !empty($tem->lich_su_tra_ndt_thu) ?  number_format($tem->lich_su_tra_ndt_thu->tien_goc_1ky_con_lai) : "0"?>
                                <br> Tiền lãi: <?= !empty($tem->lich_su_tra_ndt_thu) ?  number_format($tem->lich_su_tra_ndt_thu->tien_lai_1ky_con_lai) : "0"?>
                                <br> Tổng: <?= isset($tem->lich_su_tra_ndt_thu) ?  number_format(($tem->lich_su_tra_ndt_thu->tien_goc_1ky_con_lai)+($tem->lich_su_tra_ndt_thu->tien_lai_1ky_con_lai)) : "0"?></td>
                        </tr>
                          <?php }} ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr id="history1">
            <td class="p-0" colspan="2">
                <h5> Lịch sử trả lãi</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Thời gian thanh toán</th>
                        <th>Mã giao dịch</th>
                        <th>Số tiền gốc</th>
                        <th>Số tiền lãi</th>
                        <th>Hình thức thanh toán</th>
                    <!--     <th>Nguồn tiền trả gốc vay</th>
                        <th>Hình thức trả</th> -->
                        <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                    if(!empty($tranData)) {
                        $stt = 0;
                        $lai_ky=0;
                        foreach($tranData as $key => $tem){
                            $stt++;                     
                    ?>
                    <tr>
                    <td><?php echo $stt ?></td>
                    <td><?= !empty($tem->date_pay) ? date('d/m/Y',  $tem->date_pay ) : ""?></td>
                    <td><?= !empty($tem->ma_giao_dich_ngan_hang) ?  $tem->ma_giao_dich_ngan_hang : ""?></td>
                    <td> <?= !empty($tem->so_tien_goc_da_tra) ?  number_format($tem->so_tien_goc_da_tra) : "0"?></td>
                     <td> <?= !empty($tem->so_tien_lai_da_tra) ?  number_format($tem->so_tien_lai_da_tra) : "0"?></td>
                    <td><?= !empty($tem->hinh_thuc_tra) ?  get_type_payment($tem->hinh_thuc_tra) : ""?></td>
                    <td><?= !empty($tem->ghi_chu) ?  $tem->ghi_chu : ""?></td>
                        </tr>
                          <?php }}?>
                       
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
     </div>
    </div>
  </div>
</div>
 </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Thanh toán cho nhà đầu tư</h5>

      </div>
       <input type="hidden" name="id_contract" class="form-control " value="">
      <div class="modal-body">
            <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
  
        <div class="form-group">
          <label>Ngày trả:</label>
          <input type="date" name="ngay_tra" class="form-control">
        </div>
       
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phương thức</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <div class="form-check" style="padding-top:8px;">
            <input class="form-check-input" type="radio" name="payment_method" value="1" checked="">
            <label class="form-check-label" for="moneyoption_cast">
              Tiền mặt
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="2">
            <label class="form-check-label" for="moneyoption_banktransfer">
              Chuyển khoản
            </label>
          </div>
        </div>
      </div>
       <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>Số tiền gốc đến hạn:</label>
          <input type="text" name="so_tien_goc_den_han" disabled class="form-control">
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <label>Số tiền gốc đã trả:</label>
          <input type="text" name="so_tien_goc_da_tra" class="so_tien_goc_da_tra form-control">
      </div>
        </div>
        <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>Số tiền lãi đến hạn:</label>
          <input type="text" name="so_tien_lai_den_han" disabled class="form-control">
       </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <label>Số tiền lãi đã trả:</label>
          <input type="text" name="so_tien_lai_da_tra" class="so_tien_lai_da_tra form-control">
        </div>
        </div>
              <div class="form-group">
          <label>Mã Giao dịch ngân hàng:</label>
         <input type="text" name="ma_giao_dich_ngan_hang" class="form-control">
        </div>
              <div class="form-group">
          <label>Ghi chú:</label>
          <textarea class="form-control" name="ghi_chu" rows="5"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button"  class="btn btn-primary update_detail_payment">Cập nhật</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url();?>assets/js/investors/index.js"></script>