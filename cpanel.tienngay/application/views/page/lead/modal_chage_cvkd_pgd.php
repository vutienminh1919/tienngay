<!-- Modal yêu cầu cơ cấu -->
<div id="chage_cvkd_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title title_modal_approve_cc">Chuyển chuyên viên kinh doanh</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        
          <div class="col-xs-12 col-md-6">
            <h4>
              <i class="fa fa-files-o"></i>
              Chi tiết lead
            </h4>
            <hr class="mt-0">

            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                   Họ và Tên :
                  </td>
                  <td>
               <span id="auto_fullname"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                   Email :
                  </td>
                  <td>
                     <span id="auto_email"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    CVKD hiện tại:
                  </td>
                  <td>
                     <span id="auto_cvkd"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                    Trạng thái TLS
                  </td>
                  <td>
                    <span id="auto_status_sale"></span>
                  </td>
                </tr>
                <tr>
                  <td>
                   Trạng thái PGD
                  </td>
                  <td>
                     <span id="auto_status_pgd"></span>
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
                    THÔNG TIN CHUYỂN CVKD

                  </h4>

                </div>
               
              </div>
            <hr class="mt-0">

            <table class="table table-borderless">
              <tbody>
               
                <tr>
                  <td>
                   Chuyên viên kinh doanh <span class="text-danger">(*)</span>
                  </td>
                <td>
              <select id="cvkd_auto" class="form-control" name="cvkd_auto">
                    <?php foreach ($dataCvkd as $key => $item) { ?>
                    <option value="<?= $item ?>" ><?= $item ?></option>
                  <?php } ?>
                  
                 
                </select>
                  </td>
                </tr>
                
              

                <tr>
                  <td style="vertical-align:top !important;">
                    Ghi chú/Note
                  </td>
                  <td>
                    <textarea class="form-control" name="note_auto" rows="4" placeholder="Nhập lưu ý"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
       
          </div>
       
      </div>
      <div class="modal-footer">
        <input type="hidden" class="form-control lead_id_auto">
     
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      
        <button type="button" class="btn btn-primary approve_submit_change">Chuyển đổi</button>
      </div>
    </div>

  </div>
</div>
</div>