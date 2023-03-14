<div>&nbsp;</div>
<div class="table-responsive">
          <table id="datatable-button" class="table table-striped" style="width: 100%">
            <thead>
            <tr>
              <th>#</th>
               <th><?php echo $this->lang->line('time')?></th>
              <th><?php echo $this->lang->line('change_by')?></th>
              <th><?php echo $this->lang->line('status')?></th>
              <th><?php echo $this->lang->line('action')?></th>
             
            
             
              <th  style="width: 35%"><?php echo $this->lang->line('note')?></th>
            </tr>
            </thead>

            <tbody>
            <?php
            if(!empty($logs)){
            foreach($logs as $key => $log){
              if($log->action=="note_reminder")
                continue;
            ?>
              <tr>
                <td><?php echo $key + 1?></td>
                  <td><?php echo !empty($log->created_at) ? date('d/m/Y H:i:s', intval($log->created_at) + 7*60*60) : "" ?></td>
                <td><?php echo !empty($log->created_by) ? $log->created_by : ''?></td>
              
               
                <td><?php
                  $status = '';
                  $id_status = '';
                  if (!empty($log->new->status)) {
                    $id_status = $log->new->status;
                  } elseif (!empty($log->old->status)) {
                    $id_status = $log->old->status;
                  }
                  if (!empty($id_status)) {
                  echo get_tt_contract($id_status); 
                  }
                  ?>
                </td>
                  <td><?php echo !empty($log->action) ? $log->action : ''?></td>
                <td><?php echo !empty($log->new->note) ? $log->new->note : ''?><br>
                  <?php 
                  if($log->action=="Mới")
                  {
                    echo json_encode((array)$log->new->relative_infor);
                  }
                  ?></td>
              </tr>
            <?php } } 
    function get_tt_contract($id)
    {
      switch ($id) {
        case '1':
        return "Mới";
             break;
        case '2':
        return  "Chờ trưởng PGD duyệt";
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
         case '8':
        return  "Hội sở không duyệt";
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
  ?>
            </tbody>
          </table>
        </div>

      
