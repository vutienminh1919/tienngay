<!-- page content -->
<div class="right_col" role="main">
  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>Xác nhận giải ngân</h3>
      </div>

    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <div class="x_content">
        <div class="row">
          <div class="col-xs-6">


            <div class="row">
              <div class="col-xs-4 mb-3">
                Mã hợp đồng:
              </div>
              <div class="col-xs-8 mb-3 text-right">
                <strong><?= !empty($contractInfor->code_contract) ? $contractInfor->code_contract : "" ?></strong>
              </div>
              <div class="col-xs-4 mb-3">
                Tên người vay:
              </div>
              <div class="col-xs-8 mb-3 text-right">
                <strong><?= !empty($contractInfor->customer_infor->customer_name) ? $contractInfor->customer_infor->customer_name : "" ?></strong>
              </div>
              <div class="col-xs-4 mb-3">
                Số tiền:
              </div>
              <div class="col-xs-8 mb-3 text-right">
                <strong><?= !empty($contractInfor->receiver_infor->amount) ? number_format($contractInfor->receiver_infor->amount) : "" ?></strong>
              </div>

            <?php 
                $type_payout = !empty($contractInfor->receiver_infor->type_payout) ? $contractInfor->receiver_infor->type_payout : "" ;
                // hình thức chuyển khoản tài khoản ngân hàng
                if($type_payout == 2){
            ?>
                <div class="col-xs-4 mb-3">
                    Số tài khoản:
                </div>
                <div class="col-xs-8 mb-3 text-right">
                    <strong class="bank_account"><?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?></strong>
                </div>
                <div class="col-xs-4 mb-3">
                    Chủ tài khoản:
                </div>
                <div class="col-xs-8 mb-3 text-right">
                    <strong class="bank_account_holder"><?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?></strong>
                </div>
                <div class="col-xs-4 mb-3">
                    Ngân hàng:
                </div>
                <div class="col-xs-8 text-right">
                    <strong ><?= !empty($contractInfor->receiver_infor->bank_name) ? $contractInfor->receiver_infor->bank_name : "" ?></strong>
                </div>
                <div class="col-xs-4 ">
                    Chi nhánh:
                </div>
                <div class="col-xs-8  text-right">
                    <strong class="bank_branch"><?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?></strong>
                </div>
                <div class="col-xs-6">
                    <div class="radio">
                    Hình thức:
                    </div>
                </div>
                <div class="col-xs-3 text-right">
                    <div class="radio">
                    <label><input type="radio" value="2" name="type_payout_bank" checked>VIMOCK</label>
                    </div>
                </div>
                <div class="col-xs-3 text-right">
                    <div class="radio">
                    <label><input type="radio" value="10" name="type_payout_bank">VIMOCK247</label>
                    </div>
                </div>

            <?php }else if($type_payout == 3){?>
                <div class="col-xs-4 mb-3">
                    Chủ thẻ:
                </div>
                <div class="col-xs-8 mb-3 text-right">
                    <strong class='atm_card_holder'><?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?></strong>
                </div>
                <div class="col-xs-4 mb-3">
                    Số thẻ:
                </div>
                <div class="col-xs-8 mb-3 text-right">
                    <strong class='atm_card_number'><?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?></strong>
                </div>
                <div class="col-xs-4 mb-3">
                    Phương thức giải ngân:
                </div>
                <div class="col-xs-8 mb-3 text-right">
                    <strong>VIMOATM</strong>
                </div>
                <?php } ?>
                <div class="col-xs-4 mb-3">
              
                Nội dung chuyển khoản:
                </div>
                <!-- <br>&nbsp; -->
                <div class="col-xs-8 mb-3 text-right">
                <input type="text" required name="description" class="form-control " >
                <!-- <textarea class="form-control" rows="8" cols="80" ></textarea> -->
                <br>
              </div>

              <div class="col-xs-12 text-center">
                <a href="<?php echo  base_url("pawn/contract")?>" class="btn btn-default" style="min-width:125px">Back</a>
                <button class="btn btn-primary" style="min-width:125px"  data-toggle="modal" data-target="#approve_disbursement">Xác nhận</button>
                <input type="hidden" required name='code_contract' class="form-control " value="<?= !empty($contractInfor->code_contract) ? $contractInfor->code_contract : "" ?>" >
                <input type="hidden" required name='type_payout' class="form-control " value="<?= !empty($type_payout) ? $type_payout : "" ?>" >
                <input type="hidden" required name='amount' class="form-control " value="<?= !empty($contractInfor->receiver_infor->amount) ? $contractInfor->receiver_infor->amount : "" ?>" >
                <input type="hidden" required name='bank_id' class="form-control " value="<?= !empty($contractInfor->receiver_infor->bank_id) ? $contractInfor->receiver_infor->bank_id : "" ?>" >
              </div>


            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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
        <p><?= $this->lang->line('Confirm_Disbursement1')?></p>
            <!-- <label>Lý do:</label>
            <textarea class="form-control approve_note" rows="5" ></textarea>
            <input type="hidden"   class="form-control status_approve">
            <input type="hidden"   class="form-control contract_id"> -->
        </div>
        </table>
        <p class="text-right">
          <button  class="btn btn-danger approve_disbursement_submit">Xác nhận</button>
        </p>
      </div>

    </div>
  </div>
</div>
<script src="<?php echo base_url();?>assets/js/pawn/contract.js"></script>
