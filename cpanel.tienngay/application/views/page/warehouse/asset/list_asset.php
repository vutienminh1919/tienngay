<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">

<!-- page content -->
<div class="right_col" role="main">
  <div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử lý...</span>
  </div>
  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $this->lang->line('asset_list')?> <?= (isset($_GET['ten_kho'])) ? '/ Kho: '.$_GET['ten_kho'] : ''; ?>
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#"><?php echo $this->lang->line('asset_list')?></a>
            </small>
          </h3>
        </div>
    
      </div>
    </div>

    <?php 
    function get_tt_tai_san($id)
    {
      switch ($id) {
        case '1':
        return "Đang cầm cố";
             break;
        case '2':
        return  "Cần trả khách";
           break;
        case '3':
        return  "Đã trả khách";
           break;
        case '4':
        return  "Cần thanh lý";
           break;
        case '5':
        return  "Đã thanh lý";
           break;
    }
  }
     function get_tt_contract($id)
    {
      switch ($id) {
        case '1':
        return "Mới";
             break;
        case '2':
        return  "Chờ phòng giao dịch mới";
           break;
        case '3':
        return  "Đã hủy";
           break;
        case '4':
        return  "Trưởng PGD không duyệt";
           break;
        case '5':
        return  "Chờ hội sở duyệt";
           break;
        case '6':
        return "Đã duyệt";
             break;
        case '7':
        return  "Kế toán không duyệt";
           break;
        case '15':
        return  "Chờ giải ngân";
           break;
        case '16':
        return  "Đã tạo lệnh giải ngân thành công";
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
        return  "Đã quá hạn";
           break;
        case '21':
        return  "Chờ hội sở duyệt gia hạn";
           break;
        case '22':
        return  "Chờ kế toán duyệt gia hạn";
           break;
        case '23':
        return  "Đã gia hạn";
           break;
        case '24':
        return  "Chờ kế toán xác nhận";
           break;
    }
  }
    function get_tt_trong_kho($id)
    {
      switch ($id) {
        case '1':
        return "Cần nhập kho";
             break;
        case '2':
        return  "Đã nhập kho";
           break;
        case '3':
        return "Cần xuất kho";
             break;
        case '4':
        return  "Đã xuất kho";
           break;
    }
    }
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">
                 <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Mã HĐ</th>
                      <th>Mã người vay<br>(Lấy CMND.CCCD)</th>
                      <th>Loại tài sản</th>
                      <th>Tên tài sản</th>
                      <th>Mã kho</th>
                      <th>Trạng thái hồ sơ vay</th>
                      <th>Trạng thái tài sản</th>
                      <th>Trạng thái trong kho</th>
                  
                      <th><?php echo $this->lang->line('Function')?></th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($assetData)) {
                        $stt = 0;
                        foreach($assetData as $key => $asset){
                          if(isset($_GET['ma_kho']))
                          {
                            $contract_id=[];
                            foreach ($warehouse_assetData as $key => $value) {
                              if($_GET['ma_kho']==$value->id_warehouse)
                              $contract_id[]=$value->id_contract;
                            }
                            if( !in_array($asset->_id->{'$oid'}, $contract_id))
                            continue;
                          }
                            if($asset->status != 'block'){
                            $stt++;
                           
                    ?>
                    <tr class='asset_<?= !empty($asset->_id->{'$oid'}) ? $asset->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
  
                    <td><?= !empty($asset->code_contract) ?  $asset->code_contract : ""?></td>
                    <td><?= !empty($asset->customer_infor->customer_identify) ?  $asset->customer_infor->customer_identify : ""?></td>
                    <td><?= !empty($asset->loan_infor->type_property->text) ?  $asset->loan_infor->type_property->text : ""?></td>
                    <td><?= !empty($asset->loan_infor->name_property->text) ?  $asset->loan_infor->name_property->text : ""?></td>
                  <?php  $i=0;
                   if(!empty($warehouse_assetData)) {
                    
                      foreach($warehouse_assetData as $key => $warehouse_asset){
                            if($asset->_id->{'$oid'} == $warehouse_asset->id_contract){ ++$i; ?>
                    <td><?= !empty($warehouse_asset->code_warehouse) ?  $warehouse_asset->code_warehouse : ""; ?></td>
                    <td><?= !empty($asset->status) ?  get_tt_contract($asset->status) : "";?></td>
                    <td><?= !empty($warehouse_asset->trang_thai_tai_san) ? get_tt_tai_san($warehouse_asset->trang_thai_tai_san) : "" ;?></td>
                     <td><?= !empty($warehouse_asset->trang_thai_trong_kho) ? get_tt_trong_kho($warehouse_asset->trang_thai_trong_kho) : "";?></td>
                       <?php  }}   
                     }
                     if($i==0 || empty($warehouse_assetData) ){

                     ?> 
                     <td></td>
                    <td></td>
                    <td>Đang cầm cố</td>
                    <td>Không ở trong kho</td>
                     
                   <?php } ?>
                      <td>
              <span  data-toggle="modal"  data-codecontract="<?php echo $asset->code_contract ?>" data-id="<?php echo $asset->_id->{'$oid'} ?>" data-ten_tai_san="<?php echo $asset->loan_infor->name_property->text ?>" data-target="#nhapkhoModal"  class="btn btn-primary yeu_cau_nhap"  >
                 Yêu cầu nhập kho
              </span>
              <span class="btn btn-primary xac_nhan_nhap"  data-id="<?php echo $asset->_id->{'$oid'} ?>">
                 Xác nhận nhập kho
              </span>
               <a class="btn btn-primary"  href="<?php echo base_url("warehouse/print_phieu_nhap?id=").$asset->_id->{'$oid'}?>" target="_blank">
                 In phiếu nhập
              </a>
						  <a class="btn btn-primary"  href="<?php echo base_url("warehouse/detailAsset?id=").$asset->_id->{'$oid'}?>">
							   Chi tiết
						  </a>
               
						  <span class="btn btn-primary yeu_cau_xuat"   data-id="<?php echo $asset->_id->{'$oid'} ?>">
                 Yêu cầu xuất kho
              </span>
                 <span class="btn btn-primary xac_nhan_xuat"   data-id="<?php echo $asset->_id->{'$oid'} ?>">
                 Xác nhận xuất kho
              </span>
                <a class="btn btn-primary"  href="<?php echo base_url("warehouse/print_phieu_xuat?id=").$asset->_id->{'$oid'}?>"  target="_blank">
                 In phiếu xuất
              </a>
                <a class="btn btn-primary"  href="<?php echo base_url("warehouse/print_bb_ban_giao?id=").$asset->_id->{'$oid'}?>"  target="_blank">
                 In BB bàn giao
              </a>
               <span class="btn btn-primary xac_nhan_tra_khach"   data-id="<?php echo $asset->_id->{'$oid'} ?>">
                 Xác nhận trả khách
              </span>
              <span class="btn btn-primary xac_nhan_thanh_ly"   data-id="<?php echo $asset->_id->{'$oid'} ?>">
                 Xác nhận thanh lý
              </span>
                      </td>
                      <!-- Modal HTML -->
                        <div id="detele_<?php echo $asset->_id->{'$oid'}?>" class="modal fade">
                            <div class="modal-dialog modal-confirm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="icon-box danger">
                                            <!-- <i class="fa fa-times"></i> -->
                                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                                        </div>
                                    
                                        <h4 class="modal-title"><?php echo $this->lang->line('title_delete')?>?</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo $this->lang->line('body_modal_delete')?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $this->lang->line('cancel')?></button>
                                        <!-- <button type="button" class="btn btn-danger">Danger</button> -->
                                <!--     <button type="button" data-id="<?= !empty($asset->_id->{'$oid'}) ? $asset->_id->{'$oid'} : ""?>" class="btn btn-success delete_asset" data-dismiss="modal"><?php echo $this->lang->line('ok')?></button> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </tr>
                  <?php } }}?>

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
<!-- Modal -->
<div class="modal fade" id="nhapkhoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel"></h5>

      </div>
       <input type="hidden" name="id_contract" class="form-control " value="">
      
      <div class="modal-body">
            <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
        <div class="form-group">
          <label>Mã hợp đồng:</label>
          <input type="text" disabled class="form-control" name="code_contract" ></textarea>
        </div>
        <div class="form-group">
          <label>Tài sản:</label>
          <input type="text" name="ten_tai_san" disabled class="form-control">
        </div>
        <div class="form-group">
          <label>Kho hàng:</label>
            <select class="form-control"  name="ma_kho"  id="selectize_province">
                  <option value="">Chọn người kho hàng</option>
                  <?php 
                    if(!empty($warehouseData)){
                      foreach($warehouseData as $key => $warehouse){
                  ?>
                      <option  value="<?= !empty($warehouse->_id->{'$oid'}) ? $warehouse->_id->{'$oid'} : "" ?>"><?= !empty($warehouse->name) ? $warehouse->name : "";?> - <?= !empty($warehouse->address) ? $warehouse->address : "";?></option>
                      <?php }}?>
                  </select>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button"  class="btn btn-primary nhap_kho">Gửi yêu cầu</button>
      </div>
    </div>
  </div>
</div>

<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/warehouse/index.js"></script>
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>

<style type="text/css">
  .w-25 {
    width: 8%!important;
}
</style>
 <script>
  $(document).on("click", "span.yeu_cau_nhap", function () {

    var code_contract = $(this).data('codecontract'); 
    var ten_tai_san = $(this).data('ten_tai_san');
    var title= 'Yêu cầu nhập kho cho hợp đồng '+ code_contract; 
    var id = $(this).data('id'); 
    $("input[name='id_contract']").val(id);
    $("input[name='ten_tai_san']").val(ten_tai_san);
    $('#exampleModalLabel').text(title); 
    $("input[name='code_contract']").val(code_contract); 
 
});
</script>
<script>
$(document).ready(function () {

   set_switchery();
    function set_switchery() {
        $(".aiz_switchery").each(function () {
            new Switchery($(this).get(0), {
                color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'});
            var changeCheckbox = $(this).get(0);
            var id = $(this).data('id');
           
            changeCheckbox.onchange = function () {
                $.ajax({url: _url.base_url +'asset/doUpdateStatusWarehouse?id='+id+'&status='+ changeCheckbox.checked,
                    success: function (result) {
                      console.log(result);
                        if (changeCheckbox.checked == true) {
                            $.activeitNoty({
                                type: 'success',
                                icon: 'fa fa-check',
                                message: result.message ,
                                container: 'floating',
                                timer: 3000
                            });
                           
                        } else {
                            $.activeitNoty({
                                type: 'danger',
                                icon: 'fa fa-check',
                                message: result.message,
                                container: 'floating',
                                timer: 3000
                            });
                           
                        }
                    }
                });
            };
        });
    }
    });
</script>