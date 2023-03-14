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
	  $code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";

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
						  <form action="<?php echo base_url('pti_vta/list_pti_vta_hd')?>" method="get" style="width: 100%;">
							  <div class="col-xs-12 col-lg-2">
								  <div class="form-group">
									  <label>Từ</label>
									  <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>">
								  </div>
							  </div>
							  <div class="col-xs-12 col-lg-2">
								  <div class="form-group">
									  <label> Đến	</label>
									  <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>">

								  </div>
							  </div>
							  <div class="col-xs-12 col-lg-2">
								  <div class="form-group">
									  <label> Mã hợp đồng	</label>
									  <input type="text" name="code_contract_disbursement"
											 class="form-control" value="<?= $code_contract_disbursement ?>"
											 placeholder="Nhập mã hợp đồng">
								  </div>
							  </div>

							  <div class="col-lg-2 text-right">
								  <label>&nbsp;</label>
								  <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>
							  </div>
							  <div class="col-lg-2 text-right">
								  <label>&nbsp;</label>
								 <a style="background-color: #18d102;" href="<?=base_url()?>excel/exportListPti_vta_hd?fdate=<?=$fdate.'&tdate='.$tdate.'&code_contract_disbursement='.$code_contract_disbursement?>" class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</a>
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
                      <th>Trạng thái hợp đồng</th>
                      <th>Mã hợp đồng BH</th>
                      <th>Người được BH</th>
                      
                      <th>Gói bảo hiểm</th>
                  <th>Phí bảo hiểm</th>
                  <th>Ngày hiệu lực/Ngày hết hạn</th>
                   <th>Ngày tạo</th>
                   <th>Người tạo</th>
                    <th>Tạo lại</th>
                   <th>GCN</th>
                      <th>Trạng thái </th>
                
                      
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($ptiData)) {
                        $stt = 0;
                        foreach($ptiData as $key => $pti){
                     
                            if($pti->status != 'block'){
                            $stt++;
                           $pti_info=$pti->request;
                           $contract_info=$pti->contract_info;
                    ?>
                    <tr class='pti_<?= !empty($pti->_id->{'$oid'}) ? $pti->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
                    <td><?= !empty($pti->code_contract_disbursement) ?  $pti->code_contract_disbursement : ""?> </td>
                    <td><?= !empty($contract_info->status) ?  contract_status($contract_info->status) : ""?>
					<?php if ($contract_info->status == 3) {
							echo "<h4 style='color: red'>Cần báo đối tác PTI HỦY HĐ bảo hiểm đã tạo thành công!</h4>";
						}
						?>
					</td>
                    <td><?= !empty($pti->pti_code) ?  $pti->pti_code : ""?> </td>
                
                    <td>
               <?= !empty($pti_info->ten) ?  $pti_info->ten : ""?><br>
              <?= !empty($contract_info->customer_infor->customer_BOD) ?  $contract_info->customer_infor->customer_BOD : ""?><br>
             <?= !empty($pti_info->email) ?  $pti_info->email : ""?><br>
              <?= !empty($pti_info->phone) ?  $pti_info->phone : ""?>
                    </td>
                
                    <td>
      
       <?= !empty($contract_info->loan_infor->bao_hiem_pti_vta->code_pti_vta) ?  $contract_info->loan_infor->bao_hiem_pti_vta->code_pti_vta.'/'. $contract_info->loan_infor->bao_hiem_pti_vta->year_pti_vta : ""?>
      
                      
                    </td>
                 
                        <td>
     
        <?= !empty($contract_info->loan_infor->bao_hiem_pti_vta->price_pti_vta) ? number_format($contract_info->loan_infor->bao_hiem_pti_vta->price_pti_vta) : ""?>
      
                      
                    </td>
                     <td><?= !empty($pti_info->ngay_hl) ?  $pti_info->ngay_hl : ""?> / <br/><?= !empty($pti_info->ngay_kt) ?  $pti_info->ngay_kt  : ""?></td>
                      <td><?= !empty($pti->created_at) ?   date('m/d/Y H:i:s', $pti->created_at): ""?></td>

                      <td><?= (!empty($pti->contract_info->created_by) && $pti->type_pti == "HD") ?  $pti->contract_info->created_by : $pti->created_by ?></td>
        <td>
          <?php if($pti->status==1){ ?>
          <?= "Thành công" ?>
            <?php }else if($pti->status=='delete'){ ?>
          <?= "Đã xóa" ?>
        <?php }else{ if( $userSession['is_superadmin'] == 1){
          echo "Đã hủy" ; ?>
          <br>
          <a href="javascript:void(0)" onclick="restore_pti_vta('<?=$pti->contract_id?>')" class="btn btn-info btn-sm">
              Tạo lại
            </a>
          
        <?php } }?>
          <br>   </td>
        
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
                        <span class="dtr-data">
             
           <!--    <a class="btn btn-primary"  href="#"  >
              Gửi lại 
              </a> -->
            
               <a class="btn btn-primary" target="_blank"  href="<?php echo base_url("/pawn/detail?id=").$pti->contract_id?>" >
                 Chi tiết 
              </a>

                   </span>
                      </td>
                      <!-- Modal HTML -->
                        <div id="detele_<?php echo $pti->_id->{'$oid'}?>" class="modal fade">
                            <div class="modal-dialog modal-confirm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="icon-box danger">
                                            <!-- <i class="fa fa-times"></i> -->
                                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                                        </div>
                                    
                                        <h4 class="modal-title"><?php echo $this->lang->line('title_delete')?>?</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo $this->lang->line('body_modal_delete')?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $this->lang->line('cancel')?></button>
                                        <!-- <button type="button" class="btn btn-danger">Danger</button> -->
                                <!--     <button type="button" data-id="<?= !empty($pti->_id->{'$oid'}) ? $pti->_id->{'$oid'} : ""?>" class="btn btn-success delete_pti" data-dismiss="modal"><?php echo $this->lang->line('ok')?></button> -->
                                    </div>
                                </div>
                            </div>
                        </div>

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
