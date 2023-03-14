<div class="row">
  <div class="col-xs-12">
    <br>
   <h3>
          Lịch sử gia hạn <br>
     
        </h3>
<div class="table-responsive">
<table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>STT</th>
        <th>Ngày gia hạn</th>
	    <th>Lần gia hạn</th>
        <th>Lý do gia hạn</th>
        <th>Nhân viên gia hạn</th>
      
      
      </tr>
    </thead>
	  <tbody>
		
            <?php 
                if(!empty($contractDB->result_reminder)){
                    foreach($contractDB->result_reminder as $key => $value){
            ?>
               <tr>
		   	  <td><?php echo $key+1?></td>
                 <td><?= !empty($value->created_at) ? date('d/m/Y H:i:s', intval($value->created_at) + 7*3600) : ""?></td>
                 <td><?= !empty($value->created_by) ? $value->created_by : ""?></td>
                 <td><?= !empty($value->reminder) ? $value->reminder : ""?></td>
                 <td><?= !empty($value->note) ? $value->note : ""?></td>
                 </tr>
			<?php }}?>	
		 

	  </tbody>
</table>
</div>
  </div>
</div>
