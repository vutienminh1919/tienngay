 <div class="col-xs-12 p-0">
 <div class="table-responsive">
          <table id="" class="table table-striped" style="width: 100%">
            <thead>
            <tr>
              <th>#</th>
              <th>Mã hợp đồng</th>
              <th>Mã phiếu ghi</th>
              <th>Loại</th>
               <th>Ngày</th>
              <th>Trạng thái</th>
              <th>Chi tiết</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($data_tab_gia_han)) {
              foreach ($data_tab_gia_han as $key => $val) {
                if( $val->type_gh=="origin")
                {
                      $type_gh="Hợp đồng gốc";
                }else if( $val->type_gh > 0){
                  $type_gh="Gia hạn lần ".$val->type_gh;
                }
                if($contractInfor->code_contract==$val->code_contract)
                  continue;
                ?>
                 <tr>
                   <td><?= $key+1 ?> </td>
                   <td><?= $val->code_contract_disbursement ?> </td>
                   <td><?= $val->code_contract ?></td>
                   <td><?= $type_gh ?> </td>
                   <td><?= (!empty($val->extend_date)) ? date('d-m-Y',$val->extend_date) : '' ?> </td>
                   <td> <?= contract_status($val->status) ?></td>
                   <td><a target="blank" href="<?php echo base_url("pawn/detail?id=") . $val->_id->{'$oid'} ?>">Chi tiết</a> </td>
                 </tr>
              <?php }} ?>
            </tbody>
          </table>
        </div>
</div>