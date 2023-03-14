
<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$sdt= !empty($_GET['sdt']) ? $_GET['sdt'] : "";
  $tab= isset($_GET['tab']) ? $_GET['tab'] : 'import_payment';
  $full_name= !empty($_GET['full_name']) ? $_GET['full_name'] : "";
  $code_contract_disbursement= !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
  $code_contract= !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	?>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <div class="row">
            <div class="col-xs-12 col-lg-1">
              <h2>Quản lý lãi phí</h2>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
				  <form class="form-inline" action="<?php echo base_url('temporary_plan/list_thn')?>" method="get" style="width: 100%">
					  <div class="col-xs-12">
						  <div class="row">
					       <input type="hidden" name="tab" value="<?=$tab ?>">
							
							  <div class="col-lg-2">
								  <div class="input-group">
									  <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
									  <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>" >
								  </div>
							  </div>
							  <div class="col-lg-2">
								  <div class="input-group">
									  <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
									  <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>" >

								  </div>
							  </div>
                              <div class="col-lg-2">
             
					              <div class="input-group">
					               
					          <input type="text" name="full_name"  class="form-control" value="<?= $full_name ?>" placeholder="Nhập tên khách hàng" >
					          </div>
      						</div>
      						  <div class="col-lg-2">
             
					              <div class="input-group">
					               
					          <input type="text" name="code_contract_disbursement"  class="form-control" value="<?= $code_contract_disbursement ?>" placeholder="Nhập mã hợp đồng" >
					          </div>
      						</div>
                  <div class="col-lg-2">
             
                        <div class="input-group">
                         
                    <input type="text" name="code_contract"  class="form-control" value="<?= $code_contract ?>" placeholder="Nhập mã phiếu ghi" >
                    </div>
                  </div>
                              <div class="col-lg-2">
								
								  <select id="province" class="form-control" name="store">
									  <option value=""><?= $this->lang->line('All')?></option>
									  <?php foreach ($storeData as $p) {?>
										  <option <?php echo $store == $p->id ? 'selected' : ''?> value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
									  <?php }?>
								  </select>
							  </div>

							  <div class="col-lg-2 text-right">
								  <button class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?php echo $this->lang->line('search')?></button>
							  </div>
                 
						  </div>
					  </div>
				  </form>
              </div>
            </div>
            <div class="col-xs-12">
              <br>
             <div class="row">
              <div class="col-lg-2">
              <select  class="form-control"   id="combox_check">
              <option value="">Chọn thao tác</option> 
             
              <option  value="thanhtoan">Thanh toán</option>
              
              </select>
            
          </div>
           <div class="col-lg-2">
           	  <a class="btn btn-info "
                 onclick="check_all_kt(this)" data-tab="1" >
               Chạy
            </a> 
           </div>
       </div>
        <div class="row">
           <div class="col-lg-4">
               <input type="text" id="code_nganluong"  class="form-control" value="" placeholder="Nhập mã ngân lượng: macode_000003494_1597640636" >
            
          </div>
        </div>
          <div class="group-tabs" style="width: 100%;">
           <ul class="nav nav-tabs" >
           
              <li  class="<?= (isset($tab) && $tab=='import_payment') ? 'active' : '' ?>"><a href="<?php echo base_url();?>/temporary_plan/list_thn?tab=import_payment" >Chạy lạiThanh toán</a></li>
             
          </ul>
          <div class="tab-content">
            
     <div role="tabpanel" class="tab-pane <?= (isset($tab) && $tab=='import_payment') ? 'active' : '' ?>" id="en">
              <br/>
               <?php  if(isset($tab) && $tab=='import_payment'){ ?>
               <div class="table-responsive">
                  <div ><?php echo $result_count;?></div>
                <table id="datatable-button5" class="table table-striped datatablebutton">
                  <thead>
                    <tr>
                      <th>#</th>
                       <th><input type="checkbox" class="selectall"/></th>
                      
                      <th>Mã HĐ</th>
                      <th>Mã Phiếu ghi</th>
                      <th>Tên khách hàng</th>
                      <th>Số tiền phải thanh toán</th>
                      <th>Hạn thanh toán</th>
                      <th>Phòng giao dịch</th>
                      <th>Trạng thái</th>
                      
                      <th>Chi tiết</th>
                    </tr>
                  </thead>

          <tbody>
          <?php
          if(!empty($temporary_planData)){
          foreach($temporary_planData as $key => $tran){
          
            ?>
              <tr >
                <td><?php echo $key + 1?></td>
                  <td>
                     <?php if (intval($tran->status_disbursement) == 3){ ?>
                    <input  type="checkbox" value="<?= $tran->_id->{'$oid'} ?>" class="checkbox_tran_kt" />
                  <?php } ?>
                  </td>
                 
                          <td id='<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : ''?>'>
             <?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?>
                    
                         <!--    <input type='text' class='txtedit' value='<?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?>' id='code_contract_disbursement-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : ''?>' /> -->
                          
                  </td>
              <td><?= !empty($tran->code_contract) ? $tran->code_contract : "" ?></td>

              <td><?= !empty($tran->customer_infor->customer_name) ? $tran->customer_infor->customer_name : "" ?></td>
              <td><?= !empty($tran->detail->total_paid) ? number_format($tran->detail->total_paid ,0 ,',' ,',') : ""?></td>
             
              <td><?= !empty($tran->detail->ngay_ky_tra) ?date('d/m/Y', intval( $tran->detail->ngay_ky_tra)) : "" ?></td>
                <td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
              
              <td><?= !empty($tran->status) ? contract_status($tran->status) : "" ;?></td>
              
                 <input type='hidden'  value='<?= !empty($tran->note) ? $tran->note : "" ?>' id='note-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : ''?>' />
               </td>
               <td> <a class="btn btn-info" target="_blank"  href="<?php echo base_url("accountant/view_v2?id=").$tran->_id->{'$oid'}?>" >
                    Chi tiết hợp đồng
                  </a> <br/>
                 
                </td>
   
  </tr>
<?php } } ?>
          </tbody>
              </table>
              <div class="pagination pagination-sm">
           <?php echo $pagination?>
         </div>
            </div>
              <?php } ?>
          </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<script src="<?php echo base_url();?>assets/js/temporary_plan/index.js"></script>
<script type="text/javascript">
   $(function(){
   $('.selectall').click(function(){
      if (this.checked) {
         $(".checkbox_tran_kt").prop("checked", true);
      } else {
         $(".checkbox_tran_kt").prop("checked", false);
      } 
   });
 
   $(".checkboxes").click(function(){
      var numberOfCheckboxes = $(".checkboxes").length;
      var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
      if(numberOfCheckboxes == numberOfCheckboxesChecked) {
         $(".selectall").prop("checked", true);
      } else {
         $(".selectall").prop("checked", false);
      }
   });
});
	$(document).ready(function(){



    // Show Input element
    $('.edit').click(function(){
    	var status= $(this).data('status');
    	console.log(status);
    	
        $('.txtedit').hide();
        $(this).next('.txtedit').show().focus();
        $(this).hide();
        
    });

    // Save data
    $(".txtedit").on('focusout',function(){
        
        // Get edit id, field name and value
        var id = this.id;
        var split_id = id.split("-");
        var field_name = split_id[0];
        var edit_id = split_id[1];
        var value = $(this).val();
        
        // Hide Input element
        $(this).hide();

        // Hide and Change Text of the container with input elmeent
        $(this).prev('.edit').show();
        $(this).prev('.edit').text(value);

        // Sending AJAX request
        $.ajax({
            url:  _url.base_url +'temporary_plan/update',
            type: 'post',
            data: { field:field_name, value:value, id:edit_id },
            success:function(response){
                console.log('Save successfully'); 
            }
        });
    
    });

});
</script>
<style type="text/css">
	.container{
    margin: 0 auto;
}


.edit{
    width: 100%;
    height: 25px;
}
.editMode{
    /*border: 1px solid black;*/
 
}

.txtedit{
    display: none;
    width: 99%;
    height: 30px;
}




table tr:nth-child(1) th{
    color:white;
 
}


</style>