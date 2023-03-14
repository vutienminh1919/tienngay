<!-- page content -->
<div class="right_col" role="main">
    <div class="row top_tiles">
        <div class="col-xs-12">
            <div class="page-title">
                <div class="title_left">
                    <h3><?= $this->lang->line('Transaction_details')?>
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('disbursementAccounting')?>"><?php echo $this->lang->line('Disbursement_management')?></a> / <a href="#"><?php echo $this->lang->line('Transaction_details')?></a>
                        </small>
                    </h3>
                    <div class="alert alert-danger alert-result" id="div_error" style="display:none; color:white;"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12  col-lg-12">
            <div class="x_panel ">
                <div class="x_content ">
                    <div class="form-horizontal form-label-left">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <!-- Thông tin khoản vay-->
                                <div class="x_title">
                                    <strong><i class="fa fa-money" aria-hidden="true"></i> <?= $this->lang->line('Loan_information')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('Order_code')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">

                                        <input type="text"  name="order_code" class="form-control" disabled  value="<?= !empty($disbursement->order_code) ? $disbursement->order_code : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('Contract_code')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">

                                        <input type="text" name="code_contract" class="form-control" disabled  value="<?= !empty($disbursement->code_contract) ? $disbursement->code_contract : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('Borrower')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">

                                        <input type="text"  name="customer_name" class="form-control" disabled value="<?= !empty($disbursement->customer_name) ? $disbursement->customer_name : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <?= $this->lang->line('store')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"   name="story_name" class="form-control" disabled value="<?= !empty($disbursement->story_name) ? $disbursement->story_name : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('Disbursement_date')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" s name="disbursement_at" class="form-control" disabled value="<?= !empty($disbursement->disbursement_at) ? date('m/d/Y', $disbursement->disbursement_at) : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('Date_due')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"   name="data_expire" class="form-control" disabled value="<?= !empty($disbursement->data_expire) ? date('m/d/Y', $disbursement->data_expire) : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('formality1')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                    <input type="text"   name="type_payout1" class="form-control" disabled value="<?= !empty($disbursement->type_payout) ? $disbursement->type_payout : "" ?>">
                                    <?php
                                        $type_payout = !empty($disbursement->type_payout) ? $disbursement->type_payout : "";
                                            if($type_payout == "VIMOCK"){
                                                $type_payout = 2;
                                            }elseif($type_payout == "VIMOCKATM"){
                                                $type_payout = 3;
                                            }elseif($type_payout == "VIMOCK247"){
                                                $type_payout = 10;
                                            }
                                    ?>
                                        <input type="hidden"   name="type_payout" class="form-control" disabled value="<?= !empty($type_payout) ? $type_payout : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('atm_card_holder')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="atm_card_holder" class="form-control" disabled value="<?= !empty($disbursement->atm_card_holder) ? $disbursement->atm_card_holder : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('ATM_card_number')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  name="atm_card_number" class="form-control" disabled value="<?= !empty($disbursement->atm_card_number) ? $disbursement->atm_card_number : "" ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('Account_holder1')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  name="bank_account_holder" class="form-control" disabled value="<?= !empty($disbursement->bank_account_holder) ? $disbursement->bank_account_holder : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                  <?= $this->lang->line('Account_number')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="bank_account" class="form-control" disabled value="<?= !empty($disbursement->bank_account) ? $disbursement->bank_account : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('Bank')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="bank" class="form-control" disabled value="<?= !empty($disbursement->bank) ? $disbursement->bank : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('Bank_code')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="bank_id" class="form-control" disabled value="<?= !empty($disbursement->bank_id) ? $disbursement->bank_id : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('Branch')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  name="bank_branch" class="form-control" disabled value="<?= !empty($disbursement->bank_branch) ? $disbursement->bank_branch : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('Amount_money1')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="hidden"  name="amount" class="form-control" disabled value="<?= !empty($disbursement->amount) ? $disbursement->amount : "" ?>">
                                        <input type="text"  name="amount1" class="form-control" disabled value="<?= !empty($disbursement->amount) ? number_format($disbursement->amount) : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('content')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  name="description" class="form-control" disabled value="<?= !empty($disbursement->description) ? $disbursement->description : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('status')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                        $status = !empty($disbursement->status) ?  $disbursement->status : "";
                                        if($status == "new"){
                                            $status = "Mới";
                                        }elseif($status == "create_withdrawal_success"){
                                            $status = "Đã tạo lệnh giải ngân";
                                        }elseif($status == "success"){
                                            $status = "Giải ngân thành công";
                                        }elseif($status == "failed"){
                                            $status = "Giải ngân thất bại";
                                        }elseif($status == "cancel"){
                                            $status = "Giao dịch bị hủy";
                                        }
                                        ?>
                                        <input type="text"  name="status" class="form-control" disabled value="<?= !empty($status) ? $status : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       <?= $this->lang->line('created_by')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="import_by" class="form-control" disabled value="<?= !empty($disbursement->import_by) ? $disbursement->import_by : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('create_at')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  name="import_at" class="form-control" disabled value="<?= !empty($disbursement->import_at) ? date('m/d/Y', $disbursement->import_at) : "" ?>">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('Disbursement_by')?>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  name="disbursement_by" class="form-control" disabled value="<?= !empty($disbursement->disbursement_by) ? $disbursement->disbursement_by : "" ?>">
                                    </div>
                                </div>


                                <?php
                                     $status = !empty($disbursement->status) ?  $disbursement->status : "";
                                     if($status == "new"){
                                ?>
                                 <input type="hidden"  name="disbursementId" class="form-control" disabled value="<?= !empty($disbursement->_id->{'$oid'}) ? $disbursement->_id->{'$oid'} : "" ?>">
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"></label>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#confirmDisbursement"><?= $this->lang->line('Disbursement')?></button>
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#hideDisbursement"><?= $this->lang->line('Hidden')?></button>

                                    </div>

                                </div>

                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal HTML -->
<div id="confirmDisbursement" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
                <div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title"><?= $this->lang->line('Confirm_Disbursement')?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p> <?= $this->lang->line('Confirm_Disbursement1')?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal"><?= $this->lang->line('Cancel')?></button>
        	    <button type="button" class="btn btn-success disbursementByVimo"><?= $this->lang->line('ok')?></button>
			</div>
		</div>
	</div>
</div>
<!-- Modal HTML -->
<div id="hideDisbursement" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
                <div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title"><?= $this->lang->line('Confirm_Hide_Transactions')?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p><?= $this->lang->line('Confirm_Hide_Transactions1')?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal"><?= $this->lang->line('Cancel')?></button>
        	    <button type="button" class="btn btn-success hidedisbursement"><?= $this->lang->line('ok')?></button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url();?>assets/js/disbursement_accounting/index.js"></script>
