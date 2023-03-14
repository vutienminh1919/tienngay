<!-- page content -->

<div class="right_col" role="main">
  <div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử Lý...</span>
  </div>

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
         <?php 
         function get_type_interest($type)
                {
                  switch ($type) {
                    case '1':
                    return "Lãi hàng tháng, gốc hàng tháng";
                         break;
                    case '2':
                    return  "Lãi hàng tháng gốc cuối kỳ";
                       break;
                    
                }
                }
           function get_status($status)
                {
                  switch ($status) {
                    case '1':
                    return "Mới";
                         break;
                    case '2':
                    return  "Chờ trưởng PGD duyệt";
                       break;
                    case '3':
                    return "Đã hủy";
                         break;
                    case '4':
                    return  "Trưởng PGD không duyệt";
                       break;
                    case '5':
                    return "Chờ hội sở duyệt";
                         break;
                    case '6':
                    return  "Đã duyệt";
                       break;
                    case '7':
                    return "Kế toán không duyệt";
                         break;
                    case '15':
                    return  "Chờ giải ngân";
                       break;
                    case '16':
                    return "Đã tạo lệnh giải ngân thành công";
                         break;
                    case '17':
                    return  "Đang vay";
                       break;
                    case '18':
                    return "Giải ngân thất bại";
                         break;
                    case '19':
                    return  "Đã tất toán";
                       break;
                    case '20':
                    return "Đã quá hạn";
                         break;
                    case '21':
                    return  "Chờ hội sở duyệt gia hạn";
                       break;
                    case '22':
                    return "Chờ kế toán duyệt gia hạn";
                         break;
                    case '23':
                    return  "Đã gia hạn";
                       break;
                    case '24':
                    return "Chờ kế toán xác nhận";
                         break;
                   
                    
                }
                }
 ?> 
  Thanh toán nhà đầu tư
          <br>
          <small>
            <a href="#"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('investors/listInvestors')?>"><?php echo $this->lang->line('investors_list')?></a> / 
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
              <table class="table table-striped" id="datatable-buttons">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Mã HĐ</th>
                    <th>Mã phiếu ghi</th>
                    <th>Nhà đầu tư</th>
                    <th>Số tiền vay</th>
                    <th>Hình thức vay</th>
                    <th>Số tiền gốc đến hạn</th>
                    <th>Số tiền lãi đến hạn</th>
                    <th>Hạn thanh toán</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>

                <tbody>
                  <!-- <tr>
                  <td colspan="13" class="text-center">Không có dữ liệu</td>
                </tr> -->
               <?php 
                    if(!empty($contractData)) {
                        $stt = 0;
                        foreach($contractData as $key => $contract){
                            
                            $stt++;
                      //var_dump($contract); die;
                    ?>
                  <tr>
                   <td><?php echo $stt ?></td>
                    <td><?= !empty($contract->code_contract_disbursement) ?  $contract->code_contract_disbursement : ""?></td>
                      <td><?= !empty($contract->code_contract) ?  $contract->code_contract : ""?></td>
                    <td><?= !empty($contract->ten_nha_dau_tu) ?  $contract->ten_nha_dau_tu : ""?></td>
                    <td>
                      Số tiền vay: <?= !empty($contract->loan_infor->amount_money) ?  number_format( $contract->loan_infor->amount_money) : ""?>
                      <br> Thời gian: <?= !empty($contract->loan_infor->number_day_loan) ?  $contract->loan_infor->number_day_loan : ""?> ngày
                     
                      <br>
                    </td>

                    <td>
                     <br> Hình thức trả lãi: <?= !empty($contract->loan_infor->type_interest) ?  get_type_interest($contract->loan_infor->type_interest) : ""?>
                    </td>
              
                   
                    <td> <?= !empty($contract->tong_tien_goc_den_han) ?  number_format(round( (float)$contract->tong_tien_goc_den_han)) : ""?></td>
                    <td> <?= !empty($contract->tong_tien_lai_den_han) ?  number_format($contract->tong_tien_lai_den_han) : ""?></td>
                      <td><?= !empty($contract->ngay_ky_tra) ?   date('d/m/Y', $contract->ngay_ky_tra): ""?></td>
                    <td>
                      <a class="btn btn-info " href="<?php echo base_url('investors/view_detail_payment?id='. $contract->_id->{'$oid'})?>" ></i> Chi tiết</a>
                    </td>
                  </tr>
                  <!-- <tr id="thedetail<?= $stt?>" class="d-none">
                   
                  </tr> -->
                <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /page content -->

<!-- Modal -->
