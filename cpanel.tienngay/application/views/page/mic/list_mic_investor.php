<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">

<!-- page content -->
<div class="right_col" role="main">
  <div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử lý...</span>
  </div>
  <div class="row top_tiles">
	  <?php
	  $fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	  $tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

	  ?>
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $this->lang->line('mic_list')?> 
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#"><?php echo $this->lang->line('mic_list')?> nhà đầu tư</a>
            </small>
          </h3>
         
        </div>
    
      </div>
    </div>

  
    
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
		  <div class="x_title">

			  <div class="row">
				  <div class="col-xs-12 col-lg-12">
					  <div class="row">
						  <form action="<?php echo base_url('mic/listMic_investor')?>" method="get" style="width: 100%;">
							  <div class="col-lg-3">
								  <label></label>
								  <div class="input-group">
									  <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
									  <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>">
								  </div>
							  </div>
							  <div class="col-lg-3">
								  <label></label>
								  <div class="input-group">
									  <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
									  <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>">

								  </div>
							  </div>

							  <div class="col-lg-2 text-right">
								  <label></label>
								  <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>
							  </div>
							  <div class="col-lg-2 text-right">
								  <label></label>
								  <a style="background-color: #18d102;" href="<?=base_url()?>excel/exportListMic?fdate=<?=$fdate.'&tdate='.$tdate.'&type_mic=MIC_TDT&isExport=1'?>" class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</a>
							  </div>
						  </form>
					  </div>

				  </div>
			  </div>
			  <div class="clearfix"></div>
		  </div>
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
                      <th>Mã hợp đồng</th>
                      <th>Mã hợp đồng BH</th>
                      <th>Người được BH</th>
                      
                      <th>Số tiền vay</th>
                  <th>Phí bảo hiểm</th>
                  <th>Ngày hiệu lực/Ngày hết hạn</th>
                  <th>Ngày tạo</th>
                  <th>Người tạo</th>
                      <th>Trạng thái MIC</th>
                
                     
                      <th>Chi tiết</th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($micData)) {
                        $stt = 0;
                        foreach($micData as $key => $mic){
                            $stt++;
                           $mic_info=$mic;
                           $contract_info=$mic->contract_info;
                    ?>
                    <tr class='mic_<?= !empty($mic->_id->{'$oid'}) ? $mic->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
                    <td><?= !empty($mic->code_contract_disbursement) ?  $mic->code_contract_disbursement : ""?> </td>
                    <td><?= !empty($mic->mic_gcn) ?  $mic->mic_gcn : ""?> </td>
                
                    <td>
            
              <?= !empty($contract_info->investor_infor->name) ?  $contract_info->investor_infor->name : ""?>
                    </td>
                
                    <td>
         <?= !empty($contract_info->loan_infor->amount_money) ?  number_format($contract_info->loan_infor->amount_money) : ""?> 
                    </td>
                 
                        <td>
     
      <?= !empty($mic_info->mic_fee) ?  number_format($mic_info->mic_fee) : ""?> 
                      
                    </td>
                     <td><?= !empty($mic_info->NGAY_HL) ?  substr($mic_info->NGAY_HL,0,10) : ""?> / <br/><?= !empty($mic_info->NGAY_KT) ?  substr($mic_info->NGAY_KT,0,10)  : ""?></td>

						<td><?= !empty($mic_info->created_at) ?   date('m/d/Y H:i:s', $mic_info->created_at): ""?></td>
						<td><?= !empty($mic_info->created_by) ?   $mic_info->created_by: ""?></td>
						<td>
          <?php if($mic->status == 'deactive'){ ?>
            Thất bại
         
            <a href="javascript:void(0)" onclick="resend('<?= $mic_info->_id->{'$oid'} ?>')" class="btn btn-info btn-sm ">
              Gửi lại
            </a>
        
          
        <?php }else{ echo "Hoàn thành"; } ?>
          <br>   </td>

                      <td>
                        <span class="dtr-data">
            
               <a class="btn btn-primary" target="_blank"  href="<?php echo base_url("/pawn/detail?id=").$mic->contract_id?>" >
                 Chi tiết 
              </a>

                   </span>
                      </td>
                    
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
<script>
$(document).ready(function () {

   set_switchery();
    function set_switchery() {
        $(".aiz_switchery").each(function () {
            new Switchery($(this).get(0), {
                color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'});
            var changeCheckbox = $(this).get(0);
            var id = $(this).data('id');
           
       
        });
    }
    });
</script>
