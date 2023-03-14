<!-- Modal yêu cầu cơ cấu -->
<div id="cocauhopdongModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title title_modal_approve_cc">Yêu cầu cơ cấu</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        
          <div class="col-xs-12 col-md-6">
            <h4>
              <i class="fa fa-files-o"></i>
              Chi tiết giao dịch
            </h4>
            <hr class="mt-0">

            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    Mã hợp đồng gốc:
                  </td>
                  <td>
               <span id="cc_ma_hop_dong"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Hình thức vay:
                  </td>
                  <td>
                     <span id="cc_hinh_thuc_vay"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Loại tài sản:
                  </td>
                  <td>
                     <span id="cc_loai_tai_san"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Số tiền được vay
                  </td>
                  <td>
                    <span id="cc_so_tien_duoc_vay"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Hình thức trả lãi
                  </td>
                  <td>
                     <span id="cc_hinh_thuc_tra_lai"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Thời gian vay
                  </td>
                  <td>
                   <span id="cc_thoi_gian_vay"></span>
                  </td>
                </tr>
                 <tr>
                  <td>
                   <a class="lich_su_hoat_dong_gh_cc"> Lịch sử hoạt động </a>
                  </td>
                  <td>
                  </td>
                </tr>
                  <tr>
                  <td>
                    Tài liệu xác thực:<span class="text-danger">(*)</span>
                  </td>
                  <td>
                 
          
    

                  </td>
                </tr>
                
              </tbody>
            </table>
           
          </div>


          <div class="col-xs-12 col-md-6">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                  <h4>
                    <i class="fa fa-files-o"></i>
                    THÔNG TIN CƠ CẤU

                  </h4>

                </div>
                <div class="col-xs-12 col-md-6 text-right">
                  <a href="#" target='_blank' id="xem_chi_tiet_co_cau" target="_blank" >
                    Xem chi tiết  |
                  </a>
                  <a href="#" id="ds_hop_dong_cc">
                    DS Hợp đồng cơ cấu
                  </a>
                </div>
              </div>
            <hr class="mt-0">

            <table class="table table-borderless">
              <tbody>
               
                <tr>
                  <td>
                    Hình thức cho vay <span class="text-danger">(*)</span>
                  </td>
                <td>
              <select id="type_loan_cc" class="form-control" name="">
                 
                    <option value="DKX" >Cho vay</option>
                    <!-- <option value="CC" >Cầm cố</option>
                    <option value="TC" >Tín chấp</option> -->
                 
                </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    Thời gian vay <span class="text-danger">(*)</span>
                  </td> 
                  <td>
                      <select class="form-control w-100" id="number_day_loan_cc">
          <option value="">-- Chọn thời gian vay --</option> 
          <option value="1"  > 
            1 tháng
          </option>
          <option value="3" >
            3 tháng
          </option>
          <option value="6" >
            6 tháng
          </option>
          <option value="9" >
            9 tháng
          </option>
          <option value="12" >
            12 tháng
          </option>
          <option value="18" >
            18 tháng
          </option>
          <option value="24" >
            24 tháng
          </option>
        </select>
                
                  </td>
                </tr>
              <tr>
                  <td>
                    Số tiền được vay <span class="text-danger">(*)</span> 
                  </td>
                  <td>
                    <input type="text" value="0"  id="amount_money_cc" class="form-control number" >
                  </td>
                </tr>
              
                <tr>
                  <td>
                    Hình thức trả lãi <span class="text-danger">(*)</span> 
                  </td>
                  <td>
                    <select class="form-control district_shop"  id="type_interest_cc">
           
                       
                        <option value="">Chọn hình thức trả lãi</option>
                        <?php foreach(type_repay() as $key => $value){ ?>
                            <option  value="<?=$key?>"><?= $value ?></option> 
                            <?php } ?>
                      </select>
                    </td>
                  </tr>

                <tr>
                  <td>
                    Ngoại lệ <span class="text-danger">(*)</span>
                  </td>
                  <td>
                    <select id="exception_cc" class="form-control" name=""
                  >
                  <?php foreach (gh_cc_exception() as $key => $item) { ?>
                    <option value="<?= $key ?>" ><?= $item ?></option>
                  <?php } ?>
                </select>
                  </td>
                </tr>

              

                <tr>
                  <td style="vertical-align:top !important;">
                    Ghi chú/Note
                  </td>
                  <td>
                    <textarea class="form-control" id="approve_note_cc" rows="4" placeholder="Nhập lưu ý"></textarea>
                   
                    

                  </td>
                </tr>
              </tbody>
            </table>
       
          </div>
           <div class="col-md-12 col-xs-12">
            <div id="SomeThing" class="simpleUploader">
              <div class="uploads" id="uploads_img_file_cc">

              </div>
              <label for="uploadinput_cc" id="addup_cc">
                <div class="block uploader">
                  <span>+</span>
                </div>
              </label>
              <input id="uploadinput_cc" type="file" name="file" data-contain="uploads_img_file_cc"
                   data-title="Hồ sơ trả về" multiple data-type="img_file" class="focus">
            </div>
          </div>
        </div>
        <div class="row flex warning_send_gh_cc" style="justify-content: center" >
          <div class="col-xs-6 col-lg-6">
  <div class="alert alert-warning center" role="alert" >
        <p class="text_waring_gh_cc"></p>
     
        <a class="link_payment_gh_cc"> </a>
    </div>
  </div>
</div>
      </div>
      <div class="modal-footer">
        <input type="hidden" class="form-control contract_id_cc">
         <input type="hidden" class="form-control status_approve_cc">
          <input type="hidden" class="form-control status_contract_cc">
          <input type="hidden" class="form-control amount_debt_cc">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
         <button type="button" class="btn btn-danger cancel_submit_cc" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-info return_submit_cc" data-dismiss="modal">Trả về</button>
        <button type="button" class="btn btn-primary approve_submit_cc">Gửi</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal yêu cầu gia hạn -->
<div id="giahanhopdongModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title title_modal_approve_gh">Yêu cầu gia hạn</h4>
      </div>
      <div class="modal-body">
        
     <div class="row">
          <div class="col-xs-12 col-md-6">
            <h4>
              <i class="fa fa-files-o"></i>
              Chi tiết giao dịch
            </h4>
            <hr class="mt-0">

            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    Mã hợp đồng gốc:
                  </td>
                  <td>
               <span id="gh_ma_hop_dong"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Hình thức vay:
                  </td>
                  <td>
                     <span id="gh_hinh_thuc_vay"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Loại tài sản:
                  </td>
                  <td>
                     <span id="gh_loai_tai_san"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Số tiền được vay
                  </td>
                  <td>
                    <span id="gh_so_tien_duoc_vay"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Hình thức trả lãi
                  </td>
                  <td>
                     <span id="gh_hinh_thuc_tra_lai"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Thời gian vay
                  </td>
                  <td>
                   <span id="gh_thoi_gian_vay"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                   <a class="lich_su_hoat_dong_gh_cc"> Lịch sử hoạt động </a>
                  </td>
                  <td>
                  </td>
                </tr>
                  <tr>
                  <td>
                    Tài liệu xác thực: <span class="text-danger">(*)</span>
                  </td>
                  <td>
                 
         
    

                  </td>
                </tr>
                
              </tbody>
            </table>
              
          </div>


          <div class="col-xs-12 col-md-6">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                  <h4>
                    <i class="fa fa-files-o"></i>
                    THÔNG TIN GIA HẠN

                  </h4>

                </div>
                <div class="col-xs-12 col-md-6 text-right">
                  <a href="#" target='_blank' id="xem_chi_tiet_gia_han" target="_blank" >
                    Xem chi tiết  |
                  </a>
                  <a href="#" id="ds_hop_dong_gh">
                    DS Hợp đồng gia hạn
                  </a>
                </div>
              </div>
            <hr class="mt-0">

            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    Thời gian vay <span class="text-danger">(*)</span>
                  </td>
                  <td>
                      <select class="form-control w-100" id="number_day_loan_gh">
          <option value="">-- Chọn thời gian vay --</option>
          <option value="1"  >1
            tháng
          </option>
          <option value="2"  >2
            tháng
          </option>
          <option value="3" >3
            tháng
          </option>
          <option value="4"  >4
            tháng
          </option>
          <option value="5"  >5
            tháng
          </option>
          <option value="6" >6
            tháng
          </option>
          <option value="7"  >7
            tháng
          </option>
          <option value="8"  >8
            tháng
          </option>
          <option value="9" >9
            tháng
          </option>
          <option value="10"  >10
            tháng
          </option>
          <option value="11"  >11
            tháng
          </option>
          <option value="12" >
            12 tháng
          </option>
          
        </select>
                
                  </td>
                </tr>

                <tr>
                  <td>
                    Ngoại lệ <span class="text-danger">(*)</span>
                  </td>
                  <td>
              <select id="exception_gh" class="form-control" name="">
                  <?php foreach (gh_cc_exception() as $key => $item) { ?>
                    <option value="<?= $key ?>" ><?= $item ?></option>
                  <?php } ?>
                </select>
                  </td>
                </tr>
                <tr>
                  <td style="vertical-align:top !important;">
                    Ghi chú/Note
                  </td>
                  <td>
                    <textarea class="form-control" id="approve_note_gh" rows="4" placeholder="Nhập lưu ý"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
       
          </div>
            <div class="col-md-12 col-xs-12">
            <div id="SomeThing" class="simpleUploader">
              <div class="uploads" id="uploads_img_file_gh">

              </div>
              <label for="uploadinput_gh" id="addup_gh">
                <div class="block uploader">
                  <span>+</span>
                </div>
              </label>
              <input id="uploadinput_gh" type="file" name="file" data-contain="uploads_img_file_gh"
                   data-title="Hồ sơ trả về" multiple data-type="img_file" class="focus">
            </div>
          </div>
        </div>
 
            <div class="row flex warning_send_gh_cc" style="justify-content: center" >
          <div class="col-xs-6 col-lg-6">
  <div class="alert alert-warning center" role="alert" >
        <p class="text_waring_gh_cc"></p>
     
        <a class="link_payment_gh_cc"></a>
    </div>
  </div>
</div>
      </div>
      <div class="modal-footer">
         <input type="hidden" class="form-control status_approve_gh">
         <input type="hidden" class="form-control status_contract_gh">
        <input type="hidden" class="form-control contract_id_gh">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-danger cancel_submit_gh" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-info return_submit_gh" data-dismiss="modal">Trả về</button>
        <button type="button" class="btn btn-primary approve_submit_gh">Gửi</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="list_giahan_cc" tabindex="-1" role="dialog" aria-labelledby="ContractHistoryModal"
   aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title " id="title_list_cc_gh">DANH SÁCH HỢP ĐỒNG GIA HẠN</h5>
        <hr>
        <div class="table-responsive">
          <table  class="table table-striped" style="width: 100%">
            <thead>
            <tr>
              <th>#</th>
              <th>Mã hợp đồng</th>
              <th>Mã phiếu ghi</th>
              <th>Loại</th>
               <th>Ngày</th>
              <th>Trạng thái</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody id='list_contract_gh_cc'>
        
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
