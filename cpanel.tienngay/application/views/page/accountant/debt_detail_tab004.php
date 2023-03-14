<div class="row">
  <div class="col-xs-12">
    <br>
     <?php function get_type($id_type)
    {
      switch ($id_type) {
        case '1':
        return "Thanh toán hóa đơn";
             break;
        case '2':
        return  "Phí phạt";
           break;
        case '3':
          return "Tất toán";
           break;
        case '4':
          return "Thanh toán kỳ";
           break;
         case '5':
          return "Gia hạn";
           break;
         case '6':
          return "Thanh toán NĐT";
           break;
    }

    }
     ?>
<div class="table-responsive">
  <table id="datatable-buttons" class="table table-striped table-bordered" style="width: 100%">
    <thead>
      <tr>
        <th>#</th>
        <th>Ngày trả</th>
        <th>Số tiền trả</th>
        <th>Người cập nhật</th>
        <th>Loại thanh toán</th>
        <th>Phương thức</th>
        <th>Trạng thái</th>
        <th>Ghi chú</th>
      </tr>
    </thead>

	  <tbody>
	  <?php
	  if(!empty($historyData)){
		  foreach($historyData as $key => $history){
			  ?>

			  <tr>
				  <td><?php echo $key+1?></td>
				  <td><?= !empty($history->created_at) ? date('d/m/Y H:i:s', intval($history->created_at) ) : ""?></td>
				  <td><?= number_format(((int)$history->total) ,0 ,'.' ,'.')?></td>
				  <td><?= !empty($history->created_by) ? $history->created_by : ""?></td>
				  <td> <?= !empty($history->type) ?  get_type($history->type) : ""?></td>
				  <td><?php
					  $method = '';
					  if ($history->payment_method == 1) {
						  $method = 'Tiền mặt';
					  } elseif ($history->payment_method == 2) {
						  $method = 'Chuyển khoản';
					  } else {
						  $method = !empty($history->payment_method) ? $history->payment_method : '';
					  }
					  echo $method;
					  ?>
				  </td>
				  
				  <td>
					  <?php
					  $status = '';
					  if ($history->status == 1) {
						  $status = 'Thành công';
					  } elseif ($history->status == 2) {
						  $status = 'Chờ xác nhận';
					  } elseif ($history->status == 3) {
						  $status = 'Đã hủy';
					  } elseif ($history->status == 4) {
						  $status = 'Chưa gửi kế toán duyệt';
					  } else {
						  $status = !empty($history->status) ? $history->status : '';
					  }
					  echo $status;
					  ?>
				  </td>
				  <td>
					  <?php 
					  $content_billing = '';
					   if (!empty($history->note) && is_array($history->note)) {
					 			 foreach ($history->note as $key => $note) {
									 $content_billing .= billing_content($note).";";
					 			 }
					 			 echo rtrim($content_billing,";").".";
					  } elseif (!empty($history->note)) {
					   	echo $history->note;
					   }
					  ?>
				  </td>
			  </tr>
		  <?php }} ?>

	  </tbody>
</table>
</div>
  </div>
</div>
