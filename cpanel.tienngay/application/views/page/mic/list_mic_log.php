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
          <h3><?php echo $this->lang->line('mic_list')?> 
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Log mic</a>
            </small>
          </h3>
         
        </div>
    
      </div>
    </div>

   
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
                 <div ><?php echo $result_count;?></div>
                 <table id="datatable-button" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Ngày tạo</th>
                      <th>Mã hợp đồng</th>
                      <th>Request</th>
                      <th>Response</th>
                      
               
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($micData)) {
                        $stt = 0;
                        foreach($micData as $key => $mic){
                     
                          
                            $stt++;
                           $mic_info=$mic;
                           $contract_info=isset($mic->contract_info) ? $mic->contract_info : array();
                    ?>
                    <tr class='mic_<?= !empty($mic->_id->{'$oid'}) ? $mic->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
                       <td><?= !empty($mic->created_at) ?   date('m/d/Y H:i:s', $mic->created_at): ""?></td>
                    <td><?= !empty($mic->code_contract_disbursement) ?  $mic->code_contract_disbursement : ""?> </td>
                    <td><?= !empty($mic->request_data) ?  $mic->request_data : ""?> </td>
                    <td><?= !empty(serialize($mic->response_data)) ? serialize($mic->response_data) : ""?> </td>
                  

                    
                    
                    </tr>
                  <?php } }?>

                </tbody>
              </table>
                <div class="">
          <?php echo $pagination ?>
        </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>

</div>

<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/mic/index.js"></script>
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
