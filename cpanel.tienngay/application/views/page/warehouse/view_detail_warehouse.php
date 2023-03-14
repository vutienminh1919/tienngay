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
    echo $this->lang->line('warehouse_view_detail')?>: <?=$warehouse->name?> 
          <br>
          <small>
            <a href="#"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('warehouse/listWarehouse')?>"><?php echo $this->lang->line('warehouse_list')?></a> / <a href="#"><?php echo $this->lang->line('warehouse_view_detail')?></a>
          </small>
        </h3>
      </div>
      <div class="title_right text-right">
        <a href="<?php echo base_url('warehouse/listWarehouse')?>" class="btn btn-info ">
          <i class="fa fa-hand-o-left" aria-hidden="true"></i> Quay lại
        </a>
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
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Mã tài sản</th>
                    <th>Mã HĐ</th>
                    <th>Mã người vay<br>
                    (Lấy CMND.CCCD)</th>
                    <th>Loại tài sản</th>
                    <th>Tên tài sản</th>
                    <th>Mã kho</th>
                    <th>Tình trạng<br> tài sản</th>
                    <th>Trạng thái <br>hồ sơ vay</th>
                    <th>Trạng thái<br> tài sản</th>
                    <th>Trạng thái<br> trong kho</th>
                    <th>Chức năng</th>
                    
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
                    <td><?= !empty($contract->code_contract) ?  $contract->code_contract : ""?></td>
                    <td><?= !empty($contract->customer_infor->customer_name) ?  $contract->customer_infor->customer_name : ""?></td>
                    <td>
                      Số tiền vay: <?= !empty($contract->loan_infor->amount_money) ?  number_format( $contract->loan_infor->amount_money) : ""?>đ
                      <br> Thời gian: <?= !empty($contract->loan_infor->number_day_loan) ?  $contract->loan_infor->number_day_loan : ""?> ngày
                      <br> Hình thức trả lãi: <?= !empty($contract->loan_infor->type_interest) ?  get_type_interest($contract->loan_infor->type_interest) : ""?>
                      <br>
                    </td>

                    <td>
                      Ngày giải ngân: <?= !empty($contract->disbursement_date) ?   date('d/m/Y', $contract->disbursement_date): ""?>
                      <br> Ngày đáo hạn: <?= !empty($contract->expire_date) ?   date('d/m/Y', $contract->expire_date): ""?>
                    </td>
              
                   
                    <td><?= !empty($contract->fee->percent_interest_investor) ?  $contract->fee->percent_interest_investor : ""?>%</td>
                    <td><?= !empty($contract->status) ?  get_status($contract->status) : ""?></td>
                    <td>
                      <a href="#" class="toggleTheDetail" data-code_contract="<?= !empty($contract->code_contract) ?  $contract->code_contract : ""?>" data-stt="<?=$stt?>" data-target="thedetail-<?php echo $i?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chi tiết</a>
                    </td>
                  </tr>
                  <tr id="thedetail<?= $stt?>" class="d-none">
                   
                  </tr>
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
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel"></h5>

      </div>
       <input type="hidden" name="id" class="form-control " value="">
       <input type="hidden" name="code_contract" class="form-control " value="">
       <input type="hidden" name="stt" class="form-control " value="">
      <div class="modal-body">
            <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
        <div class="form-group">
          <label>Nguồn tiền trả gốc vay:</label>
          <textarea class="form-control" name="nguon_tien_tra_goc_vay" rows="5"></textarea>
        </div>
        <div class="form-group">
          <label>Ngày trả:</label>
          <input type="date" name="ngay_tra" class="form-control">
        </div>
        <div class="form-group">
          <label>Số tiền lãi đã trả:</label>
          <input type="number" name="so_tien_lai_da_tra" class="form-control">
        </div>
         <div class="form-group">
          <label>Số tiền gốc đã trả:</label>
          <input type="number" name="so_tien_goc_da_tra" class="form-control">
        </div>
        <div class="form-group">
          <label>Hình thức trả:</label>
          <input type="text" name="hinh_thuc_tra" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button"  class="btn btn-primary update_detail_payment">Cập nhật</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url();?>assets/js/warehouse/index.js"></script>
