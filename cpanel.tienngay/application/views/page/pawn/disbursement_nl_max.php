<!-- page content -->
<div class="right_col" role="main">
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Tải...</span>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>
            Xác nhận giải ngân
            <br>
            <small>
              <a href="#"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url("pawn/contract")?>">Quản lý hợp đồng</a> / <a href="#">Xác nhận giải ngân</a>
            </small>
          </h3>
        </div>

      </div>
    </div>
    <div class="col-xs-12">

      <div class="x_panel">
        <div class="x_title">
        <?php 
            $type_payout = !empty($contractInfor->receiver_infor->type_payout) ? $contractInfor->receiver_infor->type_payout : "" ;
             $amount_GIC=(isset($contractInfor->loan_infor->amount_GIC)) ? $contractInfor->loan_infor->amount_GIC : 0;
            // hình thức chuyển khoản tài khoản ngân hàng
            if($type_payout == 2){
        ?>
          <h2>Theo số tài khoản</h2>
        <?php }else if($type_payout == 3){?>
          <h2>Theo số thẻ ATM</h2>
        <?php }?>
          <div class="clearfix"></div>
        </div>

        <div class="x_content">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row">
                <div class="form-group col-xs-12">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Mã hợp đồng:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->code_contract_disbursement) ? $contractInfor->code_contract_disbursement : $contractInfor->code_contract ; ?>" readonly>
                  </div>
                </div>
                <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Tên người vay:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->customer_infor->customer_name) ? $contractInfor->customer_infor->customer_name : "" ; ?>" readonly>
                  </div>
                </div>
                <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Số tiền vay:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->receiver_infor->amount) ? number_format($contractInfor->receiver_infor->amount) : "" ?>" readonly>
                  </div>
                </div>
                <?php 
                        $amount_insurrance=0;
                        $type_amount_insurrance='';
                          if(isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance=="1")
                          {
                           $amount_insurrance=isset($contractInfor->loan_infor->amount_GIC) ? $contractInfor->loan_infor->amount_GIC : 0;
                            $type_amount_insurrance="GIC";
                          }else if(isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance=="2"){
                            $amount_insurrance=isset($contractInfor->loan_infor->amount_MIC) ? $contractInfor->loan_infor->amount_MIC : 0;
                            $type_amount_insurrance="MIC";
                          }
                        ?>
                 <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                   Loại bảo hiểm khoản vay:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= $type_amount_insurrance ?>" readonly>
                  </div>
                </div>
                 <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Phí bảo hiểm khoản vay:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($amount_insurrance) ? number_format($amount_insurrance) : "" ?>" readonly>
                  </div>
                </div>
                     <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Phí bảo hiểm xe:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->loan_infor->amount_GIC_easy) ? number_format($contractInfor->loan_infor->amount_GIC_easy) : "" ?>" readonly>
                  </div>
                </div>
                    <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Phí bảo hiểm phúc lộc thọ:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->loan_infor->amount_GIC_plt) ? number_format($contractInfor->loan_infor->amount_GIC_plt) : "" ?>" readonly>
                  </div>
                </div>
				  <div class="form-group col-xs-12 ">
					  <label class="control-label col-md-3 col-sm-3 col-xs-12">
						  Phí bảo hiểm TNDS:
					  </label>
					  <div class="col-md-9 col-sm-6 col-xs-12">
						  <input type="text" class="form-control"
								 value="<?= !empty($contractInfor->loan_infor->bao_hiem_tnds->price_tnds) ? number_format($contractInfor->loan_infor->bao_hiem_tnds->price_tnds) : "0" ?>"
								 readonly>
					  </div>
				  </div>
           <div class="form-group col-xs-12 ">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Phí bảo hiểm PTI - Vững Tâm An:
            </label>
            <div class="col-md-9 col-sm-6 col-xs-12">
              <input type="text" class="form-control"
                 value="<?= !empty($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta) ? number_format($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta) : "0" ?>"
                 readonly>
            </div>
          </div>
                 <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Số tiền giải ngân:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->loan_infor->amount_loan) ? number_format($contractInfor->loan_infor->amount_loan) : "" ?>" readonly>
                  </div>
                </div>
              </div>
            </div>


            <?php 
                // hình thức chuyển khoản tài khoản ngân hàng
                if($type_payout == 2){
            ?>
            <div class="col-xs-12 col-md-6">
              <div class="row">
                <div class="form-group col-xs-12">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" readonly>
                    Số tài khoản
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control bank_account" value="<?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?>" readonly>
                  </div>
                </div>
                <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Chủ tài khoản
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control bank_account_holder" value="<?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?>" readonly>
                  </div>
                </div>
                <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Ngân hàng
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->receiver_infor->bank_name) ? $contractInfor->receiver_infor->bank_name : "" ?>" readonly>
                  </div>
                </div>
                <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Chi nhánh
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control bank_branch" value="<?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?>" readonly>
                  </div>
                </div>
               <div class="col-xs-12 mb-3">
              <label class="control-label">
                Mã giao dịch ngân hàng
              </label>
              <input type="text" class="form-control" id="code_transaction_bank_disbursement" />
              <br>
            </div>
              
            <div class="col-xs-12 mb-3">
              <label class="control-label">
                Ngân hàng
              </label>
              <input type="text" class="form-control" id="bank_name" />
              <br>
            </div>

            <div class="col-xs-12 mb-3">
              <label class="control-label">
                Nội dung chuyển khoản
              </label>
              <textarea class="form-control description" id="content_transfer" rows="3" cols="80"></textarea>
              <br>
            </div>
             <div class="form-group col-xs-12 ">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Chặn bảo hiểm
                          </label>
				 <div class="col-md-6 col-sm-6 col-xs-12">
					 <div class="checkbox-inline ">
						 <?php if (!empty($user_nextpay) && $user_nextpay == 1) : ?>
							 <label><input name="chan_bao_hiem" value="1" type="checkbox" checked disabled>
								 &nbsp;
							 </label>
						 <?php else: ?>
							 <label><input name="chan_bao_hiem" value="1" type="checkbox">
								 &nbsp;
							 </label>
						 <?php endif; ?>
					 </div>

				 </div>
                      </div>
              </div>
            </div>
            <?php }else if($type_payout == 3){?>
            <div class="col-xs-12 col-md-6">
              <div class="row">
                <div class="form-group col-xs-12">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Số thẻ
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                  <input type="text" class="form-control atm_card_number" value="<?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?>" readonly>
                  </div>
                </div>
                <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Chủ thẻ
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                  
                    <input type="text" class="form-control atm_card_holder" value="<?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?>" readonly>
                  </div>
                </div>
                <div class="col-xs-12 mb-3">
              <label class="control-label">
                Mã giao dịch ngân hàng
              </label>
              <input type="text" class="form-control" id="code_transaction_bank_disbursement" />
              <br>
            </div>
              
            <div class="col-xs-12 mb-3">
              <label class="control-label">
                Ngân hàng
              </label>
              <input type="text" class="form-control" id="bank_name" />
              <br>
            </div>

            <div class="col-xs-12 mb-3">
              <label class="control-label">
                Nội dung chuyển khoản
              </label>
              <textarea class="form-control description" id="content_transfer" rows="3" cols="80"></textarea>
              <br>
            </div>
             <div class="form-group col-xs-12 ">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Chặn bảo hiểm
                          </label>
				 <div class="col-md-6 col-sm-6 col-xs-12">
					 <div class="checkbox-inline ">
						 <?php if (!empty($user_nextpay) && $user_nextpay == 1) : ?>
							 <label><input name="chan_bao_hiem" value="1" type="checkbox" checked disabled>
								 &nbsp;
							 </label>
						 <?php else: ?>
							 <label><input name="chan_bao_hiem" value="1" type="checkbox">
								 &nbsp;
							 </label>
						 <?php endif; ?>
					 </div>

				 </div>
                      </div>
              </div>
            </div>
            <?php }?>  

           
          </div>
        </div>
      </div>

    </div>
   
    <div class="col-xs-12">
      <div class="x_panel">
    
        <div class="x_content">
            <h2>Thông tin nhà đầu tư</h2>
          <div id="investor_PERSONAL" class="selectinvestor_action ">
            <hr style="margin-top:0">
            <div class="form-horizontal form-label-left" >

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nhà đầu tư</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" id='investor'>
                    <option value=''>Choose option</option>
                    <?php 
                      if(!empty($listInvestor)){
                        foreach($listInvestor as $key => $investor){
                            if(!in_array($investor->code,array('vimo','vfc'))){
                    ?>
                      <option  value='<?= !empty($investor->_id->{'$oid'}) ? $investor->_id->{'$oid'} :  "" ;?>' ><?= !empty($investor->name) ? $investor->name :  "" ;?></option>
                      <?php } } }?>
                  </select>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
<div class="col-xs-12">
      <div class="x_panel">
    
        <div class="x_content">
          <h2>Thông tin giải ngân</h2>
           <div id="investor_PERSONAL" class="selectinvestor_action ">
            <hr style="margin-top:0">
            <div class="form-horizontal form-label-left" >
              <?php $total_max=0;
              if( !empty($contractInfor->info_disbursement_max)){ ?>

              <?php
               $count_part_done=0;
               foreach ($contractInfor->info_disbursement_max as $key => $value) {
               $ck= count(explode("part_", $key));
               $total_max+=$value->money;
               if($ck==2)
               {
                if($value->status==2)
                {
                 $count_part_done++;
                }
                $part= explode("part_", $key);
               ?>
               <div class="form-group">
                <label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name"><span> Phần <?=$part[1] ?>. Số tiền giải ngân: <?= number_format($value->money) ?> </span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php if($value->status==1){ ?>
                    <?php if (isset($value->response_get_transaction_withdrawal_status_nl) && in_array('tpb-ke-toan', $groupRoles)) { ?>
                    <button class="btn btn-success disbursement" data-part="<?=$part[1]?>" data-money="<?= number_format($value->money)?>" onclick="show_popup_disbursement_part(this)"> Giải ngân phần <?=$part[1] ?></button>
                    <?= isset($value->response_get_transaction_withdrawal_status_nl->transaction_id) ? $value->response_get_transaction_withdrawal_status_nl->transaction_id : '' ?>
                    <?php } ?>
                <?php   }else{ ?>
                      <a href="#" class="btn btn-info btn-lg">
                      <span class="glyphicon glyphicon-ok-sign"></span> Complete 
                    </a>
                     <?= isset($value->response_get_transaction_withdrawal_status_nl->transaction_id) ? $value->response_get_transaction_withdrawal_status_nl->transaction_id : '' ?>
                   <?php  } ?>
                 </div>
              </div>
               <?php  }}} ?>
        </div>
      </div>
    </div>
  </div>
</div>
    <div class="col-xs-12 text-center">
        <!-- <button class="btn btn-success"> Từ chối</button> -->
        <a href="<?php echo base_url('pawn/contract')?>" class="btn btn-default" style="min-width:100px">Back</a>
     <?php if( isset($contractInfor->status_disbursement_max) && $contractInfor->status_disbursement_max==1 && $total_max==$contractInfor->loan_infor->amount_loan){ ?>
        <button class="btn btn-success disbursement" data-toggle="modal" data-target="#approve_disbursement_max"> Xác nhận</button>
        <?php }?>
   
        <button class="btn btn-success disbursement_disabled_max" style="display:none" disabled> Xác nhận</button>
        <input type="hidden" required name='contract_id' class="form-control " value="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>" >
        <input type="hidden" required name='code_contract' class="form-control " value="<?= !empty($contractInfor->code_contract) ? $contractInfor->code_contract : "" ?>" >
        <input type="hidden" required name='type_payout' class="form-control " value="<?= !empty($contractInfor->receiver_infor->type_payout) ? $contractInfor->receiver_infor->type_payout : "" ?>" >
        <input type="hidden" required name='amount' class="form-control " value="<?= !empty($contractInfor->receiver_infor->amount) ? $contractInfor->receiver_infor->amount : "" ?>" >
        <input type="hidden" required name='bank_id' class="form-control " value="<?= !empty($contractInfor->receiver_infor->bank_id) ? $contractInfor->receiver_infor->bank_id : "" ?>" >
    </div>
    <br>&nbsp;
  </div>
</div>
<?php 
  if(!empty($listInvestor)){
    foreach($listInvestor as $key => $investor){
        if($investor->code == 'vimo'){
?>
  <input type="hidden" required name='percent_interest_investor_vimo' value="<?= !empty($investor->percent_interest_investor) ? $investor->percent_interest_investor : "" ?>" >
  <?php }else if($investor->code == 'vfc'){?>
  <input type="hidden" required name='percent_interest_investor_vfc' value="<?= !empty($investor->percent_interest_investor) ? $investor->percent_interest_investor : "" ?>" >
  <?php } } }?>
<script>
$('.selectinvestor').click(function(event) {
  var thetarget = $(this).data('target');
  $('.selectinvestor_action').addClass('d-none');
  $('#' + thetarget).removeClass('d-none')
});
</script>
<!-- /page content -->
<!-- /page content -->
<div class="modal fade" id="approve_disbursement_part" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve">Xác nhận giải ngân</h5>
        <hr>
        <div class="form-group">
        <p>Bạn có chắc chắn muốn giải ngân lần: <span id="part"></span></p>
      
            Số tiền giải ngân: <span id="amount_part"></span>
            
           
        </div>
        </table>
        <p class="text-right">
         
          <button  class="btn btn-danger investors_disbursement_nl_max_submit">Xác nhận</button>
       
        </p>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="approve_disbursement_max" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve">Xác nhận giải ngân</h5>
        <hr>
        <div class="form-group">
        <p>Bạn có chắc chắn muốn giải ngân hợp đồng này ?</p>
           
        </div>
        </table>
        <p class="text-right">
          <button  class="btn btn-danger approve_investors_disbursement_nl_max_submit">Xác nhận</button>
        </p>
      </div>

    </div>
  </div>
</div>
<script>
    $(function () {
        'use strict';
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var checkin = $('#timeCheckIn').datepicker({
            onRender: function (date) {
              return  (date.valueOf() < (nowTemp.valueOf()-60*60*24*4*1000) ||  date.valueOf() > now.valueOf()) ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
            checkin.hide();
        }).data('datepicker');
        var checkin1 = $('#timeCheckIn1').datepicker({
            onRender: function (date) {
              return  (date.valueOf() < (nowTemp.valueOf()-60*60*24*4*1000) ||  date.valueOf() > now.valueOf()) ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
            checkin1.hide();
        }).data('datepicker');
    });
</script>

<script src="<?php echo base_url();?>assets/js/pawn/contract.js?rev=<?php echo time();?>"></script>
<script src="<?php echo base_url();?>assets/datepicker/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/js/bootstrap-datepicker.js"></script>
