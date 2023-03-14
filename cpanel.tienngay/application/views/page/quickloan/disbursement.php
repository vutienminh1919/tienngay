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
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->code_contract) ? $contractInfor->code_contract : "" ; ?>" readonly>
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
                 <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Phí bảo hiểm VAT:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->loan_infor->amount_GIC) ? number_format($contractInfor->loan_infor->amount_GIC) : "" ?>" readonly>
                  </div>
                </div>
                 <div class="form-group col-xs-12 ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Số tiền giải ngân:
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?= !empty($contractInfor->loan_infor->amount_loan) ? number_format($contractInfor->loan_infor->amount_money-$amount_GIC) : "" ?>" readonly>
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

              </div>
            </div>
            <?php }?>  

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
          </div>
        </div>
      </div>

    </div>

    <div class="col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <h2 class="m-0">Nhà đầu tư</h2>
            </div>
            <div class="col-xs-12 col-md-6 text-right">
              <label class="radio-inline selectinvestor" data-target="investor_CTYCK"><input type="radio" value='1' name="investor_selected" checked>
                VFC
              </label>
              <label class="radio-inline selectinvestor" data-target="investor_VIMO"><input type="radio" value='2' name="investor_selected">
                VIMO
              </label>
              <label class="radio-inline selectinvestor" data-target="investor_PERSONAL"><input type="radio" value='3' name="investor_selected" >
                Cá nhân
              </label>
            </div>
          </div>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div id="investor_CTYCK" class="selectinvestor_action">
              
               <hr style="margin-top:0">
              <div class="form-horizontal form-label-left" >

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ngày giải ngân</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id='timeCheckIn' class="form-control " value="<?php echo date("m/d/Y")?>" />
                  </div>
                </div>


              </div>
          </div>
          <div id="investor_VIMO" class="selectinvestor_action d-none">
            <hr style="margin-top:0">
            <div class="form-horizontal form-label-left" >

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hình thức</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control type_payout_bank">
                    <?php 
                        // hình thức chuyển khoản tài khoản ngân hàng
                        if($type_payout == 2){
                    ?>
                        <option value="2" >VIMOCK</option>
                        <option  value="10" >VIMOCK247</option>
                    <?php }else if($type_payout == 3){?>
                        <option value="3"  >VIMOATM</option>
                    <?php }?>  
                  </select>
                </div>
              </div>


            </div>
          </div>
          <div id="investor_PERSONAL" class="selectinvestor_action d-none">
            <hr style="margin-top:0">
            <div class="form-horizontal form-label-left" >

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ngày giải ngân</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id='timeCheckIn1' class="form-control " value="<?php echo date("m/d/Y")?>"  />
                </div>
              </div>

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

    <div class="col-xs-12 text-center">
        <!-- <button class="btn btn-success"> Từ chối</button> -->
        <a href="<?php echo base_url('pawn/contract')?>" class="btn btn-default" style="min-width:100px">Back</a>
        <button class="btn btn-success"  data-toggle="modal" data-target="#approve_disbursement"> Xác nhận</button>
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
<div class="modal fade" id="approve_disbursement" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
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
            <!-- <label>Lý do:</label>
            <textarea class="form-control approve_note" rows="5" ></textarea>
            <input type="hidden"   class="form-control status_approve">
            <input type="hidden"   class="form-control contract_id"> -->
        </div>
        </table>
        <p class="text-right">
          <button  class="btn btn-danger investors_disbursement_submit">Xác nhận</button>
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

<script src="<?php echo base_url();?>assets/js/pawn/contract.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/js/bootstrap-datepicker.js"></script>
<!-- <script>
    $(function () {
        'use strict';
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#timeCheckIn').datepicker({
            onRender: function (date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('#timeCheckOut')[0].focus();
        }).data('datepicker');
        var checkout = $('#timeCheckOut').datepicker({
            onRender: function (date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            checkout.hide();
        }).data('datepicker');
    });
</script> -->