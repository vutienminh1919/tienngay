 <?php
 $du_no_con_lai_tt =0;
 $tien_lai_tt = 0;
  $tien_phi_tt =
 $tong_tien_thanh_toan_tt = 0;
  $phi_phat_cham_tra_tt =0; 
  $tong_penalty_con_lai=0;
                $du_no_con_lai_tt = !empty($dataTatToanPart1->du_no_con_lai) ? $dataTatToanPart1->du_no_con_lai : 0;
                 $tien_lai_tt = !empty($dataTatToanPart2->lai_con_no_thuc_te) ? $dataTatToanPart2->lai_con_no_thuc_te : 0;
                  $tien_phi_tt = !empty($dataTatToanPart2->phi_con_no_thuc_te) ? $dataTatToanPart2->phi_con_no_thuc_te : 0;
                   $phi_phat_sinh_tt = !empty($contractDB->phi_phat_sinh) ? $contractDB->phi_phat_sinh : 0;
                  $phi_phat_tat_toan_truoc_han = !empty($debtData->phi_thanh_toan_truoc_han) ? $debtData->phi_thanh_toan_truoc_han : 0;
                   $tong_penalty_con_lai = !empty($contractDB->tong_penalty_con_lai) ? $contractDB->tong_penalty_con_lai : 0;
                    $tien_du_ky_truoc = !empty($contractDB->tien_du_ky_truoc) ? $contractDB->tien_du_ky_truoc : 0;
                $phi_phat_cham_tra_tt = !empty($contractDB->penalty_pay) ? $contractDB->penalty_pay : 0;
                $tien_chua_tra_ky_thanh_toan = !empty($contractDB->tien_chua_tra_ky_thanh_toan) ? $contractDB->tien_chua_tra_ky_thanh_toan : 0;
                 $tien_thua_thanh_toan = !empty($contractDB->tien_thua_thanh_toan) ? $contractDB->tien_thua_thanh_toan : 0;

                 
                $tong_tien_thanh_toan_tt = $du_no_con_lai_tt + $phi_phat_cham_tra_tt + $tien_lai_tt + $tien_phi_tt + $phi_phat_tat_toan_truoc_han+$phi_phat_sinh_tt+$tien_chua_tra_ky_thanh_toan -$tien_du_ky_truoc-$tien_thua_thanh_toan;
                //var_dump($dataTatToanPart1); die;
              //  var_dump('Dư  còn lại:'.$du_no_con_lai_tt.' -  phi_phat_cham_tra: '.$phi_phat_cham_tra_tt.' -  tien_lai: '.$tien_lai_tt.' -  tien_phi: '.$tien_phi_tt.' -  phi_phat_tat_toan_truoc_han: '.$phi_phat_tat_toan_truoc_han.' -  phi_phat_sinh: '.$phi_phat_sinh_tt ); die;
            ?>
<div class="row flex" style="justify-content: center;" <?='Gốc còn lại:'.$du_no_con_lai_tt.' -  phi_phat_cham_tra: '.$phi_phat_cham_tra_tt.' -  tien_lai: '.$tien_lai_tt.' -  tien_phi: '.$tien_phi_tt.' -  phi_phat_tat_toan_truoc_han: '.$phi_phat_tat_toan_truoc_han.' -  phi_phat_sinh: '.$phi_phat_sinh_tt.' -  tong_penalty_con_lai: '.$tong_penalty_con_lai .' -  tien_du_ky_truoc: '.$tien_du_ky_truoc  ?> >
  <div class="col-xs-12  col-md-6">
    <table class="table table-borderless">
      <tbody>
         <tr>
          <th>Người tất toán:</th>
          <td class="text-right">
            <div class="form-group">
              <input type="text" class="form-control input-sm payment_name_finish" name="payment_name_finish" >
            </div>
          </td>
        </tr>
		 <tr>
			 <th>Quan hệ với chủ hợp đồng:</th>
			 <td class="text-right">
				 <div class="form-group">
					 <input type="text" class="form-control input-sm relative_with_contract_owner_finish" name="relative_with_contract_owner_finish" >
				 </div>

			 </td>
		 </tr>
        <tr>
          <th>Ngày thực tế:</th>
          <td class="text-right"><?php echo date("d/m/Y")?></td>
        </tr>
        <tr>
          <th>Ngày khách hàng tất toán:</th>
          <td class="text-right">
              <input type="date" class="form-control input-sm" id='date_pay_finish' value="<?php echo date("Y-m-d")?>">
          </td>
        </tr>
        <tr>
          <th>Số ngày chênh lệch thực tế và tất toán:</th>
          <td class="text-right"><p class="difference_day_payment_finish"><?php echo !empty($contractDB->difference_day_payment) ? $contractDB->difference_day_payment : '0'?></p></td>
        </tr>
        <tr>
          <th>Phí khấu trừ</th>
          <td class="text-right">
            <div class="form-group">
              <input type="text" class="form-control input-sm reduced_fee_finish" name="reduced_fee_finish" placeholder="Phí ngân hàng">
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-sm discounted_fee_finish" name="discounted_fee_finish" placeholder="Phí giảm trừ">
            </div>
            <div class="!form-group">
              <input type="text" class="form-control input-sm other_fee_finish" name="other_fee_finish" placeholder="Phí khác">
            </div>
          </td>
        </tr>
         <tr>
        <th>Tổng tiền khẩu trừ:</th>
        <td class="text-right"><p id="total_deductible_finish">0</p></td>
      </tr>
       <tr>
        <th>Tiền lãi:</th>
        <td class="text-right"><p id="interest_finish"><?php echo !empty($tien_lai_tt) ? number_format($tien_lai_tt) : '0'?></p></td>
      </tr>
        <tr>
          <th>Tiền hợp lệ tất toán:</th>
          <td class="text-right"><p class="valid_amount_payment_finish"><?php echo !empty( $tong_tien_thanh_toan_tt ) ? number_format( $tong_tien_thanh_toan_tt ) : '0'?></p></td>
           <input type="hidden" name="payment_amount_valid_finish"  value="<?php echo $tong_tien_thanh_toan?>"/>
        </tr>
        <tr>
          <th>Tiền khách hàng tất toán:</th>
          <td class="text-right">
            <div class="form-group">
              <input type="text" class="form-control input-sm payment_amount_finish" name="payment_amount_finish" >
            </div>

          </td>
        </tr>


      </tbody>
    </table>

  </div>

  <div class="col-xs-12  col-md-6">
    <table class="table table-borderless">
    <tbody>
      <tr>
          <th>Số điện thoại người tất toán:</th>
          <td class="text-right">
              <input type="number" name="payment_phone_finish" class="form-control input-sm" id='payment_phone_finish' value="">
          </td>
        </tr>
      <tr>
        <th>Tổng tiền tất toán ngày hiện tại:</th>
        <td class="text-right"><p class="total_money_paid_now_finish"><?php echo !empty( $tong_tien_thanh_toan_tt) ? number_format( $tong_tien_thanh_toan_tt) : '0'?></p></td>
      </tr>
      <tr>
        <th>Tổng tiền đến ngày tất toán:</th>
        <td class="text-right "><p class="total_money_paid_finish"><?php echo !empty( $tong_tien_thanh_toan_tt) ? number_format( $tong_tien_thanh_toan_tt) : '0'?></p></td>
      </tr>
      <tr>
        <th>Tiền chênh lệch thực tế và tất toán:</th>
        <td class="text-right"><p class="actual_difference_payment_finish"><?php echo !empty($contractDB->actual_difference_payment) ? number_format($contractDB->actual_difference_payment) : '0'?></p></td>
      </tr>
        <!-- <tr>
      <th>Dư  còn lại:</th>
     
        <td class="text-right"> -->
        <input type="hidden" id="balance_finish" <?php echo !empty($du_no_con_lai_tt) ? number_format($du_no_con_lai_tt) : '0'?> > 
      <!-- </td> -->
      <!-- </tr> -->
  
       <tr>
      <th>Phí tất toán trước hạn:</th>
      
        <td class="text-right"><p id="phi_phat_tat_toan_truoc_han_finish"><?php echo !empty($phi_phat_tat_toan_truoc_han) ? number_format($phi_phat_tat_toan_truoc_han) : '0'?></p></td>
      </tr>
     
      <tr>
        <th>Tiền phạt chậm trả:</th>
        <td class="text-right"><p id="penalty_pay_finish"><?php echo !empty($phi_phat_cham_tra_tt) ? number_format($phi_phat_cham_tra_tt) : '0'?></p></td>
      </tr>
       <tr>
        <th>Tiền quá hạn:</th>
        <td class="text-right"><p id="tien_qua_han_finish"><?php echo !empty($phi_phat_sinh_tt) ? number_format($phi_phat_sinh_tt) : '0'?></p></td>
      </tr>
      <tr>
        
      <tr>
        <th>Tiền phí:</th>
        <td class="text-right"><p id="fee_finish"><?php echo !empty($tien_phi_tt) ? number_format($tien_phi_tt) : '0'?></p></td>
      </tr>
       <tr>
        <th>Phương thức:</th>
        <td class="text-right">
         
            <input class="form-check-input" type="radio" name="payment_method_finish" value="1" checked>
            <label class="form-check-label" for="moneyoption_cast">
              Tiền mặt
            </label>
        
            <input class="form-check-input" type="radio" name="payment_method_finish" value="2" >
            <label class="form-check-label" for="moneyoption_banktransfer">
              Chuyển khoản
            </label>
         
        </td>
      </tr>
      <tr>
        <th>Phòng giao dịch:</th>
        <td class="text-right">
           <select class="form-control" id="stores_finish">
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
			  <select id="payment_note_finish" name="payment_note_finish[]" class="form-control" multiple="multiple" data-placeholder="Chọn nội dung thu tiền">
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

<input type="hidden" class="form-control input-sm" name="penalty_pay_finish" >
<input type="hidden" class="form-control input-sm" name="penalty_now_finish" value="<?php echo !empty($contractDB->penalty_now) ? $contractDB->penalty_now : ''?>" >
<input type="hidden" class="form-control input-sm" value="<?php echo !empty($contractDB->code_contract) ? $contractDB->code_contract : ''?>" name="code_contract_finish" >
  <div class="col-xs-12 text-right">

 
          
     <?php
            if(($countGiaoDichTatToanChoDuyet == 0 && $contractDB->status != 19) && ( strtotime(date('Y-m-d').' 23:59:59') > $contractDB->disbursement_date) ) {
          ?>
    <button id="confirm_finish_contract" class="btn btn-success" style="min-width: 125px">IN BIÊN NHẬN</button>
  <?php }else if($countGiaoDichTatToanChoDuyet > 0 ){ ?>
    <div class="alert alert-warning center" role="alert">
 <h4> Đã tồn tại tất toán! (Kiểm tra phiếu thu nếu Thất bại thì Gửi duyệt) và báo bộ phận kế toán duyệt tất toán.</h4>
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
    $('#date_pay_finish').attr('max', maxDate);
});
  //  $(document).ready(function() {
  $('#date_pay_finish').change(function() {
    var date_pay = $(this).val();
    var id_contract = $("#id_contract").val();
  
    var formData = {
    date_pay: date_pay,
    id_contract: id_contract
    };
    
    $.ajax({
        url :  _url.base_url + 'accountant/check_date_pay_finish',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
           $("#loading").hide();
            if(data.status == 200){
              console.log(data);
              $(".reduced_fee_finish").val('0');
                $(".discounted_fee_finish").val('0');
                 $(".other_fee_finish").val('0');
               var total_money_paid_now = $(".total_money_paid_now_finish").text().split(',').join('');
              var du_no_con_lai = data.data.dataTatToanPart1.du_no_con_lai;
              var tien_lai = data.data.dataTatToanPart2.lai_con_no_thuc_te;
              var tien_phi = data.data.dataTatToanPart2.phi_con_no_thuc_te;
               var da_thanhtoan = data.data.contract.total_paid;
                var tien_du_ky_truoc = data.data.contract.tien_du_ky_truoc;
                var tien_chua_tra_ky_thanh_toan = data.data.contract.tien_chua_tra_ky_thanh_toan;
              var phi_phat_tat_toan_truoc_han =  data.data.debtData.phi_thanh_toan_truoc_han;
              if( data.data.contract.status != 19) 
              var phi_phat_cham_tra =  data.data.contract.penalty_pay;
             var phi_phat_sinh =  data.data.contract.phi_phat_sinh;
              var tong_tien_thanh_toan = 0;
              tong_tien_thanh_toan = du_no_con_lai + phi_phat_cham_tra + tien_lai + tien_phi + phi_phat_tat_toan_truoc_han+phi_phat_sinh+tien_chua_tra_ky_thanh_toan-tien_du_ky_truoc;
              console.log(du_no_con_lai + ' - '+ phi_phat_cham_tra+ ' - '+ tien_lai + ' - '+ tien_phi+ ' - '+ phi_phat_tat_toan_truoc_han+'-'+phi_phat_sinh);
               $(".total_money_paid_finish").text(numeral(tong_tien_thanh_toan).format('0,0'));
               $(".valid_amount_payment_finish").text(numeral(tong_tien_thanh_toan).format('0,0'));
               $("#phi_phat_tat_toan_truoc_han_finish").text(numeral(phi_phat_tat_toan_truoc_han).format('0,0'));
               $("#penalty_pay_finish").text(numeral(phi_phat_cham_tra).format('0,0'));
              $("#fee_finish").text(numeral(tien_phi).format('0,0'));
              $("#interest_finish").text(numeral(tien_lai).format('0,0'));
              $(".actual_difference_payment_finish").text(numeral(total_money_paid_now-tong_tien_thanh_toan).format('0,0'));
              $(".difference_day_payment_finish").text(data.data.contract.difference_day_payment);
              $("input[name='valid_amount_payment_finish']").text(numeral((tong_tien_thanh_toan)).format('0,0'));
                $("#balance_finish").text(numeral(du_no_con_lai).format('0,0'));
               $(".ky_cham_tra_top").text(numeral((data.data.contract.ky_cham_tra)).format('0,0'));
                $(".total_money_paid_pay_top").text(numeral((data.data.total_money_paid)).format('0,0'));
                 $(".penalty_top").text(numeral((phi_phat_cham_tra)).format('0,0'));
                // $(".tong_thanh_toan_top").text(numeral((tong_tien_thanh_toan)).format('0,0'));
               //  $(".tong_da_thanh_toan_top").text(numeral((da_thanhtoan)).format('0,0'));
                //  $(".tong_con_no_top").text(numeral((tong_tien_thanh_toan-da_thanhtoan)).format('0,0'));
                 $(".so_tien_phat_sinh_top").text(numeral((phi_phat_sinh)).format('0,0'));
                  $("#tien_qua_han_finish").text(numeral((phi_phat_sinh)).format('0,0'));
                  $(".total_money_paid_pay_top").text(numeral((data.data.contract.total_money_paid)).format('0,0'));
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
   
});
//});
</script>
