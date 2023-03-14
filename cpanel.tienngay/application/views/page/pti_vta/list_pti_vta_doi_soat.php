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
          <h3><?php echo $this->lang->line('pti_list')?> 
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Bảo hiểm PTI Vững Tâm An</a>
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
						  <form action="<?php echo base_url('pti_vta/list_pti_vta_doi_soat')?>" method="get" style="width: 100%;">
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
								 <a style="background-color: #18d102;" href="<?=base_url()?>pti_vta/exportListPti_vta_doi_soat?fdate=<?=$fdate.'&tdate='.$tdate?>" class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</a> 
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
                      <th>Mã hợp đồng BH</th>
                      <th>Người được BH</th>
                  <th>Phí bảo hiểm</th>
                  <th>Ngày hiệu lực/Ngày hết hạn</th>
                   <th>Ngày tạo</th>
                   <th>Người tạo</th>
                   <th>GCN</th>
                      <th>Trạng thái</th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($ptiData)) {
                        $stt = 0;
                        foreach($ptiData as $key => $pti){
							if ($pti->type_pti == "WEB" && $pti->status != 1) {
								continue;
							}
                     
                            if($pti->status != 'block'){
                            $stt++;
                           $pti_info=$pti->request;
                           $contract_info=$pti->contract_info;
                    ?>
                    <tr class='pti_<?= !empty($pti->_id->{'$oid'}) ? $pti->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
                   
                    <td><?= !empty($pti->pti_code) ?  $pti->pti_code : ""?> </td>
                
                    <td>
               <?= !empty($pti_info->ten) ?  $pti_info->ten : ""?><br>
              <?= !empty($contract_info->customer_infor->customer_BOD) ?  $contract_info->customer_infor->customer_BOD : ""?><br>
             <?= !empty($pti_info->email) ?  $pti_info->email : ""?><br>
              <?= !empty($pti_info->phone) ?  $pti_info->phone : ""?>
                    </td>
                
                  
                 
                        <td>
     
        <?= !empty($pti_info->phi_bh) ? $pti_info->phi_bh : ""?>
      
                      
                    </td>
                     <td><?= !empty($pti_info->ngay_hl) ?  $pti_info->ngay_hl : ""?> / <br/><?= !empty($pti_info->ngay_kt) ?  $pti_info->ngay_kt  : ""?></td>
                      <td><?= !empty($pti->created_at) ?   date('m/d/Y H:i:s', $pti->created_at): ""?></td>
						<td><?= (!empty($pti->contract_info->created_by) && $pti->type_pti == "HD") ?  $pti->contract_info->created_by : $pti->created_by ?></td>

        
 <td>
	 <?php
	 // từ ngày 16/01/2022 sẽ xem chứng từ qua file pdf. Các dữ liệu trước đó dữ nguyên không thay đổi.
	 $created_at = $pti->created_at;
	 if (isset($pti->updated_at)) {
		 $created_at = $pti->updated_at;
	 }
	 $targetDate = strtotime("2022/01/16");
	 ?>
	 <?php if(!empty($pti->pti_info->data)) { ?>
		 <?php if ($created_at > $targetDate) { ?>
			 <a class="btn btn-success btn-sm" target="_blank"
				href="<?php echo base_url("/pti_vta/viewGCN?so_id=").$pti->pti_info->so_id?>">Xem</a>
		 <?php } else { ?>
			 <a class="btn btn-success btn-sm" target="_blank" href="https://giaychungnhan.pti.com.vn/">Xem</a>
			 <br>
			 Mã tra cứu:
			 <br>
			 <?php echo !empty($pti->pti_info->chung_thuc) ? $pti->pti_info->chung_thuc : '' ?>
		 <?php } ?>
	 <?php } ?>
                            </td>
                      <td>
     
        <?= !empty($pti->status) ? status_transaction($pti->status) : ""?>
      
                      
                    </td>
                      <!-- Modal HTML -->
                    

                    </tr>
                  <?php } }}?>

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
<script src="<?php echo base_url();?>assets/js/pti_vta/index.js"></script>
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>

<style type="text/css">
  .w-25 {
    width: 8%!important;
}
</style>
