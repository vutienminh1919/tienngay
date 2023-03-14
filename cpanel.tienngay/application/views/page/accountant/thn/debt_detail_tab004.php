<div class="row">
  <div class="col-xs-12">
    <br>
  
<div class="table-responsive">
<table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Kỳ</th>
        <th>Ngày đến hạn</th>
	    <th>Số tiền phải <br> trả hàng kỳ</th>
        <th>Tiền gốc</th>
        <th>Tiền lãi</th>
        <th>Phí tư vấn quản lý</th>
        <th>Phí thẩm định và <br> lưu trữ tài sản</th>
        <th>Phạt chậm trả</th>
        <th>Tổng tiền thanh toán</th>
        <th>Đã thanh toán</th>
        <th>Còn lại chưa trả</th>
				<th>Phí gia hạn</th>
        <th>Tình trạng</th>
      
      </tr>
    </thead>
	  <tbody>
	  <?php
	  $tien_tra_1_ky=0;
	  $tien_goc_1ky=0;
	  $lai_ky=0;
	  $phi_tu_van=0;
	  $phi_tham_dinh=0;
	  $penalty=0;
	  $tong_thanh_toan=0;
	  $da_thanh_toan=0;
	  $con_lai_chua_tra=0;
	  if(!empty($contractData)){
		  foreach($contractData as $key => $contract){
		  	  $tien_tra_1_ky+=(float)$contract->tien_tra_1_ky;
			  $tien_goc_1ky+=(float)$contract->tien_goc_1ky;
			  $lai_ky+=(float)$contract->lai_ky;
			  $phi_tu_van+=(float)$contract->phi_tu_van;
			  $phi_tham_dinh+=(float)$contract->phi_tham_dinh;
			  $penalty+=(float)$contract->penalty;
			  $tong_thanh_toan+=(float)$contract->tien_tra_1_ky + (float)$contract->penalty;
			  $da_thanh_toan+=(float)$contract->da_thanh_toan;
			  $con_lai_chua_tra+=(float)$contract->tien_tra_1_ky + (float)$contract->penalty - (float)$contract->da_thanh_toan;
			  ?>

			  <tr>
				  <td><?php echo $key+1?></td>
				  <td><?= !empty($contract->ngay_ky_tra) ? date('d/m/Y', intval($contract->ngay_ky_tra) ) : ""?></td>
				  <td><?= number_format(((int)$contract->tien_tra_1_ky) ,0 ,'.' ,'.')?></td>
				  <td><?= !empty($contract->tien_goc_1ky) ? number_format($contract->tien_goc_1ky ,0 ,'.' ,'.') : "0"?></td>
				  <td><?= !empty($contract->lai_ky) ? number_format($contract->lai_ky ,0 ,'.' ,'.') : "0"?></td>
				  <td><?= !empty($contract->phi_tu_van) ? number_format($contract->phi_tu_van ,0 ,'.' ,'.') : "0"?></td>
				  <td><?= !empty($contract->phi_tham_dinh) ? number_format($contract->phi_tham_dinh ,0 ,'.' ,'.') : "0"?></td>
				  <td><?= !empty($contract->penalty) ? number_format($contract->penalty ,0 ,'.' ,'.') : "0"?></td>
				  <td><?= number_format(((int)$contract->tien_tra_1_ky + (int)$contract->penalty) ,0 ,'.' ,'.')?></td>
				  <td><?= number_format($contract->da_thanh_toan ,0 ,'.' ,'.')?></td>
				  <td><?= number_format(((int)$contract->tien_tra_1_ky + (int)$contract->penalty - (int)$contract->da_thanh_toan) ,0 ,'.' ,'.')?></td>
					<td>
					  <!-- <a href="#" data-toggle="modal" data-target="#tab001_noteModal"> -->
					  	<?= !empty($contract->fee_extend) ?  number_format($contract->fee_extend,0 ,'.' ,'.') : "0"?><!-- </a> -->
				  </td>
				  <td>
					  <?php
					  if ($contract->status == 1) {
						  $current_day = strtotime(date('m/d/Y'));
						  $datetime = !empty($contract->ngay_ky_tra) ? intval($contract->ngay_ky_tra): $current_day;
						  $time = intval(($current_day - $datetime) / (24*60*60));
						  if ($time < -5) {
							  echo 'Chưa đến kỳ';
						  }else if ($time >= -5 && $time <= 3) {
							  echo 'Hợp đồng vay tiêu chuẩn';
						  } else if ($time > 3 && $time < 34) {
							  echo 'Quá hạn '.$time.' '.$this->lang->line('days');
						  } else if ($time > 34 && $time < 64) {
							  echo 'Hợp đồng vay xấu cấp 1';
						  } else if ($time > 65 && $time < 94) {
							  echo 'Hợp đồng vay xấu cấp 2';
						  } else {
							  echo 'Hợp đồng vay xấu cấp 3';
						  }
					  } else if ($contract->status == 2) {
						  echo $this->lang->line('paid');
					  } else {
						  echo 'Đã quá hạn';
					  }
					  ?>
				  </td>
				 
			  </tr>
		  <?php }} ?>
		   <tr>
		   	  <td><b>Tổng</b></td>
				  <td></td>
				  <td><b><?= number_format(($tien_tra_1_ky) ,0 ,'.' ,'.')?></b></td>
				  <td><b><?= number_format((round($tien_goc_1ky)) ,0 ,'.' ,'.')?></b></td>
				  <td><b><?= number_format(($lai_ky) ,0 ,'.' ,'.')?></b></td>
				  <td><b><?= number_format(($phi_tu_van) ,0 ,'.' ,'.')?></b></td>
				  <td><b><?= number_format(($phi_tham_dinh) ,0 ,'.' ,'.')?></b></td>
				  <td><b><?= number_format(($penalty) ,0 ,'.' ,'.')?></b></td>
				  <td><b><?= number_format(($tong_thanh_toan) ,0 ,'.' ,'.')?></b></td>
				 <td><b><?= number_format(($da_thanh_toan) ,0 ,'.' ,'.')?></b></td>
				   <td><b><?= number_format(($con_lai_chua_tra) ,0 ,'.' ,'.')?></b></td>
					 
				  </td>
				  <td>
					 
				  </td>
		   </tr>

	  </tbody>
</table>
</div>
  </div>
</div>
