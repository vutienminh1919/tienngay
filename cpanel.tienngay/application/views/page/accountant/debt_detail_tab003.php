<div>&nbsp;</div>
<div class="row flex" style="justify-content: center;">
  <div class="col-xs-12  col-md-6">
    <div class="table-responsive">
    <table class="table table-borderless">
      <tbody>
         <tr>
          <th>Người thanh toán:</th>
          <td class="text-right">
            <div class="">
              <input type="text" class="form-control input-sm payment_name" name="payment_name" >
            </div>

          </td>
        </tr>
     <tr>
       <th>Quan hệ với chủ hợp đồng:</th>
       <td class="text-right">
         <div class="">
           <input type="text" class="form-control input-sm relative_with_contract_owner" name="relative_with_contract_owner" >
         </div>

       </td>
     </tr>
        <tr>
          <th>Ngày thực tế:</th>
          <td class="text-right"><?php echo date("d/m/Y")?></td>
        </tr>
        <tr>
          <th>Ngày khách hàng thanh toán:</th>
          <td class="text-right">
              <input type="date" class="form-control input-sm" id='date_pay' value="<?php echo date("Y-m-d")?>">
          </td>
        </tr>
        <tr>
          <th>Số ngày chênh lệch thực tế và thanh toán:</th>
          <td class="text-right"><p class="difference_day_payment"><?php echo !empty($contractDB->difference_day_payment) ? $contractDB->difference_day_payment : '0'?></p></td>
        </tr>
        <tr>
          <th>Phí khấu trừ</th>
          <td class="text-right">
            <div class="">
              <input type="text" class="form-control input-sm reduced_fee" name="reduced_fee" placeholder="Phí ngân hàng">
            </div>
            <div class="">
              <input type="text" class="form-control input-sm discounted_fee" name="discounted_fee" placeholder="Phí giảm trừ">
            </div>
            <div class="!">
              <input type="text" class="form-control input-sm other_fee" name="other_fee" placeholder="Phí khác">
            </div>
          </td>
        </tr>
         <tr>
        <th>Tổng tiền khẩu trừ:</th>
        <td class="text-right"><p id="total_deductible">0</p></td>
      </tr>
       <!--  <tr>
          <th></th>
          <td class="text-right"><p class="expected_money text-danger"></p></td>
        </tr> -->
        <tr>
          <th>Tiền hợp lệ thanh toán:</th>
          <td class="text-right"><p class="valid_amount_payment"><?php echo !empty($contractDB->total_money_paid) ? number_format($contractDB->total_money_paid) : '0'?></p></td>
        </tr>
        <tr>
          <th>Tiền khách hàng thanh toán:</th>
          <td class="text-right">
            <div class="">
              <input type="text" class="form-control input-sm payment_amount" name="payment_amount" >
            </div>

          </td>
        </tr>
      
       
      </tbody>
    </table>
   </div>
  </div>

  <div class="col-xs-12  col-md-6">
    <div class="table-responsive">
    <table class="table table-borderless">
    <tbody>
      <tr>
          <th>Số điện thoại người thanh toán:</th>
          <td class="text-right">
              <input type="number" name="payment_phone" class="form-control input-sm" id='payment_phone' value="">
          </td>
        </tr>
        <tr>
          <th>Hình thức:</th>
          <td class="text-right">

            <input class="form-check-input" type="radio" name="type_payment" value="1" checked>
            <label class="form-check-label" for="moneyoption_banktransfer">
              Thanh toán kỳ
            </label>
             <?php if($check_dang_xl==0 && (strtotime(date('Y-m-d').' 00:00:00') >= $contractDB->disbursement_date)){ ?>
           <?php if($contractDB->debt->check_gia_han==1 && $contractDB->status==17 && $check_isset_gh==0 &&  $check_isset_cc==0){?>
            <input class="form-check-input" type="radio" name="type_payment" value="2" >
            <label class="form-check-label" for="moneyoption_cast">
              Gia hạn
            </label>
          <?php } ?>
          <?php if($contractDB->status==17  && $check_isset_cc==0 &&  $check_isset_gh==0){?>
            <input class="form-check-input" type="radio" name="type_payment" value="3" >
            <label class="form-check-label" for="moneyoption_cast">
              Cơ cấu
            </label>
             <?php } ?>
              <?php } ?>

          </td>
        </tr>
      <tr>
        <th>Tổng tiền phải trả đến hạn:</th>
        <td class="text-right"><p class="total_money_paid_now"><?php echo !empty($contractDB->total_money_paid_now) ? number_format($contractDB->total_money_paid_now) : '0'?></p></td>
      </tr>
      <tr>
        <th>Tiền đến ngày Thanh toán:</th>
        <td class="text-right "><p class="total_money_paid"><?php echo !empty($contractDB->total_money_paid) ? number_format($contractDB->total_money_paid) : '0'?></p></td>
      </tr>
      <tr>
        <th>Tiền chênh lệch thực tế và thanh toán:</th>
        <td class="text-right"><p class="actual_difference_payment"><?php echo !empty($contractDB->actual_difference_payment) ? number_format($contractDB->actual_difference_payment) : '0'?></p></td>
      </tr>
      <tr>
        <th>Tổng tiền khẩu trừ:</th>
        <td class="text-right"><p id="total_deductible">0</p></td>
      </tr>
      <tr>
        <th>Tiền phạt chậm trả:</th>
        <td class="text-right"><p id="penalty_pay"><?php echo !empty($contractDB->penalty_pay) ? number_format($contractDB->penalty_pay) : '0'?></p></td>
      </tr>
          <tr>
        <th>Tiền quá hạn:</th>
        <td class="text-right"><p id="tien_qua_han"><?php echo !empty($contractDB->phi_phat_sinh) ? number_format($contractDB->phi_phat_sinh) : '0'?></p></td>
      </tr>
      <tr>
        <th>Phương thức:</th>
        <td class="text-right">
         
            <input class="form-check-input" type="radio" name="payment_method" value="1" checked>
            <label class="form-check-label" for="moneyoption_cast">
              Tiền mặt
            </label>
        
            <input class="form-check-input" type="radio" name="payment_method" value="2" >
            <label class="form-check-label" for="moneyoption_banktransfer">
              Chuyển khoản
            </label>
         
        </td>
      </tr>
      <tr>
        <th>Phòng giao dịch:</th>
        <td class="text-right">
           <select class="form-control" id="stores">
          <?php
          $userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
          $stores = !empty($userInfo['stores']) ?  $userInfo['stores'] : array();
          foreach($stores as $key =>  $value){
            ?>
            <option value="<?= !empty($value->store_id) ? $value->store_id : ""?>" selected><?= !empty($value->store_name) ? $value->store_name : ""?></option>
          <?php }?>
        </select>
        </td>
      </tr>
    <tr>
      <th>Nội dung thu:</th>
      <td>
        <select id="payment_note" name="payment_note[]" class="form-control" multiple="multiple" data-placeholder="Chọn nội dung thu tiền">
          <?php
          $value_full = 2;
          $value_part = 27;
          $value_slow = 52;
          ?>
          <!--1.--><option value="1">Thanh toán kỳ hợp đồng</option>
          <!--1.1--><option value="2" data-parent="1">Thanh toán đủ kỳ</option>
          <?php if (!empty($contractData)) {
            foreach ($contractData as $key_contract => $contract) {
              ?>
              <!--1.1.1--><option value="<?= ++$value_full;?>" data-parent="2">Thanh toán đủ kỳ <?= ($key_contract + 1);?></option>
            <?php }?>
            <!--1.2--><option value="27" data-parent="1">Thanh toán một phần kỳ</option>
            <?php
            foreach ($contractData as $key_contract => $contract) { ?>
              <!--1.2.1--><option value="<?= ++$value_part;?>" data-parent="27">Thanh toán một phần kỳ <?= ($key_contract + 1); ?></option>
            <?php }?>
            <!--2.--><option value="52" >Phí phạt chậm trả</option>
            <?php
            foreach ($contractData as $key_contract => $contract) { ?>
              <option value="<?= ++$value_slow;?>" data-parent="52">Phí phạt chậm trả kỳ <?= ($key_contract + 1);?></option>
            <?php }}?>
          <!--3.--><option value="77">Phí gia hạn</option>
          <!--4.--><option value="78">Phí tất toán trước hạn</option>
          <!--5.--><option value="79">Phí cơ cấu</option>
        </select>
      </td>
    </tr>

    </tbody>
  </table>
    </div>
  </div>
<input type="hidden" class="form-control input-sm" name="phi_phat_sinh" value="<?php echo $contractDB->phi_phat_sinh?>" >
<input type="hidden" class="form-control input-sm" name="so_ngay_qua_han"
       value="<?php echo !empty($contractDB->so_ngay_qua_han) ? $contractDB->so_ngay_qua_han : '' ?>">
<input type="hidden" class="form-control input-sm" name="penalty_pay" >
<input type="hidden" class="form-control input-sm" name="fee_need_gh_cc" >
<input type="hidden" class="form-control input-sm" name="penalty_now" value="<?php echo !empty($contractDB->penalty_now) ? $contractDB->penalty_now : ''?>" >
<input type="hidden" class="form-control input-sm" value="<?php echo !empty($contractDB->code_contract) ? $contractDB->code_contract : ''?>" name="code_contract" >
  <input type="hidden" id="count-status-not-yet-approve" value="<?php echo !empty($countGiaoDichThanhToanChoDuyet) ? $countGiaoDichThanhToanChoDuyet : '';?>">
  <div class="col-xs-12 text-right">
    
  <?php
    if(($countGiaoDichTatToanChoDuyet == 0 && $contractDB->status != 19)  && ( strtotime(date('Y-m-d').' 23:59:59') > $contractDB->disbursement_date) && $check_isset_gh==0 &&  $check_isset_cc==0 ) {
  ?>
    <button id="confirm_payment" class="btn btn-success" style="min-width: 125px">IN BIÊN NHẬN</button>
 <?php }else if($countGiaoDichTatToanChoDuyet > 0 ){ ?>
    <div class="alert alert-warning center" role="alert">
 <h4> Đã tồn tại thanh toán! (Kiểm tra phiếu thu nếu Thất bại >> Chọn Chức năng >> Gửi duyệt) và báo bộ phận kế toán duyệt thanh toán</h4>
</div>
  <?php }else if($contractDB->status == 19){ ?>
     <div class="alert alert-warning center" role="alert">
 <h4> Đã tất toán</h4>
</div>
     <?php } else if( strtotime(date('Y-m-d').' 23:59:59') <= $contractDB->disbursement_date){ ?>
     <div class="alert alert-warning center" role="alert">
 <h4> Chưa đến kỳ thanh toán</h4>
</div>
     <?php } ?>
     <?php if( $check_isset_gh==1 ||  $check_isset_cc==1){ ?>
      <div class="alert alert-warning center" role="alert">
 <h4> Đã tồn tại thanh toán gia hạn/ cơ cấu</h4>
</div>
      <?php } ?>
  </div>
</div>


<script type="text/javascript">
  $(function(){
    var dtToday = new Date();
    
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(day<10){day='0'+day}
    if(month<10){month='0'+month}
    var maxDate = year + '-' + month + '-' + day;
    $('#date_pay').attr('max', maxDate);
});
   // $(document).ready(function() {
 $('#date_pay').change(function() {
    var date_pay = $(this).val();
    var id_contract = $("#id_contract").val();
     $(".expected_money").text("");
    var formData = {
    date_pay: date_pay,
    id_contract: id_contract
    };
    
    $.ajax({
        url :  _url.base_url + 'accountant/check_date_pay',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
          console.log(data);
           $("#loading").hide();
            if(data.status == 200){
              $(".reduced_fee").val('0');
                $(".discounted_fee").val('0');
                 $(".other_fee").val('0');
               $(".total_money_paid").text(numeral(data.data.total_money_paid).format('0,0'));
               $(".difference_day_payment").text(numeral(data.data.difference_day_payment).format('0,0'));
               $(".actual_difference_payment").text(numeral(data.data.actual_difference_payment).format('0,0'));
               $("#penalty_pay").text(numeral(data.data.penalty_pay).format('0,0'));
               $(".valid_amount_payment").text(numeral((data.data.total_money_paid)).format('0,0'));
                $(".ky_cham_tra_top").text(numeral((data.data.ky_cham_tra)).format('0,0'));
                $(".total_money_paid_pay_top").text(numeral((data.data.total_money_paid)).format('0,0'));
                $(".penalty_top").text(numeral((data.data.penalty_pay)).format('0,0'));
                $(".tong_thanh_toan_top").text(numeral((data.data.tong_thanh_toan)).format('0,0'));
                $(".tong_da_thanh_toan_top").text(numeral((data.data.total_paid)).format('0,0'));
                $(".tong_con_no_top").text(numeral((data.data.tong_thanh_toan-data.data.total_paid)).format('0,0'));
                 $(".so_tien_phat_sinh_top").text(numeral((data.data.phi_phat_sinh)).format('0,0'));
                  $(".total_money_paid_pay_top").text(numeral((data.data.total_money_paid)).format('0,0'));
                $("#tien_qua_han").text(numeral((data.data.phi_phat_sinh)).format('0,0'));
                // var $radios = $('input:radio[name=type_payment]');
                //  $radios.filter('[value=1]').prop('checked', true);
                $("#successModal").modal("show");
                 $(".msg_success").text(data.msg);
                    setTimeout(function(){
                    $("#successModal").modal("hide");
                }, 3000);
               
            }else{
                $('#errorModal').modal('show');
                $('.msg_error').text(data.msg);
                $('#confirm_payment').hide();
                setTimeout(function(){
                    location.reload();
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $("#loading").hide();
        }
    });
    var type_payment =$("input[type=radio][name=type_payment]:checked").val();
       if(type_payment==2)
       {
        

        var id_contract = $("#id_contract").val();
  var date_pay_gh_cc = $(this).val();
    var formData = {
    date_pay: date_pay_gh_cc,
    id_contract: id_contract
    };
    
    $.ajax({
        url :  _url.base_url + 'accountant/check_date_pay_finish',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
          console.log(data);
           $("#loading").hide();
            if(data.status == 200){
               var du_no_con_lai = data.data.dataTatToanPart1.phi_chua_tra_den_thoi_diem_hien_tai+data.data.dataTatToanPart1.lai_chua_tra_den_thoi_diem_hien_tai;
              var tien_lai = data.data.dataTatToanPart2.lai_chua_tra_qua_han;
              var tien_phi = data.data.dataTatToanPart2.phi_chua_tra_qua_han;
              var lai_con_no_thuc_te = data.data.dataTatToanPart2.lai_con_lai_phai_tra_cua_ki_tiep_theo;
              var phi_con_no_thuc_te = data.data.dataTatToanPart2.phi_con_lai_phai_tra_cua_ki_tiep_theo;
               
                var tien_du_ky_truoc = data.data.contract.tien_du_ky_truoc;
                var tien_chua_tra_ky_thanh_toan = data.data.contract.tien_chua_tra_ky_thanh_toan;
             
              var phi_phat_cham_tra =  data.data.contract.penalty_pay;
             var phi_phat_sinh =  data.data.contract.phi_phat_sinh;
             var phi_gia_han =  data.data.contract.phi_gia_han;
              var tong_can_gh_cc = 0;
             if(type_payment==2)
             {
               tong_can_gh_cc = phi_phat_cham_tra + tien_lai + tien_phi +phi_phat_sinh+phi_gia_han;
             }
              $(".total_money_paid").text(numeral(tong_can_gh_cc).format('0,0'));
             $("input[name='fee_need_gh_cc']").val(tong_can_gh_cc);
              
               $(".valid_amount_payment").text(numeral(tong_can_gh_cc).format('0,0'));
                
               
            }else{
                $('#errorModal').modal('show');
                $('.msg_error').text(data.msg);
                $('#confirm_payment').hide();
                setTimeout(function(){
                    location.reload();
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $("#loading").hide();
        }
    });
}else{
  var date_pay = $(this).val();
  $(".expected_money").text("");
}
});
// });
</script>
